# ************************************************************
# Sequel Ace SQL dump
# Version 20095
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 11.4.5-MariaDB-deb12)
# Database: kanban_local
# Generation Time: 2025-07-23 05:10:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table columns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `columns`;

CREATE TABLE `columns` (
  `column_id` binary(16) NOT NULL DEFAULT '0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `column_board` binary(16) NOT NULL,
  `column_name` varchar(256) DEFAULT NULL,
  `column_position` int(11) unsigned NOT NULL DEFAULT 9999,
  `column_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `column_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`column_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `columns` WRITE;
/*!40000 ALTER TABLE `columns` DISABLE KEYS */;

INSERT INTO `columns` (`column_id`, `column_board`, `column_name`, `column_position`, `column_created`, `column_updated`)
VALUES
	(X'11F05800CAADF7EF887A001C42667147',X'11F057B9A57FA18B887A001C42667147','To Do',1,'2025-07-23 06:09:12','0000-00-00 00:00:00'),
	(X'11F05800CAAE4B84887A001C42667147',X'11F057B9A57FA18B887A001C42667147','Doing',2,'2025-07-23 06:09:12','0000-00-00 00:00:00'),
	(X'11F05800CAAF25A0887A001C42667147',X'11F057B9A57FA18B887A001C42667147','Done',3,'2025-07-23 06:09:12','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `columns` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`%` */ /*!50003 TRIGGER `column_id_uuid` BEFORE INSERT ON `columns` FOR EACH ROW BEGIN
  if NEW.column_id = 0 THEN
    SET NEW.column_id = UUID_TO_BIN(UUID(), 1);
  END IF;
END */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
