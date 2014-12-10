<div class="page">
<h1 class="page__tit"><?php echo Yii::t('credits', 'Update your balance using "PayPal"'); ?></h1>
<div class="container_12 content_block_3">
Redirect on <a href="http://www.paypal.com">www.paypal.com</a>. One moment please.
<form method="post" id="paypal-form" name="_xclick" action= "https://www.paypal.com/cgi-bin/webscr" />
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="tetven@gmail.com" />
<input type="hidden" name="item_name" value="<?php echo CHtml::encode(Yii::app()->name); ?>: update blance on  $<?php print $amount; ?>" />
<input type="hidden" name="amount" value="<?php print $amount; ?>" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="quantity" value="1" />
<input type="hidden" name="return" value="<?php print $this->createAbsoluteUrl('/credits/paypal/notify', array('status' => 'complete')); ?>" />
<input type="hidden" name="cancel_return" value="<?php print $this->createAbsoluteUrl('/site/index'); ?>" />
<input type="hidden" name="notify_url" value="<?php print $this->createAbsoluteUrl('/credits/paypal/notify'); ?>" />
<input type="hidden" name="custom" value="<?php print $pp_id ?>" />
<input type="hidden" name="currency_code" value="USD" />
<input type="hidden" name="email" value="<?php print $user->email ?>" />
</form>
<script type="text/javascript">document.forms["paypal-form"].submit();</script>
</div>
</div>