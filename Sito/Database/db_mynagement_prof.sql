-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 12, 2022 alle 10:19
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mynagement`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `aziende`
--

CREATE TABLE `MyNagamet_aziende` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `RagioneSociale` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Indirizzo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `contratti`
--

CREATE TABLE `MyNagamet_contratti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Salario` int(11) NOT NULL,
  `Durata` tinyint(1) NOT NULL,
  `DataInizio` date NOT NULL,
  `DataFine` date NOT NULL,
  `CodDipendente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendenti`
--

CREATE TABLE `MyNagamet_dipendenti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `CodiceFiscale` char(16) NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `DataNascita` date NOT NULL,
  `Indirizzo` varchar(50) NOT NULL,
  `TitoloStudio` varchar(20) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_acquistati`
--

CREATE TABLE `MyNagamet_prodotti_acquistati` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Produttore` varchar(50) NOT NULL,
  `DataAcquisto` date NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_da_vendere`
--

CREATE TABLE `MyNagamet_prodotti_da_vendere` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Produttore` varchar(50) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_venduti`
--

CREATE TABLE `MyNagamet_prodotti_venduti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Produttore` varchar(50) NOT NULL,
  `DataVendita` date NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

-- --------------------------------------------------------

--
-- Struttura della tabella `titolari`
--

CREATE TABLE `MyNagamet_titolari` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aziende`
--
ALTER TABLE `MyNagamet_aziende`
  ADD PRIMARY KEY (`Cod`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Telefono` (`Telefono`),
  ADD UNIQUE KEY `Indirizzo` (`Indirizzo`);

--
-- Indici per le tabelle `contratti`
--
ALTER TABLE `MyNagamet_contratti`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Riguarda` (`CodDipendente`);

--
-- Indici per le tabelle `dipendenti`
--
ALTER TABLE `MyNagamet_dipendenti`
  ADD PRIMARY KEY (`Cod`),
  ADD UNIQUE KEY `CodiceFiscale` (`CodiceFiscale`),
  ADD UNIQUE KEY `Telefono` (`Telefono`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Indirizzo` (`Indirizzo`),
  ADD UNIQUE KEY `CodiceFiscale_2` (`CodiceFiscale`,`Nome`,`Cognome`),
  ADD KEY `Lavora` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_acquistati`
--
ALTER TABLE `MyNagamet_prodotti_acquistati`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Acquista` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_da_vendere`
--
ALTER TABLE `MyNagamet_prodotti_da_vendere`
  ADD KEY `DeveVendere` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_venduti`
--
ALTER TABLE `MyNagamet_prodotti_venduti`
  ADD KEY `Vende` (`CodAzienda`);

--
-- Indici per le tabelle `titolari`
--
ALTER TABLE `MyNagamet_titolari`
  ADD PRIMARY KEY (`Cod`),
  ADD UNIQUE KEY `Telefono` (`Telefono`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Gestisce` (`CodAzienda`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `aziende`
--
ALTER TABLE `MyNagamet_aziende`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `contratti`
--
ALTER TABLE `MyNagamet_contratti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `dipendenti`
--
ALTER TABLE `MyNagamet_dipendenti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `prodotti_acquistati`
--
ALTER TABLE `MyNagamet_prodotti_acquistati`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `titolari`
--
ALTER TABLE `MyNagamet_titolari`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `contratti`
--
ALTER TABLE `MyNagamet_contratti`
  ADD CONSTRAINT `Riguarda` FOREIGN KEY (`CodDipendente`) REFERENCES `MyNagamet_dipendenti` (`Cod`);

--
-- Limiti per la tabella `dipendenti`
--
ALTER TABLE `MyNagamet_dipendenti`
  ADD CONSTRAINT `Lavora` FOREIGN KEY (`CodAzienda`) REFERENCES `MyNagamet_aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_acquistati`
--
ALTER TABLE `MyNagamet_prodotti_acquistati`
  ADD CONSTRAINT `Acquista` FOREIGN KEY (`CodAzienda`) REFERENCES `MyNagamet_aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_da_vendere`
--
ALTER TABLE `MyNagamet_prodotti_da_vendere`
  ADD CONSTRAINT `DeveVendere` FOREIGN KEY (`CodAzienda`) REFERENCES `MyNagamet_aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_venduti`
--
ALTER TABLE `MyNagamet_prodotti_venduti`
  ADD CONSTRAINT `Vende` FOREIGN KEY (`CodAzienda`) REFERENCES `MyNagamet_aziende` (`Cod`);

--
-- Limiti per la tabella `titolari`
--
ALTER TABLE `MyNagamet_titolari`
  ADD CONSTRAINT `Gestisce` FOREIGN KEY (`CodAzienda`) REFERENCES `MyNagamet_aziende` (`Cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
