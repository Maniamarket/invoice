<?php $this->pageTitle = Yii::app()->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Withdraw Money'); ?>
<?php //Yii::app()->clientScript->registerScript(__CLASS__ . '#mypurse', '$(document).ready(function() {$(".open_dialog").dialog("open");});', CClientScript::POS_END);    ?>
<?php
/** Start Widget * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-mypurse',
    'options' => array(
        'title' => Yii::t('mypurse', 'Terms of translation'),
        'autoOpen' => false,
        'modal' => 'true',
        'width' => 460,
        'show' => array(
            'effect' => 'blind',
            'duration' => 1000,
        ),
        'hide' => array(
            'effect' => 'explode',
            'duration' => 500,
        ),
    ),
));

echo '<div class="mypurse_terms">
        <p>' . Yii::t('mypurse', 'Money transfer between accounts within the RTBsystem\'s system implies no commission.') . '</p>
        <p>' . Yii::t('mypurse', 'Money can be transferred only between participants of the RTBsystem\'s system.') . '</p>
        <p>' . Yii::t('mypurse', 'Cancelling a money transfer will be impossible.') . '</p>
        <p>' . Yii::t('mypurse', 'You have to be aware of all your operations conducted within the RTBsystem\'s system.') . '</p>            
        <span class="close_dialog" onclick="$(\'#dialog-mypurse\').dialog(\'close\');return false;">' . Yii::t('mypurse', 'Close') . '</span> 
    </div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
/** End Widget * */
?>

<div class="block_title">
    <h1><?php print Yii::t('menu', 'Home') . " / " . Yii::t('menu', 'profile') . " / " . Yii::t('mypurse', 'transfer money'); ?></h1>
</div>

<div class="floatlert">
    <div class="webmaster_links fli">
        <?= CHtml::link(Yii::t('menu', 'Profile'), array("/user/profile"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'My Purse'), array("/mypurse/info"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Withdraw Money'), array("/mypurse/withdraw"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Transfer Money'), array("/mypurse/transfer"), array('class' => 'submit active')) ?>

    </div>
</div>
<div class="cl"></div>

<?php $aFlashes = Yii::app()->user->getFlashes(); ?>
<?php if ($aFlashes): ?>
    <div class="notise">
        <?php $this->renderPartial('//layouts/messages'); ?>
    </div>
    <div class="cl"></div>
<?php endif; ?>

<div id="webmaster_box">
    <div class="page_wrapper">
        <div class="page_header">            
            <h1 class="nli">
                <?php print Yii::t('mypurse', 'Transfer money between system accounts'); ?>
                <div class="balance rl"><?php print Yii::t('mypurse', 'Available for transfer') . ": $" . (($owner->balance >= PaymentOutput::PO_MINIMUM) ? $owner->balance : "0,000"); ?></div>
            </h1>
        </div>
        <div class="cl"></div>
        <div class="page_content">
            <div class="mypurse-form">   
                <div id="webmaster_box">
                    <div class="form full">
                        <?php $form = $this->beginWidget('CActiveForm'); ?>

                        <div class="row info-line">
                            <?php print Yii::t('mypurse', 'Minimum depositing amount') . ' $25'; ?>
                        </div>
                        <div class="cl"></div>

                        <div class="row">
                            <?php echo $form->labelEx($model, 'amount'); ?>
                            <?php echo $form->textField($model, 'amount', array('class' => 'text')); ?>
                            <?php echo $form->error($model, 'amount'); ?>
                        </div>
                        <div class="cl"></div>

                        <div class="row">
                            <?php echo $form->labelEx($model, 'email'); ?>
                            <?php echo $form->emailField($model, 'email', array('class' => 'text')); ?>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                        <div class="cl"></div>

                        <div class="row">
                            <?php echo $form->labelEx($model, 'info'); ?>
                            <?php echo $form->textArea($model, 'info', array('class' => 'text')); ?>
                            <?php echo $form->error($model, 'info', array('class' => 'errorMessage l165')); ?>
                        </div>
                        <div class="cl"></div>



                        <div class="row accept">
                            <?= $form->checkBox($model, 'accept'); ?>
                            <div class="accept-text">
                                <?= Yii::t('mypurse', 'With ') ?>                            
                                <?= '<span class="open_dialog" onclick="$(\'#dialog-mypurse\').dialog(\'open\');return false;">' . Yii::t('mypurse', 'terms of the transfer') . '</span>' ?>
                                <?= Yii::t('mypurse', 'familiar. Introduction details are correct. Transfer of funds confirm.') ?>                            
                            </div>
                            <?php echo $form->error($model, 'accept'); ?>
                        </div>
                        <div class="cl"></div>

                        <div class="buttons_add">
                            <?php echo CHtml::submitButton(Yii::t('mypurse', 'Send Money'), array('class' => 'submit')); ?>
                        </div>
                        <div class="cl"></div>

                        <?php $this->endWidget(); ?>
                    </div> 
                </div>
                <div class="cl"></div>
            </div>            
        </div>
    </div>
    <div class="cl"></div>
</div>
<div class="cl"></div>
