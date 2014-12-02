<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
	   
	    <?php echo $form->labelEx($model,'role'); ?>
	    <?php echo $form->dropDownList($model,'role', array('4'=>'User','3'=>'Manager'),
		    array('options' => array(Yii::app()->user->role =>array('selected'=>true))));?>
	    <?php echo $form->error($model,'role'); ?>
	</div>
	<div class="row">
	    <?php echo $form->labelEx($model,'def_company'); ?>
	    <?php echo $form->dropDownList($model,'def_company', MyHelper::getCompanyOptions(),
		    array('options' => array($model->def_company=>array('selected'=>true))));		
	    ?>
	    <?php echo $form->error($model,'def_company'); ?>
	</div>
	
	<div class="row">
	    <?php echo $form->labelEx($model,'def_lang'); ?>
	    <?php echo $form->dropDownList($model,'def_lang', Yii::app()->params->languages,
			array('options' => array($model->def_lang=>array('selected'=>true))));
	    ?>	
	    <?php echo $form->error($model,'def_lang'); ?>
	</div>	

	<div class="row">
	    <?php echo $form->labelEx($model,'vat'); ?>
	    <?php echo $form->dropDownList($model,'vat', MyHelper::getVAT(),array('empty'=>'no VAT')); ?>
	    <?php echo $form->error($model,'vat'); ?>
	</div>
	
	<div class="row">
	    <?php echo $form->labelEx($model,'credit'); ?>
	    <?php echo $form->textField($model,'credit',array('readonly'=>true)); ?>
	    <?php echo $form->error($model,'credit'); ?>
	    <?php //echo CHtml::Button('Get Credits'); ?>
	    
	   <?php echo CHtml::link('Get Credits','credit',array('class'=>'linkClass')); ?>
	</div>
	
	<div class="row buttons">
	    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->