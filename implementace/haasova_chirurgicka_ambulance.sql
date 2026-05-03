-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 02:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `haasova_chirurgicka_ambulance`
--

-- --------------------------------------------------------

--
-- Table structure for table `diagnosis`
--

CREATE TABLE `diagnosis` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnosis`
--

INSERT INTO `diagnosis` (`Id`, `Name`) VALUES
(1, 'Podvrtnutí krční páteře'),
(2, 'Popálenina I. stupně'),
(3, 'Popálenina II. stupně'),
(4, 'Popálenina III. stupně'),
(5, 'Popálenina IV. stupně'),
(6, 'Bolest břicha'),
(7, 'Zlomenina kosti vřetenní'),
(8, 'Řezná rána ruky'),
(9, 'Zvrknutí hlezeného kloubu'),
(10, 'Infekce kůže a podkoží'),
(11, 'Ischemická choroba končetiny'),
(12, 'Diabetes melitus - končetinové komplikace'),
(13, 'Torticolis');

-- --------------------------------------------------------

--
-- Table structure for table `diagnostic_record`
--

CREATE TABLE `diagnostic_record` (
  `Date` datetime NOT NULL,
  `Patient_id` bigint(20) UNSIGNED NOT NULL,
  `Diagnosis_id` int(11) UNSIGNED NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diagnostic_record`
--

INSERT INTO `diagnostic_record` (`Date`, `Patient_id`, `Diagnosis_id`, `Description`) VALUES
('2024-01-15 14:15:22', 8958151334, 1, 'Podvrknutí krční páteře - autonehoda'),
('2024-02-15 11:05:10', 466224231, 6, 'Dietní chyba'),
('2024-03-11 10:01:12', 9110081508, 8, '3cm rána dlaně pravé ruky'),
('2024-04-04 10:58:09', 8704152391, 6, 'Dietní chyba'),
('2024-05-11 07:15:13', 8302075738, 10, 'Rána na palci pravé dolní končetiny - diabetes'),
('2024-06-22 10:05:30', 8704152391, 6, 'Dietní chyba'),
('2024-07-08 12:37:09', 8302071646, 7, 'Otok a dekonfigurace zápěstí - zlomenina'),
('2024-08-15 09:26:25', 9805233680, 9, 'Otok zevního kotníku, bolest'),
('2024-09-12 22:57:26', 8704152391, 6, 'Dietní chyba'),
('2024-10-02 07:57:03', 9110081508, 6, 'Žlučníkový záchvat'),
('2024-10-15 09:23:34', 466224231, 10, 'Drobné rány na obou bércích infikované'),
('2024-10-15 09:23:34', 466224231, 11, 'Nedokrevnost dolních končetin'),
('2024-11-22 13:38:04', 8958151334, 3, 'Popálenina 1% - pravé předloktí'),
('2024-11-25 11:23:11', 8157315672, 13, 'Spasmus svalstva krční páteře, zvýšená bolestivost');

-- --------------------------------------------------------

--
-- Table structure for table `interaction`
--

CREATE TABLE `interaction` (
  `Queried_substance` varchar(255) NOT NULL,
  `Found_substance` varchar(255) NOT NULL,
  `Description` text NOT NULL
) ;

--
-- Dumping data for table `interaction`
--

