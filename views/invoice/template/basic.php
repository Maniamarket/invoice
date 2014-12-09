<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div>
    <div style="width: 100%; height: 200px;"></div>
    <h2 style="text-transform: uppercase;"><?= $model->company->name ?></h2>
    <span><b>Страна: </b><?= $model->company->country ?></span>
    <p>&nbsp;</p>
    <table>
        <tr><td><b>Продавец: </b><?= $model->user->username ?></td><td style="text-align: right;"><b>Покупатель: </b><?= $model->client->name ?></td></tr>
    </table>
    <h3 style="text-align: center;"><b>Счет-фактура №: </b >MM100<?= $model->id ?></h3>
    <p>&nbsp;</p>
    <table>
        <tr>
            <th><b>Наим. услуги</b></th>
            <th><b>Цена</b></th>
            <th><b>Кол-во</b></th>
            <th style="text-align: right"><b>Чистая цена</b></th>
        </tr>
        <tr>
            <td><?= $model->service->name ?></td>
            <td><?= $model->price_service ?></td>
            <td><?= $model->count ?></td>
            <td style="text-align: right"><?= $model->price_service*$model->count ?></td>
        </tr>
    </table>
    <hr />
    <table>
        <tr>
            <td colspan="4" style="text-align: right">
                <span><b>Скидки: </b><?= $model->discount ?>%</span><br />
                <span><b>НДС: </b><?= $model->vat ?>%</span><br />
                <span style="text-decoration: underline;"><b>Под. налог: </b><?= $model->tax ?>%</span><br />
                <span><b>Итого: </b><?= $model->price ?></span><br />
            </td>
        </tr>
    </table>
</div>

