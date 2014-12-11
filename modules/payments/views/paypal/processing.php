<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use yii\helpers\Url;
use app\modules\payments\models\PaypalForm;

//$proccessUrl=PaypalForm::LIFE_PAYPAL_URL;
$proccessUrl=PaypalForm::TEST_PAYPAL_URL;
$businessEmail=PaypalForm::TEST_BUSINES_PAYPAL_EMAIl;
?>
<div class="page">
    <h1 class="page__tit"><?php echo Yii::t('credits', 'Update your balance using "PayPal"'); ?></h1>
    <div class="container_12 content_block_3">
        Redirect on <a href="http://www.paypal.com">www.paypal.com</a>. One moment please.
        <form method="post" id="paypal-form" name="_xclick" action="<?= $proccessUrl;?>" />
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="<?php print $businessEmail; ?>" />
        <input type="hidden" name="item_name" value="<?php echo Html::encode(Yii::$app->name); ?>: update blance on  $<?php print $amount; ?>" />
        <input type="hidden" name="amount" value="<?php print $amount; ?>" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="quantity" value="1" />
        <input type="hidden" name="return" value="<?= Url::toRoute(array('/payments/paypal/notify', array('status' => 'complete')), true); ?>" />
        <input type="hidden" name="cancel_return" value="<?= Url::toRoute('/payments/paypal/cancel', true); ?>" />
        <input type="hidden" name="notify_url" value="<?= Url::toRoute('/payments/paypal/notify', true); ?>" />
        <input type="hidden" name="custom" value="<?php print $pp_id ?>" />
        <input type="hidden" name="currency_code" value="RUB" />
        <input type="hidden" name="email" value="<?php print $user->email ?>" />
        </form>
        <script type="text/javascript">document.forms["paypal-form"].submit();</script>
    </div>
</div>