<?php
$this->pageTitle = Yii::$app->name . ' - ' . Yii::t('mypurse', 'My Purse');
$paymentSystems = PaymentSystem::getDropDownListData();
$payment_system_id = key($paymentSystems);
?>

<div class="block_title">
    <h1><?php print Yii::t('menu', 'Home') . " / " . Yii::t('menu', 'profile') . " / " . Yii::t('menu', 'my purse'); ?></h1>
</div>


<div class="floatlert">
    <div class="webmaster_links fli">
        <?= CHtml::link(Yii::t('menu', 'Profile'), array("/user/profile"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'My Purse'), array("/mypurse/info"), array('class' => 'submit active')) ?>
        <?= CHtml::link(Yii::t('menu', 'Withdraw Money'), array("/mypurse/withdraw"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Transfer Money'), array("/mypurse/transfer"), array('class' => 'submit')) ?>     
    </div>
</div>
<div class="cl"></div>

<div class="notise">
    <?php $this->renderPartial('//layouts/messages'); ?>
</div>
<div class="cl"></div>

<div id="webmaster_box">
    <div class="page_wrapper">
        <div class="page_header">            
            <h1 class="nli">
                <?php print Yii::t('mypurse', 'Depositing'); ?>
                <div class="balance rl"><?php print Yii::t('mypurse', 'Your Balance') . ": $" . $user->balance; ?></div>
            </h1>
        </div>
        <div class="cl"></div>
        <div class="page_content">
            <div class="mypurse-form">
                <?php $form = $this->beginWidget('CActiveForm'); ?>
                <div class="pay_sys_select">          
                    <ul>
                        <?php foreach ($paymentSystems as $sis_id => $sis_name) { ?>
                            <?php $active = ''; ?>
                            <?php if ($sis_id == $payment_system_id): ?>
                                <?php $active = 'active'; ?>
                            <?php endif; ?>
                            <li>
                                <div id="<?= $sis_id; ?>" class="payment_systems <?= $active; ?>"> 
                                    <?= CHtml::image("/images/webmaster/$sis_name.png", $sis_name); ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php echo $form->hiddenField($payForm, 'payment_system_id', array('value' => $payment_system_id, 'id' => 'payment_system_id')); ?>
                </div>
                <div class="cl"></div>

                <div class="row info-line">
                    <?php print Yii::t('mypurse', 'Minimum depositing amount') . ' $25'; ?>
                </div>
                <div class="cl"></div>

                <div class="row">
                    <?php echo $form->labelEx($payForm, 'amount'); ?>
                    <?php echo $form->textField($payForm, 'amount', array('class' => 'text')); ?>
                    <?php echo $form->error($payForm, 'amount'); ?>
                </div>
                <div class="cl"></div>

                <div class="buttons_add">
                    <?php echo CHtml::submitButton(Yii::t('mypurse', 'Go to payment'), array('class' => 'submit')); ?>
                </div>
                <div class="cl"></div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <div class="cl"></div>

    <div class="horisontal-delimetr"></div>
    <div class="horisontal-delimetr"></div>
    <div class="cl"></div>

    <div class="page_wrapper">
        <div class="page_header">            
            <h1 class="nli">
                <?php print Yii::t('mypurse', 'Last payments'); ?>
            </h1>
        </div>
        <div class="cl"></div>
        <div class="page_content">
            <div class="mypurse-table">             
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'last-payments',
                    'dataProvider' => $model->searchLast(),
                    //'enableSorting' => false,
                    'filter' => $model,
                    'ajaxUpdate' => false,
                    'template' => '{items}<div class="cl"></div><div class="mb_10">{pager}<div class="cl"></div></div><div class="cl"></div>',
                    'columns' => array(
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Date') . '</div>',
                            'name' => 'date',
                            'filter' => $this->isManager ? '<div class="styled-input">' . CHtml::textField('PaymentHistory[date]', $model->date) . '</div>' : false,
                            'htmlOptions' => array('class' => 'w200 text_left')
                        ),
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Description') . '</div>',
                            'name' => 'description',
                            'value' => '$data->getDescription()',
                            'filter' => $this->isManager ? '<div class="styled-input">' . CHtml::textField('PaymentHistory[description]', $model->description) . '</div>' : false,
                            'htmlOptions' => array('class' => 'text_left')
                        ),
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Amount') . '</div>',
                            'name' => 'amount',
                            'type' => 'raw',
                            'value' => '$data->getAmount()',
                            'filter' => $this->isManager ? '<div class="styled-input">' . CHtml::textField('PaymentHistory[amount]', $model->amount) . '</div>' : false,
                            'htmlOptions' => array('class' => 'w100 text_left')
                        ),
                        array(
                            'header' => '<div>' . Yii::t('mypurse', 'Status') . '</div>',
                            'name' => 'complete',
                            'type' => 'raw',
                            'value' => array($this, 'renderComplete'),
                            'filter' => $this->isManager ? '<div class="styled-select">' . $model->getStatusFilter() . '</div>' : false,
                            'htmlOptions' => array('class' => 'w100')
                        ),
                    ),
                ));
                ?>
                <div class="cl"></div>

                <div class="payments-history">
                    <div class="row buttons">
                        <?php print CHtml::link(Yii::t('mypurse', 'Payments history'), array('history'), array('class' => 'styling')); ?>
                    </div>
                    <div class="cl"></div>
                </div>
                <div class="cl"></div>
            </div>
        </div>
    </div>
    <div class="cl"></div>
</div>
<div class="cl"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.payment_systems').click(function() {
            var id = $(this).attr('id');
            //switch active button
            $('#payment_system_id').val(id);

            $('.pay_sys_select').find('div').each(function(key, element) {
                $(element).removeClass('active');
            });
            $(this).addClass("active");
        });
    });
</script>