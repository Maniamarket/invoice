<?php

namespace app\controllers;

use Yii;
use yii\base\Object;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\web\ForbiddenHttpException;
use app\models\Invoice;
use app\models\InvoiceSearch;
use app\models\User_payment;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
/*    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/

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

    public function actionSettemplate($id, $template)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->id) {
            $model->type = $template;
            if ($model->save())
                Yii::$app->getSession()->setFlash('success', 'Шаблон успешно установлен ');
            else
                Yii::$app->getSession()->setFlash('danger', 'Неизвестная ошибка: '.$model->errors['type'][0]);
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException('Access to the invoice is forbidden. You are not the owner of the invoice');
        }
    }

    public function actionTcpdf($id, $isTranslit = 0)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->id) {
            $template = empty($model->type) ? 'basic' : $model->type;
            return $this->render('tcpdf', [
                'model' => $model,
                'template'=>$template,
                'isTranslit'=>$isTranslit
            ]);
        } else {
            throw new ForbiddenHttpException('Access to the invoice is forbidden. You are not the owner of the invoice');
        }
    }

   
    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionHistory()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User_payment::findBySql('select u.* from {{user_payment}} as u '
                    . '  where u.user_id = '.Yii::$app->user->id.' and u.txn_id IS NOT NULL order by u.id desc'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('history', ['dataProvider' => $dataProvider]);
    }
    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pageSize = ( isset($_GET['count_search'])) ? $_GET['count_search'] : 5;
        $name_seach = ( isset($_GET['name'])) ? $_GET['name'] : '';
        $sort = ( isset($_GET['sort'])) ? $_GET['sort'] : '';
        if( $sort && $sort[0] == '-') {
            $sort = unsert($sort[0]);
            $dir = SORT_DESC;
        }
        else  $dir = SORT_ASC;

        $orderBy = ( $sort ) ? [$sort => $dir] :  ['is_pay'=>SORT_ASC, 'id'=>SORT_DESC];

        $query = Invoice::find()->where(['user_id'=> Yii::$app->user->id])->orderBy( $orderBy );
        if( $name_seach )  $query->andWhere(['like','name', $name_seach.'%',false]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'pageSize' => $pageSize, 'sort'=>$sort, 'dir'=>$dir]);
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
            $model->date = new Expression('NOW()');
            $price = $model->price_service*$model->count;
            $model->price = $price*(1+($model->vat + $model->tax - $model->discount)/100);
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
