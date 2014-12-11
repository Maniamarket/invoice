-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 11 2014 г., 16:51
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
  `country_id` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `client`
--

INSERT INTO `client` (`id`, `name`, `user_id`, `email`, `email_confirm_token`, `password_hash`, `password_reset_token`, `auth_key`, `created_at`, `updated_at`, `def_lang_id`, `country_id`, `city`, `street`, `post_index`, `phone`, `password`) VALUES
(1, 'Fedorov', 3, '1@mu.ru', '', '$2y$13$iLuCWhxjnNoQ7E9bm4zlRe5g6okYUaSCfm8hJj11Iyv3gIL2qDTVS', '', 'LeKPQcSJPBrU9EsnTRg9rI8922OS7q6q', 1418052545, 1418052545, 1, 1, 'Moscwa', '', 2222, '', 'Ys7C'),
(2, 'Alex', 3, '2@mu.ru', '', '$2y$13$8TnqmIT1jhnfjZiRdj8TFubVn8pC2KQNNgJoD80fhjPHCWWKYZ5Z2', '', '1RDxdreA4EvNZBvfPb2Ad1Rc0h8WhMru', 1418052545, 1418052545, 2, 3, 'Minsk', '', NULL, '', 'N6t'),
(3, 'Belikov', 3, '3@mu.ru', '', '$2y$13$X.G4KFKIgbkWqFcDDXQGq.sn6xnanKNaDsuZ5kjEP3GW15HI1vAKO', '', 'BJCNW1HZeCltZ7LrDHoAooDxbj0UBywf', 1418052545, 1418052545, 2, 4, 'Astana', '', NULL, '', 'iud'),
(4, 'Alexey', 3, 'ca@mail.ru', '', '$2y$13$I9M4pepcx7iIxmkHXQKsE.arn8.z8hn2tMI8HqIEjv5sEv.71..h2', '', 'ui3zNx7l2nVm67SAqTV_I7FR3UK-vU1i', 1418183760, 1418183760, 1, 2, 'Kyiv', '', NULL, '', 'oUos');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
