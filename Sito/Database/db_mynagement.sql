-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 19, 2022 alle 11:42
-- Versione del server: 10.4.6-MariaDB
-- Versione PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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

CREATE TABLE `aziende` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `RagioneSociale` varchar(50) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Indirizzo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `aziende`
--

INSERT INTO `aziende` (`Cod`, `Nome`, `RagioneSociale`, `Email`, `Telefono`, `Indirizzo`) VALUES
(1, 'Trafilspec', 'Trafilspec ITS S.p.A', ' info@trafilspec.it', ' 031.33561', 'Via Cà Bianca, 2'),
(2, 'Telefonia e Sicurezza', 'Telefonia e Sicurezza S.r.l', 'commerciale@telefoniaesicurezz', '031.699991', 'Via Roma 109');

-- --------------------------------------------------------

--
-- Struttura della tabella `contratti`
--

CREATE TABLE `contratti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Salario` int(11) NOT NULL,
  `Durata` tinyint(1) NOT NULL,
  `DataInizio` date NOT NULL,
  `DataFine` date DEFAULT NULL,
  `CodDipendente` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `contratti`
--

INSERT INTO `contratti` (`Cod`, `Salario`, `Durata`, `DataInizio`, `DataFine`, `CodDipendente`) VALUES
(1, 1850, 8, '2019-04-10', '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendenti`
--

CREATE TABLE `dipendenti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `CodiceFiscale` char(16) NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `DataNascita` date NOT NULL,
  `Indirizzo` varchar(50) NOT NULL,
  `TitoloStudio` varchar(20) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `dipendenti`
--

INSERT INTO `dipendenti` (`Cod`, `CodiceFiscale`, `Nome`, `Cognome`, `Telefono`, `Email`, `DataNascita`, `Indirizzo`, `TitoloStudio`, `CodAzienda`) VALUES
(1, 'BRMLSS80A06D416J', 'ALESSIO', 'BRAMBILLA', '031562291', 'alessiobrambilla@gma', '1980-01-06', 'via abbadia lariana 3', 'Diploma ', 2),
(2, 'RSSSVT03P06D416F', 'SALVATORE', 'ROSSINI', '3290492948', 'rossinisalvatore@hotmail.com', '2003-09-06', 'via parma 28', 'Diploma ', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_acquistati`
--

CREATE TABLE `prodotti_acquistati` (
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

CREATE TABLE `prodotti_da_vendere` (
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

CREATE TABLE `prodotti_venduti` (
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

CREATE TABLE `titolari` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `Cognome` varchar(20) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `titolari`
--

INSERT INTO `titolari` (`Cod`, `Nome`, `Cognome`, `Telefono`, `Email`, `CodAzienda`) VALUES
(1, 'Marco', 'Rossi', '3334789855', 'marcorossi@gmail.com', 2),
(2, 'Davide', 'Gerosa', '6578665499', 'davidegerosa@gmail.c', 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aziende`
--
ALTER TABLE `aziende`
  ADD PRIMARY KEY (`Cod`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Telefono` (`Telefono`),
  ADD UNIQUE KEY `Indirizzo` (`Indirizzo`);

--
-- Indici per le tabelle `contratti`
--
ALTER TABLE `contratti`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Riguarda` (`CodDipendente`);

--
-- Indici per le tabelle `dipendenti`
--
ALTER TABLE `dipendenti`
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
ALTER TABLE `prodotti_acquistati`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Acquista` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_da_vendere`
--
ALTER TABLE `prodotti_da_vendere`
  ADD KEY `DeveVendere` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_venduti`
--
ALTER TABLE `prodotti_venduti`
  ADD KEY `Vende` (`CodAzienda`);

--
-- Indici per le tabelle `titolari`
--
ALTER TABLE `titolari`
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
ALTER TABLE `aziende`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `contratti`
--
ALTER TABLE `contratti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `prodotti_acquistati`
--
ALTER TABLE `prodotti_acquistati`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `titolari`
--
ALTER TABLE `titolari`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `contratti`
--
ALTER TABLE `contratti`
  ADD CONSTRAINT `Riguarda` FOREIGN KEY (`CodDipendente`) REFERENCES `dipendenti` (`Cod`);

--
-- Limiti per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  ADD CONSTRAINT `Lavora` FOREIGN KEY (`CodAzienda`) REFERENCES `aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_acquistati`
--
ALTER TABLE `prodotti_acquistati`
  ADD CONSTRAINT `Acquista` FOREIGN KEY (`CodAzienda`) REFERENCES `aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_da_vendere`
--
ALTER TABLE `prodotti_da_vendere`
  ADD CONSTRAINT `DeveVendere` FOREIGN KEY (`CodAzienda`) REFERENCES `aziende` (`Cod`);

--
-- Limiti per la tabella `prodotti_venduti`
--
ALTER TABLE `prodotti_venduti`
  ADD CONSTRAINT `Vende` FOREIGN KEY (`CodAzienda`) REFERENCES `aziende` (`Cod`);

--
-- Limiti per la tabella `titolari`
--
ALTER TABLE `titolari`
  ADD CONSTRAINT `Gestisce` FOREIGN KEY (`CodAzienda`) REFERENCES `aziende` (`Cod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
