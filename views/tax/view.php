<?php
/* @var $this TaxController */
/* @var $model Tax */

$this->breadcrumbs=array(
	'Taxes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Tax', 'url'=>array('index')),
	array('label'=>'Create Tax', 'url'=>array('create')),
	array('label'=>'Update Tax', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tax', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tax', 'url'=>array('admin')),
);
?>

<h1>View Tax #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from',
		'to',
		'manager',
		'admin',
	),
)); ?>
