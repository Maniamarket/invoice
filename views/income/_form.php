<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

?>


<div class="row">
    <div class="col-lg-5">
    <?php $form=ActiveForm::begin( [
        'id'=>'income-form',
        'enableAjaxValidation'=>false,
    ]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


        <div class="form-group">
		<?php echo $form->field($model, 'from')->textInput()->hint('Please enter from')->label('From') ; ?>
		<?php echo Html::error($model, 'from'); ?>
	</div>

        <div class="form-group">
		<?php echo $form->field($model, 'to')->textInput()->hint('Please enter to')->label('To') ; ?>
		<?php echo Html::error($model, 'to'); ?>
	</div>

        <div class="form-group">
		<?php echo $form->field($model, 'manager')->textInput()->hint('Please enter manager')->label('Manager') ; ?>
		<?php echo Html::error($model, 'manager'); ?>
	</div>

        <div class="form-group">
		<?php echo $form->field($model, 'admin')->textInput()->hint('Please enter admin')->label('Admin') ; ?>
		<?php echo Html::error($model, 'admin'); ?>
	</div>

    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php  ActiveForm::end(); ?>

    </div>
</div>
