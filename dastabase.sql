-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lut 2022, 19:49
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `firma`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `id_klienta` int(11) NOT NULL,
  `nazwa` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `miejscowosc` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `ulica` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `numer_domu` varchar(8) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`id_klienta`, `nazwa`, `miejscowosc`, `ulica`, `numer_domu`, `email`) VALUES
(1, 'Michał Głowacki', 'Sczebrzeszyn', 'Miętowa', '44a', 'glowm@protonmail.com'),
(2, 'Materox spółka z.o.o.', 'Lublin', 'Długa', '33', 'materoxsa@gmail.com'),
(3, 'Anna Długosz', 'Świetliki Długie', 'Jana Długosza', '67', '4nn4@o2.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

CREATE TABLE `konta` (
  `id_konta` int(11) NOT NULL,
  `id_pracownika` int(11) DEFAULT NULL,
  `login` varchar(16) COLLATE utf8_polish_ci DEFAULT NULL,
  `haslo` char(60) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `konta`
--

INSERT INTO `konta` (`id_konta`, `id_pracownika`, `login`, `haslo`) VALUES
(1, NULL, 'admin', '$2y$10$.m28zPq3z6RJBM4srpz.i.0go7rhLY.txI/31l2BiDkOCUBhH8wvG'),
(2, 1, 'm0recka', '$2y$10$.m28zPq3z6RJBM4srpz.i.0go7rhLY.txI/31l2BiDkOCUBhH8wvG'),
(3, 2, 'ad@m1', '$2y$10$.m28zPq3z6RJBM4srpz.i.0go7rhLY.txI/31l2BiDkOCUBhH8wvG'),
(4, 3, 'm0tyl', '$2y$10$.m28zPq3z6RJBM4srpz.i.0go7rhLY.txI/31l2BiDkOCUBhH8wvG'),
(5, 4, 'kl##wik', '$2y$10$.m28zPq3z6RJBM4srpz.i.0go7rhLY.txI/31l2BiDkOCUBhH8wvG');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `id_pracownika` int(11) NOT NULL,
  `imie` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `pesel` char(11) COLLATE utf8_polish_ci DEFAULT NULL,
  `pensja` decimal(15,2) DEFAULT NULL,
  `id_zespolu` int(11) DEFAULT NULL,
  `id_stanowiska` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`id_pracownika`, `imie`, `nazwisko`, `pesel`, `pensja`, `id_zespolu`, `id_stanowiska`) VALUES
(1, 'Agata', 'Morecka', '94872530092', '3000.00', 2, 2),
(2, 'Adam', 'Morecki', '84639210902', '4300.00', 3, 6),
(3, 'Andrzej', 'Motyl', '38402837543', '4500.00', NULL, 3),
(4, 'Jagoda', 'Klawik', '84723198434', '4600.00', 3, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `projekty`
--

CREATE TABLE `projekty` (
  `id_projektu` int(11) NOT NULL,
  `id_klienta` int(11) DEFAULT NULL,
  `nazwa_projektu` varchar(32) COLLATE utf8_polish_ci DEFAULT NULL,
  `data_rozpoczecia` date DEFAULT NULL,
  `data_zakonczenia` date DEFAULT NULL,
  `liczba_podstron` smallint(11) DEFAULT NULL,
  `cms` bit(1) DEFAULT NULL,
  `graficzny` bit(1) DEFAULT NULL,
  `ekspresowy_czas_wykonania` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `projekty`
--

INSERT INTO `projekty` (`id_projektu`, `id_klienta`, `nazwa_projektu`, `data_rozpoczecia`, `data_zakonczenia`, `liczba_podstron`, `cms`, `graficzny`, `ekspresowy_czas_wykonania`) VALUES
(1, 1, 'Wymyślny Projekt', '2022-02-06', '2022-02-20', 45, b'0', b'1', b'1'),
(2, 3, 'Niezwykły Projekt', '2022-02-27', '2022-03-31', 67, b'0', b'1', b'0');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `spotkania`
--

CREATE TABLE `spotkania` (
  `id_spotkania` int(11) NOT NULL,
  `id_klienta` int(11) DEFAULT NULL,
  `id_projektu` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `spotkania`
--

INSERT INTO `spotkania` (`id_spotkania`, `id_klienta`, `id_projektu`, `data`) VALUES
(1, 1, 1, '2022-02-23 12:30:00'),
(2, 3, 2, '2022-02-06 16:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stanowiska`
--

CREATE TABLE `stanowiska` (
  `id_stanowiska` int(11) NOT NULL,
  `nazwa_stanowiska` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `stanowiska`
--

INSERT INTO `stanowiska` (`id_stanowiska`, `nazwa_stanowiska`) VALUES
(1, 'stanowisko1'),
(2, 'stanowisko2'),
(3, 'stanowisko3'),
(4, 'stanowisko4'),
(5, 'stanowisko5'),
(6, 'stanowisko6');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zespoly`
--

CREATE TABLE `zespoly` (
  `id_zespolu` int(11) NOT NULL,
  `nazwa_zespolu` varchar(16) COLLATE utf8_polish_ci DEFAULT NULL,
  `id_projektu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zespoly`
--

INSERT INTO `zespoly` (`id_zespolu`, `nazwa_zespolu`, `id_projektu`) VALUES
(1, 'zespół1', NULL),
(2, 'zespół2', NULL),
(3, 'zespół3', NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id_klienta`);

--
-- Indeksy dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`id_konta`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `login_2` (`login`),
  ADD UNIQUE KEY `login_3` (`login`),
  ADD KEY `id_pracownika` (`id_pracownika`);

--
-- Indeksy dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`id_pracownika`),
  ADD UNIQUE KEY `pesel` (`pesel`),
  ADD KEY `id_zespolu` (`id_zespolu`),
  ADD KEY `id_stanowiska` (`id_stanowiska`);

--
-- Indeksy dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD PRIMARY KEY (`id_projektu`),
  ADD UNIQUE KEY `nazwa_projektu` (`nazwa_projektu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `spotkania`
--
ALTER TABLE `spotkania`
  ADD PRIMARY KEY (`id_spotkania`),
  ADD KEY `id_klienta` (`id_klienta`),
  ADD KEY `id_projektu` (`id_projektu`);

--
-- Indeksy dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  ADD PRIMARY KEY (`id_stanowiska`);

--
-- Indeksy dla tabeli `zespoly`
--
ALTER TABLE `zespoly`
  ADD PRIMARY KEY (`id_zespolu`),
  ADD UNIQUE KEY `nazwa_zespolu` (`nazwa_zespolu`),
  ADD KEY `id_projektu` (`id_projektu`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `id_konta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `id_pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `projekty`
--
ALTER TABLE `projekty`
  MODIFY `id_projektu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `spotkania`
--
ALTER TABLE `spotkania`
  MODIFY `id_spotkania` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `stanowiska`
--
ALTER TABLE `stanowiska`
  MODIFY `id_stanowiska` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `zespoly`
--
ALTER TABLE `zespoly`
  MODIFY `id_zespolu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD CONSTRAINT `konta_ibfk_1` FOREIGN KEY (`id_pracownika`) REFERENCES `pracownicy` (`id_pracownika`);

--
-- Ograniczenia dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD CONSTRAINT `pracownicy_ibfk_1` FOREIGN KEY (`id_zespolu`) REFERENCES `zespoly` (`id_zespolu`) ON DELETE SET NULL,
  ADD CONSTRAINT `pracownicy_ibfk_2` FOREIGN KEY (`id_stanowiska`) REFERENCES `stanowiska` (`id_stanowiska`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `projekty`
--
ALTER TABLE `projekty`
  ADD CONSTRAINT `projekty_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `spotkania`
--
ALTER TABLE `spotkania`
  ADD CONSTRAINT `spotkania_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id_klienta`) ON DELETE SET NULL,
  ADD CONSTRAINT `spotkania_ibfk_2` FOREIGN KEY (`id_projektu`) REFERENCES `projekty` (`id_projektu`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `zespoly`
--
ALTER TABLE `zespoly`
  ADD CONSTRAINT `zespoly_ibfk_1` FOREIGN KEY (`id_projektu`) REFERENCES `projekty` (`id_projektu`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
