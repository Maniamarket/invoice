<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
$this->params['breadcrumbs'][] = $this->title;
$options_page_size = [20,50,100,200,500];
?>
<div class="invoice-index">


    <table class="table" id="table-result-search">
        <thead>
        <tr>
            <th>#</th>
            <th>ID </th>
            <th>Date </th>
            <th>Name </th>
            <th>Company </th>
            <th>Net Total</th>
            <th>Grand Total</th>
            <th>Valid </th>
        </tr>
        </thead>
        <tbody id="invoice_view">
 <?php
    $t_page =  (isset(Yii::$app->request->queryParams['page']))?(Yii::$app->request->queryParams['page']-1)*$dataProvider->pagination->pageSize:0;
    foreach ($dataProvider->models as $key=>$model) {
        echo $this->render('_view_ajax', ['model'=>$model, 'number'=>$t_page+$key+1]);
    }
?>
        </tbody>
    </table>
    <?php
    echo ListView::widget([
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
        'pager'=>[
            'prevPageLabel'=>'Prev',
            'nextPageLabel'=>'Next'
        ],
        'layout'=>'{pager}'
    ])
    ?>
</div>
<?php
/** @var \yii\data\ActiveDataProvider $dataProvider */
Yii::$app->view->registerJsFile('@web/js/invoice.js');
?>
