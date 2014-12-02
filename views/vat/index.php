<?php
/* @var $this VatController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Vats',
);

$this->menu=array(
	array('label'=>'Create Vat', 'url'=>array('create')),
	array('label'=>'Manage Vat', 'url'=>array('admin')),
);
?>

<h1>VAT settings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
