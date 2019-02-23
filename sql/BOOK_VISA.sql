-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2019 at 11:34 AM
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
-- Table structure for table `BOOK_VISA`
--

CREATE TABLE `BOOK_VISA` (
  `ID` int(11) NOT NULL,
  `CODE` varchar(15) NOT NULL,
  `PURPOSE_OF_VISIT` varchar(20) NOT NULL,
  `VISA_TYPE_ID` int(11) NOT NULL,
  `PROCESSING_TIME_TYPE_ID` int(10) NOT NULL,
  `VISA_LETTER` varchar(20) NOT NULL,
  `NUMBER_OF_VISA` tinyint(4) NOT NULL,
  `PRICE_DETAIL` varchar(2000) NOT NULL,
  `TOTAL_PRICE` float NOT NULL,
  `ARRIVAL_DATE` varchar(20) NOT NULL,
  `PAYMENT` varchar(100) DEFAULT NULL,
  `ARRIVAL_AIRPORT` varchar(50) NOT NULL,
  `CONTACT_NAME` varchar(500) NOT NULL,
  `CONTACT_EMAIL` varchar(100) NOT NULL,
  `CONTACT_PHONE` varchar(20) NOT NULL,
  `CREATE_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `UPDATE_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `STATUS` varchar(10) NOT NULL DEFAULT 'NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BOOK_VISA`
--
ALTER TABLE `BOOK_VISA`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `CODE` (`CODE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BOOK_VISA`
--
ALTER TABLE `BOOK_VISA`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;