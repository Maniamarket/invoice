<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::t('app', 'Update Company');
$this->params['breadcrumbs'][]= ['label'=>'Companies', 'url'=>['index']];
$this->params['breadcrumbs'][]= 'Update';
?>

<?php echo Html::a('Список компаний', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1 class="title"><?php echo $this->title.' '.$model->id; ?></h1>

<?php echo $this->context->renderPartial('_form', ['model'=>$model, 'uploaded'=>$uploaded]); ?>