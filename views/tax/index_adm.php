<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this VatController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Vats';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Vats'); ?></h1>

<?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Percent</th>
        <th>Дейстия</th>
    </tr>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_adm',
]); ?>
</table>
