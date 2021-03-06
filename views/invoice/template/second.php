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
<body><div><table  style="font-size: 10px; text-align: left; background-color: #575756; color: #fff;">
        <tr><td colspan="6">&nbsp;</td></tr>
        <tr>
            <td width="210">
            <?php
                if (!empty($model->company->logo)) {
                    $logo = '/images/companies/'.$model->company->logo;
                    echo '<img src="'.$logo.'" width="200" />';
//                $pdf->Image($logo, '15', '25', '20', '0', '', '', '', true, 150);
                }
             ?>
            </td>
            <td width="30" style="text-align: center;"><img src="images/template2/address.png" /></td>
            <td width="150"><?php
                echo $isTranslit ? Translit::Translit($model->company->street) : $model->company->street;
                echo $isTranslit ? ', '.Translit::Translit($model->company->city) : ', '.$model->company->city;
                echo ', '.$model->company->post_index;
                echo $isTranslit ? ', '.Translit::Translit($country_name) : ', '.$country_name;
             ?>
            </td>
            <td width="30" style="text-align: right"><img src="images/template2/phone.png" /></td>
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
        <tr style="line-height: 30px;">
            <td width="200" style="text-align: center;">
               <!-- &Epsilon;&tau;&alpha;&iota;&rho;&epsilon;&iota;&alpha; -->
                <?= $isTranslit ? Translit::Translit($model->company->name) : $model->company->name ?>
            </td>
            <td width="50" style="text-align: center;"></td>
            <td width="140" style="padding-top: 10px;"><?php
                if (!empty($model->company->web_site)) {
                    echo $model->company->web_site;
                }
                ?>
            </td>
            <td width="30" style="text-align: right"></td>
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
        <tr>
            <td colspan="6" style="width: 100%; background-color: #fff; border: 1px solid #fff; border-top: 1px solid #575756;">
                <img src="images/template2/logo.png" /></td>
        </tr>
    </table>
    <table><tr><td  width="280">
     <table>
        <tr>
            <td width="35"><img src="images/template2/invoice_to.png" width="27" /></td>
            <td width="120" style="text-align: left;" colspan="2">
                <h2 style="line-height:10px; color: #24aa98; font-size: 18px; text-transform: uppercase;">Invoice to</h2>
            </td>
            <td width="100" rowspan="4"><?php if(!empty($model->client->avatar)) {echo '<img width="100" src="'.Yii::$app->params['avatarPath'].$model->client->avatar.'" />'; } ?></td>
        </tr>
         <tr><td colspan="3">
                 <h2 style="line-height:16px; text-transform: uppercase; font-size: 20px; font-weight: bold;"><?php if (!empty($model->client->company_name)) {
                         echo $isTranslit ? Translit::Translit($model->client->company_name) : $model->client->company_name;
                     } else {
                         echo $isTranslit ? Translit::Translit($model->client->name) : $model->client->name;
                     }
                     ?></h2>
            </td>
        </tr>
         <tr><td colspan="3"><p>&nbsp;</p></td></tr>
         <tr>
             <td width="200" colspan="3"><?php
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
             <td width="120" style="line-height: 30px;"><?php
                 if (!empty($model->client->phone)) {
                     echo $model->client->phone;
                 }
                 ?>
             </td>
             <td width="140" style="line-height: 30px;">VAT:
                 <?php
                 if (!empty($model->client->vat_number)) {
                     echo $model->client->vat_number;
                 }
                 ?>
             </td>
         </tr>
         <tr>
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
    <td align="right" width="350">
    <table border="0">
        <tr>
            <td width="340" colspan="3">
                <h2 style="line-height:40px; font-size: 45px; color: #7b7b7b; text-transform: uppercase;"><?= Yii::t('invoice', 'Invoice', [], $lt) ?></h2></td>
        </tr>
        <tr>
            <td width="340" colspan="3">
                <img src="images/template2/invoice_logo.png" />
            </td>
        </tr>
        <tr style="color: #7a7a7a; font-size: 11px; text-align: left; line-height: 20px;">
            <td width="40" style="text-align: right;"><img src="images/template2/date.png" width="30" /></td>
            <td width="160" style="text-align: left;">Invoice Date: <?php
                if (!empty($model->date)) {
                    echo date('d/m/Y', strtotime($model->date));
                }
                ?>
            </td>
            <td width="30" style="text-align: right;"><img src="images/template2/invoice.png" width="23" /></td>
            <td width="140">Invoice #: <?php
                    echo 'MM100'.$model->id;
                ?>
            </td>
        </tr>
    </table>

    </td></tr></table>
        <!--    <div style="width: 100%; height: 200px;"></div>-->
    <p>&nbsp;</p>
    <table style="text-align: center; line-height: 40px; font-size: 12px;">
        <tr style="background-color: #24aa98; color: #fff;">
            <th width="20" style="border: 1px solid #24aa98;"><b>#</b></th>
            <th width="200" style="border: 1px solid #24aa98;"><b><?= Yii::t('invoice', 'Item Description', [], $lt) ?></b></th>
            <th style="border: 1px solid #24aa98;"><b><?= Yii::t('invoice', 'Qty', [], $lt) ?></b></th>
            <th style="border: 1px solid #24aa98;"><b><?= Yii::t('invoice', 'Unit Cost', [], $lt) ?></b></th>
            <th style="border: 1px solid #24aa98;"><b><?= Yii::t('invoice', 'Discount', [], $lt) ?></b></th>
            <th style="border: 1px solid #24aa98; text-align: right"><b><?= Yii::t('invoice', 'Total Cost', [], $lt) ?></b></th>
        </tr>
    <?php
    foreach( $items as $key=>$item) { ?>
        <?php if ($key&1) { ?>
            <tr style="background-color: #efefef;">
        <?php } else { ?>
            <tr style="background-color: #e1e1e1;">
        <?php } ?>
            <td width="20"><?= $key+1 ?></td>
            <td><?= $isTranslit ? Translit::Translit($item->service->name) : $item->service->name ?></td>
            <td><?= $item->count ?></td>
            <td>&euro;<?= $item->price_service ?></td>
            <td><?= $item->discount ?>%</td>
            <td style="text-align: right">&euro;<?= $item->total_price ?></td>
        </tr>
     <?php } ?>
    </table>
    <table style="text-align: center; line-height: 40px; font-size: 12px;">
        <?php
        $key = count($items);
        if ($key&1) { ?>
        <tr style="background-color: #efefef;">
            <?php } else { ?>
        <tr style="background-color: #e1e1e1;">
            <?php } ?>
            <td width="300" style="text-align:left; color: #fff; background-color: #fff;">
                <table>
                    <tr style="line-height: 10px;"><td colspan="3"></td></tr>
                    <tr style="line-height: 20px;">
                      <td width="33" style="background-color:  #24aa98; color: #fff;"><img src="images/template2/payment.png" width="33" /></td>
                      <td width="150" style="background-color:  #24aa98; color: #fff;">
                            <b><?= Yii::t('invoice', 'Payment Method', [], $lt) ?>:</b>
                      </td>
                      <td> <?= Yii::t('invoice', 'Cash', [], $lt) ?></td>
                    </tr>
                    <tr style="line-height: 10px;"><td colspan="3" style="text-align: left"><img src="images/template2/payment_triangl.png" width="33" /></td></tr>
                </table>
            </td>
            <td width="40" style="background-color: #fff;"></td>
            <td width="170" style="text-align: right;">
                <?= Yii::t('invoice', 'Net Price', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130" style="text-align: right;">
                &euro;<?= $model->net_price ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr><?php $key++;
        if ($key&1) { ?>
        <tr style="background-color: #efefef;">
            <?php } else { ?>
        <tr style="background-color: #e1e1e1;">
            <?php } ?>
            <td width="340" style="text-align:left; background-color: #fff;">
                <?php if ($model->is_pay) { ?>
                    <p style="text-transform: uppercase; line-height: 10px;"><?= Yii::t('invoice', 'Validation Number', [], $lt) ?>:  <?= $model->valid_kod ?></p>
                <?php } ?>
            </td>
            <td width="170" style="text-align: right;">
                <?= Yii::t('invoice', 'VAT TAX', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130"  style="text-align: right;">
                <?= $model->vat->percent ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr><?php $key++;
        if ($key&1) { ?>
        <tr style="background-color: #efefef;">
            <?php } else { ?>
        <tr style="background-color: #e1e1e1;">
            <?php } ?>
            <td width="260" style="background-color: #fff;"></td>
            <td width="80" style="background-color: #fff;"></td>
            <td width="170" style="text-align: right;">
                <?= Yii::t('invoice', 'Income TAX', [], $lt) ?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td  width="130" style="text-align: right;">
                <?= $model->income ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr><?php $key++;
        if ($key&1) { ?>
        <tr style="background-color: #efefef;">
            <?php } else { ?>
        <tr style="background-color: #e1e1e1;">
            <?php } ?>
            <td width="260" style="background-color: #fff;"></td>
            <td width="80" style="background-color: #fff;"></td>
            <td width="170" style="text-align: right; background-color: #24aa98; color: #fff;">
                <?= Yii::t('invoice', 'Total Due', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130"  style="text-align: right; background-color: #24aa98; color: #fff;">
                &euro;<?= $model->total_price ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
</div>
</body>
