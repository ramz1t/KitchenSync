-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;

SET
    @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS,
    FOREIGN_KEY_CHECKS = 0;

SET
    @OLD_SQL_MODE = @@SQL_MODE,
    SQL_MODE = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema KitchenSync
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema KitchenSync
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `KitchenSync`;

USE `KitchenSync`;

-- -----------------------------------------------------
-- Table `KitchenSync`.`restaurants`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`restaurants` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL UNIQUE,
    `password` VARCHAR(511) NOT NULL,
    `currency` VARCHAR(45) NOT NULL DEFAULT '$',
    PRIMARY KEY (`pk`),
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`categories` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `position` INT NOT NULL,
    `restaurant_pk` INT NOT NULL,
    PRIMARY KEY (`pk`),
    INDEX `category_restaurant_pk_idx` (`restaurant_pk` ASC) VISIBLE,
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `category_restaurant_pk` FOREIGN KEY (`restaurant_pk`) REFERENCES `KitchenSync`.`restaurants` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`addons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`addons` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `price` INT NOT NULL DEFAULT 0,
    `restaurant_pk` INT NOT NULL,
    PRIMARY KEY (`pk`),
    INDEX `addon_restaurant_pk_idx` (`restaurant_pk` ASC) VISIBLE,
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `addon_restaurant_pk` FOREIGN KEY (`restaurant_pk`) REFERENCES `KitchenSync`.`restaurants` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`items` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `position` INT NOT NULL,
    `description` VARCHAR(45) NULL,
    `category_pk` INT NOT NULL,
    PRIMARY KEY (`pk`),
    INDEX `item_category_pk_idx` (`category_pk` ASC) VISIBLE,
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `item_category_pk` FOREIGN KEY (`category_pk`) REFERENCES `KitchenSync`.`categories` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`item_addons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`item_addons` (
    `item_pk` INT NOT NULL,
    `addon_pk` INT NOT NULL,
    INDEX `item_addon_item_pk_idx` (`item_pk` ASC) VISIBLE,
    INDEX `item_addon_addon_pk_idx` (`addon_pk` ASC) VISIBLE,
    CONSTRAINT `item_addon_item_pk` FOREIGN KEY (`item_pk`) REFERENCES `KitchenSync`.`items` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `item_addon_addon_pk` FOREIGN KEY (`addon_pk`) REFERENCES `KitchenSync`.`addons` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`item_varians`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`item_varians` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `price` INT NOT NULL,
    `calories` INT NOT NULL,
    `size` VARCHAR(45) NOT NULL,
    `is_default` TINYINT NOT NULL,
    `item_pk` INT NOT NULL,
    INDEX `item_variant_item_pk_idx` (`item_pk` ASC) VISIBLE,
    PRIMARY KEY (`pk`),
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `item_variant_item_pk` FOREIGN KEY (`item_pk`) REFERENCES `KitchenSync`.`items` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`orders` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `status` VARCHAR(45) NOT NULL,
    `created_at` DATETIME NOT NULL,
    `number` INT NOT NULL,
    `price` INT NOT NULL,
    `is_takeaway` TINYINT NOT NULL,
    `restaurant_pk` INT NOT NULL,
    PRIMARY KEY (`pk`),
    INDEX `order_restaurant_pk_idx` (`restaurant_pk` ASC) VISIBLE,
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `order_restaurant_pk` FOREIGN KEY (`restaurant_pk`) REFERENCES `KitchenSync`.`restaurants` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`order_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`order_items` (
    `pk` INT NOT NULL AUTO_INCREMENT,
    `quantity` INT NOT NULL,
    `special_request` VARCHAR(45) NULL,
    `item_variant_pk` INT NOT NULL,
    `order_pk` INT NOT NULL,
    PRIMARY KEY (`pk`),
    INDEX `order_item_order_pk_idx` (`order_pk` ASC) VISIBLE,
    INDEX `order_item_item_variant_pk_idx` (`item_variant_pk` ASC) VISIBLE,
    UNIQUE INDEX `pk_UNIQUE` (`pk` ASC) VISIBLE,
    CONSTRAINT `order_item_item_variant_pk` FOREIGN KEY (`item_variant_pk`) REFERENCES `KitchenSync`.`item_varians` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `order_item_order_pk` FOREIGN KEY (`order_pk`) REFERENCES `KitchenSync`.`orders` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `KitchenSync`.`order_item_addons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `KitchenSync`.`order_item_addons` (
    `order_item_pk` INT NOT NULL,
    `addon_pk` INT NOT NULL,
    INDEX `order_item_addon_order_item_pk_idx` (`order_item_pk` ASC) VISIBLE,
    INDEX `order_item_addon_addon_pk_idx` (`addon_pk` ASC) VISIBLE,
    CONSTRAINT `order_item_addon_order_item_pk` FOREIGN KEY (`order_item_pk`) REFERENCES `KitchenSync`.`order_items` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `order_item_addon_addon_pk` FOREIGN KEY (`addon_pk`) REFERENCES `KitchenSync`.`addons` (`pk`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE = InnoDB;

SET SQL_MODE = @OLD_SQL_MODE;

SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;

SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;