<?php
/* @var $this TaxController */
/* @var $model Tax */

$this->breadcrumbs=array(
	'Taxes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Tax', 'url'=>array('index')),
	array('label'=>'Manage Tax', 'url'=>array('admin')),
);
?>

<h1>Create Tax</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>