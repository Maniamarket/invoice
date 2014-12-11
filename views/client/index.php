<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title=Yii::$app->name . ' - My Client';
$this->params['breadcrumbs'][] = $this->title;
$langs = \yii\helpers\ArrayHelper::map(\app\models\Lang::find()->all(),'id','name');
$arr = [0=>'-'];
foreach($langs as $k => $v){
    $arr[$k] = $v;
}

?>

<h1><?php echo Yii::t('app', 'My Client'); ?></h1>
<p></p><?php echo Html::a('Создать', Url::toRoute('create'),['class'=>'btn-lg btn btn-success']) ?></p>
<div class="col-10">
    <h3>Форма поиска</h3>
    <div class="col-xs-4">
        <input name="name" id="name_search" type="text" placeholder="Искать" data-url="<?php echo Url::toRoute(['client/ajax'])?>" class="form-control" />
        <?=Html::dropDownList('Language',0,$arr,['class'=>'form-control','id'=>'lang_select']);?>
        <input type="button" id="bsearch" value="Поиск" class="btn btn-primary col-xs-6" />
        <input type="button" id="bclear" value="Очистить запрос" class="btn btn-warning col-xs-6" />
        <span id="sort_by"></span>
    </div>
    <div class="clearfix"></div>
</div>
<p>&nbsp;</p>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'options'=>['id'=>'table-result-search'],
    'headerRowOptions'=>[
        'class'=>'table_header',
    ],
    'columns' => [

        'id',
        'name',
        'email',
        [
            'attribute' => 'def_lang_id',
            'format' => 'html',
            'value' => function ($data) {
                /** @var app\models\Client $data */
                return $data->getLanguage()->asArray()->one()['name'];
            }

        ],        [
            'attribute' => 'country_id',
            'format' => 'html',
            'value' => function ($data) {
                /** @var app\models\Client $data */
                return $data->getCountry()->asArray()->one()['name'];
            }

        ],
        'city',
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
]);
?>
<?php
/** @var \yii\data\ActiveDataProvider $dataProvider */
    Yii::$app->view->registerJsFile('@web/js/client.js');
?>
