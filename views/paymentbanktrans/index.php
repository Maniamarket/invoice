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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'message',
	    [
		'label' => 'image',
		'format' => 'image',
		'value'=>function($data) { return $data->imageurl; },
	    ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
