<?php $this->pageTitle = Yii::$app->name . ' - ' . Yii::t('app', 'My Purse'); ?>
<div class="block_title">
    <h1><?php print Yii::t('app', 'My Purse'); ?></h1>
</div>
<div class="cl"></div>
<?php $this->renderPartial('//layouts/messages'); ?>


<div>
    <p>Redirect on <a target="_blank" href="<?php print $config->getUrl(); ?>"><?php print $config->getUrl(); ?></a>. One moment please.</p>
    <form method="<?php print $config->getMethod(); ?>" id="pay" name="<?php print $config->getFormName(); ?>" action= "<?php print $config->getAction(); ?>" >
        <?php
        foreach ($params as $key => $value) {
            echo CHtml::hiddenField($key, $value);
        }
        ?>
    </form>
</div>

<script type="text/javascript">document.forms["pay"].submit();</script>