<?php $this->pageTitle = Yii::$app->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Withdraw Money'); ?>
<div class="block_title">
    <h1><?php print Yii::t('mypurse', 'My Purse') . " &raquo; " . Yii::t('mypurse', 'Withdraw Money'); ?></h1>
</div>
<div class="cl"></div>
<?php $this->renderPartial('//layouts/messages'); ?>
<div class="cl"></div>

<div class="mypurse">

    <div class="balance"><?php print Yii::t('mypurse', 'Your Balance') ?>: $<?php print $model->balance ?></div>

    <div class="form full">
        <?php $form = $this->beginWidget('CActiveForm'); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'amount'); ?>
            <?php echo $form->textField($model, 'amount', array('class' => 'text')); ?>
            <?php echo $form->error($model, 'amount'); ?>
        </div>
        <div class="cl"></div>

        <div class="row">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textField($model, 'description', array('class' => 'text')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
        <div class="cl"></div>

        <div class="row">
            <p class="note"><?php print Yii::t('mypurse', 'Funds’ withdrawal is made every first and third week of the month. The minimum withdrawal amount is ${minimum}.', array('{minimum}' => PayOutForm::PO_MINIMUM)) ?></p>
            <p class="note">Для вывода доступны следующие кошельки Z, U, E, R</p>
            <p class="note">На кошильки U, E, R сумма будет зачисленна в долларовом еквиваленте</p>
            <!--<p class="note"><?php print Yii::t('mypurse', 'Don’t forget to include all the necessary payment details in the request form: account number for «WebMoney» service, account owner`s first name, last name and patronymic name.') ?></p>-->
            <p class="note"><?php print Yii::t('mypurse', 'Once your request is processed You`ll get the e-mail notification {email}', array('{email}'=>CHtml::link($model->email, "mailto:$model->email"))) ?></p>
            <p class="note"><?php print Yii::t('mypurse', 'Thanks for doing business with us.') ?></p>
        </div>
        <div class="cl"></div>

        <div class="row buttons">
            <?php print CHtml::link(Yii::t('mypurse', 'Back to "My Purse"'), array('index'), array('class' => 'styling grey_button')); ?>
            <?php echo CHtml::submitButton(Yii::t('mypurse', 'Send Request'), array('class' => 'submit')); ?>
        </div>
        <div class="cl"></div>

        <?php $this->endWidget(); ?>
    </div>

</div>