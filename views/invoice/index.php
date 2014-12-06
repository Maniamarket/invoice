<?php
//index.php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Invoice',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
	    
            ['label'=>'id',
	    'format'=>'raw',
	    'value'=>function($model){
		return Html::a(Html::encode($model->id),Url::toRoute(['invoice/pdf', 'id' => $model->id]));
		//return Html::url('invoice/pdf');
	    }
	    
	    ],	
            'user_id',
            'date',
            'name',
            'company_id',
            // 'service_id',
            // 'count',
            // 'vat_id',
            // 'discount',
            // 'price',
            // 'pay',
            // 'type',
            // 'finished',
            // 'created_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
