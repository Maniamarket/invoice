<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>

<div class="row">
     <div class="alert alert-success">
        Платеж успешно завершен. В ближайшее время кредиты будут начислены на ваш счет
    </div>
</div>
<?php echo Html::a('Список счетов-фактур', Url::toRoute('invoice/index'),['class'=>'btn-lg btn btn-primary']) ?>
