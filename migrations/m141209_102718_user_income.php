<?php

use yii\db\Schema;
use yii\db\Migration;

class m141209_102718_user_income extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Таблица клиентов
        $this->createTable('{{%user_income}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'credit' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATETIME . ' NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'profit_manager' => Schema::TYPE_DECIMAL . '(12,2) NOT NULL DEFAULT 0.000',
            'profit_admin'  => Schema::TYPE_DECIMAL . '(12,2) NOT NULL DEFAULT 0.000',
        ], $tableOptions);

        $this->createIndex('idx_user_income_user_id', '{{%user_income}}', 'user_id');

        $this->batchInsert('{{%user_income}}', ['id', 'user_id', 'credit', 'date',
            'parent_id', 'profit_manager', 'profit_admin'], [
            [1, 3, '30.000', '2014-12-09 14:16:23', 0, '0.00', '0.00'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user_income}}');
    }
}
