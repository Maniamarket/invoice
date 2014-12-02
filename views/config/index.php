<div class="form">
 
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'config-form',
    'enableAjaxValidation' => false,
));
?>
    <h1><?php echo Yii::t('app', 'Options'); ?></h1>
 
    <?php if(Yii::app()->user->hasFlash('config')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('config'); ?>
    </div>
    <?php endif; ?>
 
    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
    </p>
 
    <?php echo $form->errorSummary($model); ?>
 
    <div class="row">
    <?php echo $form->labelEx($model,'adminEmail'); ?>
    <?php echo $form->textField($model, 'adminEmail'); ?>
    <?php echo $form->error($model,'adminEmail'); ?>
    </div><!-- row -->
    <div class="row">
    <?php echo $form->labelEx($model,'paramName'); ?>
    <?php echo $form->textField($model, 'paramName'); ?>
    <?php echo $form->error($model,'paramName'); ?>
    </div><!-- row -->
    <div class="row buttons">
    <?php echo CHtml::submitButton(Yii::t('app', 'Save')); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div><!-- form -->