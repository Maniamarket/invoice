-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 08 2014 г., 19:30
-- Версия сервера: 5.5.38-log
-- Версия PHP: 5.5.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `invoice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '3', 1418034393),
('manager', '2', 1418034393),
('superadmin', '4', 1418034393),
('user', '1', 1418034393);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin', 'group', NULL, 1418034393, 1418034393),
('manager', 1, 'Manager', 'group', NULL, 1418034393, 1418034393),
('superadmin', 1, 'Superadmin', 'group', NULL, 1418034393, 1418034393),
('user', 1, 'User', 'group', NULL, 1418034393, 1418034393);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('superadmin', 'admin'),
('admin', 'manager'),
('manager', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('group', 'O:29:"app\\components\\rbac\\GroupRule":3:{s:4:"name";s:5:"group";s:9:"createdAt";i:1418034393;s:9:"updatedAt";i:1418034393;}', 1418034393, 1418034393);

-- --------------------------------------------------------

--
-- Структура таблицы `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_confirm_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `def_lang_id` int(11) NOT NULL DEFAULT '1',
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_client_user_id` (`user_id`),
  KEY `idx_client_email` (`email`),
  KEY `idx_client_def_lang_id` (`def_lang_id`),
  KEY `idx_company_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `name`, `user_id`, `email`, `email_confirm_token`, `password_hash`, `password_reset_token`, `auth_key`, `created_at`, `updated_at`, `def_lang_id`, `country`, `city`, `street`, `post_index`, `phone`, `password`) VALUES
(1, 'Fedorov', 4, '1@mu.ru', '', '$2y$13$iLuCWhxjnNoQ7E9bm4zlRe5g6okYUaSCfm8hJj11Iyv3gIL2qDTVS', '', 'LeKPQcSJPBrU9EsnTRg9rI8922OS7q6q', 1418034393, 1418034393, 1, 'Russia', 'Moscwa', '', 2222, '', 'Ys7C'),
(2, 'Alex', 4, '2@mu.ru', '', '$2y$13$8TnqmIT1jhnfjZiRdj8TFubVn8pC2KQNNgJoD80fhjPHCWWKYZ5Z2', '', '1RDxdreA4EvNZBvfPb2Ad1Rc0h8WhMru', 1418034393, 1418034393, 1, '', '', '', NULL, '', 'N6t'),
(3, 'Belikov', 4, '3@mu.ru', '', '$2y$13$X.G4KFKIgbkWqFcDDXQGq.sn6xnanKNaDsuZ5kjEP3GW15HI1vAKO', '', 'BJCNW1HZeCltZ7LrDHoAooDxbj0UBywf', 1418034393, 1418034393, 1, '', '', '', NULL, '', 'iud');

-- --------------------------------------------------------

--
-- Структура таблицы `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_site` int(11) DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resp_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `country`, `city`, `street`, `post_index`, `phone`, `web_site`, `mail`, `vat_number`, `activity`, `resp_person`) VALUES
(1, 'google', 'cat1.jpg', 'Russia', 'Moscow', 'Lenina 1', 60000, '22222222', 22, '22', '22', '22', '22'),
(2, 'microsoft', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'gregsys', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'bmw', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id товара',
  `invoice_id` int(11) NOT NULL COMMENT 'id счет-фактуры',
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование товара',
  `measure_id` int(11) NOT NULL COMMENT 'id единицы измерения',
  `amount` int(11) NOT NULL COMMENT 'Количество товара',
  `price` decimal(10,2) NOT NULL COMMENT 'Цена за единицу',
  `excise` decimal(10,2) DEFAULT NULL COMMENT 'Сумма акциза',
  `tax` decimal(4,2) DEFAULT NULL COMMENT 'Налоговая ставка',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `invoice_id`, `name`, `measure_id`, `amount`, `price`, `excise`, `tax`) VALUES
(1, 1, 'Косоролики', 1, 1, '10.00', NULL, '18.00'),
(2, 1, 'Кособобики', 1, 1, '11.30', NULL, '18.00');

-- --------------------------------------------------------

--
-- Структура таблицы `income`
--

