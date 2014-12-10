<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translits');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translit-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="col-xs-12 alert-warning">
        <div class="col-xs-2">For example</div>
        <div class="col-xs-12">
            <input class="hidden" id="turl" value="<?= \yii\helpers\Url::toRoute('translit/convert') ?>"/>
            Перевести с русского: <input id="i_trans"/> в транслит <input id="i_res"/>
            <button id="bet">перевод по стандартному словарю</button>
            <button id="alp">перевод из бд</button>
        </div>
    </div>
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Translit',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'from_lang_id',
                'format' => 'html',
                'value' => function ($data) {
                    return \app\models\Lang::getLanguageArray()[$data->from_lang_id] . '(' . $data->from_lang_id . ')';
                }

            ],
            [
                'attribute' => 'to_lang_id',
                'format' => 'html',
                'value' => function ($data) {
                    return \app\models\Lang::getLanguageArray()[$data->to_lang_id] . '(' . $data->to_lang_id . ')';
                }
            ],
            'from_symbol',
            'to_symbol',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
