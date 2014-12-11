<?php $this->pageTitle = Yii::$app->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Withdraw Money') . " " . Yii::t('mypurse', 'Confirm the withdrawal'); ?>

<div class="title-small-menu">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array('label' => Yii::t('mypurse', 'Transfer Money'), 'url' => array('/mypurse/transfer')),
            array('label' => Yii::t('mypurse', 'Withdraw Money'), 'url' => array('/mypurse/withdraw')),
        )
    ));
    ?>
    <div class="cl"></div>
</div>

<div class="block_title">
    <h1><?php print Yii::t('mypurse', 'My Purse') . " &raquo; " . Yii::t('mypurse', 'Withdraw Money') . " &raquo; " . Yii::t('mypurse', 'Confirm the withdrawal'); ?></h1>
</div>
<div class="cl"></div>
<?php $this->renderPartial('//layouts/messages'); ?>
<div class="cl"></div>

<div class="mypurse">

    <div class="form full">
        <?php $form = $this->beginWidget('CActiveForm'); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'hash'); ?>
            <?php echo $form->textField($model, 'hash', array('class' => 'text')); ?>
            <?php echo $form->error($model, 'hash'); ?>
        </div>
        <div class="cl"></div>

        <div class="row buttons">
            <?php print CHtml::link(Yii::t('mypurse', 'Back to "My Purse"'), array('/mypurse/info'), array('class' => 'styling grey_button')); ?>
            <?php echo CHtml::submitButton(Yii::t('mypurse', 'Confirm the withdrawal'), array('class' => 'submit')); ?>
        </div>
        <div class="cl"></div>

        <?php $this->endWidget(); ?>
    </div>

</div>
