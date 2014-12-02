<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('lang','ClientsHeaderText'),
	
);

$this->menu=array(
	array('label'=>Yii::t('lang','ClientViewText'), 'url'=>array('index')),
	array('label'=>Yii::t('lang','ClientCreateText'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo Yii::t('lang','ClientsHeaderText'); ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		//'password',
		'name',
		//'register_date',
		//'last_login',
		/*
		'is_on',
		'role',
		'parent_id',
		'country',
		'city',
		'street',
		'post_index',
		'phone',
		'web_site',
		'mail',
		'vat_number',
		'activity',
		'resp_person',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
