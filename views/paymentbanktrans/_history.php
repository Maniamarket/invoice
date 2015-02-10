<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?php echo Html::encode($model['id']); ?></td>
    <td><?php echo Html::encode($model['t_id']); ?></td>
    <td><?php echo Html::encode($model['date']); ?></td>
    <td><?php
        switch($model['status']){
            case 0: echo 'create';
                break;
            case 1: echo 'approve';
                break;
            default : echo 'delete';
        }
        ?>
    </td>
</tr>


</div>