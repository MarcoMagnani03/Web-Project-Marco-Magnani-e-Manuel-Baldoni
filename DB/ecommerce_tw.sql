-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 14, 2025 alle 18:41
-- Versione del server: 10.4.32-MariaDB
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
(19, 'Capacità', NULL, 'Hard Disk'),
(20, 'Velocità lettura (gb/s)', NULL, 'Hard Disk'),
(21, 'Velocità scrittura (gb/s)', NULL, 'Hard Disk'),
(30, 'Memoria (Gb)', NULL, 'RAM'),
(31, 'Velocità (MHz)', NULL, 'RAM'),
(32, 'DDR', NULL, 'RAM'),
(33, 'Frequenza (GHz)', NULL, 'GPU'),
(34, 'Memoria (Gb)', NULL, 'GPU'),
(35, 'N. Ventole', NULL, 'GPU'),
(36, 'PCI Express', NULL, 'GPU'),
(37, 'Socket', NULL, 'CPU'),
(38, 'N. Core/Thread', NULL, 'CPU'),
(39, 'Velocità (GHz)', NULL, 'CPU'),
(41, 'Potenza (W)', NULL, 'Alimentatore'),
(43, 'Diagonale', NULL, 'Schermo'),
(44, 'Risoluzione', NULL, 'Schermo'),
(45, 'Frequenza aggiornamento (Hz)', NULL, 'Schermo');

-- --------------------------------------------------------

--
-- Struttura della tabella `carrello`
--

