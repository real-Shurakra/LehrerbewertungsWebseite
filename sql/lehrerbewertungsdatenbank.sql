-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Jul 2021 um 12:22
-- Server-Version: 10.4.8-MariaDB
-- PHP-Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `lehrerbewertungsdatenbank`
--

-- --------------------------------------------------------

--
-- Struktur des Views `getfbfragen`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragen`.`frage` AS `frage`,`fragen`.`kategorie` AS `kategorie`,`fragen`.`id` AS `frageid`,`nm_frage_fragebogen`.`bogenid` AS `bogenid`,avg(`bewertungen`.`bewertung`) AS `bewertung` from ((`nm_frage_fragebogen` left join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) left join `bewertungen` on(`fragen`.`id` = `bewertungen`.`frageid`)) group by `fragen`.`frage`,`fragen`.`kategorie`,`fragen`.`id`,`nm_frage_fragebogen`.`bogenid` ;

--
-- VIEW  `getfbfragen`
-- Daten: keine
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
