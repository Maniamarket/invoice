<?php
use yii\helpers\Html;

?>
<tr>
    <td><?= $number ?></td>
    <td>
        <?php echo Html::a('MM100'.$model->id,['tcpdf', 'id'=>$model->id]); ?>
    </td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->net_price); ?>&euro;</td>
    <td><?php echo Html::encode($model->total_price); ?>&euro; </td>
    <td><?php if ($model->is_pay) echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is Valid</div><img src="/images/invoice_valid.png" /></span>';
        else echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is not Valid</div><img src="/images/invoice_invalid.png" /></span>';
        ?></td>
</tr>


</div>