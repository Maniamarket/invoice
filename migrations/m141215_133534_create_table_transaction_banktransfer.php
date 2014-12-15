<?php

use yii\db\Schema;
use yii\db\Migration;

class m141215_133534_create_table_transaction_banktransfer extends Migration {

    public function up() {
	$tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Таблица клиентов
        $this->createTable('{{%transaction_banktransfer}}', [
            'id' => Schema::TYPE_PK,
            't_id' => Schema::TYPE_INTEGER . ' NOT NULL',            
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => "enum('0','1','2') NOT NULL",
            'type' => "enum('0','1') NOT NULL",
            'date' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
    }

    public function down() {
	echo "m141215_133534_create_table_transaction_banktransfer cannot be reverted.\n";

	return false;
    }

}
