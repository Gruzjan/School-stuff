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
-- Baza danych: `biblioteka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `bibliotekarze`
--

CREATE TABLE `bibliotekarze` (
  `Id` int(11) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Imie` varchar(20) NOT NULL,
  `Nazwisko` varchar(50) NOT NULL,
  `Haslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `bibliotekarze`
--

INSERT INTO `bibliotekarze` (`Id`, `Login`, `Imie`, `Nazwisko`, `Haslo`) VALUES
(1, 'MZ12', 'Mariusz', 'Zygzuła', '2e33a9b0b06aa0a01ede70995674ee'),
(2, 'WS13', 'Wojciech', 'Sobolewski', '880f93bda8013cd1bb34cfdb3d85c6'),
(3, 'admin', 'Gracjan', 'Wiśniewski', '202cb962ac59075b964b07152d234b');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `czytelnicy`
--

CREATE TABLE `czytelnicy` (
  `Id` int(11) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Imie` varchar(20) NOT NULL,
  `Nazwisko` varchar(50) NOT NULL,
  `Haslo` varchar(30) NOT NULL,
  `Klasa` varchar(4) NOT NULL,
  `CzyAkt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `czytelnicy`
--

INSERT INTO `czytelnicy` (`Id`, `Login`, `Imie`, `Nazwisko`, `Haslo`, `Klasa`, `CzyAkt`) VALUES
(1, 'gracek', 'Gracjan', 'Wiśniewski', 'a09bccf2b2963982b34dc0e08d8b58', '2c', 1),
(2, 'OliX', 'Oliwer', 'Szustakowski', '6b908b785fdba05a6446347dae08d8', '1a', 0),
(3, 'mareczek', 'Marian', 'Suchodolski', '6b908b785fdba05a6446347dae08d8', '3c', 1),
(4, 'konon', 'Krzysztof', 'Kononwicz', '6b908b785fdba05a6446347dae08d8', '2d', 0),
(5, 'siema', 'Maksymilian', 'Serafin', '6b908b785fdba05a6446347dae08d8', '1e', 1),
(6, 'mati', 'Mateusz', 'Wu', '6b908b785fdba05a6446347dae08d8', '4f', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `egzemplarzksiazki`
--

CREATE TABLE `egzemplarzksiazki` (
  `Id` int(11) NOT NULL,
  `NrInwentarzowy` varchar(100) NOT NULL,
  `IdKsiazki` int(11) NOT NULL,
  `CzyDost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `egzemplarzksiazki`
--

