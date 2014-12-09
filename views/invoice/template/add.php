<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>
<div>
    <div style="width: 100%; height: 200px;"></div>
    <h2 style="text-transform: uppercase;"><?= $model->company->name ?></h2>
    <h3 style="text-align: center;"><b>Счет-фактура №: </b >MM100<?= $model->id ?> от <?= $model->date ?></h3>
    <span><b>Продавец: </b><?= $model->user->name ?></span><br />
    <span><b>Адрес компании: </b><?= $model->company->country.', '.$model->company->city.', '.$model->company->street ?></span><br />
    <span><b>Покупатель: </b><?= $model->client->name ?></span><br />
    <span><b>Адрес покупателя: </b><?= $model->client->country.', '.$model->client->city.', '.$model->client->street ?></span>
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

