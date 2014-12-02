<?php
/* @var $this VatController */
/* @var $model Vat */

$this->breadcrumbs=array(
	'Vats'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vat', 'url'=>array('index')),
	array('label'=>'Manage Vat', 'url'=>array('admin')),
);
?>

<h1>Create VAT</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>