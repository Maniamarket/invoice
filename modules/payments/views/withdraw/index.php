<?php $this->pageTitle = Yii::app()->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Withdraw Money'); ?>
<?php
$paymentSystems = PaymentSystem::getDropDownListData($this->isAdmin);
$payment_system_id = key($paymentSystems);
?>
<div class="block_title">
    <h1><?php print Yii::t('menu', 'Home') . " / " . Yii::t('menu', 'profile') . " / " . Yii::t('mypurse', 'withdraw money'); ?></h1>
</div>

<div class="floatlert">
    <div class="webmaster_links fli">
        <?= CHtml::link(Yii::t('menu', 'Profile'), array("/user/profile"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'My Purse'), array("/mypurse/info"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Withdraw Money'), array("/mypurse/withdraw"), array('class' => 'submit active')) ?>
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
                <?php print Yii::t('mypurse', 'Choice system for withdraw money'); ?>
                <div class="balance rl"><?php print Yii::t('mypurse', 'Available for output') . ": $" . (($owner->balance >= PaymentOutput::PO_MINIMUM) ? $owner->balance : "0,000"); ?></div>
            </h1>
        </div>
        <div class="cl"></div>
        <div class="page_content">
            <div class="mypurse-form">
                <div class="pay_sys_select">    
                    <div id="webmaster_tabs" class="webmaster_tabs">
                        <ul id="sortable_items fl">
                            <?php
                            foreach ($paymentSystems as $sis_id => $modelName) {
                                $PaymentSystem = new $modelName;
                                $params = ($notice) ? array('method' => $modelName, 'id' => $owner->id) : array('method' => $modelName);
                                $url = $this->createAbsoluteUrl('/mypurse/withdraw/process', $params, HTTPS);

                                $PaySysName = $PaymentSystem->getName();
                                ?>
                                <?php $active = ''; ?>
                                <?php if ($sis_id == $payment_system_id): ?>
                                    <?php $active = ' active'; ?>
                                <?php endif; ?>
                                <li id="tab_<?= $sis_id; ?>" class='fl<?= $active; ?> '>     
                                    <?= CHtml::image("/images/webmaster/$PaySysName.png", $PaySysName); ?>
                                </li>
                            <?php } ?>
                        </ul> 
                        <div class="cl"></div>
                    </div>   
                </div>
                <div class="cl"></div>

                <div class="row info-line">
                    <?php print Yii::t('mypurse', 'Minimum withdrawal amount') . ' $25'; ?>
                </div>

                <div class="cl"></div>

                <div id="webmaster_box">
                    <?php foreach ($paymentSystems as $sis_id => $modelName): ?>   
                        <?php $hidden_tab = 'hidden_tab'; ?>
                        <?php if ($sis_id == $payment_system_id): ?>
                            <?php $hidden_tab = ''; ?>
                        <?php endif; ?>
                        <div id="tabs-tab_<?= $sis_id; ?>" class='tabs_box <?= $hidden_tab; ?>'>
                            <?php $this->renderPartial('pay_out_form', array('model' => $model, 'PaymentSystem' => new $modelName)); ?>  
                        </div>

                    <?php endforeach; ?>     
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
        //setup tabs
        $('#webmaster_tabs li').click(function() {
            //get tab id
            var tab_id = $(this).attr('id');
            //switch active button
            $('#webmaster_tabs').find('li').each(function(key, element) {
                $(element).removeClass('active');
            });
            $(this).addClass("active");
            //switch active button
            $('#webmaster_box').find('div.tabs_box').each(function(key, element) {
                $(element).hide();
            });
            $('#tabs-' + tab_id).show();
        });
    });
</script>