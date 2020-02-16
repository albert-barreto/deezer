-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema deezer
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema deezer
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `deezer` DEFAULT CHARACTER SET utf8 ;
USE `deezer` ;

-- -----------------------------------------------------
-- Table `deezer`.`content_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`content_type` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `deezer`.`artist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`artist` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `style` VARCHAR(45) NULL DEFAULT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_artist_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_artist_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`album`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`album` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `year` INT(11) NULL DEFAULT NULL,
  `artist_id` INT(11) NOT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_album_artist1_idx` (`artist_id` ASC) VISIBLE,
  INDEX `fk_album_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_album_artist1`
    FOREIGN KEY (`artist_id`)
    REFERENCES `deezer`.`artist` (`id`),
  CONSTRAINT `fk_album_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(100) NULL DEFAULT NULL,
  `type` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`message` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `type` ENUM('recommandation', 'nouveauté', 'partage', 'information') NULL,
  `description` TEXT NULL DEFAULT NULL,
  `period` DATE NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_message_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_message_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_message_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `deezer`.`user` (`id`),
  CONSTRAINT `fk_message_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`notification`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`notification` (
  `user_id` INT(11) NOT NULL,
  `message_id` INT(11) NOT NULL,
  `status` INT(1) NULL DEFAULT NULL,
  `date` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`, `message_id`),
  INDEX `fk_user_has_message_message1_idx` (`message_id` ASC) VISIBLE,
  INDEX `fk_user_has_message_user1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_user_has_message_message1`
    FOREIGN KEY (`message_id`)
    REFERENCES `deezer`.`message` (`id`),
  CONSTRAINT `fk_user_has_message_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `deezer`.`user` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`playlist`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`playlist` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_playlist_user1_idx` (`user_id` ASC) VISIBLE,
  INDEX `fk_playlist_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_playlist_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `deezer`.`user` (`id`),
  CONSTRAINT `fk_playlist_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`track`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`track` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `album_id` INT(11) NOT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_track_album1_idx` (`album_id` ASC) VISIBLE,
  INDEX `fk_track_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_track_album1`
    FOREIGN KEY (`album_id`)
    REFERENCES `deezer`.`album` (`id`),
  CONSTRAINT `fk_track_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`playlist_track`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`playlist_track` (
  `playlist_id` INT(11) NOT NULL,
  `track_id` INT(11) NOT NULL,
  PRIMARY KEY (`playlist_id`, `track_id`),
  INDEX `fk_playlist_has_track_track1_idx` (`track_id` ASC) VISIBLE,
  INDEX `fk_playlist_has_track_playlist1_idx` (`playlist_id` ASC) VISIBLE,
  CONSTRAINT `fk_playlist_has_track_playlist1`
    FOREIGN KEY (`playlist_id`)
    REFERENCES `deezer`.`playlist` (`id`),
  CONSTRAINT `fk_playlist_has_track_track1`
    FOREIGN KEY (`track_id`)
    REFERENCES `deezer`.`track` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `deezer`.`podcast`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `deezer`.`podcast` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL DEFAULT NULL,
  `year` INT(11) NULL DEFAULT NULL,
  `artist_id` INT(11) NOT NULL,
  `content_type_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_podcast_artist_idx` (`artist_id` ASC) VISIBLE,
  INDEX `fk_podcast_content_type1_idx` (`content_type_id` ASC) VISIBLE,
  CONSTRAINT `fk_podcast_artist`
    FOREIGN KEY (`artist_id`)
    REFERENCES `deezer`.`artist` (`id`),
  CONSTRAINT `fk_podcast_content_type1`
    FOREIGN KEY (`content_type_id`)
    REFERENCES `deezer`.`content_type` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
