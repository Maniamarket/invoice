<style type="text/css">
    .form_default div.row input.submit{
        margin-left: 210px;
    }
</style>
<?php
$this->pageTitle = Yii::$app->name . ' - Buy Credits';
$this->breadcrumbs = array(
    'Buy Credits',
);
?>
<div class="page">
<h1 class="page__tit"><?php echo Yii::t('credits', 'Update your balance using "Robokassa"'); ?></h1>
<div class="grid_2">
    <?php
    $this->widget('ext.LeftMenu.LeftMenu');
    ?>
</div>
<div class="grid_10 content_block_3">
    <div>
        <div class="align_left" style="width: 550px;">
            <?php echo Yii::t('payment', '<p>IMPORTANT: Our site currency is USD.</p> <p>If your currency is different, the payment system will automatically convert your currency to dollars.</p> <p>Please, indicate the amount of money</p>') ?>
            <p><?php echo Yii::t('user', 'Recommended for CIS'); ?></p>
        </div>
        <div class="align_right">
            <img src="<?php print Yii::$app->baseUrl; ?>/images/robokassa_mini.png" alt="robokassa" class="right15" />
        </div>
    </div>
    <div class="clear"></div>

    <?php $this->renderPartial('messages'); ?>


    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'payment-buy-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('class' => 'form_default payment_form'),
        ));
        ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'out_summ'); ?>
            <?php echo $form->textField($model, 'out_summ', $model->htmlOptions()); ?>
            <?php echo $form->error($model, 'out_summ'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'in_curr'); ?>
            <?php echo $model->GetCurrenciesDropDownList() ?>
            <?php echo $form->error($model, 'in_curr'); ?>
        </div>

        <div class="row">
            <div id="addtitionalInfo"></div>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton(Yii::t('credits', 'Go to payment'), array('class' => 'submit')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>

<?php /* Google AdWords для действия "Пополнение баланса" */ ?>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 990620359;
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "amBrCJmrrgQQx9Wu2AM";
    var google_conversion_value = 0;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/990620359/?value=0&amp;label=amBrCJmrrgQQx9Wu2AM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
</div>