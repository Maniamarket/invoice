-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 02 2014 г., 15:59
-- Версия сервера: 5.6.13-log
-- Версия PHP: 5.4.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
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
-- Структура таблицы `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `web_site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resp_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `country`, `city`, `street`, `post_index`, `phone`, `web_site`, `mail`, `vat_number`, `activity`, `resp_person`) VALUES
(1, 'google', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'microsoft', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'gregsys', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'bmw', 'logo.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `income`
--

CREATE TABLE IF NOT EXISTS `income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `manager` double NOT NULL,
  `admin` double NOT NULL,
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
  `date` date NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `service_id` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `vat_id` int(11) NOT NULL,
  `discount` int(3) NOT NULL,
  `price` int(11) NOT NULL,
  `pay` int(11) NOT NULL,
  `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `finished` tinyint(1) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Триггеры `invoice`
--
DROP TRIGGER IF EXISTS `tg_invoice_insert`;
DELIMITER //
CREATE TRIGGER `tg_invoice_insert` BEFORE INSERT ON `invoice`
 FOR EACH ROW BEGIN
  INSERT INTO invoice_seq VALUES (NULL);
  SET NEW.id = CONCAT('MM', LPAD(LAST_INSERT_ID(), 4, '0'));
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `service`
--

CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `service`
--

INSERT INTO `service` (`id`, `name`) VALUES
(1, 'service1'),
(2, 'service2');

-- --------------------------------------------------------

--
-- Структура таблицы `surtax`
--

CREATE TABLE IF NOT EXISTS `surtax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) COLLATE utf8_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1414915120),
('m141102_074403_alter_table_user_add_columns', 1414915123),
('m141104_074059_alter_table_Company_add_columns', 1415086955),
('m141104_085418_alter_table_Invoice_add_columns', 3),
('m141104_154255_create_table_map_invoice_service', 1415116247),
('m141104_160821_alter_table_Invoice', 1415117435),
('m141119_080043_alter_table_setting_add_column_currency', 1416384210);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `register_date` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `is_on` tinyint(1) NOT NULL DEFAULT '1',
  `role` int(1) NOT NULL DEFAULT '5',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activity` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resp_person` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `credit` int(11) NOT NULL DEFAULT '0',
  `def_vat_id` int(11) NOT NULL DEFAULT '0',
  `def_company_id` int(11) NOT NULL,
  `def_lang_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=72 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `user_id`, `password`, `name`, `register_date`, `last_login`, `is_on`, `role`, `admin_id`, `manager_id`, `country`, `city`, `street`, `post_index`, `phone`, `web_site`, `mail`, `vat_number`, `activity`, `resp_person`, `bank_code`, `account_number`, `credit`, `def_vat_id`, `def_company_id`, `def_lang_id`) VALUES
(1, 'root', '202cb962ac59075b964b07152d234b70', 'Root Root', '2014-10-22 18:52:16', '2014-10-22 18:52:16', 1, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0),
(2, 'client', '202cb962ac59075b964b07152d234b70', 'Client Client', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 5, 2, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0),
(3, 'user', '202cb962ac59075b964b07152d234b70', 'User User', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 4, 3, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0),
(4, 'manager', '202cb962ac59075b964b07152d234b70', 'Manager Manager', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 3, 4, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0),
(5, 'admin', '202cb962ac59075b964b07152d234b70', 'Admin Administrator', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 2, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 0, 0, 0, 0),
(64, '54789dec50953', 'df5370ea6034d30465497fd32170e985', 'Shao Kahn', '2014-11-28 19:08:12', '2014-11-28 19:08:12', 1, 4, 64, 0, '', 'Bangladesh', 'Armenia', 1, '1', '1', 'arevars@gmail.com', '1', '1', '1', '', '', 0, 0, 0, 0),
(65, '54789e16cd1ec', 'c96a097941faaedcac396e03a83895e6', 'Shao Kahn', '2014-11-28 19:08:54', '2014-11-28 19:08:54', 1, 4, 65, 0, '1', 'Bangladesh', 'Armenia', NULL, '', '', 'asdas@asdasd.ru', '', '', '', '', '', 0, 0, 0, 0),
(66, '54789e357c826', 'a8f5f167f44f4964e6c998dee827110c', 'asdasda', '2014-11-28 19:09:25', '2014-11-28 19:09:25', 1, 4, 66, 0, '', '', '', NULL, '', '', 'arevars@gmail.com', '', '', '', '', '', 0, 0, 0, 0),
(67, '54789f17e45ba', 'd41d8cd98f00b204e9800998ecf8427e', 'Shao Kahn', '2014-11-28 19:13:11', '2014-11-28 19:13:11', 1, 4, 67, 0, '', 'Bangladesh', 'Armenia', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 0),
(68, '5478a073c30f8', 'd41d8cd98f00b204e9800998ecf8427e', 'asdasda', '2014-11-28 19:18:59', '2014-11-28 19:18:59', 1, 4, 68, 0, '', '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 0),
(69, '5478a28726f53', 'd41d8cd98f00b204e9800998ecf8427e', 'a', '2014-11-28 19:27:51', '2014-11-28 19:27:51', 1, 4, 69, 0, '', '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 0),
(70, '5478a437de339', 'd41d8cd98f00b204e9800998ecf8427e', 's', '2014-11-28 19:35:03', '2014-11-28 19:35:03', 1, 4, 70, 0, '', '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 0),
(71, '5478a9c4437ac', 'd41d8cd98f00b204e9800998ecf8427e', 'asd', '2014-11-28 19:58:44', '2014-11-28 19:58:44', 1, 4, 71, 0, '', '', '', NULL, '', '', '', '', '', '', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `vat`
--

CREATE TABLE IF NOT EXISTS `vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percent` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `vat`
--

INSERT INTO `vat` (`id`, `percent`) VALUES
(1, 25),
(2, 20),
(3, 10),
(4, 15);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
