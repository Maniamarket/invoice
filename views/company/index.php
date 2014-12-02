<?php
use yii\widgets\ListView;
/* @var $this CompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Companies';
$this->params['breadcrumbs'][] = $this->title;

/*$this->menu=array(
	array('label'=>'Create Company', 'url'=>array('create')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);*/
?>

<h1>Companies</h1>

<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