CREATE TABLE IF NOT EXISTS `income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `manager` float NOT NULL,
  `admin` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `income`
--

INSERT INTO `income` (`id`, `from`, `to`, `manager`, `admin`) VALUES
(1, 1000, 10000, 1.5, 1),
(2, 10000, 100000, 1.8, 1.1),
(3, 100000, 1000000, 2, 1.2),
(4, 1000000, 10000000, 2.5, 1.5);

-- --------------------------------------------------------

--
-- Структура таблицы `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `price_service` decimal(12,0) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `vat` decimal(5,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(5,2) NOT NULL DEFAULT '0.00',
  `discount` int(3) NOT NULL,
  `price` int(11) NOT NULL,
  `is_pay` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finished` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_invoice_user` (`user_id`),
  KEY `idx_invoice_client` (`client_id`),
  KEY `idx_invoice_company` (`company_id`),
  KEY `idx_invoice_service` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `invoice`
--

INSERT INTO `invoice` (`id`, `user_id`, `client_id`, `date`, `name`, `company_id`, `service_id`, `price_service`, `count`, `vat`, `tax`, `discount`, `price`, `is_pay`, `type`, `finished`) VALUES
('1', 1, 1, '2014-12-05', '1', 1, 1, '0', 1, '1.00', '0.00', 1, 1, 1, '1', 0),
('2', 1, 1, '2014-12-05', '1', 1, 1, '0', 1, '1.00', '0.00', 1, 1, 1, '1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `lang`
--

INSERT INTO `lang` (`id`, `name`) VALUES
(1, 'Russia'),
(2, 'English');

-- --------------------------------------------------------

--
-- Структура таблицы `measures`
--

CREATE TABLE IF NOT EXISTS `measures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Код единицы измерения',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Единица измерения',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `measures`
--

INSERT INTO `measures` (`id`, `code`, `name`) VALUES
(1, '796', 'шт'),
(2, '166', 'кг');

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1418034389),
('m140506_102106_rbac_init', 1418034393),
('m141207_115424_init_bd', 1418034394);

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `name`) VALUES
(1, 'Bank card'),
(2, 'PayPal'),
(3, 'Банковский перевод');

-- --------------------------------------------------------

--
-- Структура таблицы `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `currency` char(3) DEFAULT 'EUR',
  `curs` float DEFAULT NULL,
  `equivalent` float DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_system_id` int(11) NOT NULL,
  `complete` tinyint(1) DEFAULT '0',
  `type` int(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pay_sys_id` (`payment_system_id`),
  KEY `balance` (`user_id`,`complete`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_old`
--

CREATE TABLE IF NOT EXISTS `payment_old` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_system`
--

CREATE TABLE IF NOT EXISTS `payment_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(128) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sellers`
--

CREATE TABLE IF NOT EXISTS `sellers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование продавца',
  `address` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Адрес продавца',
  `inn` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ИНН продавца',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `address`, `inn`) VALUES
(1, 'ЗАО "Все продам"', 'г. Неизвестный ул. Без имени д.112', '786534652985'),
(2, 'ООО "Рога и копыта"', 'г. Приморск ул. Ленина д.2', '754642308479');

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `name`) VALUES
(1, 'service1'),
(2, 'service2'),
(3, 'Сервис3');

-- --------------------------------------------------------

--
-- Структура таблицы `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `credit` int(11) NOT NULL DEFAULT '0',
  `def_vat_id` int(11) NOT NULL DEFAULT '0',
  `def_company_id` int(11) NOT NULL DEFAULT '0',
  `def_lang_id` int(11) NOT NULL DEFAULT '0',
  `bank_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `account_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_on` tinyint(1) NOT NULL DEFAULT '1',
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_site` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_setting_def_vat_id` (`def_vat_id`),
  KEY `idx_setting_def_company_id` (`def_company_id`),
  KEY `idx_setting_def_lang_id` (`def_lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `setting`
--

INSERT INTO `setting` (`user_id`, `name`, `credit`, `def_vat_id`, `def_company_id`, `def_lang_id`, `bank_code`, `account_number`, `last_login`, `is_on`, `country`, `city`, `street`, `post_index`, `phone`, `web_site`) VALUES
(1, 'no', 0, 3, 2, 2, '1111111111', '1111111111', '2014-12-01 00:00:00', 1, 'yyyy', 'yyy', 'yyy', 999999, '67895909', 0),
(2, 'no', 0, 1, 1, 1, 'no', 'no', '2014-12-04 12:39:39', 1, 'qq', 'qq', 'qq', 11, 'qq', 0),
(3, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 0),
(4, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 0),
(6, '', 0, 0, 0, 0, 'no', 'no', '2014-12-07 11:39:47', 1, '', '', '', NULL, '', NULL),
(7, '', 0, 1, 1, 1, 'no', 'no', '2014-12-07 15:05:00', 1, '', '', '', NULL, '', NULL),
(8, '', 0, 0, 0, 0, 'no', 'no', '2014-12-07 16:20:27', 1, '', '', '', NULL, '', NULL),
(9, '', 0, 0, 0, 0, 'no', 'no', '2014-12-07 16:31:05', 1, '', '', '', NULL, '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `surtax`
--

CREATE TABLE IF NOT EXISTS `surtax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `surtax`
--

INSERT INTO `surtax` (`id`, `percent`) VALUES
(1, '20.00');

-- --------------------------------------------------------

--
-- Структура таблицы `translit`
--

CREATE TABLE IF NOT EXISTS `translit` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ид транслитерации',
  `from_lang_id` int(11) NOT NULL COMMENT 'ид языка оригинала',
  `to_lang_id` int(11) NOT NULL COMMENT 'ид языка на который переводим',
  `from_symbol` varchar(8) NOT NULL COMMENT 'символ оригинал',
  `to_symbol` varchar(8) NOT NULL COMMENT 'символ результата',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tlang` (`to_lang_id`),
  KEY `flang` (`from_lang_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `translit`
--

INSERT INTO `translit` (`id`, `from_lang_id`, `to_lang_id`, `from_symbol`, `to_symbol`) VALUES
(1, 1, 2, 'б', 'b');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_confirm_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_username` (`username`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_role` (`role`),
  KEY `idx_user_status` (`status`),
  KEY `idx_user_parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `password_hash`, `password_reset_token`, `email`, `email_confirm_token`, `auth_key`, `role`, `status`, `created_at`, `updated_at`, `parent_id`) VALUES
(1, 'test', '', '$2y$13$B4DPxXs0/GKHt4Z81yiRM.DHwgr5tk4HNyorp1g8VmzWdDtEbMWJW', '', 'test@mail.ru', '', 'OSgDej5fe8zJdRy_N2AshqP3P2e5gTUL', 'user', 10, 1418034394, 1418034394, 0),
(2, 'manager', '', '$2y$13$Ir6j3GVK.Fdh0l7cM8fsGO2QHCKxTNoKKnCZGlqm25KFXwXdR5kTK', '', 'manager@mail.ru', '', '0pIFtMFMleZ_CmZdK240ti2bNyJBH98L', 'manager', 10, 1418034394, 1418034394, 0),
(3, 'admin', '', '$2y$13$9dqaQK3viYvdoAAI0Oy0XuUqfiSJ0saJXM2qYQ2A0TzA1QFV56Q6.', '', 'admin@mail.ru', '', 'pI8Z6XtcXeUKQKEJoPYBazoP5-qo3zmv', 'admin', 10, 1418034394, 1418034394, 0),
(4, 'superadmin', '', '$2y$13$Kqo/vATU4BSO9XT.Xm.jNOz.kIaUBBhCsHm.WHfauI5ZGkDkrXMvK', '', 'superadmin@mail.ru', '', 'MqtOr8ySQ7k2QFMEN3KhX3QBOEw9fDVD', 'superadmin', 10, 1418034394, 1418034394, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `vat`
--

CREATE TABLE IF NOT EXISTS `vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `vat`
--

INSERT INTO `vat` (`id`, `percent`) VALUES
(1, 25),
(2, 26),
(3, 10),
(4, 15);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `payment_history`
--
ALTER TABLE `payment_history`
  ADD CONSTRAINT `fk_psid_rt1` FOREIGN KEY (`payment_system_id`) REFERENCES `payment_system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_uid_rt0` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `translit`
--
ALTER TABLE `translit`
  ADD CONSTRAINT `translit_ibfk_2` FOREIGN KEY (`to_lang_id`) REFERENCES `lang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `translit_ibfk_1` FOREIGN KEY (`from_lang_id`) REFERENCES `lang` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
