CREATE TABLE `book-listing`.`users` 
( 
	`id` INT NOT NULL AUTO_INCREMENT , 
	`firstName` VARCHAR(255) NOT NULL , 
	`lastName` VARCHAR(255) NOT NULL , 
	`email` VARCHAR(255) NOT NULL , 
	`password` VARCHAR(255) NOT NULL , 
	`active` BOOLEAN NOT NULL , 
	`admin` BOOLEAN NOT NULL , 
	PRIMARY KEY (`id`), 
	UNIQUE `email` (`email`)
) 
ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci;
