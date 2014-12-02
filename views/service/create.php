<?php
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\web\View;
/* @var $this ServiceController */
/* @var $model Service */

$this->title=Yii::$app->name . ' - Services';
$this->params['breadcrumbs'][] = ['label'=>$this->title,'url'=>['index']];

$this->title=Yii::$app->name . ' - Create';
$this->params['breadcrumbs'][] = $this->title;

echo Menu::widget([
        'items' => [
	['label'=>'List Service', 'url'=>array('index')],
	['label'=>'Manage Service', 'url'=>array('admin')],
]]);
?>

<h1>Create Service</h1>

<?php  echo $this->context->renderPartial('_form', ['model'=>$model]); ?>