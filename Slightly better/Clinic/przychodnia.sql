-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Lis 2021, 20:37
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
-- Baza danych: `przychodnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `choroby`
--

CREATE TABLE `choroby` (
  `id` int(11) NOT NULL,
  `icd10` varchar(35) DEFAULT NULL,
  `nazwa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `choroby`
--

INSERT INTO `choroby` (`id`, `icd10`, `nazwa`) VALUES
(1, 'A00.1', 'Cholera wywołana przecinkowcem vibrio cholerae 01'),
(2, 'B04', 'Ospa małpia'),
(3, 'J21.8', 'Ostre zapalenie oskrzelików wywołane innymi określonymi drobnoustrojami'),
(4, 'I15.0', 'Nadciśnienie naczyniowo-nerkowe'),
(5, 'E07.0', 'Nadmierne wydzielanie kalcytoniny'),
(6, 'A36.1', 'Błonica nosowo-gardłowa'),
(7, 'A37.9', 'Krztusiec, nieokreślony'),
(8, 'J10.0', 'Grypa z zapaleniem płuc wywołana zidentyfikowanym wirusem grypy'),
(9, 'J17.3', 'Zapalenie płuc w przebiegu chorób pasożytniczych'),
(10, 'G10', 'Choroba Huntingtona');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `historia`
--

