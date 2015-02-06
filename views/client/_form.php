<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

?>

<div class="form">
<?php
    $form=ActiveForm::begin( [
        'id'=>'setting-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation'=>false,
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
        ],
]); ?>

    <?php echo $form->errorSummary($model); ?>


    <div class="form-group">
            <div class="fieldset"><?= Yii::t('app', 'Personal Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'name',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'id',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(['disabled'=>'disabled']) ; ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'email',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'passw',['labelOptions'=>['class'=>'control-label col-md-4']])->passwordInput() ; ?>
        </div>
    </div>
    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Professional Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'company_name',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'vat_number',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'tax_agency',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'country_id',['labelOptions'=>['class'=>'control-label col-md-4']])->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Country::getCountriesArray(2),'cid','name')); ?>
            <?php echo $form->field($model, 'city',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'street',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'post_index',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'phone',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'fax',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
            <?php echo $form->field($model, 'web_site',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
            <?php echo $form->field($model, 'def_lang_id',['labelOptions'=>['class'=>'control-label col-md-4']])->dropDownList(app\models\Setting::List_lang()); ?>
        </div>
    </div>

    <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-action']); ?>
    </div>

<?php  ActiveForm::end(); ?>
</div>