INSERT INTO `interaction` (`Queried_substance`, `Found_substance`, `Description`) VALUES
('Bemiparin', 'Nimesulid', 'Zvyšuje účinek'),
('Bemiparin', 'Paracetamol', 'Zvyšuje účinek'),
('Clindamycin', 'Naftidrofuryl', 'Nevysvětlitelné vertigo'),
('Levopromazin', 'Mephenoxalon', 'Zvyšuje účinek'),
('Naftidrofuryl', 'Clindamycin', 'Nevysvětlitelné vertigo'),
('Nimesulid', 'Paracetamol', 'Poškozuje játra při nadměrném užívání'),
('Paracetamol', 'Nimesulid', 'Poškozuje játra při nadměrném užívání');

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Medicinal_substance` varchar(255) NOT NULL,
  `Form` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`Id`, `Name`, `Medicinal_substance`, `Form`) VALUES
(1, 'Zibor', 'Bemiparin', 'Injekce'),
(2, 'Panadol', 'Paracetamol', 'Tablety'),
(3, 'Panadol', 'Paracetamol', 'Sirup'),
(4, 'Paralen', 'Paracetamol', 'Tablety'),
(5, 'Aulin', 'Nimesulid', 'Tablety'),
(6, 'Aulin', 'Nimesulid', 'Sáčky'),
(7, 'Levopront', 'Levopromazin', 'Kapky'),
(8, 'Levopront', 'Levopromazin', 'Tablety'),
(9, 'Doxybene', 'Doxycyclin', 'Tablety'),
(10, 'Dalcin C', 'Clindamycin', 'Tablety'),
(11, 'Amoclen', 'Amoxicillinum', 'Tablety'),
(12, 'Augmentin', 'Amoxicillinum', 'Sirup'),
(13, 'Augmentin', 'Amoxicillinum', 'Tablety'),
(14, 'Dimexol', 'Mephenoxalon', 'Tablety'),
(15, 'Framykoin', 'Neomycin', 'Zásyp'),
(16, 'Framykoin', 'Neomycin', 'Mast'),
(17, 'Enelbin', 'Naftidrofuryl', 'Tablety');

-- --------------------------------------------------------

--
-- Table structure for table `medicinal_substance`
--

CREATE TABLE `medicinal_substance` (
  `Name` varchar(255) NOT NULL,
  `Category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicinal_substance`
--

INSERT INTO `medicinal_substance` (`Name`, `Category`) VALUES
('Amoxicillinum', 'ATB'),
('Bemiparin', 'Anticolaguans'),
('Clindamycin', 'ATB'),
('Doxycyclin', 'ATB'),
('Levopromazin', 'Neuroleptikum'),
('Mephenoxalon', 'Myorelaxans'),
('Naftidrofuryl', 'Vasodilatans'),
('Neomycin', 'ATB'),
('Nimesulid', 'Analgeticum'),
('Paracetamol', 'Analgeticum, Antipyretikum');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `Birth_certificate_number` bigint(20) UNSIGNED NOT NULL,
  `Given_name` varchar(255) NOT NULL,
  `Surname` varchar(255) NOT NULL,
  `Permanent_address` varchar(255) NOT NULL,
  `Insurance_company_number` smallint(6) UNSIGNED NOT NULL,
  `Telephone_number` int(11) UNSIGNED NOT NULL,
  `Birthdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`Birth_certificate_number`, `Given_name`, `Surname`, `Permanent_address`, `Insurance_company_number`, `Telephone_number`, `Birthdate`) VALUES
(203014713, 'Michal', 'Krytý', 'Zelená 17, Klatovy', 207, 606309421, '2002-03-01'),
(261307893, 'Julie', 'Fučíková', 'Manětínská 14, Plzeň', 111, 601234765, '2002-11-30'),
(466224231, 'Jaroslava', 'Srpková', 'Plzenecká 13, Plzeň', 211, 602224567, '1946-12-24'),
(1559110729, 'Charlotte', 'Kolářová', 'Přehýšov 214', 111, 703848321, '2015-09-11'),
(8157315672, 'Veronika', 'Malá', 'Klatovská 20, Plzeň', 211, 608765567, '1981-07-31'),
(8302071646, 'Josef', 'Novák', 'Nerudova 3, Plzeň', 211, 605786543, '1983-02-07'),
(8302075738, 'Josef', 'Novák', 'Klatovská 15, Přeštice', 201, 731342675, '1983-02-07'),
(8704152391, 'Petr', 'Nádeník', 'Boženy Němcové 12, Nýřany', 205, 603752987, '1987-04-15'),
(8958151334, 'Petra', 'Bartůňková', 'Radyňská 123, Starý Plzenec', 211, 602345765, '1989-08-15'),
(9110081508, 'Jan', 'Kolář', 'Přehýšov 214', 111, 703848321, '1991-10-08'),
(9805233680, 'Kevin', 'Červeňák', 'Guldenerova 4, Plzeň', 207, 604568234, '1998-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `Date` date NOT NULL,
  `Patient_id` bigint(20) UNSIGNED NOT NULL,
  `Medicine_id` int(11) UNSIGNED NOT NULL,
  `Commentary` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`Date`, `Patient_id`, `Medicine_id`, `Commentary`) VALUES
