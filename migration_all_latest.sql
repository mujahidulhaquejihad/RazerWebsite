-- =============================================================================
-- PC Building Website – ALL MIGRATIONS FOR LATEST CODEBASE
-- =============================================================================
-- Run this file ONCE after you have imported wp_project.sql into your database.
-- Target database: wp_project (or whatever you use – same as in connect_database.php)
--
-- If you already ran some of these migrations before, you may see errors like
-- "Duplicate column name" or "Duplicate key". You can ignore those and continue,
-- or run only the sections that you haven’t applied yet.
-- =============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET NAMES utf8mb4;

-- -----------------------------------------------------------------------------
-- 1) USER: role column (for future admin/user distinction)
-- -----------------------------------------------------------------------------
ALTER TABLE `user` ADD COLUMN `role` VARCHAR(20) NOT NULL DEFAULT 'user' AFTER `password`;
UPDATE `user` SET `role` = 'user' WHERE `role` = '' OR `role` IS NULL;

-- -----------------------------------------------------------------------------
-- 2) COMPONENT TABLES: stock, image_url, description, and spec columns
-- -----------------------------------------------------------------------------
-- Cabinet (Case)
ALTER TABLE `cabinet` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `cabinet` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `cabinet` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- Processor (CPU)
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

-- Power supply
ALTER TABLE `power_supply` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `power_supply` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `power_supply` ADD COLUMN `wattage` INT(11) DEFAULT NULL AFTER `image_url`;
ALTER TABLE `power_supply` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `wattage`;

-- CPU Cooler
ALTER TABLE `cpu_cooler` ADD COLUMN `stock` INT(11) NOT NULL DEFAULT 10 AFTER `price`;
ALTER TABLE `cpu_cooler` ADD COLUMN `image_url` VARCHAR(255) DEFAULT NULL AFTER `stock`;
ALTER TABLE `cpu_cooler` ADD COLUMN `description` TEXT DEFAULT NULL AFTER `image_url`;

-- -----------------------------------------------------------------------------
-- 3) BUILDS TABLE (saved builds by user)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `builds` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` VARCHAR(200) NOT NULL,
  `name` VARCHAR(100) DEFAULT 'My Build',
  `total_price` INT(11) NOT NULL DEFAULT 0,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
-- 4) BUILD ITEMS (components in each build)
-- -----------------------------------------------------------------------------
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

-- -----------------------------------------------------------------------------
-- 5) USER: banned column (admin ban/unban)
-- -----------------------------------------------------------------------------
ALTER TABLE `user` ADD COLUMN `banned` TINYINT(1) NOT NULL DEFAULT 0 AFTER `timestamp`;

-- -----------------------------------------------------------------------------
-- 6) CONTACT MESSAGES TABLE
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `phone` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` VARCHAR(20) NOT NULL DEFAULT 'new',
  `admin_notes` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------
-- 7) BUILDS: order_id (link orders to builds for admin order view)
-- -----------------------------------------------------------------------------
ALTER TABLE `builds` ADD COLUMN `order_id` INT(11) DEFAULT NULL AFTER `total_price`;
ALTER TABLE `builds` ADD KEY `order_id` (`order_id`);

-- -----------------------------------------------------------------------------
-- 8) OPTIONAL: Populate compatibility fields from existing data
-- -----------------------------------------------------------------------------
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

-- =============================================================================
-- Done. Optional: run seed_components_100.sql to add 100 sample components.
-- =============================================================================
