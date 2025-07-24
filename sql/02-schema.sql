-- Boards
DROP TABLE IF EXISTS `boards`;
CREATE TABLE `boards` (
  `board_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `board_uuid` CHAR(36) NOT NULL,
  `board_title` varchar(256) DEFAULT NULL,
  `board_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `board_updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`board_id`),
  UNIQUE KEY `idx_board_uuid` (`board_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Columns
DROP TABLE IF EXISTS `columns`;
CREATE TABLE `columns` (
  `column_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `column_uuid` CHAR(36) NOT NULL,
  `column_board` int(11) unsigned NOT NULL,
  `column_title` varchar(256) DEFAULT NULL,
  `column_position` INT(11) unsigned NOT NULL DEFAULT 9999,
  `column_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `column_updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`column_id`),
  UNIQUE KEY `idx_column_uuid` (`column_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Cards
DROP TABLE IF EXISTS `cards`;
CREATE TABLE `cards` (
  `card_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `card_uuid` CHAR(36) NOT NULL,
  `card_board` int(11) unsigned NOT NULL,
  `card_column`  int(11) unsigned NOT NULL,
  `card_title` varchar(256) DEFAULT NULL,
  `card_content` TEXT DEFAULT NULL,
  `card_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `card_updated` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`card_id`),
  UNIQUE KEY `idx_card_uuid` (`card_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
