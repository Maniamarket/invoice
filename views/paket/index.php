<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Lang';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Paket Credits'); ?></h1>
<?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?>


<table class="table">
    <thead>
    <tr>
        <th>Quantity</th>
        <th>Cost</th>
        <th>Date update</th>
    </tr>
    </thead>
    <tbody>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
    </tbody>
</table>

