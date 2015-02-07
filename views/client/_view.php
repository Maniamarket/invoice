<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?= $number ?></td>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->vat_number); ?></td>
    <td><?php echo Html::encode($model->invoice); ?>&euro;</td>
    <td><?php echo Html::encode($model->total); ?>&euro; </td>
    <td><?= Html::a('details',['update', 'id'=>$model->id]) ?></td>
    <td>
        &nbsp;
           <?php

         echo Html::a('<img src="/images/invoice_pdf.png"', ['tcpdf', 'id'=>$model->id],['title'=>'View in Pdf',
         'onclick'=>'$("#iframe-pdf").attr("src","'.Url::toRoute(['tcpdf', 'id'=>$model->id]).'"); return false;', 'data-toggle'=>"modal", 'data-target'=>"#modal-pdf"]);
         echo '&nbsp';
           echo Html::a('<img src="/images/invoice_print.png"', ['tcpdf', 'id'=>$model->id,'print'=>1],['title'=>'Print']);
           echo '&nbsp';
           echo Html::a('<span style="color: purple;" class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id, 'isTranslit'=>1],['title'=>'Print Translit']);
           ?>
    </td>
</tr>


</div>