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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
	<?= Html::a('Create Paymentbanktrans', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?=
    GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
	    ['class' => 'yii\grid\SerialColumn'],
	    'id',
	    [
		'attribute' => 'username',
		'value' => 'username',
		'format' => 'raw',
		'visible' => Yii::$app->user->can('superadmin'),
	    ],
	    'message',
	    [
		'label' => 'image',
		'format' => 'raw',
		//'value'=>function($data) { return $data->imageurl; },		
		'value' => function($data) {
	    return Html::a('Attached image', $data->imageurl, ['target' => 'blank']);
	},
	    //'value'=>Html::a('Create Paymentbanktrans', [function($data) { return $data->imageurl; }], ['data-toggle' => 'lightbox'])
	    //'value'=>Html::a('Create Paymentbanktrans', ['fun'], ['data-toggle' => 'lightbox'])
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
		'value' => function($data) {return date("Y-m-d H:i:s", $data->date);},
	    ],
	    [
		'attribute' => 'buttons',
		'format' => 'raw',
		'value' => function ($data) {
		    if(empty($data->status)){ 
		    return '<a href="/paymentbanktrans/approve?id='.$data->id.'" title="Approve">'
			    . '<span class="glyphicon glyphicon-ok"></span>'
			    . '</a>&nbsp;&nbsp;'
			    . '<a href="/paymentbanktrans/cancel?id='.$data->id.'" title="Cancel">'
			    . '<span class="glyphicon glyphicon-remove"></span>'
			    . '</a>';
		    } else {
		    return  '<span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;'			    
			    . '<span class="glyphicon glyphicon-remove"></span>';		    	
		    }		    
		},
		
	    ],
	    ['class' => 'yii\grid\ActionColumn',],
	],
    ]);
    ?>

</div>
