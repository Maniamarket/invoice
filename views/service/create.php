<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use yii\web\View;
/* @var $this ServiceController */
/* @var $model Service */

$this->title=Yii::$app->name . ' - '.Yii::t('app', 'Services');
$this->params['breadcrumbs'][] = ['label'=>$this->title,'url'=>['index']];

$this->title=Yii::$app->name . ' - '.Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php echo Html::a('Список сервисов', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>

<h1 class="title"><?= Yii::t('app', 'Create Services') ?></h1>

<?php  echo $this->context->renderPartial('_form', ['model'=>$model]); ?>
