<?php
/* @var $this TaxController */
/* @var $model Tax */

$this->breadcrumbs=array(
	'Taxes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tax', 'url'=>array('index')),
	array('label'=>'Create Tax', 'url'=>array('create')),
	array('label'=>'View Tax', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Tax', 'url'=>array('admin')),
);
?>

<h1>Update Tax <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>