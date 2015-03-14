<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - Lang';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', 'Packages Credits'); ?>
    <?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn btn-yellow pull-right']) ?>
</h1>


<div class="form">
<?php
$form=ActiveForm::begin( [
    'id'=>'payment-form',
    'enableAjaxValidation'=>false,
    'options'=>['class' => 'form-horizontal', 'role'=>'form'],
    'fieldConfig' => [
        'template' => "<div class=\"col-md-7\">{label}\n{input}</div>\n<div class=\"col-md-offset-2 col-md-7\">{error}</div>",
    ],
]);
?>
<?php
echo '<div class="row"><div class="fieldset-column pull-left"><label class="control-label col-md-5">'.
    Yii::t('app', 'Enabled Packages').'</label><div class="col-md-2">';
echo Html::checkbox('active',(int)$paket->title,['class' => 'form-control']);
//        echo '</div>';
echo '</div>';
echo '<div class="row">';
echo Html::submitButton(Yii::t('app', 'Done'), ['name' =>'submitPack', 'class' => 'btn btn-action']);
echo '</div></div>';
ActiveForm::end();
?>
</div>

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

