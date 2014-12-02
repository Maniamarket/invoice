<?php
use yii\helpers\Html;
/* @var $this CompanyController */
/* @var $model Company */
?>


<tr>
    <td><?php echo Html::a(Html::encode($model->id), ['view', 'id'=>$model->id]); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::img(Yii::$app->params['imagePath'].$model->logo,['alt'=>'company']); ?></td>
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