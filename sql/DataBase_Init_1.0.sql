-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 28. Jan 2022 um 12:54
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

CREATE TABLE `bewertungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `bewertung` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `description`) VALUES
(1, 'Arbeitsklima'),
(2, 'Lehrer'),
(3, 'Leistungsbewertung'),
(4, 'Unterricht');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `codes`
--

CREATE TABLE `codes` (
  `codehash` varchar(16) NOT NULL,
  `fragebogenid` bigint(20) UNSIGNED NOT NULL,
  `kritik` tinyint(1) NOT NULL DEFAULT 0,
  `bewertung` tinyint(1) NOT NULL DEFAULT 0,
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

CREATE TABLE `fach` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'subject id',
  `name` varchar(32) NOT NULL COMMENT 'name of the subject',
  `softdelete` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag for deletation'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragen`
--

CREATE TABLE `fragen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frage` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED DEFAULT NULL,
  `kategorie` bigint(20) UNSIGNED NOT NULL,
  `softdelete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragentemplate`
--

CREATE TABLE `fragentemplate` (
  `frage` varchar(255) NOT NULL,
  `kategorie` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `fragentemplate`
--

INSERT INTO `fragentemplate` (`frage`, `kategorie`) VALUES
('Das Arbeitsklima ermuntert die Schüler zur aktiven Unterrichtsbeteiligung.', 1),
('Der Umgang der Schüler untereinander ist ehrlich und aufrichtig.', 1),
('Die Schüler bearbeiten die Aufgaben im Unterricht konzentriert.', 1),
('Die Schüler beteiligen sich angemessen im Unterricht.', 1),
('Die Schüler entschuldigen ihre Fehlzelten rechtzeitig und angemessen.', 1),
('Die Schüler erledigen ihre Hausaufgaben zuverlässig.', 1),
('Die Schüler erscheinen pünktlich zum Unterricht.', 1),
('Die Schüler verhalten sich im Unterricht ruhig.', 1),
('Einzelne Schüler wurden verbal oder mit anderen Mittel von ihren Mitschülern herabgesetzt.', 1),
('Es herrscht ein Arbeitsklima, in dem auch Fehler und abweichende Meinungen zugelassen werden.', 1),
('Man fühlt sich ernst genommen.', 1),
('Man traut sich, Fragen zu stellen.', 1),
('Unter den Schülern herrschte Fairness.', 1),
('Er erklärt Unterrichtsinhalte anhand von Beispielen.', 2),
('Er fördert selbstständiges Denken und Arbeiten.', 2),
('Er ist freundlich und geduldig.', 2),
('Er lobt Schüler und ermutigt sie.', 2),
('Er lässt Kritik zu und geht darauf ein.', 2),
('Er nimmt Ideen der Schüler auf und blockt diese nicht ab.', 2),
('Die Aufgabenstellungen sind verständlich formuliert.', 3),
('Die Beurteilung ist gerecht, weil alle Schüler gleich behandelt werden.', 3),
('Die Beurteilungskriterien sind nachvollziehbar.', 3),
('Die Klassenarbeiten entsprechen dem behandelten Stoff.', 3),
('Die Klassenarbeiten verlangen mehr als nur Auswendiglernen.', 3),
('Die Klassenarbeiten werden fair benotet.', 3),
('Die Schüler erhalten ausreichend Gelegenheit, sich im Rahmen der sonstigen Mitarbeit zu engagieren.', 3),
('Die sonstige Mitarbeit fließt angemessen in die Gesamtnote ein.', 3),
('Der Unterricht enthalt ausreichend Übungsphasen Unterrichtsergebnisse werden schriftlich festgehalten.', 4),
('Der Unterricht ist gut vorbereitet und sorgfaltig geplant.', 4),
('Die Arbeitsanweisungen sind klar verständlich.', 4),
('Die Arbeitsmaterialien sind übersichtlich und ordentlich aufbereitet.', 4),
('Die Interessen der Schüler werden bei der Unterrichtsplanung berücksichtigt.', 4),
('Die Unterrichtsinhalte sind praxisbezogen.', 4),
('Die Zusammenarbeit bzw. Absprache zwischen Schule und Betrieben ist angemessen.', 4),
('Gruppen- und Einzelarbeiten der Schüler werden abwechslungsreich eingesetzt.', 4),
('Im Unterricht werden Bezüge zu aktuellen Themen hergestellt.', 4),
('Praxisbezug wird durch Kontakte zu Betrieben und anderen außerschulichen Einrichtungen gewährleistet.', 4),
('Tafelbilder und Folien sind gut lesbar.', 4);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getallcategories`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getallcategories` (
`kategorie` text
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getallclasses`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getallclasses` (
`name` varchar(32)
,`softdelete` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getallsubjects`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getallsubjects` (
`name` varchar(32)
,`softdelete` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getalluser`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getalluser` (
`mail` varchar(255)
,`isroot` tinyint(1)
,`creationdate` timestamp
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getaskallquestions`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getaskallquestions` (
`id` bigint(20) unsigned
,`username` varchar(255)
,`frage` varchar(255)
,`kategorie` text
,`softdelete` tinyint(1)
);

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
-- Stellvertreter-Struktur des Views `getcodesinfo`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getcodesinfo` (
`codehash` varchar(16)
,`kritik` tinyint(1)
,`bewertung` tinyint(1)
,`fragebogenid` bigint(20) unsigned
,`creationdate` timestamp
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getfbfragen`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getfbfragen` (
`zeitstempel` timestamp
,`bogenid` bigint(20) unsigned
,`thema` varchar(255)
,`klassename` varchar(32)
,`frageid` bigint(20) unsigned
,`frage` varchar(255)
,`kategorie` text
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
-- Stellvertreter-Struktur des Views `getkritik`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getkritik` (
`vorschlag` text
,`bogenid` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getquestions`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getquestions` (
`frage` varchar(255)
,`kategorie` text
,`mail` varchar(255)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getuserhistorie`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `getuserhistorie` (
`timestamp` timestamp
,`lastname` varchar(128)
,`firstname` varchar(128)
,`username` varchar(255)
,`clientip` varchar(45)
,`useraction` text
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `klasse`
--

CREATE TABLE `klasse` (
  `name` varchar(32) NOT NULL COMMENT 'name of class',
  `schueleranzahl` smallint(6) NOT NULL COMMENT 'student count',
  `softdelete` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Flag for deletation'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lehrer`
--

CREATE TABLE `lehrer` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'User id',
  `mail` varchar(255) NOT NULL COMMENT 'User mail adress',
  `vorname` varchar(128) NOT NULL COMMENT 'User firsname',
  `nachname` varchar(128) NOT NULL COMMENT 'User lastname',
  `passwort` varchar(128) NOT NULL COMMENT 'User password. This is the complete, with pepper and salt, encripted password',
  `isroot` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Shows if user has root accsses to the database',
  `pepper` varchar(32) DEFAULT NULL COMMENT 'password pepper',
  `salt` varchar(32) DEFAULT NULL COMMENT 'password salt',
  `creationdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `settings` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `lehrer`
--

INSERT INTO `lehrer` (`id`, `mail`, `vorname`, `nachname`, `passwort`, `isroot`, `pepper`, `salt`, `creationdate`, `settings`) VALUES
(1, 'temp.dump@hotmail.com', 'Admin', 'Admin', '8c961088a179e47df0ff9a1becedeed84feb4d51a79481a46391516a8425ddcaf7aa516331b76a23dde2b489c539823346ca5780bc16385d94128718bbc01fad', 1, 'ae45f0a9dffd2b3dd79c1624b8c36181', '8436d1dcd1e883cb417bafa96ffe9751', '2021-12-13 12:34:19', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nm_frage_fragebogen`
--

CREATE TABLE `nm_frage_fragebogen` (
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Tabellenstruktur für Tabelle `userhistorie`
--

CREATE TABLE `userhistorie` (
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` bigint(20) UNSIGNED NOT NULL,
  `clientip` varchar(45) NOT NULL,
  `useraction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `userhistorie`
--

INSERT INTO `userhistorie` (`timestamp`, `userid`, `clientip`, `useraction`) VALUES
('2022-01-28 11:02:24', 1, '127.0.0.1', 'Login'),
('2022-01-28 11:02:29', 1, '127.0.0.1', 'Login');

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
-- Struktur des Views `getallcategories`
--
DROP TABLE IF EXISTS `getallcategories`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getallcategories`  AS  select `categories`.`description` AS `kategorie` from `categories` order by `categories`.`description` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getallclasses`
--
DROP TABLE IF EXISTS `getallclasses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getallclasses`  AS  select `klasse`.`name` AS `name`,`klasse`.`softdelete` AS `softdelete` from `klasse` order by `klasse`.`name` desc ;

-- --------------------------------------------------------

--
-- Struktur des Views `getallsubjects`
--
DROP TABLE IF EXISTS `getallsubjects`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getallsubjects`  AS  select `fach`.`name` AS `name`,`fach`.`softdelete` AS `softdelete` from `fach` order by `fach`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getalluser`
--
DROP TABLE IF EXISTS `getalluser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getalluser`  AS  select `lehrer`.`mail` AS `mail`,`lehrer`.`isroot` AS `isroot`,`lehrer`.`creationdate` AS `creationdate` from `lehrer` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getaskallquestions`
--
DROP TABLE IF EXISTS `getaskallquestions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getaskallquestions`  AS  select `fragen`.`id` AS `id`,`lehrer`.`mail` AS `username`,`fragen`.`frage` AS `frage`,`categories`.`description` AS `kategorie`,`fragen`.`softdelete` AS `softdelete` from ((`fragen` left join `categories` on(`fragen`.`kategorie` = `categories`.`id`)) left join `lehrer` on(`fragen`.`lehrerid` = `lehrer`.`id`)) order by `fragen`.`kategorie` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getbewertungen`
--
DROP TABLE IF EXISTS `getbewertungen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getbewertungen`  AS  select sum(`bewertungen`.`bewertung`) AS `sum(bewertungen.bewertung)`,`fragebogen`.`id` AS `id`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `bewertungen` on(`fragebogen`.`id` = `bewertungen`.`bogenid`)) group by `fragebogen`.`id` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getcodesinfo`
--
DROP TABLE IF EXISTS `getcodesinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getcodesinfo`  AS  select `codes`.`codehash` AS `codehash`,`codes`.`kritik` AS `kritik`,`codes`.`bewertung` AS `bewertung`,`codes`.`fragebogenid` AS `fragebogenid`,`codes`.`creationdate` AS `creationdate` from `codes` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getfbfragen`
--
DROP TABLE IF EXISTS `getfbfragen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`id` AS `bogenid`,`fragebogen`.`name` AS `thema`,`fragebogen`.`klassename` AS `klassename`,`fragen`.`id` AS `frageid`,`fragen`.`frage` AS `frage`,`categories`.`description` AS `kategorie`,`fach`.`name` AS `fachname`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) AS `bew110`,sum(if(`bewertungen`.`bewertung` = -1,1,0)) AS `bew101`,sum(if(`bewertungen`.`bewertung` = 0,1,0)) AS `bew000`,sum(if(`bewertungen`.`bewertung` = 1,1,0)) AS `bew001`,sum(if(`bewertungen`.`bewertung` = 2,1,0)) AS `bew010`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) * -2 + sum(if(`bewertungen`.`bewertung` = -1,1,0)) * -1 + sum(if(`bewertungen`.`bewertung` = 0,1,0)) * 0 + sum(if(`bewertungen`.`bewertung` = 1,1,0)) * 1 + sum(if(`bewertungen`.`bewertung` = 2,1,0)) * 2 AS `bewertung` from (((((`nm_frage_fragebogen` join `fragebogen` on(`fragebogen`.`id` = `nm_frage_fragebogen`.`bogenid`)) join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) left join `categories` on(`fragen`.`kategorie` = `categories`.`id`)) left join `bewertungen` on(`nm_frage_fragebogen`.`frageid` = `bewertungen`.`frageid` and `nm_frage_fragebogen`.`bogenid` = `bewertungen`.`bogenid`)) group by `fragen`.`id`,`fragebogen`.`id` ;

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
-- Struktur des Views `getkritik`
--
DROP TABLE IF EXISTS `getkritik`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getkritik`  AS  select `verbesserungen`.`vorschlag` AS `vorschlag`,`verbesserungen`.`bogenid` AS `bogenid` from `verbesserungen` ;

-- --------------------------------------------------------

--
-- Struktur des Views `getquestions`
--
DROP TABLE IF EXISTS `getquestions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getquestions`  AS  select `fragen`.`frage` AS `frage`,`categories`.`description` AS `kategorie`,`lehrer`.`mail` AS `mail` from ((`fragen` left join `categories` on(`fragen`.`kategorie` = `categories`.`id`)) join `lehrer` on(`fragen`.`lehrerid` = `lehrer`.`id`)) where `fragen`.`softdelete` is false ;

-- --------------------------------------------------------

--
-- Struktur des Views `getuserhistorie`
--
DROP TABLE IF EXISTS `getuserhistorie`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getuserhistorie`  AS  select `userhistorie`.`timestamp` AS `timestamp`,`lehrer`.`nachname` AS `lastname`,`lehrer`.`vorname` AS `firstname`,`lehrer`.`mail` AS `username`,`userhistorie`.`clientip` AS `clientip`,`userhistorie`.`useraction` AS `useraction` from (`userhistorie` left join `lehrer` on(`lehrer`.`id` = `userhistorie`.`userid`)) order by `lehrer`.`nachname` <> 0 and `userhistorie`.`timestamp` <> 0 ;

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
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `description` (`description`) USING HASH;

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
  ADD KEY `lehrerid` (`lehrerid`),
  ADD KEY `kategorie` (`kategorie`);

--
-- Indizes für die Tabelle `fragentemplate`
--
ALTER TABLE `fragentemplate`
  ADD PRIMARY KEY (`frage`),
  ADD KEY `kategorie` (`kategorie`);

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
-- Indizes für die Tabelle `userhistorie`
--
ALTER TABLE `userhistorie`
  ADD KEY `userid` (`userid`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'subject id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `fragebogen`
--
ALTER TABLE `fragebogen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT für Tabelle `fragen`
--
ALTER TABLE `fragen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6369;

--
-- AUTO_INCREMENT für Tabelle `lehrer`
--
ALTER TABLE `lehrer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User id', AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT für Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `fragen_ibfk_1` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `fragen_ibfk_2` FOREIGN KEY (`kategorie`) REFERENCES `categories` (`id`);

--
-- Constraints der Tabelle `fragentemplate`
--
ALTER TABLE `fragentemplate`
  ADD CONSTRAINT `fragentemplate_ibfk_1` FOREIGN KEY (`kategorie`) REFERENCES `categories` (`id`);

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
-- Constraints der Tabelle `userhistorie`
--
ALTER TABLE `userhistorie`
  ADD CONSTRAINT `userhistorie_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `lehrer` (`id`);

--
-- Constraints der Tabelle `verbesserungen`
--
ALTER TABLE `verbesserungen`
  ADD CONSTRAINT `verbesserungen_ibfk_1` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
