<?php
/* @var $this VatController */
/* @var $model Vat */

$this->breadcrumbs=array(
	'Vats'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vat', 'url'=>array('index')),
	array('label'=>'Create Vat', 'url'=>array('create')),
	array('label'=>'View Vat', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vat', 'url'=>array('admin')),
);
?>

<h1>Update VAT <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>