<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//use app\components\LanguageSelector;

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions() {
	return array(
	    // captcha action renders the CAPTCHA image displayed on the contact page
	    'captcha' => array(
		'class' => 'yii\captcha\CaptchaAction',
		'backColor' => 0xFFFFFF,
	    ),
	    // page action renders "static" pages stored under 'protected/views/site/pages'
	    // They can be accessed via: index.php?r=site/page&view=FileName
	    'page' => array(
		'class' => 'CViewAction',
	    ),
	);
    }

    public function accessRules() {
        return array('allow', 'actions' => array('captcha'), 'users' => array('*'));
    }

/*    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!\Yii::$app->user->can($action->id)) {
                throw new ForbiddenHttpException('Access denied');
            }
            return true;
        } else {
            return false;
        }
    }*/

    public function __construct($id, $module = null, $config = []) {
        parent::__construct($id, $module);
        // If there is a post-request, redirect the application to the provided url of the selected language
        if (isset($_POST['language'])) {
            $lang = $_POST['language'];
            $MultilangReturnUrl = $_POST[$lang];
            $this->redirect($MultilangReturnUrl);
        }
// Set the application language if provided by GET, session or cookie
        if (isset($_GET['language'])) {
            Yii::$app->language = $_GET['language'];
            Yii::$app->user->setState('language', $_GET['language']);
            $cookie = new HttpCookie('language', $_GET['language']);
            $cookie->expire = time() + (60 * 60 * 24 * 365); // (1 year)
            Yii::$app->request->cookies['language'] = $cookie;
        } /*else if (Yii::$app->user->hasState('language'))
            Yii::$app->language = Yii::$app->user->getState('language');*/
        else if (isset(Yii::$app->request->cookies['language']))
            Yii::$app->language = Yii::$app->request->cookies['language']->value;
    }

/**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
	// renders the view file 'protected/views/site/index.php'
	// using the default layout 'protected/views/layouts/main.php'
	    return $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
	if ($error = Yii::app()->errorHandler->error) {
	    if (Yii::app()->request->isAjaxRequest)
		echo $error['message'];
	    else
            return $this->render('error', $error);
	}
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
	$model = new ContactForm;
	if (isset($_POST['ContactForm'])) {
	    $model->attributes = $_POST['ContactForm'];
	    if ($model->validate()) {
		$name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
		$subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
		$headers = "From: $name <{$model->email}>\r\n" .
			"Reply-To: {$model->email}\r\n" .
			"MIME-Version: 1.0\r\n" .
			"Content-Type: text/plain; charset=UTF-8";

		mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
		Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
		$this->refresh();
	    }
	}
        return $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the register page
     */
    public function actionRegister() {
	$model = new RegisterForm;
	
	
	//
	// collect user input data
	if (isset($_POST['RegisterForm'])) {
	   
	    //echo '<pre>'; print_r($_POST); exit;
	    
	    $model->attributes = $_POST['RegisterForm'];    
	    $this->performAjaxValidation($model);
	    
	    //echo '<pre>'; print_r($model); exit;
	    
	    $newUser = new User;
	    $newSetting = new Setting;
	    
	    $newUser->attributes = $_POST['RegisterForm'];	    
	    $newUser->setAttributes(array(
		'register_date' => date('Y-m-d H:i:s'),
		'last_login' => date('Y-m-d H:i:s'),
	    ));
	    
	    $newUser->user_id = uniqid();
	    $rawPass = $newUser->password;
	    $newUser->password = md5($newUser->password);
	    
	     //echo '<pre>';
	    //print_r($newUser->attributes); exit;
	
	    if ($newUser->validate() && $model->validate()) {
		if ($newUser->save()) {
		    if (empty($newUser->parent_id)) {
			$sql = "UPDATE user SET parent_id = LAST_INSERT_ID() WHERE id = LAST_INSERT_ID()";
			Yii::app()->db->createCommand($sql)->execute();			
		    }
		    $newSetting->user_id = $newUser->id;
		    $newSetting->save();
		    
		    $body = 'Dear '.$newUser->name.'. Thank you for registering.'."\r\n";
		    $body .= 'Your login - '.$newUser->user_id."\r\n";
		    $body .= 'Your password - '.$rawPass."\r\n";
		    
		    $name = '=?UTF-8?B?' . base64_encode('Logistic Biling System') . '?=';
		    $subject = '=?UTF-8?B?' . base64_encode('Registration information') . '?=';
		    $headers = "From: $name <".Yii::app()->params['adminEmail'].">\r\n" .
			    "Reply-To: ".Yii::app()->params['adminEmail']."\r\n" .
			    "MIME-Version: 1.0\r\n" .
			    "Content-Type: text/plain; charset=UTF-8";

		    if (mail($newUser->mail, $subject, $body, $headers)) {
			Yii::app()->user->setFlash('success', 'Registration Successful. Registration information send to your mail.');
			//$this->refresh();
			$model->unsetAttributes();
			$this->redirect(Yii::app()->user->returnUrl);
			
		    }

		    /*
		    
		    //print_r($rawPass); exit;
		    $identity = new UserIdentity($newUser->user_id, $rawPass);
		    $identity->authenticate();
		    
		    
		    if ($identity->errorCode === UserIdentity::ERROR_NONE) {
			//$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
			$duration = 3600 * 24 * 30; // 30 days
			Yii::app()->user->login($identity, $duration);
			$newUser->unsetAttributes();
			$newSetting->unsetAttributes();
			//$this->redirect(array('site/index', 'id' => $newUser->id));
			$this->redirect('/index.php/site/index');			
		    }
		    */
		}
	    }	   
	}
	// display the register form
        return $this->render('register', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
	Yii::app()->user->logout();
	$this->redirect(Yii::app()->homeUrl);
    }
    
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }


}
