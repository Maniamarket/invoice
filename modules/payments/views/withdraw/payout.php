<?php $this->pageTitle = Yii::app()->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Withdraw Money'). ": " . $PaymentSystem->getName(); ?>
<div class="block_title">
    <h1><?php print Yii::t('mypurse', 'My Purse') . " &raquo; " . Yii::t('mypurse', 'Withdraw Money') . " &raquo; " . $PaymentSystem->getName(); ?></h1>
</div>
<div class="cl"></div>
<?php $this->renderPartial('//layouts/messages'); ?>
<div class="cl"></div>

<div class="mypurse">

    <div class="balance"><?php print Yii::t('mypurse', 'Your Balance') ?>: $<?php print $model->balance ?></div>

    <div class="form full">
        <?php $form = $this->beginWidget('CActiveForm'); ?>

        <div class="row">
            <?php echo CHtml::image($PaymentSystem->withdrawLogo(), $PaymentSystem->getName(), array('class'=>'withdraw-logo')); ?>
        </div>
        <div class="cl"></div>

        <div class="row">
            <?php echo $form->labelEx($model, 'amount'); ?>
            <?php echo $form->textField($model, 'amount', array('class' => 'text')); ?>
            <?php echo $form->error($model, 'amount'); ?>
        </div>
        <div class="cl"></div>

        <div class="row">
            <?php echo $form->labelEx($model, 'paymentSystemInfo'); ?>
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

        <br/>
        <br/>
        <p class="hint">
            1 USD = <?= Currency::getUSDCrossCurs('RUR'); ?> RUR<br/>
            1 USD = <?= Currency::getUSDCrossCurs('UAH'); ?> UAH<br/>
            <?= Yii::t('mypurse', 'Currency exchange is taken twice a day from the official site').' '. CHtml::link(Yii::t('mypurse', 'CBR'), 'http://www.cbr.ru', array('target' => '_blank')) ?><br/>
            <?= Yii::t('mypurse', 'For withdrawal of funds in russian rubles  - usage the official rate of exchange').' '. CHtml::link(Yii::t('mypurse', 'CBR'), 'http://www.cbr.ru', array('target' => '_blank')) ?><br/>
            <?= Yii::t('mypurse', 'For withdrawal of funds in U.S. dollars - the exchange rate is not considered') ?><br/>
            <?= Yii::t('mypurse', 'If you withdraw funds in any other foreign currency - calculate cross-rate for the selected currency') ?><br/>
        </p>
        <div class="cl"></div>



        <div class="row buttons">
            <?php print CHtml::link(Yii::t('mypurse', 'Choose another method'), array('index'), array('class' => 'styling grey_button')); ?>
            <?php echo CHtml::submitButton(Yii::t('mypurse', 'Send Request'), array('class' => 'submit')); ?>
        </div>
        <div class="cl"></div>

        <?php $this->endWidget(); ?>
    </div>

</div>