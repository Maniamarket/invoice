<?php
$this->title=Yii::$app->name . ' - Client Settings Update';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="title"><?php echo Yii::t('app', 'Client Profile'); ?></h1>

<?php echo $this->context->renderPartial('_form', array('model'=>$model)); ?>


