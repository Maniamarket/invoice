<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->credit); ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->credit_sum); ?></td>
    <td><?php
        if( $model->txn_id < 0)  echo '- from invoice '.$model->txn_id;
        elseif(  $model->txn_id > 0 )  echo 'paypal';
        else 'bank trans';
        ?>
    </td>
</tr>


</div>