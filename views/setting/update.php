<?php
$this->title = Yii::t('app', 'Settings Update');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="title"><?php echo $this->title; ?></h1>

<?php echo $this->context->renderPartial('_form', ['model'=>$model, 'user'=>$user]); ?>


