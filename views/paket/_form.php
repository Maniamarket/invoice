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
        <?php echo $form->field($model, 'value')->textInput()->hint('Please enter Quantity')->label('Quantity') ; ?>
    </div>

    <div class="form-group">
		<?php echo $form->field($model, 'price')->textInput()->hint('Please enter Cost')->label('Cost') ; ?>
	</div>

    <div class="form-group">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php  ActiveForm::end(); ?>

    </div>
</div>
