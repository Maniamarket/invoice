<?php

namespace app\controllers;

use Yii;
use app\models\Invoice;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\Sellers;
use app\models\Clients;
use yii\data\ActiveDataProvider;

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
            'query' => Invoice::queryProvider(Yii::$app->request->queryParams),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
/*        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
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
        $model = new Invoice();

		$sellersList = ArrayHelper::map(Sellers::find()->asArray()->all(), 'id', 'name');
		$sellersAddrList = ArrayHelper::map(Sellers::find()->asArray()->all(), 'id', 'address');
		$sellersInnList = ArrayHelper::map(Sellers::find()->asArray()->all(), 'id', 'inn');
		$clientsList = ArrayHelper::map(Clients::find()->asArray()->all(), 'id', 'name');
		$clientsAddrList = ArrayHelper::map(Clients::find()->asArray()->all(), 'id', 'address');
		$clientsInnList = ArrayHelper::map(Clients::find()->asArray()->all(), 'id', 'inn');

		$model->user_id = Yii::$app->user->identity->id;

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'sellersList' => $sellersList,
                'sellersAddrList' => $sellersAddrList,
                'sellersInnList' => $sellersInnList,
                'clientsList' => $clientsList,
                'clientsAddrList' => $clientsAddrList,
                'clientsInnList' => $clientsInnList,
            ]);
        }
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
