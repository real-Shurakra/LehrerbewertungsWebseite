SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `lehrerbewertungsdatenbank` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lehrerbewertungsdatenbank`;

DROP TABLE IF EXISTS `bewertungen`;
CREATE TABLE `bewertungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `bewertung` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `codehash` varchar(16) NOT NULL,
  `fragebogenid` bigint(20) UNSIGNED NOT NULL,
  `kritik` tinyint(1) NOT NULL DEFAULT 0,
  `bewertung` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `fach`;
CREATE TABLE `fach` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `fach` (`id`, `name`) VALUES
(1, 'ITS');

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

DROP TABLE IF EXISTS `fragen`;
CREATE TABLE `fragen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `frage` varchar(255) NOT NULL,
  `lehrerid` bigint(20) UNSIGNED DEFAULT NULL,
  `kategorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(38, 'Die Beurteilung ist gerecht, weil alle Schüler gleich behandelt werden.', NULL, 'Leistungsbewertung');
DROP VIEW IF EXISTS `getbewertungen`;
CREATE TABLE `getbewertungen` (
`sum(bewertungen.bewertung)` decimal(27,0)
,`id` bigint(20) unsigned
,`mail` varchar(255)
);
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
DROP VIEW IF EXISTS `getfragenanzahl`;
CREATE TABLE `getfragenanzahl` (
`count(nm_frage_fragebogen.frageid)` bigint(21)
,`id` bigint(20) unsigned
,`mail` varchar(255)
);

