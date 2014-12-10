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

        $this->batchInsert('{{%translit}}', ['id', 'from_lang_id', 'to_lang_id', 'from_symbol', 'to_symbol'], [
            [1, 1, 2, 'а', 'a'], [2, 1, 2, 'б', 'b'], [3, 1, 2, 'в', 'v'], [4, 1, 2, 'г', 'g'],
            [5, 1, 2, 'д', 'd'], [6, 1, 2, 'е', 'e'], [7, 1, 2, 'ё', 'e'], [8, 1, 2, 'ж', 'zh'],
            [9, 1, 2, 'з', 'z'], [10, 1, 2, 'и', 'i'], [11, 1, 2, 'й', 'y'], [12, 1, 2, 'к', 'k'],
            [13, 1, 2, 'л', 'l'], [14, 1, 2, 'м', 'm'], [15, 1, 2, 'н', 'n'], [16, 1, 2, 'о', 'o'],
            [17, 1, 2, 'п', 'p'], [18, 1, 2, 'р', 'r'], [19, 1, 2, 'с', 's'], [20, 1, 2, 'т', 't'],
            [21, 1, 2, 'у', 'u'], [22, 1, 2, 'ф', 'f'], [23, 1, 2, 'х', 'h'], [24, 1, 2, 'ц', 'c'],
            [25, 1, 2, 'ч', 'ch'], [26, 1, 2, 'ш', 'sh'], [27, 1, 2, 'щ', 'sch'], [28, 1, 2, 'ь', '\''],
            [29, 1, 2, 'ы', 'y'], [30, 1, 2, 'ъ', '\''], [31, 1, 2, 'э', 'e'], [32, 1, 2, 'ю', 'yu'],
            [33, 1, 2, 'я', 'ya'], [34, 1, 2, 'А', 'A'], [35, 1, 2, 'Б', 'B'], [36, 1, 2, 'В', 'V'],
            [37, 1, 2, 'Г', 'G'], [38, 1, 2, 'Д', 'D'], [39, 1, 2, 'Е', 'E'], [40, 1, 2, 'Ё', 'E'],
            [41, 1, 2, 'Ж', 'Zh'], [42, 1, 2, 'З', 'Z'], [43, 1, 2, 'И', 'I'], [44, 1, 2, 'Й', 'Y'],
            [45, 1, 2, 'К', 'K'], [46, 1, 2, 'Л', 'L'], [47, 1, 2, 'М', 'M'], [48, 1, 2, 'Н', 'N'],
            [49, 1, 2, 'О', 'O'], [50, 1, 2, 'П', 'P'], [51, 1, 2, 'Р', 'R'], [52, 1, 2, 'С', 'S'],
            [53, 1, 2, 'Т', 'T'], [54, 1, 2, 'У', 'U'], [55, 1, 2, 'Ф', 'F'], [56, 1, 2, 'Х', 'H'],
            [57, 1, 2, 'Ц', 'C'], [58, 1, 2, 'Ч', 'Ch'], [59, 1, 2, 'Ш', 'Sh'], [60, 1, 2, 'Щ', 'Sch'],
            [61, 1, 2, 'Ь', '\''], [62, 1, 2, 'Ы', 'Y'], [63, 1, 2, 'Ъ', '\''], [64, 1, 2, 'Э', 'E'],
            [65, 1, 2, 'Ю', 'Yu'], [66, 1, 2, 'Я', 'Ya'],

        ]);


    }

    public function down()
    {
        echo "m141208_155833_translit cannot be reverted.\n";

        return false;
    }
}
