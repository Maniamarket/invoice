<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - Profit';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Profit user_id='.$user_model->id.' username -'.$user_model->username); ?></h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Date</th>
        <th>Credit</th>
    </tr>
    </thead>
    <tbody>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_profit_history',
]); ?>
    </tbody>
</table>
