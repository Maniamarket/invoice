<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - '.$hearder;
$this->params['breadcrumbs'][] = $this->title;

?>

<h1 class="title"><?php echo Yii::t('app', $hearder); ?></h1>

<?php echo Html::a('Создать', Url::toRoute(['create','type_user'=>$type_user]),['class'=>'btn-lg btn btn-success']) ?>
<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Profit</th>
        <th>Total Profit</th>
        <?php if( $type_user == 4 ){ ?>
            <th>Income Tax</th>
            <th>Edit Income tax</th>
            <th>History credit</th>
            <th>History bank transfer</th>
            <th>Add credit</th>
            <th>Edit</th>
        <?php } ?>
        <?php if( $type_user > 1 && $type_user < 4 ){ ?>
        <th>Profit Manager</th>
        <th>Total Profit Manager</th>
        <?php } ?>
        <?php if( $type_user > 2 && $type_user < 4){ ?>
        <th>Profit Admin</th>
        <th>Total Profit Admin</th>
        <?php } ?>
        <?php if( $type_user > 1 && $type_user < 4){ ?>
        <th>Income</th>
        <th>My_profit</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
    foreach ($dataProvider->models as $key=>$model) {
       echo $this->render('_view', ['model'=>$model,'type_user'=>$type_user ]);
    }
/*echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
        'viewParams'=>['type_user'=>$type_user],
    'layout'=>'{items}'
]);*/
?>
    </tbody>
</table>

<?php
echo ListView::widget([
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'pager'=>[
        'prevPageLabel'=>'Prev',
        'nextPageLabel'=>'Next'
    ],
    'layout'=>'{pager}'
])
?>