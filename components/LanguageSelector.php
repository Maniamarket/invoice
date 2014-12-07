<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Lang;

class LanguageSelector extends Widget {

    public function run() {
	$currentLang = \Yii::$app->language;
	$langs = Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all();
	return $this->render('languageSelector', ['currentLang' => $currentLang, 'langs' => $langs]);
    }
}
