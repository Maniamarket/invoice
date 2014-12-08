<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    public function behaviors()
    {
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
     * export a single Invoice model in PDF.
     * @return mixed
     */
    public function actionPdf($id){
        Yii::$app->response->format = 'pdf';
        return $this->renderPartial('invoice', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionTcpdf($id)
    {
        return $this->render('tcpdf', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->where(['user_id'=> Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    /**
     * Displays a single Invoice model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $model = new Invoice;

        if ($model->load(Yii::$app->request->post()) ) {
 //           $model->date = new Expression('NOW()');;
            $price = $model->price_service*$model->count;
            $model->price = $price*($model->vat+$model->tax)/100;
            $model->user_id = Yii::$app->user->id;
            if( $model->save()) return $this->redirect(['index']);
        } 
        return $this->render('create', ['model' => $model, ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
