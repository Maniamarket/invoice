DROP TABLE IF EXISTS payment;
DROP TABLE IF EXISTS payment_old;
DROP TABLE IF  EXISTS payment_history;
DROP TABLE IF  EXISTS payment_system;
DROP TABLE IF  EXISTS payment_currency;

CREATE TABLE `payment_system` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `model` VARCHAR(128) DEFAULT NULL,
  `active` TINYINT(1) DEFAULT '1',
  PRIMARY KEY (`id`),
   UNIQUE KEY `model` (`model`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

INSERT INTO `payment_system` (`model`,`active`) VALUES ('PayPal', 1);
INSERT INTO `payment_system` (`model`,`active`) VALUES ('BankTransfer', 1);


CREATE TABLE `payment_currency` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `operator_id` INT(11) DEFAULT NULL,
  `char_code` CHAR(9) DEFAULT NULL,
  `name` VARCHAR(384) DEFAULT NULL,
  `curs` FLOAT DEFAULT NULL,
  `active` TINYINT(1) DEFAULT NULL,
  `last_modify` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `char_code` (`char_code`),
  KEY `fk_uid_pc1` (`operator_id`),
  CONSTRAINT `fk_uid_pc1` FOREIGN KEY (`operator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;


INSERT INTO `payment_currency` (`id`, `operator_id`, `char_code`, `name`, `curs`, `active`, `last_modify`) VALUES('1','4','USD','asd','1.66','1','2014-12-11 14:20:53');
INSERT INTO `payment_currency` (`id`, `operator_id`, `char_code`, `name`, `curs`, `active`, `last_modify`) VALUES('2','4','EUR','asasd','1','1','2014-10-02 10:00:00');
INSERT INTO `payment_currency` (`id`, `operator_id`, `char_code`, `name`, `curs`, `active`, `last_modify`) VALUES('3','4','UAH','asdasdas','20','1','2014-12-11 14:20:44');
INSERT INTO `payment_currency` (`id`, `operator_id`, `char_code`, `name`, `curs`, `active`, `last_modify`) VALUES('4','4','RUB','ee','65','1','2014-12-11 14:20:44');


DROP TABLE IF  EXISTS payment_history;
CREATE TABLE `payment_history` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) DEFAULT NULL,
  `operator_id` INT(11) DEFAULT NULL,
  `amount` FLOAT NOT NULL,
  `currency_id` INT(11) NOT NULL,
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
  CONSTRAINT `fk_psid_ph0` FOREIGN KEY (`payment_system_id`) REFERENCES `payment_system` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_uid_ph1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_uid_ph2` FOREIGN KEY (`operator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_cid_ph3` FOREIGN KEY (`currency_id`) REFERENCES `payment_currency` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;


