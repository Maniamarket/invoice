<?php
namespace app\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use app\models\User;
class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'superadmin') {
                return $role == User::ROLE_SUPERADMIN;
            } elseif ($item->name === 'admin') {
                return $role == User::ROLE_SUPERADMIN || User::ROLE_ADMIN;
            } elseif ($item->name === 'manager') {
                //manager является потомком admin, который получает его права
                return $role == User::ROLE_SUPERADMIN || User::ROLE_ADMIN
                || $role == User::ROLE_MANAGER;
            } elseif ($item->name === 'user') {
                return $role == User::ROLE_SUPERADMIN|| User::ROLE_ADMIN
                || $role == User::ROLE_MANAGER || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}