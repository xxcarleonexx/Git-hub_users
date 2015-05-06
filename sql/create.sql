SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `dbtest` ;
CREATE SCHEMA IF NOT EXISTS `dbtest` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `dbtest` ;

-- -----------------------------------------------------
-- Table `dbtest`.`tbUsers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbtest`.`tbUsers` ;

CREATE TABLE IF NOT EXISTS `dbtest`.`tbUsers` (
  `autoid` INT NOT NULL AUTO_INCREMENT,
  `id` INT NOT NULL,
  PRIMARY KEY (`autoid`, `id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbtest`.`tbProject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dbtest`.`tbProject` ;

CREATE TABLE IF NOT EXISTS `dbtest`.`tbProject` (
  `autoid` INT NOT NULL AUTO_INCREMENT,
  `id` INT NOT NULL,
  PRIMARY KEY (`autoid`, `id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
