drop TABLE if EXISTS `users`;

create table `users`  (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `active` CHAR(1) NOT NULL ,
  `admin` CHAR(1) NOT NULL,
  PRIMARY KEY (`id`)

);
INSERT INTO users(`username`,`password`,`name`,`email`,`created_at`,`active`,`admin`) VALUES('demo','e69dc2c09e8da6259422d987ccbe95b5','demo','demo@example.com',now(),'Y','Y');
