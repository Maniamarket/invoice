<style type="text/css">
    .grid-view table.items td{
        text-align: center;
    }
</style>
<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('payment', 'Payment History');
$this->breadcrumbs = array(
    Yii::t('payment', 'Payment History'),
);
?>

<div class="page">
    <h1 class="page__tit"><?php echo Yii::t('payment', 'Payment History'); ?></h1>
    <div class="grid_2">
        <?php
        $this->widget('ext.LeftMenu.LeftMenu');
        ?>
    </div>
    <div class="grid_10 content_block_3">
        <p>
            <?php echo Yii::t('payment', 'You can use the comparison operators (<, <=,>,> =, <> or =) at the beginning of each of the search values to narrow your search.'); ?>
        </p>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'transactions-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'columns' => array(
                array(
                    'name' => 'id',
                    'value' => 'PaymentHistory::model()->formatID($data->id)'
                ),
                array(
                    'name' => 'summ',
                    'type' => 'raw',
                    'value' => array($this, 'renderSumm'),
                ),
                'curr',
                'date',
                array(
                    'header' => Yii::t('payment', 'Status'),
                    'name' => 'complete',
                    'value' => '($data->complete) ? Yii::t("payment", "Payment is completed") : Yii::t("payment", "Canceled")'
                ),
            ),
        ));
        ?>
    </div>
</div>