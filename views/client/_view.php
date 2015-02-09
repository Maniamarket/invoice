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
    <td><a href="#" onclick="$.ajax({
        url:'<?= Url::toRoute(['ajax_invoice','id'=>$model->id]) ?>',
        method:'GET',
        data:{ },
        success: function(response) { $('#invoice_content').empty().html(response); }
    });
    return false;" data-toggle="modal" data-target="#modal-invoice">
            <?php echo Html::encode($model->invoice); ?></a>
    </td>
    <td><?php echo Html::encode($model->total); ?>&euro; </td>
    <td><?= Html::a('details',['update', 'id'=>$model->id]) ?></td>
</tr>


</div>