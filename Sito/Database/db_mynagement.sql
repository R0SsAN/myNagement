-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 30, 2022 alle 13:39
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
(2, 'Telefonia e Sicurezza', 'Telefonia e Sicurezza S.r.l', 'commerciale@telefoniaesicurezz', '031.699991', 'Via Roma 109'),
(4, 'Rossini costruzioni', 'Rossini Costruzioni SNC', 'contatti@rossinicostruzioni.com', '0316474627', 'via rossi 2 ponte lambro CO italia'),
(6, 'Auger', 'Auger srl', 'contatti@auger.com', '0316574829', 'via stefano andreani 2 casletto'),
(7, 'Zio pizza', 'zio pizza srl', 'pizzazio@gmail.com', '0317583950', 'via andrei 10 mariano comense CO Italia'),
(8, 'sdfsdf', 'fsdfsdf', 'sdfsd', '23423', 'sdfsdf'),
(9, 'latteria locatelli', 'latteria locatelli snc', 'latteria.locatelli@gmail.com', '031681296', 'via mornerino 25, Canzo, CO'),
(10, 'dfgdfg', 'dfgdfg', 'dfgdfgdfg', '234234', 'dfgdfgd'),
(13, 'galaxyss', 'sdjkhsdjkfh', 'sdkjhsdfjkh@gmail.com', '2347892389', 'sdkjhsdjkfh');

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
(1, 1850, 8, '2019-04-10', '0000-00-00', 1),
(2, 5000, 1, '2022-03-23', '2022-08-19', 5),
(3, 2000, 1, '2022-03-04', '2022-11-10', 2),
(4, 1500, 1, '2021-08-11', '2022-01-08', 4),
(5, 3500, 1, '2013-03-19', '2027-08-13', 3);

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
(2, 'RSSSVT03P06D416F', 'SALVATORE', 'ROSSINI', '3290492948', 'rossinisalvatore@hotmail.com', '2003-09-06', 'via parma 28', 'Diploma ', 1),
(3, 'HFGR546238FHT73H', 'Franco', 'muciaccia', '7485858930', 'fabio@gmail.com', '1996-03-13', 'via frnchi 2 , lurago d\'erba, Italia', 'diploma', 2),
(4, 'HGJT7584JG730LK4', 'Albertro', 'Verdi', '3392047584', 'alberti@gmail.com', '1990-02-06', 'via verdi 3 , lurago d\'erba, Italia', 'diploma', 1),
(5, 'HGJ46AHZ57B8FNGK', 'Andrea', 'Rossi', '3395867102', 'rossi@gmail.com', '1995-03-25', 'via spasani 35, monguzzo CO Italia', 'laurea telecomunicaz', 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_acquistati`
--

CREATE TABLE `prodotti_acquistati` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Quantita` int(11) NOT NULL,
  `Produttore` varchar(50) NOT NULL,
  `DataAcquisto` date NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `prodotti_acquistati`
--

INSERT INTO `prodotti_acquistati` (`Cod`, `Seriale`, `Nome`, `Prezzo`, `Quantita`, `Produttore`, `DataAcquisto`, `CodAzienda`) VALUES
(6, 'HFGH5647', 'Matite', 2, 2, 'Fabilo', '2022-01-13', 6),
(7, 'HFGH5647', 'Matite', 2, 2, 'Fabilo', '2022-01-13', 1),
(8, 'JGK485839F', 'Calcestruzzo', 150, 50, 'Miniera rossi srl', '2022-03-23', 4),
(9, 'JGH347829', 'Sacchi cemento armato', 55, 10, 'Holcim spa', '2022-02-16', 4),
(10, 'GDFHJ234', 'Farina tipo 0 sacco 10kg', 10, 1, 'Barilla', '2022-03-13', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_da_vendere`
--

CREATE TABLE `prodotti_da_vendere` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Quantita` int(11) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `prodotti_da_vendere`
--

INSERT INTO `prodotti_da_vendere` (`Cod`, `Seriale`, `Nome`, `Prezzo`, `Quantita`, `CodAzienda`) VALUES
(1, 'HDJ47482387', 'Firewall', 200, 20, 2),
(2, 'DDJH348723', 'Router', 100, 10, 2),
(3, 'HDJ34', 'Pizza surgelata', 3, 1, 7),
(4, 'HFJ34743', 'Casa', 150000, 1, 4),
(5, 'HDJ34', 'Kebab', 3.5, 1, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotti_venduti`
--

CREATE TABLE `prodotti_venduti` (
  `Cod` int(10) UNSIGNED NOT NULL,
  `Seriale` varchar(50) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Prezzo` float NOT NULL,
  `Quantita` int(11) NOT NULL,
  `DataVendita` date NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `prodotti_venduti`
--

INSERT INTO `prodotti_venduti` (`Cod`, `Seriale`, `Nome`, `Prezzo`, `Quantita`, `DataVendita`, `CodAzienda`) VALUES
(1, 'HDJ47482387', 'Firewall', 200, 5, '2022-01-01', 2),
(2, 'DDJH348723', 'Router', 100, 2, '2022-01-15', 2),
(3, 'HDJ34', 'Pizza surgelata', 3, 1, '2022-01-22', 7),
(4, 'HFJ34743', 'Casa', 150000, 1, '2022-02-14', 4),
(5, 'HDJ34', 'Kebab', 3.5, 1, '0000-00-00', 7);

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
  `Password` char(32) NOT NULL,
  `CodAzienda` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dump dei dati per la tabella `titolari`
--

INSERT INTO `titolari` (`Cod`, `Nome`, `Cognome`, `Telefono`, `Email`, `Password`, `CodAzienda`) VALUES
(1, 'Marco', 'Rossi', '3334789855', 'marcorossi@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 2),
(2, 'Davide', 'Gerosa', '6578665499', 'davidegerosa@gmail.c', '5f4dcc3b5aa765d61d8327deb882cf99', 1),
(3, 'sdffsdfsd', 'sdfsdfsd', '3234234', 'fsdfsdf@luca.com', 'f1a74dbfa928054f592c2eaa3362b337', 1),
(4, 'andrea', 'locatelli', '237846234', 'locatelli@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 9),
(5, 'sdfsdf', 'sdfsd', '23234', 'asdfsdf@gmail.com', '73a90acaae2b1ccc0e969709665bc62f', 9),
(6, 'dsfsdf', 'sdfsdf', '234234', 'sdfsd@gmail.com', 'd58e3582afa99040e27b92b13c8f2280', 9),
(7, 'sdfsdf', 'sdfsdf', '23423423', 'sdfsdfsdf@gmail.com', 'd58e3582afa99040e27b92b13c8f2280', 9),
(8, 'jlskdfsdljk', 'sdlkfjsdfkl', '3456345', 'ciao@gmail.com', '0fe4f43e1dd173abc07ce508a74800e2', 13);

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
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `DeveVendere` (`CodAzienda`);

--
-- Indici per le tabelle `prodotti_venduti`
--
ALTER TABLE `prodotti_venduti`
  ADD PRIMARY KEY (`Cod`),
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
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `contratti`
--
ALTER TABLE `contratti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `dipendenti`
--
ALTER TABLE `dipendenti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prodotti_acquistati`
--
ALTER TABLE `prodotti_acquistati`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `prodotti_da_vendere`
--
ALTER TABLE `prodotti_da_vendere`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `prodotti_venduti`
--
ALTER TABLE `prodotti_venduti`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `titolari`
--
ALTER TABLE `titolari`
  MODIFY `Cod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
