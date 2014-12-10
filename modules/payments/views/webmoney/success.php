<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('credits', 'Your payment is completed successfully!');
$this->breadcrumbs = array(
    Yii::t('credits', 'Your payment is completed successfully!'),
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
        <h1><?php echo Yii::t('credits', 'Your payment is completed successfully!'); ?></h1>
        <div class="row"><?php echo Yii::t('credits', 'Order #'); ?> <?php print $record->formatID(); ?></div>
        <div class="row"><?php echo Yii::t('credits', 'Sum'); ?>:  $<?php print $record->summ; ?> (<?php print $record->outSum ?> <?php echo Yii::t('credits', 'RUR'); ?>)</div>
        <div class="row"><?php echo Yii::t('credits', 'Date'); ?>: <?php print $record->date; ?></div>
        <h2><?php echo Yii::t('credits', 'Your current balance is:'); ?> $<?php print $user->getFormatSumm(); ?></h2>
    </div>
</div>