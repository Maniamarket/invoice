<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::$app->name . ' - Update Income';
$this->params['breadcrumbs'][]= ['label'=>'Income', 'url'=>['index']];
$this->params['breadcrumbs'][]= 'Update';
?>

<?php echo Html::a('Список комиссий', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1 class="title">Update Income <?php echo $model->id; ?></h1>

<?php echo $this->context->renderPartial('_form', ['model'=>$model]); ?>