-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2019 at 09:53 AM
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
-- Table structure for table `VISA_SETTING`
--

CREATE TABLE `VISA_SETTING` (
  `NAME` varchar(100) NOT NULL,
  `VALUE` int(11) DEFAULT NULL,
  `TEXT` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `VISA_SETTING`
--

INSERT INTO `VISA_SETTING` (`NAME`, `VALUE`, `TEXT`) VALUES
('Belarus', NULL, '15'),
('Brunei', NULL, '14'),
('Demark', NULL, '15'),
('Finland', NULL, '15'),
('France', NULL, '15'),
('Germany', NULL, '15'),
('Indonesia', NULL, '30'),
('Italy', NULL, '15'),
('Japan', NULL, '15'),
('Laos', NULL, '30'),
('Malaysia', NULL, '30'),
('Norway', NULL, '15'),
('Number Of Visa', 6, NULL),
('Private Visa Letter', 15, NULL),
('Russia', NULL, '15'),
('Singapore', NULL, '30'),
('South of Korea', NULL, '15'),
('Spain', NULL, '15'),
('Sweden', NULL, '15'),
('Thailand', NULL, '30'),
('The Philippines', NULL, '21'),
('The united of Kingdom', NULL, '15'),
('Visa Exemption', NULL, 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `VISA_SETTING`
--
ALTER TABLE `VISA_SETTING`
  ADD PRIMARY KEY (`NAME`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
