<?php
namespace app\models;

use app\models\Client;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupClientForm extends Model
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
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    /**
     * Signs client up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $client = new Client();
            $client->email = $this->email;
            $client->user_id = Yii::$app->user->id;
            $password = $this->generateRandomPassword();
            $client->password = $password;
//Yii::$app->session['password']= $password;
            $client->setPassword($password);
            $client->generateAuthKey();
            $client->save();
            Yii::$app->mailer->compose('welcome_client', ['user' => $client,'password' => $password])
                ->setFrom('no-reply@site.ru')
                ->setTo($client->email)
                ->setSubject('Welcome')
                ->send();
 //echo 'pass='.$password; exit();
            return $client;
        }

        return null;
    }
    
    function generateRandomPassword() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
        $password = '';
//        $desired_length = rand(8, 12);
        $desired_length = rand(3, 4);

        for($length = 0; $length < $desired_length; $length++) {
          $index = rand(0, $count - 1);
          $password .= mb_substr($chars, $index, 1);
        }
        return $password;
    }
}
