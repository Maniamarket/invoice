<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\web\View;
/* @var $this ServiceController */
/* @var $model Service */

$this->title=Yii::$app->name . ' - Create Payment';
$this->params['breadcrumbs'][] = ['label'=>$this->title,'url'=>['index']];

$this->title=Yii::$app->name . ' - Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo Html::a('List Payments', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1 class="title">Create Payment</h1>

<?php  echo $this->context->renderPartial('_form', ['model'=>$model]); ?>