CREATE TABLE `carrello` (
  `utente` varchar(255) NOT NULL,
  `prodotto` varchar(255) NOT NULL,
  `quantita` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `carrello`
--

INSERT INTO `carrello` (`utente`, `prodotto`, `quantita`) VALUES
('manuel.baldoni@studio.unibo.it', '058d0739-cc58-4405-b172-affb547f848e', 1),
('manuel.baldoni@studio.unibo.it', '132e1bf8-c1cf-48e4-bbff-b135357dde1a', 1),
('manuel.baldoni@studio.unibo.it', '304aa3b3-e93b-45b5-9800-38f419e1f500', 2);

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
(24, 'ede05adf-a358-48ef-893b-304e0c7e72d1', '81DRltGu6BL._AC_SL1500_.jpg'),
(25, 'ede05adf-a358-48ef-893b-304e0c7e72d1', '81X55mgX1SL._AC_SL1500_.jpg'),
(26, 'ede05adf-a358-48ef-893b-304e0c7e72d1', '51JJ47pcvBL._AC_.jpg'),
(27, 'ede05adf-a358-48ef-893b-304e0c7e72d1', '61q0rsE3ezL._AC_SL1500_.jpg'),
(28, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', '81fLtWboBxL._AC_SL1500_.jpg'),
(29, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', '618o4bQWVYL._AC_SL1500_.jpg'),
(30, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', '61Y3WbtG-xL._AC_SL1500_.jpg'),
(31, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', '71wBoiM+xXL._AC_SL1500_.jpg'),
(32, '27a40d8e-b713-45ca-a1c3-588684d85d3e', '51S-BhrxT6L._AC_SL1280_.jpg'),
(33, '4a75570a-b704-4e90-af66-8615b6f91324', '61a+cNGLTvL._AC_SL1500_.jpg'),
(34, 'a7739b13-63f4-4dcc-a565-29f7425d9b80', '61f5TtVr8JL._AC_SL1500_.jpg'),
(35, 'a7739b13-63f4-4dcc-a565-29f7425d9b80', '51tdc1Qr97L._AC_SL1500_.jpg'),
(36, 'a7739b13-63f4-4dcc-a565-29f7425d9b80', '71u7i+TcfPL._AC_SL1500_.jpg'),
(37, 'a2a66787-b22b-498f-94de-cfd9bc6cc84e', '71IONUzyQ9L._AC_SL1500_.jpg'),
(38, 'a2a66787-b22b-498f-94de-cfd9bc6cc84e', '616NQAwpDqL._AC_SL1500_.jpg'),
(39, '132e1bf8-c1cf-48e4-bbff-b135357dde1a', '81TYqhBo3qL._AC_SL1500_.jpg'),
(40, '058d0739-cc58-4405-b172-affb547f848e', '61KvvsJnd3L._AC_SL1500_.jpg'),
(41, '058d0739-cc58-4405-b172-affb547f848e', '510zUuytB+L._AC_SL1500_.jpg'),
(42, '304aa3b3-e93b-45b5-9800-38f419e1f500', '61Jt6bRTM8L._AC_SL1500_.jpg'),
(43, '304aa3b3-e93b-45b5-9800-38f419e1f500', '717RCxFOpML._AC_SL1500_.jpg'),
(44, 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7', '71sYCMV7mgL._AC_SL1500_.jpg'),
(45, 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7', '71hYOIgYe-L._AC_SL1500_.jpg');

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
(1, 'Intel'),
(2, 'AMD'),
(3, 'NVIDIA'),
(4, 'Corsair'),
(5, 'Seagate'),
(11, 'be quiet'),
(12, 'Gawfolk');

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
(31, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: RAM', 0, '2025-01-12 16:33:46', 'admin@takeit.it', 'informazione'),
(32, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Hard Disk', 0, '2025-01-12 16:34:24', 'admin@takeit.it', 'informazione'),
(33, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: CPU', 0, '2025-01-12 16:34:34', 'admin@takeit.it', 'informazione'),
(34, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: RAM', 0, '2025-01-12 16:34:47', 'admin@takeit.it', 'informazione'),
(35, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: GPU', 0, '2025-01-12 16:35:24', 'admin@takeit.it', 'informazione'),
(36, 'Creata nuova tipologia prodotto', 'Creata tipologia prodotto con nome: RAM', 0, '2025-01-12 16:37:02', 'admin@takeit.it', 'informazione'),
(37, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: RAM', 0, '2025-01-12 16:37:32', 'admin@takeit.it', 'informazione'),
(38, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: GPU', 0, '2025-01-12 16:37:39', 'admin@takeit.it', 'informazione'),
(39, 'Modificato prodotto', 'Modificato il prodotto di codice b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 17:03:08', 'admin@takeit.it', 'informazione'),
(40, 'Modificato prodotto', 'Modificato il prodotto di codice b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 17:03:29', 'admin@takeit.it', 'informazione'),
(41, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:06:54', 'admin@takeit.it', 'informazione'),
(42, 'Modificato prodotto', 'Modificato il prodotto di codice b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 17:07:01', 'admin@takeit.it', 'informazione'),
(43, 'Modificato prodotto', 'Modificato il prodotto di codice b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 17:07:37', 'admin@takeit.it', 'informazione'),
(44, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:07:43', 'admin@takeit.it', 'informazione'),
(45, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:07:59', 'admin@takeit.it', 'informazione'),
(46, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:08:13', 'admin@takeit.it', 'informazione'),
(47, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:08:54', 'admin@takeit.it', 'informazione'),
(48, 'Modificato prodotto', 'Modificato il prodotto di codice b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 17:09:01', 'admin@takeit.it', 'informazione'),
(49, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: CPU', 0, '2025-01-12 17:13:40', 'admin@takeit.it', 'informazione'),
(50, 'Modificato prodotto', 'Modificato il prodotto di codice 4a75570a-b704-4e90-af66-8615b6f91324', 0, '2025-01-12 17:15:57', 'admin@takeit.it', 'informazione'),
(51, 'Modificato prodotto', 'Modificato il prodotto di codice 27a40d8e-b713-45ca-a1c3-588684d85d3e', 0, '2025-01-12 17:16:29', 'admin@takeit.it', 'informazione'),
(52, 'Modificato prodotto', 'Modificato il prodotto di codice ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 17:22:56', 'admin@takeit.it', 'informazione'),
(53, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Hard Disk', 0, '2025-01-12 17:27:24', 'admin@takeit.it', 'informazione'),
(54, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Alimentatore', 0, '2025-01-12 17:38:14', 'admin@takeit.it', 'informazione'),
(55, 'Creata nuova tipologia prodotto', 'Creata tipologia prodotto con nome: Test', 0, '2025-01-12 17:38:28', 'admin@takeit.it', 'informazione'),
(56, 'Eliminazione tipologia prodotto', 'Eliminata tipologia con nome: Test', 0, '2025-01-12 17:38:31', 'admin@takeit.it', 'informazione'),
(57, 'Creata nuova marca', 'Creata una nuova marca con titolo: be quiet', 0, '2025-01-12 17:40:56', 'admin@takeit.it', 'informazione'),
(58, 'Creata nuova marca', 'Creata una nuova marca con titolo: Gawfolk', 0, '2025-01-12 17:42:34', 'admin@takeit.it', 'informazione'),
(59, 'Creata nuova tipologia prodotto', 'Creata tipologia prodotto con nome: Schermo', 0, '2025-01-12 17:43:33', 'admin@takeit.it', 'informazione'),
(60, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 4a75570a-b704-4e90-af66-8615b6f91324 al carrello', 0, '2025-01-12 17:55:21', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(61, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto a2a66787-b22b-498f-94de-cfd9bc6cc84e al carrello', 0, '2025-01-12 17:55:32', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(62, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: Lexar ARES RGB, Codice: a2a66787-b22b-498f-94de-cfd9bc6cc84e\n', 0, '2025-01-12 17:56:01', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(63, 'Realizzato un ordine', 'L\'utente francesco.pazzaglia@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: Lexar ARES RGB, Codice: a2a66787-b22b-498f-94de-cfd9bc6cc84e\n', 0, '2025-01-12 17:56:01', 'admin@takeit.it', 'informazione'),
(64, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 27a40d8e-b713-45ca-a1c3-588684d85d3e', 0, '2025-01-12 17:56:26', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(65, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: a2a66787-b22b-498f-94de-cfd9bc6cc84e', 0, '2025-01-12 17:57:06', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(66, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto b075dbd9-bb73-4799-a46f-1397ca6a3db4 al carrello', 0, '2025-01-12 17:58:14', 'luca.casadei@studio.unibo.it', 'informazione'),
(67, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto a7b2f7f5-0fe6-4551-9db4-df76758d38d7 al carrello', 0, '2025-01-12 17:58:28', 'luca.casadei@studio.unibo.it', 'informazione'),
(68, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 132e1bf8-c1cf-48e4-bbff-b135357dde1a al carrello', 0, '2025-01-12 17:58:32', 'luca.casadei@studio.unibo.it', 'informazione'),
(69, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Gawfolk Monitor, Codice: a7b2f7f5-0fe6-4551-9db4-df76758d38d7\nNome: RTX 3050 WINDFORCE OC, Codice: b075dbd9-bb73-4799-a46f-1397ca6a3db4\n', 0, '2025-01-12 18:02:11', 'luca.casadei@studio.unibo.it', 'informazione'),
(70, 'Realizzato un ordine', 'L\'utente luca.casadei@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Gawfolk Monitor, Codice: a7b2f7f5-0fe6-4551-9db4-df76758d38d7\nNome: RTX 3050 WINDFORCE OC, Codice: b075dbd9-bb73-4799-a46f-1397ca6a3db4\n', 0, '2025-01-12 18:02:11', 'admin@takeit.it', 'informazione'),
(71, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 132e1bf8-c1cf-48e4-bbff-b135357dde1a', 0, '2025-01-12 18:02:48', 'luca.casadei@studio.unibo.it', 'informazione'),
(72, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 0, '2025-01-12 18:03:13', 'luca.casadei@studio.unibo.it', 'informazione'),
(73, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 304aa3b3-e93b-45b5-9800-38f419e1f500 al carrello', 0, '2025-01-12 18:03:35', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(74, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 058d0739-cc58-4405-b172-affb547f848e al carrello', 0, '2025-01-12 18:03:42', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(75, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto b075dbd9-bb73-4799-a46f-1397ca6a3db4 al carrello', 0, '2025-01-12 18:03:46', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(76, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 132e1bf8-c1cf-48e4-bbff-b135357dde1a al carrello', 0, '2025-01-12 18:03:50', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(77, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Processore AMD Ryzen 9 9900X, Codice: 058d0739-cc58-4405-b172-affb547f848e\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Pure Power 12 M, Codice: 304aa3b3-e93b-45b5-9800-38f419e1f500\nNome: RTX 3050 WINDFORCE OC, Codice: b075dbd9-bb73-4799-a46f-1397ca6a3db4\n', 0, '2025-01-12 18:03:55', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(78, 'Realizzato un ordine', 'L\'utente manuel.baldoni@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Processore AMD Ryzen 9 9900X, Codice: 058d0739-cc58-4405-b172-affb547f848e\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Pure Power 12 M, Codice: 304aa3b3-e93b-45b5-9800-38f419e1f500\nNome: RTX 3050 WINDFORCE OC, Codice: b075dbd9-bb73-4799-a46f-1397ca6a3db4\n', 0, '2025-01-12 18:03:55', 'admin@takeit.it', 'informazione'),
(79, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 4a75570a-b704-4e90-af66-8615b6f91324 al carrello', 0, '2025-01-12 18:04:00', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(80, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto ede05adf-a358-48ef-893b-304e0c7e72d1 al carrello', 0, '2025-01-12 18:04:02', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(81, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC, Codice: ede05adf-a358-48ef-893b-304e0c7e72d1\n', 0, '2025-01-12 18:04:06', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(82, 'Realizzato un ordine', 'L\'utente manuel.baldoni@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC, Codice: ede05adf-a358-48ef-893b-304e0c7e72d1\n', 0, '2025-01-12 18:04:06', 'admin@takeit.it', 'informazione'),
(83, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 058d0739-cc58-4405-b172-affb547f848e', 0, '2025-01-12 18:04:38', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(84, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 304aa3b3-e93b-45b5-9800-38f419e1f500', 0, '2025-01-12 18:04:49', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(85, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: b075dbd9-bb73-4799-a46f-1397ca6a3db4', 0, '2025-01-12 18:05:02', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(86, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 4a75570a-b704-4e90-af66-8615b6f91324', 0, '2025-01-12 18:05:22', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(87, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 27a40d8e-b713-45ca-a1c3-588684d85d3e al carrello', 0, '2025-01-12 18:05:28', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(88, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\n', 0, '2025-01-12 18:05:31', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(89, 'Realizzato un ordine', 'L\'utente manuel.baldoni@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\n', 0, '2025-01-12 18:05:31', 'admin@takeit.it', 'informazione'),
(90, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 27a40d8e-b713-45ca-a1c3-588684d85d3e', 0, '2025-01-12 18:05:50', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(91, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 304aa3b3-e93b-45b5-9800-38f419e1f500 al carrello', 0, '2025-01-12 18:07:27', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(92, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Pure Power 12 M, Codice: 304aa3b3-e93b-45b5-9800-38f419e1f500\n', 0, '2025-01-12 18:07:30', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(93, 'Realizzato un ordine', 'L\'utente francesco.pazzaglia@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Pure Power 12 M, Codice: 304aa3b3-e93b-45b5-9800-38f419e1f500\n', 0, '2025-01-12 18:07:30', 'admin@takeit.it', 'informazione'),
(94, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 304aa3b3-e93b-45b5-9800-38f419e1f500', 0, '2025-01-12 18:07:38', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(95, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto ede05adf-a358-48ef-893b-304e0c7e72d1 al carrello', 0, '2025-01-12 18:07:47', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(96, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 27a40d8e-b713-45ca-a1c3-588684d85d3e al carrello', 0, '2025-01-12 18:07:51', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(97, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\nNome: MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC, Codice: ede05adf-a358-48ef-893b-304e0c7e72d1\n', 0, '2025-01-12 18:07:55', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(98, 'Realizzato un ordine', 'L\'utente francesco.pazzaglia@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\nNome: MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC, Codice: ede05adf-a358-48ef-893b-304e0c7e72d1\n', 0, '2025-01-12 18:07:55', 'admin@takeit.it', 'informazione'),
(99, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 27a40d8e-b713-45ca-a1c3-588684d85d3e', 0, '2025-01-12 18:08:13', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(100, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: ede05adf-a358-48ef-893b-304e0c7e72d1', 0, '2025-01-12 18:08:33', 'francesco.pazzaglia@studio.unibo.it', 'informazione'),
(101, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 058d0739-cc58-4405-b172-affb547f848e al carrello', 0, '2025-01-12 18:08:56', 'marco.magnani30@studio.unibo.it', 'informazione'),
(102, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 27a40d8e-b713-45ca-a1c3-588684d85d3e al carrello', 0, '2025-01-12 18:08:58', 'marco.magnani30@studio.unibo.it', 'informazione'),
(103, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto a7b2f7f5-0fe6-4551-9db4-df76758d38d7 al carrello', 0, '2025-01-12 18:09:00', 'marco.magnani30@studio.unibo.it', 'informazione'),
(104, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Processore AMD Ryzen 9 9900X, Codice: 058d0739-cc58-4405-b172-affb547f848e\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\nNome: Gawfolk Monitor, Codice: a7b2f7f5-0fe6-4551-9db4-df76758d38d7\n', 0, '2025-01-12 18:09:04', 'marco.magnani30@studio.unibo.it', 'informazione'),
(105, 'Realizzato un ordine', 'L\'utente marco.magnani30@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Processore AMD Ryzen 9 9900X, Codice: 058d0739-cc58-4405-b172-affb547f848e\nNome: Intel Core i7-12700KF, Codice: 27a40d8e-b713-45ca-a1c3-588684d85d3e\nNome: Gawfolk Monitor, Codice: a7b2f7f5-0fe6-4551-9db4-df76758d38d7\n', 0, '2025-01-12 18:09:04', 'admin@takeit.it', 'informazione'),
(106, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 058d0739-cc58-4405-b172-affb547f848e', 0, '2025-01-12 18:09:22', 'marco.magnani30@studio.unibo.it', 'informazione'),
(107, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: 27a40d8e-b713-45ca-a1c3-588684d85d3e', 0, '2025-01-12 18:09:44', 'marco.magnani30@studio.unibo.it', 'informazione'),
(108, 'Creata nuova recensione', 'Creata nuova recensione per il prodotto: a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 0, '2025-01-12 18:10:03', 'marco.magnani30@studio.unibo.it', 'informazione'),
(109, 'Ordine modificato', 'Modificato l\'ordine n° 12', 0, '2025-01-12 18:16:39', 'admin@takeit.it', 'informazione'),
(110, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 132e1bf8-c1cf-48e4-bbff-b135357dde1a al carrello', 0, '2025-01-14 08:58:27', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(111, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 4a75570a-b704-4e90-af66-8615b6f91324 al carrello', 0, '2025-01-14 08:58:27', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(112, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto a2a66787-b22b-498f-94de-cfd9bc6cc84e al carrello', 0, '2025-01-14 08:58:29', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(113, 'Realizzato ordine', 'Hai realizzato un ordine con i seguenti prodotti:\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: Lexar ARES RGB, Codice: a2a66787-b22b-498f-94de-cfd9bc6cc84e\n', 0, '2025-01-14 08:58:51', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(114, 'Realizzato un ordine', 'L\'utente manuel.baldoni@studio.unibo.it ha realizzato un ordine con i seguenti prodotti:\nNome: Seagate IronWolf, Codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a\nNome: Intel Core i9-14900K, Codice: 4a75570a-b704-4e90-af66-8615b6f91324\nNome: Lexar ARES RGB, Codice: a2a66787-b22b-498f-94de-cfd9bc6cc84e\n', 0, '2025-01-14 08:58:51', 'admin@takeit.it', 'informazione'),
(115, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 058d0739-cc58-4405-b172-affb547f848e al carrello', 0, '2025-01-14 09:33:21', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(116, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 132e1bf8-c1cf-48e4-bbff-b135357dde1a al carrello', 0, '2025-01-14 09:33:21', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(117, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 304aa3b3-e93b-45b5-9800-38f419e1f500 al carrello', 0, '2025-01-14 09:33:22', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(118, 'Eliminato un prodotto dal carrello', 'Eliminato dal carrello il prodotto di codice: 132e1bf8-c1cf-48e4-bbff-b135357dde1a', 0, '2025-01-14 09:38:58', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(119, 'Eliminato un prodotto dal carrello', 'Eliminato dal carrello il prodotto di codice: 058d0739-cc58-4405-b172-affb547f848e', 0, '2025-01-14 09:39:06', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(120, 'Eliminato un prodotto dal carrello', 'Eliminato dal carrello il prodotto di codice: 058d0739-cc58-4405-b172-affb547f848e', 0, '2025-01-14 09:39:09', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(121, 'Eliminato un prodotto dal carrello', 'Eliminato dal carrello il prodotto di codice: 058d0739-cc58-4405-b172-affb547f848e', 0, '2025-01-14 09:39:10', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(122, 'Ordine modificato', 'Modificato l\'ordine n° 12, il nuovo stato è in consegna', 0, '2025-01-14 09:41:31', 'admin@takeit.it', 'informazione'),
(123, 'Ordine modificato', 'Modificato l\'ordine n° 12, il nuovo stato è in consegna', 0, '2025-01-14 09:41:31', 'luca.casadei@studio.unibo.it', 'informazione'),
(124, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 304aa3b3-e93b-45b5-9800-38f419e1f500 al carrello', 0, '2025-01-14 11:11:45', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(125, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 132e1bf8-c1cf-48e4-bbff-b135357dde1a al carrello', 0, '2025-01-14 11:11:46', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(126, 'Aggiunto un prodotto al carrello', 'Aggiunto il prodotto 058d0739-cc58-4405-b172-affb547f848e al carrello', 0, '2025-01-14 11:11:46', 'manuel.baldoni@studio.unibo.it', 'informazione'),
(127, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Hard Disk', 0, '2025-01-14 18:16:52', 'admin@takeit.it', 'informazione'),
(128, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Hard Disk', 0, '2025-01-14 18:17:52', 'admin@takeit.it', 'informazione'),
(129, 'Modificata tipologia prodotto', 'Modificata tipologia prodotto con nome: Hard Disk', 0, '2025-01-14 18:17:56', 'admin@takeit.it', 'informazione');

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
(11, '2025-01-12', '2025-01-17 17:56:01', 'francesco.pazzaglia@studio.unibo.it', 'in elaborazione'),
(12, '2025-01-12', '2025-01-17 18:02:00', 'luca.casadei@studio.unibo.it', 'in consegna'),
(13, '2025-01-12', '2025-01-17 18:03:55', 'manuel.baldoni@studio.unibo.it', 'in elaborazione'),
(14, '2025-01-12', '2025-01-17 18:04:06', 'manuel.baldoni@studio.unibo.it', 'in elaborazione'),
(15, '2025-01-12', '2025-01-17 18:05:31', 'manuel.baldoni@studio.unibo.it', 'in elaborazione'),
(16, '2025-01-12', '2025-01-17 18:07:30', 'francesco.pazzaglia@studio.unibo.it', 'in elaborazione'),
(17, '2025-01-12', '2025-01-17 18:07:55', 'francesco.pazzaglia@studio.unibo.it', 'in elaborazione'),
(18, '2025-01-12', '2025-01-17 18:09:04', 'marco.magnani30@studio.unibo.it', 'in elaborazione'),
(19, '2025-01-14', '2025-01-19 08:58:51', 'manuel.baldoni@studio.unibo.it', 'in elaborazione');

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
(11, '4a75570a-b704-4e90-af66-8615b6f91324', 1),
(11, 'a2a66787-b22b-498f-94de-cfd9bc6cc84e', 1),
(12, '132e1bf8-c1cf-48e4-bbff-b135357dde1a', 1),
(12, 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 1),
(12, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', 1),
(13, '058d0739-cc58-4405-b172-affb547f848e', 1),
(13, '132e1bf8-c1cf-48e4-bbff-b135357dde1a', 1),
(13, '304aa3b3-e93b-45b5-9800-38f419e1f500', 1),
(13, 'b075dbd9-bb73-4799-a46f-1397ca6a3db4', 1),
(14, '4a75570a-b704-4e90-af66-8615b6f91324', 1),
(14, 'ede05adf-a358-48ef-893b-304e0c7e72d1', 1),
(15, '27a40d8e-b713-45ca-a1c3-588684d85d3e', 1),
(16, '304aa3b3-e93b-45b5-9800-38f419e1f500', 1),
(17, '27a40d8e-b713-45ca-a1c3-588684d85d3e', 1),
(17, 'ede05adf-a358-48ef-893b-304e0c7e72d1', 1),
(18, '058d0739-cc58-4405-b172-affb547f848e', 1),
(18, '27a40d8e-b713-45ca-a1c3-588684d85d3e', 1),
(18, 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 1),
(19, '132e1bf8-c1cf-48e4-bbff-b135357dde1a', 1),
(19, '4a75570a-b704-4e90-af66-8615b6f91324', 1),
(19, 'a2a66787-b22b-498f-94de-cfd9bc6cc84e', 1);

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
('058d0739-cc58-4405-b172-affb547f848e', 'Processore AMD Ryzen 9 9900X', 'Il processore AMD Ryzen 9 9900X beneficia delle ottimizzazioni apportati dall\'architettura AMD Zen 5, realizzata in 4 nm. I suoi 12 core e 24 thread, le maggiori prestazioni energetiche, le frequenze ottime, la cache L3 da 76 MB e l\'involucro termico da 120 W faranno la gioia dei giocatori e dei creatori più esigenti.', 480.00, '2025-01-12', 'disponibile', 18, 'CPU', 2),
('132e1bf8-c1cf-48e4-bbff-b135357dde1a', 'Seagate IronWolf', 'Sistemi NAS domestici, SOHO e per aziende di piccole e medie dimensioni', 137.00, '2025-01-12', 'disponibile', 6, 'Hard Disk', 5),
('27a40d8e-b713-45ca-a1c3-588684d85d3e', 'Intel Core i7-12700KF', 'La nuova architettura ibrida delle prestazione di Intel integra due famiglie di core in una singola CPU, consentendo un\'esperienza di gioco fluida e piacevole.', 250.99, '2025-01-12', 'disponibile', 7, 'CPU', 1),
('304aa3b3-e93b-45b5-9800-38f419e1f500', 'Pure Power 12 M', 'Fonte ATX 750W BE QUIET Pure Power 12 M', 119.99, '2025-01-12', 'disponibile', 5, 'Alimentatore', 11),
('4a75570a-b704-4e90-af66-8615b6f91324', 'Intel Core i9-14900K', 'L\'architettura ibrida e la tecnologia più avanzata del settore ti permettono di andare oltre nel gioco e nella creazione di contenuti. Dal progresso nel gioco al miglioramento nel mondo reale, raggiungi il tuo massimo potenziale con Intel.', 483.36, '2025-01-12', 'disponibile', 2, 'CPU', 1),
('a2a66787-b22b-498f-94de-cfd9bc6cc84e', 'Lexar ARES RGB', 'La memora per desktop Lexar ARES RGB offre agli appassionati di videogiochi e i PC altissime prestazioni con la DDR5 di nuova generazione', 137.99, '2025-01-12', 'disponibile', 3, 'RAM', 4),
('a7739b13-63f4-4dcc-a565-29f7425d9b80', 'AMD Ryzen™ 5 7600X', 'AMD Ryzen™ 5 7600X Processeur, 6 Cœurs/12 Threads Débridés, Architecture Zen 4, 38MB L3 Cache, 105W TDP, Jusqu\'à 5,3 GHz Fréquence Boost, Socket AMD 5, DDR5 & PCIe 5.0', 216.90, '2025-01-12', 'disponibile', 15, 'CPU', 2),
('a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 'Gawfolk Monitor', 'Questo monitor è leader nel campo visivo grazie all\'eccellente qualità dei colori e alle transizioni sottili dovute all\'elevata profondità di colore.', 179.99, '2025-01-12', 'disponibile', 6, 'Schermo', 12),
('b075dbd9-bb73-4799-a46f-1397ca6a3db4', 'RTX 3050 WINDFORCE OC', 'Gigabyte GeForce RTX 3050 WINDFORCE OC 6G. Processore grafico / fornitore: NVIDIA, Processore grafico: GeForce RTX 3050, Frequenza del processore: 1477 MHz. Memoria Grafica Dedicata: 6 GB, Tipo memoria adattatore grafico: GDDR6, Ampiezza dati: 96 bit, Velocità memoria: 14000 MHz. Risoluzione massima: 7680 x 4320 Pixel. Versione DirectX: 12 Ultimate, Versione OpenGL: 4.6. Tipo interfaccia: PCI Express 4.0. Tipo di raffreddamento: Attivo, Numero di ventole: 2 ventol', 242.20, '2025-01-12', 'disponibile', 18, 'GPU', 3),
('ede05adf-a358-48ef-893b-304e0c7e72d1', 'MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC', 'MSI GeForce RTX 4060 VENTUS 2X BLACK 8G OC è la variante overcloccata della GeForce RTX 4060 VENTUS 2X 8G.\r\n\r\nLe schede MSI GeForce RTX 4080 VENTUS 2X sono dotate della tecnologia TORX Fan 4.0 e di una piastra di base in rame nichelato. Ciò garantisce prestazioni elevate durante il game o la creazione di contenuti.\r\n\r\nLe schede grafiche MSI della serie VENTUS sono caratterizzate da un design sobrio e minimalista, con soluzioni di raffreddamento efficienti e PCB resistenti per il massimo valore.', 322.39, '2025-01-12', 'disponibile', 18, 'GPU', 3);

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
(4, 4, 'Bello!', 'Bello, ma un po\' costoso\r\n', '2025-01-12', 'francesco.pazzaglia@studio.unibo.it', '27a40d8e-b713-45ca-a1c3-588684d85d3e'),
(5, 5, 'Super!', 'Super belle, ottimo rapporto qualità prezzo', '2025-01-12', 'francesco.pazzaglia@studio.unibo.it', 'a2a66787-b22b-498f-94de-cfd9bc6cc84e'),
(6, 2, 'Non ci siamo!', 'Non mi piace, lento. Non come pubblicizzato', '2025-01-12', 'luca.casadei@studio.unibo.it', '132e1bf8-c1cf-48e4-bbff-b135357dde1a'),
(7, 4, 'Bella risoluzione ma...', 'Ottima risoluzione, ma troppo pesante per la mia scrivania', '2025-01-12', 'luca.casadei@studio.unibo.it', 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7'),
(8, 1, 'Se potessi darei 0', 'Arrivato rotto, non posso neanche restituirlo! Ho comprato un altro processore', '2025-01-12', 'manuel.baldoni@studio.unibo.it', '058d0739-cc58-4405-b172-affb547f848e'),
(9, 5, 'Ottimo', 'come descritto', '2025-01-12', 'manuel.baldoni@studio.unibo.it', '304aa3b3-e93b-45b5-9800-38f419e1f500'),
(10, 4, 'Bello', 'bello', '2025-01-12', 'manuel.baldoni@studio.unibo.it', 'b075dbd9-bb73-4799-a46f-1397ca6a3db4'),
(11, 5, 'Super!', 'In sostituzione a quello vecchio va molto più veloce', '2025-01-12', 'manuel.baldoni@studio.unibo.it', '4a75570a-b704-4e90-af66-8615b6f91324'),
(12, 3, 'Non male', 'Però rapporto qualità prezzo molto meglio il modello nuovo', '2025-01-12', 'manuel.baldoni@studio.unibo.it', '27a40d8e-b713-45ca-a1c3-588684d85d3e'),
(13, 3, 'Not bad', 'Nice', '2025-01-12', 'francesco.pazzaglia@studio.unibo.it', '304aa3b3-e93b-45b5-9800-38f419e1f500'),
(14, 5, 'Però', 'Ne ho preso anche un\'altro', '2025-01-12', 'francesco.pazzaglia@studio.unibo.it', '27a40d8e-b713-45ca-a1c3-588684d85d3e'),
(15, 4, 'Buono', 'Come da descrizione, niente di più', '2025-01-12', 'francesco.pazzaglia@studio.unibo.it', 'ede05adf-a358-48ef-893b-304e0c7e72d1'),
(16, 5, 'A me piace', 'Arrivato tutto intero e super performante', '2025-01-12', 'marco.magnani30@studio.unibo.it', '058d0739-cc58-4405-b172-affb547f848e'),
(17, 5, 'Ottimo!', 'Ottimo rapporto qualità prezzo, nulla da dire', '2025-01-12', 'marco.magnani30@studio.unibo.it', '27a40d8e-b713-45ca-a1c3-588684d85d3e'),
(18, 3, 'Interessante ma normale', 'Niente di particolare, però troppo pesante', '2025-01-12', 'marco.magnani30@studio.unibo.it', 'a7b2f7f5-0fe6-4551-9db4-df76758d38d7');

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
('058d0739-cc58-4405-b172-affb547f848e', 37, 'Socket AM5'),
('058d0739-cc58-4405-b172-affb547f848e', 38, '12'),
('058d0739-cc58-4405-b172-affb547f848e', 39, '4.4 - 5.6'),
('132e1bf8-c1cf-48e4-bbff-b135357dde1a', 19, '4'),
('132e1bf8-c1cf-48e4-bbff-b135357dde1a', 20, '6'),
('132e1bf8-c1cf-48e4-bbff-b135357dde1a', 21, '6'),
('27a40d8e-b713-45ca-a1c3-588684d85d3e', 37, 'LGA 1700'),
('27a40d8e-b713-45ca-a1c3-588684d85d3e', 38, '12'),
('27a40d8e-b713-45ca-a1c3-588684d85d3e', 39, '2.7'),
('304aa3b3-e93b-45b5-9800-38f419e1f500', 41, '750'),
('4a75570a-b704-4e90-af66-8615b6f91324', 37, 'LGA 1700'),
('4a75570a-b704-4e90-af66-8615b6f91324', 38, '24'),
('4a75570a-b704-4e90-af66-8615b6f91324', 39, '2.2'),
('a2a66787-b22b-498f-94de-cfd9bc6cc84e', 30, '32'),
('a2a66787-b22b-498f-94de-cfd9bc6cc84e', 31, '6400'),
('a2a66787-b22b-498f-94de-cfd9bc6cc84e', 32, '5'),
('a7739b13-63f4-4dcc-a565-29f7425d9b80', 37, 'Socket AM5'),
('a7739b13-63f4-4dcc-a565-29f7425d9b80', 38, '12'),
('a7739b13-63f4-4dcc-a565-29f7425d9b80', 39, '4,7'),
('a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 43, '32 pollici'),
('a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 44, 'Full HD 1080P'),
('a7b2f7f5-0fe6-4551-9db4-df76758d38d7', 45, '75'),
('b075dbd9-bb73-4799-a46f-1397ca6a3db4', 33, '14'),
('b075dbd9-bb73-4799-a46f-1397ca6a3db4', 34, '6'),
('b075dbd9-bb73-4799-a46f-1397ca6a3db4', 35, '2'),
('b075dbd9-bb73-4799-a46f-1397ca6a3db4', 36, '4.0'),
('ede05adf-a358-48ef-893b-304e0c7e72d1', 33, '25'),
('ede05adf-a358-48ef-893b-304e0c7e72d1', 34, '8'),
('ede05adf-a358-48ef-893b-304e0c7e72d1', 35, '2'),
('ede05adf-a358-48ef-893b-304e0c7e72d1', 36, '4.0');

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
('annullato'),
('consegnato'),
('in consegna'),
('in elaborazione');

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
('Alimentatore', 'PSU per alimentare componenti hardware'),
('CPU', 'Processori per computer desktop e server'),
('GPU', 'Schede grafiche per gaming e calcolo professionale'),
('Hard Disk', 'Dispositivi di archiviazione tradizionali e SSD'),
('RAM', 'Memorie ad accesso casuale di diverse capacità e velocità'),
('Schermo', 'Monitor');

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
('francesco.pazzaglia@studio.unibo.it', '35063d19254b05981455c8bf8bb76671723de56c3bfbbea174f6646cb6f4ddc102be91ec8e062ca99bee549ab460aff4c2470e6540ad68f475c3f115237c4468', 'Francesco', 'Pazzaglia', '2003-01-21', 'cliente', '7504e9548c2b23abf12f06916203032b303617b01a4ace52ed0bff042149feded74ab6b60258ca90c469b17d1d3c8466583a8ce8870757b187360165f5b860f9', ''),
('luca.casadei@studio.unibo.it', 'b4f3a6d2a7398498c12fc80adb1299a83ef984d3398f99ad8c474b7ad4a92486945c0c19bbce514c7bd8ea7ac1c29f3f625570114d29b92874cc0768ddf2e42f', 'Luca', 'Casadei', '2003-06-18', 'cliente', '0594a4007f1ff3dc701947d476e81d722e5f445629c74f43fc6be49c9fbbcf87331f0d79cd1c9f98e34405e628063599779318952486b162bd055449abc7ade6', ''),
('manuel.baldoni@studio.unibo.it', '3a26ae9f52b0a345b7f20284f3a12a8386758f39e460e81d716ef1cb6e8904937a6f10405b8cc43f5cd6b591f0dd65773b1d29044f7024b553d7d1511d2e1ae6', 'Manuel', 'Baldoni', '2004-03-12', 'cliente', 'bfbf4bb1c92016cf35ce8265b03888ffa731726f8319158ca6224d06f3e23f9e0c83e5df4d8096f3da10fcaf9cf16b654453c18dcc33bf1c5a76950953569ef8', '3493473334'),
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
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `immagine_prodotto`
--
ALTER TABLE `immagine_prodotto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT per la tabella `marca`
--
ALTER TABLE `marca`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `notifica`
--
ALTER TABLE `notifica`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT per la tabella `ordine`
--
ALTER TABLE `ordine`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT per la tabella `recensione`
--
ALTER TABLE `recensione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
