<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->name . ' - Buy Credits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paypal-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="text-left">
            <p><?php echo Yii::t('user', 'Recommended for europe and america'); ?></p>
            <p><?php echo Yii::t('credits', 'IMPORTANT! Currency - the U.S. dollar.'); ?></p>
            <p><?php echo Yii::t('credits', 'If you are using any other currency will be automatically converted at the exchange rate.'); ?></p>
        </div>
        <div class="paypal_mini">
            <img src="<?php print Yii::$app->homeUrl; ?>/images/paypal_mini.gif" alt="paypal" />
        </div>
    </div>
    <div class="clear"></div>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'payment-form']); ?>
            <div class="row">
                <?= $form->field($model, 'amount') ?>
            </div>
            <div class="form-group">                
                <?= Html::submitButton('Пополнить', ['class' => 'btn btn-primary', 'name' => 'payment-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="clear"></div>
</div>