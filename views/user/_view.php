<?php
use yii\helpers\Html;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->user_income->credit); ?></td>
     <?php  if( $type_user > 1){ ;?>
        <td><?php 
        echo ($model->user_income->profit_manager) 
        ?></td>
     <?php } ?>

</tr>
