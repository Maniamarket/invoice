<?php

namespace app\controllers;

use app\models\Receipt;
use Yii;
use app\models\Transactionbanktrans;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransactionBanktransferController implements the CRUD actions for TransactionBanktransfer model.
 */
class TransactionbanktransController extends Controller {

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
     * Lists all TransactionBanktransfer models.
     * @return mixed
     */
    public function actionIndex() {
	$dataProvider = new ActiveDataProvider([
	    'query' => Transactionbanktrans::find()
		->select('transaction_banktransfer.id,'
			. 'username,'
			. 't_id,'
			. 'transaction_banktransfer.status,'
			. 'type,'
			. 'date')
		->join('inner join', 'user', 'user.id = transaction_banktransfer.user_id'),
		
	]);

	return $this->render('index', [
		    'dataProvider' => $dataProvider,
	]);
    }

    /**
     * Displays a single TransactionBanktransfer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
	return $this->render('view', [
		    'model' => $this->findModel($id),
	]);
    }

    /**
     * Creates a new TransactionBanktransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
	$model = new Transactionbanktrans();

	if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    return $this->redirect(['view', 'id' => $model->id]);
	} else {
	    return $this->render('create', [
			'model' => $model,
	    ]);
	}
    }

    /**
     * Updates an existing TransactionBanktransfer model.
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

    public function actionReceipt() {
        $model = Receipt::findOne([''])$this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
//        var_dump('aaaa');
    }

    /**
     * Deletes an existing TransactionBanktransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
	$this->findModel($id)->delete();

	return $this->redirect(['index']);
    }

    /**
     * Finds the TransactionBanktransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TransactionBanktransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
	if (($model = Transactionbanktrans::findOne($id)) !== null) {
	    return $model;
	} else {
	    throw new NotFoundHttpException('The requested page does not exist.');
	}
    }

}
