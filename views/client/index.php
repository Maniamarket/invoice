<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - My Client';
$this->params['breadcrumbs'][] = $this->title;

$qp=Yii::$app->request->queryParams;

?>

<h1><?php echo Yii::t('lang', 'My Client'); ?></h1>
<p></p><?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?></p>
<div class="col-10">
    <h3>Форма поиска</h3>
   <?php echo Html::beginForm(['index'],'get',['id'=>'form-client-search']); ?>
        <input name="name" id='name_search' type="text" placeholder="Введите имя... " data-url="<?php echo Url::toRoute(['client/ajax'])?>"
             value="<?php if(isset($qp['name'])) echo $qp['name']; ?>" class="col-5" />
        <input type="submit" value="Поиск" class="btn btn-primary" />
    <?php echo Html::endForm(); ?>
</div>
<p>&nbsp;</p>
<table class="table table-striped table-bordered" id="table-result-search">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name
            <?php if(isset($qp['name'])) {
                if (isset($qp['orderby']) && $qp['orderby']=='asc') {
                ?>
                    <span class="glyphicon glyphicon-arrow-up" aria-hidden="true" title="По возрастанию"></span>
            <?php } else { ?>
                <a href="<?php echo Url::toRoute(['client/index','name'=>$qp['name'], 'orderby'=>'asc']); ?>" title="По возрастанию"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
            <?php }
                if (isset($qp['orderby']) && $qp['orderby']=='desc') {
                ?>
                    <span class="glyphicon glyphicon-arrow-down" aria-hidden="true" title="По убыванию"></span>
                <?php } else { ?>
                    <a href="<?php echo Url::toRoute(['client/index','name'=>$qp['name'], 'orderby'=>'desc']); ?>" title="По убыванию"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                <?php }
            }
             else {
            ?>
           <a href="<?php echo Url::to(''); ?>&name=&orderby=asc" title="По возрастанию"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
           <a href="<?php echo Url::to(''); ?>&name=&orderby=desc" title="По убыванию"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
            <?php
               }
            ?>
        </th>
        <th>E-mail</th>
        <th>Language</th>
        <th>Country</th>
        <th>City</th>
        <th>Street</th>
        <th>Phone</th>
    </tr>
    </thead>
    <tbody>
<?php
 echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
]);
?>
    </tbody>
</table>

<?php
/*$this->registerJs(
   '$("document").ready(function(){
        $("#name_search").change(function() {
            alert("Hi!");
            console.log($("#name_search").val());
        });
    });'
);*/
    Yii::$app->view->registerJsFile('@web/js/client.js');
?>
