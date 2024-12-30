-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 30, 2024 alle 17:03
-- Versione del server: 11.3.2-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_tw`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `caratteristica_prodotto`
--

CREATE TABLE `caratteristica_prodotto` (
  `codice` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `tipologia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `caratteristica_prodotto`
--

INSERT INTO `caratteristica_prodotto` (`codice`, `nome`, `descrizione`, `tipologia`) VALUES
(1, 'Frequenza (Hz)', 'La frequenza di refresh della scheda video', 'Scheda video'),
(2, 'Memoria (GB)', 'La memoria integrata della scheda video', 'Scheda video');

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `utente` varchar(255) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `immagine_prodotto`
--

CREATE TABLE `immagine_prodotto` (
  `id` int(11) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `percorso` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `immagine_prodotto`
--

INSERT INTO `immagine_prodotto` (`id`, `prodotto`, `percorso`) VALUES
(1, 'c4df3639-385c-44ed-8b61-00abb4d32659', 'Foto Marco_compressa.jpg'),
(2, '289249f4-5963-422a-98ef-28e3c803c566', '81cy1Ep7vFL._AC_SL1500_.jpg'),
(3, 'ae0f7c0d-b658-4b2d-8594-8840ad38ade5', '81cy1Ep7vFL._AC_SL1500_.jpg'),
(4, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', '81cy1Ep7vFL._AC_SL1500_.jpg'),
(5, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', '613tjCIW93L._AC_SL1500_.jpg'),
(6, 'ed662d36-bcdc-4075-81d7-69ffd4a048e7', '613tjCIW93L._AC_SL1500_.jpg'),
(7, '5e4e562d-8ef2-4017-bff9-145ed7137f3e', '613tjCIW93L._AC_SL1500_.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `marca`
--

CREATE TABLE `marca` (
  `codice` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `marca`
--

INSERT INTO `marca` (`codice`, `titolo`) VALUES
(1, 'HP'),
(2, 'NVIDIA'),
(10, 'AMD');

-- --------------------------------------------------------

--
-- Struttura della tabella `notifica`
--

CREATE TABLE `notifica` (
  `codice` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `contenuto` text NOT NULL,
  `letta` tinyint(1) DEFAULT 0,
  `dataOraCreazione` datetime NOT NULL,
  `utenteEmail` varchar(255) NOT NULL,
  `tipologia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `notifica`
--

INSERT INTO `notifica` (`codice`, `titolo`, `contenuto`, `letta`, `dataOraCreazione`, `utenteEmail`, `tipologia`) VALUES
(1, 'Notifica Bella', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque interdum tortor non odio faucibus, et porttitor lacus lobortis. Maecenas nec lectus a turpis tempor luctus eget id purus. Phasellus dolor nunc, blandit quis euismod vel, placerat id tellus. Maecenas et erat quis lectus aliquet mattis vitae sit amet nunc. Vivamus eget facilisis orci. Maecenas sit amet tempor risus, a accumsan velit. Fusce sagittis sit amet nisl eu varius. Quisque a tincidunt sem, at dapibus mauris. Suspendisse aliquet nisi ornare metus tempus, et elementum turpis cursus.\r\n\r\nMorbi dui neque, porttitor et justo ut, accumsan consectetur libero. Sed enim enim, efficitur vitae arcu vulputate, aliquet euismod tellus. Nullam fermentum nibh non enim euismod, eu pellentesque ante bibendum. Duis sodales ac sem et convallis. Sed quis tristique orci, ac tempor tortor. Pellentesque posuere, est at egestas fringilla, magna lorem congue velit, eu interdum sapien leo nec arcu. Sed gravida neque et felis iaculis ultricies. Donec nulla urna, egestas et feugiat lacinia, varius non eros. Donec lobortis tellus vitae lacinia rutrum. Nullam eu augue fringilla, aliquet ante nec, euismod quam.', 0, '2024-11-25 18:03:01', 'admin@takeit.it', 'informazione'),
(2, 'Aggiornamento Sistema', 'Aggiornamento dei server completato con successo.', 0, '2024-11-30 09:00:00', 'admin@takeit.it', 'informazione'),
(3, 'Nuova Funzione Disponibile', 'È stata aggiunta una nuova funzionalità alla piattaforma.', 0, '2024-11-30 10:30:00', 'admin@takeit.it', 'informazione'),
(4, 'Manutenzione Programmata', 'La manutenzione programmata avrà luogo il 1° dicembre dalle 02:00 alle 04:00.', 1, '2024-11-30 11:15:00', 'admin@takeit.it', 'informazione'),
(5, 'Cambio Password Consigliato', 'Per motivi di sicurezza, ti consigliamo di cambiare la password.', 0, '2024-11-30 12:00:00', 'admin@takeit.it', 'informazione'),
(6, 'Politica Privacy Aggiornata', 'La politica sulla privacy è stata aggiornata, consulta la nuova versione.', 0, '2024-11-30 12:45:00', 'admin@takeit.it', 'informazione'),
(7, 'Offerta Speciale', 'Sconto del 20% su tutti i piani per un periodo limitato.', 0, '2024-11-30 13:30:00', 'admin@takeit.it', 'informazione'),
(8, 'Supporto Tecnico Migliorato', 'Il supporto tecnico è stato ampliato per migliorare l\'assistenza.', 0, '2024-11-30 14:00:00', 'admin@takeit.it', 'informazione'),
(9, 'Aggiornamento Condizioni d\'Uso', 'Le condizioni d\'uso sono state modificate, ti invitiamo a leggerle.', 0, '2024-11-30 15:00:00', 'admin@takeit.it', 'informazione'),
(10, 'Sicurezza degli Account', 'Sono state implementate nuove misure di sicurezza per gli account.', 0, '2024-11-30 15:30:00', 'admin@takeit.it', 'informazione'),
(11, 'Promemoria Evento', 'Non dimenticare l\'evento speciale di domani alle 18:00.', 0, '2024-11-30 16:00:00', 'admin@takeit.it', 'informazione'),
(12, 'Creata nuova tipologia prodotto', 'Creata tipologia prodotto con nome: prova', 0, '2024-12-25 14:43:11', 'admin@takeit.it', 'informazione'),
(13, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: prova', 0, '2024-12-25 14:47:39', 'admin@takeit.it', 'informazione'),
(14, 'Eliminazione tipologia prodotto', 'Eliminata tipologia con nome: prova', 0, '2024-12-25 14:47:50', 'admin@takeit.it', 'informazione'),
(15, 'Ordine modificato', 'Modificato l\'ordine n° 1', 1, '2024-12-26 17:15:37', 'admin@takeit.it', 'informazione'),
(16, 'Ordine modificato', 'Modificato l\'ordine n° 1', 0, '2024-12-26 17:16:36', 'admin@takeit.it', 'informazione'),
(17, 'Creata nuova marca', 'Creata una nuova marca con titolo: pro', 0, '2024-12-28 16:41:05', 'admin@takeit.it', 'informazione'),
(18, 'Creata nuova marca', 'Creata una nuova marca con titolo: AMD', 0, '2024-12-28 16:51:47', 'admin@takeit.it', 'informazione'),
(19, 'Creata nuova marca', 'Creata una nuova marca con titolo: prova', 0, '2024-12-28 16:53:32', 'admin@takeit.it', 'informazione'),
(20, 'Creata nuova marca', 'Creata una nuova marca con titolo: AMD', 0, '2024-12-30 10:02:26', 'admin@takeit.it', 'informazione'),
(21, 'Creata nuova marca', 'Creata una nuova marca con titolo: AMD', 0, '2024-12-30 10:03:35', 'admin@takeit.it', 'informazione'),
(22, 'Eliminata una marca', 'Eliminata la marca con codice: 9', 0, '2024-12-30 10:03:38', 'admin@takeit.it', 'informazione'),
(23, 'Creata nuova marca', 'Creata una nuova marca con titolo: AMD', 0, '2024-12-30 10:05:14', 'admin@takeit.it', 'informazione'),
(24, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 15:23:34', 'admin@takeit.it', 'informazione'),
(25, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 16:52:30', 'admin@takeit.it', 'informazione'),
(26, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 16:56:45', 'admin@takeit.it', 'informazione'),
(27, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 17:00:30', 'admin@takeit.it', 'informazione'),
(28, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 17:00:38', 'admin@takeit.it', 'informazione'),
(29, 'Modificato prodotto', 'Modificato il prodotto di codice 289249f4-5963-422a-98ef-28e3c803c566', 0, '2024-12-30 17:01:00', 'admin@takeit.it', 'informazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `ordine`
--

CREATE TABLE `ordine` (
  `codice` int(11) NOT NULL,
  `dataPartenza` date NOT NULL,
  `dataOraArrivo` datetime NOT NULL,
  `utente` varchar(255) DEFAULT NULL,
  `stato` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ordine`
--

INSERT INTO `ordine` (`codice`, `dataPartenza`, `dataOraArrivo`, `utente`, `stato`) VALUES
(1, '2024-12-01', '2024-12-12 16:30:00', 'admin@takeit.it', 'In consegna'),
(2, '2024-12-02', '2024-12-03 16:45:00', 'marco.magnani30@studio.unibo.it', 'in consegna'),
(3, '2024-11-29', '2024-12-01 10:00:00', 'admin@takeit.it', 'consegnato'),
(4, '2024-12-01', '2024-12-03 15:00:00', 'marco.magnani30@studio.unibo.it', 'eliminato'),
(5, '2024-12-03', '2024-12-04 12:00:00', 'admin@takeit.it', 'in elaborazione'),
(6, '2024-12-04', '2024-12-05 18:00:00', 'marco.magnani30@studio.unibo.it', 'in consegna'),
(7, '2024-12-05', '2024-12-06 14:00:00', 'admin@takeit.it', 'consegnato'),
(8, '2024-12-06', '2024-12-07 11:00:00', 'marco.magnani30@studio.unibo.it', 'in consegna'),
(9, '2024-12-07', '2024-12-08 09:30:00', 'admin@takeit.it', 'in elaborazione'),
(10, '2024-12-08', '2024-12-09 16:00:00', 'marco.magnani30@studio.unibo.it', 'eliminato');

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_ordine`
--

CREATE TABLE `prodotti_ordine` (
  `ordine` int(11) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotti_ordine`
--

INSERT INTO `prodotti_ordine` (`ordine`, `prodotto`, `quantita`) VALUES
(1, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 2),
(1, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 1),
(2, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 1),
(2, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 3),
(3, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 4),
(3, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 2),
(4, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 1),
(5, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 5),
(6, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 3),
(6, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 2),
(7, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 2),
(8, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 4),
(9, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 1),
(9, 'd3adfd23-b3a5-43ae-908b-6c2b49f23847', 1),
(10, 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `codice` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(20,2) NOT NULL,
  `dataCreazione` date NOT NULL,
  `stato` enum('disponibile','non disponibile') NOT NULL,
  `quantita` int(11) NOT NULL,
  `tipologia` varchar(255) NOT NULL,
  `marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`codice`, `nome`, `descrizione`, `prezzo`, `dataCreazione`, `stato`, `quantita`, `tipologia`, `marca`) VALUES
('289249f4-5963-422a-98ef-28e3c803c566', 'nuovo prodotto con immaginetta', 'prova nuovo prodotto con immagine brutta', 150.01, '2024-12-14', 'disponibile', 12011, 'Scheda video', 10),
('5e4e562d-8ef2-4017-bff9-145ed7137f3e', 'Prova Baldo merda', 'Prova che baldo non sa fare un canzo', 120.00, '2024-12-27', 'disponibile', 10, 'Scheda video', 2),
('ae0f7c0d-b658-4b2d-8594-8840ad38ade5', 'nuovo prodotto', 'prova nuovo prodotto', 12.00, '2024-12-13', 'disponibile', 11, 'Scheda video', 2),
('c4df3639-385c-44ed-8b61-00abb4d32659', 'Prova immagine', 'Prova immagine', 2432.00, '2024-12-13', 'disponibile', 55325, 'Scheda video', 2),
('c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 'RTX 3050 LP 6G OC', 'La GeForce RTX 3050 da 6 GB è basata sull\'architettura NVIDIA Ampere.\r\nDispone di core di ray tracing dedicati, core tensoriali AI e memoria G6 veloce.\r\nL design piatto consente di ottimizzare lo spazio; si adatta a sistemi sottili o piccoli', 183.99, '2024-11-22', 'disponibile', 5, 'Scheda video', 2),
('d3adfd23-b3a5-43ae-908b-6c2b49f23847', 'RTX 3050 VENTUS 2X XS', 'Le schede grafiche serie Ventus sono pensate per fornire prestazioni elevate in un prodotto che offre tutte le caratteristiche essenziali per completare qualsiasi attività. Un sistema di raffreddamento con due ventole posizionate sopra un robusto design industriale conferisce a queste schede grafiche dall\'aspetto lavorato in grado di integrarsi con qualsiasi PC.', 216.93, '2024-11-22', 'disponibile', 2, 'Scheda video', 2),
('ed662d36-bcdc-4075-81d7-69ffd4a048e7', 'Ultimo prodotto', 'Ultimo prodotto di prova', 10000.05, '2024-12-13', 'disponibile', 190, 'Scheda video', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `recensione`
--

CREATE TABLE `recensione` (
  `id` int(11) NOT NULL,
  `valutazione` int(11) DEFAULT NULL CHECK (`valutazione` between 1 and 5),
  `titolo` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  `dataCreazione` date NOT NULL,
  `utente` varchar(255) NOT NULL,
  `prodotto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `recensione`
--

INSERT INTO `recensione` (`id`, `valutazione`, `titolo`, `descrizione`, `dataCreazione`, `utente`, `prodotto`) VALUES
(1, 4, 'Ma che bel prodotto!', 'Un bellissimo prodotto, ma Marco è brutto. Niente 5 stelle per Marco', '2024-11-26', 'admin@takeit.it', 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8'),
(2, 2, 'Brutto!', 'Marco è brutto, ma questo prodotto di più!', '2024-11-26', 'admin@takeit.it', 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8'),
(3, 5, 'Perfetto!', 'Bello bello', '2024-11-27', 'admin@takeit.it', 'c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8');

-- --------------------------------------------------------

--
-- Struttura della tabella `specifica_prodotto`
--

CREATE TABLE `specifica_prodotto` (
  `prodotto` varchar(255) NOT NULL,
  `caratteristica` int(11) NOT NULL,
  `contenuto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `specifica_prodotto`
--

INSERT INTO `specifica_prodotto` (`prodotto`, `caratteristica`, `contenuto`) VALUES
('289249f4-5963-422a-98ef-28e3c803c566', 1, '10001'),
('289249f4-5963-422a-98ef-28e3c803c566', 2, '1000'),
('5e4e562d-8ef2-4017-bff9-145ed7137f3e', 1, '34'),
('5e4e562d-8ef2-4017-bff9-145ed7137f3e', 2, '345'),
('ae0f7c0d-b658-4b2d-8594-8840ad38ade5', 1, '20'),
('ae0f7c0d-b658-4b2d-8594-8840ad38ade5', 2, '10'),
('c4df3639-385c-44ed-8b61-00abb4d32659', 1, '35'),
('c4df3639-385c-44ed-8b61-00abb4d32659', 2, '234'),
('c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 1, '1.4'),
('c9e1f9b0-97c2-4d8e-b52e-6e90d2d9f7c8', 2, '6'),
('ed662d36-bcdc-4075-81d7-69ffd4a048e7', 1, '45'),
('ed662d36-bcdc-4075-81d7-69ffd4a048e7', 2, '23553');

-- --------------------------------------------------------

--
-- Struttura della tabella `stato_ordine`
--

CREATE TABLE `stato_ordine` (
  `titolo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `stato_ordine`
--

INSERT INTO `stato_ordine` (`titolo`) VALUES
('consegnato'),
('eliminato'),
('In consegna'),
('In elaborazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipologia_prodotto`
--

CREATE TABLE `tipologia_prodotto` (
  `nome` varchar(255) NOT NULL,
  `descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipologia_prodotto`
--

INSERT INTO `tipologia_prodotto` (`nome`, `descrizione`) VALUES
('Scheda video', 'Scheda video molto bella');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipo_notifica`
--

CREATE TABLE `tipo_notifica` (
  `titolo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipo_notifica`
--

INSERT INTO `tipo_notifica` (`titolo`) VALUES
('errore'),
('informazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `dataDiNascita` date DEFAULT NULL,
  `ruolo` enum('venditore','cliente') NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `cellulare` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`email`, `password`, `nome`, `cognome`, `dataDiNascita`, `ruolo`, `salt`, `cellulare`) VALUES
('admin@takeit.it', '799301a6fa6d4bbd7c05473622261982e23c8980842888b514a2ade72518177ed34e98e779ba7f6b8b8ecce64124a7a85693e73095ededebb15b258b6b2e66b7', 'ass', 'as', '2024-11-28', 'venditore', '01264e6b3fc93b97273df3bab6a716a5e6a2b902e179ce03f922dd8e9173c9b3556c416bc9325f2212e8ad8a97921bad38bee1e145d2f9b4367c5d6eb28caee9', NULL),
('marco.magnani30@studio.unibo.it', '6b1ffb05f285d586fe9dc3f0506d5224019627fdfe0864d47528fb73666145e75fe71cd85466e6bed48bb5117eaf30e9ea8dec0c8b9d0e166f09fd66e51425a2', 'Marco', 'Magnani', '2004-10-24', 'cliente', 'da951e1665100da3cc204f5c2f8b935a31cd9ba5455ed9861c7c6fd56b539f2592b38e342eebe8bb1cec83b41a12c7732b6f53f0dc792b0b62b39344c155081d', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `caratteristica_prodotto`
--
ALTER TABLE `caratteristica_prodotto`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `tipologia` (`tipologia`);

--
-- Indici per le tabelle `carrello`
--
ALTER TABLE `carrello`
  ADD PRIMARY KEY (`utente`,`prodotto`),
  ADD KEY `prodotto` (`prodotto`);

--
-- Indici per le tabelle `immagine_prodotto`
--
ALTER TABLE `immagine_prodotto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotto` (`prodotto`);

--
-- Indici per le tabelle `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`codice`);

--
-- Indici per le tabelle `notifica`
--
ALTER TABLE `notifica`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `utenteEmail` (`utenteEmail`),
  ADD KEY `tipologia` (`tipologia`);

--
-- Indici per le tabelle `ordine`
--
ALTER TABLE `ordine`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `utente` (`utente`),
  ADD KEY `stato` (`stato`);

--
-- Indici per le tabelle `prodotti_ordine`
--
ALTER TABLE `prodotti_ordine`
  ADD PRIMARY KEY (`ordine`,`prodotto`),
  ADD KEY `prodotto` (`prodotto`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `marca` (`marca`),
  ADD KEY `tipologia` (`tipologia`);

--
-- Indici per le tabelle `recensione`
--
ALTER TABLE `recensione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utente` (`utente`),
  ADD KEY `prodotto` (`prodotto`);

--
-- Indici per le tabelle `specifica_prodotto`
--
ALTER TABLE `specifica_prodotto`
  ADD PRIMARY KEY (`prodotto`,`caratteristica`),
  ADD KEY `caratteristica` (`caratteristica`);

--
-- Indici per le tabelle `stato_ordine`
--
ALTER TABLE `stato_ordine`
  ADD PRIMARY KEY (`titolo`);

--
-- Indici per le tabelle `tipologia_prodotto`
--
ALTER TABLE `tipologia_prodotto`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `tipo_notifica`
--
ALTER TABLE `tipo_notifica`
  ADD PRIMARY KEY (`titolo`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `caratteristica_prodotto`
--
ALTER TABLE `caratteristica_prodotto`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `immagine_prodotto`
--
ALTER TABLE `immagine_prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `marca`
--
ALTER TABLE `marca`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `caratteristica_prodotto`
--
ALTER TABLE `caratteristica_prodotto`
  ADD CONSTRAINT `caratteristica_prodotto_ibfk_1` FOREIGN KEY (`tipologia`) REFERENCES `tipologia_prodotto` (`nome`) ON DELETE CASCADE;

--
-- Limiti per la tabella `carrello`
--
ALTER TABLE `carrello`
  ADD CONSTRAINT `carrello_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrello_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `immagine_prodotto`
--
ALTER TABLE `immagine_prodotto`
  ADD CONSTRAINT `immagine_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `notifica`
--
ALTER TABLE `notifica`
  ADD CONSTRAINT `notifica_ibfk_1` FOREIGN KEY (`utenteEmail`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifica_ibfk_2` FOREIGN KEY (`tipologia`) REFERENCES `tipo_notifica` (`titolo`);

--
-- Limiti per la tabella `ordine`
--
ALTER TABLE `ordine`
  ADD CONSTRAINT `ordine_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE SET NULL,
  ADD CONSTRAINT `ordine_ibfk_2` FOREIGN KEY (`stato`) REFERENCES `stato_ordine` (`titolo`);

--
-- Limiti per la tabella `prodotti_ordine`
--
ALTER TABLE `prodotti_ordine`
  ADD CONSTRAINT `prodotti_ordine_ibfk_1` FOREIGN KEY (`ordine`) REFERENCES `ordine` (`codice`) ON DELETE CASCADE,
  ADD CONSTRAINT `prodotti_ordine_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  ADD CONSTRAINT `prodotto_ibfk_1` FOREIGN KEY (`marca`) REFERENCES `marca` (`codice`),
  ADD CONSTRAINT `prodotto_ibfk_2` FOREIGN KEY (`tipologia`) REFERENCES `tipologia_prodotto` (`nome`);

--
-- Limiti per la tabella `recensione`
--
ALTER TABLE `recensione`
  ADD CONSTRAINT `recensione_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE,
  ADD CONSTRAINT `recensione_ibfk_2` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE;

--
-- Limiti per la tabella `specifica_prodotto`
--
ALTER TABLE `specifica_prodotto`
  ADD CONSTRAINT `specifica_prodotto_ibfk_1` FOREIGN KEY (`prodotto`) REFERENCES `prodotto` (`codice`) ON DELETE CASCADE,
  ADD CONSTRAINT `specifica_prodotto_ibfk_2` FOREIGN KEY (`caratteristica`) REFERENCES `caratteristica_prodotto` (`codice`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
