<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = Yii::t('app', 'Create User');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="title"><?= Html::encode($this->title) ?></h1>
<div class="form">

    <?php $form = ActiveForm::begin(['id' => 'form-signup',
        'options'=>['class' => 'form-horizontal', 'role'=>'form'],
        'fieldConfig' => [
        'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
    ],
    ]); ?>
    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Personal Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?= $form->field($model, 'email',['labelOptions'=>['class'=>'control-label col-md-4'],
                'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"]) ?>
        </div>
    </div>
    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Invoice Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($setting, 'def_template',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_Templates(['prompt'=>'-Choose a Template-'])); ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($setting, 'def_vat_id',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_vat(['prompt'=>'-Choose a Vat-'])); ?>
            <?php echo $form->field($setting, 'def_company_id',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_company(['prompt'=>'-Choose a Company-'])); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-action', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
