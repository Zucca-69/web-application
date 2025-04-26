-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              11.7.2-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database rungamedb
CREATE DATABASE IF NOT EXISTS `rungamedb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `rungamedb`;

-- Dump della struttura di tabella rungamedb.appartenenze
CREATE TABLE IF NOT EXISTS `appartenenze` (
  `FKcategoryId` int(11) NOT NULL,
  `FKproductId` int(11) NOT NULL,
  PRIMARY KEY (`FKcategoryId`,`FKproductId`),
  KEY `FK_appartenenze_prodotti` (`FKproductId`),
  CONSTRAINT `FK_appartenenze_categorie` FOREIGN KEY (`FKcategoryId`) REFERENCES `categorie` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_appartenenze_prodotti` FOREIGN KEY (`FKproductId`) REFERENCES `prodotti` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='interazione tra categorie e prodotti';

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.carrelli
CREATE TABLE IF NOT EXISTS `carrelli` (
  `cartId` int(11) NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`cartId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.immagini
CREATE TABLE IF NOT EXISTS `immagini` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `imageData` longblob NOT NULL,
  `imageName` varchar(255) NOT NULL DEFAULT '',
  `imageType` varchar(255) NOT NULL,
  `imageSize` varchar(45) NOT NULL,
  `imageTmpName` varchar(255) DEFAULT NULL,
  `imageError` varchar(45) DEFAULT NULL,
  `imageURL` varchar(255) DEFAULT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `FKcategoryId` int(11) DEFAULT NULL,
  `FKproductId` int(11) DEFAULT NULL,
  PRIMARY KEY (`imageId`),
  KEY `FK_immagini_carrelli` (`FKcategoryId`),
  KEY `FK_immagini_prodotti` (`FKproductId`),
  CONSTRAINT `FK_immagini_carrelli` FOREIGN KEY (`FKcategoryId`) REFERENCES `categorie` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_immagini_prodotti` FOREIGN KEY (`FKproductId`) REFERENCES `prodotti` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.interazioni
CREATE TABLE IF NOT EXISTS `interazioni` (
  `FKuserId` int(11) NOT NULL,
  `FKproductId` int(11) NOT NULL,
  `FKcartId` int(11) NOT NULL,
  `tipologia` enum('visualizzato','messo nel carrello','acquistato') NOT NULL,
  `timestamp` timestamp NOT NULL,
  PRIMARY KEY (`FKuserId`,`FKproductId`,`FKcartId`),
  KEY `FK_interazioni_prodotti` (`FKproductId`),
  KEY `FK_interazioni_carrelli` (`FKcartId`),
  CONSTRAINT `FK_interazioni_carrelli` FOREIGN KEY (`FKcartId`) REFERENCES `carrelli` (`cartId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_interazioni_prodotti` FOREIGN KEY (`FKproductId`) REFERENCES `prodotti` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_interazioni_utenti` FOREIGN KEY (`FKuserId`) REFERENCES `utenti` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='tabella di interazione tra utenti prodotti e carrello';

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.metodipagamento
CREATE TABLE IF NOT EXISTS `metodipagamento` (
  `numeroCartaHash` varchar(80) NOT NULL DEFAULT '',
  `nomeCarta` varchar(35) NOT NULL,
  `tipologia` enum('visa','paypal','mastercard','revolut') NOT NULL,
  `scadenza` datetime NOT NULL,
  `cvvHash` varchar(80) NOT NULL DEFAULT '',
  `soprannomeCarta` varchar(35) DEFAULT NULL,
  `FKuserId` int(11) NOT NULL,
  PRIMARY KEY (`numeroCartaHash`) USING BTREE,
  KEY `userId_pay` (`FKuserId`) USING BTREE,
  CONSTRAINT `FK_metodipagamento_utenti` FOREIGN KEY (`FKuserId`) REFERENCES `utenti` (`userId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.prodotti
CREATE TABLE IF NOT EXISTS `prodotti` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL DEFAULT '',
  `descrizione` varchar(100) NOT NULL DEFAULT '',
  `prezzo` float NOT NULL DEFAULT 0,
  `saga` varchar(50) DEFAULT NULL,
  `piattaforma` enum('PS4','PS5','PC','XBOX360','XBOXONE') DEFAULT NULL,
  `quantitaDisponibile` int(11) NOT NULL,
  `dataUscita` date NOT NULL,
  `dataDisponibile` date DEFAULT NULL,
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura di tabella rungamedb.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `userId` int(4) NOT NULL AUTO_INCREMENT,
  `nome` char(50) NOT NULL,
  `cognome` char(35) NOT NULL,
  `dataNascita` date NOT NULL DEFAULT '0000-00-00',
  `dataIscrizione` date NOT NULL DEFAULT '0000-00-00',
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL DEFAULT '',
  `passwordHash` varchar(80) NOT NULL DEFAULT '',
  `codiceVerifica` varchar(10) NOT NULL,
  `verificato` bit(1) NOT NULL DEFAULT b'0',
  `FKimmagineProfilo` int(11) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  KEY `immagineProfilo` (`FKimmagineProfilo`) USING BTREE,
  CONSTRAINT `FK_utenti_immagini` FOREIGN KEY (`FKimmagineProfilo`) REFERENCES `immagini` (`imageId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- L’esportazione dei dati non era selezionata.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
