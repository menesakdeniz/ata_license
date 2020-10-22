-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                10.4.14-MariaDB - mariadb.org binary distribution
-- Sunucu İşletim Sistemi:       Win64
-- HeidiSQL Sürüm:               11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- fivem için veritabanı yapısı dökülüyor
CREATE DATABASE IF NOT EXISTS `fivem` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `fivem`;

-- tablo yapısı dökülüyor fivem.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '0',
  `permission` varchar(50) NOT NULL DEFAULT 'unverified',
  `hak` int(4) NOT NULL DEFAULT 0,
  `isfreeze` varchar(50) DEFAULT 'false',
  `endtime` date DEFAULT NULL,
  `verfcode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- fivem.accounts: ~3 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT IGNORE INTO `accounts` (`id`, `username`, `password`, `email`, `permission`, `hak`, `isfreeze`, `endtime`, `verfcode`) VALUES
	(22, 'KelMustafa', 'test', 'caglayanmustafaata@gmail.com', 'creator', 0, 'false', NULL, 'c2f946c7ac3321e114558930a1eca38c');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- tablo yapısı dökülüyor fivem.lisans
CREATE TABLE IF NOT EXISTS `lisans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `serial` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ip` varchar(30) CHARACTER SET utf8 NOT NULL,
  `stat` varchar(20) CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `sahip` varchar(30) CHARACTER SET utf8 NOT NULL,
  `webhook` varchar(180) CHARACTER SET utf8 NOT NULL,
  `cins` varchar(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4;

-- fivem.lisans: ~1 rows (yaklaşık) tablosu için veriler indiriliyor
/*!40000 ALTER TABLE `lisans` DISABLE KEYS */;
/*!40000 ALTER TABLE `lisans` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
