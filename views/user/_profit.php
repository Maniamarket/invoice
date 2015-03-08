<?php
use yii\helpers\Html;

//var_dump(count($model->user_payment));
?>
<?php foreach ($model->user_payment as $payment) { ?>
<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($payment->date); ?></td>
    <td><?php
             echo -$payment->credit;
    ?></td>
</tr>
<?php } ?>
<!--if(Yii::$app->user->identity->role == 'mamager' ) //echo ($model->profit_manager+$model->credit);
else //echo ($model->profit_admin+$model->credit);-->
