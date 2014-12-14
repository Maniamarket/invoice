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
		'label' => 'username',
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
		'label' => 'status',
		'value' => function($data) {
	    return $data->status;
	},
	    //'value'=>function($data) { return $data->status ? 0 : 'Отправлен' ? 1 : 'Принят' ? 2 : 'Отклонен';},		
	    //'value'=>['0'=>'Отправлен','1'=>'Принят','2'=>'Отклонен'],
	    ],
	    [
		'label' => 'date',
		'value' => function($data) {
	    return date("Y-m-d H:i:s", $data->date);
	},
	    ],
	    [
		'attribute' => 'buttons',
		'format' => 'raw',
		'value' => function ($model) {
		    return '<a href="/paymentbanktrans/approve?id='.$model->id.'" title="Approve">'
			    . '<span class="glyphicon glyphicon-ok"></span>'
			    . '</a>&nbsp;&nbsp;'
			    . '<a href="/paymentbanktrans/cancel?id='.$model->id.'" title="Cancel">'
			    . '<span class="glyphicon glyphicon-remove"></span>'
			    . '</a>';	
		    //return '<a class="btn btn-success" href="/ru/paymentbanktrans/create">Create Paymentbanktrans</a><a class="btn btn-" href="/ru/paymentbanktrans/create">Create Paymentbanktrans</a>';	
		},
	    ],
	    ['class' => 'yii\grid\ActionColumn',],
	],
    ]);
    ?>

</div>
