<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div>
    <div><img src="<?php !empty($model->company->logo) ? 'images/companies/'.$model->company->logo : ''; ?>" width="150" alt="<?php echo $model->company->name ?>" /> </div>
    <h1>Invoice - #<?= Html::encode($model->id) ?></h1>
    <?= DetailView::widget([
	'model' => $model,
	'attributes' => [
	    'id',
        [
            'attribute'=>'User Name',
            'value'=>$model->user->username,
        ],
	    'date',
	    'name',
	    [
            'attribute'=>'Company Name',
            'value'=>$model->company->name,
        ],
        [
            'attribute'=>'Service Name',
            'value'=>$model->service->name,
        ],
	    'count',
	    'vat',
	    'discount',
	    'price',
	    'type',
	    'finished',
	],
    ]) ?>
</div>

