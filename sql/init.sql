-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: db
-- Vytvořeno: Sob 22. říj 2022, 20:20
-- Verze serveru: 5.7.40
-- Verze PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `web`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `lang`
--

CREATE TABLE `lang` (
  `shortcut` varchar(10) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `lang`
--

INSERT INTO `lang` (`shortcut`, `name`) VALUES
('en', 'English'),
('ro', 'Romanian');

-- --------------------------------------------------------

--
-- Struktura tabulky `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1666469412),
('m221015_000000_install_langs', 1666469415),
('m221016_000000_install_translations', 1666469415);

-- --------------------------------------------------------

--
-- Struktura tabulky `translation`
--

CREATE TABLE `translation` (
  `key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `translation`
--

INSERT INTO `translation` (`key`) VALUES
('POPUP_BUTTON_LABEL'),
('SCREEN_TITLE_LESSONS');

-- --------------------------------------------------------

--
-- Struktura tabulky `translationlang`
--

CREATE TABLE `translationlang` (
  `id` int(11) NOT NULL,
  `lang` varchar(10) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `translation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `translationlang`
--

INSERT INTO `translationlang` (`id`, `lang`, `key`, `translation`) VALUES
(1, 'ro', 'POPUP_BUTTON_LABEL', 'Apasa aici'),
(2, 'en', 'POPUP_BUTTON_LABEL', 'Press here'),
(3, 'ro', 'SCREEN_TITLE_LESSONS', 'Lectii'),
(4, 'en', 'SCREEN_TITLE_LESSONS', 'Lessons');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `lang`
--
ALTER TABLE `lang`
  ADD UNIQUE KEY `shortcut` (`shortcut`);

--
-- Indexy pro tabulku `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexy pro tabulku `translation`
--
ALTER TABLE `translation`
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexy pro tabulku `translationlang`
--
ALTER TABLE `translationlang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_translationlang_lang` (`lang`),
  ADD KEY `fk_translationlang_translation` (`key`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `translationlang`
--
ALTER TABLE `translationlang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `translationlang`
--
ALTER TABLE `translationlang`
  ADD CONSTRAINT `fk_translationlang_lang` FOREIGN KEY (`lang`) REFERENCES `lang` (`shortcut`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_translationlang_translation` FOREIGN KEY (`key`) REFERENCES `translation` (`key`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
