<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Translit */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Translit',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="translit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
