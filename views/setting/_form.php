<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\bootstrap\Modal;
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
            'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
        ],
/*        'fieldConfig' => [
            'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
        ],*/
]); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Personal Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($user, 'username',['labelOptions'=>['class'=>'control-label col-md-4'],'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput() ; ?>
            <?php echo $form->field($model, 'user_id',['labelOptions'=>['class'=>'control-label col-md-4'],
                'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"]
            )->textInput(['disabled'=>'disabled']) ; ?>
        </div>
        <div class="fieldset-column pull-right">
            <?php  echo $form->field($user, 'email',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput() ; ?>
            <?php  echo $form->field($user, 'password_',['labelOptions'=>['class'=>'control-label col-md-4'], 'template' => "{label}\n<div class=\"col-md-7\">{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput() ; ?>
        </div>
    </div>


    <div class="form-group">
        <div class="fieldset"><?= Yii::t('app', 'Professional Details') ?></div>
    </div>
    <div class="row">
        <div class="fieldset-column pull-left">
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
        </div>
        <div class="fieldset-column pull-right">
            <?php echo $form->field($model, 'def_company_id',['labelOptions'=>['class'=>'control-label'],
                'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->dropDownList(Setting::List_company(['prompt'=>'-Choose a Company-'])); ?>
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
            <?php echo $form->field($model, 'credit',['labelOptions'=>['class'=>'control-label'],
                'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>"])->textInput(['disabled'=>'disabled'])->label(Yii::t('app', 'Balance')) ; ?>
            <a href="<?= Url::toRoute(['user/buy'],true) ?>" class="btn btn-action">
                <?php echo Yii::t('app','Buy Credits'); ?></a>
<!--            <a href="#" data-toggle="modal" data-target="#modal-credits" class="btn btn-action">
                <?php echo Yii::t('app','Buy Credits'); ?></a>-->
        </div>
    </div>
<?php  ActiveForm::end(); ?>
            <?php
 /*           Modal::begin([
                'header' => '&nbsp;',
                'options'=>['id'=>'modal-credits'],
//                'toggleButton' => ['tag'=>'a', 'label' => 'Buy Credits',
//                    'style'=>'cursor:pointer;', 'class'=>'btn btn-action'],
//            'size' => 'modal-lg',
            ]);
            $form=ActiveForm::begin( [
                'id'=>'payment-form',
                'enableAjaxValidation'=>false,
                'options'=>['class' => 'form-horizontal', 'role'=>'form'],
                'fieldConfig' => [
                    'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
                ],
            ]);
            echo '<div class="row">';
            echo '<div class="form-group"><label class="control-label col-md-5" >Number of Credits</label><div class="col-md-6">'.Html::textInput('number_credits','',['id'=>'number_credits', 'class'=>'form-control']).'</div></div>';
            echo '<div class="form-group"><label class="control-label col-md-5" >Payment</label><div class="col-md-6">'.Html::dropDownList('payment_credits','',Setting::List_payment(),['id'=>'payment_credits', 'class'=>'form-control']).'</div></div>';
            echo '<div class="form-group"><div class="col-md-5" style="text-align: right;"><a href="#" id="buy_credit_submit" class="btn btn-action">Buy Credits</a> </div></div>';
            echo '</div>';
            ActiveForm::end();
            Modal::end();*/
            ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#buy_credit_submit").click(function() {
            var sum = $("#number_credits").val();
            if (sum<1) {
               alert('Count credits must > 0!');
           }
           else {
                var id_payment = parseInt($('#payment_credits').val());
                switch (id_payment) {
                    case 1:
                        $('#payment-form').attr('action','<?= Url::toRoute(['payment/index']) ?>');
                        $('#payment-form').submit();
                        break;
                    case 2:
                        $('#payment-form').attr('action','<?= Url::toRoute(['user/payment_credit','payment_id'=>'2', 'id'=>Yii::$app->user->id]) ?>');
                        $('#number_credits').attr('name','User_payment[credit]')
                        $('#payment-form').submit();
                        break;
                    default :
                        $('#payment-form').attr('action','<?= Url::toRoute(['paymentbanktrans/create']) ?>');
                        $('#number_credits').attr('name','Paymentbanktrans[sum]')
                        $('#payment-form').submit();
                        break;
                }
           }
        })
    })
</script>
