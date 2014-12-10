<?php $form = $this->beginWidget('CActiveForm'); ?>

<?php echo $form->hiddenField($model, 'payment_system_id', array('value' => $PaymentSystem->getId())); ?>

<div class="row">
    <?php echo $form->labelEx($model, 'amount'); ?>
    <?php echo $form->textField($model, 'amount', array('class' => 'text')); ?>
    <?php echo $form->error($model, 'amount'); ?>
</div>
<div class="cl"></div>

<div class="row">
    <label for="PaymentOutput_paymentSystemInfo">
        <?php echo $PaymentSystem->withdrawAttributeLabel(); ?>
    </label>
    <?php echo $PaymentSystem->getField($form, $model); ?>
    <?php echo $form->error($model, 'paymentSystemInfo'); ?>
</div>
<div class="cl"></div>

<div class="row">
    <?php echo $form->labelEx($model, 'clientWish'); ?>
    <?php echo $form->textArea($model, 'clientWish', array('class' => 'text')); ?>
    <?php echo $form->error($model, 'clientWish'); ?>
</div>
<div class="cl"></div>

<div class="withdraw_info">
    <ul class="hint">
        <li>
            1 USD = <?= Currency::getUSDCrossCurs('RUR'); ?> RUR
        </li>
        <li>
            1 USD = <?= Currency::getUSDCrossCurs('UAH'); ?> UAH
        </li>
        <li>
            <?= Yii::t('mypurse', 'Currency exchange is taken twice a day from the official site') . ' ' . CHtml::link(Yii::t('mypurse', 'CBR'), 'http://www.cbr.ru', array('target' => '_blank')) ?>
        </li>
        <li>
            <?= Yii::t('mypurse', 'For withdrawal of funds in russian rubles  - usage the official rate of exchange') . ' ' . CHtml::link(Yii::t('mypurse', 'CBR'), 'http://www.cbr.ru', array('target' => '_blank')) ?>
        </li>
        <li>
            <?= Yii::t('mypurse', 'For withdrawal of funds in U.S. dollars - the exchange rate is not considered') ?>
        </li>
        <li>
            <?= Yii::t('mypurse', 'If you withdraw funds in any other foreign currency - calculate cross-rate for the selected currency') ?>
        </li>
    </ul>                
</div>
<div class="cl"></div>

<div class="buttons_add">
    <?php echo CHtml::submitButton(Yii::t('mypurse', 'Send Request'), array('class' => 'submit')); ?>
</div>
<div class="cl"></div>

<?php $this->endWidget(); ?>