('2024-01-15', 8958151334, 14, '1/2 - 1/2 - 1 tableta'),
('2024-05-11', 8302075738, 10, '1 tableta po 6 hodinách'),
('2024-07-08', 8302071646, 5, '2x denně při bolesti'),
('2024-08-15', 9805233680, 1, '1 injekce denně'),
('2024-10-02', 9110081508, 6, 'Při bolesti'),
('2024-10-15', 466224231, 13, '1 tableta po 8 hodinách'),
('2024-10-15', 466224231, 17, '2 tablety 3x denně'),
('2024-11-22', 8958151334, 11, '1 tableta po 12 hodinách');

-- --------------------------------------------------------

--
-- Table structure for table `sickness_certificate`
--

CREATE TABLE `sickness_certificate` (
  `Patient_id` bigint(20) UNSIGNED NOT NULL,
  `Date_beginning` date NOT NULL,
  `Date_end` date DEFAULT NULL,
  `Active_address` varchar(255) NOT NULL,
  `Employer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sickness_certificate`
--

INSERT INTO `sickness_certificate` (`Patient_id`, `Date_beginning`, `Date_end`, `Active_address`, `Employer`) VALUES
(203014713, '2024-11-25', NULL, 'Koterovská 37, Plzeň', 'Škoda Transportation'),
(8302071646, '2024-07-08', '2024-08-15', 'Nerudova 3, Plzeň', 'Restaurace U oběšence'),
(8958151334, '2024-01-15', '2024-02-02', 'Kamínková 12, Plzeň', 'Magistrát města Plzně'),
(8958151334, '2024-11-22', NULL, 'Radyňská 123, Starý Plzenec', 'Magistrát města Plzně'),
(9110081508, '2024-03-11', '2024-03-21', 'Přehýšov 214', 'Zemědělské družstvo Blatnice'),
(9110081508, '2024-10-02', '2024-10-05', 'Přehýšov 214', 'Novemcar Město Tauškov');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `diagnostic_record`
--
ALTER TABLE `diagnostic_record`
  ADD PRIMARY KEY (`Date`,`Patient_id`,`Diagnosis_id`) USING BTREE,
  ADD KEY `diagnostika_pacient_foreign` (`Patient_id`),
  ADD KEY `diagnostika_diagnoza_foreign` (`Diagnosis_id`);

--
-- Indexes for table `interaction`
--
ALTER TABLE `interaction`
  ADD PRIMARY KEY (`Queried_substance`,`Found_substance`) USING BTREE,
  ADD KEY `interakce_zjistena_latka_foreign` (`Found_substance`);

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `lecivo_leciva_latka_foreign` (`Medicinal_substance`);

--
-- Indexes for table `medicinal_substance`
--
ALTER TABLE `medicinal_substance`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`Birth_certificate_number`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`Date`,`Patient_id`,`Medicine_id`) USING BTREE,
  ADD KEY `Pacient_foreign` (`Patient_id`),
  ADD KEY `Lecivo_foreign` (`Medicine_id`);

--
-- Indexes for table `sickness_certificate`
--
ALTER TABLE `sickness_certificate`
  ADD PRIMARY KEY (`Patient_id`,`Date_beginning`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diagnosis`
--
ALTER TABLE `diagnosis`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `medication`
--
ALTER TABLE `medication`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diagnostic_record`
--
ALTER TABLE `diagnostic_record`
  ADD CONSTRAINT `diagnostika_diagnoza_foreign` FOREIGN KEY (`Diagnosis_id`) REFERENCES `diagnosis` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `diagnostika_pacient_foreign` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`Birth_certificate_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `interaction`
--
ALTER TABLE `interaction`
  ADD CONSTRAINT `interakce_zjistena_latka_foreign` FOREIGN KEY (`Found_substance`) REFERENCES `medicinal_substance` (`Name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `interakce_zjistovana_latka_foreign` FOREIGN KEY (`Queried_substance`) REFERENCES `medicinal_substance` (`Name`);

--
-- Constraints for table `medication`
--
ALTER TABLE `medication`
  ADD CONSTRAINT `lecivo_leciva_latka_foreign` FOREIGN KEY (`Medicinal_substance`) REFERENCES `medicinal_substance` (`Name`);

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `Lecivo_foreign` FOREIGN KEY (`Medicine_id`) REFERENCES `medication` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Pacient_foreign` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`Birth_certificate_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sickness_certificate`
--
ALTER TABLE `sickness_certificate`
  ADD CONSTRAINT `neschopenka_pacient_foreign` FOREIGN KEY (`Patient_id`) REFERENCES `patient` (`Birth_certificate_number`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
