<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this CompanyController */
/* @var $model Company */

$this->title=Yii::$app->name . ' - Company';
$this->params['breadcrumbs'][]= ['label'=>'Companies', 'url'=>['index']];
$this->params['breadcrumbs'][]= $model->name;

/*$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),
	array('label'=>'Update Company', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Company', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);*/
?>

<?php echo Html::a('Список компаний', Url::toRoute('index'),['class'=>'btn-lg btn btn-primary']) ?>
<?php
if (\Yii::$app->user->can('superadmin')) {
    echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']);
    echo Html::a('Обновить', Url::toRoute(['update','id'=>$model->id]),['class'=>'btn-lg btn btn-success']);
    echo Html::a('Удалить',
    ['delete', 'id'=>$model->id],['class'=>'btn-lg btn btn-danger', 'onclick'=>'return confirm("Вы действительно хотите удалить?");']);
}
?>
<h1>View Company #<?php echo $model->id; ?></h1>
<?php echo DetailView::widget([
	'model'=>$model,
	'attributes'=>[
		'id',
        'name',
        'country_id',
        'street',
        'post_index',
        'phone',
        'web_site',
        'mail',
        'vat_number',
        'activity',
        'resp_person',
	],
]); ?>

