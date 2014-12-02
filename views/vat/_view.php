<?php
/* @var $this VatController */
/* @var $data Vat */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percent')); ?>:</b>
	<?php echo CHtml::encode($data->percent); ?>
	<br />


</div>