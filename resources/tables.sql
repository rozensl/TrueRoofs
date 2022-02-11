CREATE TABLE `trueroofs`.`user` ( 
`userID` INT(5) NOT NULL AUTO_INCREMENT ,  
`userName` VARCHAR(30) NOT NULL ,  
`password` VARCHAR(30) NOT NULL ,  
`email` VARCHAR(30) NOT NULL ,  
`joinedOn` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
`interest` VARCHAR(30) NOT NULL DEFAULT 'browse' ,    
PRIMARY KEY  (`userID`),    
UNIQUE  `email` (`email`)
) ENGINE = InnoDB;

CREATE TABLE `trueroofs`.`listing` ( 
`id` INT(10) NOT NULL AUTO_INCREMENT ,  
`name` VARCHAR(50) NOT NULL ,  
`description` TEXT NOT NULL ,  
`address` VARCHAR(250) NULL DEFAULT NULL ,  
`dlat` VARCHAR(15) NOT NULL ,  
`dlong` VARCHAR(15) NOT NULL ,  
`source` VARCHAR(250) NOT NULL ,  
`price` FLOAT NOT NULL , 
`bedroom` INT(5) NOT NULL,
`bathroom` INT(5) NOT NULL, 
`imagePath` VARCHAR(250) NOT NULL ,  
`imageURL` VARCHAR(250) NOT NULL ,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB;

CREATE TABLE `trueroofs`.`review` ( 
`id` INT(15) NOT NULL AUTO_INCREMENT ,  
`name` VARCHAR(50) NOT NULL ,  
`reviewerID` INT(5) NOT NULL ,  
`reviewerName` VARCHAR(50) NOT NULL ,  
`locationID` VARCHAR(10) NULL DEFAULT NULL ,  
`dlat` VARCHAR(15) NOT NULL ,  
`dlong` VARCHAR(15) NOT NULL ,  
`content` TEXT NOT NULL ,  
`rating` FLOAT NOT NULL ,  
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  
`imagePath` VARCHAR(250) NOT NULL ,    
PRIMARY KEY  (`id`)
) ENGINE = InnoDB;

