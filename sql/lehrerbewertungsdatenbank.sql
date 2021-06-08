-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Jun 2021 um 17:57
-- Server-Version: 10.4.14-MariaDB
-- PHP-Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `fragebogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `codes`
--

INSERT INTO `codes` (`codehash`, `fragebogenid`) VALUES
('25-44-42-03', 70),
('61-45-30-52', 70),
('63-73-28-35', 70),
('68-51-74-14', 70),
('71-81-13-06', 70),
('75-63-90-56', 70),
('94-23-66-34', 70),
('98-74-40-44', 70),
('99-88-77-66', 70);

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
(83, '2021-05-27 15:48:00', 'BogenX', 1, 1, 'ITB1-19', 1);

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
,`id` bigint(20) unsigned
,`bogenid` bigint(20) unsigned
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
(7, 70),
(35, 70);

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

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragen`.`frage` AS `frage`,`fragen`.`id` AS `id`,`nm_frage_fragebogen`.`bogenid` AS `bogenid` from (`nm_frage_fragebogen` left join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) ;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

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
