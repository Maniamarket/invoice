<?php
use yii\helpers\Html;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->email); ?></td>
    <td><?php echo Html::encode($model->language->name); ?></td>
    <td><?php echo Html::encode($model->country); ?></td>
    <td><?php echo Html::encode($model->city); ?></td>
    <td><?php echo Html::encode($model->street); ?></td>
    <td><?php echo Html::encode($model->phone); ?></td>
</tr>