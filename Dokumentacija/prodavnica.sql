-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2022 at 09:57 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prodavnica`
--
CREATE DATABASE IF NOT EXISTS `prodavnica` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `prodavnica`;

-- --------------------------------------------------------

--
-- Table structure for table `artikal`
--

CREATE TABLE `artikal` (
  `SifraArtikla` int(11) NOT NULL,
  `SoljaMajica` bit(1) NOT NULL,
  `Boja` varchar(30) NOT NULL,
  `Velicina` varchar(5) DEFAULT NULL,
  `Cena` int(11) NOT NULL,
  `Fajl` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artikal`
--

INSERT INTO `artikal` (`SifraArtikla`, `SoljaMajica`, `Boja`, `Velicina`, `Cena`, `Fajl`) VALUES
(1, b'0', 'Bela', NULL, 500, 'Images/majice/majica-bela.png'),
(2, b'0', 'Crna', NULL, 800, 'Images/majice/majica-crna.png'),
(3, b'0', 'Plava', NULL, 800, 'Images/majice/majica-plava.png'),
(4, b'0', 'Zelena', NULL, 600, 'Images/majice/majica-zelena.png'),
(5, b'0', 'Žuta', NULL, 600, 'Images/majice/majica-zuta.png'),
(6, b'0', 'Crvena', NULL, 600, 'Images/majice/majica-crvena.png'),
(7, b'1', 'Bela', NULL, 1000, 'Images/solje/solja-bela.png'),
(8, b'1', 'Crvena', NULL, 1200, 'Images/solje/solja-crvena.png'),
(9, b'1', 'Žuta', NULL, 1200, 'Images/solje/solja-zuta.png'),
(10, b'1', 'Plava', NULL, 1200, 'Images/solje/solja-plava.png'),
(11, b'1', 'Zelena', NULL, 1200, 'Images/solje/solja-zelena.png'),
(12, b'1', 'Crna', NULL, 1500, 'Images/solje/solja-crna.png'),
(25, b'0', 'Narandžasta', NULL, 600, 'Images/majice/majica-narandzasta.png');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `SifraKorisnika` int(11) NOT NULL,
  `Ime` varchar(30) NOT NULL,
  `Prezime` varchar(30) NOT NULL,
  `Adresa` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` int(20) NOT NULL,
  `Rola` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`SifraKorisnika`, `Ime`, `Prezime`, `Adresa`, `Email`, `Password`, `Rola`) VALUES
(2, 'Andrej', 'Unkovic', 'Krunska 1', 'unkovic.andrej@gmail.com', 123, 0),
(3, 'Dejan', 'Palic', 'Sombor', 'dejan.palic@gmail.com', 123, 1),
(5, 'Viktor', 'Unkovic', 'Krunsa 5', 'unkovic.viktor@gmail.com', 123, 1),
(6, 'Uros', 'Gegic', 'Krunsa 5', 'uros@gmail.com', 123, 1),
(7, 'Viktor', 'Unkovic', 'Krunska 2', 'sikitrontr@gmail.com', 123, 1),
(8, 'Ivona', 'Djuric', 'Krunska', 'ivona.djuric@gmail.com', 123, 1),
(9, 'Jovan', 'Jovic', 'Savski Venac 12', 'jovan.jovic@gmail.com', 123, 1),
(10, 'Sanja', 'Unkovic', 'Njegoseva', 'unkovic.sanja@gmail.com', 123, 1);

-- --------------------------------------------------------

--
-- Table structure for table `korpa`
--

CREATE TABLE `korpa` (
  `SifraKorpe` int(11) NOT NULL,
  `SifraArtikla` int(11) NOT NULL,
  `SifraKorisnika` int(11) NOT NULL,
  `SifraLogotipa` int(11) NOT NULL,
  `LogoPutanjaKorisnika` varchar(50) DEFAULT NULL,
  `Boja` varchar(30) NOT NULL,
  `Velicina` varchar(5) NOT NULL,
  `Rola` int(11) NOT NULL,
  `UkupnaCena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logotip`
--

CREATE TABLE `logotip` (
  `SifraLogotipa` int(11) NOT NULL,
  `Naziv` varchar(30) NOT NULL,
  `FajlLogotipa` varchar(50) DEFAULT NULL,
  `Cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `logotip`
--

INSERT INTO `logotip` (`SifraLogotipa`, `Naziv`, `FajlLogotipa`, `Cena`) VALUES
(1, 'Nike', 'Images/logotip/logotip1.png', 300),
(2, 'Orao', 'Images/logotip/logotip2.png', 300),
(3, 'Cvet', 'Images/logotip/logotip3.png', 400),
(4, 'Romb', 'Images/logotip/logotip4.png', 300),
(5, 'Monster', 'Images/logotip/logotip5.png', 400),
(6, 'LogoKorisnika', NULL, 500);

