<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Paymentbanktrans */

$this->title = Yii::$app->name . ' - ' . Yii::t('app', 'Buy credits');
$this->params['breadcrumbs'][] = $this->title;

?>

  <strong><?= Yii::$app->session->getFlash('successCreditPay'); ?></strong>


<h1 class="title"><?php  echo Yii::t('app', 'Buy credits');  ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'payment_id' => $payment_id,
    ]) ?>
