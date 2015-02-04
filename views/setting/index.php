<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title=Yii::$app->name . ' - Settings';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Settings'); ?></h1>

<?php  echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
