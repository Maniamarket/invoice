<?php
use yii\helpers\Html;
use yii\helpers\Url;

//var_dump(count($model->user_payment));
?>
<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->username); ?></td>
    <td><?php echo $model->sum_profit;  ?></td>
    <td><?php echo Html::a('go',Url::toRoute(['user/profit_history','user_id'=>$model->id]));  ?></td>
</tr>
<!--if(Yii::$app->user->identity->role == 'mamager' ) //echo ($model->profit_manager+$model->credit);
else //echo ($model->profit_admin+$model->credit);-->
