<style type="text/css">
    .form_default div.row input.submit{
        margin-left: 210px;
    }
    .profile_balance .paypal_mini{
        margin-left: 555px;
        position: absolute;
    }
</style>
<?php
$this->pageTitle = Yii::app()->name . ' - Buy Credits';
$this->breadcrumbs = array(
    'Buy Credits',
);
?>
<div align='center'  id="profile_title" ><?php echo Yii::t('credits', 'Update your balance using "Interkassa"'); ?><br /><br /></div>
<div class="grid_2">
    <?php
    $this->widget('ext.LeftMenu.LeftMenu');
    ?>
</div>

<div class="grid_10 content_block_3 profile_balance">
    <div>
        <div class="align_left" style="width: 550px;">
            <p><?php echo Yii::t('user', 'Recommended for CIS'); ?></p>
            <p><?php echo Yii::t('credits', 'IMPORTANT! Currency - the U.S. dollar.'); ?></p>
            <p><?php echo Yii::t('credits', 'If you are using any other currency will be automatically converted at the exchange rate.'); ?></p>
            <p><?php echo Yii::t('credits', 'In case if your USD wallet is empty, the website will convert other currencies on your Webmoney wallets into dollars.'); ?></p>
        </div>
        <div class="paypal_mini">
            <img src="<?php print Yii::app()->baseUrl; ?>/images/interkassa-mini.png" alt="interkassa" />
        </div>
    </div>
    <div class="clear"></div>

    <?php $this->renderPartial('messages'); ?>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'interkassa-form',
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