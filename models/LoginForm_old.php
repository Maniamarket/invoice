<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
	return array(
	    // username and password are required
	    array('username, password', 'required'),
	    // rememberMe needs to be a boolean
	    array('rememberMe', 'boolean'),
	    // password needs to be authenticated
	    array('password', 'authenticate'),
	);
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
	return array(
	    'rememberMe' => 'Remember me next time',
	);
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
	if (!$this->hasErrors()) {
	    $this->_identity = new UserIdentity($this->username, $this->password);
	    if (!$this->_identity->authenticate())
		$this->addError('password', 'Incorrect username or password.');
	}
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        } else {
            return false;
        }
/*	if ($this->_identity === null) {
	    $this->_identity = new UserIdentity($this->username, $this->password);
	    $this->_identity->authenticate();
	}
	if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {	    
	    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
	    Yii::app()->user->login($this->_identity, $duration);
	    return true;
	} else
	    return false;*/
    }

}
