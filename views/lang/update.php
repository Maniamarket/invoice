<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::$app->name . ' - Update Service';
$this->params['breadcrumbs'][]= ['label'=>'Services', 'url'=>['index']];
$this->params['breadcrumbs'][]= 'Update';
?>

<?php echo Html::a('Список языков', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1>Update Service <?php echo $model->id; ?></h1>

<?php echo $this->context->renderPartial('_form', ['model'=>$model]); ?>