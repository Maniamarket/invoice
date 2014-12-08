<?php

use yii\db\Schema;
use yii\db\Migration;

class m141208_155833_translit extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%translit}}', [
            'id' => Schema::TYPE_PK,
            'from_lang_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'to_lang_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'from_symbol' => Schema::TYPE_STRING . '(8) NOT NULL',
            'to_symbol' => Schema::TYPE_STRING . '(8) NOT NULL',
        ], $tableOptions);

        $this->createIndex('FK_from_lang', '{{%translit}}', 'from_lang_id');
        $this->addForeignKey(
            'FK_from_lang', '{{%translit}}', 'from_lang_id', '{{%lang}}', 'id', 'NO ACTION', 'CASCADE'
        );

        $this->createIndex('FK_to_lang', '{{%translit}}', 'to_lang_id');
        $this->addForeignKey(
            'FK_to_lang', '{{%translit}}', 'to_lang_id', '{{%lang}}', 'id', 'NO ACTION', 'CASCADE'
        );

    }

    public function down()
    {
        echo "m141208_155833_translit cannot be reverted.\n";

        return false;
    }
}
