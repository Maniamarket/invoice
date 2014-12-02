<?php
/* @var $this InvoiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Invoices',
);

$this->menu=array(
	array('label'=>'Create Invoice', 'url'=>array('create')),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);
?>

<h1>Invoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
