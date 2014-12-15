<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaction Banktransfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-banktransfer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
	<?php //Html::a('Create Transaction Banktransfer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
	    ['class' => 'yii\grid\SerialColumn'],
	    //'id',
	    't_id',	    
	    [
		'attribute' => 'user_id',
		'value' => 'username',
		'format' => 'raw',		
	    ],
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
		'attribute' => 'type',
		'format' => 'html',
		'value' => function($data) {
		    switch($data->type){
			case 0: return '<span class="label label-default">Bank transfer</span>';
			default: return '<span class="label label-danger">Ошибка</span>';
		    }
		},
	    
	    ],
	    [
		'attribute' => 'date',
		'value' => function($data) {
		    return date("Y-m-d H:i:s", $data->date);
		}	
	    ],
	    ['class' => 'yii\grid\ActionColumn'],
	],
    ]);
    ?>

</div>
