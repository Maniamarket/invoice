<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$settingLink = Yii::$app->urlManager->createAbsoluteUrl(['setting/update']);
?>

Здравствуйте!
<br />
Благодарим Вас за регистрацию на сайте. Ваш ID(логин)- <?= Html::encode($user->username) ?>  Начните с заполнения своего профиля:
<br />
<?= Html::a(Html::encode('Перейти в профиль'), $settingLink) ?>
<br />
Если Вы не регистрировались на нашем сайте, то просто удалите это письмо.