<style type="text/css">
    .form_default div.row input.submit{
        margin-left: 210px;
    }
    .profile_balance .paypal_mini{
        margin-left: 580px;
        position: absolute;
    }
</style>
<?php
$this->pageTitle = Yii::app()->name . ' - Buy Credits';
$this->breadcrumbs = array(
    'Buy Credits',
);
?>
<div class="page">
<h1 class="page__tit"><?php echo Yii::t('credits', 'Update your balance using "PayPal"'); ?></h1>
<div class="grid_2">
    <?php
    $this->widget('ext.LeftMenu.LeftMenu');
    ?>
</div>

<div class="grid_10 content_block_3 profile_balance">
    <div>
        <div class="align_left" style="width: 550px;">
            <p><?php echo Yii::t('user', 'Recommended for europe and america'); ?></p>
            <p><?php echo Yii::t('credits', 'IMPORTANT! Currency - the U.S. dollar.'); ?></p>
            <p><?php echo Yii::t('credits', 'If you are using any other currency will be automatically converted at the exchange rate.'); ?></p>
        </div>
        <div class="paypal_mini">
            <img src="<?php print Yii::app()->baseUrl; ?>/images/paypal_mini.gif" alt="paypal" />
        </div>
    </div>
    <div class="clear"></div>

    <?php $this->renderPartial('messages'); ?>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'paypal-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('class' => 'form_default payment_form'),
        ));
        ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'amount'); ?>
            <?php echo $form->textField($model, 'amount'); ?>
            <?php echo $form->error($model, 'amount'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('credits', 'Go to payment'), array('class' => 'submit')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
</div>