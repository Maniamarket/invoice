<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="form col-sm-5">

<?php $form = ActiveForm::begin([
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data', 'role'=>'form'],
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
            <?php echo $form->field($model, 'name')->textInput()->hint('You family, name, ')->label('name') ; ?>
            <?php echo Html::error($model, 'name'); ?>
	</div>

        <div class="form-group">
          <?php echo $form->field($model, 'company_id')->dropDownList(app\models\Setting::List_company(),['prompt'=>'-Choose a Company-'])->hint('Company')->label('Company') ; ?>
        </div>
        <div class="form-group">
          <?php echo $form->field($model, 'client_id')->dropDownList(app\models\Setting::List_client(),['prompt'=>'-Choose a Client-'])->hint('client')->label('client') ; ?>
        </div>

        <div class="form-group">
          <?php echo $form->field($model, 'service_id')->dropDownList(app\models\Setting::List_service(),['prompt'=>'-Choose a Service-'])->hint('Service')->label('Service') ; ?>
        </div>

        <div class="form-group">
         <?php echo $form->field($model, 'price_service', [
                'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('price_service'), ],
               ])->label(false);
             echo Html::error($model, 'price_service'); 
         ?>
        </div>

        <div class="form-group">
         <?php echo $form->field($model, 'count', [
                'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('count'), ],
               ])->label(false);
             echo Html::error($model, 'count'); 
         ?>
        </div>

        <div class="form-group">
         <?php echo $form->field($model, 'vat', [
                'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('vat'), ],
               ])->label(false);
             echo Html::error($model, 'vat'); 
         ?>
        </div>

        <div class="form-group">
         <?php echo $form->field($model, 'tax', [
                'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('tax'), ],
               ])->label(false);
             echo Html::error($model, 'tax'); 
         ?>
        </div>

        <div class="form-group">
         <?php echo $form->field($model, 'discount', [
                'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('discount'), ],
               ])->label(false);
              echo Html::error($model, 'discount'); 
         ?>
        </div>

	<div class="row buttons">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->