DROP TABLE IF EXISTS `klasse`;
CREATE TABLE `klasse` (
  `name` varchar(32) NOT NULL,
  `schueleranzahl` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `klasse` (`name`, `schueleranzahl`) VALUES
('ITB1-19', 30);

DROP TABLE IF EXISTS `lehrer`;
CREATE TABLE `lehrer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mail` varchar(255) NOT NULL,
  `vorname` varchar(128) NOT NULL,
  `nachname` varchar(128) NOT NULL,
  `passwort` varchar(128) NOT NULL,
  `isroot` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `lehrer` (`id`, `mail`, `vorname`, `nachname`, `passwort`, `isroot`) VALUES
(1, 'temp.dump@hotmail.com', 'Admin', 'Admin', 'fc5a8d28daaff41f992dd78286e7c7eb58953f138bc67f5f622a7fea035745be97f1ee603aafeabf3a54fad97ba6b8eb2211e5d1635139b38c3ac189d8d8685e', 1);

DROP TABLE IF EXISTS `nm_frage_fragebogen`;
CREATE TABLE `nm_frage_fragebogen` (
  `frageid` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `nm_lehrer_klasse`;
CREATE TABLE `nm_lehrer_klasse` (
  `lehrerid` bigint(20) UNSIGNED NOT NULL,
  `klassename` varchar(32) NOT NULL,
  `fachid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `verbesserungen`;
CREATE TABLE `verbesserungen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bogenid` bigint(20) UNSIGNED NOT NULL,
  `vorschlag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `getbewertungen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getbewertungen`  AS  select sum(`bewertungen`.`bewertung`) AS `sum(bewertungen.bewertung)`,`fragebogen`.`id` AS `id`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `bewertungen` on(`fragebogen`.`id` = `bewertungen`.`bogenid`)) group by `fragebogen`.`id` ;
DROP TABLE IF EXISTS `getfbfragen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfbfragen`  AS  select `fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`id` AS `bogenid`,`fragebogen`.`name` AS `thema`,`fragebogen`.`klassename` AS `klassename`,`fragen`.`id` AS `frageid`,`fragen`.`frage` AS `frage`,`fragen`.`kategorie` AS `kategorie`,`fach`.`name` AS `fachname`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) AS `bew110`,sum(if(`bewertungen`.`bewertung` = -1,1,0)) AS `bew101`,sum(if(`bewertungen`.`bewertung` = 0,1,0)) AS `bew000`,sum(if(`bewertungen`.`bewertung` = 1,1,0)) AS `bew001`,sum(if(`bewertungen`.`bewertung` = 2,1,0)) AS `bew010`,sum(if(`bewertungen`.`bewertung` = -2,1,0)) * -2 + sum(if(`bewertungen`.`bewertung` = -1,1,0)) * -1 + sum(if(`bewertungen`.`bewertung` = 0,1,0)) * 0 + sum(if(`bewertungen`.`bewertung` = 1,1,0)) * 1 + sum(if(`bewertungen`.`bewertung` = 2,1,0)) * 2 AS `bewertung` from ((((`nm_frage_fragebogen` join `fragebogen` on(`fragebogen`.`id` = `nm_frage_fragebogen`.`bogenid`)) join `fragen` on(`nm_frage_fragebogen`.`frageid` = `fragen`.`id`)) join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) left join `bewertungen` on(`nm_frage_fragebogen`.`frageid` = `bewertungen`.`frageid` and `nm_frage_fragebogen`.`bogenid` = `bewertungen`.`bogenid`)) group by `fragen`.`id`,`fragebogen`.`id` ;
DROP TABLE IF EXISTS `getfragebogen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfragebogen`  AS  select `fragebogen`.`id` AS `id`,`fragebogen`.`zeitstempel` AS `zeitstempel`,`fragebogen`.`name` AS `name`,`fach`.`name` AS `fach`,`fragebogen`.`klassename` AS `klassename`,`fragebogen`.`schueleranzahl` AS `schueleranzahl`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `fach` on(`fragebogen`.`fachid` = `fach`.`id`)) ;
DROP TABLE IF EXISTS `getfragenanzahl`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getfragenanzahl`  AS  select count(`nm_frage_fragebogen`.`frageid`) AS `count(nm_frage_fragebogen.frageid)`,`fragebogen`.`id` AS `id`,`lehrer`.`mail` AS `mail` from ((`lehrer` left join `fragebogen` on(`lehrer`.`id` = `fragebogen`.`lehrerid`)) left join `nm_frage_fragebogen` on(`fragebogen`.`id` = `nm_frage_fragebogen`.`bogenid`)) group by `fragebogen`.`id` ;


ALTER TABLE `bewertungen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `frageid` (`frageid`),
  ADD KEY `bogenid` (`bogenid`);

ALTER TABLE `codes`
  ADD PRIMARY KEY (`codehash`),
  ADD KEY `fragebogenid` (`fragebogenid`);

ALTER TABLE `fach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `fragebogen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `klassename` (`klassename`),
  ADD KEY `fachid` (`fachid`),
  ADD KEY `lehrerid` (`lehrerid`);

ALTER TABLE `fragen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lehrerid` (`lehrerid`);

ALTER TABLE `klasse`
  ADD PRIMARY KEY (`name`);

ALTER TABLE `lehrer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

ALTER TABLE `nm_frage_fragebogen`
  ADD UNIQUE KEY `frageid` (`frageid`,`bogenid`),
  ADD KEY `bogenid` (`bogenid`);

ALTER TABLE `nm_lehrer_klasse`
  ADD KEY `lehrerid` (`lehrerid`),
  ADD KEY `klassename` (`klassename`),
  ADD KEY `fachid` (`fachid`);

ALTER TABLE `verbesserungen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `bogenid` (`bogenid`);


ALTER TABLE `bewertungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `fach`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `fragebogen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `fragen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

ALTER TABLE `lehrer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `verbesserungen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `bewertungen`
  ADD CONSTRAINT `bewertungen_ibfk_1` FOREIGN KEY (`frageid`) REFERENCES `fragen` (`id`),
  ADD CONSTRAINT `bewertungen_ibfk_2` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);

ALTER TABLE `codes`
  ADD CONSTRAINT `codes_ibfk_1` FOREIGN KEY (`fragebogenid`) REFERENCES `fragebogen` (`id`);

ALTER TABLE `fragebogen`
  ADD CONSTRAINT `fragebogen_ibfk_1` FOREIGN KEY (`klassename`) REFERENCES `klasse` (`name`),
  ADD CONSTRAINT `fragebogen_ibfk_2` FOREIGN KEY (`fachid`) REFERENCES `fach` (`id`),
  ADD CONSTRAINT `fragebogen_ibfk_3` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`);

ALTER TABLE `fragen`
  ADD CONSTRAINT `fragen_ibfk_1` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`);

ALTER TABLE `nm_frage_fragebogen`
  ADD CONSTRAINT `nm_frage_fragebogen_ibfk_1` FOREIGN KEY (`frageid`) REFERENCES `fragen` (`id`),
  ADD CONSTRAINT `nm_frage_fragebogen_ibfk_2` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);

ALTER TABLE `nm_lehrer_klasse`
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_1` FOREIGN KEY (`lehrerid`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_2` FOREIGN KEY (`klassename`) REFERENCES `klasse` (`name`),
  ADD CONSTRAINT `nm_lehrer_klasse_ibfk_3` FOREIGN KEY (`fachid`) REFERENCES `fach` (`id`);

ALTER TABLE `verbesserungen`
  ADD CONSTRAINT `verbesserungen_ibfk_1` FOREIGN KEY (`bogenid`) REFERENCES `fragebogen` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
