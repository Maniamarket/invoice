<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - My Invoice';
$this->params['breadcrumbs'][] = $this->title;

$options_page_size = [20,50,100,200,500];
?>
<div class="invoice-index">

    <h1 class="title"><?= Html::encode($this->title) ?></h1>

    <div class="col-10">
        <?php echo Html::beginForm(['invoice'],'get',['id'=>'form-client-search', 'class'=>"form-inline"]); ?>
        <div class="form-group pull-right">
            <div class="form-group">
                <label for="count_search" class="control-label">Show</label>
                <select class="form-control" name="count_search" id="count_search" onchange="$('#form-client-search').submit()">
                    <?php foreach ($options_page_size as $opt) {
                        if ($opt == $pageSize) {
                            echo '<option selected>'.$opt.'</option>';
                        }
                        else {
                            echo '<option>'.$opt.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php echo Html::endForm(); ?>
    </div>
    <p>&nbsp;</p>
    <?php
   Modal::begin([
        'header' => '&nbsp;',
        'options'=>['id'=>'modal-pdf'],
        'size' => 'modal-lg',
    ]);
    echo '<div style="width:auto; height:600px;"> <iframe id="iframe-pdf" src="" width="860" height="600" align="left">
    Ваш браузер не поддерживает плавающие фреймы!
 </iframe></div>';
    Modal::end();
    ?>

    <table class="table" id="table-result-search">
        <thead>
        <tr>
            <th>#</th>
            <th>ID
                <?php
                if ($sort=='id' && $dir==SORT_ASC) {
                    echo Html::a('<span class="triangl">&#9650;</span>',
                        Url::toRoute(['client/invoice','sort'=>'-id']));
                }
                else {
                    echo '<a href="'.Url::toRoute(['client/invoice','sort'=>'id']).'" ><span class="triangl">&#9660;</span></a>';
                }
                ?>
            </th>
            <th>Date
                <?php
                if ($sort=='date' && $dir==SORT_ASC) {
                    echo Html::a('<span class="triangl">&#9650;</span>',
                        Url::toRoute(['client/invoice','sort'=>'-date']));
                }
                else {
                    echo '<a href="'.Url::toRoute(['client/invoice','sort'=>'date']).'" ><span class="triangl">&#9660;</span></a>';
                }
                ?>
            </th>
            <th>Name </th>
            <th>Company
                <?php
                if ($sort=='company_id' && $dir==SORT_ASC) {
                    echo Html::a('<span class="triangl">&#9650;</span>',
                        Url::toRoute(['client/invoice','sort'=>'-company_id']));
                }
                else {
                    echo '<a href="'.Url::toRoute(['client/invoice','sort'=>'company_id']).'" ><span class="triangl">&#9660;</span></a>';
                }
                ?>
            </th>
            <th>Net Total</th>
            <th>Grand Total</th>
            <th>Valid
                <?php
                if ($sort=='is_pay' && $dir==SORT_ASC) {
                    echo Html::a('<span class="triangl">&#9650;</span>',
                        Url::toRoute(['client/invoice','sort'=>'-is_pay']));
                }
                else {
                    echo '<a href="'.Url::toRoute(['client/invoice','sort'=>'is_pay']).'" ><span class="triangl">&#9660;</span></a>';
                }
                ?>
            </th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody id="invoice_view">
        <?php
        $t_page =  (isset(Yii::$app->request->queryParams['page']))?(Yii::$app->request->queryParams['page']-1)*$dataProvider->pagination->pageSize:0;
        foreach ($dataProvider->models as $key=>$model) {
            echo $this->render('_invoice', ['model'=>$model, 'number'=>$t_page+$key+1]);
        }
        ?>
        </tbody>
    </table>
    <?php
    echo ListView::widget([
        'dataProvider'=>$dataProvider,
        'itemView'=>'_invoice',
        'pager'=>[
            'prevPageLabel'=>'Prev',
            'nextPageLabel'=>'Next'
        ],
        'layout'=>'{pager}'
    ])
    ?>
</div>