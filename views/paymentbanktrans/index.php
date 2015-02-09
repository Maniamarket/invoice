<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Paymentbanktrans';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="paymentbanktrans-index">
    <strong><?= Yii::$app->session->getFlash('successCreditPay'); ?></strong>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Paymentbanktrans', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',	    
            'message',
	    [
		'attribute' => 'image',
		'format' => 'raw',
		//'value'=>function($data) { return $data->imageurl; },		
		'value'=>function($data) { return Html::a('Attached image', $data->imageurl, ['target'=>'blank']); },		
		
	    ],
	    'sum',
	    [
		'attribute' => 'status',
		'format' => 'html',
		'value' => function($data) {
		    switch($data->status){
			case 0: return '<span class="label label-primary">Отправлен</span>';
			case 1: return '<span class="label label-success">Принят</span>';
			case 2: return '<span class="label label-danger">Отклонен</span>';
			default: return '<span class="label label-danger">Ошибка</span>';
		    }
		},
	    
	    ],
	    [
		'attribute' => 'date',
		'value' => function($data) { return date("Y-m-d H:i:s",$data->date);},		
	    ],			
        ],
    ]); ?>

</div>
