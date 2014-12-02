<?php
/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('lang', 'ServiceHeaderText'),
);

$this->menu=array(
	array('label'=>'Create Service', 'url'=>array('create')),
	array('label'=>'Manage Service', 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('lang', 'ServiceHeaderText'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
