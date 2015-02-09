<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paymentbanktrans */

$this->title = 'Update Paymentbanktrans: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paymentbanktrans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paymentbanktrans-update">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
