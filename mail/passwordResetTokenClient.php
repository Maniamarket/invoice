<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $client common\models\Client */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['client/reset-password', 'token' => $client->password_reset_token]);
?>
Hello <?= Html::encode($client->name) ?>,
Follow the link below to reset your password:
<?= Html::a(Html::encode($resetLink), $resetLink) ?>