CREATE TABLE IF NOT EXISTS `inventory`.`prices` (
	`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
    `value` DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS `inventory`.`products` (
	`id` BIGINT(20) PRIMARY KEY AUTO_INCREMENT,
    `price_id` BIGINT(20) NOT NULL,
    `name` VARCHAR(191) NOT NULL,
    `color` VARCHAR(191) NOT NULL,
	FOREIGN KEY (`price_id`) REFERENCES prices(id)
);