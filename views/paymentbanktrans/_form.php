<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\Setting;
use app\models\Payment;

$banks = Payment::getBankData();
/* @var $this yii\web\View */
/* @var $model app\models\Paymentbanktrans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form">

<?php $form = ActiveForm::begin([
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
    ],
]); ?>

    <div class="row">
        <div class="fieldset-column pull-left">
            <?php echo $form->field($model, 'sum',['labelOptions'=>['class'=>'control-label col-md-5']])->textInput(['id'=>'cost_id', 'maxlength' => 10])->hint('You credit ')->label('Cost (€):') ; ?>
            <div class="form-group field-user_payment-credit required">
                <label class="control-label col-md-5" for="user_payment-credit">Number of Credits:</label>
                <div class="col-md-6">
                    <?php echo Html::textInput('number_credits', $model->sum, ['class'=>'form-control', 'disabled' => 'disabled','id'=>'credit_id']); ?>
                </div>
            </div>
            <div class="form-group field-user_payment-credit required">
                <label class="control-label col-md-5" for="user_payment-credit">Payment:</label>
                <div class="col-md-6">
                    <?php echo Html::dropDownList('payment_credits',$payment_id,Setting::List_payment(),['prompt'=>'-Choose a Payment-','id'=>'payment_credits', 'class'=>'form-control dropdown-ajax']); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="nowrap">Please pay the amount to the one of the following banks and then send us the receipt by pressing “Browse”</div>
            </div>
            <?php echo $form->field($model, 'file',['labelOptions'=>['class'=>'control-label col-md-5']])->fileInput()->hint('Attach File ')->label('Add Receipt') ; ?>
            <?php echo $form->field($model, 'message',['labelOptions'=>['class'=>'control-label col-md-5']])->textInput(['maxlength' => 255])->hint('Message')->label('Message') ; ?>
        </div>
    </div>
    <div class="row">
        <?php foreach ($banks as $key=>$bank) { ?>
        <div class="fieldset-full-grey">
            <div class="fieldset-column pull-left">
                <div class="form-group">
                    <label class="control-label col-md-4">Bank <?= $key+1 ?></label>
                    <div class="col-md-8">
                        <p class="form-control"><?= $bank['bank_name'] ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Bank Account</label>
                    <div class="col-md-8">
                        <p class="form-control"><?= $bank['bank_account'] ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">IBAN</label>
                    <div class="col-md-8">
                        <p class="form-control"><?= $bank['iban'] ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">SWIFT</label>
                    <div class="col-md-8">
                        <p class="form-control"><?= $bank['swift'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php } ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Buy Credits', ['class' => 'btn btn-action', 'name' => 'send']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var active_payment = <?= $payment_id ?>;
    var url_card = '<?= Url::toRoute(['/user/buy', 'id' => Yii::$app->user->id, 'payment_id' => 1], true) ?>';
    var url_paypal = '<?= Url::toRoute(['/user/payment_credit', 'id' => Yii::$app->user->id, 'payment_id' => 2], true) ?>';
    var url_bank = '<?= Url::toRoute(['/paymentbanktrans/create','payment_id' => 3], true) ?>';
</script>

<?php
Yii::$app->view->registerJsFile('@web/js/choose_payment.js');
?>
