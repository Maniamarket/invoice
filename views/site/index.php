<?php
/* @var $this SiteController */

$this->title='Billing';
?>

<h1><?php echo Yii::t('lang', 'Welcome'); ?><i><?php //echo CHtml::encode(Yii::app()->user->user_name); ?></i></h1>
<p><?php echo Yii::t('lang', 'main_page_text'); ?><b><?php if (!Yii::$app->user->isGuest) echo Yii::$app->user->identity->username; ?></b></p>

