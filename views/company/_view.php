<?php
use yii\helpers\Html;
/* @var $this CompanyController */
/* @var $model Company */
?>


<tr>
    <td>
        <?php echo Html::a(Html::encode($model->id), ['view', 'id'=>$model->id]); ?>
        &nbsp;
        <?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['update', 'id'=>$model->id],['title'=>'Update']); ?>
        &nbsp;
        <?php echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
            ['delete', 'id'=>$model->id],['title'=>'Delete', 'onclick'=>'return confirm("Вы действительно хотите удалить?");']); ?>
    </td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::img(Yii::$app->params['imagePath'].'/companies/'.$model->logo,['alt'=>'company','width'=>150]); ?></td>
    <td><?php echo Html::encode($model->country); ?></td>
    <td><?php echo Html::encode($model->city); ?></td>
    <td><?php echo Html::encode($model->street); ?></td>
    <td><?php echo Html::encode($model->post_index); ?></td>
    <td><?php echo Html::encode($model->phone); ?></td>
    <td><?php echo Html::encode($model->web_site); ?></td>
    <td><?php echo Html::encode($model->mail); ?></td>
    <td><?php echo Html::encode($model->vat_number); ?></td>
    <td><?php echo Html::encode($model->activity); ?></td>
    <td><?php echo Html::encode($model->resp_person); ?></td>
</tr>