<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?= $number ?></td>
    <td>
        <?php echo Html::a('MM100'.$model->id,['tcpdf', 'id'=>$model->id]); ?>
        &nbsp;
        <?php if ($model->is_pay) { ?>
            <span class="pull-right">
               <?php Modal::begin([
                   'header' => '<h2>Шаблон для печати</h2>',
                   'toggleButton' => ['tag'=>'a', 'label' => '<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>',
                       'style'=>'cursor:pointer;', 'title'=>'Set Template'],
               ]);
               echo 'Выберите шаблон:';
               echo Html::ol([
                   Html::a('Базовый',['settemplate','id'=>$model->id,'template'=>'basic']),
                   Html::a('Дополнительный',['settemplate','id'=>$model->id,'template'=>'add'])
                ],
               ['encode'=>false]);
               Modal::end();
               echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id],['title'=>'Print']);
               echo '&nbsp';
               echo Html::a('<span style="color: purple;" class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id, 'isTranslit'=>1],['title'=>'Print Translit']);
               ?>
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
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->price); ?></td>
    <td><?php echo Html::encode($model->price_service*$model->count); ?></td>
<!--    <td><?php echo Html::encode($model->count); ?></td>
    <td><?php echo Html::encode($model->vat); ?></td>
    <td><?php echo Html::encode($model->tax); ?></td>
    <td><?php echo Html::encode($model->discount); ?></td>
    <td><?php echo Html::encode($model->price); ?></td>-->
</tr>


</div>