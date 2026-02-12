-- Allow admin to ban users. Run once.

ALTER TABLE `user` ADD COLUMN `banned` TINYINT(1) NOT NULL DEFAULT 0 AFTER `timestamp`;
