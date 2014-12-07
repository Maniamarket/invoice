<?php
use yii\helpers\Html;
?>
<div id = "language-select">
    <?php
	foreach ($langs as $lang) {
		echo Html::a(
			'<img src="'.Yii::$app->params['imagePath'] . $lang->url . '.gif" title="' . $lang->name . '" style="padding: 1px;" width=16 height=11>',
			'/'.$lang->url.Yii::$app->getRequest()->getLangUrl());
	    };
    ?>
</div>