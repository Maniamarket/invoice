<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title=Yii::$app->name . ' - Lang';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php echo Yii::t('app', 'LangHeaderText'); ?></h1>

<?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Url</th>
        <th>Local</th>
        <th>Name</th>
        <th>Default</th>
        <th>Date update</th>
        <th>Действия</th>
    </tr>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_adm',
]); ?>
</table>

