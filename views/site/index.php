<?php
/* @var $this SiteController */

$this->title = 'Billing';
?>

<h1><?= Yii::t('app', 'Welcome'); ?><i><?php //echo Yii::$app->user->identity->role;     ?></i></h1>
<?php if (!Yii::$app->user->isGuest): ?>
    <p><?= Yii::t('app', 'main_page_text'); ?><b><?= Yii::$app->user->identity->username; ?></b>, вы вошли как <?= Yii::$app->user->identity->role; ?></b></p>
    <?php
  endif ?>
