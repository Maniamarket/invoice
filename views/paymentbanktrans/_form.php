<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Paymentbanktrans */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paymentbanktrans-form">

<?php $form = ActiveForm::begin([
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data', 'role'=>'form'],
]); ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => 255]) ?>    
    
    <label>Attach file</label>
    <?= Html::activeFileInput($model,'file'); ?>
    <br>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