-- --------------------------------------------------------

--
-- Table structure for table `narudzbina`
--

CREATE TABLE `narudzbina` (
  `SifraNarudzbine` int(11) NOT NULL,
  `SifraArtikla` int(11) NOT NULL,
  `SifraKorisnika` int(11) NOT NULL,
  `SifraLogotipa` int(11) NOT NULL,
  `LogoPutanjaKorisnika` varchar(50) DEFAULT NULL,
  `Boja` varchar(30) NOT NULL,
  `Velicina` varchar(5) NOT NULL,
  `Rola` int(30) NOT NULL,
  `Cena` int(11) NOT NULL,
  `Datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `narudzbina`
--

INSERT INTO `narudzbina` (`SifraNarudzbine`, `SifraArtikla`, `SifraKorisnika`, `SifraLogotipa`, `LogoPutanjaKorisnika`, `Boja`, `Velicina`, `Rola`, `Cena`, `Datum`) VALUES
(44, 5, 5, 3, '', 'Žuta', 'L', 1, 1100, '2022-02-17 13:33:27'),
(45, 10, 5, 6, 'Images/korisnikLogotipi/narandz.jpg', 'Plava', '', 1, 1700, '2022-02-17 13:33:27'),
(46, 6, 2, 5, '', 'Crvena', 'S', 0, 1100, '2022-02-17 13:36:16'),
(47, 12, 2, 6, 'Images/korisnikLogotipi/braon.jpg', 'Crna', '', 0, 2000, '2022-02-17 13:36:16'),
(48, 9, 9, 6, 'Images/korisnikLogotipi/plava.jpg', 'Žuta', '', 1, 1700, '2022-02-17 15:06:32'),
(49, 10, 9, 6, 'Images/korisnikLogotipi/Screenshot_1.jpg', 'Plava', '', 1, 1700, '2022-02-17 15:06:32'),
(50, 4, 9, 2, '', 'Zelena', 'M', 1, 1100, '2022-02-17 15:06:32'),
(51, 3, 10, 3, '', 'Plava', 'S', 1, 1200, '2022-02-17 17:27:25'),
(52, 9, 10, 5, '', 'Žuta', '', 1, 1600, '2022-02-17 17:27:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikal`
--
ALTER TABLE `artikal`
  ADD PRIMARY KEY (`SifraArtikla`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`SifraKorisnika`);

--
-- Indexes for table `korpa`
--
ALTER TABLE `korpa`
  ADD PRIMARY KEY (`SifraKorpe`,`SifraArtikla`,`SifraKorisnika`,`SifraLogotipa`),
  ADD KEY `SifraLogotipa` (`SifraLogotipa`),
  ADD KEY `SifraKorisnika` (`SifraKorisnika`),
  ADD KEY `SifraArtikla` (`SifraArtikla`);

--
-- Indexes for table `logotip`
--
ALTER TABLE `logotip`
  ADD PRIMARY KEY (`SifraLogotipa`);

--
-- Indexes for table `narudzbina`
--
ALTER TABLE `narudzbina`
  ADD PRIMARY KEY (`SifraNarudzbine`,`SifraArtikla`,`SifraKorisnika`,`SifraLogotipa`),
  ADD KEY `SifraArtikla` (`SifraArtikla`),
  ADD KEY `SifraKorisnika` (`SifraKorisnika`),
  ADD KEY `SifraLogotipa` (`SifraLogotipa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikal`
--
ALTER TABLE `artikal`
  MODIFY `SifraArtikla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `SifraKorisnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `korpa`
--
ALTER TABLE `korpa`
  MODIFY `SifraKorpe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `logotip`
--
ALTER TABLE `logotip`
  MODIFY `SifraLogotipa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `narudzbina`
--
ALTER TABLE `narudzbina`
  MODIFY `SifraNarudzbine` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `korpa`
--
ALTER TABLE `korpa`
  ADD CONSTRAINT `korpa_ibfk_1` FOREIGN KEY (`SifraLogotipa`) REFERENCES `logotip` (`SifraLogotipa`),
  ADD CONSTRAINT `korpa_ibfk_2` FOREIGN KEY (`SifraKorisnika`) REFERENCES `korisnik` (`SifraKorisnika`),
  ADD CONSTRAINT `korpa_ibfk_3` FOREIGN KEY (`SifraArtikla`) REFERENCES `artikal` (`SifraArtikla`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
