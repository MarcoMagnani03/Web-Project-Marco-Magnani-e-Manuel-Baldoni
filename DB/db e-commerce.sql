DROP TABLE IF EXISTS `carrello`;
DROP TABLE IF EXISTS `prodotti_ordine`;
DROP TABLE IF EXISTS `recensione`;
DROP TABLE IF EXISTS `immagine_prodotto`;
DROP TABLE IF EXISTS `notifica`;
DROP TABLE IF EXISTS `categoria_prodotto`;
DROP TABLE IF EXISTS `ordine`;
DROP TABLE IF EXISTS `categoria`;
DROP TABLE IF EXISTS `prodotto`;
DROP TABLE IF EXISTS `stato_ordine`;
DROP TABLE IF EXISTS `tipo_notifica`;
DROP TABLE IF EXISTS `utente`;
DROP TABLE IF EXISTS `caratteristica`;
DROP TABLE IF EXISTS `categoria_caratteristica`;
DROP TABLE IF EXISTS `prodotto_caratteristica`;

-- Creazione della tabella utente
CREATE TABLE IF NOT EXISTS `utente` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `dataDiNascita` date DEFAULT NULL,
  `ruolo` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella prodotto
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

-- Creazione della tabella carrello con chiavi esterne
CREATE TABLE IF NOT EXISTS `carrello` (
  `prodotto` int(11) NOT NULL,
  `utente` varchar(255) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`utente`, `prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `categoria_padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`codice`),
  CONSTRAINT `fk_categoria_padre`
    FOREIGN KEY (`categoria_padre`) REFERENCES `categoria` (`codice`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella categoria_prodotto
CREATE TABLE IF NOT EXISTS `categoria_prodotto` (
  `prodotto` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  PRIMARY KEY (`prodotto`,`categoria`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `categoria_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `categoria_prodotto_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella immagine_prodotto
CREATE TABLE IF NOT EXISTS `immagine_prodotto` (
  `prodotto` int(11) NOT NULL,
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  PRIMARY KEY (`codice`,`prodotto`) USING BTREE,
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `immagine_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella tipo_notifica
CREATE TABLE IF NOT EXISTS `tipo_notifica` (
  `titolo` varchar(50) NOT NULL,
  PRIMARY KEY (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella notifica
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

-- Creazione della tabella stato_ordine
CREATE TABLE IF NOT EXISTS `stato_ordine` (
  `titolo` varchar(50) NOT NULL,
  PRIMARY KEY (`titolo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella ordine
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

-- Creazione della tabella prodotti_ordine
CREATE TABLE IF NOT EXISTS `prodotti_ordine` (
  `ordine` int(11) NOT NULL,
  `prodotto` int(11) NOT NULL,
  `quantita` int(11) NOT NULL,
  PRIMARY KEY (`ordine`,`prodotto`),
  KEY `prodotto` (`prodotto`),
  CONSTRAINT `prodotti_ordine_ibfk_1` FOREIGN KEY (`ordine`) REFERENCES `ordine` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prodotti_ordine_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione della tabella recensione
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

-- Tabella delle caratteristiche generali
CREATE TABLE IF NOT EXISTS `caratteristica` (
  `codice` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL, -- es. "RAM", "CPU", "memoria", "velocità", ecc.
  PRIMARY KEY (`codice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabella di collegamento tra categoria e caratteristica
CREATE TABLE IF NOT EXISTS `categoria_caratteristica` (
  `categoria_codice` int(11) NOT NULL,
  `caratteristica_codice` int(11) NOT NULL,
  PRIMARY KEY (`categoria_codice`, `caratteristica_codice`),
  CONSTRAINT `fk_categoria_caratteristica_categoria` FOREIGN KEY (`categoria_codice`) REFERENCES `categoria` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_categoria_caratteristica_caratteristica` FOREIGN KEY (`caratteristica_codice`) REFERENCES `caratteristica` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabella di collegamento tra prodotto e caratteristica specifica del prodotto
CREATE TABLE IF NOT EXISTS `prodotto_caratteristica` (
  `prodotto_codice` int(11) NOT NULL,
  `caratteristica_codice` int(11) NOT NULL,
  `valore` varchar(255) NOT NULL, -- es. "16GB", "Intel i7", ecc.
  PRIMARY KEY (`prodotto_codice`, `caratteristica_codice`),
  CONSTRAINT `fk_prodotto_caratteristica_prodotto` FOREIGN KEY (`prodotto_codice`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_prodotto_caratteristica_caratteristica` FOREIGN KEY (`caratteristica_codice`) REFERENCES `caratteristica` (`codice`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
