<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\db\Schema;
use yii\rbac\DbManager;
use app\components\rbac\GroupRule;

/**
 * Initializes RBAC tables
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @modified Dmitry Khe <xedmitry@yandex.ru>
 * @since 3.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    public function up()
    {
        $authManager = new DbManager;
        $authManager->init();

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($authManager->ruleTable, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => Schema::TYPE_STRING . '(64)',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id' => Schema::TYPE_STRING . '(64) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $authManager->removeAll(); //удаляем старые данные
        // Rules
        $groupRule = new GroupRule();

        $authManager->add($groupRule);

        // Roles
        $user = $authManager->createRole('user');
        $user->description = 'User';
        $user->ruleName = $groupRule->name;
        $authManager->add($user);
        // связываем пользователя с id=1 c ролью User
        $authManager->assign($user, 1);

        $manager = $authManager->createRole('manager');
        $manager->description = 'Manager';
        $manager->ruleName = $groupRule->name;
        $authManager->add($manager);
        $authManager->addChild($manager, $user);
        // связываем пользователя с id=1 c ролью Manager
        $authManager->assign($manager, 2);

        $admin = $authManager->createRole('admin');
        $admin->description = 'Admin';
        $admin->ruleName = $groupRule->name;
        $authManager->add($admin);
        $authManager->addChild($admin, $manager);
        // связываем пользователя с id=1 c ролью Admin
        $authManager->assign($admin, 3);

        $superadmin = $authManager->createRole('superadmin');
        $superadmin->description = 'Superadmin';
        $superadmin->ruleName = $groupRule->name;
        $authManager->add($superadmin);
        $authManager->addChild($superadmin, $admin);
        // связываем пользователя с id=1 c ролью Superadmin
        $authManager->assign($superadmin, 4);
    }

    public function down()
    {
        $authManager = $this->getAuthManager();

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }
}
