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
            'credit_sum' => Schema::TYPE_DECIMAL . '(12,3) NOT NULL DEFAULT 0.000',
            'profit_parent'  => Schema::TYPE_DECIMAL . '(12,3) NOT NULL DEFAULT 0.000',
        ], $tableOptions);

        $this->createIndex('idx_user_payment_user_id', '{{%user_payment}}', 'user_id');

        $this->batchInsert('{{%user_payment}}', ['id', 'user_id', 'credit', 'is_input', 'date', 'credit_sum', 'profit_parent'], [
            [1, 4, 5, 1, '2014-12-09 11:33:43', '0.000', '0.000'],
            [2, 4, 5, 1, '2014-12-09 11:36:14', '0.000', '0.000'],
            [3, 4, 5, 1, '2014-12-09 11:38:32', '0.000', '0.000']
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user_payment}}');
    }
}
