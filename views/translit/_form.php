<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Translit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from_lang_id')->dropDownList(\app\models\Lang::getLanguageArray()) ?>

    <?= $form->field($model, 'to_lang_id')->dropDownList(\app\models\Lang::getLanguageArray()) ?>


    <?= $form->field($model, 'from_symbol')->textInput(['maxlength' => 8]) ?>

    <?= $form->field($model, 'to_symbol')->textInput(['maxlength' => 8]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
