<?php
use yii\helpers\Html;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php
             echo -$model->credit;
    ?></td>
</tr>
<!--if(Yii::$app->user->identity->role == 'mamager' ) //echo ($model->profit_manager+$model->credit);
else //echo ($model->profit_admin+$model->credit);-->
