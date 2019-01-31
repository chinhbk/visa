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
-- Table structure for table `PROCESSING_TIME_TYPE`
--

CREATE TABLE `PROCESSING_TIME_TYPE` (
  `ID` smallint(6) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `PURPOSE_OF_VISIT` varchar(20) NOT NULL DEFAULT 'TOURIST VISA',
  `IS_SHOW` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `PROCESSING_TIME_TYPE`
--

INSERT INTO `PROCESSING_TIME_TYPE` (`ID`, `NAME`, `PURPOSE_OF_VISIT`, `IS_SHOW`) VALUES
(1, 'Normal - 2 working days (MON-FRI)', 'TOURIST VISA', 1),
(2, 'Urgent - 1 working day (MON-FRI)', 'TOURIST VISA', 1),
(3, 'Urgent - 8 working hours (MON-FRI)', 'TOURIST VISA', 1),
(4, 'Urgent - 4 working hours (MON-FRI)', 'TOURIST VISA', 1),
(5, 'Urgent - 2 working hours (MON-FRI)', 'TOURIST VISA', 1),
(6, 'Urgent - 30 minutes (MON-FRI)', 'TOURIST VISA', 1),
(7, 'Urgent - 15 minutes (MON-FRI)', 'TOURIST VISA', 1),
(8, 'Urgent - holiday', 'TOURIST VISA', 1),
(9, 'Normal - 3,4 working days (MON-FRI)', 'BUSINESS VISA', 1),
(10, 'Urgent - 2 working days (MON-FRI)', 'BUSINESS VISA', 1),
(11, 'Urgent - holiday', 'BUSINESS VISA', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `PROCESSING_TIME_TYPE`
--
ALTER TABLE `PROCESSING_TIME_TYPE`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `PROCESSING_TIME_TYPE`
--
ALTER TABLE `PROCESSING_TIME_TYPE`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
