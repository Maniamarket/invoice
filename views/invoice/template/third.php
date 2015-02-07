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
            <td width="210">
            <?php
                if (!empty($model->company->logo)) {
                    $logo = '/images/companies/'.$model->company->logo;
                    echo '<img src="'.$logo.'" width="200" />';
//                $pdf->Image($logo, '15', '25', '20', '0', '', '', '', true, 150);
                }
             ?>
            </td>
            <td colspan="2">&nbsp;</td>
            <td style="text-align: center" width="200" colspan="4">
                <p style="line-height: 4px;">&nbsp;</p>
                <?= $isTranslit ? Translit::Translit($model->company->name) : $model->company->name ?></td>
        </tr>
        <tr><td colspan="7">&nbsp;</td></tr>
        <tr>
            <td width="150" style="border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;">
                <p style="line-height: 4px;">&nbsp;</p>
                <?php
                echo $isTranslit ? Translit::Translit($model->company->street) : $model->company->street;
                echo $isTranslit ? ', '.Translit::Translit($model->company->city) : ', '.$model->company->city;
                echo ', '.$model->company->post_index;
                echo $isTranslit ? ', '.Translit::Translit($country_name) : ', '.$country_name;
                ?>
            </td>
            <td width="30" style="text-align: center; border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;"><img src="images/template3/separator.png" /></td>
            <td width="100" style="border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;">
                <p style="line-height: 4px;">&nbsp;</p>
                <?php
                if (!empty($model->company->phone)) {
                    echo $model->company->phone;
                }
                if (!empty($model->company->phone2)) {
                    echo '<br />'.$model->company->phone2;
                }
                ?>
            </td>
            <td width="30" style="text-align: center; border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;"><img src="images/template3/separator.png" /></td>
            <td width="140" style="border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;">
                <p style="line-height: 4px;">&nbsp;</p>
                <?php
                if (!empty($model->company->web_site)) {
                    echo $model->company->web_site;
                }
                ?>
                <br />
                <?php
                if (!empty($model->company->mail)) {
                echo $model->company->mail;
                }
                ?>
            </td>
            <td width="30" style="text-align: center; border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;"><img src="images/template3/separator.png" /></td>
            <td width="150" style="border-top: 1px solid #c9c9c9; border-bottom: 1px solid #c9c9c9;">
                <p style="line-height: 4px;">&nbsp;</p>
                VAT:
                <?php
                if (!empty($model->company->vat_number)) {
                    echo $model->company->vat_number;
                }
                if (!empty($model->company->tax_agency)) {
                    echo '<br />Tax Agency: '.$model->company->tax_agency;
                }
                if (!empty($model->company->fax)) {
                    echo '<br />Fax: '.$model->company->fax;
                }
                ?>
            </td>
        </tr>
        <tr><td colspan="7">
                <p style="line-height: 8px;">&nbsp;</p>
        </td></tr>
    </table>
    <table><tr><td  width="280">
     <table>
        <tr>
            <td width="35"><img src="images/template3/invoice_to.png" width="27" /></td>
            <td width="220" style="text-align: left;" colspan="2">
                <h2 style="line-height:8px; color: #b7a997; font-size: 20px;">Invoice TO</h2>
            </td>
        </tr>
         <tr><td colspan="3">
                 <h2 style="line-height:10px; text-transform: uppercase; font-size: 18px; font-weight: bold;"><?php if (!empty($model->client->company_name)) {
                         echo $isTranslit ? Translit::Translit($model->client->company_name) : $model->client->company_name;
                     } else {
                         echo $isTranslit ? Translit::Translit($model->client->name) : $model->client->name;
                     }
                     ?></h2>
            </td>
        </tr>
         <tr><td colspan="3"><p>&nbsp;</p></td></tr>
         <tr>
             <td width="200" colspan="3"><b style="color: #000;">A: </b><?php
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
             <td width="110" style="line-height: 40px;"><b style="color: #000;">T: </b><?php
                 if (!empty($model->client->phone)) {
                     echo $model->client->phone;
                 }
                 ?>
             </td>
             <td width="140" style="line-height: 40px;"><b style="color: #000;">E: </b><?php
                 if (!empty($model->client->email)) {
                     echo $model->client->email;
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td width="110"><b style="color: #000;">VAT: </b>
                 <?php
                 if (!empty($model->client->vat_number)) {
                     echo $model->client->vat_number;
                 }
                 ?>
             </td>
             <td width="140"><b style="color: #000;">Tax Agency: </b>
                 <?php
                 if (!empty($model->client->tax_agency)) {
                     echo $model->client->tax_agency;
                 }
                 ?>
             </td>
         </tr>
         <tr>
             <td width="110" style="line-height: 10px;">
                 <?php
                 if (!empty($model->client->web_site)) {
                     echo $model->client->web_site;
                 }
                 ?>
             </td>
             <td width="140" style="line-height: 30px;"><b style="color: #000;">Fax: </b>
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
            <td width="340" colspan="3" style="text-align: left;">
                <h2 style="line-height:40px; font-size: 45px; color: #000; text-transform: uppercase;"><?= Yii::t('invoice', 'Invoice', [], $lt) ?></h2></td>
        </tr>
        <tr>
            <td width="340" colspan="3">
                <img src="images/template3/invoice_logo.png" />
            </td>
        </tr>
        <tr style="color: #7a7a7a; font-size: 11px; text-align: left; line-height: 20px;">
            <td width="40" style="text-align: right;"><img src="images/template3/date.png" width="40" /></td>
            <td width="140" style="text-align: left;">DATE: <?php
                if (!empty($model->date)) {
                    echo date('M d, Y', strtotime($model->date));
                }
                ?>
            </td>
            <td width="40" style="text-align: right;"><img src="images/template3/invoice.png" width="40" /></td>
            <td width="140">Number: <?php
                    echo 'MM100'.$model->id;
                ?>
            </td>
        </tr>
    </table>

    </td></tr></table>
        <!--    <div style="width: 100%; height: 200px;"></div>-->
    <p>&nbsp;</p>
    <table style="text-align: center; line-height: 40px; font-size: 12px; color: #616262;">
        <tr style="background-color: #ebebec; color: #867b6d;">
            <th width="20"><b>#</b></th>
            <th width="200"><b><?= Yii::t('invoice', 'Item Description', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Qty', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Unit Cost', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Discount', [], $lt) ?></b></th>
            <th><b><?= Yii::t('invoice', 'Total Cost', [], $lt) ?></b></th>
        </tr>
    <?php foreach( $items as $key=>$item) { ?>
        <?php if ($key&1) { ?>
            <tr style="background-color: #ebebec;">
        <?php } else { ?>
            <tr>
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
    <table style="text-align: center; line-height: 30px; font-size: 12px;">
        <tr style="line-height: 5px;"><td colspan="3"></td></tr>
        <tr>
            <td width="340" rowspan="2" style="text-align:left; color: #fff; background-color: #fff;">
                <table>
                    <tr style="line-height: 20px;">
                        <td width="33" style="background-color:  #a49785; color: #fff;"><img src="images/template3/payment.png" width="33" /></td>
                        <td width="150" style="background-color:  #a49785; color: #fff;">
                            <b><?= Yii::t('invoice', 'Payment Method', [], $lt) ?>:</b>
                        </td>
                    </tr>
                    <tr style="line-height: 20px;">
                        <td width="150" style="background-color: #ebebec; color: #000;"> <?= Yii::t('invoice', 'Cash', [], $lt) ?></td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td width="170" style="text-align: right; background-color: #ebebec; border-bottom: 4px solid #fff; border-left: 6px solid #b8aa97;">
                <?= Yii::t('invoice', 'Net Price', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130" style="text-align: right; background-color: #b8aa97; color: #fff;  border-bottom: 4px solid #fff;">
                &euro;<?= $model->net_price ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td width="170" style="text-align: right; background-color: #ebebec; border-bottom: 4px solid #fff; border-left: 6px solid #b8aa97;">
                <?= Yii::t('invoice', 'VAT TAX', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130"  style="text-align: right; background-color: #b8aa97; color: #fff;  border-bottom: 4px solid #fff;">
                <?= $model->vat->percent ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td width="340" style="text-align:left; background-color: #fff;">
                <?php if ($model->is_pay) { ?>
                    <p style="text-transform: uppercase; line-height: 10px;"><?= Yii::t('invoice', 'Validation Number', [], $lt) ?>:  <?= $model->valid_kod ?></p>
                <?php } ?>
            </td>
            <td width="170" style="text-align: right; background-color: #ebebec; border-bottom: 4px solid #fff; border-left: 6px solid #b8aa97;">
                <?= Yii::t('invoice', 'Income TAX', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td  width="130" style="text-align: right; background-color: #b8aa97; color: #fff;  border-bottom: 4px solid #fff;">
                <?= $model->income ?>%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td width="340" style="text-align:left; background-color: #fff;"></td>
            <td width="170" style="text-align: right; background-color: #a49785; color: #fff; border-left: 6px solid #b8aa97; border-bottom:  4px solid #fff;">
                <?= Yii::t('invoice', 'Total Due', [], $lt) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="130"  style="text-align: right; background-color: #b8aa97; color: #fff; border-bottom: 4px solid #fff;">
                &euro;<?= $model->total_price ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
</div>
</body>
