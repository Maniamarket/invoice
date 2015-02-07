<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?= $number ?></td>
    <td>
        <?php echo 'MM100'.$model->id; ?>
    </td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->net_price); ?>&euro;</td>
    <td><?php echo Html::encode($model->total_price); ?>&euro; </td>
    <td><?php if ($model->is_pay) echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is Valid</div><img src="/images/invoice_valid.png" /></span>';
        else echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is not Valid</div><img src="/images/invoice_invalid.png" /></span>';
     ?></td>
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