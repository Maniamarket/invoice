<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title=Yii::$app->name . ' - Payment';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Payments'); ?></h1>

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
<?php echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_adm',
]); ?>
    </tbody>
</table>

