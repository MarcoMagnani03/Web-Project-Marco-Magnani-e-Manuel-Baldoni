-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              11.3.2-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database ecommerce_tw
CREATE DATABASE IF NOT EXISTS `ecommerce_tw` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ecommerce_tw`;

-- Dump della struttura di tabella ecommerce_tw.carrello
CREATE TABLE IF NOT EXISTS `carrello` (
  `prodotto` int(11) NOT NULL,
  `utente` varchar(255) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`utente`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.carrello: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.categoria: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.categoria_prodotto
CREATE TABLE IF NOT EXISTS `categoria_prodotto` (
  `prodotto` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  PRIMARY KEY (`prodotto`,`categoria`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `categoria_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `categoria_prodotto_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.categoria_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.immagine_prodotto
CREATE TABLE IF NOT EXISTS `immagine_prodotto` (
  `prodotto` int(11) NOT NULL,
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`,`prodotto`) USING BTREE,
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `immagine_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.immagine_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.notifica
CREATE TABLE IF NOT EXISTS `notifica` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  `contenuto` text NOT NULL,
  `letta` tinyint(1) NOT NULL,
  `dataCreazione` date NOT NULL,
  `tipologia` varchar(50) DEFAULT NULL,
  `utente` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`),
  KEY `tipologia` (`tipologia`),
  KEY `utente` (`utente`),
  CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`tipologia`) REFERENCES `tipo_notifica` (`titolo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `notifica_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.notifica: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.ordine
CREATE TABLE IF NOT EXISTS `ordine` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `DataPartenza` date NOT NULL,
  `DataArrivo` date NOT NULL,
  `stato` varchar(50) DEFAULT NULL,
  `utente` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`),
  KEY `stato` (`stato`),
  KEY `utente` (`utente`),
  CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`stato`) REFERENCES `stato_ordine` (`titolo`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.prodotti_ordine
CREATE TABLE IF NOT EXISTS `prodotti_ordine` (
  `ordine` int(11) NOT NULL,
  `prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`ordine`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `prodotti_ordine_ibfk_1` FOREIGN KEY (`ordine`) REFERENCES `ordine` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prodotti_ordine_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.prodotti_ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.prodotto
CREATE TABLE IF NOT EXISTS `prodotto` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `dataCreazione` date NOT NULL,
  `stato` varchar(50) NOT NULL,
  `quantita` int(11) DEFAULT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.recensione
CREATE TABLE IF NOT EXISTS `recensione` (
  `utente` varchar(255) NOT NULL,
  `prodotto` int(11) NOT NULL,
  `valutazione` int(11) NOT NULL,
  `titolo` varchar(255) DEFAULT NULL,
  `descrizione` text DEFAULT NULL,
  `dataCreazione` date NOT NULL,
  PRIMARY KEY (`utente`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.recensione: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.stato_ordine
CREATE TABLE IF NOT EXISTS `stato_ordine` (
  `titolo` varchar(50) NOT NULL,
  PRIMARY KEY (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.stato_ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.tipo_notifica
CREATE TABLE IF NOT EXISTS `tipo_notifica` (
  `titolo` varchar(50) NOT NULL,
  PRIMARY KEY (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.tipo_notifica: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.utente
CREATE TABLE IF NOT EXISTS `utente` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `dataDiNascita` date DEFAULT NULL,
  `ruolo` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.utente: ~0 rows (circa)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
