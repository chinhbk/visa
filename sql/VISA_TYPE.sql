-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2019 at 11:42 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vie17981_visa_tour`
--

-- --------------------------------------------------------

--
-- Table structure for table `VISA_TYPE`
--

CREATE TABLE `VISA_TYPE` (
  `ID` smallint(6) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `PURPOSE_OF_VISIT` varchar(20) DEFAULT 'TOURIST VISA',
  `IS_SHOW` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `VISA_TYPE`
--

INSERT INTO `VISA_TYPE` (`ID`, `NAME`, `PURPOSE_OF_VISIT`, `IS_SHOW`) VALUES
(1, '1 Month Single Entry', 'TOURIST VISA', 1),
(2, '1 Month Multiple Entry', 'TOURIST VISA', 1),
(3, '3 Months Single Entry', 'TOURIST VISA', 1),
(4, '3 Months Multiple Entry', 'TOURIST VISA', 1),
(5, '6 Months Multiple Entry', 'TOURIST VISA', 1),
(6, '1 Year Multiple Entry', 'TOURIST VISA', 1),
(7, '1 Month Single Entry', 'BUSINESS VISA', 1),
(8, '1 Month Multiple Entry', 'BUSINESS VISA', 1),
(9, '3 Months Single Entry', 'BUSINESS VISA', 1),
(10, '3 Months Multiple Entry', 'BUSINESS VISA', 1),
(11, '6 Months Multiple Entry', 'BUSINESS VISA', 1),
(12, '1 Year Multiple Entry', 'BUSINESS VISA', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `VISA_TYPE`
--
ALTER TABLE `VISA_TYPE`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `VISA_TYPE`
--
ALTER TABLE `VISA_TYPE`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
