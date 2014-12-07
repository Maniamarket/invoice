<?php
$this->title=Yii::$app->name . ' - Settings Update';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Yii::t('app', 'SettingHeaderText'); ?></h1>

<?php echo $this->context->renderPartial('_form', array('model'=>$model)); ?>


