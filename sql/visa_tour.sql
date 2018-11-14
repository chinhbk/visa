-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 12:13 PM
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
('kouug5ohktj85ascam6j8a4gp5', NULL, 1542106989, 300, 'Zend_Auth|a:1:{s:7:\"storage\";O:8:\"stdClass\":5:{s:2:\"ID\";s:1:\"1\";s:4:\"NAME\";N;s:9:\"USER_NAME\";s:5:\"admin\";s:8:\"PASSWORD\";s:5:\"admin\";s:4:\"ROLE\";s:1:\"0\";}}'),
('ru8f22n71up90rh0vr3pj6t776', NULL, 1542105935, 300, ''),
('4q9er2v86cj5eumburacuvu405', NULL, 1542105960, 300, ''),
('hg7s9tetjnvo8dvkdsqpljb5q2', NULL, 1542105983, 300, ''),
('vucgdcv67e38qhmq7m9ldg1bg0', NULL, 1542106040, 300, ''),
('hnqmtkd3sc70btkim6nif92i12', NULL, 1542106079, 300, ''),
('it02kuvjvvdkmqad752teo3561', NULL, 1542106089, 300, ''),
('u7k71nmojml2gonulr13a8i206', NULL, 1542106139, 300, ''),
('vpbup4kb4nmc8v7t5opg2jmvj5', NULL, 1542106173, 300, ''),
('muk47mr9v72hhf0fib3iq8jo44', NULL, 1542106201, 300, ''),
('ldsafkfs6c852n22p50519kap6', NULL, 1542106205, 300, ''),
('2hkm1mnbambvcn3ahlir6jris0', NULL, 1542106227, 300, ''),
('a3qljdc4bsnph6m9r22stcfav5', NULL, 1542106274, 300, ''),
('8c9j9un3jk824dk9ib1bk3mi62', NULL, 1542106312, 300, ''),
('uvkojjnknjqvus0b5bntvpjt81', NULL, 1542106345, 300, ''),
('85dkaasno51baj3j9p55auo0r1', NULL, 1542106378, 300, ''),
('bk7to504qb06dnuu4pfj924bc0', NULL, 1542106421, 300, ''),
('cbltq0ssuvkqlet6o0q8t0c3l4', NULL, 1542106458, 300, ''),
('km0oaer3shou757rtp8k6168u4', NULL, 1542106466, 300, ''),
('dsi0uj8a0n31d2kl4erm52r501', NULL, 1542106532, 300, ''),
('bdf28ss1puub63as0lbilrl4v2', NULL, 1542106558, 300, ''),
('m0n5f4kai3tdbcrav36r5uqed5', NULL, 1542106569, 300, ''),
('2vc5ush89nbeqh2j7tqe2ofvb3', NULL, 1542106593, 300, ''),
('vn3b0n3u8t589kbesejk80jgk1', NULL, 1542106614, 300, ''),
('3cog4c2935q13lfbgur0b6s2j1', NULL, 1542106627, 300, ''),
('gvtqekb37ejiqiai3kvb36nks5', NULL, 1542106629, 300, ''),
('ivonc4nqp8caccgdj8uqcvmpu7', NULL, 1542106708, 300, ''),
('j1p3kmdc0bki4g4h3f5e1kmcq4', NULL, 1542106711, 300, ''),
('a0943i1c57tjittttdq4hfsuh6', NULL, 1542106720, 300, ''),
('vlr12ec39qtecd7m7gf92p8j35', NULL, 1542106723, 300, ''),
('e504pbaj3d57ltiu4jirlcbi70', NULL, 1542106727, 300, ''),
('jbr4kfk22moea37uuqf6n9leh5', NULL, 1542106729, 300, ''),
('h2cclj94tv2f5lj3vt2jbh4p72', NULL, 1542106737, 300, ''),
('0329ufi2qdduiml3vke3jpvub6', NULL, 1542106838, 300, ''),
('diav5tebeuiblk7c1ks3c5gmf7', NULL, 1542106881, 300, ''),
('92ckdjva8i83nin13k8pbj09f5', NULL, 1542106895, 300, ''),
('bi60qa83fj7gi7fvbj3i8qdpd4', NULL, 1542106900, 300, ''),
('febfbabduev0h9gnbtpj24bb06', NULL, 1542106902, 300, ''),
('s7rhl10l4f2rba0ifo37demln3', NULL, 1542106962, 300, ''),
('p3c2cvn7toq1l5di38k60d8om3', NULL, 1542106987, 300, ''),
('6oiiqa7jbtk2q589spdneqlod3', NULL, 1542106989, 300, '');

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
(23, 'A trip to Vietnam would not be complete without a few days of relaxation, and idyllic Hoa Lu rates amongst Vietnam\'s most secluded destinations', '/uploads/1541763302.jpg', '/uploads/1541753489.jpg', 'S01', '1 day', 55, '<p><br></p><p><span><strong>Tour Price : 55&nbsp;</strong>usd / person</span></p><p><strong>t</strong><span><span><strong>ype of tour : group tour max 9 people on a mini Van&nbsp;</strong></span></span></p><p><span>&nbsp;</span><span><span><strong>Why our tour :&nbsp;</strong></span></span>we do hight quality of group tour max 9 people on mini Van of 16 seat, we start the tour abit early but on the tour very relax and visit more place in Ninh, as you know Ninh binh have a lot of place must see and visit, mostly group tour only make for you option visit Hoa lu -Tam Coc or Bai Dinh trang An, just visit 2 places only you will be miss some importain place to visit in Ninh binh, our Minh binh daily group tour we will take you by small group and take you to see more places, on our tour will take you go to visit - Hoa Lu, trang an cruise by bamboo boat, and visit the biggest pagoda in south east asia call Bai Binh pagoda</p><p><br></p><p><span>&nbsp;</span><br></p><p><br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><p>&nbsp;<br></p><div><span><span><strong>07:00 – 7:40&nbsp;</strong>&nbsp;Get picked up by our tour guide and car then depart for&nbsp;<strong>Ninh Binh province</strong>&nbsp;(90 km south of Hanoi). Have a break 20 minutes half way to relax and experience Vietnamese handicraft products such as lacquer wares, paintings, embroideries…</span></span></div><div><span><span><strong>10:00</strong>&nbsp;Arrive to Ninh Binh our fisrt stop to visit Hoa Lu ancient capital of vietnam from 968 you will visit Dinh And Le temple after visit Dinh and le temple our tour continue to visit&nbsp;<b>Mua Cave,</b>&nbsp;from Mua cave you will have chance to climb up to the top of the mountain of the looftop to see over view of Ninh binh it also one of the most beautiful place to see the view in Ninh Binh, where can see the city far from the standing in front of Tam Coc in back and the limestone mountain along to the south of Vietnam.after visit all then we continue to Tam coc, you will take by bamboo boat explore 3 cave we call them the name tam coc, after cruise by bamboo boat for over 1 hours, after finish boat trip in tam coc will have lunch at local restaurant then we will have some time for you cycling&nbsp;</span></span></div><div><span><span><strong>CYCLING RIDE (optional)</strong>: Those who love to explore real countryside images of Vietnam can proceed a&nbsp;<strong>40 minute cycling ride</strong>&nbsp;along country lane (from Tam Coc to&nbsp;<strong>Bich Dong Pagoda</strong>, estimated time 40 minutes for 5km cycling 2 ways), experiencing the beautiful scenery of lush paddy fields. Finish the cycling&nbsp; then our van will take you back to hanoi&nbsp;</span></span></div><div><span><span><strong>18:00</strong>&nbsp;Arrive in&nbsp;<strong>Hanoi</strong>. Tour ends.</span></span></div><p>---------</p>', 1, '2018-09-11 15:52:29', '2018-11-13 16:53:08'),
(26, 'A trip to Vietnam would not be complete without a few days of relaxation, and idyllic Bai Dinh rates amongst Vietnam\'s most secluded destinations', '/uploads/1542020941.JPG', '/uploads/1542020946.JPG', 'S02', '1 day', 57, '<p><br></p><p><span>&nbsp;<b>8.00AM</b>: Authentic vietnamt tours tour expert pick you up at your hotel by private car , travel to Ninh binh&nbsp;</span><strong><span><a href=\"http://www.indochinaclassictravel.com/vietnam-tours-detail/10/78/Bai-Dinh-Trang-An.html\" class=\"f-link\">visit trang an and Bai dinh&nbsp;</a></span></strong><span><br type=\"_moz\"></span><span>around 9 to 9:30 am &nbsp;Arrive &nbsp;to Bai dinh where you will amzing to see so huge of pagoda ,on the stop when you arrive you can see over view of the pagoda ,now you are start for trip to visit all pagoda ,before go inside pagoda we need to transport by electrict car ,and you start for walk inside pagoda to visit&nbsp;</span><span>500 La Han statues, biggest bronze Buddha statue in Vietnam 10 metre in height, 100 tons in weight.on the tour can lean some story from our tour guide about this pagoda&nbsp;</span></p><div><span>after visit pagoda around 12 :00 pm &nbsp; Have lunch at the local restaurant with an authentic local food ,after lunch we start to make our trip to discover Trang and with 8 grottoes by bamboo boat for you see the most amazing of the yen river where water flowing pass all of the grottoes &nbsp;about 3:30 pm we end our visit and back to hanoi about 5:30 pm&nbsp;</span></div><div>&nbsp;<br></div><div><div><span><strong>private tour Rate: This rate is quoted in usd &nbsp;per person,&nbsp;</strong>&nbsp;</span></div><div><span>&nbsp;</span></div><div><div><div><div><table><tbody><tr><td><span><strong>Group size</strong></span></td><td><span><strong>2 persons</strong></span></td><td><span><strong>4 persons</strong></span></td><td><span><strong>6 persons</strong></span></td><td><span><strong>8 persons</strong></span></td><td><span><strong>Single Supp</strong></span></td></tr><tr><td><span><strong>Land Tour/pp</strong></span></td><td><span><b>109</b></span></td><td><span><b>85</b></span></td><td><span><b>78</b></span></td><td><span><b>58</b></span></td><td><span><strong>-<br><br></strong></span></td></tr></tbody></table><span><strong>Tour cost included:</strong></span></div><div><span>• Full transportation by private car and private boat&nbsp;<br>• Full meals as indicated in the itinerary.&nbsp;<br>• English speaking guide.&nbsp;<br>• Entrance fees.</span></div><div><span>&nbsp; &nbsp;electrict car to pagoda&nbsp;<br>&nbsp;<br><strong>Tour cost excluded:</strong></span></div><div><span>&nbsp;• Personal insurance&nbsp;<br>&nbsp;• Expenditure of a personal nature and tips (such as drinks, souvenirs, laundry, emergency&nbsp;&nbsp;transfers &amp; etc)</span></div></div></div></div></div><p><br></p>', 0, '2018-12-11 18:09:27', '2018-11-13 16:52:43'),
(27, 'if you dont have much time and would like to see a lot of  Ninh binh?  ', '/uploads/1542102563.jpg', '/uploads/1542102570.jpg', 'S03', '1 day', 95, '<p><p><span><strong>Tour start every day :</strong>&nbsp;from Hanoi pick up by shutle bus transfer to Ninh binh take around 2 hours&nbsp;</span></p><div><span><strong>T</strong><strong>our Price : 95&nbsp;</strong>usd / person VND 2.156.000&nbsp;</span></div><div><span><strong>Type of tour :&nbsp;</strong>&nbsp;sit on the back of the bike with our driver, or you can ride your own bike if you truthly experience !</span></div><div><span>&nbsp;</span></div><div><span><strong>Why our tour like this :&nbsp;</strong>if you dont have much time and would like to see a lot of&nbsp; Ninh binh?&nbsp;&nbsp;</span></div><p>&nbsp;</p><div><span><b>are you</b>&nbsp; just have one day? and you would like to be verysafe? as you know why we do this tour like this have to transfer by shutle bus&nbsp; to Ninh binh, because the road to Ninh binh very busy the traffic very crazy if ride&nbsp;<strong>motorbike</strong>&nbsp;from hanoi to&nbsp;<strong>Ninh Binh</strong>,for 100km all ride throughthe city and it not safe at all that why we would like&nbsp; a tour must be sfae and visit a lot of Ninh binh for one day tour, so we use car to transfer you to Ninh binh but our tour start a bit early from 7 am tranfer to Ninh binh and will start motorbike tour at 9 am, our motorbike tour very differents we would like to take you to see more Ninh binh than an other tour nomolly do, for just in one day we could like to take you to see all of ninh binh like : Hoa lu, tam coc, tran an , bai dinh pagoda, rural villages rice paddies, and mua cave and ride pass must beautifull part of ninh binh, and also ride to visit some where tourist never been to or hear about where you truthly know and have authentic travel experience</span></div><div><span>&nbsp;</span></div><div><span><strong>Tour includes: shutle bus&nbsp;</strong>&nbsp;transfer to Ninh binh and back to hanoi&nbsp; , english speaking tour guide, all entry fees, nice motorbike and riders , all enry fees, Lunch, water on the way, boat cruise in Tam coc or trang An&nbsp;</span></div><div><span>&nbsp;</span></div><div><span><strong>Note :</strong>&nbsp;our&nbsp; tour flaxible could change of visiting in Binh binh&nbsp;</span></div><div><span>&nbsp;</span></div><div><span>The detail :&nbsp;<strong>At 6:30 am</strong>&nbsp; to 7:30 AM&nbsp; our tour guide will come to pick up you at your hotel stay in Hanoi, and will&nbsp; transfer you to Ninh Binh, it take around 2 hours max&nbsp; to get to Ninh Binh, from the tour if you could have breakfast at the hotel before we leave the be ok, if not on the hafl way we will stop for you to enjoy local breakfast by Pho&nbsp;After transfer to Ninh Binh arrive about 8:30 am then we start our motorbike to explore Ninh binh,&nbsp; our first place we will ride to pass the rural villages see the rice paddies abd visit local family to see how about the people live in countryside, then our team will take you to visit Bich Dong cave where you could climb to the top of the mountain to visit the temple, after visit&nbsp;<strong>Bich Dong</strong><strong>&nbsp;temple</strong>, we ride&nbsp;<strong>motorbike</strong>&nbsp;again to passing the rural way where tourist never know or hear about,&nbsp; where you can see beautifull view from here,then we continue to visit Thung nham where you can see great landscape, and we open for this tour option can continue to do the cruise in&nbsp;<strong>Binh binh</strong>&nbsp;Option for<strong>&nbsp;Tam Coc&nbsp;</strong>or&nbsp;<strong>Trang An</strong>&nbsp;just ask our tour guide, if do Tam coc will have 1,5 hours cruise in tam coc to see Amazing landscape, if you chose option for Trang An we will ride motorbike passing 2 villages you will see very beautfull lanscape from here, then arrive to trang an you will take by bamboo boat cruise around 2 hours, then will have lunch, after lunch will ride pass the vast rice paddies field then take you to Mua Cave where you can climb to the top of the mountain see over view of Ninh binh where you excally know Ninh is Halong on land, after looflop we continue ride motorbike pass Trang an, and continue to visit Hoa Lu, Hoa lu will be our last stop and tour will end in Hoa lu where we park our&nbsp;<strong>motorbike&nbsp;</strong>for our team take motorbike back place parking, our tour will finish at 3:30 To 4 pm will take you back to Hanoi around 5:40 to 6:00 pm</span></div><div><span>&nbsp;</span></div><div><span>&nbsp;</span><strong>For quick or last minutes Booking please whatsApp to book now! +84986259477 or Hotline call + 841639641221&nbsp;</strong></div><br></p>', 0, '2018-11-13 16:51:05', '2018-11-13 16:51:05'),
(28, 'A trip to Vietnam would not be complete without a few days of relaxation, and idyllic Duong lam rates amongst Vietnam\'s most secluded destinations', '/uploads/1542103100.jpeg', '/uploads/1542103033.jpeg', 'S04', '1 day', 0, '<p><br></p><p><span>Tour start dailty from 8 : 30 to 16 :30 pm&nbsp;</span></p><p><span>driver and tour guide &nbsp;from authentic vietnam tour come to pick up you at</span></p><p><span>8 :30 your hotel stay and head about 60 km west, to the historic village of Duong Lam in Ha Tay Province. Duong Lam is well-known not only for being ancient but also its laterite houses.where you meet and see local people very friendly and chance to see the most ancient houses in &nbsp;vietnam with architecture of 4 to 500 years old &nbsp;our guide will take you discover village and come to visit some house where you will meet the host will share with you the history of the viilage and how old of they house , after meet and visit the ancient house&nbsp;</span><span>&nbsp;Next active ride bicycles around the quiet village and through the country side, passing rice fields and farmers. We will have chances to stop at Phung Hung Temple and Mia Pagoda.</span></p><div><span>After lunch we will have some time to explore the village further and chat with the family. Then we will head to visit most beautifull and oldest pagoda in vietnam call<strong><a href=\"http://www.indochinaclassictravel.com/vietnam-tours-detail/10/79/Duong-lam-and-thay-pagoda-1-day.html\" class=\"f-link\">&nbsp;thay pagoda</a></strong>,in tha pagoda we can learn and see the most oldest architecture , which contains the largest wood statues in Vietnam. This is also where water puppetry originated. The trip concludes around 4:300 or 5 pm when we’re back to hotel.&nbsp;</span></div><p><br></p><div><div><strong>private tour Rate: This rate is quoted in usd &nbsp;per person,&nbsp;</strong>&nbsp;</div><div>&nbsp;</div><div><div><div><div><table><tbody><tr><td><strong>Group size</strong></td><td><strong>2 persons</strong></td><td><strong>4 persons</strong></td><td><strong>6 persons</strong></td><td><strong>8 persons</strong></td><td><strong>Single Supp</strong></td></tr><tr><td><strong>Land Tour/pp</strong></td><td><b>109</b></td><td><b>85</b></td><td><b>68</b></td><td><b>55</b></td><td><strong>-<br><br></strong></td></tr></tbody></table><strong>Tour cost included:</strong></div><div>• Full transportation by private car &nbsp;<br>• Lunch &nbsp;and solf drink .&nbsp;<br>• English speaking guide.&nbsp;<br>• Entrance fees.</div><div><span>&nbsp; &nbsp;bicycles</span></div><div><br>&nbsp;<br><strong>Tour cost excluded:</strong></div><div>&nbsp;• Personal insurance&nbsp;<br>&nbsp;• Expenditure of a personal nature and tips (such as drinks, souvenirs, laundry, emergency&nbsp;&nbsp;transfers &amp; etc)</div></div></div></div></div><p><br></p>', 1, '2018-11-13 16:57:18', '2018-11-13 16:58:23'),
(29, 'Hanoi vespa night tour we recommend you to do package tour', '/uploads/1542103593.jpg', '/uploads/1542103598.jpg', 'S10', '1 day', 0, '<p><p><span><strong><span><span>Hanoi vespa night tour</span></span></strong></span></p><p><span><strong><a href=\"http://www.indochinaclassictravel.com/\" class=\"f-link\"><span>&nbsp;</span>we recommend you to do package tour click here&nbsp;</a></strong></span></p><p><span>from 73 to 85 usd /person&nbsp;</span><span>depend How many people are you have&nbsp;</span></p><p>&nbsp;</p><p><span><strong>Duration:</strong>&nbsp;4 hours Tour starts daily at 6 - 10 pm or 10:30 pm</span></p><p><span><strong>Include:</strong>&nbsp;ClassicVespa scooters, safe driver, English speaking guide, food and drinks in the trip ,have free once &nbsp;drink swing bar&nbsp;</span></p><p><span>Don’t forget, this tour includes &nbsp;food &amp; drinks, so make sure to come with an empty stomach and a hunger for adventure!</span></p><p><span>Our&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Vespas&nbsp;</span></a>take guests to sample the best dishes that Vietnam has to offer! This is a great way to see parts of the city that most tourists don\'t get to see or even hear about. Taking you to the most popular street stalls, hidden alleyways and of course where the locals love to hang out with their friends.&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Vespa tours</span></a>&nbsp;start from your hotel, &nbsp;then drive you to a crowded street café where we experience the hustle and bustle of this city with popular lemon-tea drinks and sunflower seeds. Continuing to town in one of the most busy beautifull place for joung people come here to meeting friend and take photo from Opera houseThe tour then takes you to to see ceramic road and chuong duong bridge to have a glimpse of&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Hanoi</span></a>&nbsp;on the two banks of red river. The exciting ride in an organized chaos traffic takes us to local restaurant with authentic food and then take us to mall alley to try a different version of Pho a Vietnamese dish that is world famous and try many different food from here . A ride around the big lake is a super romantic sight of&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Hanoi</span></a>&nbsp;that most travelers rarely have a chance to see. Which you will experinece a big \"wow\" factor. This will surely make you say \"I’m happy that I did this trip\"! Moving forward with the tour, ride vespa around&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Hanoi</span></a>&nbsp;city drive pass Ho Chi Minh mausoleum,a few minute stop for egg coffe one of the most famus of coffe in hanoi &nbsp;,Now it\'s time to hang out with the young Hanoian crowd in a local Bar with live trendy music. Here you will have an opportunity to take the stage and perfom yourself or listen to local musical talent performing both in Vietnamese and English showing off their unique style.</span></p><p><span>Come with us on&nbsp;</span><span><a href=\"http://www.hanoivespatours.com/\" title=\"hanoi vespa tours\" class=\"f-link\"><span>Vespa Tours</span></a>&nbsp;and experience your own personal Hanoi, making new friendships.</span></p><p><span><br></span></p><p><span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/36cc78aaaf94e5bdc95ada4b984ee6ae6b65ec4d.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p><p><span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/81e9349ed40f8b6fca980e4796fabaf77872598e.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></p><p><span><br></span></p><br></p>', 0, '2018-11-13 17:08:36', '2018-11-13 17:08:36'),
(30, 'Providing a variety of colour and beauty of Vietnam diversity. Vietnam Insight will tantalize all of your senses. From the chaotic Hanoi to Halong...', '/uploads/1542104123.jpg', '/uploads/1542106946.jpg', 'S12', '3 day', 0, '<p><br></p><div><table width=\"200\"><tbody><tr><td><p></p></td><td><span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/3e1348f1030e397e36473fec46ae41110984f714.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin: 10px 0px;\"></span></td><td><span class=\"f-img-wrap\"><img alt=\"Image title\" src=\"/uploads/364623eb3edba62981ac5927ed12cb8011be6cf8.jpg\" width=\"300\" style=\"min-width: 16px; min-height: 16px; margin-bottom: 10px; margin-left: auto; margin-right: auto; margin-top: 10px\"></span></td></tr></tbody></table><br><p>&nbsp;&nbsp;<strong><span>Day 1: Arrive Hanoi</span>&nbsp;</strong></p><p><span>Arrive in Hanoi,&nbsp; is the capital of Vietnam with more than thousand years old.&nbsp; Airport welcome by Halong Travel guides with signboard.&nbsp; Transfer to hotel and lodging. In the afternoon, take small excursion in the 36 streets of the famous Old Quarter by cyclo, the Vietnamese version of the rickshaw.&nbsp; Dinner and Overnight at Hotel.</span></p><p><span><span><strong>Day 2: Hanoi&nbsp;</strong></span><br>Breakfast and visit the historical city of Hanoi. In the morning visit Ho Chi Minh\'s Mausoleum, and his private residence, the One Pillar Pagoda, Ho Chi Minh\'s Museum, the Temples of Quanthanh, next to the Lake West, the Temple of Literature (the first University of Vietnam - built in 1070) and the Museum of the Army. Lunch in the Forest Restaurant. in the afternoon, Free time to go shopping in Hang Gai street, famous for its stores of silk. The late afternoon we will attend the \"Water Puppet Show\" - a Vietnamese famous traditional art. Return to hotel.&nbsp;</span><span><br><strong><span>Day 3: Hanoi-Halong (B ,L,D)</span>&nbsp;</strong><br>Our guide pick you up from 8:00 am to 8:30 am at your hotel. Leave Hanoi by road for Halong Bay. Enjoy the journey through the rich farmlands of the Red River Delta and the scenery of rice fields, water buffalo and everyday Vietnamese village life. Arrive in Halong and board the&nbsp; traditional sailing junk. Whilst cruising the exquisite waters sample the regions fresh seafood.&nbsp; Annam Junk explores Halong bay on the most wonderful route: Dinh Huong island, Ga Choi Island, Dog Island, Sail island.&nbsp; Binh Phong mountain, Man’s head island, Tortoise island. Visit the zone of&nbsp; Man-made pearl growing center, Visit Luon cave with paddle boat. Enjoy a swim in the emerald waters of Halong Bay at any spot that you wish to visit. go up to the Halong bay View at Titop beach. Watch the sun set over the bay whilst enjoying a delicious dinner. Overnight on board junk.<br></span><span>( Option overnight in the Hotel, Please contact us )&nbsp;<br></span><span><span><strong>Day 4. Halong - Hanoi ( B - L )</strong></span><br>Wake up to fresh coffee espresso famous in Vietnam “Trung Nguyen”&nbsp; and Enjoy the sunrise, a wholesome breakfast before Visit the recently discovered Surprise Grotto with its great views, and on the next island see the yawning mouth of Bo Nau Cave. Continue visit Baitulong bay En route the junk weaves through strange-shaped rock formations that invite comparisons from fighting cocks to dragons and even General de Gaulle’s nose! After another wonderful fresh seafood lunch on Board. Transfer back to Hanoi by road and transfer to hotel on arrival. Arrive Hanoi on 16:30.&nbsp;</span><span><br></span><span><span><strong>Day 5. - Hanoi - Hue ( B )</strong></span><br>Breakfast, Fly to Hue that was the last imperial capital of Vietnam from 1524 to 1945 and has recently been recognized by UNESCO as a World Cultural Heritage Site. A day tour of Hue offers us an opportunity to explore the \"Forbidden City\", Imperial Palace. A long boat cruise on the Huong River to view some fine examples of buddhist architecture and visit Thien Mu pagoda.&nbsp;<br></span><span><span><strong>Day 6 Hue - Danang - Hoi an ( B )</strong></span><br>Breakfast, This is your chance to explore the center where the historic, the cultural and the romantic combine. Visit Khai Dind Tomb and&nbsp; Tu Duc tomb , home to over 140 historic works of architecture. Heading south, we visit the fascinating Cham museum in Danang and explore the Buddhist Shrines of the Marble Mountain Caves. &nbsp;<br></span><span><span><strong>Day 7 - Hoi An</strong></span><br>Breakfast and departure to Hoian, a small and charming city, located at border of Thu Bon river. Afternoon we will make a stroll between the&nbsp; 844 houses and temples in Hoian, including the Tanky\'s House, 200 years of antiquity, with Chinese poems written in nacar inlaid, or even the structure oldest call \"The House at Tran Phu St.\", made of carved wood. Visit city\'s Market, located on the right bank of the river and one of the most colorful places of the trip. Night at hotel. &nbsp;<br></span><span><span><strong>Day 8. - Danang - Saion (B &nbsp;)</strong></span><br>After breakfast transfer to Danang Airport for the flight to Ho Chi Minh City. Guests are welcomed by Halong travel guides on arrival in Ho Chi Minh City and transferred directly to the hotel. A morning city tour visits two fine examples of French colonial architecture, the Notre Dame Cathedral and the Old Saigon Post Office.&nbsp; In the afternoon, Visit the Museum History;Criminal Musem. The market Cho Lon, Ben Thanh.&nbsp;<br></span><span><span><strong>Day 9. - Saigon - vinh Long &nbsp;(MEKONG DELTA)/SAIGON (B, L)</strong></span><br>After Breakfast, Transfer to Vinh Long for 4 hours. full day trip to the watery world of the Mekong Delta. Take a boat trip along narrow waterways overhung with dense vegetation and try exotic fruits in one of the many orchards. Enjoy the landscape of the Mekong delta where we take a boat to visit the floating market CAIBE. Lunch in the bonsai garden ,for lunch sample the local delicacy, Elephant\'s Ear Fish. Return to City HO CHI MINH, and visit Tay Son lacquer ware factory. Overnight in HCMC.&nbsp;<br></span><span><span><strong>Day 10. -&nbsp; Saigon &nbsp;(HO CH I MINH)/ EXIT&nbsp; (B)</strong></span><br>Breakfast,&nbsp; transfer to the airport and return your home.</span></p>Providing a variety of colour and beauty of Vietnam diversity. Vietnam Insight will tantalize all of your senses. From the chaotic Hanoi to Halong &nbsp;spend a night on board our 4 star &nbsp;boat on beautiful Halong Bay ,charming Hoi An, the imperial capital of Hue, saigon the biggest city in vietnam ... all included in the 10 days of the trip.</div><div><div><strong>Start City&nbsp;: Hanoi&nbsp;</strong><br>End City: Saigon&nbsp;<strong>or Vice versa</strong><br><strong>Duration:&nbsp;</strong><strong>14 days/ 13 nights</strong><br><strong>Departure:&nbsp;</strong><strong>Daily, upon your request.</strong><br>- The Vietnam insight &nbsp;tour is your best choice if you want to experience the totality of Vietnam: the land, the people, the culture, and the history, as a Vietnamese person would. In this Vietnam holiday, as you travel through the country you will experience all forms of transport: car, train, airplane, boat, walking and hiking. During 2 weeks traveling with Travel Vietnam, you will trace the path of the founding of Vietnam.<br>- Visit:<strong>&nbsp;Hanoi, , Halong Bay, Hue, Hoian, Saigon, , Mekong River Delta, Sai don exit .</strong><br>- Extendable with optional tours from Hanoi and from Saigon</div></div><div>DURATION:&nbsp;<span>10 DAY(S) - 9 NIGHT(S)</span></div><div><div><div>CODES:&nbsp;<span>PT2</span></div><div>PRICE:&nbsp;<span>0</span>&nbsp;USD</div><p><br></p><p><br></p></div></div><p><br></p>', 1, '2018-11-13 17:14:51', '2018-11-13 18:02:35'),
(31, 'Explore Vietnam on an in-depth journey that takes you from North to South. Start with the colonial charm of Vietnam’s capital, Hanoi, then travel to the natural wonderland of Halong Bay and trek through Sapa’s terraced rice paddies', '/uploads/1542104216.jpg', '/uploads/1542104217.jpg', 'S22', '', 0, '<p><div><div><div><span>Explore Vietnam on an in-depth journey that takes you from North to South. Start with the colonial charm of Vietnam’s capital, Hanoi, then travel to the natural wonderland of Halong Bay and trek through Sapa’s terraced rice paddies and hill tribe villages. Visit the ancient capital Hue and bask on the beaches of Hoian. Explore the lush landscape of the Mekong Delta and the bright lights and urban bustle of Saigon. This tour takes you deep into our beautiful country, immersing you in our rich culture and elegant landscapes.<br>The whole tour is accompanied by experienced, local, English speaking guides.</span></div><div><span><strong>Start City&nbsp;: Hanoi&nbsp;</strong><br>End City: Saigon&nbsp;<strong>or Vice versa</strong><br><strong>Duration:&nbsp;</strong><strong>14 days/ 13 nights</strong><br><strong>Departure:&nbsp;</strong><strong>Daily, upon your request.</strong><br>- The Vietnam Highlight &nbsp;tour is your best choice if you want to experience the totality of Vietnam: the land, the people, the culture, and the history, as a Vietnamese person would. In this Vietnam holiday, as you travel through the country you will experience all forms of transport: car, train, airplane, boat, walking and hiking. During 2 weeks traveling with<a href=\"http://www.authenticvietnamtour.com/vietnam-tours-detail/9/2/Vietnam-Highlight-14-Days.html\" class=\"f-link\"><strong>Authentic vietnam tours</strong></a>&nbsp;, you will trace the path of the founding of Vietnam.<br>- Visit:<strong>&nbsp;Hanoi, Sapa, Halong Bay, Hue, Hoian, Saigon, Tay Ninh, Mekong River Delta, Can Tho.</strong><br>- Extendable with optional tours from Hanoi and from Saigon.</span></div></div></div><div>DURATION:&nbsp;<span>14 DAY(S) - 13 NIGHT(S)</span></div><div><div><div>CODES:&nbsp;<span>HG 01</span></div><div>PRICE:&nbsp;<span>1.408</span>&nbsp;USD</div><div><br></div></div></div><div><b>trip name : Authentic and &nbsp;Highlinght 14 days&nbsp;</b></div><div><b>Type of trip:&nbsp;</b>Private</div><div><b>Trip Duration: 14</b>&nbsp;Days</div><div><b>Starting:&nbsp;</b>Hanoi capital city, Vietnam</div><div><b>Finishing:&nbsp;</b>Saigon (Ho Chi Minh city), Vietnam</div><div><b>Trip Grading:&nbsp;</b>Moderate walking</div><div><b>Destinations: Hanoi –Sapa - Halong – Hue – Hoi An –my son - Saigon – Mekong Delta</b></div><div><strong>PRIVATE TOUR RATE: Prices are quoted in US dollars per person double occupancy.</strong></div><div>&nbsp;</div><table><tbody><tr><th><strong>Group size</strong></th><td><strong>2 persons</strong></td><td><strong>4 persons</strong></td><td><strong>6 persons</strong></td><td><strong>Single Supp\'</strong></td></tr><tr><th><strong>Land tour/ pp</strong></th><td>1,510</td><td>1,363</td><td>1,188</td><td>-</td></tr><tr><th><strong>2 Flights/ pp</strong></th><td>&nbsp;&nbsp; 220</td><td>&nbsp; 220</td><td>&nbsp; 220</td><td>&nbsp;</td></tr><tr><th><strong>Total/pp</strong></th><td>1,730</td><td>1,583</td><td>1,408</td><td>&nbsp;</td></tr></tbody></table><table><tbody><tr><td><em><strong>Includes:</strong>&nbsp;</em><br>- Accommodation (3 star hotel in average)<br>- Breakfast &amp; meals per mentioned in the itinerary<br>- Transportations by private car with A/C<br>- English-speaking guides<br>- Return train ticket Hanoi – Laocai&nbsp;– Hanoi (in a shared 4 berths cabin with A/C)<br>- 2 domestic flights (Hanoi – Hue, Danang – Saigon)<br>- All entrance fees, performances, boat trips &amp; excursions.</td><td><p><em><strong>Excludes:</strong></em><br>- International Flights<br>- Travel insurance<br>- Vietnam Visa<br>- Gratuities for tour guides/ drivers<br>- Beverages &amp; other personal expenses.</p></td></tr></tbody></table><br></p>', 0, '2018-11-13 17:17:43', '2018-11-13 17:17:43');

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
(23, 'HOA LU - TAM COC DAILY TOUR', 2),
(24, 'BAI DINH TRANG AN 1 DAY TOUR', 2),
(25, 'BAI DINH TRANG AN 1 DAY TOUR', 2),
(26, 'BAI DINH TRANG AN 1 DAY TOUR', 2),
(27, 'NINH BINH DAILY MOTORBIKE TOUR', 2),
(28, 'Duong lam and thay pagoda 1 day', 3),
(29, 'HANOI VESPA STREET FOOD TOUR', 3),
(30, 'over view of vietnam 10 days', 4),
(31, 'AUTHENTIC AND HIGHLIGHT OF VIETNAM 14 DAYS', 4);

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
  ADD PRIMARY KEY (`ID`) USING BTREE;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
