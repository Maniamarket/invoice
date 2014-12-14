<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->name . ' - Buy Credits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paypal-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="text-left">
            <p><?= Yii::t('payment', 'Recommended for europe and america'); ?></p>
            <p><?= Yii::t('payment', 'IMPORTANT! Currency - the EUR.'); ?></p>
            <p><?= Yii::t('payment', 'If you are using any other currency will be automatically converted at the exchange rate.'); ?></p>
        </div>
        <div class="paypal_mini">
            <img src="<?= Yii::$app->homeUrl; ?>/images/paypal_mini.gif" alt="paypal" />
        </div>
    </div>
    <div class="clear"></div>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'payment-form']); ?>
            <div class="row">
                <?= $form->field($model, 'amount') ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'currency')->dropDownList(ArrayHelper::map($activeCurrency, 'id', 'char_code'), ['prompt' => ' - ' . Yii::t('payment', 'Choose a currency') . ' - ']); ?>
            </div>
            <div class="form-group">                
                <?= Html::submitButton('РџРѕРїРѕР»РЅРёС‚СЊ', ['class' => 'btn btn-primary', 'name' => 'payment-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="clear"></div>
</div>