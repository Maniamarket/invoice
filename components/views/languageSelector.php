<?php
use yii\helpers\Html;
?>
<div id = "language-select">
    <?php
    if (sizeof($languages) < 4) { // если языков меньше четырех - отображаем в строчку
	// Если хотим видить в виде флагов то используем этот код
	foreach ($languages as $key => $lang) {
	    if ($key != $currentLang) {
		echo Html::a(
			'<img src="'.Yii::$app->params['imagePath'] . $key . '.gif" title="' . $lang . '" style="padding: 1px;" width=16 height=11>', $this->context->createMultilanguageReturnUrl($key));
	    };
	}
	// Если хотим в виде текста то этот код
	/*
	  $lastElement = end($languages);
	  foreach($languages as $key=>$lang) {
	  if($key != $currentLang) {
	  echo CHtml::link(
	  $lang,
	  $this->getOwner()->createMultilanguageReturnUrl($key));
	  } else echo '<b>'.$lang.'</b>';
	  if($lang != $lastElement) echo ' | ';
	  }
	 */
    } else {
	// Render options as dropDownList
	echo Html::form();
	foreach ($languages as $key => $lang) {
	    echo Html::hiddenField(
		    $key, $this->getOwner()->createMultilanguageReturnUrl($key));
	}
	echo Html::dropDownList('language', $currentLang, $languages, array(
	    'submit' => '',
		)
	);
	echo Html::endForm();
    }
    ?>
</div>