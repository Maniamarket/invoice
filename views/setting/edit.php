<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Setting;
use yii\helpers\Url;

?>

<div class="form">
<?php
    $form=ActiveForm::begin( [
	'id'=>'service-form',
	'enableAjaxValidation'=>false,
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
        'fieldConfig' => [
            'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
        ],
]); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Personal Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($user, 'username',['labelOptions'=>['class'=>'control-label col-md-4'],'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(); ?>
            <?php echo $form->field($model, 'user_id',['labelOptions'=>['class'=>'control-label col-md-4'],
                'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"]
            )->textInput(['disabled'=>'disabled']) ; ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php  echo $form->field($user, 'email',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(); ?>
            <?php  echo $form->field($user, 'password_',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(); ?>
        </div>
    </div>
    <div class="fieldset-column pull-right">
        <?php  echo $form->field($user, 'role',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])
            ->dropDownList(User::getRoleArray(),[]); ?>
        <?php  echo $form->field($user, 'parent_id',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])
            ->dropDownList(User::getParentArray(),[]); ?>
    </div>

    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Invoice Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo Html::label('Income - ','', []); ?>
            <?php echo Html::label($model->surtax,'', ['class'=>'control-label']) ?>
            <?php echo Html::label('Default template - ','', []); ?>
            <?php echo Html::label(Setting::List_Templates()[$model->def_template],'', ['class'=>'control-label']) ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo Html::label('Default Vat - ','', []); ?>
            <?php echo Html::label(Setting::List_Vat()[$model->def_vat_id],'', ['class'=>'control-label']) ?>
            <?php echo Html::label('Default company - ','', []); ?>
            <?php echo Html::label(Setting::List_company()[$model->def_company_id],'', []) ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-action']); ?>
    </div>

    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Credits') ?></div>
    </div>

    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo Html::label($model->credit,'', [])?>
        </div>
    </div>
<?php  ActiveForm::end(); ?>

</div>
