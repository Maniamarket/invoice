-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 05 2014 г., 13:32
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_confirm_token` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `def_lang_id` int(11) NOT NULL DEFAULT '1',
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `post_index` int(11) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `name`, `user_id`, `email`, `email_confirm_token`, `password_hash`, `password_reset_token`, `auth_key`, `created_at`, `updated_at`, `def_lang_id`, `country`, `city`, `street`, `post_index`, `phone`, `password`) VALUES
(1, '', 4, '1@mu.ru', '', '$2y$13$iLuCWhxjnNoQ7E9bm4zlRe5g6okYUaSCfm8hJj11Iyv3gIL2qDTVS', '', 'LeKPQcSJPBrU9EsnTRg9rI8922OS7q6q', 1417771546, 1417771546, 1, '', '', '', NULL, '', 'Ys7C'),
(2, '', 4, '2@mu.ru', '', '$2y$13$8TnqmIT1jhnfjZiRdj8TFubVn8pC2KQNNgJoD80fhjPHCWWKYZ5Z2', '', '1RDxdreA4EvNZBvfPb2Ad1Rc0h8WhMru', 1417771848, 1417771848, 1, '', '', '', NULL, '', 'N6t'),
(3, '', 4, '3@mu.ru', '', '$2y$13$X.G4KFKIgbkWqFcDDXQGq.sn6xnanKNaDsuZ5kjEP3GW15HI1vAKO', '', 'BJCNW1HZeCltZ7LrDHoAooDxbj0UBywf', 1417771883, 1417771883, 1, '', '', '', NULL, '', 'iud');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
