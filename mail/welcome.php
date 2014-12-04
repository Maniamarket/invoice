<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$settingLink = Yii::$app->urlManager->createAbsoluteUrl(['setting/update']);
?>

Здравствуйте, <?= Html::encode($user->username) ?>!
<br />
Благодарим Вас за регистрацию на сайте. Начните с заполнения своего профиля:
<br />
<?= Html::a(Html::encode('Перейти в профиль'), $settingLink) ?>
<br />
Если Вы не регистрировались на нашем сайте, то просто удалите это письмо.