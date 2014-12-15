<?php

namespace app\controllers;

use Yii;
use app\models\Paymentbanktrans;
use app\models\Transactionbanktrans;
use app\models\Setting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PaymentbanktransController implements the CRUD actions for Paymentbanktrans model.
 */
class PaymentbanktransController extends Controller {

    public function behaviors() {
	return [
	    'verbs' => [
		'class' => VerbFilter::className(),
		'actions' => [
		    'delete' => ['post'],
		],
	    ],
	];
    }

    /**
     * Lists all Paymentbanktrans models.
     * @return mixed
     */
    public function actionIndex() {
	//$this->()
	//$query = Paymentbanktrans::find()->where(['user_id' => Yii::$app->user->id])->one();
	$dataProvider = new ActiveDataProvider([
	    'query' => Paymentbanktrans::find()
		->select('payment_bt.id,username,message,file,payment_bt.status, date,sum')
		->join('inner join', 'user', 'user.id = payment_bt.user_id')
		->where(['user_id' => Yii::$app->user->id])
	]);
	
	 if(Yii::$app->user->identity->role==='superadmin' ){
	     return $this->render('index_adm', [
		    'dataProvider' => $dataProvider,
		    'creditPath' => Yii::$app->params['creditPath'],
		 ]);
	 } else {
	     return $this->render('index', [
		    'dataProvider' => $dataProvider,
		    'creditPath' => Yii::$app->params['creditPath'],
		 ]);
	 } 

	
	
    }
    /**
     * Approve user credit request.
     * @param integer $id
     * @return mixed
     */
    public function actionApprove($id){
	//подтверждаем банковский перевод и пишем в таблицу запрошенные кредиты
	$credits = Setting::findOne(Yii::$app->user->id);
	$payment = Paymentbanktrans::findOne($id);
	$credits->credit += $payment->sum;
	$payment->status = 1;
	
	$credits->update();
	$payment->update();
	
	//записываем в журнал транзакций
	$this->writeTransaction($payment->id, $payment->status);
	
	$this->redirect(array('index'));
    }
    /**
     * Cancel user credit request.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id){
	//отмена запроса кредитов банковским переводом
	$payment = Paymentbanktrans::findOne($id);	
	$payment->status = 2;		
	$payment->update();
	
	//записываем в журнал транзакций
	$this->writeTransaction($payment->id, $payment->status);
	
	$this->redirect(array('index'));
    }
    
    protected function writeTransaction($id, $status){
	$transaction = new Transactionbanktrans;	
	//$transaction = Transactionbanktrans::find();	
	//echo '<pre>'; print_r($transaction); exit;
	$transaction->t_id = $id;
	$transaction->user_id = Yii::$app->user->id;
	$transaction->status = $status;
	$transaction->type = 0;
	$transaction->date = time();
	
	//echo '<pre>'; print_r($transaction); exit;
	$transaction->save();
	//echo '<pre>'; $transaction->getErrors();exit;
	
    }

    /**
     * Displays a single Paymentbanktrans model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
	return $this->render('view', [
		    'model' => $this->findModel($id),
	]);
    }

    /**
     * Creates a new Paymentbanktrans model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
	$model = new Paymentbanktrans();
	//$user = User::find()->where(['id' => Yii::$app->user->id])->one();

	if (Yii::$app->request->isPost) {
	    $model->attributes = $_POST['Paymentbanktrans'];

	    $file = UploadedFile::getInstance($model, 'file');

	    $model->file = $file->name;
	    $model->user_id = Yii::$app->user->id;
	    $model->date = time();
	    $model->status = 0;

	    if ($model->validate() && $file) {
		$model->save();
		$file->saveAs(Yii::$app->params['creditPath'] . $file->name);
		//@todo send mail to superadmin
		//echo Yii::$app->user->identity->email; exit;
		Yii::$app->mailer->compose()
			->setFrom(Yii::$app->user->identity->email)
			->setTo('phpdev@xaker.ru')
			->setSubject('get credit')
			->setTextBody($model->message)
			->attach(Yii::$app->params['creditPath'] . $file->name)
			->send();
		Yii::$app->getSession()->setFlash('successCreditPay', 'Your message send to superadmin');
		$this->redirect(array('create', 'id' => $model->id));
	    }
	} else {
	    return $this->render('create', [
			'model' => $model,
	    ]);
	}
    }

    /**
     * Updates an existing Paymentbanktrans model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
	$model = $this->findModel($id);

	if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    return $this->redirect(['view', 'id' => $model->id]);
	} else {
	    return $this->render('update', [
			'model' => $model,
	    ]);
	}
    }

    /**
     * Deletes an existing Paymentbanktrans model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
	$this->findModel($id)->delete();

	return $this->redirect(['index']);
    }

    /**
     * Finds the Paymentbanktrans model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paymentbanktrans the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
	if (($model = Paymentbanktrans::findOne($id)) !== null) {
	    return $model;
	} else {
	    throw new NotFoundHttpException('The requested page does not exist.');
	}
    }

}