INSERT INTO `egzemplarzksiazki` (`Id`, `NrInwentarzowy`, `IdKsiazki`, `CzyDost`) VALUES
(1, 'A01', 5, 1),
(2, 'A02', 5, 1),
(3, 'A03', 5, 0),
(4, 'B01', 4, 1),
(5, 'B02', 4, 1),
(6, 'B03', 4, 0),
(7, 'C01', 1, 1),
(8, 'C02', 1, 1),
(9, 'C03', 1, 0),
(10, 'D01', 2, 1),
(11, 'D02', 2, 0),
(12, 'D03', 2, 0),
(13, 'E01', 3, 1),
(14, 'E02', 3, 1),
(15, 'E03', 3, 0),
(16, 'G01', 6, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ksiazki`
--

CREATE TABLE `ksiazki` (
  `Id` int(11) NOT NULL,
  `Autor` varchar(200) NOT NULL,
  `Tytul` varchar(100) NOT NULL,
  `Gatunek` varchar(20) NOT NULL,
  `Wydawnictwo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ksiazki`
--

INSERT INTO `ksiazki` (`Id`, `Autor`, `Tytul`, `Gatunek`, `Wydawnictwo`) VALUES
(1, 'Bolesław Prus', 'Lalka', 'Powieść', 'Wydawnictwo Mg'),
(2, 'Peter Brett', 'Malowany człowiek', 'Fantasy', 'Amber'),
(3, 'Simon Beckett', 'Chemia Śmierci', 'Thriller', 'Zielona Sowa'),
(4, 'Aleksander Fredro', 'Zemsta', 'Dramat', 'Greg'),
(5, 'J Sharma,Ashish Sarin', 'Spring Framework. Wprowadzenie do tworzenia aplikacji. Wydanie II', 'Poradnik', 'Helion'),
(6, 'Gracjan Wiśniewski', 'Prezentacja', 'Poradnik', 'Moje');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenia`
--

CREATE TABLE `wypozyczenia` (
  `Id` int(11) NOT NULL,
  `NrInwentarzowy` varchar(100) NOT NULL,
  `IdCzytelnika` int(11) NOT NULL,
  `DataWyp` date NOT NULL,
  `DataZwrotu` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wypozyczenia`
--

INSERT INTO `wypozyczenia` (`Id`, `NrInwentarzowy`, `IdCzytelnika`, `DataWyp`, `DataZwrotu`) VALUES
(1, 'B02', 1, '2020-10-21', '2020-11-01'),
(2, 'C01', 6, '2020-10-07', '2020-10-24'),
(3, 'D02', 5, '2020-10-15', '2020-10-30'),
(4, 'A01', 3, '2020-10-02', '2020-10-31'),
(5, 'E01', 2, '2020-10-28', '2020-10-31'),
(6, 'B01', 4, '2020-10-12', '2020-10-24'),
(7, 'C02', 1, '2020-10-07', '2020-10-28'),
(8, 'D01', 6, '2020-10-02', '2020-10-30'),
(9, 'A02', 5, '2020-10-29', '2020-11-01'),
(10, 'E02', 3, '2020-10-03', '2020-10-18'),
(11, 'B02', 1, '2020-11-07', '2020-11-08'),
(12, 'B02', 1, '2020-11-09', '2020-11-09'),
(13, 'B02', 1, '2020-11-09', '2020-11-09'),
(14, 'E02', 5, '2020-11-09', '2020-11-09'),
(15, 'E02', 5, '2020-11-07', '2020-11-12'),
(18, 'A02', 5, '2020-11-09', '2020-11-09'),
(19, 'A02', 5, '2020-11-09', '2020-11-12'),
(20, 'D02', 5, '2020-11-12', '2020-11-12'),
(21, 'D02', 5, '2020-11-12', '0000-00-00'),
(22, 'A02', 1, '2020-11-12', '2020-11-12'),
(23, 'A02', 5, '2020-11-12', '2020-11-12'),
(24, 'G01', 1, '2020-11-12', '2020-11-12');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `bibliotekarze`
--
ALTER TABLE `bibliotekarze`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `czytelnicy`
--
ALTER TABLE `czytelnicy`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `egzemplarzksiazki`
--
ALTER TABLE `egzemplarzksiazki`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `NrInwentarzowy` (`NrInwentarzowy`),
  ADD KEY `fk_ksiazkiegzemplarz` (`IdKsiazki`);

--
-- Indeksy dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  ADD PRIMARY KEY (`Id`);

--
-- Indeksy dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `1` (`NrInwentarzowy`),
  ADD KEY `2` (`IdCzytelnika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `bibliotekarze`
--
ALTER TABLE `bibliotekarze`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `czytelnicy`
--
ALTER TABLE `czytelnicy`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `egzemplarzksiazki`
--
ALTER TABLE `egzemplarzksiazki`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `ksiazki`
--
ALTER TABLE `ksiazki`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `egzemplarzksiazki`
--
ALTER TABLE `egzemplarzksiazki`
  ADD CONSTRAINT `fk_ksiazkiegzemplarz` FOREIGN KEY (`IdKsiazki`) REFERENCES `ksiazki` (`Id`);

--
-- Ograniczenia dla tabeli `wypozyczenia`
--
ALTER TABLE `wypozyczenia`
  ADD CONSTRAINT `wypozyczenia_ibfk_1` FOREIGN KEY (`NrInwentarzowy`) REFERENCES `egzemplarzksiazki` (`NrInwentarzowy`),
  ADD CONSTRAINT `wypozyczenia_ibfk_2` FOREIGN KEY (`IdCzytelnika`) REFERENCES `czytelnicy` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
