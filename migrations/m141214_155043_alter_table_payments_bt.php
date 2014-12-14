<?php

use yii\db\Schema;
use yii\db\Migration;

class m141214_155043_alter_table_payments_bt extends Migration
{
    public function up()
    {
	$this->addColumn('payment_bt', 'sum',  'INT(11) AFTER `file`');
	$this->addColumn('payment_bt', 'status',  'ENUM("0","1","2") NOT NULL DEFAULT "0"');
	$this->addColumn('payment_bt', 'date',  'INT(11)');
    }

    public function down()
    {
        echo "m141214_155043_alter_table_payments_bt cannot be reverted.\n";

        return false;
    }
}
