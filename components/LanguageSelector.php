<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class LanguageSelector extends Widget {

    public function run() {
	$currentLang = \Yii::$app->language;
	$languages = \Yii::$app->params['languages'];
	return $this->render('languageSelector', array('currentLang' => $currentLang,
						'languages' => $languages)
		);
    }

    public function createMultilanguageReturnUrl($lang = 'en') {
        if (count($_GET) > 0) {
            $arr = $_GET;
            $arr['language'] = $lang;
        } else
            $arr = array('language' => $lang);
        return Url::toRoute('', $arr);
    }
}
