<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this VatController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Income';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Incomes'); ?></h1>

<?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>from</th>
        <th>to</th>
        <th>manager %</th>
        <th>admin %</th>
        <th>Дейстия</th>
    </tr>
    </thead>
    <tbody>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_adm',
]); ?>
    </tbody>
</table>
