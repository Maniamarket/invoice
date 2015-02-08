<?php

namespace app\controllers;

use app\models\Company;
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
        $pageSize = ( isset($_GET['count_search'])) ? $_GET['count_search'] : 20;
        $name_seach = ( isset($_GET['name'])) ? $_GET['name'] : '';
        $sort = ( isset($_GET['sort'])) ? $_GET['sort'] : '';
        if( $sort && $sort[0] == '-') {
            $sort = substr($sort,1);
            $dir = SORT_DESC;
        }
        else  $dir = SORT_ASC;

        $orderBy = ( $sort ) ? [$sort => $dir] :  ['is_pay'=>SORT_ASC, 'id'=>SORT_DESC];

        $query = Invoice::find()->select(['invoice.*', 'cl.name as client_name' ])->leftJoin('client as cl','invoice.client_id = cl.id');
        if( Yii::$app->user->can('superadmin')) $query->orderBy( $orderBy );
        else  $query->where(['invoice.user_id'=> Yii::$app->user->id])->orderBy( $orderBy );
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

    public function actionAjax_company()
    {
        if( Yii::$app->request->isAjax ){
            $input = ($_POST['input_word']);
            $is_find = false;
            $res_mac = []; $mac = [];
            if( HelpKontrol::typ_name($input) ) {
                $mac = Company::list_company_field( $input, 'name' );
            }
            if( is_array($mac) && count($mac)) { $res_mac = $mac; $is_find = true;}

            if( HelpKontrol::typ_email($input) ) {
                $mac = Company::list_company_field( $input, 'mail' );
            }
            if( is_array($mac) && count($mac)) { $res_mac = $mac; $is_find = true;}

            if( !$is_find && HelpKontrol::typ_phone( $input )){
                $mac = Company::list_company_field( $input, 'phone' );
                if( !is_array($mac) || !count($mac)) $mac = Company::list_company_field( $input, 'phone2' );
            }
            if( is_array($mac) && count($mac)) { $res_mac = $mac; $is_find = true;}

            $i = 0;
            foreach( $res_mac as $key=>$val)
            {
                if( $i == 0 ) echo '<option selected="" value="'.$key.'">'.$val.'</option>';
                else  echo '<option  value="'.$key.'">'.$val.'</option>';
                $i++;
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
        if( ! isset( Yii::$app->session['create_invoice'])) Yii::$app->session['create_invoice'] = 1;

        if( isset($_POST['id'])) $model = $this->findModel($_POST['id']);
        else {$model = new Invoice; $model->client_id = 1; $model->company_id = 1; $model->payment_id = 1; $model->save();  }
        $model->client_id = 0;  $model->company_id = 0; $model->payment_id = 0;
        $model->date = date("Y/m/d", time());
        $setting = Setting::findOne(Yii::$app->user->id);
        $model->vat_id = $setting->def_vat_id;
        $model->income = $setting->surtax;
        $items_error = [];
        $itog = ['net'=>0, 'total'=>0];
        $model_item = 0;

        if( isset($_POST['submit'])){
            if( $_POST['submit'] == 'cleare'){
                $model_item = 0;
                $q = 'delete from invoice_item where invoice_id = '.$model->id;
                Yii::$app->db->createCommand($q)->execute();
            }else{
                $model->load(Yii::$app->request->post());
                $vat = Vat::findOne(['id'=>$model->vat_id]);
                $is_error = false;

                if( isset($_POST['items'])){

                    foreach( $_POST['items'] as $row){
                        $item_t =  Invoice_item::findOne($row['id']);
                        $item_t->attributes = $row;
                        $net = ((int) $item_t->count)*( (int) $item_t->price_service);
                        $item_t->total_price = $net*(1+( (int)$vat->percent+ (int)$model->income - (int)$item_t->discount)/100);
                        $items_error[] = ( $is = $item_t->save()) ? 0 : $item_t->errors;
                        if( !$is ) $is_error = true;
                        $itog['net'] = $itog['net']+$net;
                        $itog['total'] = $itog['total']+$item_t->total_price;
                    }
                }
                $item = new Invoice_item;
                $item->attributes = $_POST;
                $item->total_price = $item->count*$item->price_service*(1+($vat->percent + $model->income - $item->discount)/100);
                $item->invoice_id = $model->id;
                $model_item = $item;
                $itog['net'] = $itog['net']+ ((int) $item->count)*( (int) $item->price_service);
                $itog['total'] = $itog['total'] + $item->total_price;
                if( $_POST['submit'] == 'add' ){
                    if(Yii::$app->session['create_invoice']+1 == $_GET['create_invoice'] )
                       if( $item->save()) {Yii::$app->session['create_invoice'] = Yii::$app->session['create_invoice']+1; $model_item = 0;}
                }elseif( !$is_error && ($_POST['submit'] == 'end' ))
                {
                    $model->net_price = $itog['net'];
                    $model->total_price = $itog['total'];
                    $model->user_id = Yii::$app->user->id;
                    if( $model->save() && $item->save()) return $this->redirect(['index']);
                }
            }
        }
        $items = Invoice_item::findAll(['invoice_id'=>$model->id]);
        return $this->render('create', ['model' => $model, 'model_item' => $model_item, 'itog'=>$itog,
            'items' => $items, 'items_error'=>$items_error ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( ! isset( Yii::$app->session['create_invoice']) || ! Yii::$app->session['create_invoice'] ){
            Yii::$app->session['create_invoice'] = 1;
        }
/*  $mac = Company::list_company_field( '2', 'name' );
        if( is_array($mac) && count($mac)){    var_dump($mac); echo 'qqqq';}
   $mac = Company::list_company_field( '2', 'phone' );
    //    $mac = Company::list_company_field( 'g', 'name' );
     //   var_dump($mac);exit;
//*/
        $model = $this->findModel($id);
        $model->date = date("Y/m/d", time());

        $items_error = [];
        $itog = ['net'=>$model->net_price, 'total'=>$model->total_price];
        if( isset($_POST['submit'])){
            if( $_POST['submit'] == 'cleare'){
                $q = 'delete from invoice_item where invoice_id = '.$model->id;
                Yii::$app->db->createCommand($q)->execute();
            }else{
                $model->load(Yii::$app->request->post());
                $vat = Vat::findOne(['id'=>$model->vat_id]);
                $is_error = false;

                $itog = ['net'=>0, 'total'=>0];
                if( isset($_POST['items']))
                    foreach( $_POST['items'] as $row){
                        $item_t =  Invoice_item::findOne($row['id']);
                        $item_t->attributes = $row;
                        $net = ((int) $item_t->count)*( (int) $item_t->price_service);
                        $item_t->total_price = $net*(1+( (int) $vat->percent+ (int)$model->income - (int)$item_t->discount)/100);
                        $items_error[] = ( $is = $item_t->save()) ? 0 : $item_t->errors;
                        if( !$is ) $is_error = true;
                        $itog['net'] = $itog['net'] + $net;
                        $itog['total'] = $itog['total']+$item_t->total_price;
  //echo 'total=';       var_dump($item_t->total_price);    echo'net=';                var_dump($itog['net']);
                    }
//exit;
                if( $_POST['submit'] == 'add' ){
                    if( (Yii::$app->session['create_invoice']+1) == $_GET['create_invoice'] )
                    {
                        $item = new Invoice_item;
                        $item->count = 0;
                        $item->price_service =0;
                        $item->discount =0;
                        $item->service_id = 1;

                        $item->total_price = 0;
                        $item->invoice_id = $model->id;
                        if( $item->save()){
                            Yii::$app->session['create_invoice'] = $_GET['create_invoice'];
                        }
                    }
                }elseif( ! $is_error && ($_POST['submit'] == 'end' ))
                {
                    $model->net_price = $itog['net'];
                    $model->total_price = $itog['total'];
                    if( $model->save() ) return $this->redirect(['index']);
                }
            }
        }
        $items = Invoice_item::findAll(['invoice_id'=>$model->id]);
        return $this->render('update', ['model' => $model, 'itog'=>$itog,'items' => $items, 'items_error'=>$items_error ]);
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