CREATE TABLE `historia` (
  `id` int(11) NOT NULL,
  `wizytaId` int(11) DEFAULT NULL,
  `wywiad` varchar(255) DEFAULT NULL,
  `rozpoznanie` varchar(5) DEFAULT NULL,
  `opisRecepty` varchar(255) DEFAULT NULL,
  `opisBadan` varchar(255) DEFAULT NULL,
  `zalecenia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `historia`
--

INSERT INTO `historia` (`id`, `wizytaId`, `wywiad`, `rozpoznanie`, `opisRecepty`, `opisBadan`, `zalecenia`) VALUES
(1, 10, 'Wywiad1', 'A00.1', 'opis recepty1', 'opis Badan1', 'zalecenia1'),
(2, 9, 'Wywiad ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis', 'A36.1', 'Recepta ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium qui', 'Badania ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium qui', 'Zalecenia ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium q'),
(3, 8, 'Wywiad ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis', 'A37.9', 'Recepta ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium qui', 'Badania ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium qui', 'Zalecenia ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium q'),
(4, 7, 'wywiad4', 'B04', 'opisRecepty4', 'opisBadan4', 'zalecenia4'),
(5, 6, 'wywiad5', 'E07.0', 'opisRecepty5', 'opisBadan5', 'zalecenia5'),
(6, 5, 'wywiad6', 'G10', 'opisRecepty6', 'opisBadan6', 'zalecenia'),
(7, 4, 'wywiad7', 'I15.0', 'opisRecepty7', 'opisBadan7', 'zalecenia7'),
(8, 3, 'wywiad8', 'J10.0', 'opisRecepty8', 'opisBadan8', 'zalecenia8'),
(9, 2, 'wywiad9', 'J17.3', 'opisRecepty9', 'opisBadan9', 'zalecenia9'),
(10, 1, 'wywiad10', 'J21.8', 'opisRecepty10', 'opisBadan10', 'zalecenia10'),
(14, 11, 'Interview', 'I15.0', 'Prescription ', 'research', 'Recommendations'),
(15, 9, 'Wywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswywiadasddsadasdaswyw', 'I15.0', 'recepta', 'adfssad', 'fsdaf');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE `lekarze` (
  `id` int(11) NOT NULL,
  `tytul` varchar(80) DEFAULT NULL,
  `imie` varchar(20) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `specjalizacja` varchar(100) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `haslo` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `lekarze`
--

INSERT INTO `lekarze` (`id`, `tytul`, `imie`, `nazwisko`, `specjalizacja`, `login`, `haslo`) VALUES
(1, 'Lekarz', 'Gracjan', 'Wiśniewski', 'Rehabilitacja medyczna', 'GW11', '8aa1779ba1ef9b1b9289c95cb5b0c8fe'),
(2, 'Lekarz', ' Mikołaj', 'Lendzion', 'Onkologia kliniczna', 'ML11', '2a1ae9faf1c08e1dfb2bbe0d64f9da57'),
(3, 'Specjalista chorób zakaźnych', 'Gerald', 'Wawrzynowicz', 'Choroby zakaźne', 'GW12', 'c392e3d42045f55fa6090651dd02b71a'),
(5, 'Kardiolog', 'Andrzej', 'Wachowiak', 'Choroby układu kardiologicznego', 'AW11', '5842b2b792b4dca7bade8176da965063');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pacjenci`
--

CREATE TABLE `pacjenci` (
  `id` int(11) NOT NULL,
  `imie` varchar(20) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `ulica` varchar(100) DEFAULT NULL,
  `nrDomu` int(11) DEFAULT NULL,
  `nrMieszkania` int(11) DEFAULT NULL,
  `kodPocztowy` varchar(6) DEFAULT NULL,
  `miasto` varchar(40) DEFAULT NULL,
  `pesel` varchar(11) DEFAULT NULL,
  `dataUr` date DEFAULT NULL,
  `plec` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pacjenci`
--

INSERT INTO `pacjenci` (`id`, `imie`, `nazwisko`, `ulica`, `nrDomu`, `nrMieszkania`, `kodPocztowy`, `miasto`, `pesel`, `dataUr`, `plec`) VALUES
(1, 'Anna', 'Robertowa', 'Pistacjowa', 1, NULL, '02-797', 'Olsztyn', '90101851661', '1980-10-18', 'M'),
(2, 'Władysław', 'Wiśniewski', 'Chałupnika Kazimierza', 5, 12, '31-464', 'Gdańsk', '54102547053', '1954-10-25', 'M'),
(3, 'Alojzy', 'Ostrowski', 'Łanowa', 60, 2, '25-147', 'Kielce', '56091592535', '1956-09-15', 'M'),
(4, 'Patrycja', 'Ostrowska', 'Gromadzka', 22, NULL, '41-214', 'Sosnowiec', '71020980146', '1971-02-09', 'K'),
(5, 'Zofia', 'Górska', 'Weigla Rudolfa', 94, 56, '53-114', 'Wrocław', '90030918602', '1990-09-09', 'K'),
(6, 'Marcin', 'Majkut', 'Jana Pawla', 13, 27, '80-180', 'Warszawa', '9674762852', '2020-12-02', 'M'),
(19, 'Mikołaj', 'Szustakowski', 'Przemyska', 12, NULL, '80-180', 'Gdańsk', '12476423411', '2003-11-17', 'M');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rejestratorzy`
--

CREATE TABLE `rejestratorzy` (
  `id` int(11) NOT NULL,
  `imie` varchar(20) DEFAULT NULL,
  `nazwisko` varchar(50) DEFAULT NULL,
  `login` varchar(20) DEFAULT NULL,
  `haslo` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `rejestratorzy`
--

INSERT INTO `rejestratorzy` (`id`, `imie`, `nazwisko`, `login`, `haslo`) VALUES
(1, 'Amelka', 'Wiśniewska', 'AK11', 'd0126ebac3071e44c756dad3b90e5c18'),
(2, 'Marcin', 'Majkut', 'MM11', '1479157a7867b09583db8f174d46c445'),
(3, 'Dawid', 'Szpakowski', 'DS11', 'ad6c632058483d932eceaa478451d5bb');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyty`
--

CREATE TABLE `wizyty` (
  `id` int(11) NOT NULL,
  `lekarzId` int(11) DEFAULT NULL,
  `pacjentId` int(11) DEFAULT NULL,
  `rejestratorId` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wizyty`
--

INSERT INTO `wizyty` (`id`, `lekarzId`, `pacjentId`, `rejestratorId`, `data`) VALUES
(1, 1, 1, 1, '2019-10-16 10:00:00'),
(2, 1, 3, 2, '2019-12-18 09:00:00'),
(3, 2, 4, 1, '2020-10-15 11:00:00'),
(4, 3, 2, 3, '2020-11-05 15:00:00'),
(5, 3, 1, 1, '2020-11-15 08:00:00'),
(6, 2, 3, 3, '2020-10-01 11:00:00'),
(7, 1, 2, 1, '2020-10-28 11:00:00'),
(8, 1, 1, 2, '2020-12-08 12:00:00'),
(9, 2, 5, 1, '2020-12-11 09:30:00'),
(10, 1, 1, 1, '2020-11-03 08:30:00'),
(11, 2, 3, 1, '2020-12-10 12:00:00'),
(12, 1, 1, 1, '2020-12-24 13:00:00'),
(13, 3, 4, 1, '2020-12-11 12:20:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `choroby`
--
ALTER TABLE `choroby`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icd10` (`icd10`);

--
-- Indeksy dla tabeli `historia`
--
ALTER TABLE `historia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wizytaId` (`wizytaId`),
  ADD KEY `rozpoznanie` (`rozpoznanie`);

--
-- Indeksy dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indeksy dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pesel` (`pesel`);

--
-- Indeksy dla tabeli `rejestratorzy`
--
ALTER TABLE `rejestratorzy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Indeksy dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lekarzId` (`lekarzId`),
  ADD KEY `pacjentId` (`pacjentId`),
  ADD KEY `rejestratorId` (`rejestratorId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `choroby`
--
ALTER TABLE `choroby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `historia`
--
ALTER TABLE `historia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `pacjenci`
--
ALTER TABLE `pacjenci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT dla tabeli `rejestratorzy`
--
ALTER TABLE `rejestratorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `historia`
--
ALTER TABLE `historia`
  ADD CONSTRAINT `historia_ibfk_1` FOREIGN KEY (`wizytaId`) REFERENCES `wizyty` (`id`),
  ADD CONSTRAINT `historia_ibfk_2` FOREIGN KEY (`rozpoznanie`) REFERENCES `choroby` (`icd10`);

--
-- Ograniczenia dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD CONSTRAINT `wizyty_ibfk_1` FOREIGN KEY (`lekarzId`) REFERENCES `lekarze` (`id`),
  ADD CONSTRAINT `wizyty_ibfk_2` FOREIGN KEY (`pacjentId`) REFERENCES `pacjenci` (`id`),
  ADD CONSTRAINT `wizyty_ibfk_3` FOREIGN KEY (`rejestratorId`) REFERENCES `rejestratorzy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
