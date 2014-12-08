<?php
use yii\helpers\Html;
?>
<tr>
    <td>
        <?php echo Html::a('MM100'.$model->id,['tcpdf', 'id'=>$model->id]); ?>
        &nbsp;
        <?php if ($model->is_pay) { ?>
            <span class="pull-right">
                <?php echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span>',
            ['tcpdf', 'id'=>$model->id],['title'=>'Print']); ?>
            </span>
        <?php } elseif (\Yii::$app->user->can('superadmin')){ ?>
            <span class="pull-right">
                <?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                    ['update', 'id'=>$model->id],['title'=>'Update']); ?>
                &nbsp;
                <?php echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                    ['delete', 'id'=>$model->id],['title'=>'Delete', 'onClick'=>'return confirm("Вы действительно хотите удалить?")']); ?>
            </span>
        <?php } ?>
    </td>
    <td><?php if ($model->is_pay) echo 'фактура оплачена';
              else echo Html::a('Оплатить', ['user/pay', 'id'=>$model->id],['title'=>'Pay']);;         
     ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->service->name); ?></td>
    <td><?php echo Html::encode($model->count); ?></td>
    <td><?php echo Html::encode($model->vat); ?></td>
    <td><?php echo Html::encode($model->discount); ?></td>
</tr>


</div>