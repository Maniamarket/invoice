<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div class="row">
	    <?php echo $form->labelEx($model, 'logo'); ?>
	    <?php echo $form->fileField($model, 'logo'); ?>
	    <?php echo $form->error($model, 'logo'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'street'); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'post_index'); ?>
		<?php echo $form->textField($model,'post_index',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'post_index'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'web_site'); ?>
		<?php echo $form->textField($model,'web_site',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'web_site'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'vat_number'); ?>
		<?php echo $form->textField($model,'vat_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'vat_number'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'activity'); ?>
		<?php echo $form->textField($model,'activity',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'activity'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'resp_person'); ?>
		<?php echo $form->textField($model,'resp_person',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'resp_person'); ?>
	</div>
	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->