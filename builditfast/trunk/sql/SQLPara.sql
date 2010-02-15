CREATE TABLE `paragraphs` (
 `key` VARCHAR( 255 ) NOT NULL ,
 `value` MEDIUMTEXT NOT NULL ,
 `habilitado` TINYINT( 1 ) DEFAULT '1' NOT NULL ,
 PRIMARY KEY ( `key` ) 
);
