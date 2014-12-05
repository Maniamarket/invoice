<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Lang';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php echo Yii::t('lang', 'LangHeaderText'); ?></h1>

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

