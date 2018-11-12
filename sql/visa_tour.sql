-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2018 at 11:47 AM
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
-- Database: `visa_tour`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `ID` int(11) NOT NULL,
  `IMAGE` varchar(100) DEFAULT NULL,
  `STATUS` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`ID`, `IMAGE`, `STATUS`) VALUES
(1, '/uploads/1420795751.jpg', 0),
(2, '/uploads/1420710321.jpg', 1),
(3, '/uploads/1420710328.jpg', 1),
(4, '/uploads/1420710335.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `NEWS_TYPE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(200) DEFAULT NULL,
  `SMALL_IMAGE` varchar(200) DEFAULT NULL,
  `SUMMARY` text,
  `CONTENT` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`ID`, `NEWS_TYPE_ID`, `TITLE`, `SMALL_IMAGE`, `SUMMARY`, `CONTENT`) VALUES
(1, 1, 'abc', '/uploads/1420711926.jpg', '123gggggggggggggggggggggggggggg', '<p>fassssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss</p>'),
(2, 3, 'ccccccccccccccccccccccccccccccccccccccccccccccc', '<br />\r\n<b>Notice</b>:  Undefined property: Application_Model_News::$image in <b>D:\\Web\\domains\\haraku\\public_html\\application\\models\\News.php</b> on line <b>37</b><br />\r\n', '1112222222222222222222', '<p>hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/5a4fc1a11b73b6fc10b36b72384bed7d17b72afa.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p>'),
(3, 2, 'rrrrrrrrrrrrrrr', '/uploads/1420712605.jpg', 'aaaaaaaaaaaaaaaaaa', '<p>ddddddddddddddddddddddrrrrrrrrrrrrrrrrrrrrgggggggggggggggggfffffffffffffff</p>'),
(4, 2, 'b', '/uploads/1420713248.jpg', 'b', '<p>b<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/6944cc15cefe338f8cb14311011e3dcd53855f57.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin: 10px 0px;\"></span></p>'),
(5, 1, 'cc', '/uploads/1420713273.jpg', 'ccvv', '<p>vvvv<span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/d1a570f480cc92d2b844e23a8ecb3f151b3918dd.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p>');

-- --------------------------------------------------------

--
-- Table structure for table `news_type`
--

CREATE TABLE `news_type` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news_type`
--

INSERT INTO `news_type` (`ID`, `NAME`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `PROVINCE` varchar(45) DEFAULT NULL,
  `ADDRESS` text,
  `IS_SHIP` tinyint(1) DEFAULT NULL,
  `SHIP_CODE` varchar(20) DEFAULT NULL,
  `STATUS` tinyint(11) DEFAULT NULL,
  `NOTE` text,
  `CREATE_DATE` datetime DEFAULT NULL,
  `UPDATE_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`ID`, `NAME`, `PHONE`, `EMAIL`, `PROVINCE`, `ADDRESS`, `IS_SHIP`, `SHIP_CODE`, `STATUS`, `NOTE`, `CREATE_DATE`, `UPDATE_DATE`) VALUES
