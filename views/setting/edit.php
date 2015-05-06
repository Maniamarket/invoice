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
            'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
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
        <div class="fieldset"><?= Yii::t('app', 'Professional Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'name',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'company_name',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'vat_number',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php
            echo $form->field($model, 'country_id',['labelOptions'=>['class'=>'control-label col-md-4']])->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Country::getCountriesArray(2),'cid','name'),['class'=>'dropdown-ajax']);

            ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.dropdown-ajax').parent().css('position: relative');
                    $('.dropdown-ajax').each(function(){
                        $(this).parent().append(
                            '<input type="text" class="form-control dropdown-ajax-search" value="'+$(this).children('option:selected').text()+'" />'
                        );
                        var list_option = '';
                        $(this).children('option').each(function(){
                            list_option = list_option +'<li data-val="'+$(this).val()+'">'+$(this).text()+'</li>';
                        })
                        $(this).parent().append('<div class="dropdown-ajax-result"><ul>'+list_option+'</ul></div>');
                    })
                    $('.dropdown-ajax-search').each(function() {
                        $(this).focus(function() {
                            $(this).next().show();
                        });
                        $(this).blur(function() {
                            if (!$(this).next().is(':hover')) {
                                $(this).next().hide();
                            }
                        });
                    })
                    $('.dropdown-ajax-result li').each(function() {
                        $(this).click(function() {
                            $(this).closest('.dropdown-ajax-result').prev().val($(this).text());
                            $(this).closest('.dropdown-ajax-result').prev().prev().val($(this).attr('data-val'));
                            //                         alert($(this).attr('data-val'));
                            $(this).closest('.dropdown-ajax-result').hide();
                        });
                    })
                    /*                    $(document).on('focus','.dropdown-ajax-search' ,function(){
                     alert('sddd');
                     $('.dropdown-ajax-result').show();
                     }).on('blur','.dropdown-ajax-search', function(){
                     $('.dropdown-ajax-result').hide();
                     })*/
                })
            </script>
            <?php echo $form->field($model, 'city',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'street',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'post_index',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'phone',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
            <?php echo $form->field($model, 'fax',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
            <?php echo $form->field($model, 'web_site',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput(); ?>
            <?php echo $form->field($model, 'file',['labelOptions'=>['class'=>'control-label col-md-4']])->fileInput();  ?>
        </div>
    </div>


    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Invoice Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'def_template',['labelOptions'=>['class'=>'control-label'],
                'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->dropDownList(Setting::List_Templates(['prompt'=>'-Choose a Template-'])); ?>
            <?php if (Yii::$app->user->can('superadmin')) { ?>
                <?php echo $form->field($model, 'surtax',['labelOptions'=>['class'=>'control-label'],
                    'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput() ; ?>
            <?php } ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'def_company_id',['labelOptions'=>['class'=>'control-label'],
                'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->dropDownList(Setting::List_company(['prompt'=>'-Choose a Company-'])); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-action']); ?>
    </div>

    <?php if (Yii::$app->user->can('superadmin')) { ?>

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
    <?php } ?>
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
