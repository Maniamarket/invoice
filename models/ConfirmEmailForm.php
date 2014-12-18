<?php

namespace app\models;

use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class ConfirmEmailForm extends Model {

    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array $config
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = []) {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Отсутствует код подтверждения.');
        }
        $this->_user = User::findByEmailConfirmToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Неверный токен.');
        }
        parent::__construct($config);
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function confirmEmail() {
        $user = $this->_user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();

        return $user->save();
    }

    /**
     * Resets password.
     *
     * @return void
     */
    public function sendWelcomeEmail() {
        Yii::$app->mailer->compose('welcome', ['user' => $user])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($user->email)
                ->setSubject('Welcome')
                ->send();
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        return $this->_user;
    }

}
