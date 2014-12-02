<?php
/* @var $this InvoiceController */
/* @var $model Invoice */


$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Invoice', 'url'=>array('index')),
	array('label'=>'Create Invoice', 'url'=>array('create')),
	array('label'=>'Update Invoice', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Invoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);
?>

<h1>View Invoice #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'name',
		'company',
		'price',
		'pay',
		'type',
	),
)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice_paying_form',
	'enableAjaxValidation'=>false,
)); ?>

<?php if(empty(CHtml::encode($model->pay))) : ?>
<p>Pay with :</p> <?php echo $form->dropDownList($model,'type', 
			    array('empty'=>'--Select Service--'),
				   array('1'=>'PayPal',
				    '2'=>'Visa/Master card',
				    '3'=>'Credits'));
	?>
	<div class="row buttons">
	    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

	
	<?php endif; ?>
<?php $this->endWidget(); ?>
