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

DROP TABLE IF EXISTS RECENSIONE;
DROP TABLE IF EXISTS PRODOTTI_ORDINE;
DROP TABLE IF EXISTS ORDINE;
DROP TABLE IF EXISTS STATO_ORDINE;
DROP TABLE IF EXISTS CARRELLO;
DROP TABLE IF EXISTS SPECIFICA_PRODOTTO;
DROP TABLE IF EXISTS CARATTERISTICA_PRODOTTO;
DROP TABLE IF EXISTS IMMAGINE_PRODOTTO;
DROP TABLE IF EXISTS PRODOTTO;
DROP TABLE IF EXISTS MARCA;
DROP TABLE IF EXISTS TIPOLOGIA_PRODOTTO;
DROP TABLE IF EXISTS NOTIFICA;
DROP TABLE IF EXISTS TIPO_NOTIFICA;
DROP TABLE IF EXISTS UTENTE;


-- Dump della struttura di tabella ecommerce_tw.caratteristica_prodotto
CREATE TABLE IF NOT EXISTS `caratteristica_prodotto` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `tipologia` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`),
  KEY `tipologia` (`tipologia`),
  CONSTRAINT `caratteristica_prodotto_ibfk_1` FOREIGN KEY (`tipologia`) REFERENCES `tipologia_prodotto` (`nome`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.caratteristica_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.carrello
CREATE TABLE IF NOT EXISTS `carrello` (
  `utente` varchar(255) NOT NULL,
  `prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`utente`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.carrello: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.immagine_prodotto
CREATE TABLE IF NOT EXISTS `immagine_prodotto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prodotto` int(11) NOT NULL,
  `percorso` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `immagine_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.immagine_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.marca
CREATE TABLE IF NOT EXISTS `marca` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.marca: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.notifica
CREATE TABLE IF NOT EXISTS `notifica` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  `contenuto` text NOT NULL,
  `letta` tinyint(1) DEFAULT 0,
  `dataOraCreazione` datetime NOT NULL,
  `utenteEmail` varchar(255) NOT NULL,
  `tipologia` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`),
  KEY `utenteEmail` (`utenteEmail`),
  KEY `tipologia` (`tipologia`),
  CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`utenteEmail`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  CONSTRAINT `notifica_ibfk_2` FOREIGN KEY (`tipologia`) REFERENCES `tipo_notifica` (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.notifica: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.ordine
CREATE TABLE IF NOT EXISTS `ordine` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `dataPartenza` date NOT NULL,
  `dataOraArrivo` datetime NOT NULL,
  `utente` varchar(255) DEFAULT NULL,
  `stato` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`),
  KEY `utente` (`utente`),
  KEY `stato` (`stato`),
  CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE SET NULL,
  CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`stato`) REFERENCES `stato_ordine` (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.prodotti_ordine
CREATE TABLE IF NOT EXISTS `prodotti_ordine` (
  `ordine` int(11) NOT NULL,
  `prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`ordine`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `prodotti_ordine_ibfk_1` FOREIGN KEY (`ordine`) REFERENCES `ordine` (`codice`) ON DELETE CASCADE,
  CONSTRAINT `prodotti_ordine_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.prodotti_ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.prodotto
CREATE TABLE IF NOT EXISTS `prodotto` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) NOT NULL,
  `dataCreazione` date NOT NULL,
  `stato` enum('disponibile','non disponibile') NOT NULL,
  `quantita` int(11) NOT NULL,
  `tipologia` varchar(255) NOT NULL,
  `marca` int(11) DEFAULT NULL,
  PRIMARY KEY (`codice`),
  UNIQUE KEY `nome` (`nome`),
  KEY `marca` (`marca`),
  KEY `tipologia` (`tipologia`),
  CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`marca`) REFERENCES `marca` (`codice`),
  CONSTRAINT `prodotto_ibfk_2` FOREIGN KEY (`tipologia`) REFERENCES `tipologia_prodotto` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.recensione
CREATE TABLE IF NOT EXISTS `recensione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valutazione` int(11) DEFAULT NULL CHECK (`valutazione` between 1 and 5),
  `titolo` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  `dataCreazione` date NOT NULL,
  `utente` varchar(255) NOT NULL,
  `prodotto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utente` (`utente`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.recensione: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.specifica_prodotto
CREATE TABLE IF NOT EXISTS `specifica_prodotto` (
  `prodotto` int(11) NOT NULL,
  `caratteristica` int(11) NOT NULL,
  `contenuto` text NOT NULL,
  PRIMARY KEY (`prodotto`,`caratteristica`),
  KEY `caratteristica` (`caratteristica`),
  CONSTRAINT `specifica_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE,
  CONSTRAINT `specifica_prodotto_ibfk_2` FOREIGN KEY (`caratteristica`) REFERENCES `caratteristica_prodotto` (`codice`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.specifica_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.stato_ordine
CREATE TABLE IF NOT EXISTS `stato_ordine` (
  `titolo` varchar(255) NOT NULL,
  PRIMARY KEY (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.stato_ordine: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.tipologia_prodotto
CREATE TABLE IF NOT EXISTS `tipologia_prodotto` (
  `nome` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.tipologia_prodotto: ~0 rows (circa)

-- Dump della struttura di tabella ecommerce_tw.tipo_notifica
CREATE TABLE IF NOT EXISTS `tipo_notifica` (
  `titolo` varchar(255) NOT NULL,
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
  `ruolo` enum('venditore','cliente') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati della tabella ecommerce_tw.utente: ~0 rows (circa)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
