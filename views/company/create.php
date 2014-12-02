<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::$app->name . ' - Create Company';
$this->params['breadcrumbs'][]= ['label'=>'Companies', 'url'=>['index']];
$this->params['breadcrumbs'][]= 'Create';
?>

<?php echo Html::a('Список компаний', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1>Create Company</h1>

<?php $this->context->renderPartial('_form', array('model'=>$model)); ?>