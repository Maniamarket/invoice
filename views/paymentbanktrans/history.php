<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'History');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-index">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <p>&nbsp;</p>
    <table class="table table-striped table-bordered" id="table-result-search">
        <thead>
        <tr>
            <th>ID</th>
            <th>Transfer id</th>
            <th>Date</th>
            <th>Status </th>
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
