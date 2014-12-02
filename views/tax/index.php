<?php
/* @var $this TaxController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	Yii::t('lang', 'TaxHeaderText'),
);
/*
$this->menu=array(
	array('label'=>'Create Tax', 'url'=>array('create')),
	array('label'=>'Manage Tax', 'url'=>array('admin')),
);
 * 
 */
?>

<h1><?php echo Yii::t('lang', 'TaxHeaderText'); ?></h1>

<?php /*$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>

    <div class="row">
	<?php echo CHtml::link(Yii::t('lang', 'TaxVATSettingText'),array('vat/admin')); ?>
    </div>
    </br>
    <div class="row">
	<?php echo CHtml::link(Yii::t('lang', 'TaxSettingText'),array('tax/admin')); ?>
    </div>
    