<?php

use yii\db\Schema;
use yii\db\Migration;

class m141207_115424_init_bd extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Таблица клиентов
        $this->createTable('{{%client}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(40) NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'email' => Schema::TYPE_STRING . '(100) NOT NULL',
            'email_confirm_token' => Schema::TYPE_STRING . ' NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'def_lang_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
            'country_id' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'city' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'street' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'post_index' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'phone' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'password' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('idx_client_user_id', '{{%client}}', 'user_id');
        $this->createIndex('idx_client_email', '{{%client}}', 'email');
        $this->createIndex('idx_client_def_lang_id', '{{%client}}', 'def_lang_id');

        $this->batchInsert('{{%client}}', ['id', 'name', 'user_id', 'email', 'email_confirm_token', 'password_hash',
            'password_reset_token', 'auth_key', 'created_at', 'updated_at', 'def_lang_id', 'country_id', 'city',
            'street', 'post_index', 'phone', 'password'], [
            [1, 'Fedorov', 3, '1@mu.ru', '', '$2y$13$iLuCWhxjnNoQ7E9bm4zlRe5g6okYUaSCfm8hJj11Iyv3gIL2qDTVS', '',
                'LeKPQcSJPBrU9EsnTRg9rI8922OS7q6q', time(), time(), 1, 2, 'Moscwa', '', 2222, '', 'Ys7C'],
            [2, 'Alex', 3, '2@mu.ru', '', '$2y$13$8TnqmIT1jhnfjZiRdj8TFubVn8pC2KQNNgJoD80fhjPHCWWKYZ5Z2', '',
                '1RDxdreA4EvNZBvfPb2Ad1Rc0h8WhMru', time(), time(), 1, 1, '', '', NULL, '', 'N6t'],
            [3, 'Belikov', 3, '3@mu.ru', '', '$2y$13$X.G4KFKIgbkWqFcDDXQGq.sn6xnanKNaDsuZ5kjEP3GW15HI1vAKO', '',
                'BJCNW1HZeCltZ7LrDHoAooDxbj0UBywf', time(), time(), 1, 1, '', '', NULL, '', 'iud'],
        ]);
        // Таблица счет-фактур
        $this->createTable('{{%invoice}}', [
            'id' => Schema::TYPE_PK . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'client_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date' => Schema::TYPE_DATE . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'company_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'service_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'price_service' => Schema::TYPE_DECIMAL . '(10,2) NOT NULL DEFAULT 0',
            'count' => Schema::TYPE_INTEGER . ' NOT NULL',
            'vat' => Schema::TYPE_DECIMAL . '(5,2) NOT NULL DEFAULT 0',
            'tax' => Schema::TYPE_DECIMAL . '(5,2) NOT NULL DEFAULT 0',
            'discount' => Schema::TYPE_DECIMAL . '(5,2) NOT NULL',
            'price' => Schema::TYPE_INTEGER . ' NOT NULL',
            'is_pay' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0',
            'type' => Schema::TYPE_STRING . '(50) DEFAULT "basic"',
        ], $tableOptions);

        $this->createIndex('idx_invoice_user', '{{%invoice}}', 'user_id');
        $this->createIndex('idx_invoice_client', '{{%invoice}}', 'client_id');
        $this->createIndex('idx_invoice_company', '{{%invoice}}', 'company_id');
        $this->createIndex('idx_invoice_service', '{{%invoice}}', 'service_id');

        $this->batchInsert('{{%invoice}}', ['id', 'user_id', 'client_id', 'date', 'name', 'company_id', 'service_id',
            'price_service', 'count', 'vat', 'tax', 'discount', 'price', 'is_pay', 'type'], [
            [1, 3, 1, '2014-12-05', '1', 1, 1, '200.00', 1, 1, '10.00', '1.00', '220.00', 1, '1'],
            [2, 3, 1, '2014-12-05', '1', 1, 1, '500.00', 1, 1, '10.00', '1.00', '550.00', 0, '1']
        ]);

        // Таблица пользователей
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'email_confirm_token' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . ' NOT NULL',
            'role' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_role', '{{%user}}', 'role');
        $this->createIndex('idx_user_status', '{{%user}}', 'status');
        $this->createIndex('idx_user_parent_id', '{{%user}}', 'parent_id');

        $this->batchInsert('{{%user}}', ['id', 'username', 'name', 'password_hash', 'password_reset_token', 'email',
            'email_confirm_token',  'auth_key', 'role', 'status', 'created_at', 'updated_at', 'parent_id'], [
            [1, 'test', '', '$2y$13$B4DPxXs0/GKHt4Z81yiRM.DHwgr5tk4HNyorp1g8VmzWdDtEbMWJW', '', 'test@mail.ru', '', 'OSgDej5fe8zJdRy_N2AshqP3P2e5gTUL', 'user', 10, time(), time(), 0],
            [2, 'manager', '', '$2y$13$Ir6j3GVK.Fdh0l7cM8fsGO2QHCKxTNoKKnCZGlqm25KFXwXdR5kTK', '', 'manager@mail.ru', '', '0pIFtMFMleZ_CmZdK240ti2bNyJBH98L', 'manager', 10, time(), time(), 0],
            [3, 'admin', '', '$2y$13$9dqaQK3viYvdoAAI0Oy0XuUqfiSJ0saJXM2qYQ2A0TzA1QFV56Q6.', '', 'admin@mail.ru', '', 'pI8Z6XtcXeUKQKEJoPYBazoP5-qo3zmv', 'admin', 10, time(), time(), 0],
            [4, 'superadmin', '', '$2y$13$Kqo/vATU4BSO9XT.Xm.jNOz.kIaUBBhCsHm.WHfauI5ZGkDkrXMvK', '', 'superadmin@mail.ru', '', 'MqtOr8ySQ7k2QFMEN3KhX3QBOEw9fDVD', 'superadmin', 10, time(), time(), 0],
        ]);

        // Таблица настроек пользователя
        $this->createTable('{{%setting}}', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL  DEFAULT "no"',
            'credit' => Schema::TYPE_DECIMAL . '(12,2) NOT NULL  DEFAULT 0',
            'def_vat_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'def_company_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'def_lang_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'bank_code' => Schema::TYPE_STRING . '(100) NOT NULL  DEFAULT "no"',
            'account_number' => Schema::TYPE_STRING . '(100) NOT NULL DEFAULT 0',
            'last_login' => Schema::TYPE_DATETIME . ' NOT NULL DEFAULT 0',
            'is_on' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1',
            'country' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'city' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'street' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'post_index' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'phone' => Schema::TYPE_STRING . '(100) DEFAULT NULL',
            'web_site' => Schema::TYPE_BOOLEAN . ' DEFAULT NULL',
            'surtax' => Schema::TYPE_DECIMAL . '(5,2) DEFAULT NULL',
        ], $tableOptions);

        $this->addPrimaryKey('idx_setting_primary', '{{%setting}}', 'user_id');
        $this->createIndex('idx_setting_def_vat_id', '{{%setting}}', 'def_vat_id');
        $this->createIndex('idx_setting_def_company_id', '{{%setting}}', 'def_company_id');
        $this->createIndex('idx_setting_def_lang_id', '{{%setting}}', 'def_lang_id');

        $this->batchInsert('{{%setting}}', ['user_id', 'name', 'credit', 'def_vat_id', 'def_company_id', 'def_lang_id',
            'bank_code', 'account_number', 'last_login', 'is_on', 'country','city', 'street', 'post_index', 'phone', 'web_site', 'surtax'], [
            [1, 'no', 0, 3, 2, 2, '1111111111', '1111111111', '2014-12-01 00:00:00', 1, 'yyyy', 'yyy', 'yyy', 999999, '67895909', 'tururt', 5],
            [2, 'no', 0, 1, 1, 1, 'no', 'no', '2014-12-04 12:39:39', 1, 'qq', 'qq', 'qq', 11, 'qq', 'www', 5],
            [3, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 'qq', 5],
            [4, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 'qq', 5],
        ]);


        // Таблица компаний
        $this->createTable('{{%company}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'logo' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'country_id' => Schema::TYPE_INTEGER . ' DEFAULT 1',
            'city' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'street' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'post_index' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'phone' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'web_site' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'mail' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'vat_number' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'activity' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'resp_person' => Schema::TYPE_STRING . ' DEFAULT NULL',
        ], $tableOptions);

        $this->createIndex('idx_company_email', '{{%client}}', 'email');

        $this->batchInsert('{{%company}}', ['id', 'name', 'logo', 'country_id', 'city', 'street', 'post_index', 'phone',
            'web_site', 'mail', 'vat_number', 'activity', 'resp_person'], [
            [1, 'google', 'Google.jpg', 1, 'Moscow', 'Lenina 1', 60000, '22222222', '22', '22', '22', '22', '22'],
            [2, 'microsoft', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [3, 'gregsys', '', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL],
            [4, 'bmw', '', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL]
        ]);

        // Таблица скидок
        $this->createTable('{{%income}}', [
            'id' => Schema::TYPE_PK,
            'from' => Schema::TYPE_INTEGER . ' NOT NULL',
            'to' => Schema::TYPE_INTEGER . ' NOT NULL',
            'manager' => Schema::TYPE_FLOAT . ' NOT NULL',
            'admin' => Schema::TYPE_FLOAT . ' NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%income}}', ['id', 'from', 'to', 'manager', 'admin'], [
            [1, 0, 1000, 1.5, 1],
            [2, 1000, 10000, 1.5, 1],
            [3, 10000, 100000, 1.8, 1.1],
            [4, 100000, 1000000, 2, 1.2],
            [5, 1000000, 10000000, 2.5, 1.5]
        ]);

        // Таблица языков
        $this->createTable('{{%lang}}', [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'local' => Schema::TYPE_STRING . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'default' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'date_update' => Schema::TYPE_INTEGER . ' NOT NULL',
            'date_create' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%lang}}', ['id', 'url', 'local', 'name', 'default', 'date_update', 'date_create'], [
            [1, 'en', 'en-US', 'English', 0, time(), time()],
            [2, 'ru', 'ru-RU', 'Русский', 1, time(), time()]
        ]);

        // Таблица платежей
        $this->createTable('{{%payment}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(40) NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%payment}}', ['id', 'name'], [
            [1, 'Bank card'],
            [2, 'PayPal'],
            [3, 'Банковский перевод']
         ]);

        // Таблица сервисов
        $this->createTable('{{%service}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%service}}', ['id', 'name'], [
            [1, 'service1'],
            [2, 'service2'],
            [3, 'Сервис3']
        ]);

        // Таблица подоходных налогов
        $this->createTable('{{%surtax}}', [
            'id' => Schema::TYPE_PK,
            'percent' => Schema::TYPE_DECIMAL . '(5,2) NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%surtax}}', ['id', 'percent'], [
            [1, '20.00']
        ]);

        $this->createTable('{{%vat}}', [
            'id' => Schema::TYPE_PK,
            'percent' => Schema::TYPE_INTEGER . '(3) NOT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%vat}}', ['id', 'percent'], [
            [1, 2],
            [2, 3],
            [3, 4],
            [4, 6]
        ]);
    }

    public function down()
    {
        echo "m141207_115424_init_bd cannot be reverted.\n";

        return false;
    }
}
