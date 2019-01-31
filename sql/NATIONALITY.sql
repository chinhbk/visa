-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2019 at 11:41 AM
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
-- Table structure for table `NATIONALITY`
--

CREATE TABLE `NATIONALITY` (
  `ID` smallint(6) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `IS_DIFFICULT` tinyint(4) NOT NULL DEFAULT '0',
  `IS_SHOW` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `NATIONALITY`
--

INSERT INTO `NATIONALITY` (`ID`, `NAME`, `IS_DIFFICULT`, `IS_SHOW`) VALUES
(1, 'Argentina', 0, 1),
(2, 'Armenia', 0, 1),
(3, 'Azerbaijan', 0, 1),
(4, 'Albania', 0, 1),
(5, 'India', 0, 1),
(6, 'Poland', 0, 1),
(7, 'Belarus', 0, 1),
(8, 'Australia', 0, 1),
(9, 'Austria', 0, 1),
(10, 'Belgium', 0, 1),
(11, 'Bosnia and Herzegovina', 0, 1),
(12, 'Brazil', 0, 1),
(13, 'Bulgaria', 0, 1),
(14, 'Canada', 0, 1),
(15, 'Chile', 0, 1),
(16, 'China', 0, 1),
(17, 'Colombia', 0, 1),
(18, 'Costa Rica', 0, 1),
(19, 'Cyprus', 0, 1),
(20, 'Czech Republic', 0, 1),
(21, 'Croatia', 0, 1),
(22, 'Demark', 0, 1),
(23, 'Dominican Republic', 0, 1),
(24, 'Estonia', 0, 1),
(25, 'Finland', 0, 1),
(26, 'France', 0, 1),
(27, 'Georgia', 0, 1),
(28, 'Germany', 0, 1),
(29, 'Greece', 0, 1),
(30, 'Guatemala', 0, 1),
(31, 'Honduras', 0, 1),
(32, 'Hungary', 0, 1),
(33, 'Indonesia', 0, 1),
(34, 'Ireland', 0, 1),
(35, 'Iceland', 0, 1),
(36, 'Israel', 0, 1),
(37, 'Italy', 0, 1),
(38, 'Japan', 0, 1),
(39, 'Kazakhstan', 0, 1),
(40, 'Latvia', 0, 1),
(41, 'Liechtenstein', 0, 1),
(42, 'Lithuania', 0, 1),
(43, 'Luxembourg', 0, 1),
(44, 'Macedonia', 0, 1),
(45, 'Malaysia', 0, 1),
(46, 'Malta', 0, 1),
(47, 'Mexico', 0, 1),
(48, 'Moldova', 0, 1),
(49, 'Montenegro', 0, 1),
(50, 'Netherlands', 0, 1),
(51, 'New Zealand', 0, 1),
(52, 'Nicaragua', 0, 1),
(53, 'Norway', 0, 1),
(54, 'Papua new guinea', 0, 1),
(55, 'Panama', 0, 1),
(56, 'Peru', 0, 1),
(57, 'Portugal', 0, 1),
(58, 'Puerto Rico', 0, 1),
(59, 'Romania', 0, 1),
(60, 'Russia', 0, 1),
(61, 'Serbia', 0, 1),
(62, 'Slovakia', 0, 1),
(63, 'Slovenia', 0, 1),
(64, 'South Africa', 0, 1),
(65, 'South Korea', 0, 1),
(66, 'Spain', 0, 1),
(67, 'Sweden', 0, 1),
(68, 'Switzerland', 0, 1),
(69, 'Thailand', 0, 1),
(70, 'Trinidad Tobago', 0, 1),
(71, 'Ukraine', 0, 1),
(72, 'Uruguay', 0, 1),
(73, 'United Kingdom', 0, 1),
(74, 'United States', 0, 1),
(75, 'Uzbekistan', 0, 1),
(76, 'Bangladesh', 1, 1),
(77, 'Srilanka', 1, 1),
(78, 'Iran', 1, 1),
(79, 'Iraq', 1, 1),
(80, 'Libi', 1, 1),
(81, 'Xiri', 1, 1),
(82, 'Afghanistan', 1, 1),
(83, 'Pakistan', 1, 1),
(84, 'Congo', 1, 1),
(85, 'Mozambique', 1, 1),
(86, 'Ghana', 1, 1),
(87, 'Sierra Leon', 1, 1),
(88, 'Liberia', 1, 1),
(89, 'Libang', 1, 1),
(90, 'Yemen', 1, 1),
(91, 'Turkey', 1, 1),
(92, 'Cameroon', 1, 1),
(93, 'Maroc', 1, 1),
(94, 'Kenya', 1, 1),
(95, 'Jordan', 1, 1),
(96, 'Saudi Arabia', 1, 1),
(97, 'Kuwat', 1, 1),
(98, 'Gunie', 1, 1),
(99, 'Senegal', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `NATIONALITY`
--
ALTER TABLE `NATIONALITY`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `NATIONALITY`
--
ALTER TABLE `NATIONALITY`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
