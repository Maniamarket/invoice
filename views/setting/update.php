<h1><?php echo Yii::t('lang', 'SettingHeaderText'); ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tax-grid',
	'dataProvider'=>Tax::model()->search(),	
	'columns'=>array(		
		'from',
		'to',
		'manager',
		'admin',		
	),
)); ?>