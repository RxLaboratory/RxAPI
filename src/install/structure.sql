SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `rxv_apps`;
CREATE TABLE `rxv_apps` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `os` enum('win','mac','linux','android','ios','all') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all',
  `host` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `rxv_stats`;
CREATE TABLE `rxv_stats` (
  `id` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `appName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `os` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `osVersion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `host` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hostVersion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `languageCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT "unknown"
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `rxv_versions`;
CREATE TABLE `rxv_versions` (
  `id` int(11) NOT NULL,
  `app` int(11) NOT NULL,
  `version` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `downloadURL` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `changelogURL` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `donateURL` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `rxv_apps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `app-os-host-unique` (`host`,`name`,`os`);

ALTER TABLE `rxv_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app-idx` (`app`);

ALTER TABLE `rxv_versions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name-version-unique` (`version`,`app`),
  ADD KEY `app-fk` (`app`);


ALTER TABLE `rxv_apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rxv_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rxv_versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `rxv_stats`
  ADD CONSTRAINT `apps-fk` FOREIGN KEY (`app`) REFERENCES `rxv_apps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `rxv_versions`
  ADD CONSTRAINT `app-fk` FOREIGN KEY (`app`) REFERENCES `rxv_apps` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
