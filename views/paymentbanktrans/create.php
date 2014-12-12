<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paymentbanktrans */

$this->title = 'Get credits by bank transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentbanktrans-create">
  <strong><?= Yii::$app->session->getFlash('successCreditPay'); ?></strong>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
