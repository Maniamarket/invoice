<?php

namespace app\controllers;

use Yii;
use app\models\Paymentbanktrans;
use app\models\Transactionbanktrans;
use app\models\Setting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\User_payment;

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
    public function actionIndex()
    {
    	if (Yii::$app->user->identity->role === 'superadmin') {
	    	$query = Paymentbanktrans::find()->select('payment_bt.id,username,message,file, payment_bt.status,date,user_id,sum')
                ->join('inner join', 'user', 'user.id = payment_bt.user_id');
        } else {
            $query = Paymentbanktrans::find()->select('payment_bt.id,username,message,file,payment_bt.status, date,sum')
                ->join('inner join', 'user', 'user.id = payment_bt.user_id')
                ->where(['user_id' => Yii::$app->user->id]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10, ],
        ]);
        if (Yii::$app->user->identity->role === 'superadmin')
          return $this->render('index_adm', [ 'dataProvider' => $dataProvider,  'creditPath' => Yii::$app->params['creditPath'], ]);
        else
          return $this->render('index', [ 'dataProvider' => $dataProvider,  'creditPath' => Yii::$app->params['creditPath'], ]);
        }

    /**
     * Approve user credit request.
     * @param integer $id
     * @return mixed
     */
    public function actionApprove($id) {
	//подтверждаем банковский перевод и пишем в таблицу запрошенные кредиты	
	$payment = Paymentbanktrans::findOne($id);
	$credits = Setting::findOne(['user_id' => $payment->user_id]);

	$credits->credit += $payment->sum;
	$payment->status = 1;
 //оплата налогов (история)
    $model = new User_payment;
    $model->user_id = $payment->user_id;
    $model->is_input = 1;
    $model->credit = $payment->sum;
    $old = User_payment::find()->where(['user_id'=>$payment->user_id])->orderBy(['id'=>SORT_DESC])->one();
        $model->credit_sum =  ( $old ) ? ($old->credit_sum + $payment->sum) : $payment->sum;
        $model->profit_parent =  ( $old ) ? $old->profit_parent : 0;
    $model->date = date("Y/m/d", time());
    $model->txn_id = 0;
    if( $model->save()){
        $credits->update();
        $payment->update();

        //записываем в журнал транзакций
        $this->writeTransaction($payment->user_id, $payment->id, $payment->status);
        $this->redirect(['index']);
    }
 }

    /**
     * Cancel user credit request.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel($id) {
	//отмена запроса кредитов банковским переводом
	$payment = Paymentbanktrans::findOne($id);
	$payment->status = 2;
	$payment->update();

	//записываем в журнал транзакций
	$this->writeTransaction($payment->user_id, $payment->id, $payment->status);

	$this->redirect(array('index'));
    }

    protected function writeTransaction($uid, $tid, $status) {
	$transaction = new Transactionbanktrans;	
	$transaction->t_id = $tid;
	$transaction->user_id = $uid;
	$transaction->status = $status;
	$transaction->type = 0;
	$transaction->date = time();
	
	$transaction->save();
	
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
        if (!empty($file)) {
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
                ->setTo(Yii::$app->params['adminEmail'])
                ->setSubject('get credit')
                ->setTextBody($model->message)
                ->attach(Yii::$app->params['creditPath'] . $file->name)
                ->send();
            Yii::$app->getSession()->setFlash('successCreditPay', 'Your message send to superadmin');
            $this->redirect(array('index', 'id' => $model->id));
            }
	    }
	}
    return $this->render('create', [
        'model' => $model,
    ]);
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
