<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Setting;
use yii\helpers\Url;

$this->title = Yii::t('app', 'User Update');
$this->params['breadcrumbs'][] = $this->title;

?>
<h1 class="title"><?php echo $this->title; ?></h1>

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
            <?php if( Yii::$app->user->can('superadmin')) echo $form->field($user, 'role',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])
                ->dropDownList(User::getRoleArray(),['id'=>'role_id']); ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php  echo $form->field($user, 'email',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(); ?>
            <?php  echo $form->field($user, 'password_',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(); ?>
            <?php  if( Yii::$app->user->can('superadmin')) echo $form->field($user, 'parent_id',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])
                ->dropDownList(User::getParentArray($user->role),['id'=>'parent_id']); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Invoice Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'surtax',['labelOptions'=>['class'=>'control-label']])->textInput(['disabled'=>'disabled']) ; ?>
            <?php echo $form->field($model, 'def_template',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_Templates(['prompt'=>'-Choose a Template-']),['disabled'=>'disabled']); ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'def_vat_id',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_vat(['prompt'=>'-Choose a Vat-']), ['disabled'=>'disabled']); ?>
            <?php echo $form->field($model, 'def_company_id',['labelOptions'=>['class'=>'control-label']])->dropDownList(Setting::List_company(['prompt'=>'-Choose a Company-']), ['disabled'=>'disabled']); ?>
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
            <?php echo $form->field($model, 'credit',['labelOptions'=>['class'=>'control-label']])->textInput(['disabled'=>'disabled']) ; ?>
            <a href="<?= Url::toRoute(['user/add_credit','id'=>$user->id]) ?>"  class="btn btn-action" >
                <?php echo Yii::t('app','Add Credits'); ?></a>
        </div>
    </div>
<?php  ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#role_id").change(function() {
            var role = $("#role_id").val();
              //  alert('role-'+role);
            $.ajax({
                url: '<?= Url::toRoute('setting/ajax_parent') ?>',
                method: 'post',
                data: { role:role },
                success: function (data) {
                    $("#parent_id").empty().html(data);
                }
            });
            })
    })
</script>
