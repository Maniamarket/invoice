<?php
/* @var $this CompanyController */
/* @var $data Company */
?>



<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
      <?php echo CHtml::image(Yii::app()->params['imagePath'].$data->logo,'company'); ?>	
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
    <?php echo CHtml::encode($data->country); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
    <?php echo CHtml::encode($data->city); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
    <?php echo CHtml::encode($data->street); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('post_index')); ?>:</b>
    <?php echo CHtml::encode($data->post_index); ?>
    <br />

   
    <b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
    <?php echo CHtml::encode($data->phone); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('web_site')); ?>:</b>
    <?php echo CHtml::encode($data->web_site); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('mail')); ?>:</b>
    <?php echo CHtml::encode($data->mail); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('vat_number')); ?>:</b>
    <?php echo CHtml::encode($data->vat_number); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('activity')); ?>:</b>
    <?php echo CHtml::encode($data->activity); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('resp_person')); ?>:</b>
    <?php echo CHtml::encode($data->resp_person); ?>
    <br />
</div>