<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this CompanyController */
/* @var $dataProvider ActiveDataProvider */

$this->title=Yii::$app->name . ' - Companies';
$this->params['breadcrumbs'][] = $this->title;

/*$this->menu=array(
	array('label'=>'Create Company', 'url'=>array('create')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);*/
?>

<h1>Companies</h1>
<?php
if (\Yii::$app->user->can('superadmin')) {
    echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']);
 }
?>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Logo</th>
        <th>Country</th>
        <th>City</th>
        <th>Street</th>
        <th>Post Index</th>
        <th>Phone</th>
        <th>Site</th>
        <th>Mail</th>
        <th>Vat Number</th>
        <th>Activity</th>
        <th>Resp Person</th>
    </tr>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
</table>
