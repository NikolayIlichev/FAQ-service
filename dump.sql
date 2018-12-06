CREATE TABLE `categories` ( 
	`id` INT NOT NULL AUTO_INCREMENT,
	`category_name` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`login`, `password`) 
VALUES ('admin', 'admin');

CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` varchar(200) DEFAULT NULL,
  `question` varchar(1000) DEFAULT NULL,
  `answer` varchar(1000) DEFAULT NULL,
  `author` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `active` varchar(1) NOT NULL DEFAULT 'N',
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;