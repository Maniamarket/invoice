<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use nex\chosen\Chosen;
use yii\jui\AutoComplete;

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
            <?php if( !$model->isNewRecord ) echo $form->field($model, 'password_',['labelOptions'=>['class'=>'control-label col-md-4']])->textInput() ; ?>
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
            <?php
/*            echo $form->field($model, 'country_id',['labelOptions'=>['class'=>'control-label col-md-4']])->widget(
                Chosen::className(), [
                'items' => \yii\helpers\ArrayHelper::map(\app\models\Country::getCountriesArray(2),'cid','name'),
                'disableSearch' => false,
                'clientOptions' => [
                    'search_contains' => true,
                    'single_backstroke_delete' => false,
                ],
            ]);*/
             /*           echo $form->field($model, 'country_id',['labelOptions'=>['class'=>'control-label col-md-4']])->widget(
                AutoComplete::className(), [
//                'source' => \yii\helpers\ArrayHelper::map(\app\models\Country::getCountriesArray(2),'cid','name'),
//                'disableSearch' => false,
                'clientOptions' => [
                    'source' => ['USA', 'RUS'],// \yii\helpers\ArrayHelper::map(\app\models\Country::getCountriesArray(2),'cid','name'),
 //                   'single_backstroke_delete' => false,
                ],
            ]);*/
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
            <?php echo $form->field($model, 'def_lang_id',['labelOptions'=>['class'=>'control-label col-md-4']])->dropDownList(app\models\Setting::List_lang()); ?>
            <?php echo $form->field($model, 'file',['labelOptions'=>['class'=>'control-label col-md-4']])->fileInput();  ?>
        </div>
    </div>

    <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-action']); ?>
    </div>

<?php  ActiveForm::end(); ?>
</div>
