<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - Profit';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php echo Yii::t('app', 'Profit'); ?></h1>

<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Profit</th>
    </tr>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_profit',
]); ?>
</table>
