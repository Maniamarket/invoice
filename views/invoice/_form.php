<?php
/* @var $this InvoiceController */
/* @var $model Invoice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	<div id ='service'>
	    <div class="row">
		    <?php echo $form->labelEx($model,'service'); ?>
		    <?php echo $form->dropDownList($model,'service[]', MyHelper::getService(),
			    array('empty' => '--Select Service--'));?>	
		    <?php echo $form->error($model,'service[]'); ?>
		    <?php echo CHtml::link('Add new service','#',
			array('class'=>'linkClass','onclick'=>'addNewService()'));
		    ?>
		
	    </div>
	    
	</div>
	<div id='newService'></div>
	<script>
    function addNewService() {
	    var ddlist = document.getElementById('service').innerHTML;
	    var newData = document.getElementById('newService').outerHTML;
	    //alert(newData);
	    document.getElementById('newService').innerHTML = ddlist+''+newData;
	    
	    //alert(ddlist);
    }
  </script>
	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id', MyHelper::getUsers());?>	
		<?php echo $form->error($model,'user_id'); ?>
	</div>
	
	
	
	<div class="row">
	      
	<?php echo $form->labelEx($model, 'date'); ?>
	    
	    <?php /*Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
		$this->widget('CJuiDateTimePicker',array(
		    'model'=>$model, //Model object
		    'attribute'=>'date', //attribute name
		    'mode'=>'datetime', //use "time","date" or "datetime" (default)
		    'options'=>array(), // jquery plugin options
		));*/
	    ?>
	    
	    <?php
	    
	    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'name' => 'Invoice[date]',		
		// additional javascript options for the date picker plugin
		'options' => array(
		    'showAnim' => 'fold',
		),
		'htmlOptions' => array(
		    'style' => 'height:15px;'
		),
	    ));/**/
	    
	?>
	    <?php echo $form->error($model, 'date'); ?>
    </div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'company'); ?>
		<?php echo $form->dropDownList($model,'company', MyHelper::getCompanyOptions());?>	
		<?php echo $form->error($model,'company'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); 
		?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'currency'); ?>
		<?php echo $form->dropDownList($model,'currency', Yii::app()->params['currency']); ?>
		<?php echo $form->error($model,'currency'); ?>
	</div>
  
	<div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php echo $form->textField($model,'count',array('value' => '1')); 
		?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vat'); ?>
		<?php echo $form->dropDownList($model,'vat', MyHelper::getVAT(),array(
        'empty'=>'no VAT'));?>	
		
		<?php echo $form->error($model,'vat'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount'); 
		?>
		<?php echo $form->error($model,'discount'); ?>
	</div>
	<div class="row buttons">
	    <?php echo CHtml::button(Yii::t('lang','InvoicePriceCalcText'),array('title'=>"Calculate Price",'onclick'=>'js:calcPrice();'));?>
	</div>
	<p><?php echo Yii::t('lang','InvoiceToPayText'); ?> : <b><span id='fullprice'></span></b></p>
	<div class="row buttons">
	    <p><?php echo Yii::t('lang','InvoicePayWithText'); ?> :
		<?php echo CHtml::radioButton('payOpt', true, array('value'=>'yes', 'id'=>'payWithPaypal', 'uncheckValue'=>null)); ?> Paypal 
		<?php echo CHtml::radioButton('payOpt', false, array('value'=>'yes', 'id'=>'payWithCard', 'uncheckValue'=>null)); ?> Credit Card
		<?php echo CHtml::submitButton(Yii::t('lang','InvoicePayText'), array('name' => 'pay')); ?>
	    </p>
	</div>
  <script>
      function calcPrice() {
	 //alert(document.getElementById('Invoice_price').value);
	price = document.getElementById('Invoice_price').value;
	count = document.getElementById('Invoice_count').value;
	lastPrice = price*count;  
	
	com = lastPrice * 12/100;
	  lastPrice += com;
	  
	  vat = document.getElementById('Invoice_vat').value;
	  if(vat != 0) {
	      lastPrice += lastPrice*vat/100;
	  }
	  discount = document.getElementById('Invoice_discount').value;
	  if(discount != 0) {
	      lastPrice -= lastPrice*discount/100;
	  }
	  //lastPrice = price*count*vat/100*12/100*discount/100;
	// alert(lastPrice);
	 //document.getElementById('fullprice').value = lastPrice;
	 //Math.round(lastPrice).toFixed(2);
	 document.getElementById('fullprice').innerHTML = Math.round(lastPrice).toFixed(2);
	  
	  
      }
  </script>
	<div class="row buttons">
	    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('lang','InvoiceSaveText') : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->