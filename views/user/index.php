<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - '.$hearder;
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php echo Yii::t('lang', $hearder); ?></h1>

<?php echo Html::a('Создать', Url::toRoute(['create','type_user'=>$type_user]),['class'=>'btn-lg btn btn-success']) ?>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]); ?>
</table>
