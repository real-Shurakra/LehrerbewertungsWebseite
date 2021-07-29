-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Jul 2021 um 21:25
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
-- Tabellenstruktur für Tabelle `bewertungen`
--

CREATE TABLE `bewertungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `bewertung` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `bewertungen`
--

INSERT INTO `bewertungen` (`id`, `frageid`, `bogenid`, `bewertung`) VALUES
(1, 7, 70, -2),
(2, 35, 70, 1),
(9, 7, 70, -1),
(10, 35, 70, 2),
(11, 7, 70, -1),
(12, 35, 70, 2),
(13, 7, 70, -1),
(14, 35, 70, 2),
(15, 7, 70, -1),
(16, 35, 70, 2),
(17, 7, 70, -1),
(18, 35, 70, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `codes`
--

CREATE TABLE `codes` (
  `codehash` varchar(16) NOT NULL,
  `fragebogenid` bigint(20) UNSIGNED NOT NULL,
  `kritik` tinyint(1) NOT NULL DEFAULT 0,
  `bewertung` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `codes`
--

INSERT INTO `codes` (`codehash`, `fragebogenid`, `kritik`, `bewertung`) VALUES
('00-48-40-00', 103, 0, 0),
('00-51-32-87', 113, 0, 0),
('00-88-38-27', 108, 0, 0),
('00-98-27-82', 109, 0, 0),
('01-03-21-68', 104, 0, 0),
('01-07-34-37', 111, 0, 0),
('01-10-27-54', 116, 0, 0),
('01-25-37-71', 112, 0, 0),
('01-35-14-73', 117, 0, 0),
('01-35-94-42', 109, 0, 0),
('01-50-35-60', 118, 0, 0),
('01-82-65-25', 114, 0, 0),
('02-08-86-90', 117, 0, 0),
('02-13-32-41', 117, 0, 0),
('02-28-25-09', 111, 0, 0),
('02-34-42-82', 111, 0, 0),
('02-36-34-06', 110, 0, 0),
('02-59-70-07', 114, 0, 0),
('02-75-45-10', 124, 0, 0),
('03-23-12-80', 103, 0, 0),
('03-47-25-93', 102, 0, 0),
('03-61-09-53', 117, 0, 0),
('03-72-45-20', 113, 0, 0),
('03-86-61-33', 108, 0, 0),
('03-93-68-63', 107, 0, 0),
('04-01-33-34', 110, 0, 0),
('04-09-13-18', 108, 0, 0),
('04-54-94-23', 116, 0, 0),
('04-73-48-69', 124, 0, 0),
('04-82-35-44', 118, 0, 0),
('04-91-54-53', 110, 0, 0),
('04-99-58-77', 98, 0, 0),
('05-08-16-19', 110, 0, 0),
('06-21-29-16', 116, 0, 0),
('06-47-82-36', 112, 0, 0),
('06-82-24-64', 116, 0, 0),
('06-84-03-23', 105, 0, 0),
('06-91-68-03', 115, 0, 0),
('07-04-75-02', 107, 0, 0),
('07-29-21-47', 110, 0, 0),
('07-41-51-43', 111, 0, 0),
('07-64-41-83', 116, 0, 0),
('07-71-34-16', 102, 0, 0),
('08-40-62-16', 118, 0, 0),
('08-44-24-83', 111, 0, 0),
('08-55-61-69', 112, 0, 0),
('08-56-22-30', 118, 0, 0),
('09-01-87-25', 107, 0, 0),
('09-17-07-73', 107, 0, 0),
('09-19-93-51', 103, 0, 0),
('09-22-61-51', 117, 0, 0),
('09-44-05-43', 112, 0, 0),
('09-62-08-33', 102, 0, 0),
('09-80-66-51', 116, 0, 0),
('10-39-89-25', 113, 0, 0),
('10-64-74-87', 124, 0, 0),
('10-94-67-42', 104, 0, 0),
('11-22-28-62', 102, 0, 0),
('11-29-83-35', 107, 0, 0),
('11-49-12-16', 114, 0, 0),
('11-65-10-94', 117, 0, 0),
('11-70-75-23', 118, 0, 0),
('12-41-24-41', 112, 0, 0),
('12-51-64-81', 108, 0, 0),
('12-60-81-82', 105, 0, 0),
('12-63-50-74', 102, 0, 0),
('13-30-07-90', 104, 0, 0),
('13-38-33-89', 110, 0, 0),
('13-66-41-47', 108, 0, 0),
('14-36-51-44', 117, 0, 0),
('14-61-48-13', 108, 0, 0),
('15-15-07-62', 115, 0, 0),
('16-17-80-67', 109, 0, 0),
('16-57-14-50', 110, 0, 0),
('16-59-84-76', 117, 0, 0),
('16-62-26-27', 103, 0, 0),
('16-93-53-14', 108, 0, 0),
('17-84-03-05', 103, 0, 0),
('18-01-21-68', 105, 0, 0),
('18-16-02-10', 108, 0, 0),
('18-17-00-38', 106, 0, 0),
('18-60-50-82', 112, 0, 0),
('18-63-95-75', 106, 0, 0),
('18-71-76-14', 110, 0, 0),
('19-04-07-13', 116, 0, 0),
('19-09-04-24', 106, 0, 0),
('19-46-51-61', 101, 0, 0),
('19-51-90-52', 106, 0, 0),
('20-22-92-13', 124, 0, 0),
('20-40-50-97', 103, 0, 0),
('21-44-13-99', 114, 0, 0),
('21-44-60-25', 116, 0, 0),
('21-83-60-33', 108, 0, 0),
('22-14-17-84', 111, 0, 0),
('22-15-54-23', 116, 0, 0),
('22-38-19-67', 114, 0, 0),
('23-24-13-41', 116, 0, 0),
('23-53-17-73', 113, 0, 0),
('23-53-63-90', 104, 0, 0),
('23-75-09-14', 109, 0, 0),
('23-82-87-08', 111, 0, 0),
('23-90-80-58', 106, 0, 0),
('24-15-44-01', 114, 0, 0),
('24-34-86-23', 111, 0, 0),
('24-37-70-01', 102, 0, 0),
('24-82-44-95', 103, 0, 0),
('24-94-40-66', 124, 0, 0),
('25-15-10-93', 112, 0, 0),
('25-24-85-50', 105, 0, 0),
('25-61-19-59', 118, 0, 0),
('25-76-12-40', 104, 0, 0),
('26-19-28-88', 103, 0, 0),
('26-19-82-14', 111, 0, 0),
('26-44-60-31', 106, 0, 0),
('26-74-66-49', 121, 0, 0),
('26-74-86-94', 112, 0, 0),
('26-91-41-03', 111, 0, 0),
('27-06-86-18', 102, 0, 0),
('27-21-88-51', 111, 0, 0),
('27-47-12-03', 109, 0, 0),
('27-62-70-43', 124, 0, 0),
('27-63-48-54', 112, 0, 0),
('28-16-33-03', 104, 0, 0),
('28-28-76-05', 118, 0, 0),
('28-47-25-30', 113, 0, 0),
('28-95-83-66', 109, 0, 0),
('28-99-91-69', 103, 0, 0),
('29-28-86-63', 114, 0, 0),
('29-34-78-32', 114, 0, 0),
('29-35-31-15', 111, 0, 0),
('29-69-74-04', 102, 0, 0),
('30-15-86-87', 124, 0, 0),
('30-38-52-94', 113, 0, 0),
('30-46-90-94', 117, 0, 0),
('30-92-72-89', 124, 0, 0),
('31-04-70-48', 115, 0, 0),
('31-37-32-26', 114, 0, 0),
('31-37-57-56', 118, 0, 0),
('31-43-20-76', 114, 0, 0),
('31-51-07-58', 108, 0, 0),
('31-87-56-50', 108, 0, 0),
('31-92-66-30', 118, 0, 0),
('31-94-88-38', 109, 0, 0),
('32-07-71-26', 111, 0, 0),
('32-16-05-02', 110, 0, 0),
('32-42-03-01', 105, 0, 0),
('32-70-78-29', 115, 0, 0),
('32-83-98-82', 103, 0, 0),
('33-04-37-51', 96, 0, 0),
('33-36-34-61', 103, 0, 0),
('33-49-14-71', 116, 0, 0),
('33-97-13-96', 115, 0, 0),
('34-34-33-05', 103, 0, 0),
('34-44-56-17', 105, 0, 0),
('34-56-19-46', 111, 0, 0),
('34-89-27-92', 107, 0, 0),
('34-98-12-89', 109, 0, 0),
('35-10-45-00', 105, 0, 0),
('35-18-52-04', 107, 0, 0),
('35-19-26-85', 112, 0, 0),
('35-57-48-95', 115, 0, 0),
('35-62-73-57', 109, 0, 0),
('35-78-33-12', 116, 0, 0),
('35-98-89-68', 112, 0, 0),
('36-71-31-16', 105, 0, 0),
('36-74-17-37', 113, 0, 0),
('36-74-89-41', 105, 0, 0),
('37-02-36-50', 124, 0, 0),
('37-51-62-16', 113, 0, 0),
('37-53-39-56', 118, 0, 0),
('38-08-18-21', 97, 0, 0),
('38-23-29-09', 118, 0, 0),
('38-57-20-92', 116, 0, 0),
('38-59-85-17', 115, 0, 0),
('38-62-97-69', 104, 0, 0),
('38-68-85-55', 108, 0, 0),
('38-85-44-97', 118, 0, 0),
('39-09-89-96', 124, 0, 0),
('39-22-13-38', 117, 0, 0),
('39-36-51-46', 114, 0, 0),
('39-48-55-38', 103, 0, 0),
('39-49-09-91', 103, 0, 0),
('39-55-38-78', 103, 0, 0),
('40-33-62-24', 105, 0, 0),
('40-43-36-58', 106, 0, 0),
('40-79-01-40', 110, 0, 0),
('41-36-08-75', 104, 0, 0),
('41-53-51-59', 102, 0, 0),
('41-83-63-94', 109, 0, 0),
('41-88-03-16', 103, 0, 0),
('41-90-01-11', 106, 0, 0),
('41-95-84-10', 114, 0, 0),
('42-62-80-25', 107, 0, 0),
('42-69-15-51', 110, 0, 0),
('43-14-04-15', 108, 0, 0),
('43-37-04-55', 117, 0, 0),
('43-46-81-95', 102, 0, 0),
('43-50-35-30', 111, 0, 0),
('43-51-31-09', 112, 0, 0),
('43-65-54-23', 105, 0, 0),
('44-10-64-88', 106, 0, 0),
('44-33-55-06', 110, 0, 0),
('44-66-75-97', 106, 0, 0),
('44-69-07-26', 103, 0, 0),
('44-73-84-70', 109, 0, 0),
('44-75-24-28', 102, 0, 0),
('44-85-22-30', 108, 0, 0),
('44-85-88-47', 114, 0, 0),
('44-89-34-90', 111, 0, 0),
('45-67-50-12', 112, 0, 0),
('46-34-40-16', 106, 0, 0),
('46-40-40-17', 116, 0, 0),
('46-45-70-90', 116, 0, 0),
('46-49-01-69', 118, 0, 0),
('46-79-95-04', 118, 0, 0),
('47-09-32-25', 115, 0, 0),
('47-55-73-60', 113, 0, 0),
('47-57-68-92', 114, 0, 0),
('47-68-16-06', 111, 0, 0),
('47-95-89-41', 112, 0, 0),
('47-99-58-99', 115, 0, 0),
('48-09-63-90', 113, 0, 0),
('48-28-79-06', 113, 0, 0),
('48-34-02-15', 105, 0, 0),
('48-59-33-27', 107, 0, 0),
('48-65-15-90', 106, 0, 0),
('48-93-55-98', 116, 0, 0),
('49-23-42-89', 115, 0, 0),
('49-76-38-04', 106, 0, 0),
('50-02-69-08', 124, 0, 0),
('50-37-94-70', 112, 0, 0),
('50-62-74-21', 107, 0, 0),
('50-69-85-30', 109, 0, 0),
('50-76-67-27', 110, 0, 0),
('50-80-66-02', 103, 0, 0),
('50-87-68-92', 108, 0, 0),
('51-04-33-57', 109, 0, 0),
('51-42-37-06', 124, 0, 0),
('51-59-57-62', 102, 0, 0),
('51-63-52-67', 114, 0, 0),
('51-74-04-82', 113, 0, 0),
('51-86-22-68', 124, 0, 0),
('52-14-99-14', 117, 0, 0),
('52-40-78-25', 117, 0, 0),
('52-54-54-80', 114, 0, 0),
('52-96-14-24', 103, 0, 0),
('53-47-75-04', 117, 0, 0),
('53-48-00-51', 124, 0, 0),
('53-61-08-52', 100, 0, 0),
('53-61-20-26', 105, 0, 0),
('54-41-87-86', 117, 0, 0),
('54-64-21-22', 115, 0, 0),
('55-30-14-02', 103, 0, 0),
('55-42-10-38', 108, 0, 0),
('55-49-28-32', 115, 0, 0),
('55-49-74-82', 109, 0, 0),
('55-59-35-48', 102, 0, 0),
('56-01-80-39', 114, 0, 0),
('56-03-29-70', 115, 0, 0),
('56-28-28-82', 110, 0, 0),
('56-43-73-34', 107, 0, 0),
('56-66-64-60', 106, 0, 0),
('56-75-42-67', 117, 0, 0),
('56-85-64-75', 108, 0, 0),
('57-23-54-72', 110, 0, 0),
('57-33-14-28', 124, 0, 0),
('57-33-87-24', 113, 0, 0),
('57-38-52-63', 124, 0, 0),
('57-69-52-49', 108, 0, 0),
('57-99-05-26', 115, 0, 0),
('58-07-55-30', 104, 0, 0),
('58-22-01-24', 124, 0, 0),
('58-27-51-92', 122, 0, 0),
('58-33-89-81', 112, 0, 0),
('58-39-33-48', 113, 0, 0),
('58-79-71-67', 124, 0, 0),
('58-80-55-19', 109, 0, 0),
('59-23-53-16', 112, 0, 0),
('59-35-34-63', 106, 0, 0),
('59-41-20-93', 115, 0, 0),
('59-48-62-71', 113, 0, 0),
('59-62-03-85', 113, 0, 0),
('59-68-78-44', 102, 0, 0),
('59-73-46-72', 116, 0, 0),
('59-76-88-19', 110, 0, 0),
('60-07-37-21', 105, 0, 0),
('60-33-64-24', 104, 0, 0),
('60-38-02-76', 104, 0, 0),
('60-63-35-43', 116, 0, 0),
('60-66-68-22', 107, 0, 0),
('60-79-79-47', 104, 0, 0),
('60-91-46-98', 112, 0, 0),
('61-14-48-68', 112, 0, 0),
('61-74-46-27', 117, 0, 0),
('62-06-69-21', 107, 0, 0),
('62-11-27-48', 104, 0, 0),
('62-14-83-71', 106, 0, 0),
('62-15-11-99', 110, 0, 0),
('62-16-46-09', 124, 0, 0),
('62-28-56-07', 107, 0, 0),
('62-97-17-89', 102, 0, 0),
('63-33-48-58', 104, 0, 0),
('63-35-91-45', 103, 0, 0),
('63-54-26-22', 116, 0, 0),
('64-32-84-80', 106, 0, 0),
('65-06-22-45', 116, 0, 0),
('65-17-79-55', 117, 0, 0),
('65-46-38-70', 115, 0, 0),
('65-48-35-43', 110, 0, 0),
('65-72-58-14', 110, 0, 0),
('66-00-14-45', 94, 0, 0),
('66-52-24-36', 108, 0, 0),
('66-61-77-54', 115, 0, 0),
('66-76-99-74', 104, 0, 0),
('67-19-24-92', 117, 0, 0),
('67-20-54-93', 107, 0, 0),
('67-22-01-96', 124, 0, 0),
('67-49-33-45', 107, 0, 0),
('67-61-51-61', 115, 0, 0),
('67-81-09-50', 108, 0, 0),
('67-91-60-72', 109, 0, 0),
('67-96-79-20', 118, 0, 0),
('68-02-84-47', 114, 0, 0),
('68-32-25-37', 108, 0, 0),
('68-84-21-89', 106, 0, 0),
('68-88-00-59', 114, 0, 0),
('69-21-24-88', 116, 0, 0),
('69-25-00-37', 118, 0, 0),
('69-32-37-81', 118, 0, 0),
('69-51-02-59', 111, 0, 0),
('69-98-37-59', 104, 0, 0),
('70-19-94-61', 118, 0, 0),
('70-34-35-02', 108, 0, 0),
('70-41-74-69', 109, 0, 0),
('70-99-34-24', 113, 0, 0),
('71-00-90-54', 102, 0, 0),
('71-45-19-71', 124, 0, 0),
('71-74-60-56', 110, 0, 0),
('71-81-23-06', 105, 0, 0),
('71-83-91-69', 117, 0, 0),
('72-09-02-92', 109, 0, 0),
('72-19-20-27', 107, 0, 0),
('72-41-85-98', 110, 0, 0),
('72-46-53-49', 102, 0, 0),
('72-51-09-14', 114, 0, 0),
('72-66-22-57', 124, 0, 0),
('72-77-46-07', 114, 0, 0),
('72-90-72-71', 116, 0, 0),
('73-16-52-04', 113, 0, 0),
('73-56-40-43', 105, 0, 0),
('73-66-70-90', 107, 0, 0),
('73-77-61-82', 103, 0, 0),
('73-80-22-10', 113, 0, 0),
('73-91-67-54', 109, 0, 0),
('73-92-25-59', 107, 0, 0),
('74-08-70-18', 106, 0, 0),
('74-47-82-13', 117, 0, 0),
('74-90-56-78', 117, 0, 0),
('75-52-27-76', 111, 0, 0),
('75-74-43-35', 111, 0, 0),
('76-46-72-88', 106, 0, 0),
('76-55-71-34', 105, 0, 0),
('76-70-73-15', 103, 0, 0),
('76-99-44-70', 112, 0, 0),
('77-17-24-20', 104, 0, 0),
('77-57-20-88', 116, 0, 0),
('77-81-53-00', 111, 0, 0),
('78-03-36-78', 117, 0, 0),
('78-28-27-67', 118, 0, 0),
('78-72-05-70', 102, 0, 0),
('78-90-46-76', 105, 0, 0),
('78-96-76-23', 105, 0, 0),
('78-99-78-50', 103, 0, 0),
('79-30-73-53', 113, 0, 0),
('79-37-20-19', 117, 0, 0),
('79-52-37-07', 108, 0, 0),
('79-69-15-99', 105, 0, 0),
('80-02-96-04', 124, 0, 0),
('80-25-82-47', 110, 0, 0),
('80-36-87-21', 107, 0, 0),
('80-56-23-86', 107, 0, 0),
('80-98-46-39', 114, 0, 0),
('81-44-18-92', 118, 0, 0),
('81-51-52-57', 102, 0, 0),
('82-55-34-00', 115, 0, 0),
('83-24-42-26', 115, 0, 0),
('83-49-52-97', 114, 0, 0),
('84-05-25-15', 104, 0, 0),
('84-33-73-59', 106, 0, 0),
('84-42-82-86', 111, 0, 0),
('84-47-53-77', 104, 0, 0),
('84-68-33-79', 103, 0, 0),
('85-13-34-79', 105, 0, 0),
('85-46-22-32', 106, 0, 0),
('85-63-64-89', 115, 0, 0),
('85-68-68-46', 110, 0, 0),
('85-76-19-95', 112, 0, 0),
('86-27-36-91', 124, 0, 0),
('86-38-50-58', 104, 0, 0),
('86-58-12-52', 112, 0, 0),
('87-09-94-35', 106, 0, 0),
('87-55-90-91', 117, 0, 0),
('87-81-32-84', 108, 0, 0),
('88-24-84-91', 115, 0, 0),
('88-92-05-39', 107, 0, 0),
('89-13-45-82', 104, 0, 0),
('89-13-63-70', 102, 0, 0),
('89-18-33-01', 115, 0, 0),
('89-19-78-60', 104, 0, 0),
('89-45-15-59', 105, 0, 0),
('89-50-33-21', 124, 0, 0),
('89-72-90-14', 102, 0, 0),
('89-88-70-36', 116, 0, 0),
('90-07-53-28', 102, 0, 0),
('90-16-50-04', 118, 0, 0),
('90-18-21-99', 102, 0, 0),
('90-27-81-88', 115, 0, 0),
('90-51-70-45', 112, 0, 0),
('90-60-92-50', 113, 0, 0),
('90-99-13-04', 109, 0, 0),
('91-23-31-26', 107, 0, 0),
('91-37-86-57', 109, 0, 0),
('91-49-66-65', 107, 0, 0),
('92-00-01-93', 104, 0, 0),
('92-10-22-79', 113, 0, 0),
('92-39-19-80', 113, 0, 0),
('92-57-43-73', 107, 0, 0),
('92-66-99-95', 109, 0, 0),
('92-74-80-18', 118, 0, 0),
('92-89-80-56', 110, 0, 0),
('93-12-45-84', 109, 0, 0),
('93-37-09-39', 104, 0, 0),
('93-76-49-31', 106, 0, 0),
('94-73-57-28', 118, 0, 0),
('95-33-27-40', 114, 0, 0),
('95-54-68-15', 118, 0, 0),
('95-55-48-02', 108, 0, 0),
('95-59-22-52', 114, 0, 0),
('95-64-30-23', 105, 0, 0),
('96-03-57-12', 110, 0, 0),
('96-03-64-86', 115, 0, 0),
('96-40-47-84', 111, 0, 0),
('96-63-72-87', 109, 0, 0),
('96-66-12-84', 102, 0, 0),
('96-75-64-98', 113, 0, 0),
('97-12-05-06', 104, 0, 0),
('97-66-91-63', 109, 0, 0),
('98-12-79-15', 113, 0, 0),
('98-34-18-25', 105, 0, 0),
('98-57-02-56', 102, 0, 0),
('98-93-10-75', 105, 0, 0),
('99-04-57-38', 106, 0, 0),
('99-22-50-19', 118, 0, 0),
('99-51-81-32', 120, 0, 0),
('99-77-44-71', 111, 0, 0),
('99-86-01-11', 112, 0, 0),
('99-87-05-83', 111, 0, 0),
('99-87-19-88', 116, 0, 0),
('99-93-80-81', 112, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

CREATE TABLE `fach` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fach`
--

