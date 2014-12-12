<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Request;
use yii\web\Cookie;
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
        //    var_dump($_POST);           
            // payment_success.php
             $paypalemail = "my@email.com";     // e-mail продавца
             $adminemail  = "admin@email.com";  // e-mail  администратора
             $currency    = 'RUB';//"EUR";              // валюта

             /********
             запрашиваем подтверждение транзакции
             ********/
      /*       $postdata="";
             foreach ($_POST as $key=>$value) $postdata.=$key."=".urlencode($value)."&";
             $postdata .= "cmd=_notify-validate"; 
             $curl = curl_init("https://www.paypal.com/cgi-bin/webscr");
             curl_setopt ($curl, CURLOPT_HEADER, 0); 
             curl_setopt ($curl, CURLOPT_POST, 1);
             curl_setopt ($curl, CURLOPT_POSTFIELDS, $postdata);
             curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); 
             curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
             curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 1);
             $response = curl_exec ($curl);
             curl_close ($curl);
             if ($response != "VERIFIED") die("You should not do that ..."); */

       /*      
             switch ($_REQUEST['payment_status']) {
                // Платеж не прошел
                case 'failed': echo 'Платеж не прошел';   return $this->redirect(['invoise/index']);
                // Платеж отменен продавцом
                case 'denied': echo 'Платеж отменен продавцом';   return $this->redirect(['invoise/index']);
                // Деньги были возвращены покупателю
                case 'refunded':  echo 'Деньги были возвращены покупателю';   return $this->redirect(['invoise/index']);
                // Платеж успешно выполнен, оказываем услугу
                case 'completed': break;
            }*/
             /********
             проверяем получателя платежа и тип транзакции, и выходим, если не наш аккаунт
             в $paypalemail - наш  primary e-mail, поэтому проверяем receiver_email
             ********/
      /*       if ($_REQUEST['receiver_email'] != $paypalemail || $_REQUEST["txn_type"] != "web_accept")
                 die("You should not be here ...");
*/
             $user_payment_id = intval($_REQUEST['item_number']);
             $user_payment = User_payment::findOne($user_payment_id);
             if( !$user_payment ){ // не найден такой платеж
                mail($adminemail, "IPN error", "Unable to restore cart contents\r\nCart ID: ".
                    $cart_id."\r\nTransaction ID: ".$_POST["txn_id"]);
                die("I cannot find N payment ... Please contact ".$adminemail);                  
             }
             
//    убедимся в том, что эта транзакция не   была обработана ранее 
       /*      if( $user_payment->txn_id ) die("Yet pay ... Please contact ".$adminemail);
             
             if( $user_payment->user_id != Yii::$app->user->id){
                 die("Это не ваша платежка ... Please contact ".$adminemail);  
             }
         
//     проверяем сумму платежа             
             if( $user_payment->price != floatval($_REQUEST['mc_gros']) 
                     || $_REQUEST["mc_currency"] != PayController::$currency[$user_payment->$currency_id])
             {
               mail($adminemail, "IPN error", "Payment amount mismatch\r\nCart ID: "
                 . $user_payment->id."\r\nTransaction ID: ".$_REQUEST["txn_id"]);
               die("Out of money? Please contact ".$adminemail);
             } */  
//  проверки завершены. 
            $old = User_payment::findBySql('select u.* from {{user_payment}} as u where u.user_id = '.$user_payment->user_id
                    .' and u.txn_id IS NOT NULL order by u.id desc ')->one();
//                 var_dump($old);                  exit();
            $user_payment->credit_sum = (( $old) ? $old->credit_sum : 0) + $user_payment->credit;
//            $user_payment->txn_id = $_POST["txn_id"];
            $user_payment->txn_id = 5;
            $user_payment->save();
   //увеличение кредитов
            $user_credit = Setting::find()->where(['user_id' => $user_payment->user_id])->one();
            $user_credit->credit = $user_credit->credit + $user_payment->credit;
            $user_credit->save();

             return $this->redirect(['invoice/index']);
//  mail($adminemail, "New order", "New order\r\nOrder ID: ". $order_id."\r\nTransaction ID: "
//    .$_POST["txn_id"]);*/
             
  /* 
    сообщаем, что заказ принят, благодарим за покупку и 
    предлагаем купить еще что-нибудь */              exit(); 
	}

	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
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

	public function loadModel($id)
	{
            $model=Service::find()->where(['id' => $id])->one();
            
            if($model===null) throw new CHttpException(404,'The requested page does not exist.');
            
            return $model;
	}

}
