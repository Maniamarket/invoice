<?php
use yii\helpers\Html;

/* @var $this ServiceController */
/* @var $model Service */
?>

<div class="view">

	<b><?php echo Html::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo Html::a(Html::encode($model->id), array('view', 'id'=>$model->id)); ?>
	<br />

	<b><?php echo Html::encode($model->getAttributeLabel('name')); ?>:</b>
	<?php echo Html::encode($model->name); ?>
	<br />


</div>