<?php
use yii\grid\GridView;
?>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
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
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);

?>
