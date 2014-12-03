<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\rbac\DbManager;
use app\components\rbac\UserRoleRule;
//use app\rbac\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
/*        $r=new DbManager;
        $r->init();
        $user = $r->createRole('user');
        $r->add($user);*/

        $auth = Yii::$app->authManager;
//        $auth = new DbManager;
//        $auth->init();
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = 'Админ панель';
        $auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $moder = $auth->createRole('manager');
        $moder->description = 'Менеджер';
        $moder->ruleName = $rule->name;
        $auth->add($moder);
        //Добавляем потомков
        $auth->addChild($moder, $user);
        $auth->addChild($moder, $dashboard);
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $moder);

/*        $authManager = Yii::$app->authManager;

        // Create roles
        $guest  = $authManager->createRole('guest');
        $user  = $authManager->createRole('USER');
        $manager = $authManager->createRole('MANAGER');
        $admin  = $authManager->createRole('ADMIN');
        $superadmin  = $authManager->createRole('SUPERADMIN');

        // Create simple, based on action{$NAME} permissions
        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error  = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('sign-up');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        // Add permissions in Yii::$app->authManager
        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);


        // Add rule, based on UserExt->group === $user->group
        $userGroupRule = new UserGroupRule();
        $authManager->add($userGroupRule);

        // Add rule "UserGroupRule" in roles
        $guest->ruleName  = $userGroupRule->name;
        $user->ruleName  = $userGroupRule->name;
        $manager->ruleName = $userGroupRule->name;
        $admin->ruleName  = $userGroupRule->name;

        // Add roles in Yii::$app->authManager
        $authManager->add($guest);
        $authManager->add($user);
        $authManager->add($manager);
        $authManager->add($admin);
        $authManager->add($superadmin);

        // Add permission-per-role in Yii::$app->authManager
        // Guest
        $authManager->addChild($guest, $login);
        $authManager->addChild($guest, $logout);
        $authManager->addChild($guest, $error);
        $authManager->addChild($guest, $signUp);
        $authManager->addChild($guest, $index);
        $authManager->addChild($guest, $view);

        // USER
        $authManager->addChild($user, $update);
        $authManager->addChild($user, $guest);

        // MANAGER
        $authManager->addChild($manager, $update);
        $authManager->addChild($manager, $guest);

        // ADMIN
        $authManager->addChild($admin, $delete);
        $authManager->addChild($admin, $user);
        $authManager->addChild($admin, $manager);

        // SUPERADMIN
        $authManager->addChild($superadmin, $delete);
        $authManager->addChild($superadmin, $user);
        $authManager->addChild($superadmin, $manager);
        $authManager->addChild($superadmin, $admin);*/
    }
}
