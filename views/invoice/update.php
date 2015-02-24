<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [ 'modelClass' => 'Invoice', ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update #'.$model->id);
?>
<div class="invoice-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->context->renderPartial('_form', ['model' => $model,  'model_item' => 0,
        'itog'=>$itog, 'items' => $items, 'items_error'=>$items_error, 'is_add'=>false]); ?>

</div>
