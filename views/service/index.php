<?php
use yii\widgets\ListView;
use yii\widgets\Menu;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Services';
$this->params['breadcrumbs'][] = $this->title;

echo Menu::widget([
        'items' => [
	['label'=>'Create Service', 'url'=>array('create')],
	['label'=>'Manage Service', 'url'=>array('admin')],
]]);
?>

<h1><?php echo Yii::t('lang', 'ServiceHeaderText'); ?></h1>

<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
