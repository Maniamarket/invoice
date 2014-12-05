<?php
$this->title=Yii::$app->name . ' - Client Settings Update';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?php echo Yii::t('lang', 'ClientSettingHeaderText'); ?></h1>

<?php echo $this->context->renderPartial('_form', array('model'=>$model)); ?>


