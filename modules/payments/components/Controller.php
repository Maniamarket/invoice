<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function init() {
        $referal_id = Yii::$app->request->getParam('ref', 0);
        if ($referal_id) {
            $cookies_referal_id = Yii::$app->request->cookies->contains('referal_id') ?
                    (int) Yii::$app->request->cookies['referal_id']->value : FALSE;
            if (!$cookies_referal_id) {
                $cookie = new CHttpCookie('referal_id', $referal_id);
                $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year 
                Yii::$app->request->cookies['referal_id'] = $cookie;
            }
        }
        parent::init();
    }

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $defaultLanguage = 'en';

        // Set the application language if provided by GET, session or cookie
        if (isset($_POST['language'])) {
            $newLang = $_POST['language'];
        } else if (isset($_GET['language'])) {
            $newLang = $_GET['language'];
        } else if (isset(Yii::$app->request->cookies['language'])) {
            $newLang = Yii::$app->request->cookies['language']->value;
        } else {
            $newLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        }

        $allowedLanguage = Yii::$app->params['languages'];
        if (isset($allowedLanguage[$newLang])) {
            Yii::$app->language = $newLang;
            $cookie = new CHttpCookie('language', $newLang);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::$app->request->cookies['language'] = $cookie;
            if (isset($_POST['language'])) {
                $this->redirect($newLang);
            }
        } else {
            $cookie = new CHttpCookie('language', $defaultLanguage);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::$app->request->cookies['language'] = $cookie;
            $this->redirect($defaultLanguage);
        }
    }

    public function createMultilanguageReturnUrl($lang = 'en') {
        if (count($_GET) > 0) {
            $arr = $_GET;
            $arr['language'] = $lang;
        }
        else
            $arr = array('language' => $lang);
        return $this->createUrl('', $arr);
    }

    public function block_action($id) {
        if (UserBanList::model()->isBan($id)) {
            Yii::$app->user->setFlash('error', Yii::t('ban', '{user} has blocked you!', array('{user}' => User::model()->findByPk($id)->fio)));
            $this->redirect($this->createUrl("user/user_profile", array('id' => $id)));
            Yii::$app->end();
        }

        if (UserBanList::model()->isMyBan($id)) {
            Yii::$app->user->setFlash('error', Yii::t('ban', 'You <a href="/user/banlist">have blocked</a> {user} !', array('{user}' => User::model()->findByPk($id)->fio)));
            $this->redirect($this->createUrl("user/user_profile", array('id' => $id)));
            Yii::$app->end();
        }
    }

}