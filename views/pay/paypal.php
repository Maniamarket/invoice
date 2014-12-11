<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


?>

<div class="row">
    
<?php
  $paypalemail  = "my@email.com";     // e-mail продавца
  $currency     = "EUR";              // валюта

  $form=ActiveForm::begin( [
	'id'=>'setting-form',
        'action' => 'succecc_paypal',
//        'action' => 'https://www.paypal.com/cgi-bin/webscr',
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