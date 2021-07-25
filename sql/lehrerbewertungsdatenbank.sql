-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Jul 2021 um 11:23
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
(19, 7, 112, -1),
(20, 35, 112, 2),
(21, 7, 112, 2),
(22, 35, 112, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `codes`
--

CREATE TABLE `codes` (
  `codehash` varchar(16) NOT NULL,
  `fragebogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `codes`
--

INSERT INTO `codes` (`codehash`, `fragebogenid`) VALUES
('01-63-94-02', 110),
('04-26-19-99', 110),
('07-65-59-64', 110),
('12-37-73-84', 110),
('13-43-03-27', 110),
('15-20-37-15', 110),
('17-29-84-02', 110),
('19-44-31-02', 110),
('20-61-06-00', 110),
('25-24-33-42', 110),
('31-03-96-77', 110),
('31-16-55-43', 110),
('34-92-05-81', 110),
('35-95-94-03', 110),
('40-55-89-06', 110),
('47-45-12-62', 110),
('58-00-64-93', 110),
('58-46-03-61', 110),
('60-51-06-06', 110),
('62-79-67-65', 110),
('64-61-82-60', 110),
('75-53-43-88', 110),
('78-22-63-33', 110),
('92-35-34-40', 110),
('99-48-03-71', 110),
('07-31-84-80', 111),
('14-43-54-22', 111),
('16-34-35-20', 111),
('22-03-53-93', 111),
('39-33-25-85', 111),
('43-74-31-58', 111),
('44-72-16-81', 111),
('48-64-05-40', 111),
('75-05-13-32', 111),
('91-87-30-53', 111),
('04-65-14-39', 112),
('06-68-81-43', 112),
('08-39-58-09', 112),
('15-42-36-29', 112),
('21-61-61-53', 112),
('23-01-34-44', 112),
('27-41-16-88', 112),
('32-96-26-82', 112),
('33-24-29-04', 112),
('34-29-93-90', 112),
('34-46-93-29', 112),
('35-78-29-25', 112),
('36-56-10-84', 112),
('37-78-33-59', 112),
('43-20-61-80', 112),
('47-56-97-96', 112),
('49-16-11-20', 112),
('49-19-66-69', 112),
('51-78-49-05', 112),
('53-92-12-76', 112),
('64-21-09-79', 112),
('68-65-33-64', 112),
('70-96-99-46', 112),
('73-95-07-57', 112),
('74-09-51-34', 112),
('88-49-25-93', 112),
('88-56-88-67', 112),
('99-29-21-26', 112),
('02-16-34-60', 113),
('03-51-23-14', 113),
('06-43-17-49', 113),
('10-56-68-87', 113),
('11-70-39-18', 113),
('12-95-43-49', 113),
('20-23-78-36', 113),
('22-04-68-45', 113),
('29-53-73-39', 113),
('40-29-98-51', 113),
('41-84-27-69', 113),
('44-79-16-22', 113),
('44-89-76-60', 113),
('46-52-36-25', 113),
('49-21-81-05', 113),
('54-86-17-65', 113),
('60-34-81-37', 113),
('60-68-56-24', 113),
('61-44-57-83', 113),
('77-48-55-93', 113),
('81-81-22-38', 113),
('84-73-18-41', 113),
('89-49-18-15', 113),
('90-77-84-06', 113),
('96-98-01-27', 113),
('02-50-43-63', 114),
('05-73-28-95', 114),
('06-16-93-82', 114),
('06-19-51-25', 114),
('07-62-49-25', 114),
('09-44-01-63', 114),
('09-44-86-71', 114),
('10-44-47-69', 114),
('24-54-14-35', 114),
('34-37-99-63', 114),
('49-96-44-16', 114),
('50-10-97-95', 114),
('52-84-22-79', 114),
('53-83-92-44', 114),
('56-08-05-13', 114),
('56-49-61-69', 114),
('58-68-80-27', 114),
('63-20-88-59', 114),
('71-09-65-31', 114),
('81-70-52-36', 114),
('83-56-48-01', 114),
('85-70-21-60', 114),
('86-05-84-12', 114),
('88-22-41-92', 114),
('96-92-40-83', 114),
('01-42-32-94', 115),
('08-41-92-10', 115),
('08-85-22-53', 115),
('19-84-74-58', 115),
('23-72-59-81', 115),
('25-41-47-24', 115),
('33-22-20-85', 115),
('35-22-28-43', 115),
('35-54-74-58', 115),
('41-93-35-50', 115),
('42-25-40-06', 115),
('42-25-60-44', 115),
('43-60-84-61', 115),
('45-36-20-23', 115),
('49-06-20-57', 115),
('55-25-69-41', 115),
('56-21-30-53', 115),
('61-92-34-41', 115),
('62-63-81-58', 115),
('66-38-08-38', 115),
('71-09-95-73', 115),
('72-80-48-07', 115),
('75-42-50-51', 115),
('81-86-39-28', 115),
('86-61-17-99', 115),
('86-97-05-15', 115),
('93-30-48-88', 115),
('98-88-40-09', 115),
('07-32-36-36', 116),
('08-00-12-06', 116),
('09-36-69-47', 116),
('14-06-80-71', 116),
('28-20-61-06', 116),
('31-60-34-94', 116),
('33-78-08-64', 116),
('42-39-38-56', 116),
('42-55-94-96', 116),
('45-24-13-52', 116),
('49-58-88-93', 116),
('53-15-50-80', 116),
('61-31-74-34', 116),
('65-11-74-91', 116),
('67-24-77-66', 116),
('68-23-58-11', 116),
('76-21-07-81', 116),
('76-66-99-19', 116),
('84-85-92-56', 116),
('85-03-96-24', 116),
('86-55-30-03', 116),
('88-45-88-21', 116),
('95-31-09-58', 116),
('96-48-29-13', 116),
('96-58-16-76', 116),
('11-86-42-43', 117),
('21-87-42-01', 117),
('25-17-14-91', 117),
('31-40-41-46', 117),
('31-95-55-86', 117),
('32-62-47-64', 117),
('34-63-45-75', 117),
('37-53-62-14', 117),
('42-81-11-81', 117),
('43-12-46-36', 117),
('44-34-93-85', 117),
('59-01-96-38', 117),
('59-10-82-20', 117),
('62-19-31-54', 117),
('68-16-43-08', 117),
('69-79-64-51', 117),
('85-65-49-64', 117),
('87-38-76-39', 117),
('94-46-97-15', 117),
('97-25-15-41', 117),
('97-61-96-16', 117),
('97-65-91-47', 117),
('98-44-56-58', 117),
('01-22-82-94', 118),
('01-85-18-71', 118),
('02-07-29-38', 118),
('03-30-69-04', 118),
('05-73-12-22', 118),
('06-68-52-09', 118),
('12-89-84-75', 118),
('13-92-56-26', 118),
('14-93-43-23', 118),
('17-85-07-30', 118),
('29-39-57-94', 118),
('35-29-81-04', 118),
('35-88-09-31', 118),
('45-05-94-28', 118),
('46-77-83-49', 118),
('46-87-58-81', 118),
('50-22-19-96', 118),
('50-78-32-79', 118),
('51-78-39-35', 118),
('59-97-22-93', 118),
('75-41-50-76', 118),
('81-20-75-75', 118),
('92-68-87-57', 118),
('92-72-53-15', 118),
('96-21-94-33', 118);

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
(1, 'ITS'),
(2, 'AWE'),
(3, 'FKO');

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
(109, '2021-07-18 10:16:50', 'BogenX', 1, 1, 'ITB1-19', 25),
(110, '2021-07-18 10:18:38', 'BogenY', 1, 1, 'ITB1-19', 25),
(111, '2021-07-18 11:34:23', 'BogenZ', 1, 1, 'ITB1-19', 10),
(112, '2021-07-19 16:50:39', 'Test-Bogen0', 1, 1, 'ITB1-20', 28),
(113, '2021-07-19 17:03:24', 'Test-Bogen1', 1, 1, 'ITB1-20', 25),
(114, '2021-07-19 18:34:05', 'ghjkgkjhgkj', 1, 1, 'ITB1-20', 25),
(115, '2021-07-19 18:36:54', 'BogenBla', 1, 1, 'ITB1-19', 28),
(116, '2021-07-19 20:03:39', 'AWE-Bogen', 1, 2, 'ITB1-20', 25),
(117, '2021-07-19 20:05:04', 'AWE-Noch ein Bogen', 1, 2, 'ITB1-19', 23),
(118, '2021-07-19 20:15:29', 'FKO-Bogen', 1, 3, 'ITB1-19', 25);

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
(128, 'asdfsa', 1, 'Unterricht'),
(129, 't87ztooiz', NULL, 'Unterricht'),
(130, '454', NULL, 'Unterricht'),
(131, 'ilgklghlglh', 1, 'Unterricht');

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
('ITB1-19', 30),
('ITB1-20', 28);

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
(1, 109),
(1, 111),
(1, 112),
(1, 113),
(1, 114),
(1, 116),
(1, 117),
(1, 118),
(2, 109),
(2, 111),
(2, 112),
(2, 113),
(2, 114),
(2, 115),
(2, 116),
(2, 117),
(2, 118),
(3, 109),
(3, 111),
(3, 112),
(3, 113),
(3, 114),
(3, 115),
(3, 116),
(3, 117),
(3, 118),
(4, 109),
(4, 111),
(4, 112),
(4, 113),
(4, 114),
(4, 115),
(4, 116),
(4, 117),
(4, 118),
(5, 109),
(5, 111),
(5, 112),
(5, 113),
(5, 114),
(5, 115),
(5, 116),
(5, 117),
(5, 118),
(6, 109),
(6, 111),
(6, 112),
(6, 113),
(6, 114),
(6, 115),
(6, 116),
(6, 117),
(6, 118),
(7, 109),
(7, 111),
(7, 112),
(7, 113),
(7, 114),
(7, 115),
(7, 116),
(7, 117),
(7, 118),
(8, 109),
(8, 111),
(8, 112),
(8, 113),
(8, 114),
(8, 116),
(8, 117),
(8, 118),
(9, 109),
(9, 111),
(9, 112),
(9, 113),
(9, 114),
(9, 116),
(9, 117),
(9, 118),
(10, 109),
(10, 111),
(10, 112),
(10, 113),
(10, 114),
(10, 116),
(10, 117),
(10, 118),
(11, 109),
(11, 111),
(11, 112),
(11, 113),
(11, 114),
(11, 116),
(11, 117),
(11, 118),
(12, 109),
(12, 112),
(12, 113),
(12, 114),
(12, 115),
(12, 116),
(12, 117),
(12, 118),
(13, 109),
(13, 112),
(13, 113),
(13, 114),
(13, 115),
(13, 116),
(13, 117),
(13, 118),
(14, 109),
(14, 112),
(14, 113),
(14, 114),
(14, 115),
(14, 116),
(14, 117),
(14, 118),
(15, 109),
(15, 112),
(15, 113),
(15, 114),
(15, 115),
(15, 116),
(15, 117),
(15, 118),
(16, 109),
(16, 112),
(16, 113),
(16, 114),
(16, 115),
(16, 116),
(16, 117),
(16, 118),
(17, 109),
(17, 111),
(17, 112),
(17, 113),
(17, 114),
(17, 115),
(17, 116),
(17, 117),
(17, 118),
(18, 109),
(18, 111),
(18, 112),
(18, 113),
(18, 114),
(18, 115),
(18, 116),
(18, 117),
(18, 118),
(19, 109),
(19, 111),
(19, 112),
(19, 113),
(19, 114),
(19, 115),
(19, 116),
(19, 117),
(19, 118),
(20, 109),
(20, 111),
(20, 112),
(20, 113),
(20, 114),
(20, 115),
(20, 116),
(20, 117),
(20, 118),
(21, 109),
(21, 112),
(21, 113),
(21, 114),
(21, 115),
(21, 116),
(21, 117),
(21, 118),
(22, 109),
(22, 111),
(22, 112),
(22, 113),
(22, 114),
(22, 115),
(22, 116),
(22, 117),
(22, 118),
(23, 109),
(23, 111),
(23, 112),
(23, 113),
(23, 114),
(23, 115),
(23, 116),
(23, 117),
(23, 118),
(24, 109),
(24, 111),
(24, 112),
(24, 113),
(24, 114),
(24, 115),
(24, 116),
(24, 117),
(24, 118),
(25, 109),
(25, 111),
(25, 112),
(25, 113),
(25, 114),
(25, 115),
(25, 116),
(25, 117),
(25, 118),
(26, 109),
(26, 111),
(26, 112),
(26, 113),
(26, 114),
(26, 115),
(26, 116),
(26, 117),
(26, 118),
(27, 109),
(27, 111),
(27, 112),
(27, 113),
(27, 114),
(27, 115),
(27, 116),
(27, 117),
(27, 118),
(28, 109),
(28, 111),
(28, 112),
(28, 113),
(28, 114),
(28, 115),
(28, 116),
(28, 117),
(28, 118),
(29, 109),
(29, 111),
(29, 112),
(29, 113),
(29, 114),
(29, 115),
(29, 116),
(29, 117),
(29, 118),
(30, 109),
(30, 111),
(30, 112),
(30, 113),
(30, 114),
(30, 115),
(30, 116),
(30, 117),
(30, 118),
(31, 109),
(31, 111),
(31, 112),
(31, 113),
(31, 114),
(31, 115),
(31, 116),
(31, 117),
(31, 118),
(32, 109),
(32, 111),
(32, 112),
(32, 113),
(32, 114),
(32, 115),
(32, 116),
(32, 117),
(32, 118),
(33, 109),
(33, 111),
(33, 112),
(33, 113),
(33, 114),
(33, 115),
(33, 116),
(33, 117),
(33, 118),
(34, 109),
(34, 111),
(34, 112),
(34, 113),
(34, 114),
(34, 115),
(34, 116),
(34, 117),
(34, 118),
(35, 109),
(35, 111),
(35, 112),
(35, 113),
(35, 114),
(35, 115),
(35, 116),
(35, 117),
(35, 118),
(36, 109),
(36, 111),
(36, 112),
(36, 113),
(36, 114),
(36, 115),
(36, 116),
(36, 117),
(36, 118),
(37, 109),
(37, 111),
(37, 112),
(37, 113),
(37, 114),
(37, 115),
(37, 116),
(37, 117),
(37, 118),
(38, 109),
(38, 111),
(38, 112),
(38, 113),
(38, 114),
(38, 115),
(38, 116),
(38, 117),
(38, 118),
(112, 110),
(112, 111),
(112, 112),
(112, 114),
(112, 115),
(112, 116),
(112, 118),
(113, 110),
(113, 111),
(113, 112),
(113, 114),
(113, 116),
(113, 118),
(114, 110),
(114, 111),
(114, 112),
(114, 114),
(114, 116),
(114, 118),
(115, 110),
(115, 111),
(115, 112),
(115, 114),
(115, 116),
(115, 118),
(116, 110),
(116, 111),
(116, 112),
(116, 114),
(116, 115),
(116, 116),
(116, 118),
(117, 110),
(117, 111),
(117, 112),
(117, 114),
(117, 115),
(117, 116),
(117, 118),
(118, 110),
(118, 111),
(118, 112),
(118, 114),
(118, 115),
(118, 116),
(118, 118),
(119, 110),
(119, 111),
(119, 112),
(119, 114),
(119, 115),
(119, 116),
(119, 118),
(120, 110),
(120, 111),
(120, 112),
(120, 114),
(120, 115),
(120, 116),
(120, 118),
(121, 110),
(121, 111),
(121, 112),
(121, 114),
(121, 115),
(121, 116),
(121, 118),
(122, 110),
(122, 111),
(122, 112),
(122, 114),
(122, 115),
(122, 116),
(122, 118),
(123, 110),
(123, 111),
(123, 112),
(123, 114),
(123, 115),
(123, 116),
(123, 118),
(124, 110),
(124, 111),
(124, 112),
(124, 114),
(124, 115),
(124, 116),
(124, 118),
(125, 110),
(125, 111),
(125, 112),
(125, 114),
(125, 115),
(125, 116),
(125, 118),
(126, 110),
(126, 111),
(126, 112),
(126, 114),
(126, 115),
(126, 116),
(126, 118),
(127, 110),
(127, 111),
(127, 112),
(127, 114),
(127, 115),
(127, 116),
(127, 118),
(128, 110),
(128, 111),
(128, 112),
(128, 114),
(128, 115),
(128, 116),
(128, 118),
(129, 110),
(129, 111),
(129, 112),
(129, 114),
(129, 115),
(129, 116),
(129, 118),
(130, 110),
(130, 111),
(130, 112),
(130, 114),
(130, 115),
(130, 116),
(130, 118),
(131, 110),
(131, 111),
(131, 112),
(131, 114),
(131, 115),
(131, 116),
(131, 118);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragen`.`frage` AS `frage`,`fragen`.`kategorie` AS `kategorie`,`fragen`.`id` AS `frageid`,`nm_frage_fragebogen`.`bogenid` AS `bogenid`,avg(`bewertungen`.`bewertung`) AS `bewertung`,`fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`name` AS `thema`,`fragebogen`.`klassename` AS `klassename`,`fach`.`name` AS `fachname` from ((((`nm_frage_fragebogen` left join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) left join `bewertungen` on(`fragen`.`id` = `bewertungen`.`frageid`)) left join `fragebogen` on(`nm_frage_fragebogen`.`bogenid` = `fragebogen`.`id`)) left join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) group by `fragen`.`frage`,`fragen`.`kategorie`,`fragen`.`id`,`nm_frage_fragebogen`.`bogenid`,`fragebogen`.`zeitstempel`,`fragebogen`.`name`,`fragebogen`.`klassename`,`fach`.`name` ;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

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
