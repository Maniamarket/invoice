<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\web\View;
/* @var $this ServiceController */
/* @var $model Service */

$this->title=Yii::$app->name . ' - Services';
$this->params['breadcrumbs'][] = ['label'=>$this->title,'url'=>['index']];

$this->title=Yii::$app->name . ' - Create';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo Html::a('Список Комиссий', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1>Create Income</h1>

<?php  echo $this->context->renderPartial('_form', ['model'=>$model]); ?>
