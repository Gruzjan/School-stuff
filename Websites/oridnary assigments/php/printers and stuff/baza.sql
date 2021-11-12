-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Lis 2021, 20:32
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `baza`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `drukarki`
--

CREATE TABLE `drukarki` (
  `symbol` varchar(30) NOT NULL,
  `producent` varchar(30) DEFAULT NULL,
  `model` varchar(30) DEFAULT NULL,
  `symbol_tuszu` varchar(10) DEFAULT NULL,
  `cena` float DEFAULT NULL,
  `rozmiar_papieru` varchar(3) DEFAULT NULL CHECK (`rozmiar_papieru` in ('A4','A3','A3+'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `drukarki`
--

INSERT INTO `drukarki` (`symbol`, `producent`, `model`, `symbol_tuszu`, `cena`, `rozmiar_papieru`) VALUES
('AB-212', 'Iiyama', 'GEMEDION', '`--', 3.4, 'A3'),
('AB-213', 'Siema technologies s.a.', 'GEMEDION v2', 'stsa', 0.29, 'A4'),
('AB-220', 'Robie drukarki', 'Drukarka', 'T_U_S_Z', 129.99, 'A4');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tusze`
--

CREATE TABLE `tusze` (
  `kod` int(11) NOT NULL,
  `producent` varchar(30) DEFAULT NULL,
  `nazwa` varchar(30) DEFAULT NULL,
  `symbol` varchar(10) DEFAULT NULL,
  `cena` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tusze`
--

INSERT INTO `tusze` (`kod`, `producent`, `nazwa`, `symbol`, `cena`) VALUES
(1, 'siema technologies s.a.', 'siemson', 'stsa', 119.99),
(2, 'siema technologies s.a.', 'asdfasdf', 'stsa', 11),
(3, 'samsung sasasaas', 'not siema', '`--', 12),
(4, 'robie tusze', 'tusz', 'T_U_S_Z', 19.99);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `drukarki`
--
ALTER TABLE `drukarki`
  ADD PRIMARY KEY (`symbol`);

--
-- Indeksy dla tabeli `tusze`
--
ALTER TABLE `tusze`
  ADD PRIMARY KEY (`kod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `tusze`
--
ALTER TABLE `tusze`
  MODIFY `kod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
