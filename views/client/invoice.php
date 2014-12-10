<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - My Invoice';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            <th>Client</th>
            <th>Date</th>
            <th>Company</th>
            <th>Service</th>
            <th>Price Service</th>
            <th>Count</th>
            <th>Vat</th>
            <th>Discount</th>
        </tr>
        </thead>
        <tbody>
        <?php
        echo ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_invoice',
        ]);
        ?>
        </tbody>
    </table>

 </div>
