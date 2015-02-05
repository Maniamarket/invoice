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
</style>
<body><div><table  style="font-size: 10px; text-align: left;">
        <tr>
            <td width="200">
            <?php
                if (!empty($model->company->logo)) {
                    $logo = '/images/companies/'.$model->company->logo;
                    echo '<img src="'.$logo.'" width="200" />';
//                $pdf->Image($logo, '15', '25', '20', '0', '', '', '', true, 150);
                }
             ?>
            </td>
            <td width="50" style="text-align: center;"><img src="images/template1/address.png" /></td>
            <td width="140"><?php
                if (!empty($model->company->street)) {
                    echo $model->company->street;
                }
                if (!empty($model->company->city)) {
                    echo ', '.$model->company->city;
                }
                if (!empty($model->company->post_index)) {
                    echo ', '.$model->company->post_index;
                }
                if (!empty($model->company->country_id)) {
                    echo ', ';
                    echo $isTranslit ? Translit::Translit($country_name ) : $country_name;
                }
             ?>
            </td>
            <td width="30" style="text-align: right"><img src="images/template1/phone.png" /></td>
            <td width="100"><?php
                if (!empty($model->company->phone)) {
                    echo $model->company->phone;
                }
            ?>
            </td>
            <td>VAT:
                <?php
                if (!empty($model->company->vat_number)) {
                    echo $model->company->vat_number;
                }
                if (!empty($model->company->resp_person)) {
                    echo '<br />Tax Agency: '.$model->company->resp_person;
                }
                ?>
            </td>
        </tr>
        <tr>
            <td width="200" style="text-align: center;">
               <!-- &Epsilon;&tau;&alpha;&iota;&rho;&epsilon;&iota;&alpha; -->
                <?= $isTranslit ? Translit::Translit($model->company->name) : $model->company->name ?>
            </td>
            <td width="50" style="text-align: center;"><img src="images/template1/site.png" /></td>
            <td width="140" style="padding-top: 10px;"><?php
                if (!empty($model->company->web_site)) {
                    echo $model->company->web_site;
                }
                ?>
            </td>
            <td width="30" style="text-align: right"><img src="images/template1/email.png" /></td>
            <td width="100" colspan="2"><?php
                if (!empty($model->company->mail)) {
                    echo $model->company->mail;
                }
                ?>
            </td>
        </tr>
    </table>
    <table><tr><td>
     <table>
        <tr>
            <td width="50"><img src="images/template1/invoice_to.png" width="42px" /></td>
            <td width="220" style="text-align: left;" colspan="2">
                <h2 style="line-height:10px; text-transform: uppercase;">Invoice to</h2>
            </td>
        </tr>
         <tr><td colspan="3">
                <h2 style="text-transform: uppercase;"><?= $isTranslit ? Translit::Translit($model->client->name) : $model->client->name ?></h2>
            </td>
        </tr>
         <tr>
             <td width="200" colspan="3"><?php
                 if (!empty($model->client->street)) {
                     echo $model->client->street;
                 }
                 if (!empty($model->client->city)) {
                     echo ', '.$model->client->city;
                 }
                 if (!empty($model->client->post_index)) {
                     echo ', '.$model->client->post_index;
                 }
                 if (!empty($model->client->country_id)) {
                     echo ', ';
                     echo $isTranslit ? Translit::Translit($model->client->country->name ) : $model->client->country->name;
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td width="30" style="text-align: right; line-height: 40px;"><img src="images/template1/mobile.png" /></td>
             <td width="120" style="line-height: 40px;"><?php
                 if (!empty($model->client->phone)) {
                     echo $model->client->phone;
                 }
                 ?>
             </td>
             <td width="120" style="line-height: 40px;">VAT:
                 <?php
                 if (!empty($model->client->vat_number)) {
                     echo $model->client->vat_number;
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td width="30" style="text-align: right;"><img src="images/template1/email_client.png" /></td>
             <td width="120"><?php
                 if (!empty($model->client->email)) {
                     echo $model->client->email;
                 }
                 ?>
             </td>
             <td width="120">Tax Agency:
                 <?php
                 if (!empty($model->client->vat_number)) {
                     echo $model->client->vat_number;
                 }
                 ?>
             </td>
         </tr>
    </table>
    </td>
    <td align="right">
    <table border="0">
        <tr>
            <td width="150"><p>&nbsp;</p><p>&nbsp;</p></td>
            <td width="150"><p>&nbsp;</p><p>&nbsp;</p></td>
        </tr>
        <tr>
            <td width="150">
                <img src="images/template1/date.png" />
            </td>
            <td width="150">
                <img src="images/template1/invoice.png" />
            </td>
        </tr>
        <tr style="background-color: #757577;">
            <td width="130" style="border: 1px solid #757577; border-top: 1px solid #fff;">
                <img src="images/template1/triangl.png" />
            </td>
            <td width="170" style="border: 1px solid #757577; border-top: 1px solid #fff;">
                <img src="images/template1/triangl.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
        <tr style="background-color: #757577; color: #fff; font-size: 15px;">
            <td width="150" style="border: 1px solid #757577;">
                Invoice Date: <br />
                <?php
                if (!empty($model->date)) {
                    echo $model->date;
                }
                ?>
                <br />&nbsp;
            </td>
            <td width="150" style="border: 1px solid #757577;">
                Invoice #: <br />
                <?php
                    echo 'MM100'.$model->id;
                ?>
            </td>
        </tr>
    </table>

    </td></tr></table>
        <!--    <div style="width: 100%; height: 200px;"></div>-->
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
</body>
