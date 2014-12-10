<?php
use yii\helpers\Html;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->url); ?></td>
    <td><?php echo Html::encode($model->local); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->default); ?></td>
    <td><?php echo Html::encode(date('d.m.y h:i:s',$model->date_update)); ?></td>
</tr>