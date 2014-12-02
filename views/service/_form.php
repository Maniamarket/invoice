<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>


<div class="form">

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
        
        
     	<div class="row">
		<?php echo $form->field($model, 'name')->textInput()->hint('Please enter your name')->label('Name') ; ?>
		<?php echo Html::error($model, 'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php  ActiveForm::end(); ?>

</div><!-- form -->