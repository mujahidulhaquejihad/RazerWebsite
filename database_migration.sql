-- Migration: PC Builder roadmap (run once on existing wp_project database)
-- Adds: user role, component stock/images/specs, builds, build_items

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

-- 1) User: add role (user | admin)
ALTER TABLE `user` ADD COLUMN `role` VARCHAR(20) NOT NULL DEFAULT 'user' AFTER `password`;
UPDATE `user` SET `role` = 'user' WHERE `role` = '' OR `role` IS NULL;

-- 2) Component tables: add stock, image_url, and compatibility/spec columns
-- Cabinet (Case)
ALTER TABLE `cabinet` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `cabinet` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `cabinet` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- Processor (CPU) - socket for compatibility
ALTER TABLE `processor` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `processor` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `processor` ADD COLUMN `socket_type` VARCHAR(50) DEFAULT NULL AFTER `image_url`;
ALTER TABLE `processor` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `socket_type`;

-- Motherboard
ALTER TABLE `motherboard` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `motherboard` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `motherboard` ADD COLUMN `socket_type` VARCHAR(50) DEFAULT NULL AFTER `image_url`;
ALTER TABLE `motherboard` ADD COLUMN `ram_type` VARCHAR(20) DEFAULT NULL AFTER `socket_type`;
ALTER TABLE `motherboard` ADD COLUMN `form_factor` VARCHAR(20) DEFAULT NULL AFTER `ram_type`;
ALTER TABLE `motherboard` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `form_factor`;

-- GPU
ALTER TABLE `gpu` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `gpu` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `gpu` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- RAM
ALTER TABLE `ram` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `ram` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `ram` ADD COLUMN `ram_type` VARCHAR(20) DEFAULT NULL AFTER `image_url`;
ALTER TABLE `ram` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `ram_type`;

-- SSD
ALTER TABLE `ssd` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `ssd` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `ssd` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- HDD
ALTER TABLE `hdd` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `hdd` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `hdd` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- Power supply - wattage for compatibility
ALTER TABLE `power_supply` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `power_supply` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `power_supply` ADD COLUMN `wattage` INT(11) DEFAULT NULL AFTER `image_url`;
ALTER TABLE `power_supply` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `wattage`;

-- CPU Cooler
ALTER TABLE `cpu_cooler` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `cpu_cooler` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `cpu_cooler` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- 3) Builds (saved builds by user)
CREATE TABLE IF NOT EXISTS `builds` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(200) NOT NULL,
  `name` VARCHAR(100) DEFAULT 'My Build',
  `total_price` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Build items (components in each build)
CREATE TABLE IF NOT EXISTS `build_items` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `build_id` INT(11) NOT NULL,
  `category` VARCHAR(30) NOT NULL,
  `component_id` VARCHAR(50) NOT NULL,
  `component_name` VARCHAR(200) NOT NULL,
  `price` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `build_id` (`build_id`),
  CONSTRAINT `build_items_build_fk` FOREIGN KEY (`build_id`) REFERENCES `builds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5) Populate compatibility fields from existing data (optional)
UPDATE `processor` SET `socket_type` = 'LGA1200' WHERE `cpu_id` IN ('i3','i5','i7');
UPDATE `processor` SET `socket_type` = 'AM4' WHERE `cpu_id` IN ('r3','r5','r7');
UPDATE `motherboard` SET `socket_type` = 'LGA1200', `ram_type` = 'DDR4', `form_factor` = 'ATX' WHERE `mb_id` IN (1,2,3);
UPDATE `motherboard` SET `socket_type` = 'AM4', `ram_type` = 'DDR4', `form_factor` = 'ATX' WHERE `mb_id` IN (4,5);
UPDATE `ram` SET `ram_type` = 'DDR4' WHERE 1=1;
UPDATE `power_supply` SET `wattage` = 450 WHERE `ps_id` = 1;
UPDATE `power_supply` SET `wattage` = 550 WHERE `ps_id` = 2;
UPDATE `power_supply` SET `wattage` = 750 WHERE `ps_id` = 3;
UPDATE `power_supply` SET `wattage` = 900 WHERE `ps_id` = 4;
UPDATE `power_supply` SET `wattage` = 1000 WHERE `ps_id` = 5;
