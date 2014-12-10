-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 04 2014 г., 14:12
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
-- Структура таблицы `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT 'no',
  `credit` int(11) NOT NULL DEFAULT '0',
  `def_vat_id` int(11) NOT NULL DEFAULT '0',
  `def_company_id` int(11) NOT NULL DEFAULT '0',
  `def_lang_id` int(11) NOT NULL DEFAULT '0',
  `bank_code` varchar(100) NOT NULL DEFAULT 'no',
  `account_number` varchar(100) NOT NULL DEFAULT 'no',
  `last_login` datetime NOT NULL,
  `is_on` tinyint(1) NOT NULL DEFAULT '1',
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `web_site` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `setting`
--

INSERT INTO `setting` (`user_id`, `name`, `credit`, `def_vat_id`, `def_company_id`, `def_lang_id`, `bank_code`, `account_number`, `last_login`, `is_on`, `country`, `city`, `street`, `post_index`, `phone`, `web_site`) VALUES
(1, 'no', 0, 3, 2, 2, '1111111111', '1111111111', '2014-12-01 00:00:00', 1, 'yyyy', 'yyy', 'yyy', 999999, '67895909', 'tururt'),
(2, 'no', 0, 1, 1, 1, 'no', 'no', '2014-12-04 12:39:39', 1, 'qq', 'qq', 'qq', 11, 'qq', 'www'),
(3, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 'qq'),
(4, 'aaaaa', 0, 1, 1, 1, 'no', 'no', '2014-12-04 09:21:05', 1, 'qq', 'qq', 'qq', 11111, 'qq', 'qq');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
