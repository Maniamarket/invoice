<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/*
# true - тестовый режим, https://www.sandbox.paypal.com
# false - рабочий режим, https://www.paypal.com/
*/
$url_pay = ( \Yii::$app->params['SandboxFlag'] ) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
// e-mail продавца
$paypalemail  = ( \Yii::$app->params['SandboxFlag'] ) ? "RabotaSurv-de@gmail.com" : "info@maniamarket.eu";
$currency     =  "EUR";// 'RUB';             // валюта
?>

<div class="row">
    
<?php

  $form=ActiveForm::begin( [
	'id'=>'setting-form',
//        'action' => 'succecc_paypal',
        'action' => $url_pay,
	'enableAjaxValidation'=>false,
]); ?>

     <?php  echo Html::hiddenInput("cmd","_xclick"); ?>
     <?php  echo Html::hiddenInput("business",$paypalemail); ?>
     <?php  echo Html::hiddenInput("lc","DE"); ?>
     <?php  echo Html::hiddenInput("item_name","Credit"); ?>
     <?php  echo Html::hiddenInput("item_number" , $model->id); ?>
     <?php $number = $model->credit*(1+0.035);
          echo Html::hiddenInput("amount" ,number_format($number, 2, '.', ''));
     //     echo Html::hiddenInput("amount" ,$model->credit);
     ?>
     <?php  echo Html::hiddenInput("no_note" , "1"); ?>
     <?php  echo Html::hiddenInput("no_shipping" , "1"); ?>
     <?php  echo Html::hiddenInput("rm" , "1"); ?>
     <?php  echo Html::hiddenInput("return" , Url::toRoute('succecc_paypal', TRUE )); ?>
     <?php  echo Html::hiddenInput("cancel_return" , Url::toRoute('cancel_paypal', TRUE )); ?>
     <?php  echo Html::hiddenInput("currency_code" , $currency); ?>
     <?php  echo Html::hiddenInput("notify_url" , Url::toRoute(['ipn'],true)); ?>

     <div class="form-group">
            <?php echo Html::submitButton( 'Платить через PayPal' ,['class'=>'btn btn-success']); ?>
    </div>
</div>