<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupAdminForm extends Model
{
   // public $username;
    public $email;
    public $password;

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
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($role,$type)
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->setPassword('123456');
            $user->role = $role;
            $user->generateAuthKey();
            $user->save();
            $user->username = $user->id;
            $password = 'user_'.$user->id;
            $user->setPassword($password);
            $this->setOwner($user, $type);
            $user->save();
            Yii::$app->mailer->compose('welcome_admin', ['user' => $user,'password' => $password])
                ->setFrom('no-reply@site.ru')
                ->setTo($user->email)
                ->setSubject('Welcome')
                ->send();
            return $user;
        }

        return null;
    }
    
    public function setOwner($user, $type)
    {
        switch ( $type){
            case  2 : $user->manager_id = Yii::$app->user->id;  return true;
            case  3 : $user->admin_id = Yii::$app->user->id;  return true;
            case  4 : $user->admin_id = Yii::$app->user->id;  return true;
        }
    }
}