INSERT INTO `fach` (`id`, `name`) VALUES
(1, 'ITS');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragebogen`
--

CREATE TABLE `fragebogen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zeitstempel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED NOT NULL,
  `fachid` bigint(20) UNSIGNED NOT NULL,
  `klassename` varchar(32) NOT NULL,
  `schueleranzahl` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fragebogen`
--

INSERT INTO `fragebogen` (`id`, `zeitstempel`, `name`, `lehrerid`, `fachid`, `klassename`, `schueleranzahl`) VALUES
(60, '2021-05-27 15:11:37', 'BogenX', 1, 1, 'ITB1-19', 1),
(70, '2021-05-27 15:17:49', 'BogenX', 1, 1, 'ITB1-19', 1),
(79, '2021-05-27 15:29:25', 'BogenX', 1, 1, 'ITB1-19', 1),
(80, '2021-05-27 15:29:50', 'BogenX', 1, 1, 'ITB1-19', 5),
(81, '2021-05-27 15:47:25', 'BogenX', 1, 1, 'ITB1-19', 1),
(82, '2021-05-27 15:47:53', 'BogenX', 1, 1, 'ITB1-19', 1),
(83, '2021-05-27 15:48:00', 'BogenX', 1, 1, 'ITB1-19', 1),
(86, '2021-07-12 08:46:15', 'Minka-Test', 1, 1, 'ITB1-19', 25),
(87, '2021-07-12 08:46:25', 'Minka-Test', 1, 1, 'ITB1-19', 25),
(88, '2021-07-12 08:50:11', 'Minka-Test', 1, 1, 'ITB1-19', 25),
(92, '2021-07-12 09:09:38', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(93, '2021-07-12 09:09:51', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(94, '2021-07-12 09:11:32', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(95, '2021-07-12 09:23:46', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(96, '2021-07-12 09:28:21', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(97, '2021-07-12 09:28:27', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(98, '2021-07-12 09:28:45', 'Test-Minka', 1, 1, 'ITB1-19', 1),
(100, '2021-07-12 09:29:26', 'loi', 1, 1, 'ITB1-19', 1),
(101, '2021-07-12 09:29:58', 'loi', 1, 1, 'ITB1-19', 1),
(102, '2021-07-12 09:30:53', '156', 1, 1, 'ITB1-19', 25),
(103, '2021-07-12 09:31:24', '1566', 1, 1, 'ITB1-19', 25),
(104, '2021-07-12 09:32:56', '1566', 1, 1, 'ITB1-19', 25),
(105, '2021-07-12 09:34:33', '1566', 1, 1, 'ITB1-19', 25),
(106, '2021-07-12 09:35:57', '1566', 1, 1, 'ITB1-19', 25),
(107, '2021-07-12 09:36:25', '1566', 1, 1, 'ITB1-19', 25),
(108, '2021-07-12 09:36:55', '1566', 1, 1, 'ITB1-19', 25),
(109, '2021-07-12 09:37:12', '15663', 1, 1, 'ITB1-19', 25),
(110, '2021-07-12 09:37:46', '156633', 1, 1, 'ITB1-19', 25),
(111, '2021-07-12 09:38:19', '156633', 1, 1, 'ITB1-19', 25),
(112, '2021-07-12 09:38:40', '156633', 1, 1, 'ITB1-19', 25),
(113, '2021-07-12 09:38:57', '156633', 1, 1, 'ITB1-19', 25),
(114, '2021-07-12 09:39:13', '1566333', 1, 1, 'ITB1-19', 25),
(115, '2021-07-12 09:39:28', '1566333', 1, 1, 'ITB1-19', 25),
(116, '2021-07-12 09:40:37', '1566333', 1, 1, 'ITB1-19', 25),
(117, '2021-07-12 09:41:56', '1566333', 1, 1, 'ITB1-19', 25),
(118, '2021-07-12 09:42:08', '1566333', 1, 1, 'ITB1-19', 25),
(120, '2021-07-12 10:30:01', '', 1, 1, 'ITB1-19', 1),
(121, '2021-07-12 10:31:03', '', 1, 1, 'ITB1-19', 1),
(122, '2021-07-12 10:31:49', '', 1, 1, 'ITB1-19', 1),
(124, '2021-07-12 10:37:51', '', 1, 1, 'ITB1-19', 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragen`
--

