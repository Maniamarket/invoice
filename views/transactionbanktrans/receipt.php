<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::$app->name . ' - ' . Yii::t('app', 'Transaction receipt');
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php  echo Yii::t('app', 'Transaction receipt');  ?></h1>
<div class="form label-left">
<?php if ($mode==1) { ?>
    <div class="form-horizontal">
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'Title') ?></label>
                <div class="col-md-3">
                    <p class="form-control-static"><?= $model->title ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'Logo') ?></label>
                <div class="col-md-3">
                    <p class="form-control-static"><img src="<?= '/'.Yii::$app->params['avatarPath'].$model->logo ?>" /></p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'Description') ?></label>
                <div class="col-md-10">
                    <p class="form-control-static"><?= $model->description ?></p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::a('Edit', Url::toRoute(['receipt', 'mode' => 2]), ['class' => 'btn btn-yellow']) ?>
        </div>
    </div>
<?php } else { ?>
    <?php $form = ActiveForm::begin([
        'id'=>'invoice-form',
        'enableAjaxValidation'=>false,
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-3\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ],
    ]); ?>
    <div class="row">
    <?= $form->field($model, 'title',['labelOptions'=>['class'=>'control-label col-md-2']])->textInput() ?>

    <?= $form->field($model, 'file',['labelOptions'=>['class'=>'control-label col-md-2']])->fileInput()->hint('add logo'); ?>

    <?= $form->field($model, 'description',['labelOptions'=>['class'=>'control-label col-md-2'],
    'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>"])->textarea(['style'=>'min-height: 170px']) ?>

    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-yellow']) ?>
        <?= Html::resetButton('Clear', ['class' => 'btn btn-action']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php } ?>

</div>
