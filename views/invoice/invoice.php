
<h1>Invoice - #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'date',
		'name',
		'service',
		'user',
		'company',
		'price',
		'count',
		'vat',
		'type',
		'created_date',
	),
)); ?>


