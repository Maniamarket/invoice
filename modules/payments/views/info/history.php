<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('mypurse', 'My Purse') . ": " . Yii::t('mypurse', 'Payment History');
?>
<div class="block_title">    
    <h1><?php print Yii::t('menu', 'Home') . " / " . Yii::t('menu', 'profile') . " / " . Yii::t('menu', 'my purse') . " / " . Yii::t('mypurse', 'payment history'); ?></h1>

</div>
<div class="cl"></div>
<?php $this->renderPartial('//layouts/messages'); ?>
<div class="cl"></div>


<div class="floatlert">
    <div class="webmaster_links fli">
        <?= CHtml::link(Yii::t('menu', 'Profile'), array("/user/profile"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'My Purse'), array("/mypurse/info"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Withdraw Money'), array("/mypurse/withdraw"), array('class' => 'submit')) ?>
        <?= CHtml::link(Yii::t('menu', 'Transfer Money'), array("/mypurse/transfer"), array('class' => 'submit')) ?>     
    </div>
</div>

<div id="webmaster_box">
    <div class="page_wrapper">
        <div class="page_header">            
            <h1 class="nli">
                <?php print Yii::t('mypurse', 'Payment History'); ?>
            </h1>
        </div>
        <div class="cl"></div>
        <div class="page_content">
            <div class="mypurse-table">             
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'last-payments',
                    'dataProvider' => $model->search(),
                    //'enableSorting' => false, 
                    
                    'filter' => $model,
                    'pager' => array(
                        'header' => '<div class="pager_select">' . $this->createPageSizeSelector('sites-grid') . '</div>',
                        'prevPageLabel' => '<div class="prev_bg"><div class="arrow-left"></div></div>',
                        'nextPageLabel' => '<div class="next_bg"><div class="arrow-right"></div></div>',
                    ),
                    'template' => '{items}<div class="cl"></div><div class="mb_10">{pager}<div class="cl"></div></div><div class="cl"></div>',
                    'columns' => array(
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Date') . '</div>',
                            'name' => 'date',
                            'filter' => '<div class="styled-input">' . CHtml::textField('PaymentHistory[date]', $model->date) . '</div>',
                            'htmlOptions' => array('class' => 'w200 text_left')
                        ),
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Payment Type') . '</div>',
                            'name' => 'type',
                            'type' => 'raw',
                            'value' => '$data->getType()',                            
                            'filter' => '<div class="styled-select">' . $model->getTypeFilter() . '</div>',
                            //'filter' => '<div class="styled-input">' . CHtml::textField('PaymentHistory[date]', $model->date) . '</div>',
                            'htmlOptions' => array('class' => 'text_left')
                        ),
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Description') . '</div>',
                            'name' => 'description',
                            'value' => '$data->getDescription()',
                            'filter' => '<div class="styled-input">' . CHtml::textField('PaymentHistory[description]', $model->description) . '</div>',
                            'htmlOptions' => array('class' => 'text_left')
                        ),
                        array(
                            'header' => '<div class="text_left">' . Yii::t('mypurse', 'Amount') . '</div>',
                            'name' => 'amount',
                            'type' => 'raw',
                            'value' => '$data->getAmount()',
                            'filter' => '<div class="styled-input">' . CHtml::textField('PaymentHistory[amount]', $model->amount) . '</div>',
                            'htmlOptions' => array('class' => 'w100 text_left')
                        ),
                        array(
                            'header' => '<div>' . Yii::t('mypurse', 'Status') . '</div>',
                            'name' => 'complete',
                            'type' => 'raw',
                            'value' => array($this, 'renderComplete'),
                            'filter' => '<div class="styled-select">' . $model->getStatusFilter() . '</div>',
                            'htmlOptions' => array('class' => 'w100')
                        ),
                    ),
                ));
                ?>
                <div class="cl"></div>
            </div>
        </div>
    </div>
    <div class="cl"></div>
</div>
<div class="cl"></div>