(10, 'chinh', '0949201088', 'chinh.vu@samsung.com', 'Hà Nội', '		zzzzzzzzzzzz			', 1, '123', 6, '	AAA				', '2015-01-07 09:34:29', '2015-01-08 14:41:02'),
(11, 'chinh', '0949201088', 'chinhbk88@gmail.com', 'Hà Nội', 'aaa', 0, NULL, 5, '		aaaa			', '2015-01-07 09:36:08', '2015-01-08 11:23:07'),
(12, 'Dong Lam', '1021281820', 'zz@gg.com', 'TP Hồ Chí Minh', 'ZZZZZZZZZZZZZDDDDDDDDDDDDDD					', 1, '121xssssx', 6, '	zzzzzzzzzzzzzzzzzcccc				', '2015-01-08 11:26:15', '2015-01-08 11:35:12'),
(13, 'rrr', '0301983913', 'rrrrrr', 'Hà Nội', '	rrrrrrrrrrrrrrrrrrrrrrrrr				', 1, NULL, 0, '	ttdgg				', '2015-01-09 11:09:15', '2015-01-09 11:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `ID` int(11) NOT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `PRODUCT_ID` int(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DISCOUNT_PRICE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`ID`, `ORDER_ID`, `PRODUCT_ID`, `QUANTITY`, `PRICE`, `DISCOUNT_PRICE`) VALUES
(9, 10, 2, 3, 200000, 190000),
(10, 10, 3, 3, 190000, 190000),
(11, 11, 2, 1, 200000, 190000),
(12, 11, 3, 2, 190000, 190000),
(13, 12, 2, 5, 200000, 190000),
(14, 12, 3, 7, 190000, 190000),
(15, 13, 4, 2, 100000, NULL),
(16, 13, 3, 3, 190000, 190000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `PRODUCT_TYPE_ID` int(11) DEFAULT NULL,
  `SUB_PRODUCT_TYPE_ID` int(11) DEFAULT NULL,
  `CODE` varchar(100) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DISCOUNT_PRICE` int(11) DEFAULT NULL,
  `IMAGE_MAIN` text,
  `IMAGE_SECOND` text,
  `IMAGE_THIRD` text,
  `PROMOTION` text,
  `SHORT_DESC` text,
  `DETAILS` text,
  `IS_TYPE_PRIORITY` tinyint(1) DEFAULT NULL,
  `IS_SUBTYPE_PRIORITY` tinyint(1) DEFAULT NULL,
  `IS_HOT` tinyint(1) DEFAULT NULL,
  `COLOR` varchar(10) DEFAULT NULL,
  `MATERIAL` varchar(10) DEFAULT NULL,
  `ORIGIN` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `PRODUCT_TYPE_ID`, `SUB_PRODUCT_TYPE_ID`, `CODE`, `NAME`, `PRICE`, `DISCOUNT_PRICE`, `IMAGE_MAIN`, `IMAGE_SECOND`, `IMAGE_THIRD`, `PROMOTION`, `SHORT_DESC`, `DETAILS`, `IS_TYPE_PRIORITY`, `IS_SUBTYPE_PRIORITY`, `IS_HOT`, `COLOR`, `MATERIAL`, `ORIGIN`) VALUES
(2, 1, NULL, 'code12222', 'name', 200000, 190000, '/uploads/1420514601.jpg', '/uploads/1420527441.jpg', '/uploads/1420532218.jpg', 'kkmkmmkk', 'aaaaa', '<p>bbb</p>', 1, 1, 1, 'nau', 'da', 'Trung Quoc'),
(3, 2, 14, '11111', 'abc', 190000, 190000, '/uploads/1420611238.jpg', NULL, NULL, NULL, '', '<p><br></p>', 1, 1, 1, '', '', ''),
(4, 2, 14, '123', 'ccccdddddddd', 100000, NULL, '/uploads/1420775236.jpg', NULL, NULL, '', '', '<p><br></p>', 1, 1, 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`ID`, `NAME`, `PARENT_ID`) VALUES
(1, 'Home', NULL),
(2, 'Visa', NULL),
(3, 'VietNam Tours', NULL),
(4, 'Southeast Asia Tours ', NULL),
(5, 'Best Selling Tours', NULL),
(8, 'Apply Online', 2),
(9, 'FAQ', 2),
(12, 'Ha Long Bay', 3),
(13, 'Nha Trang & Phu Yen', 3),
(14, 'Phu Quoc', 3),
(15, 'Singapore', 4),
(16, 'China', 4),
(17, 'Cambodia', 4);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `ID` char(32) DEFAULT NULL,
  `NAME` char(32) DEFAULT NULL,
  `MODIFIED` int(11) DEFAULT NULL,
  `LIFETIME` int(11) DEFAULT NULL,
  `DATA` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`ID`, `NAME`, `MODIFIED`, `LIFETIME`, `DATA`) VALUES
('sas1h128ue1m6uv6rngtvbd1e2', NULL, 1541763304, 300, 'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),
('4ar0gdl3fkuakot440oillocp2', NULL, 1542008051, 300, ''),
('kouug5ohktj85ascam6j8a4gp5', NULL, 1542019454, 300, 'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),
('q9rk1duiml67b4ib333rd6v373', NULL, 1542018627, 300, ''),
('psq82bm0eu88rmsli8o685ip45', NULL, 1542018827, 300, '');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `TOUR_TYPE_ID` int(11) NOT NULL,
  `SHORT_DESC` text,
  `IMAGE_SMALL` varchar(100) DEFAULT NULL,
  `IMAGE` varchar(100) DEFAULT NULL,
  `CODE` varchar(100) DEFAULT NULL,
  `DURATION` varchar(100) DEFAULT NULL,
  `PRICE` int(11) DEFAULT NULL,
  `DETAILS` text,
  `IS_HOT` tinyint(1) DEFAULT NULL,
  `CREATE_DATE` datetime DEFAULT NULL,
  `UPDATE_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`TOUR_TYPE_ID`, `SHORT_DESC`, `IMAGE_SMALL`, `IMAGE`, `CODE`, `DURATION`, `PRICE`, `DETAILS`, `IS_HOT`, `CREATE_DATE`, `UPDATE_DATE`) VALUES
(23, 'we offer Daily group tour to visit Ninh Binh - Hoa Lu- Tam coc price: $ 65 group tour max 9', '/uploads/1541763302.jpg', '/uploads/1541753489.jpg', 'S01', '1 day', 55, '<p><br></p><p><span><strong>Tour Price : 55&nbsp;</strong>usd / person</span></p><p><strong>t</strong><span><span><strong>ype of tour : group tour max 9 people on a mini Van&nbsp;</strong></span></span></p><p><span>&nbsp;</span><span><span><strong>Why our tour :&nbsp;</strong></span></span>we do hight quality of group tour max 9 people on mini Van of 16 seat, we start the tour abit early but on the tour very relax and visit more place in Ninh, as you know Ninh binh have a lot of place must see and visit, mostly group tour only make for you option visit Hoa lu -Tam Coc or Bai Dinh trang An, just visit 2 places only you will be miss some importain place to visit in Ninh binh, our Minh binh daily group tour we will take you by small group and take you to see more places, on our tour will take you go to visit - Hoa Lu, trang an cruise by bamboo boat, and visit the biggest pagoda in south east asia call Bai Binh pagoda</p><p><br></p><p><span>&nbsp;</span><br></p><p><br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><div><span><span><strong>07:00 – 7:40&nbsp;</strong>&nbsp;Get picked up by our tour guide and car then depart for&nbsp;<strong>Ninh Binh province</strong>&nbsp;(90 km south of Hanoi). Have a break 20 minutes half way to relax and experience Vietnamese handicraft products such as lacquer wares, paintings, embroideries…</span></span></div><div><span><span><strong>10:00</strong>&nbsp;Arrive to Ninh Binh our fisrt stop to visit Hoa Lu ancient capital of vietnam from 968 you will visit Dinh And Le temple after visit Dinh and le temple our tour continue to visit&nbsp;<b>Mua Cave,</b>&nbsp;from Mua cave you will have chance to climb up to the top of the mountain of the looftop to see over view of Ninh binh it also one of the most beautiful place to see the view in Ninh Binh, where can see the city far from the standing in front of Tam Coc in back and the limestone mountain along to the south of Vietnam.after visit all then we continue to Tam coc, you will take by bamboo boat explore 3 cave we call them the name tam coc, after cruise by bamboo boat for over 1 hours, after finish boat trip in tam coc will have lunch at local restaurant then we will have some time for you cycling&nbsp;</span></span></div><div><span><span><strong>CYCLING RIDE (optional)</strong>: Those who love to explore real countryside images of Vietnam can proceed a&nbsp;<strong>40 minute cycling ride</strong>&nbsp;along country lane (from Tam Coc to&nbsp;<strong>Bich Dong Pagoda</strong>, estimated time 40 minutes for 5km cycling 2 ways), experiencing the beautiful scenery of lush paddy fields. Finish the cycling&nbsp; then our van will take you back to hanoi&nbsp;</span></span></div><div><span><span><strong>18:00</strong>&nbsp;Arrive in&nbsp;<strong>Hanoi</strong>. Tour ends.</span></span></div><p>---------</p>', 1, '2018-09-11 15:52:29', '2018-09-11 18:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `tour_type`
--

CREATE TABLE `tour_type` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tour_type`
--

INSERT INTO `tour_type` (`ID`, `NAME`, `PARENT_ID`) VALUES
(1, 'VietNam Tours', NULL),
(2, ' Ninh Binh Daily Tour', 1),
(3, ' Hanoi Daily Day Tours', 1),
(4, ' Vietnam Package Tours', 1),
(5, 'Hanoi -Halong -Sapa- Ninh Binh', 1),
(6, 'Tour To Sapa', 1),
(7, 'Hoa Lu - Tam Coc  Daily Group', 2),
(8, 'Bai Dinh Trang An 1 day tour', 2),
(23, 'HOA LU - TAM COC DAILY TOUR', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(45) DEFAULT NULL,
  `USER_NAME` varchar(20) DEFAULT NULL,
  `PASSWORD` varchar(45) DEFAULT NULL,
  `ROLE` tinyint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `NAME`, `USER_NAME`, `PASSWORD`, `ROLE`) VALUES
(1, NULL, 'admin', 'admin', 0),
(2, NULL, 'admin_product', '678', 1),
(3, NULL, 'admin_order', 'admin_order', 2),
(4, NULL, 'admin_news', 'admin_news', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `news_type`
--
ALTER TABLE `news_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`TOUR_TYPE_ID`);

--
-- Indexes for table `tour_type`
--
ALTER TABLE `tour_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `news_type`
--
ALTER TABLE `news_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tour_type`
--
ALTER TABLE `tour_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
