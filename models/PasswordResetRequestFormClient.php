<?php
namespace app\models;
use app\models\Client;
use app\models\User;
use yii\base\Model;
/**
 * Password reset request form
 */
class PasswordResetRequestFormClient extends Model
{
    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\Client',
                'message' => 'There is no client with such email.'
            ],
        ];
    }
    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $client User */
        $client = Client::findOne([ 'email' => $this->email,]);
        if ($client) {
            if (!Client::isPasswordResetTokenValid($client->password_reset_token)) {
                $client->generatePasswordResetToken();
            }
            if ($client->save()) {
                return \Yii::$app->mailer->compose('passwordResetTokenClient', ['client' => $client])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }
        return false;
    }
}