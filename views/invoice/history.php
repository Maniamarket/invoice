<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'History');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1 class="title"><?= Html::encode($this->title) ?>
    <?php if (Yii::$app->user->id != $user) echo ' User # '.$user; ?></h1>
    <table class="table" id="table-result-search">
        <thead>
        <tr>
            <th>ID</th>
            <th>Credits</th>
            <th>Date</th>
            <th>Credit summ </th>
            <th>Operation </th>
        </tr>
        </thead>
        <tbody>
        <?php
        echo ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_history',
        ]);
        ?>
        </tbody>
    </table>
</div>
