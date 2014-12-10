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
        'enableAjaxValidation'=>false,
    ]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


    <div class="form-group">
		<?php echo $form->field($model, 'url')->textInput()->hint('Please enter url. Example: "en"')->label('Url') ; ?>
		<?php echo Html::error($model, 'url'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->field($model, 'local')->textInput()->hint('Please enter locale. Example: "en-US"')->label('Locale') ; ?>
        <?php echo Html::error($model, 'local'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->field($model, 'name')->textInput()->hint('Please enter name')->label('Name') ; ?>
        <?php echo Html::error($model, 'name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->field($model, 'default')->textInput()->hint('Please enter default')->label('Default') ; ?>
        <?php echo Html::error($model, 'default'); ?>
    </div>

    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php  ActiveForm::end(); ?>

    </div>
</div>
