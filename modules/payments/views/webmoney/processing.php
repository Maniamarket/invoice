<meta http-equiv="Content-Type" content="text/html; charset=cp1251" />
<div align='center'  id="profile_title" ><?php echo Yii::t('credits', 'Update your balance using "WebMoney"'); ?><br /><br /></div>
<div class="container_12 content_block_3">
    Redirect on <a href="http://www.webmoney.ru">www.webmoney.ru</a>. One moment please.
    <form method="post" id="pay" name="pay" action= "https://merchant.webmoney.ru/lmi/payment.asp" />

    <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php print $amount; ?>" />
    <input type="hidden" name="LMI_PAYMENT_DESC" value="<?php echo CHtml::encode(Yii::$app->name); ?>: update blance on  $<?php print $amount; ?>" />
    <input type="hidden" name="LMI_PAYMENT_NO" value="<?php print $pp_id ?>" />
    <input type="hidden" name="LMI_PAYEE_PURSE" value="Z310766237213" />
    <input type="hidden" name="LMI_SIM_MODE" value="0" />

</form>
<script type="text/javascript">document.forms["pay"].submit();</script>
</div>