<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td>
        <?php echo Html::a('MM100'.$model->id,['tcpdf', 'id'=>$model->id]); ?>
        &nbsp;
        <?php if ($model->is_pay) { ?>
            <span class="pull-right">
               <?php Modal::begin([
                   'header' => '<h2>Шаблон для печати</h2>',
                   'toggleButton' => ['tag'=>'a', 'label' => '<span class="glyphicon glyphicon-print" aria-hidden="true"></span>',
                       'style'=>'cursor:pointer;', 'title'=>'Print'],
               ]);
               echo 'Выберите шаблон:';
               echo Html::ol([
                       Html::a('Базовый',['tcpdf','id'=>$model->id,'template'=>'basic']),
                       Html::a('Дополнительный',['tcpdf','id'=>$model->id,'template'=>'add'])
                   ],
                   ['encode'=>false]);
               Modal::end(); ?>

               <?php //echo Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id],['title'=>'Print']); ?>
            </span>
        <?php } ?>
    </td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->service->name); ?></td>
    <td><?php echo Html::encode($model->price_service); ?></td>
    <td><?php echo Html::encode($model->count); ?></td>
    <td><?php echo Html::encode($model->vat); ?></td>
    <td><?php echo Html::encode($model->discount); ?></td>
</tr>


</div>