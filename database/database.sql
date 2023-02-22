-- MySQL Script generated by MySQL Workbench
-- 
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sims
-- -----------------------------------------------------
USE `sims` ;

-- -----------------------------------------------------
-- Table `sims`.`mail_list`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`mail_list` ;

CREATE TABLE IF NOT EXISTS `sims`.`mail_list` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_send` VARCHAR(255) NULL,
  `full_name` VARCHAR(255) NULL,
  `sent` BOOLEAN DEFAULT FALSE,
  `selector` VARCHAR(12) NOT NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`affiliations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`affiliations` ;

CREATE TABLE IF NOT EXISTS `sims`.`affiliations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `affiliation1` VARCHAR(255) NOT NULL,
  `affiliation2` VARCHAR(255) NULL,
  `country` VARCHAR(50) NOT NULL,
  `state` VARCHAR(50) NULL,
  `city` VARCHAR(50) NOT NULL,
  `street` VARCHAR(255) NOT NULL,
  `zipcode` VARCHAR(50) NOT NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`affiliations_to_people`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`affiliations_to_people` ;

CREATE TABLE IF NOT EXISTS `sims`.`affiliations_to_people` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `affiliation_id` INT UNSIGNED NOT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `order_nr` INT UNSIGNED NOT NULL DEFAULT 1,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`people`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `sims`.`people` ;

-- payment_type!!

CREATE TABLE IF NOT EXISTS `sims`.`people` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `last_name` VARCHAR(50) NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `middle_name` VARCHAR(50) NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `title` VARCHAR(50) NULL,
  `email` VARCHAR(255) NOT NULL,
  `affiliation_id` INT UNSIGNED NOT NULL
  `type` ENUM('regular', 'student', 'exhibitor', 'accomp', 'author', 'staff', 'invited', 'other', 'one_day') NULL,
  `registered` BOOLEAN NOT NULL DEFAULT FALSE,
  `paid` BOOLEAN NULL,
  `excursion_first` ENUM('none', 'krakow', 'wieliczka', 'ojcow'),
  `excursion_second` ENUM('none', 'krakow', 'wieliczka', 'ojcow'),
  `dinner` ENUM('none', 'meat', 'veg'),
  `short_course` BOOLEAN DEFAULT NULL,
  `additional_info` VARCHAR(255) NULL,
  `cost` DECIMAL(10,2),

  `vat_invoice` BOOLEAN NULL,
  `vat_nr` VARCHAR(50) NULL,
  `vat_affiliation` INT UNSIGNED NULL,
  
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`),
  FOREIGN KEY (`vat_affiliation`) REFERENCES `affiliations` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`users`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `sims`.`users` ;

CREATE TABLE IF NOT EXISTS `sims`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `access_type` ENUM('user', 'mod', 'admin') NOT NULL DEFAULT 'user',
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `accomp_persons` INT UNSIGNED NOT NULL DEFAULT 0,
  
  `personal_cost` DECIMAL(10,2),
  `short_course_cost` DECIMAL(10,2),
  `personal_grant` DECIMAL(10,2) DEFAULT 0,
  `personal_fee` DECIMAL(10,2) AS (IF(`personal_cost` + `short_course_cost` >= `personal_grant`,`personal_cost` + `short_course_cost` - `personal_grant`,0)) PERSISTENT,
  `personal_paid` DECIMAL(10,2) DEFAULT 0,
  
  `accomp_cost` DECIMAL(10,2),
  `accomp_grant` DECIMAL(10,2) DEFAULT 0,
  `accomp_fee` DECIMAL(10,2) AS (IF(`accomp_cost`>=`accomp_grant`,`accomp_cost` - `accomp_grant`,0)) PERSISTENT,
  `accomp_paid` DECIMAL(10,2) DEFAULT 0,
  
  `total_fee` DECIMAL(10,2) AS (`personal_fee` + `accomp_fee`) PERSISTENT,  
  
  `fee_paid` DECIMAL(10,2) AS (`personal_paid` + `accomp_paid`) PERSISTENT,
  
  `comments` VARCHAR(160) NULL,
  
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`accomp_to_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`accomp_to_users` ;

CREATE TABLE IF NOT EXISTS `sims`.`accomp_to_users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`abstracts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`abstracts` ;

CREATE TABLE IF NOT EXISTS `sims`.`abstracts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL,
  `text` VARCHAR(3700) NULL,
  `topics` VARCHAR(1000) NULL,
  `type_proposed` ENUM('oral', 'poster', 'other'),
  `accepted` BOOLEAN NULL,
  `type_assigned` ENUM('oral', 'poster', 'other'),
  `session_assigned` VARCHAR(50),
  `award` BOOLEAN NOT NULL DEFAULT FALSE,
  `support_letter` BOOLEAN NOT NULL DEFAULT FALSE,
  `name` VARCHAR(255) NULL,
  `file` VARCHAR(255) NULL,
  `comments` VARCHAR(160) NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`abstracts_to_people`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`abstracts_to_people` ;

CREATE TABLE IF NOT EXISTS `sims`.`abstracts_to_people` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `abstract_id` INT UNSIGNED NOT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `presenting` BOOLEAN NOT NULL DEFAULT false,
  `corresponding` BOOLEAN NULL DEFAULT false,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`abstract_id`) REFERENCES `abstracts` (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sims`.`cards`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`payments` ;

CREATE TABLE IF NOT EXISTS `sims`.`payments` (
  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `type` ENUM('personal', 'accomp', 'other') NOT NULL,
  `success` BOOLEAN NULL,
  `method` ENUM('transfer', 'card', 'other') NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `comments` VARCHAR(160) NULL,
  `session_id` VARCHAR(128) NULL,
  `response_code` VARCHAR(3) NULL,
  `transaction_id` VARCHAR(50) NULL,
  `cc_number_hash` VARCHAR(512) NULL,
  `bin` INT NULL,
  `card_type` VARCHAR(20) NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`log` ;

CREATE TABLE IF NOT EXISTS `sims`.`log` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `importance` INT UNSIGNED NOT NULL DEFAULT 3,
  `page` VARCHAR(50) NULL,
  `content` VARCHAR(500) NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sims`.`person_to_authors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sims`.`person_to_authors` ;

CREATE TABLE IF NOT EXISTS `sims`.`person_to_authors` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `author_id` INT UNSIGNED NOT NULL,
  `change_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`person_id`) REFERENCES `people` (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `people` (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;