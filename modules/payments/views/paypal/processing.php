<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
//use yii\helpers\BaseHtml;
use yii\helpers\Url;
//use app\modules\payments\models\PaypalForm;
?>
<div class="page">
    <h1 class="page__tit"><?= Yii::t('payment', 'Update your balance using "PayPal"'); ?></h1>
    <div class="container_12 content_block_3">
        Redirect on <a href="http://www.paypal.com">www.paypal.com</a>. One moment please.

        <form method="post" id="paypal-form" name="_xclick" action="<?= $PaypalForm->proccessUrl; ?>" />
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="business" value="<?= $PaypalForm->businessEmail; ?>" />
        <input type="hidden" name="item_name" value="<?= Html::encode(Yii::$app->name) . ': ' . Yii::t('payment', 'update blance on') . ' ' . $history->amount . ' ' . Yii::t('payment', 'credits') ?>" />
        <input type="hidden" name="amount" value="<?= $history->equivalent; ?>" />
        <input type="hidden" name="no_shipping" value="1" />
        <input type="hidden" name="quantity" value="1" />
        <input type="hidden" name="return" value="<?= Url::toRoute(array('/payments/paypal/notify', array('status' => 'complete')), true); ?>" />
        <input type="hidden" name="cancel_return" value="<?= Url::toRoute('/payments/paypal/cancel', true); ?>" />
        <input type="hidden" name="notify_url" value="<?= Url::toRoute('/payments/paypal/notify', true); ?>" />
        <input type="hidden" name="custom" value="<?= $history->id ?>" />
        <input type="hidden" name="currency_code" value="<?= $PaypalForm->defaultCurrency; ?>" />
        <input type="hidden" name="email" value="<?= $user->email ?>" />
        </form>
        <script type="text/javascript">document.forms["paypal-form"].submit();</script>
    </div>
</div>