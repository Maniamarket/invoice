<?php
namespace app\controllers;

use Yii;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Payment;
use yii\helpers\Url;
use yii\web\Request;
use PayPal\Api\Details;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
//use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use app\models\PPIPNMessage;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

class PaymentController extends Controller
{
    public $enableCsrfValidation = false;

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
                        'actions'=>['index'],
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
	public function actionCreate()
	{
		$model=new Payment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                 if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['index']);
                 } else 
                        return $this->render('create', ['model' => $model, ]);
	}

	
	public function actionUpdate($id)
	{
                if( Yii::$app->request->isAjax)
                {      
                    $model=$this->loadModel($id);
                    $post = Yii::$app->request->post();
                    $model->name= $post['name'];
                    $model->save();
                    echo $model->name;
                }
	}
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

    public function actionTest_success()
    {
        $qp = Yii::$app->request->queryParams;
        $payerId = $qp['PayerID'];
        $apiContext = new ApiContext(new OAuthTokenCredential('AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd','EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX'));
        $apiContext->setConfig([ 'mode' => 'sandbox']);
        $payment = new Payment();
//        $payment->setId($qp['paymentId']);
        $payment = Payment::get($qp['paymentId'], $apiContext);
        $paymentExecution= new PaymentExecution();
        $paymentExecution->setPayerId($payerId);
        $payment->execute($paymentExecution, $apiContext);
        var_dump($payment);
    }

    public function actionIpn()
    {
//        Yii::info('Метод сработал', 'userMessage');
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
                $transaction_id = $_POST['txn_id'];
                $payerid = $_POST['payer_id'];
                $firstname = $_POST['first_name'];
                $lastname = $_POST['last_name'];
                $payeremail = $_POST['payer_email'];
                $paymentdate = $_POST['payment_date'];
                $paymentstatus = $_POST['payment_status'];
                $mdate= date('Y-m-d h:i:s',strtotime($paymentdate));
                $otherstuff = json_encode($_POST);
                Yii::info('Validated', 'userMessage');
            }
        }
 //       $this->setHeader(200);
        echo 'success';
/*        $ipn = new PPIPNMessage(array(['mode' => 'sandbox']),null,[]);
        if (!$ipn->validate()) {
            throw new \Exception('Не пройдена валидация платежа на стороне PayPal');
        }*/
// $_GET['txn_id']          Ид платежа PayPal
// $_GET['mc_gross']        Сумма платежа
// $_GET['mc_currency']     Валюта платежа
// $_GET['payer_email']     Еmail плательщика
// $_GET['item_number1']    Ид первого товара
// $_GET['payment_status']  Статус заказа
// $_GET['receiver_email']  Email получателя
        if (isset($_GET['payment_status'])) {
            switch ($_GET['payment_status']) {
                // Платеж успешно выполнен, оказываем услугу
                case 'completed': echo 'completed'; break;
                // Платеж не прошел
                case 'failed': echo 'failed'; break;
                // Платеж отменен продавцом
                case 'denied': echo 'denied'; break;
                // Деньги были возвращены покупателю
                case 'refunded': echo 'refunded'; break;
            }
        }
    }

    public function actionTest()
    {
        if (!isset($_GET['classic'])) {
            $resultUrl = Url::toRoute(['payment/test_success'],true);
    //        Yii::$app->paypal->payDemo();

            if (isset($_REQUEST['amount'])) {
                $price = $_REQUEST['amount'];
            $apiContext = new ApiContext(new OAuthTokenCredential('AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd','EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX'));

            $sdkConfig = array(
                "mode" => "sandbox"
            );

            $apiContext->setConfig($sdkConfig);

            $payer = new Payer();
            $payer->setPaymentMethod('paypal');
            $amount = new Amount();
            $amount->setCurrency('RUB');
//            $amount->setTotal('10');
            $amount->setTotal($price);
//                var_dump($amount); exit;
    //        $amount->
            $item1 = new Item();
            $item1->setName('Buy Credits')->setCurrency('RUB')->setQuantity(1)->setPrice($price);
    // Ид товара/услуги на вашей стороне
            $item1->setSku('1000');
            $itemList = new ItemList();
            $itemList->setItems(array($item1));
            $transaction = new Transaction();
            $transaction->setAmount($amount);
            $transaction->setDescription('Payment to UnitPay');
            $transaction->setItemList($itemList);
            $payment = new Payment();
            $payment->setIntent('sale');
            $payment->setPayer($payer);
            $payment->setTransactions(array($transaction));
            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($resultUrl);
            $redirectUrls->setCancelUrl($resultUrl);
            $payment->setRedirectUrls($redirectUrls);
            $payment->create($apiContext);

     //       var_dump($payment);

            $payment->getId();
            $links = $payment->getLinks();

    //        var_dump($links);
            foreach ($links as $link) {
                if ($link->getMethod() == 'REDIRECT') {
    //                echo $link->getHref();

     //               header('location:'.$link->getHref());
                    return $this->redirect($link->getHref());
                }
            }
            }
            else {
                return $this->render('paypal', ['classic'=>0]);
            }
        }
        return $this->render('paypal',['classic'=>1]);

//        $cred = new OAuthTokenCredential("AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd","EL1tVxAjhT7cJimnz5-Nsx9k2reTKSVfErNQF-CmrwJgxRtylkGTKlU4RvrX", $sdkConfig);
        //        $cred = new OAuthTokenCredential("AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd","ECRaAxBG9fgaKCBSIDQ88MwdGYl7fT8iu-NlbiN-jbr3lKf8NoMWwuPW8KeT", $sdkConfig);
 //       echo $cred;
/*        $cred = "AQkquBDf1zctJOWGKWUEtKXm6qVhueUEMvXO_-MCI4DQQ4-LWvkDLIN2fGsd";
        $apiContext = new ApiContext($cred, 'Request' . time());
        $apiContext->setConfig($sdkConfig);

        $payer = new Payer();
        $payer->setPayment_method("paypal");

        $amount = new Amount();
        $amount->setCurrency("USD");
        $amount->setTotal("12");

        $transaction = new Transaction();
        $transaction->setDescription("creating a payment");
        $transaction->setAmount($amount);

//        $baseUrl = getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturn_url("https://devtools-paypal.com/guide/pay_paypal/php?success=true");
        $redirectUrls->setCancel_url("https://devtools-paypal.com/guide/pay_paypal/php?cancel=true");

        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setRedirect_urls($redirectUrls);
        $payment->setTransactions(array($transaction));

        $payment->create($apiContext);*/
    }
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $dataProvider = new ActiveDataProvider([
                'query' => Payment::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            if( yii::$app->user->identity->role==='superadmin' ) return $this->render('index_adm',array( 'dataProvider'=>$dataProvider, ));
            else  return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
	}

	public function loadModel($id)
	{
            $model=Payment::find()->where(['id' => $id])->one();
            
            if($model===null) throw new CHttpException(404,'The requested page does not exist.');
            
            return $model;
	}

}
