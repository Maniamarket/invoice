<?php

use yii\db\Schema;
use yii\db\Migration;

class m141209_054746_user_payment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Таблица клиентов
        $this->createTable('{{%user_payment}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'credit' => Schema::TYPE_INTEGER . ' NOT NULL',
            'is_input' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'date' => Schema::TYPE_DATETIME . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('idx_user_payment_user_id', '{{%user_payment}}', 'user_id');

        $this->batchInsert('{{%user_payment}}', ['id', 'user_id', 'credit', 'is_input', 'date'], [
            [1, 4, 5, 1, '2014-12-09 11:33:43'],
            [2, 4, 5, 1, '2014-12-09 11:36:14'],
            [3, 4, 5, 1, '2014-12-09 11:38:32']
        ]);
    }

    public function down()
    {
        $this->dropTable('user_payment');
        return false;
    }
}
