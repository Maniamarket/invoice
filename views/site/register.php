<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'register-form',
    'enableAjaxValidation'=>true,    
    'focus'=>array($model,'name'),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', array('4'=>'User','3'=>'Manager')); ?>
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
	
	<?php if(CCaptcha::checkRequirements()) : ?>  
	<div class="row">	                  
	    <div class="contact_field_wrapper">
		<?php echo '<br />'.$form->labelEx($model, 'verifyCode'); ?> 
		<div class="captcha user-captcha">
		    <?php $this->widget('CCaptcha'); ?>
		    <?php echo $form->error($model, 'verifyCode'); ?>
		    <?php echo '<br />'.$form->textField($model,'verifyCode'); ?>
		    <div class="hint">Please enter the letters as they are shown in the image above.<br/>
			Letters are not case-sensitive.
		    </div>
		</div>
	    </div>	    
	</div>
	<?php endif; ?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Create User'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>