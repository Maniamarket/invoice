<?php
use yii\helpers\Html;
use yii\helpers\Url;

if (!$classic) {
    echo Html::beginForm(['test'], 'post');
    echo Html::input('text', 'amount', 2);
    echo Html::submitButton();
    echo Html::endForm();
} else {
?>
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

    <input type="hidden" name="cmd" value="_xclick">

    <input type="hidden" name="business" value="RabotaSurv-de@gmail.com">

    <input type="hidden" name="lc" value="DE">

    <input type="hidden" name="item_name" value="My Cool Shop. Order #12345">

    <input type="hidden" name="item_number" value="12345">

    <input type="hidden" name="amount" value="2">

    <input type="hidden" name="no_note" value="1">

    <input type="hidden" name="no_shipping" value="1">

    <input type="hidden" name="rm" value="0">

    <input type="hidden" name="return" value="<?php echo Url::toRoute(['test_success'],true); ?>">

    <input type="hidden" name="cancel_return" value="<?php echo Url::toRoute(['test_success'],true); ?>">

    <input type="hidden" name="currency_code" value="EUR">

    <input type="hidden" name="notify_url" value="<?php echo Url::toRoute(['ipn'],true); ?>">

    <input type="submit" value="Платить через PayPal">

</form>
<?php } ?>