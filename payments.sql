DROP TABLE payment;

CREATE TABLE `payment_old` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `payment_system` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `model` VARCHAR(128) DEFAULT NULL,
  `active` TINYINT(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `payment_currency` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `currency` CHAR(3) DEFAULT 'EUR'
  `curs` FLOAT DEFAULT NULL,
  `active` TINYINT(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `payment_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `amount` FLOAT NOT NULL,
  `currency_id` INT(11) DEFAULT NULL,
  `curs` FLOAT DEFAULT NULL,
  `equivalent` FLOAT DEFAULT NULL,
  `description` VARCHAR(128) DEFAULT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_system_id` INT(11) NOT NULL,
  `complete` TINYINT(1) DEFAULT '0',
  `type` INT(4) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pay_sys_id` (`payment_system_id`),
  KEY `balance` (`user_id`,`complete`),
  KEY `type` (`type`),
  CONSTRAINT `fk_psid_rt1` FOREIGN KEY (`payment_system_id`) REFERENCES `payment_system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_uid_rt0` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;


