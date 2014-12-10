<div id="dialog<?php print $model->id ?>" title="<?php print Yii::t('mypurse', 'Withdraw Money') . ' #' . $model->paymentOutput->id ?>" class="withdrawDialogBox">

    <div class="form">

        <div class="row">
            <label>Система: </label>
            <label><?php print $model->paymentSystem->getConfig()->getName(); ?></label>
        </div>
        <div class="cl"></div>

        <div class="row">
            <label>Реквизиты перевода: </label>
            <label><?php print $model->paymentOutput->paymentSystemInfo ?></label>
        </div>
        <div class="cl"></div>

        <div class="row">
            <label>Сумма:</label>
            <label>$<?php print $model->paymentOutput->amount; ?></label>
        </div>
        <div class="cl"></div>

        <div class="row">
            <label>Дополнительная информация: </label>
            <label><?php print $model->paymentOutput->clientWish ?></label>
        </div>
        <div class="cl"></div>


        <div class="row">
            <label>Дата подачи заявки:</label>
            <label><?php print $model->paymentOutput->dateAdded; ?></label>
        </div>
        <div class="cl"></div>

        <?php if ($model->paymentOutput->operatorMessage) { ?>
            <div class="row">
                <label>Комментарий оператора:</label>
                <label><?php print $model->paymentOutput->operatorMessage; ?></label>
            </div>
            <div class="cl"></div>
        <?php } ?>

    </div>

</div>