<?php
use yii\helpers\Html;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->credit); ?></td>
    <td><?php echo Html::encode($model->sum_profit); ?></td>
     <?php  if( $type_user > 1){ ;?>
        <td><?php  echo ($model->profit_manager) ?></td>
        <td><?php  echo ($model->sum_profit_manager) ?></td>
     <?php } ?>
     <?php  if( $type_user > 2){ ;?>
        <td><?php  echo ($model->profit_admin) ?></td>
        <td><?php  echo ($model->sum_profit_admin) ?></td>
     <?php } ?>

</tr>
