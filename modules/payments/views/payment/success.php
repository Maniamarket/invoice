<?php
$this->pageTitle = Yii::$app->name . ' - Платеж завершен';
$this->breadcrumbs = array(
    'Платеж завершен',
);
?>
<div align="center">
    <h1>Ваш платеж успешно завершен!</h1>
    <div class="row">Заказ № <?php print $record->formatID(); ?></div>
    <div class="row">Сумма:  $<?php print $record->summ; ?> (<?php print $record->outSum ?> рублей)</div>
    <div class="row">Дата: <?php print $record->date; ?></div>

    <h2>Ваш текущий баланс составляет: $<?php print $user->getSumm(); ?></h2>
</div>