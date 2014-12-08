<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<style>    
.image-background {
    background: url('/images/xmark.png') no-repeat center center;
    position: fixed;
    width: 100%;
    height: 350px;
    top:0;
    left:0;
    z-index: -1;
}
</style>

<?php if(empty($model->finished)) : ?>
    <div class="image-background">
<?php else : ?>
    <div class="invoice-view">
<?php endif;?>
    <h1>Invoice - #<?= Html::encode($model->id) ?></h1>
    <?= DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
	    'user_id',
	    'date',
	    'name',
	    'company_id',
	    'service_id',
	    'count',
	    'vat_id',
	    'discount',
	    'price',
	    'pay',
	    'type',
	    'finished',
	    'created_date',
	],
    ]) ?>
</div>

