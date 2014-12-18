<?php

namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    // public $username;
    public $email;
    public $password;

    /**
     * @var string
     */
    public $captcha;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            /*    ['username', 'filter', 'filter' => 'trim'],
              ['username', 'required'],
              ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
              ['username', 'string', 'min' => 2, 'max' => 255],
             */
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'captcha'], 'required'],
            ['email', 'email'],
            ['captcha', 'captcha', 'captchaAction' => '/site/captcha'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();
            $user->save();
            $user->username = $user->id;            
            $user->save();          
            
            if ($user->save()) {
                Yii::$app->mailer->compose('confirmEmail', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Email confirmation for ' . Yii::$app->name)
                    ->send();
            }
            return $user;
        }

        return null;
    }

}
