-- Link order_details to builds so admin can see what was ordered.
-- Run once.

ALTER TABLE `builds` ADD COLUMN `order_id` INT(11) DEFAULT NULL AFTER `total_price`;
ALTER TABLE `builds` ADD KEY `order_id` (`order_id`);
