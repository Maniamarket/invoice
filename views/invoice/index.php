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
        <?= Html::a(Yii::t('app', 'Buy credit' ), ['user/buy', 'id' => Yii::$app->user->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'History credit' ), ['history'], ['class' => 'btn btn-success']) ?>
   </p>
    <p>
        <b>Credits: </b><?= Yii::$app->user->identity->setting->credit ?>
   </p>

    <div class="col-10">
        <h3>Р¤РѕСЂРјР° РїРѕРёСЃРєР°</h3>
        <?php echo Html::beginForm(['index'],'get',['id'=>'form-client-search']); ?>
        <input name="name" id='name_search' type="text" placeholder="Р’РІРµРґРёС‚Рµ РёРјСЏ... " data-url="<?php echo Url::toRoute(['client/ajax'])?>"
               value="<?php if(isset($qp['name'])) echo $qp['name']; ?>" class="col-5" />
        <input type="submit" value="РџРѕРёСЃРє" class="btn btn-primary" />
        <?php echo Html::endForm(); ?>
    </div>
    <p>&nbsp;</p>
    <table class="table table-striped table-bordered" id="table-result-search">
        <thead>
        <tr>
            <th>ID</th>
            <th>РћРїР»Р°С‚Р°</th>
            <th>Name
                <?php if(isset($qp['name'])) {
                    if (isset($qp['orderby']) && $qp['orderby']=='asc') {
                        ?>
                        <span class="glyphicon glyphicon-arrow-up" aria-hidden="true" title="РџРѕ РІРѕР·СЂР°СЃС‚Р°РЅРёСЋ"></span>
                    <?php } else { ?>
                        <a href="<?php echo Url::toRoute(['client/index','name'=>$qp['name'], 'orderby'=>'asc']); ?>" title="РџРѕ РІРѕР·СЂР°СЃС‚Р°РЅРёСЋ"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                    <?php }
                    if (isset($qp['orderby']) && $qp['orderby']=='desc') {
                        ?>
                        <span class="glyphicon glyphicon-arrow-down" aria-hidden="true" title="РџРѕ СѓР±С‹РІР°РЅРёСЋ"></span>
                    <?php } else { ?>
                        <a href="<?php echo Url::toRoute(['client/index','name'=>$qp['name'], 'orderby'=>'desc']); ?>" title="РџРѕ СѓР±С‹РІР°РЅРёСЋ"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
                    <?php }
                }
                else {
                    ?>
                    <a href="<?php echo Url::to(''); ?>&name=&orderby=asc" title="РџРѕ РІРѕР·СЂР°СЃС‚Р°РЅРёСЋ"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></a>
                    <a href="<?php echo Url::to(''); ?>&name=&orderby=desc" title="РџРѕ СѓР±С‹РІР°РЅРёСЋ"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></a>
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
        echo ListView::widget([
            'dataProvider'=>$dataProvider,
            'itemView'=>'_view',
        ]);
        ?>
        </tbody>
    </table>
</div>
