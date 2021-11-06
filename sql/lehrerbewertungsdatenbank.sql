-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Sep 2021 um 10:58
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
CREATE DATABASE IF NOT EXISTS `lehrerbewertungsdatenbank` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lehrerbewertungsdatenbank`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bewertungen`
--

DROP TABLE IF EXISTS `bewertungen`;
CREATE TABLE `bewertungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `bewertung` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `codes`
--

DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `codehash` varchar(16) NOT NULL,
  `fragebogenid` bigint(20) UNSIGNED NOT NULL,
  `kritik` tinyint(1) NOT NULL DEFAULT 0,
  `bewertung` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

DROP TABLE IF EXISTS `fach`;
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

DROP TABLE IF EXISTS `fragebogen`;
CREATE TABLE `fragebogen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zeitstempel` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED NOT NULL,
  `fachid` bigint(20) UNSIGNED NOT NULL,
  `klassename` varchar(32) NOT NULL,
  `schueleranzahl` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragen`
--

DROP TABLE IF EXISTS `fragen`;
CREATE TABLE `fragen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frage` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED DEFAULT NULL,
  `kategorie` varchar(255) NOT NULL,
  `softdelete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fragen`
--

INSERT INTO `fragen` (`id`, `frage`, `lehrerid`, `kategorie`, `softdelete`) VALUES
(1, 'Der Unterricht ist gut vorbereitet und sorgfaltig geplant.', 1, 'Unterricht', 0),
(2, 'Die Interessen der Schüler werden bei der Unterrichtsplanung berücksichtigt.', 1, 'Unterricht', 0),
(3, 'Die Arbeitsanweisungen sind klar verständlich.', 1, 'Unterricht', 0),
(4, 'Die Arbeitsmaterialien sind übersichtlich und ordentlich aufbereitet.', 1, 'Unterricht', 0),
(5, 'Gruppen- und Einzelarbeiten der Schüler werden abwechslungsreich eingesetzt.', 1, 'Unterricht', 0),
(6, 'Im Unterricht werden Bezüge zu aktuellen Themen hergestellt.', 1, 'Unterricht', 0),
(7, 'Die Unterrichtsinhalte sind praxisbezogen.', 1, 'Unterricht', 0),
(8, 'Praxisbezug wird durch Kontakte zu Betrieben und anderen außerschulichen Einrichtungen gewährleistet.', 1, 'Unterricht', 0),
(9, 'Die Zusammenarbeit bzw. Absprache zwischen Schule und Betrieben ist angemessen.', 1, 'Unterricht', 0),
(10, 'Der Unterricht enthalt ausreichend Übungsphasen Unterrichtsergebnisse werden schriftlich festgehalten.', 1, 'Unterricht', 0),
(11, 'Tafelbilder und Folien sind gut lesbar.', 1, 'Unterricht', 0),
(12, 'Das Arbeitsklima ermuntert die Schüler zur aktiven Unterrichtsbeteiligung.', 1, 'Arbeitsklima', 0),
(13, 'Es herrscht ein Arbeitsklima, in dem auch Fehler und abweichende Meinungen zugelassen werden.', 1, 'Arbeitsklima', 0),
(14, 'Man traut sich, Fragen zu stellen.', 1, 'Arbeitsklima', 0),
(15, 'Man fühlt sich ernst genommen.', 1, 'Arbeitsklima', 0),
(16, 'Die Schüler erscheinen pünktlich zum Unterricht.', 1, 'Arbeitsklima', 0),
(17, 'Die Schüler entschuldigen ihre Fehlzelten rechtzeitig und angemessen.', 1, 'Arbeitsklima', 0),
(18, 'Die Schüler beteiligen sich angemessen im Unterricht.', 1, 'Arbeitsklima', 0),
(19, 'Die Schüler bearbeiten die Aufgaben im Unterricht konzentriert.', 1, 'Arbeitsklima', 0),
(20, 'Die Schüler erledigen ihre Hausaufgaben zuverlässig.', 1, 'Arbeitsklima', 0),
(21, 'Die Schüler verhalten sich im Unterricht ruhig.', 1, 'Arbeitsklima', 0),
(22, 'Unter den Schülern herrschte Fairness.', 1, 'Arbeitsklima', 0),
(23, 'Einzelne Schüler wurden verbal oder mit anderen Mittel von ihren Mitschülern herabgesetzt.', 1, 'Arbeitsklima', 0),
(24, 'Der Umgang der Schüler untereinander ist ehrlich und aufrichtig.', 1, 'Arbeitsklima', 0),
(25, 'Er ist freundlich und geduldig.', 1, 'Lehrer', 0),
(26, 'Er erklärt Unterrichtsinhalte anhand von Beispielen.', 1, 'Lehrer', 0),
(27, 'Er lobt Schüler und ermutigt sie.', 1, 'Lehrer', 0),
(28, 'Er lässt Kritik zu und geht darauf ein.', 1, 'Lehrer', 0),
(29, 'Er fördert selbstständiges Denken und Arbeiten.', 1, 'Lehrer', 0),
(30, 'Er nimmt Ideen der Schüler auf und blockt diese nicht ab.', 1, 'Lehrer', 0),
(31, 'Die Klassenarbeiten entsprechen dem behandelten Stoff.', 1, 'Leistungsbewertung', 0),
(32, 'Die Klassenarbeiten verlangen mehr als nur Auswendiglernen.', 1, 'Leistungsbewertung', 0),
(33, 'Die Aufgabenstellungen sind verständlich formuliert.', 1, 'Leistungsbewertung', 0),
(34, 'Die Klassenarbeiten werden fair benotet.', 1, 'Leistungsbewertung', 0),
(35, 'Die Beurteilungskriterien sind nachvollziehbar.', 1, 'Leistungsbewertung', 0),
(36, 'Die Schüler erhalten ausreichend Gelegenheit, sich im Rahmen der sonstigen Mitarbeit zu engagieren.', 1, 'Leistungsbewertung', 0),
(37, 'Die sonstige Mitarbeit fließt angemessen in die Gesamtnote ein.', 1, 'Leistungsbewertung', 0),
(38, 'Die Beurteilung ist gerecht, weil alle Schüler gleich behandelt werden.', 1, 'Leistungsbewertung', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragentemplate`
--

DROP TABLE IF EXISTS `fragentemplate`;
CREATE TABLE `fragentemplate` (
  `frage` varchar(255) NOT NULL,
  `kategorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fragentemplate`
--

INSERT INTO `fragentemplate` (`frage`, `kategorie`) VALUES
('Das Arbeitsklima ermuntert die Schüler zur aktiven Unterrichtsbeteiligung.', 'Arbeitsklima'),
('Der Umgang der Schüler untereinander ist ehrlich und aufrichtig.', 'Arbeitsklima'),
('Der Unterricht enthalt ausreichend Übungsphasen Unterrichtsergebnisse werden schriftlich festgehalten.', 'Unterricht'),
('Der Unterricht ist gut vorbereitet und sorgfaltig geplant.', 'Unterricht'),
('Die Arbeitsanweisungen sind klar verständlich.', 'Unterricht'),
('Die Arbeitsmaterialien sind übersichtlich und ordentlich aufbereitet.', 'Unterricht'),
('Die Aufgabenstellungen sind verständlich formuliert.', 'Leistungsbewertung'),
('Die Beurteilung ist gerecht, weil alle Schüler gleich behandelt werden.', 'Leistungsbewertung'),
('Die Beurteilungskriterien sind nachvollziehbar.', 'Leistungsbewertung'),
('Die Interessen der Schüler werden bei der Unterrichtsplanung berücksichtigt.', 'Unterricht'),
('Die Klassenarbeiten entsprechen dem behandelten Stoff.', 'Leistungsbewertung'),
('Die Klassenarbeiten verlangen mehr als nur Auswendiglernen.', 'Leistungsbewertung'),
('Die Klassenarbeiten werden fair benotet.', 'Leistungsbewertung'),
('Die Schüler bearbeiten die Aufgaben im Unterricht konzentriert.', 'Arbeitsklima'),
('Die Schüler beteiligen sich angemessen im Unterricht.', 'Arbeitsklima'),
('Die Schüler entschuldigen ihre Fehlzelten rechtzeitig und angemessen.', 'Arbeitsklima'),
('Die Schüler erhalten ausreichend Gelegenheit, sich im Rahmen der sonstigen Mitarbeit zu engagieren.', 'Leistungsbewertung'),
('Die Schüler erledigen ihre Hausaufgaben zuverlässig.', 'Arbeitsklima'),
('Die Schüler erscheinen pünktlich zum Unterricht.', 'Arbeitsklima'),
('Die Schüler verhalten sich im Unterricht ruhig.', 'Arbeitsklima'),
('Die sonstige Mitarbeit fließt angemessen in die Gesamtnote ein.', 'Leistungsbewertung'),
('Die Unterrichtsinhalte sind praxisbezogen.', 'Unterricht'),
('Die Zusammenarbeit bzw. Absprache zwischen Schule und Betrieben ist angemessen.', 'Unterricht'),
('Einzelne Schüler wurden verbal oder mit anderen Mittel von ihren Mitschülern herabgesetzt.', 'Arbeitsklima'),
('Er erklärt Unterrichtsinhalte anhand von Beispielen.', 'Lehrer'),
('Er fördert selbstständiges Denken und Arbeiten.', 'Lehrer'),
('Er ist freundlich und geduldig.', 'Lehrer'),
('Er lobt Schüler und ermutigt sie.', 'Lehrer'),
('Er lässt Kritik zu und geht darauf ein.', 'Lehrer'),
('Er nimmt Ideen der Schüler auf und blockt diese nicht ab.', 'Lehrer'),
('Es herrscht ein Arbeitsklima, in dem auch Fehler und abweichende Meinungen zugelassen werden.', 'Arbeitsklima'),
('Gruppen- und Einzelarbeiten der Schüler werden abwechslungsreich eingesetzt.', 'Unterricht'),
('Im Unterricht werden Bezüge zu aktuellen Themen hergestellt.', 'Unterricht'),
('Man fühlt sich ernst genommen.', 'Arbeitsklima'),
('Man traut sich, Fragen zu stellen.', 'Arbeitsklima'),
('Praxisbezug wird durch Kontakte zu Betrieben und anderen außerschulichen Einrichtungen gewährleistet.', 'Unterricht'),
('Tafelbilder und Folien sind gut lesbar.', 'Unterricht'),
('Unter den Schülern herrschte Fairness.', 'Arbeitsklima');

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getbewertungen`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `getbewertungen`;
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
DROP VIEW IF EXISTS `getfbfragen`;
CREATE TABLE `getfbfragen` (
`zeitstempel` timestamp
,`bogenid` bigint(20) unsigned
,`thema` varchar(255)
,`klassename` varchar(32)
,`frageid` bigint(20) unsigned
,`frage` varchar(255)
,`kategorie` varchar(255)
,`fachname` varchar(32)
,`bew110` decimal(22,0)
,`bew101` decimal(22,0)
,`bew000` decimal(22,0)
,`bew001` decimal(22,0)
,`bew010` decimal(22,0)
,`bewertung` decimal(27,0)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getfragebogen`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `getfragebogen`;
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
DROP VIEW IF EXISTS `getfragenanzahl`;
CREATE TABLE `getfragenanzahl` (
`count(nm_frage_fragebogen.frageid)` bigint(21)
,`id` bigint(20) unsigned
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getquestions`
-- (Siehe unten für die tatsächliche Ansicht)
--
DROP VIEW IF EXISTS `getquestions`;
CREATE TABLE `getquestions` (
`frage` varchar(255)
,`kategorie` varchar(255)
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `klasse`
--

DROP TABLE IF EXISTS `klasse`;
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

DROP TABLE IF EXISTS `lehrer`;
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

DROP TABLE IF EXISTS `nm_frage_fragebogen`;
CREATE TABLE `nm_frage_fragebogen` (
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nm_lehrer_klasse`
--

DROP TABLE IF EXISTS `nm_lehrer_klasse`;
CREATE TABLE `nm_lehrer_klasse` (
  `lehrerid` bigint(20) UNSIGNED NOT NULL,
  `klassename` varchar(32) NOT NULL,
  `fachid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbesserungen`
--

DROP TABLE IF EXISTS `verbesserungen`;
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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`id` AS `bogenid`,`fragebogen`.`name` AS `thema`,`fragebogen`.`klassename` AS `klassename`,`fragen`.`id` AS `frageid`,`fragen`.`frage` AS `frage`,`fragen`.`kategorie` AS `kategorie`,`fach`.`name` AS `fachname`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) AS `bew110`,sum(if(`bewertungen`.`bewertung` = -1,1,0)) AS `bew101`,sum(if(`bewertungen`.`bewertung` = 0,1,0)) AS `bew000`,sum(if(`bewertungen`.`bewertung` = 1,1,0)) AS `bew001`,sum(if(`bewertungen`.`bewertung` = 2,1,0)) AS `bew010`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) * -2 + sum(if(`bewertungen`.`bewertung` = -1,1,0)) * -1 + sum(if(`bewertungen`.`bewertung` = 0,1,0)) * 0 + sum(if(`bewertungen`.`bewertung` = 1,1,0)) * 1 + sum(if(`bewertungen`.`bewertung` = 2,1,0)) * 2 AS `bewertung` from ((((`nm_frage_fragebogen` join `fragebogen` on(`fragebogen`.`id` = `nm_frage_fragebogen`.`bogenid`)) join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) left join `bewertungen` on(`nm_frage_fragebogen`.`frageid` = `bewertungen`.`frageid` and `nm_frage_fragebogen`.`bogenid` = `bewertungen`.`bogenid`)) group by `fragen`.`id`,`fragebogen`.`id` ;

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

-- --------------------------------------------------------

--
-- Struktur des Views `getquestions`
--
DROP TABLE IF EXISTS `getquestions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getquestions`  AS  select `fragen`.`frage` AS `frage`,`fragen`.`kategorie` AS `kategorie`,`lehrer`.`mail` AS `mail` from (`fragen` join `lehrer` on(`fragen`.`lehrerid` = `lehrer`.`id`)) where `fragen`.`softdelete` is false ;

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
-- Indizes für die Tabelle `fragentemplate`
--
ALTER TABLE `fragentemplate`
  ADD PRIMARY KEY (`frage`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT für Tabelle `lehrer`
--
ALTER TABLE `lehrer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
