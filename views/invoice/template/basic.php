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
        font-size: 15px;
        font-weight: bold;
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
                echo $isTranslit ? Translit::Translit($model->company->street) : $model->company->street;
                echo $isTranslit ? ', '.Translit::Translit($model->company->city) : ', '.$model->company->city;
                echo ', '.$model->company->post_index;
                echo $isTranslit ? ', '.Translit::Translit($country_name) : ', '.$country_name;
             ?>
            </td>
            <td width="30" style="text-align: right"><img src="images/template1/phone.png" /></td>
            <td width="100"><?php
                if (!empty($model->company->phone)) {
                    echo $model->company->phone;
                }
                if (!empty($model->company->phone2)) {
                    echo '<br />'.$model->company->phone2;
                }
            ?>
            </td>
            <td>VAT:
                <?php
                if (!empty($model->company->vat_number)) {
                    echo $model->company->vat_number;
                }
                if (!empty($model->company->tax_agency)) {
                    echo '<br />Tax Agency: '.$model->company->tax_agency;
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
            <td width="100"><?php
                if (!empty($model->company->mail)) {
                    echo $model->company->mail;
                }
                ?>
            </td>
            <td>fax: <?php
                if (!empty($model->company->fax)) {
                    echo $model->company->fax;
                }
                ?>
            </td>
        </tr>
    </table>
    <table><tr><td>
     <table>
        <tr>
            <td width="50"><img src="images/template1/invoice_to.png" width="42" /></td>
            <td width="120" style="text-align: left;">
                <h2 style="line-height:10px; text-transform: uppercase;">Invoice to</h2>
            </td>
            <td width="100" rowspan="3"><?php if(!empty($model->client->avatar)) {echo '<img width="100" src="'.Yii::$app->params['avatarPath'].$model->client->avatar.'" />'; } ?></td>
        </tr>
         <tr><td colspan="2">
                <h2 style="text-transform: uppercase;"><?php if (!empty($model->client->company_name)) {
                    echo $isTranslit ? Translit::Translit($model->client->company_name) : $model->client->company_name;
                } else {
                   echo $isTranslit ? Translit::Translit($model->client->name) : $model->client->name;
                }
                ?></h2>
            </td>
        </tr>
         <tr>
             <td width="200" colspan="2"><?php
                 echo $isTranslit ? Translit::Translit($model->client->street) : $model->client->street;
                 echo $isTranslit ? ', '.Translit::Translit($model->client->city) : ', '.$model->client->city;
                 echo ', '.$model->client->post_index;
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
             <td width="140" style="line-height: 40px;">VAT:
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
             <td width="140">Tax Agency:
                 <?php
                 if (!empty($model->client->tax_agency)) {
                     echo $model->client->tax_agency;
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td width="30" style="text-align: right; line-height: 40px;"><img src="images/template1/site.png" /></td>
             <td width="120" style="line-height: 30px;"><?php
                 if (!empty($model->client->web_site)) {
                     echo $model->client->web_site;
                 }
                 ?>
             </td>
             <td width="140" style="line-height: 30px;">Fax:
                 <?php
                 if (!empty($model->client->fax)) {
                     echo $model->client->fax;
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
    <p>&nbsp;</p>
    <table style="text-align: center; line-height: 30px; font-size: 12px;">
        <tr>
            <th width="20"><b>#</b></th>
            <th width="200"><b><?= Yii::t('invoice', 'Item Description', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Qty', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Unit Cost', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Discount', [], $lt) ?></b></th>
            <th style="text-align: right"><b><?= Yii::t('invoice', 'Total Cost', [], $lt) ?></b></th>
        </tr>
    <?php foreach( $items as $key=>$item) { ?>
        <?php if ($key&1) { ?>
            <tr>
        <?php } else { ?>
            <tr style="background-color: #e8e8e9;">
        <?php } ?>
            <td width="20"><?= $key+1 ?></td>
            <td><?= $isTranslit ? Translit::Translit($item->service->name) : $item->service->name ?></td>
            <td><?= $item->count ?></td>
            <td><?= $item->price_service ?>&euro;</td>
            <td><?= $item->discount ?>%</td>
            <td style="text-align: right"><?= $item->total_price ?>&euro;</td>
        </tr>
     <?php } ?>
    </table>
    <hr />
<table style="text-align: center; line-height: 30px; font-size: 12px;">
    <tr>
        <td width="340" rowspan="4" style="background-color: #fff;">
            <p  style="font-size: 12px; color: #fff; background-color: #acacac; line-height: 24px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Payment Method:</b> PayPal</p></td>
        <td width="170" style="text-align: right;">
            <?= Yii::t('invoice', 'Net Price', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="130" style="text-align: right;">
            <?= $model->net_price ?>&euro;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td width="170" style="text-align: right;">
            <?= Yii::t('invoice', 'VAT TAX', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="130"  style="text-align: right;">
            <?= $model->vat->percent ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td width="170" style="text-align: right;">
            <?= Yii::t('invoice', 'Income TAX', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td  width="130" style="text-align: right;">
            <?= $model->income ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr>
        <td width="170" style="text-align: right; background-color: #757577; color: #fff;">
            <?= Yii::t('invoice', 'Total Due', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td width="130"  style="text-align: right; background-color: #757577; color: #fff;">
            <?= $model->total_price ?>&euro;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>
</div>
</body>
