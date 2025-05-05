-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              11.6.2-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.8.0.6908
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
DROP DATABASE IF EXISTS `rungamedb`;
CREATE DATABASE IF NOT EXISTS `rungamedb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `rungamedb`;

-- Dump della struttura di tabella rungamedb.appartenenze
DROP TABLE IF EXISTS `appartenenze`;
CREATE TABLE IF NOT EXISTS `appartenenze` (
  `FKcategoryId` int(11) NOT NULL,
  `FKproductId` int(11) NOT NULL,
  PRIMARY KEY (`FKcategoryId`,`FKproductId`),
  KEY `FK_appartenenze_prodotti` (`FKproductId`),
  CONSTRAINT `FK_appartenenze_categorie` FOREIGN KEY (`FKcategoryId`) REFERENCES `categorie` (`categoryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_appartenenze_prodotti` FOREIGN KEY (`FKproductId`) REFERENCES `prodotti` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci COMMENT='interazione tra categorie e prodotti';

-- Dump dei dati della tabella rungamedb.appartenenze: ~0 rows (circa)
DELETE FROM `appartenenze`;

-- Dump della struttura di tabella rungamedb.carrelli
DROP TABLE IF EXISTS `carrelli`;
CREATE TABLE IF NOT EXISTS `carrelli` (
  `cartId` int(11) NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`cartId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Dump dei dati della tabella rungamedb.carrelli: ~0 rows (circa)
DELETE FROM `carrelli`;

-- Dump della struttura di tabella rungamedb.categorie
DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(35) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Dump dei dati della tabella rungamedb.categorie: ~8 rows (circa)
DELETE FROM `categorie`;
INSERT INTO `categorie` (`categoryId`, `nome`) VALUES
	(1, 'Avventura'),
	(2, 'Horror'),
	(3, 'RPG'),
	(4, 'Sport'),
	(5, 'Azione'),
	(6, 'Picchiaduro'),
	(7, 'Corsa'),
	(8, 'Sparatutto');

-- Dump della struttura di tabella rungamedb.immagini
DROP TABLE IF EXISTS `immagini`;
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

-- Dump dei dati della tabella rungamedb.immagini: ~0 rows (circa)
DELETE FROM `immagini`;

-- Dump della struttura di tabella rungamedb.interazioni
DROP TABLE IF EXISTS `interazioni`;
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

-- Dump dei dati della tabella rungamedb.interazioni: ~0 rows (circa)
DELETE FROM `interazioni`;

-- Dump della struttura di tabella rungamedb.metodipagamento
DROP TABLE IF EXISTS `metodipagamento`;
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

-- Dump dei dati della tabella rungamedb.metodipagamento: ~0 rows (circa)
DELETE FROM `metodipagamento`;

-- Dump della struttura di tabella rungamedb.prodotti
DROP TABLE IF EXISTS `prodotti`;
CREATE TABLE IF NOT EXISTS `prodotti` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL DEFAULT '',
  `descrizione` varchar(350) NOT NULL DEFAULT '',
  `prezzo` float NOT NULL DEFAULT 0,
  `saga` varchar(50) DEFAULT NULL,
  `piattaforma` enum('PS3','PS4','PS5','PC','XBOX360','XBOXONE') DEFAULT NULL,
  `quantitaDisponibile` int(11) NOT NULL,
  `dataUscita` date NOT NULL,
  `dataDisponibile` date DEFAULT NULL,
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Dump dei dati della tabella rungamedb.prodotti: ~6 rows (circa)
DELETE FROM `prodotti`;
INSERT INTO `prodotti` (`productId`, `nome`, `descrizione`, `prezzo`, `saga`, `piattaforma`, `quantitaDisponibile`, `dataUscita`, `dataDisponibile`) VALUES
	(1, 'Uncharted: Drake\'s Fortune', 'Uncharted: Drake\'s Fortune è un action-adventure dove Nathan Drake, cacciatore di tesori scaltro e ironico, cerca un tesoro legato a Sir Francis Drake. Esplorando un\'isola sperduta, affronta mercenari e scopre un antico segreto, tra sparatorie, arrampicate e enigmi ambientali. Un mix di azione e esplorazione.', 11, 'Uncharted', 'PS3', 542, '2007-11-19', '2007-12-07'),
	(3, 'Uncharted: The Nathan Drake Collection', 'Uncharted: The Nathan Drake Collection raccoglie i primi tre giochi della serie, migliorati graficamente. Include Drake\'s Fortune, Among Thieves e Drake\'s Deception, con controlli unificati, nuovi livelli di difficoltà e modalità Speed Run, ma senza il multiplayer originale.', 22.9, 'Uncharted', 'PS4', 623, '2015-10-07', '2015-10-07'),
	(4, 'Uncharted 2: Among Thieves', 'Uncharted 2: Among Thieves è un action-adventure che segue Nathan Drake nella ricerca di un artefatto leggendario, il Cintamani Stone, in Asia. Affronta mercenari, tradimenti e pericoli, con un mix di esplorazione, combattimenti, arrampicate e puzzle, e una trama ricca di colpi di scena.', 11.9, 'Uncharted', 'PS3', 623, '2009-10-13', '2009-10-16'),
	(5, 'Uncharted 3: Drake\'s Deception', 'Uncharted 3: Drake\'s Deception segue Nathan Drake alla ricerca della leggendaria città di Iram, nel deserto arabico. Tra tradimenti e misteri antichi, esplora luoghi esotici, affronta combattimenti intensi e risolve enigmi complessi, con una trama ricca di azione e colpi di scena.', 11.9, 'Uncharted', 'PS3', 623, '2011-11-01', '2011-11-02'),
	(6, 'Uncharted 4: Fine di un ladro', 'Uncharted 4: A Thief\'s End segue Nathan Drake che, ormai ritirato, viene richiamato in azione per cercare il tesoro del pirata Henry Avery. Tra avventure, inseguimenti e battaglie, il gioco esplora il passato di Drake, la sua relazione con il fratello Sam e il suo desiderio di una vita tranquilla, ma coinvolta in nuovi pericoli.', 24.9, 'Uncharted', 'PS4', 125, '2016-05-10', '2016-05-10'),
	(7, 'Uncharted 4: Fine di un ladro', 'Uncharted 4: A Thief\'s End segue Nathan Drake che, ormai ritirato, viene richiamato in azione per cercare il tesoro del pirata Henry Avery. Tra avventure, inseguimenti e battaglie, il gioco esplora il passato di Drake, la sua relazione con il fratello Sam e il suo desiderio di una vita tranquilla, ma coinvolta in nuovi pericoli.', 35.99, 'Uncharted', 'PS5', 125, '2022-01-28', '2022-01-28');

-- Dump della struttura di tabella rungamedb.utenti
DROP TABLE IF EXISTS `utenti`;
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

-- Dump dei dati della tabella rungamedb.utenti: ~0 rows (circa)
DELETE FROM `utenti`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;