<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\controllers\PayController;


$this->title = Yii::$app->name . ' - Payment credit';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php  echo 'Payment credit';  ?></h1>
<?php $form = ActiveForm::begin([
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data', 'role'=>'form'],
]); ?>
    <div class="form-group">
          <?php echo $form->field($model, 'credit')->textInput()->hint('You credit ')->label('count credit, EUR') ; ?>
          <?php echo Html::error($model, 'credit'); ?>
    </div>

    <div class="form-group">
         <?php echo $form->field($model, 'currency_id')->dropDownList(PayController::$currency,['prompt'=>'-Choose a Company-'])
                 ->hint('Please enter currency')->label('currency'); ?>
    </div>
<?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'send']) ?>
<?php ActiveForm::end(); ?>

