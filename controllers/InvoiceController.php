<?php

namespace app\controllers;

use app\models\Setting;
use app\models\User;
use app\models\Vat;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use app\models\Invoice;
use app\models\User_payment;
use app\components\HelpKontrol;
use app\models\Invoice_item;

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
        $items = Invoice_item::findAll(['invoice_id'=>$id]);
        if ($model->user_id == Yii::$app->user->id) {
            $template = empty($model->type) ? 'basic' : $model->type;
            return $this->render('tcpdf', [
                'model' => $model,
                'template'=>$template,
                'isTranslit'=>$isTranslit,
                'items'=>$items
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
            $sort = substr($sort,1);
            $dir = SORT_DESC;
        }
        else  $dir = SORT_ASC;

        $orderBy = ( $sort ) ? [$sort => $dir] :  ['is_pay'=>SORT_ASC, 'id'=>SORT_DESC];

        $query = Invoice::find()->select(['invoice.*', 'cl.name as client_name' ])->leftJoin('client as cl','invoice.client_id = cl.id');
        $query->where(['invoice.user_id'=> Yii::$app->user->id])->orderBy( $orderBy );
        if( $name_seach )  $query->andWhere(['like','cl.name', $name_seach.'%',false]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => $pageSize,  ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'pageSize' => $pageSize, 'sort'=>$sort, 'dir'=>$dir,
             'name_search' => $name_seach
        ] );
    }

    public function actionAjax()
    {
        if( Yii::$app->request->isAjax ){
            $name_seach = ( isset($_POST['name'])) ? $_POST['name'] : '';
            $pageSize = ( isset($_POST['count_search'])) ? $_POST['count_search'] : 5;
            $sort = ( isset($_GET['sort'])) ? $_GET['sort'] : '';
            $dir = ( isset($_GET['sort'])) ? $_GET['dir'] : SORT_ASC;

            $orderBy = ( $sort ) ? [$sort => $dir] :  ['is_pay'=>SORT_ASC, 'id'=>SORT_DESC];

            $query = Invoice::find()->select(['invoice.*', 'cl.name as client_name' ])->leftJoin('client as cl','invoice.client_id = cl.id');
            $query->where(['invoice.user_id'=> Yii::$app->user->id])->orderBy( $orderBy );
            if( $name_seach )  $query->andWhere(['like','cl.name', $name_seach.'%',false]);

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [ 'pageSize' => $pageSize,  ],
            ]);

            $t_page =  (isset(Yii::$app->request->queryParams['page']))?(Yii::$app->request->queryParams['page']-1)*$dataProvider->pagination->pageSize:0;
            if( $dataProvider->models )
                foreach ($dataProvider->models as $key=>$model) {
                   echo $this->renderPartial('_view', ['model'=>$model, 'number'=>$t_page+$key+1]);
                }
        }
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
        if( isset($_POST['id'])) $model = $this->findModel($_POST['id']);
        else {$model = new Invoice;  $model->client_id =1;  $model->company_id =1; $model->save();  }
        $model->date = date("d/m/Y",  time());
        $setting = Setting::findOne(Yii::$app->user->id);
        $model->vat_id = $setting->def_vat_id;
        $model->income_id = 1;
        $model->income = $setting->surtax;
        $items_error = [];
        $model_item = 0;

        if( isset($_POST['submit'])){
            $model->load(Yii::$app->request->post());
         //   var_dump($_POST); exit;
            $vat = Vat::findOne(['id'=>$model->vat_id]);

            $item = new Invoice_item;
            $item->attributes = $_POST;

            $item->total_price = $item->count*$item->price_service*(1+($vat->percent+$model->income+$item->discount)/100);
            $item->invoice_id = $model->id;
            $model_item = $item;
            $is_error = false;
            $item->validate();
      //      var_dump($item->errors); exit;
            if( $item->save() ){
                if( isset($_POST['items'])){
                    foreach( $_POST['items'] as $row){
                        $item_t =  Invoice_item::findOne($row['id']);
                        $item_t->attributes = $row;
                        $item_t->total_price = $item_t->count*$item_t->price_service*(1+($vat->percent+$model->income+$item_t->discount)/100);
                        $items_error[] = ( $is = $item_t->save()) ? 0 : $item_t->errors;
                        if( !$is ) $is_error = true;
                    }
                }
                if( !$is_error && ($_POST['submit'] == 'end' )){
                    $items = Invoice_item::findAll(['invoice_id'=>$model->id]);
                    $net = 0;
                    $total = 0;
                    foreach( $items as $row){
                        $net_t = $row['count']*$row['price_service'];
                        $net += $net_t;
                        $total += $net_t*(1+ ($vat->id + $model->income - $row['discount'])/100);
                    }

                    $model->net_price = $net;
                    $model->total_price = $total;
                    $model->user_id = Yii::$app->user->id;
                    var_dump($model->attributes);
                    if( $model->save()) return $this->redirect(['index']);
                }
            }
        }
        $items = Invoice_item::findAll(['invoice_id'=>$model->id]);
     //   var_dump($items); echo 'id='.$model->id;
        return $this->render('create', ['model' => $model, 'model_item' => $model_item, 'items' => $items, 'items_error'=>$items_error ]);
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
