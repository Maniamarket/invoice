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

    <h1 class="title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [ 'modelClass' => 'Invoice',]), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Buy credit' ), ['user/buy', 'id' => Yii::$app->user->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'History credit' ), ['history'], ['class' => 'btn btn-success']) ?>
   </p>
    <p>
        <b>Credits: </b><?= Yii::$app->user->identity->setting->credit ?>
   </p>

    <div class="col-10">
        <?php echo Html::beginForm(['index'],'get',['id'=>'form-client-search', 'class'=>"form-inline"]); ?>
        <div class="form-group">
            <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
                <input name="name" id='name_search' type="text" placeholder="Search... " data-url="<?php echo Url::toRoute(['client/ajax'])?>"
                       value="<?php if(isset($qp['name'])) echo $qp['name']; ?>" class="form-control" />
            </div>
        </div>
<!--        <input type="submit" value="Поиск" class="btn btn-primary" />-->
        <div class="form-group pull-right">
            <div class="form-group">
                <label for="count_search" class="control-label">Show</label>
                <select class="form-control" name="count_search" id="count_search">
                    <option>20</option>
                    <option>50</option>
                    <option>100</option>
                    <option>200</option>
                    <option>500</option>
                </select>
            </div>
        </div>
        <?php echo Html::endForm(); ?>
    </div>
    <p>&nbsp;</p>
    <?php
 /*   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>['id'=>'table-result-search'],
        'headerRowOptions'=>[
            'class'=>'table_header',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'name',
        [
            'attribute' => 'company_id',
            'label' => 'Company',
                'format' => 'html',
                'value' => function ($data) {
                         return $data->getCompany()->asArray()->one()['name'];;
/                   }

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons'=>[
                    'delete'=>function($url, $model, $key){
                            return "<a href='#' data-id='$key' onclick='return false;' data-rmu='$url' data-message='Are you sure delete $model->name' class='rm-btn'><span class='glyphicon glyphicon-trash'></span></a>";
                        }
                ]
            ],
        ],
    ]);*/

    ?>
    <table class="table" id="table-result-search">
        <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Оплата</th>
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
            <th>Surtax</th>
            <th>Discount</th>
            <th>Total Price</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $t_page =  (isset(Yii::$app->request->queryParams['page']))?(Yii::$app->request->queryParams['page']-1)*$dataProvider->pagination->pageSize:0;
            foreach ($dataProvider->models as $key=>$model) {
                echo $this->render('_view', ['model'=>$model, 'number'=>$t_page+$key+1]);
            }
/*        echo ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
            'layout'=>'{items}'
        ])*/
        ?>
        </tbody>
    </table>
    <?php
    echo ListView::widget([
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
        'pager'=>[
            'prevPageLabel'=>'Prev',
            'lastPageLabel'=>'Next'
        ],
        'layout'=>'{pager}'
    ])
    ?>
</div>
