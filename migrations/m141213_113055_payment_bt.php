<?php

use yii\db\Schema;
use yii\db\Migration;

class m141213_113055_payment_bt extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Таблица клиентов
        $this->createTable('{{%payment_bt}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'message' => Schema::TYPE_STRING . ' NOT NULL',
            'file' => Schema::TYPE_STRING . ' NOT NULL',
            'sum' => Schema::TYPE_INTEGER . ' ',
            'status' =>  'ENUM("0","1","2") NOT NULL DEFAULT "0"',
            'date' =>  Schema::TYPE_INTEGER . ' ',
        ], $tableOptions);

        $this->createIndex('idx_payment_bt_user_id', '{{%payment_bt}}', 'user_id');

    }

    public function down()
    {
        $this->dropTable('{{%payment_bt}}');
    }
}
