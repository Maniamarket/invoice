<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/*
# true - тестовый режим, https://www.sandbox.paypal.com
# false - рабочий режим, https://www.paypal.com/
*/
  $SandboxFlag = true;
  //$url_pay = ( $SandboxFlag ) ? 'https://www.sandbox.paypal.com' : 'https://www.paypal.com/'; //'https://www.paypal.com/cgi-bin/webscr'
  $url_pay = ( $SandboxFlag ) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
// e-mail продавца
  $paypalemail  = ( $SandboxFlag ) ? "RabotaSurv-facilitator@gmail.com " : "RabotaSurv-facilitator@gmail.com ";
   // e-mail client RabotaSurv-buyer@gmail.com 
  $currency     = 'RUB';// "EUR";              // валюта
?>

<div class="row">
    
<?php

  $form=ActiveForm::begin( [
	'id'=>'setting-form',
        'action' => 'succecc_paypal',
//        'action' => $url_pay,
	'enableAjaxValidation'=>false,
]); ?>

     <?php  echo Html::hiddenInput("cmd","_xclick"); ?>
     <?php  echo Html::hiddenInput("business",$paypalemail); ?>
     <?php  echo Html::hiddenInput("item_name","Credit"); ?>
     <?php  echo Html::hiddenInput("item_number" , $model->id); ?>
     <?php  echo Html::hiddenInput("amount" ,$model->credit); ?>
     <?php  echo Html::hiddenInput("no_shipping" , "1"); ?>
     <?php  echo Html::hiddenInput("return" , Url::toRoute('succecc_paypal', TRUE )); ?>
     <?php  echo Html::hiddenInput("rm" , "2"); ?>
     <?php  echo Html::hiddenInput("cancel_return" , Url::toRoute('cancel_paypal', TRUE )); ?>
     <?php  echo Html::hiddenInput("currency_code" , $currency); ?>
     <div class="form-group">
            <?php echo Html::submitButton( 'Buy' ,['class'=>'btn btn-success']); ?>
    </div>
</div>