CREATE TABLE `fragen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frage` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED DEFAULT NULL,
  `kategorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fragen`
--

INSERT INTO `fragen` (`id`, `frage`, `lehrerid`, `kategorie`) VALUES
(1, 'Der Unterricht ist gut vorbereitet und sorgfaltig geplant.', NULL, 'Unterricht'),
(2, 'Die Interessen der Schüler werden bei der Unterrichtsplanung berücksichtigt.', NULL, 'Unterricht'),
(3, 'Die Arbeitsanweisungen sind klar verständlich.', NULL, 'Unterricht'),
(4, 'Die Arbeitsmaterialien sind übersichtlich und ordentlich aufbereitet.', NULL, 'Unterricht'),
(5, 'Gruppen- und Einzelarbeiten der Schüler werden abwechslungsreich eingesetzt.', NULL, 'Unterricht'),
(6, 'Im Unterricht werden Bezüge zu aktuellen Themen hergestellt.', NULL, 'Unterricht'),
(7, 'Die Unterrichtsinhalte sind praxisbezogen.', NULL, 'Unterricht'),
(8, 'Praxisbezug wird durch Kontakte zu Betrieben und anderen außerschulichen Einrichtungen gewährleistet.', NULL, 'Unterricht'),
(9, 'Die Zusammenarbeit bzw. Absprache zwischen Schule und Betrieben ist angemessen.', NULL, 'Unterricht'),
(10, 'Der Unterricht enthalt ausreichend Übungsphasen Unterrichtsergebnisse werden schriftlich festgehalten.', NULL, 'Unterricht'),
(11, 'Tafelbilder und Folien sind gut lesbar.', NULL, 'Unterricht'),
(12, 'Das Arbeitsklima ermuntert die Schüler zur aktiven Unterrichtsbeteiligung.', NULL, 'Arbeitsklima'),
(13, 'Es herrscht ein Arbeitsklima, in dem auch Fehler und abweichende Meinungen zugelassen werden.', NULL, 'Arbeitsklima'),
(14, 'Man traut sich, Fragen zu stellen.', NULL, 'Arbeitsklima'),
(15, 'Man fühlt sich ernst genommen.', NULL, 'Arbeitsklima'),
(16, 'Die Schüler erscheinen pünktlich zum Unterricht.', NULL, 'Arbeitsklima'),
(17, 'Die Schüler entschuldigen ihre Fehlzelten rechtzeitig und angemessen.', NULL, 'Arbeitsklima'),
(18, 'Die Schüler beteiligen sich angemessen im Unterricht.', NULL, 'Arbeitsklima'),
(19, 'Die Schüler bearbeiten die Aufgaben im Unterricht konzentriert.', NULL, 'Arbeitsklima'),
(20, 'Die Schüler erledigen ihre Hausaufgaben zuverlässig.', NULL, 'Arbeitsklima'),
(21, 'Die Schüler verhalten sich im Unterricht ruhig.', NULL, 'Arbeitsklima'),
(22, 'Unter den Schülern herrschte Fairness.', NULL, 'Arbeitsklima'),
(23, 'Einzelne Schüler wurden verbal oder mit anderen Mittel von ihren Mitschülern herabgesetzt.', NULL, 'Arbeitsklima'),
(24, 'Der Umgang der Schüler untereinander ist ehrlich und aufrichtig.', NULL, 'Arbeitsklima'),
(25, 'Er ist freundlich und geduldig.', NULL, 'Lehrer'),
(26, 'Er erklärt Unterrichtsinhalte anhand von Beispielen.', NULL, 'Lehrer'),
(27, 'Er lobt Schüler und ermutigt sie.', NULL, 'Lehrer'),
(28, 'Er lässt Kritik zu und geht darauf ein.', NULL, 'Lehrer'),
(29, 'Er fördert selbstständiges Denken und Arbeiten.', NULL, 'Lehrer'),
(30, 'Er nimmt Ideen der Schüler auf und blockt diese nicht ab.', NULL, 'Lehrer'),
(31, 'Die Klassenarbeiten entsprechen dem behandelten Stoff.', NULL, 'Leistungsbewertung'),
(32, 'Die Klassenarbeiten verlangen mehr als nur Auswendiglernen.', NULL, 'Leistungsbewertung'),
(33, 'Die Aufgabenstellungen sind verständlich formuliert.', NULL, 'Leistungsbewertung'),
(34, 'Die Klassenarbeiten werden fair benotet.', NULL, 'Leistungsbewertung'),
(35, 'Die Beurteilungskriterien sind nachvollziehbar.', NULL, 'Leistungsbewertung'),
(36, 'Die Schüler erhalten ausreichend Gelegenheit, sich im Rahmen der sonstigen Mitarbeit zu engagieren.', NULL, 'Leistungsbewertung'),
(37, 'Die sonstige Mitarbeit fließt angemessen in die Gesamtnote ein.', NULL, 'Leistungsbewertung'),
(38, 'Die Beurteilung ist gerecht, weil alle Schüler gleich behandelt werden.', NULL, 'Leistungsbewertung'),
(112, 'Herr KrÃ¶ger sieht aus wie jemand der Katzen mag.', 1, 'Lehrer'),
(113, 'Test', 1, 'Unterricht'),
(114, 'TEST_2', NULL, 'Unterricht'),
(115, 'Kaschwivbel', 1, 'Unterricht'),
(116, 'asfdasfs', 1, 'Unterricht'),
(117, 'sd', 1, 'Unterricht'),
(118, 'sdfgsdfgdsg', 1, 'Unterricht'),
(119, 'Kabogadibogadi', 1, 'Unterricht'),
(120, 'blubb', 1, 'Unterricht'),
(121, 'blubb2', 1, 'Unterricht'),
(122, 'blubb3', 1, 'Unterricht'),
(123, 'blubb4', 1, 'Unterricht'),
(124, 'asdfasdfasfsd', 1, 'Unterricht'),
(125, 'asfdasdfasfads', 1, 'Unterricht'),
(126, 'sfgsdfgdgdggggggggggggggggggggggggggg', 1, 'Unterricht'),
(127, 'Testfrage', 1, 'Lehrer'),
(128, 'asdfsa', 1, 'Unterricht');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getbewertungen`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getbewertungen` (
`sum(bewertungen.bewertung)` decimal(27,0)
,`id` bigint(20) unsigned
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getfbfragen`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getfbfragen` (
`frage` varchar(255)
,`kategorie` varchar(255)
,`frageid` bigint(20) unsigned
,`bogenid` bigint(20) unsigned
,`bewertung` decimal(9,4)
,`zeitstempel` timestamp
,`thema` varchar(255)
,`klassename` varchar(32)
,`fachname` varchar(32)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getfragebogen`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getfragebogen` (
`id` bigint(20) unsigned
,`zeitstempel` timestamp
,`name` varchar(255)
,`fach` varchar(32)
,`klassename` varchar(32)
,`schueleranzahl` smallint(6)
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getfragenanzahl`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getfragenanzahl` (
`count(nm_frage_fragebogen.frageid)` bigint(21)
,`id` bigint(20) unsigned
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `klasse`
--

CREATE TABLE `klasse` (
  `name` varchar(32) NOT NULL,
  `schueleranzahl` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `klasse`
--

INSERT INTO `klasse` (`name`, `schueleranzahl`) VALUES
('ITB1-19', 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lehrer`
--

CREATE TABLE `lehrer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail` varchar(255) NOT NULL,
  `vorname` varchar(128) NOT NULL,
  `nachname` varchar(128) NOT NULL,
  `passwort` varchar(128) NOT NULL,
  `isroot` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `lehrer`
--

INSERT INTO `lehrer` (`id`, `mail`, `vorname`, `nachname`, `passwort`, `isroot`) VALUES
(1, 'temp.dump@hotmail.com', 'Admin', 'Admin', 'fc5a8d28daaff41f992dd78286e7c7eb58953f138bc67f5f622a7fea035745be97f1ee603aafeabf3a54fad97ba6b8eb2211e5d1635139b38c3ac189d8d8685e', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nm_frage_fragebogen`
--

CREATE TABLE `nm_frage_fragebogen` (
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `nm_frage_fragebogen`
--

INSERT INTO `nm_frage_fragebogen` (`frageid`, `bogenid`) VALUES
(16, 124),
(17, 124),
(19, 124),
(20, 124),
(22, 124);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nm_lehrer_klasse`
--

CREATE TABLE `nm_lehrer_klasse` (
  `lehrerid` bigint(20) UNSIGNED NOT NULL,
  `klassename` varchar(32) NOT NULL,
  `fachid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbesserungen`
--

CREATE TABLE `verbesserungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `vorschlag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur des Views `getbewertungen`
--
DROP TABLE IF EXISTS `getbewertungen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getbewertungen`  AS  select sum(`bewertungen`.`bewertung`) AS `sum(bewertungen.bewertung)`,`fragebogen`.`id` AS `id`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `bewertungen` on(`fragebogen`.`id` = `bewertungen`.`bogenid`)) group by `fragebogen`.`id` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getfbfragen`
--
DROP TABLE IF EXISTS `getfbfragen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `lehrerbewertungsdatenbank2`.`fragen`.`frage` AS `frage`,`lehrerbewertungsdatenbank2`.`fragen`.`kategorie` AS `kategorie`,`lehrerbewertungsdatenbank2`.`fragen`.`id` AS `frageid`,`lehrerbewertungsdatenbank2`.`nm_frage_fragebogen`.`bogenid` AS `bogenid`,avg(`lehrerbewertungsdatenbank2`.`bewertungen`.`bewertung`) AS `bewertung`,`lehrerbewertungsdatenbank2`.`fragebogen`.`zeitstempel` AS `zeitstempel`,`lehrerbewertungsdatenbank2`.`fragebogen`.`name` AS `thema`,`lehrerbewertungsdatenbank2`.`fragebogen`.`klassename` AS `klassename`,`lehrerbewertungsdatenbank2`.`fach`.`name` AS `fachname` from ((((`lehrerbewertungsdatenbank2`.`nm_frage_fragebogen` left join `lehrerbewertungsdatenbank2`.`fragen` on(`lehrerbewertungsdatenbank2`.`nm_frage_fragebogen`.`frageid` = `lehrerbewertungsdatenbank2`.`fragen`.`id`)) left join `lehrerbewertungsdatenbank2`.`bewertungen` on(`lehrerbewertungsdatenbank2`.`fragen`.`id` = `lehrerbewertungsdatenbank2`.`bewertungen`.`frageid`)) left join `lehrerbewertungsdatenbank2`.`fragebogen` on(`lehrerbewertungsdatenbank2`.`nm_frage_fragebogen`.`bogenid` = `lehrerbewertungsdatenbank2`.`fragebogen`.`id`)) left join `lehrerbewertungsdatenbank2`.`fach` on(`lehrerbewertungsdatenbank2`.`fragebogen`.`fachid` = `lehrerbewertungsdatenbank2`.`fach`.`id`)) group by `lehrerbewertungsdatenbank2`.`fragen`.`frage`,`lehrerbewertungsdatenbank2`.`fragen`.`kategorie`,`lehrerbewertungsdatenbank2`.`fragen`.`id`,`lehrerbewertungsdatenbank2`.`nm_frage_fragebogen`.`bogenid`,`lehrerbewertungsdatenbank2`.`fragebogen`.`zeitstempel`,`lehrerbewertungsdatenbank2`.`fragebogen`.`name`,`lehrerbewertungsdatenbank2`.`fragebogen`.`klassename`,`lehrerbewertungsdatenbank2`.`fach`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getfragebogen`
--
DROP TABLE IF EXISTS `getfragebogen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfragebogen`  AS  select `fragebogen`.`id` AS `id`,`fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`name` AS `name`,`fach`.`name` AS `fach`,`fragebogen`.`klassename` AS `klassename`,`fragebogen`.`schueleranzahl` AS `schueleranzahl`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) ;

-- --------------------------------------------------------

--
-- Struktur des Views `getfragenanzahl`
--
DROP TABLE IF EXISTS `getfragenanzahl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfragenanzahl`  AS  select count(`nm_frage_fragebogen`.`frageid`) AS `count(nm_frage_fragebogen.frageid)`,`fragebogen`.`id` AS `id`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `nm_frage_fragebogen` on(`fragebogen`.`id` = `nm_frage_fragebogen`.`bogenid`)) group by `fragebogen`.`id` ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bewertungen`
--
ALTER TABLE `bewertungen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `frageid` (`frageid`),
  ADD KEY `bogenid` (`bogenid`);

--
-- Indizes für die Tabelle `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`codehash`),
  ADD KEY `fragebogenid` (`fragebogenid`);

--
-- Indizes für die Tabelle `fach`
--
ALTER TABLE `fach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indizes für die Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `klassename` (`klassename`),
  ADD KEY `fachid` (`fachid`),
  ADD KEY `lehrerid` (`lehrerid`);

--
-- Indizes für die Tabelle `fragen`
--
ALTER TABLE `fragen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lehrerid` (`lehrerid`);

--
-- Indizes für die Tabelle `klasse`
--
ALTER TABLE `klasse`
  ADD PRIMARY KEY (`name`);

--
-- Indizes für die Tabelle `lehrer`
--
ALTER TABLE `lehrer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indizes für die Tabelle `nm_frage_fragebogen`
--
ALTER TABLE `nm_frage_fragebogen`
  ADD UNIQUE KEY `frageid` (`frageid`,`bogenid`),
  ADD KEY `bogenid` (`bogenid`);

--
-- Indizes für die Tabelle `nm_lehrer_klasse`
--
ALTER TABLE `nm_lehrer_klasse`
  ADD KEY `lehrerid` (`lehrerid`),
  ADD KEY `klassename` (`klassename`),
  ADD KEY `fachid` (`fachid`);

--
-- Indizes für die Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `bogenid` (`bogenid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bewertungen`
--
ALTER TABLE `bewertungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT für Tabelle `lehrer`
--
ALTER TABLE `lehrer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bewertungen`
--
ALTER TABLE `bewertungen`
  ADD CONSTRAINT `bewertungen_ibfk_1` FOREIGN KEY (`frageid`) REFERENCES `fragen` (`id`),
  ADD CONSTRAINT `bewertungen_ibfk_2` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);

--
-- Constraints der Tabelle `codes`
--
ALTER TABLE `codes`
  ADD CONSTRAINT `codes_ibfk_1` FOREIGN KEY (`fragebogenid`) REFERENCES `fragebogen` (`id`);

--
-- Constraints der Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  ADD CONSTRAINT `fragebogen_ibfk_1` FOREIGN KEY (`klassename`) REFERENCES `klasse` (`name`),
  ADD CONSTRAINT `fragebogen_ibfk_2` FOREIGN KEY (`fachid`) REFERENCES `fach` (`id`),
  ADD CONSTRAINT `fragebogen_ibfk_3` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`);

--
-- Constraints der Tabelle `fragen`
--
ALTER TABLE `fragen`
  ADD CONSTRAINT `fragen_ibfk_1` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`);

--
-- Constraints der Tabelle `nm_frage_fragebogen`
--
ALTER TABLE `nm_frage_fragebogen`
  ADD CONSTRAINT `nm_frage_fragebogen_ibfk_1` FOREIGN KEY (`frageid`) REFERENCES `fragen` (`id`),
  ADD CONSTRAINT `nm_frage_fragebogen_ibfk_2` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);

--
-- Constraints der Tabelle `nm_lehrer_klasse`
--
ALTER TABLE `nm_lehrer_klasse`
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_1` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_2` FOREIGN KEY (`klassename`) REFERENCES `klasse` (`name`),
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_3` FOREIGN KEY (`fachid`) REFERENCES `fach` (`id`);

--
-- Constraints der Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  ADD CONSTRAINT `verbesserungen_ibfk_1` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
