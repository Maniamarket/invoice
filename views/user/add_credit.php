<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Setting;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = Yii::t('app', 'Add credit');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="title"><?= Html::encode($this->title) ?></h1>
<div class="form">

    <?php $form = ActiveForm::begin(['id' => 'form-add-credit',
        'options'=>['class' => 'form-horizontal', 'role'=>'form'],
//        'fieldConfig' => [
  //      'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
   // ],
    ]); ?>
    <div class="form-group" >
        Total <?php echo $model->credit; ?>
    </div>
    <div class="form-group" >
        <label>Add credit</label>
        <?= Html::textInput('add_credit',$add_credit) ?>
        <?= Html::label($error,'',['class'=>"text-danger"] )?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-action', 'name' => 'signup-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
