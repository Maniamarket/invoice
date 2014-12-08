<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\InvoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [ 'modelClass' => 'Invoice',]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a(Yii::t('app', 'Buy credit' ), ['user/buy', 'id' => Yii::$app->user->id], ['class' => 'btn btn-success']) ?>
   </p>

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
            <th>Оплата</th>
            <th>Date</th>
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
            'itemView'=>'_view',
        ]);
        ?>
        </tbody>
    </table>

    <?php /*echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'number',
            'date',
            'seller_id',
            // 'sender_addr',
            // 'recipient_addr',
            // 'bill_number',
            // 'client_id',
            // 'currency_id',

        ],
    ]);*/ ?>

</div>
