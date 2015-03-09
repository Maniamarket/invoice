<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::$app->name . ' - Update Payment';
$this->params['breadcrumbs'][]= ['label'=>'Payments', 'url'=>['index']];
$this->params['breadcrumbs'][]= 'Update';
?>

<?php echo Html::a('List Payments', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<?php switch($model->id) {
    case 1:
?>
<h1 class="title">Settings Credit Card</h1>
<?php break;
    case 2:
 ?>
<h1 class="title">Settings Paypal</h1>
<?php break;
    case 3:
 ?>
<h1 class="title">Settings Bank</h1>
<?php break;
    default: break;
} ?>
<?php echo $this->context->renderPartial('_form', ['model'=>$model]); ?>
