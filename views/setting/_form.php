<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

?>

<div class="row">
    <div class="col-lg-5">
        <p><b>Your ID</b>: <?php echo $model->user_id ?></p>
        <p><b>Your Credits</b>: <?php echo $model->credit ?></p>
<?php
    $form=ActiveForm::begin( [
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
        <?php echo $form->field($model, 'def_company_id')->dropDownList(app\models\Setting::List_company())->hint('Please enter Company')->label('Company') ; ?>
    </div>

    <div class="form-group">
      <?php echo $form->field($model, 'def_lang_id')->dropDownList(app\models\Setting::List_lang())->hint('You langviage')->label('langviage') ; ?>
    </div>

    <div class="form-group">
      <?php echo $form->field($model, 'def_vat_id')->dropDownList(app\models\Setting::List_Vat())->hint('You vat')->label('vat') ; ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'bank_code')->textInput()->hint('You bank_code')->label('bank_code') ; ?>
            <?php echo Html::error($model, 'bank_code'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'name')->textInput()->hint('You family, name, ')->label('fio') ; ?>
            <?php echo Html::error($model, 'name'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'account_number')->textInput()->hint('account_number')->label('account_number') ; ?>
            <?php echo Html::error($model, 'account_number'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'country')->textInput()->hint('country')->label('country') ; ?>
            <?php echo Html::error($model, 'country'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'city')->textInput()->hint('city')->label('city') ; ?>
            <?php echo Html::error($model, 'city'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'street')->textInput()->hint('street')->label('street') ; ?>
            <?php echo Html::error($model, 'street'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'post_index')->textInput()->hint('post_index')->label('post_index') ; ?>
            <?php echo Html::error($model, 'post_index'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'phone')->textInput()->hint('phone')->label('phone') ; ?>
            <?php echo Html::error($model, 'phone'); ?>
    </div>

    <div class="form-group">
            <?php echo $form->field($model, 'web_site')->textInput()->hint('web_site')->label('web_site') ; ?>
            <?php echo Html::error($model, 'web_site'); ?>
    </div>

    <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
    </div>

<?php  ActiveForm::end(); ?>
    </div>
</div>
