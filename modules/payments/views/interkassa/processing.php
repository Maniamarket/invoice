<meta http-equiv="Content-Type" content="text/html; charset=cp1251" />
<div align='center'  id="profile_title" ><?php echo Yii::t('credits', 'Update your balance using "Interkassa"'); ?><br /><br /></div>
<div class="container_12 content_block_3">
    Redirect on <a href="http://www.interkassa.com">www.interkassa.com</a>. One moment please.
    <form method="post" id="pay" name="pay" action= "http://www.interkassa.com/lib/payment.php" />
    <input type="hidden" name="ik_shop_id" value="4EFA5C92-48A5-4BEA-2D29-27EE2CBA12A0" />
    <input type="hidden" name="ik_payment_amount" value="<?php print $amount; ?>" />
    <input type="hidden" name="ik_payment_id" value="<?php print $pp_id ?>" />
    <input type="hidden" name="ik_payment_desc" value="<?php echo CHtml::encode(Yii::$app->name); ?>: update blance on  $<?php print $amount; ?>" />
    <input type="hidden" name="ik_paysystem_alias" value="" />
    </form>
<script type="text/javascript">document.forms["pay"].submit();</script>
</div>