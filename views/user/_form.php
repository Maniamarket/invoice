<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>


<div class="row">
    <div class="col-lg-5">
    <?php $form=ActiveForm::begin( [
        'id'=>'service-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
    ]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


    <div class="form-group">
		<?php echo $form->field($model, 'name')->textInput()->hint('Please enter your name')->label('Name') ; ?>
		<?php echo Html::error($model, 'name'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->field($model, 'name')->textInput()->hint('Please enter your name')->label('Name') ; ?>
		<?php echo Html::error($model, 'name'); ?>
	</div>

    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php  ActiveForm::end(); ?>

    </div>
</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', array('5'=>'Client','4'=>'User','3'=>'Manager')); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post_index'); ?>
		<?php echo $form->textField($model,'post_index'); ?>
		<?php echo $form->error($model,'post_index'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'web_site'); ?>
		<?php echo $form->textField($model,'web_site',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'web_site'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat_number'); ?>
		<?php echo $form->textField($model,'vat_number',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vat_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'activity'); ?>
		<?php echo $form->textField($model,'activity',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'activity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'resp_person'); ?>
		<?php echo $form->textField($model,'resp_person',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'resp_person'); ?>
	</div>
	<div class="row">
	    <?php echo $form->labelEx($model,'bank_code'); ?>
	    <?php echo $form->textField($model,'bank_code',array('size'=>20,'maxlength'=>255)); ?>
	    <?php echo $form->error($model,'bank_code'); ?>
	</div>

	<div class="row">
	    <?php echo $form->labelEx($model,'account_number'); ?>
	    <?php echo $form->textField($model,'account_number',array('size'=>20,'maxlength'=>255)); ?>
	    <?php echo $form->error($model,'account_number'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->