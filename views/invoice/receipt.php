<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - ' . Yii::t('app', 'Transaction movement');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row" id="receipt-head">
    <div class="col-md-5"><img src="<?= '/'.Yii::$app->params['avatarPath'].$receipt->logo ?>" /></div>
    <div class="col-md-5 receipt-desc">
        <?= $receipt->title ?><br />
        <?= $receipt->description ?>
    </div>
</div>
<div id="receipt-body">
    <div class="row">
        <div class="col-md-11"><h1><?= Yii::t('app', 'Transaction movement') ?></h1></div>
        <div class="clearfix"></div>
        <div class="col-md-2">From</div>
        <div class="col-md-4"><p class="form-control">ID: 12548769</p></div>
        <div class="col-md-5 pull-right">
            <p class="form-control">ID: 12548769</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">To</div>
        <div class="col-md-4"><p class="form-control">ID: 12548769</p></div>
        <div class="col-md-5 pull-right">
            <p class="form-control">ID: 12548769</p>
        </div>
    </div>
</div>


