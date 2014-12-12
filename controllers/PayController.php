<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Request;
use yii\web\Cookie;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use app\models\User_payment;
use app\models\Setting;

use PayPal\Api\Details;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;


class PayController extends Controller
{
    public $enableCsrfValidation = false;
    public static $currency = [ 1=>'EUR', 2=>'USD' , 3 => 'GBP', 4 => 'RUB'];
    public static $currency_rate = [ 1=>1, 2=>1.4 , 3 => 2, 4 => 50 ];
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions'=>['ipn'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions'=>['paypal','succecc_paypal'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                        ],
                ],
            ];
    }
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPaypal( $id )
	{
            $model = User_payment::findOne($id);
   //         Yii::$app->getResponse()->getCookies()->add( new Cookie([ 'name' => 'credit', 'value' => $model->credit,]));
    
            return $this->render('paypal', ['model' => $model, ]);
	}


    public function actionSuccecc_paypal()
    {
        return $this->render('paypal_success');
    }

    public function actionCancel_paypal()
    {
        var_dump($_REQUEST);
        return $this->render('paypal_cancel');
    }

	public function actionIpn()
	{
        $SandboxFlag = true;
        //$url_pay = ( $SandboxFlag ) ? 'https://www.sandbox.paypal.com' : 'https://www.paypal.com/'; //'https://www.paypal.com/cgi-bin/webscr'
        $url_pay = ( $SandboxFlag ) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
// e-mail продавца
        $paypalemail  = ( $SandboxFlag ) ? "RabotaSurv-de@gmail.com" : "RabotaSurv-facilitator@gmail.com";
        // e-mail client RabotaSurv-buyer@gmail.com
        $currency     =  "EUR";// 'RUB';             // валюта
        $paypalmode = 'sandbox'; //Sandbox for testing or empty '';
        if ($_POST) {
            $req = 'cmd=' . urlencode('_notify-validate');
            foreach ($_POST as $key => $value) {
                $value = urlencode(stripslashes($value));
                $req .= "&$key=$value";
            }
            Yii::info($req, 'userMessage');
            if($paypalmode=='sandbox')
            {
                $paypalmode     =   '.sandbox';
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$paypalmode.'.sandbox.paypal.com'));
            $res = curl_exec($ch);
            curl_close($ch);

            if (strcmp ($res, "VERIFIED") == 0)
            {

             
             switch ($_POST['payment_status']) {
                // Платеж не прошел
                case 'failed':  throw new BadRequestHttpException('Не пройдена валидация платежа на стороне PayPal');
                 // Платеж отменен продавцом
                case 'denied': throw new BadRequestHttpException('Платеж отменен продавцом');
                // Деньги были возвращены покупателю
                case 'refunded':  throw new BadRequestHttpException('Деньги были возвращены покупателю');
                // Платеж успешно выполнен, оказываем услугу
                case 'completed': break;
            }
             if ($_POST['receiver_email'] != $paypalemail || $_POST["txn_type"] != "web_accept") {
                 Yii::info('You should not be here', 'userMessage');
                 throw new BadRequestHttpException('You should not be here ...');
             }

             $user_payment_id = intval($_POST['item_number']);
             $user_payment = User_payment::findOne($user_payment_id);
             $adminemail = Yii::$app->params['adminEmail'];
             if( !$user_payment ){ // не найден такой платеж
                mail($adminemail, "IPN error", "Unable to restore cart contents\r\nCart ID: ".
                    $user_payment_id ."\r\nTransaction ID: ".$_POST["txn_id"]);
                 Yii::info('Failed Payment', 'userMessage');
                 throw new BadRequestHttpException('I cannot find N payment ... Please contact '.$adminemail);
             }
             
//    убедимся в том, что эта транзакция не   была обработана ранее 
             if(!is_null($user_payment->txn_id) ) {
                 Yii::info('Yet pay ... txn_id='.$user_payment->txn_id, 'userMessage');
                 BadRequestHttpException("Yet pay ... Please contact ".$adminemail);
             }

                Yii::info('step1', 'userMessage');
//     проверяем сумму платежа
             if( ($user_payment->credit != $_POST['mc_gross']) || ($_POST["mc_currency"] != $currency))
             {
                mail($adminemail, "IPN error", "Payment amount mismatch\r\nCart ID: "
                 . $user_payment->id."\r\nTransaction ID: ".$_POST["txn_id"]);
                 Yii::info('Failed Sum', 'userMessage');
                 throw new BadRequestHttpException("Out of money? Please contact ".$adminemail);
             }
                Yii::info('step2', 'userMessage');
//  проверки завершены.
            $old = User_payment::findBySql('select u.* from {{user_payment}} as u where u.user_id = '.$user_payment->user_id
                    .' and u.txn_id IS NOT NULL order by u.id desc ')->one();
//                 var_dump($old);                  exit();
            $user_payment->credit_sum = (( $old) ? $old->credit_sum : 0) + $user_payment->credit;
                Yii::info('step3', 'userMessage');

//            $user_payment->txn_id = $_POST["txn_id"];
            $user_payment->txn_id = 5;
            $user_payment->save();
                Yii::info('step4', 'userMessage');

                //увеличение кредитов
            $user_credit = Setting::find()->where(['user_id' => $user_payment->user_id])->one();
            $user_credit->credit = $user_credit->credit + $user_payment->credit;
            $user_credit->save();
 
            Yii::info('Validated', 'userMessage');
            }

            echo 'success';
        }
           // return $this->redirect(['invoice/index']);
//  mail($adminemail, "New order", "New order\r\nOrder ID: ". $order_id."\r\nTransaction ID: "
//    .$_POST["txn_id"]);*/
             
  /* 
    сообщаем, что заказ принят, благодарим за покупку и 
    предлагаем купить еще что-нибудь */           
	}
	
	
	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
            $dataProvider = new ActiveDataProvider([
                'query' => Service::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            if( yii::$app->user->identity->role==='superadmin' ) return $this->render('index_adm',array( 'dataProvider'=>$dataProvider, ));
            else  return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
	}
*/
}
