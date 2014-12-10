<?php
$this->pageTitle = Yii::app()->name . ' - Платеж завершен';
$this->breadcrumbs = array(
    'Платеж завершен',
);
?>
<div align='center'  id="profile_title" ><?php echo Yii::t('credits', 'Update your balance using "WebMoney"'); ?><br /><br /></div>
<div class="grid_2">
    <?php
    $this->widget('ext.LeftMenu.LeftMenu');
    ?>
</div>

<div class="grid_10 content_block_3 profile_balance">
    <div align="center">
        <h1>Ошибка платежа!</h1>
    </div>
</div>