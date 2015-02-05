<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Translit;

$lt = $isTranslit ? 'en-US' : Yii::$app->language;
$country_name  = ($model->company->country) ? $model->company->country->name : 'no';
?>
<div>
    <div style="width: 100%; height: 200px;"></div>
    <h2 style="text-transform: uppercase;"><?= $isTranslit ? Translit::Translit($model->company->name) : $model->company->name ?></h2>

    <span><b><?= Yii::t('invoice', 'Country', [], $lt) ?>: </b><?= $isTranslit ? Translit::Translit($country_name ) : $country_name ?></span>
    <p>&nbsp;</p>
    <table>
        <tr><td><b><?= Yii::t('invoice', 'Seller', [], $lt) ?>: </b><?= $model->user->username ?></td>
            <td style="text-align: right;"><b><?= Yii::t('invoice', 'Buyer', [], $lt) ?>: </b><?= $isTranslit ? Translit::Translit($model->client->name):$model->client->name ?></td></tr>
    </table>
    <h3 style="text-align: center;"><b><?= Yii::t('invoice', 'Invoice', [], $lt) ?> №: </b >MM100<?= $model->id ?></h3>
    <p>&nbsp;</p>
    <table>
        <tr>
            <th><b><?= Yii::t('invoice', 'Service', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Price', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Count', [], $lt) ?></b></th>
            <th style="text-align: right"><b><?= Yii::t('invoice', 'Clear Price', [], $lt) ?></b></th>
        </tr>
        <tr>
            <td><?= $isTranslit ? Translit::Translit($model->service->name) : $model->service->name ?></td>
            <td><?= $model->price_service ?></td>
            <td><?= $model->count ?></td>
            <td style="text-align: right"><?= $model->price_service*$model->count ?></td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
            <td colspan="4" style="text-align: right">
                <span><b><?= Yii::t('invoice', 'Discount', [], $lt) ?>: </b><?= $model->discount ?>%</span><br />
                <span><b><?= Yii::t('invoice', 'Vat', [], $lt) ?>: </b><?= $model->vat ?>%</span><br />
                <span style="text-decoration: underline;"><b><?= Yii::t('invoice', 'Surtax', [], $lt) ?>: </b><?= $model->tax ?>%</span><br />
                <span><b><?= Yii::t('invoice', 'Total', [], $lt) ?>: </b><?= $model->price ?></span><br />
            </td>
        </tr>
    </table>
</div>

