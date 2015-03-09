<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Translit;

$lt = $isTranslit ? 'en-US' : Yii::$app->language;
$country_name  = ($model->company->country) ? $model->company->country->name : 'no';
?>
<style>
    h1, h2, h3, p, table, span {
     color: #575756;
    }
    th {
        font-size: 20px;
        font-weight: bold;
    }
    .text {
        display: block;
        font-size: 20px;
/*        line-height: 14px;*/
        width: 150px;
    }
    .form-control {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 20px;
        width: 210px;
        text-align: left;
/*        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        */
    }
</style>
<body><div>
    <table  style="font-size: 10px; text-align: left; border-bottom: 1px solid #e2e2e2;">
        <tr>
            <td>
            <?php
                if (!empty($receipt->logo)) {
                    $logo = '/images/avatars/'.$receipt->logo;
                    echo '<img src="'.$logo.'" width="300" />';
//                $pdf->Image($logo, '15', '25', '20', '0', '', '', '', true, 150);
                }
             ?>
            </td>
            <td style="text-align: right; font-size: 20px; line-height: 20px;"><?php
                echo $isTranslit ? Translit::Translit($receipt->title) : $receipt->title;
                echo '<br />';
                echo $isTranslit ? Translit::Translit($receipt->description) : $receipt->description;
             ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    </table>
    <table>
        <tr><td colspan="4">
                <h1 style="font-size: 30px;"><?= Yii::t('app', 'Transaction movement') ?></h1>
            </td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td class="text" style="text-align: left;">
                <?= Yii::t('invoice','From') ?>
            </td>
            <td  class="form-control">
                &nbsp;&nbsp;Id: <?= $model->client->id ?>
            </td>
            <td style="width: 50px;">&nbsp;</td>
            <td class="form-control">
                &nbsp;&nbsp;<?= $isTranslit ? Translit::Translit($model->client->name) : $model->client->name ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td class="text" style="text-align: left;">
                <?= Yii::t('invoice','To') ?>
            </td>
            <td  class="form-control">
                &nbsp;&nbsp;Id: <?= $model->company->id ?>
            </td>
            <td style="width: 50px;">&nbsp;</td>
            <td class="form-control">
                &nbsp;&nbsp;<?= $isTranslit ? Translit::Translit($model->company->name) : $model->company->name ?>
            </td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td class="text">
                <?= Yii::t('invoice','Amount') ?>
            </td>
            <td  class="form-control">
                &nbsp;&nbsp;<?= $model->total_price ?>&euro;
            </td>
            <td style="width: 50px;">&nbsp;</td><td></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td class="text">
                <?= Yii::t('invoice','Date') ?>
            </td>
            <td  class="form-control">
                &nbsp;&nbsp;<?= date('d/m/Y', strtotime($model->date)) ?>
            </td>
            <td style="width: 50px;">&nbsp;</td><td></td>
        </tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr>
            <td class="text">
                <?= Yii::t('invoice','Transaction') ?>
            </td>
            <td  class="form-control">
                &nbsp;&nbsp;<?= $model->id ?>
            </td>
            <td  style="width: 50px;">&nbsp;</td><td></td>
        </tr>
        <tr><td class="text">&nbsp;&nbsp;<?= Yii::t('invoice','Number') ?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
    </table>
    <p style="font-size: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;<?= Yii::t('invoice','Transaction  Succesful') ?></p>

</div>
</body>
