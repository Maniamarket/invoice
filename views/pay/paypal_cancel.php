<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="row">
     <div class="alert alert-danger">
        Вы отменили платеж.
    </div>
</div>
<?php echo Html::a('Список счетов-фактур', Url::toRoute('invoice/index'),['class'=>'btn-lg btn btn-primary']) ?>
