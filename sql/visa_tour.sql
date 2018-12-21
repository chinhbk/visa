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

CREATE TABLE `book_tour` (
  `ID` int(11) NOT NULL,
  `TOUR_ID` int(11) NOT NULL,
  `ARRIVAL_DATE` varchar(20) NOT NULL,
  `CODE` varchar(15) DEFAULT NULL,
  `NAME` varchar(100) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(20) DEFAULT NULL,
  `COUNTRY` varchar(20) DEFAULT NULL,
  `COMMENT` text,
  `NO` int(11) DEFAULT NULL,
  `CREATE_DATE` date DEFAULT NULL,
  `UPDATE_DATE` date DEFAULT NULL,
  `STATUS` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_tour`
--
ALTER TABLE `book_tour`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_tour`
--
ALTER TABLE `book_tour`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;



CREATE TABLE `SETTING` (
  `ID` int(2) NOT NULL,
  `HOTLINE` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(120) DEFAULT NULL,
  `ADDRESS` varchar(200) DEFAULT NULL,
  `CONTACT` text,
  `WHYUS` text,
  `TOURTERM` text,
  `VISASTEP` text,
  `VISAFAQ` text,
  `VISATERM` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SETTING`
--

INSERT INTO `SETTING` (`ID`, `HOTLINE`, `EMAIL`, `ADDRESS`, `CONTACT`, `WHYUS`, `TOURTERM`, `VISASTEP`, `VISAFAQ`, `VISATERM`) VALUES
(1, '0084 916 128 611', 'vietnamvisatours@gmail.com', 'No 106, Dinh Cong St, Thanh Xuan Dist., Hanoi', '<ul><li><p>Office Address:&nbsp;No 106, Dinh Cong St, Thanh Xuan Dist., Hanoi</p></li></ul><ul><li><p><span>Phone:&nbsp;<span>0084 916 128 611</span></span><br></p></li></ul><ul><li><p><span><span>Email:&nbsp;<span>vietnamvisatours@gmail.com</span></span></span></p></li></ul><p></p>', '<p><em>Amongst a number of things to prepare for your trip to&nbsp;</em><em>Vietnam</em><em>, getting the Visa is not the most significant but the very first task to be completed as efficiently as possible.</em><br></p><p><br></p><p>Vietnam Visa dot net is operated to promote the image of Vietnam to international friends through offering a free consultancy service related to traveling in Vietnam and facilitating potential tourists worldwide with procedures of Vietnam entry and exit and traveling related arrangement during their stay in Vietnam.</p><p><br></p><p>As locals, Vietnam Visa Dot Net has a great command of the Vietnam culture, legal system and regulations related to Vietnam Visa. And pursuant to the&nbsp;<span>National Ordinance 24/1999/PL-UBTVQH10</span>&nbsp;on entry, exit and transit of foreigners in Vietnam issued by Standing Committee of National Assembly, We set up&nbsp;<a href=\"http://vietnamvisatours.com\" rel=\"nofollow\" class=\"f-link\">Vietnamvisatours.com</a>&nbsp;to assist the Vietnam visa applicants at the most convenient but cheapest way with SMART service that meets the criteria of&nbsp;<span>S</span>imple and&nbsp;<span>S</span>ecure,&nbsp;<span>M</span>annerly,&nbsp;<span>A</span>chievable,&nbsp;<span>R</span>eliable, and&nbsp;<span>T</span>imely.</p><p><br></p><table><tbody><tr><td width=\"103\"><p><span><strong>Simple</strong></span></p><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>Making the best use of online solutions, we have developed a very simple procedures that is easy for Vietnam visa applicants to use. Specifically, you, as a client, are just required to follow such the very simple steps as:</p><p><span><em>Step 1</em></span><em>&nbsp;:</em>&nbsp;Fill in the secure online visa form at</p><p><a href=\"https://Vietnamvisatours.com/apply-visa-online\" rel=\"nofollow\" class=\"f-link\">https://Vietnamvisatours.com/apply-visa-online</a></p><p></p><p><span><em>Step 2</em></span><em>&nbsp;:&nbsp;</em>Pay the service fee at a reasonable rate through Credit Card, Paypal, Western Union or Bank Account.</p><p><span><em>Step 3</em></span><em>&nbsp;:</em>&nbsp;Get the visa approval letter by email within 1 or 2 working days and pick up your visa at the Vietnam international airports.</p><p><span><em>Step 4</em></span><em>&nbsp;:&nbsp;</em>Bring \"visa approval letter\" passport, 2 photos, \"<a href=\"https://vietnamvisa.org/entry_%20and_%20exit_%20form.pdf\" title=\"exit and entry form\" class=\"f-link\">exit and entry form</a>\", and stamping fee to get your visa stamped at the Vietnam international airports .</p><p><span>&nbsp;</span>&nbsp;</p></td></tr><tr><td width=\"103\"><p><span><strong>Secure</strong></span></p><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>Being aware of the impotance of security of clients’ private information, we have been using the highest level of online security to ensure one hundred percent that your provided information is kept in security and confidentiality.</p><p>&nbsp;</p></td></tr><tr><td width=\"103\"><span><strong>Mannerly</strong></span><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>Being a client, you have rights to be respected, to be informed, to feel safe and in control of what is happening. Along with that, you have to be treated with friendly behaviours. Therefore, to protect and to fulfill your rights as a client, vietnam-visa offers a mannerly and friendly service to all of its clients to make sure that you feel confortable and confident.</p><p>&nbsp;</p></td></tr><tr><td width=\"103\"><p><span><strong>Achievable</strong></span></p><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>Owning to the open door policy of the Vietnam Government that encourages the foreigners all over the world to visit Vietnam, it is not very difficult for almost those who need to apply for a Vietnam visa to get visa for Vietnam. However, not ALL who needs a Vietnam visa can be successful in applying for a visa, though the rate of failing is very low. Vietnamvisatours.com works to facilitate your visa application procedures and advise you the best way to move forwards to getting the visa. And you are just charged the service fee in case your visa application is surely proceeded successfully.</p><p>&nbsp;</p></td></tr><tr><td width=\"103\"><p><span><strong>Reliable</strong></span></p><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>With a deep LOVE with Vietnam, our Vietnamvisatours.com staff has been trying our best to welcome more and more foreigners to visit the country where it bases. Applying client centered approach, our supporting staff always welcome all the feedback from clients and listen to them carefully to perfect the service with the big hope of offering a reliable service to the clients.</p><p>&nbsp;</p></td></tr><tr><td width=\"103\"><p><span><strong>Timely</strong></span></p><p><span>&nbsp;</span>&nbsp;</p></td><td width=\"487\"><p>For any clients both easy and difficult ones, TIMELY criteria is always prioritized. Being fully aware of the clients’ psychology, Vietnamvisatours.com&nbsp;has been applying the TIMELY principle to all of its staff in dealing with the visa procedures. All the clients must be informed clearly the visa processing schedule. And as a client, you can actively monitor the process by loginning Client Login and Check Status at the site to know your visa processing status. In case you feel unsatisfied, you can call to the supporting supervisor at +84 988 580 614 to complain.</p><p>For normal service, the visa application procedures can be processed within two (2) to three (3) bussiness days.</p><p>For urgent service, the visa application procedures can be processed within one (1) business day.</p></td></tr></tbody></table><p><br></p>', '<p></p><header><div><div><h1><a href=\"https://vietnamtour.com/term-conditions.html\" title=\"Travel Terms\" class=\"f-link\">TRAVEL TERMS</a></h1></div></div></header><p></p><section><strong>VIETNAM VISA&nbsp;TOUR</strong>&nbsp;- The following terms and conditions are applied to bookings made by you through your usage of www.vietnamvisatours.com. The rate is valid until Dec 31st, 2019.<br><strong>CHILD DISCOUNT</strong><br>Children under 12 years is generally granted a reduction up to 30% of the land tour, 25% of land tour, provided that they are accompanied by at least two full-paying adults and stays in the same room. An extra bed is fully charged as adult.<br><strong>DEPOSIT &amp; PAYMENT</strong><br>30% of the total tour cost to be deposited upon commitment of the tour,&nbsp;<strong>this deposit is non-refundable</strong>. This amount will be paid by credit card (Our Travel Consultant will send you the link to pay online) is required to confirm your booking.<br>Where deposits and advance payments are required from contractors/third parties, these will also be invoiced to the client for payment. This will be required for Vietnam Tour to secure services contractors/third parties. Pre-payment procedures during high/peak seasons may also vary, depending on the accommodation policy to guarantee the booking.&nbsp;<a href=\"http://vietnamvisatours.com\" rel=\"nofollow\" class=\"f-link\">Vietnam Visa&nbsp;Tours&nbsp;</a>will inform you accordingly about this for each individual case.<br>The remaining balance of the tour price (70%) is due upon your arrival to Southeast Asia, payable at our offices in&nbsp;Hanoi&nbsp;(Vietnam) .Cash is preferred to reduce any processing fees that may affect your cost (for a 100 USD Note, we only accept the new one with a blue 3D Security Ribbon). The deposit should be made by Credit Card or Bank transfer with following details:<br><strong>BANK TRANSFER</strong><br>Our travel consultants will show you in details.<br><span>- If you choose to pay the balance by bank transfer, we would request you to wire money before the tour starts at least 2 weeks (14 days), then send us the bank slip.<br>- Final payment must be confirmed and validated by us. We are not responsible for errors or omissions that may occur as a result of the transfer of incorrect information from you or third party travel service suppliers.<br>- In case you write any wrong information (not the same as we officially provided) and it takes time to amend, we will request you to pay by other method such as credit card or cash to secure your booking. Otherwise, your service will be released.</span><br><strong>PAY BY CREDIT CARD</strong><br>Kindly make deposit/payment via our secured Online Payment SSL&nbsp;<br>Vietnam Tour is a verified member of OnePay so we could accept Debit Card, Credit Card, Visa Card, Master Card and JCB card (see payment guide).<br><strong><em>Note</em></strong>:<em>&nbsp;When you pay by Credit Card, please add 3% of bank commission</em>.<br><strong>CANCELLATIONS &amp;&nbsp; REFUNDS</strong><br>All cancellations must be received in writing, sent to us via fax or email. The following rules apply for cancellations:<br>&nbsp;* More than Twenty one (21) days prior to departure: The total deposit paid to us (30% of the Tour value) for the administrative fee in accordance with canceling advanced arrangements, will be valid for o­ne (1) year from the date the deposit was received. During this time (365 days) the amount can be applied to other tours and services. After o­ne (1) year the deposit amount is forfeited.<br>&nbsp;* 7- 21 days&nbsp; prior to departure: 50% on total value of the trip charged, due to hotel charges for no-shows and organizing fees.<br>&nbsp;* Within 1-6 days&nbsp; prior to departure: 100% on total charged.<br>&nbsp;* No-Show: 100% on total charge.<br><strong>UNUSED SERVICES</strong><br>No refunds or exchanges can be made with respect to accommodation, meals, sightseeing tours, transport or any other services, included in the tour price, but not utilized by the tour members.<br>Travel documents will be compiled after the deposit has been received and are sent two or three weeks prior to departure. These documents will be sent via email, and should be printed out by participants and retained as a receipt.<br><strong>RESPONSIBILITY</strong><br>All possible care is taken to ensure that our suppliers maintain the highest possible standards. However, we are not responsible in any way for problems, however they arise, that result from the booking of services we do not directly control.<br><strong>Vietnam Tour</strong>, its subsidiaries, affiliated companies, servants or agents shall not be responsible or become liable in contract or tort for any injury, damage, loss, delay to person or property, additional expenses or inconvenience caused directly or indirectly due to any events beyond our control.<br><strong>VALIDITY</strong><br>This information is valid at the time of publication but is subject to change without prior notice. However, should any changes occur, they will be posted on the website immediately. However, should the Terms and Conditions change after the deposit is paid, the&nbsp;Terms and Conditions&nbsp;under which the deposit was paid shall apply.</section><p></p>', '<p></p><p>Vietnam Visa on arrival one of the best way of getting a valid visa to Vietnam,&nbsp; that the travelers will need to get a visa approval letter issues by Vietnamese Government&nbsp; (Immigration Office) beforehand and getting a full visa sticker at Vietnam international airports upon arrival.</p><p><span class=\"f-img-wrap\"><span class=\"\" style=\"/* float: none; *//* margin-left:0px ; *//* margin-right:0px; *//* margin-bottom: 0px; *//* margin-top: 0px; */\"><img alt=\"\" height=\"234\" src=\"https://vietnamonlinevisa.com/baobivinhphuoc/upload/images/vietnam-visa-india.jpg\" width=\"718\" style=\"margin: 0px;\"></span></span></p><p>Is Vietnam Visa on Arrival legitimate? of course, Yes! We use official government forms, simplifying the process so applications can be completed within 5 minutes.<br>Issuing authority: Vietnam Immigration Department – a Government’s authority<br>Legal basis: Ordinance on entry, exit and residence of foreigners in Vietnam</p><ul><li>Government’s Decree No. 21/2001/ND-CP</li><li>Joint Circular No. 04/2002/TTLT/BCA-BNG.</li></ul><h3><strong>How to Vietnam Visa on Arrival.</strong></h3><p>Instead of applying through the embassies of Vietnam, all you need to do is, to complete the online form with 3 simple steps.</p><p><strong>1. SUBMIT APPLICATION</strong></p><p>After the payment was made, it takes 1-2 business days to process. Once your application approved, the link to download your e-Visa will be e-mailed to you<br>You can proceed with online application.Take 5 minutes to fill &amp; complete the form online with minimum required information:<span class=\"f-img-wrap\"><img alt=\"\" height=\"136\" src=\"https://vietnamonlinevisa.com/baobivinhphuoc/upload/images/laptop.png\" width=\"253\"></span></p><ul><li>Full name – The same as in passport</li><li>Date of birth</li><li>Nationality</li><li>Passport number</li><li>Date of arrival</li><li>Type of Visa</li></ul><p>&nbsp;<br></p><p>After this, you can make payment by Mastercard or Visa credit/debit card. Only charge for successful application.<strong>&nbsp;100% risk-free.</strong></p><p><strong>2. GET APPROVED LETTER VIA EMAIL.</strong></p><p>After the payment was made, it takes 1-2 business days to process. You will get the visa approved letter send via email (attached files with Vietnamese visa application form NA1). After that you will need to:<span class=\"f-img-wrap\"><img alt=\"\" height=\"179\" src=\"https://vietnamonlinevisa.com/baobivinhphuoc/upload/images/computer.png\" width=\"221\"></span></p><ul><li>Print out the letter and the form,</li><li>Fill out the Vietnamese visa application form,</li><li>Prepare 2 passport-sized photos 4x6cm and cash for stamping fee,</li></ul><p>Put all above mentioned things along with your passport in a package,<br>then show them to Immigration officer at Vietnam arrival airports.</p><p><strong>3. GET VISA STAMP UPON ARRIVAL AIRPORT.</strong></p><p>Upon arrival at landing visa (VOA) Counter, present the following:</p><ul><li>Your passport, Visa approval letter (print out in any color accepted)</li><li>2 Passport-sized photos</li><li>Vietnamese visa application form, and</li><li>Stamping fee</li></ul><p>to the Immigration Officer to get visa stamped onto your passport.</p><p><span>Noted: Before leave the counter, please double check the yellow visa and stamped to be matches with your passport details.</span></p><p><span class=\"f-img-wrap\"><img alt=\"\" height=\"372\" src=\"https://vietnamonlinevisa.com/baobivinhphuoc/upload/images/cheap-vietnam-visa.jpg\" width=\"674\" style=\"margin: 0px;\"></span></p><p><br></p>', '<p><br></p><h3>What is visa on arrival?</h3><p>This is one of, if not, the quickest and cheapest way to get your visa for Vietnam. You just need to fill in our \"<a href=\"https://vietnamvisa.org/secure/\" class=\"f-link\"><span>Online Application Form</span></a>\", get your \"<a href=\"https://vietnamvisa.org/faq\" class=\"f-link\"><span>Visa approval letter</span></a>\" within 2 working days and pick up your visa at your destination airport (Hanoi airport, Ho Chi Minh city airport)<br><br>After we obtain the approval letter for you, we will forward you a copy by email or fax. Copies of the same document will be forwarded on your behalf to Vietnam Immigration checkpoints at<span>International Airports only</span>. When you arrive in Viet Nam, the Immigration officers will have those documents ready and will be able to issue your entry visa quickly.</p><p><span>See Also: &nbsp;</span>You can check out the information below for the detailed airport map where you will pick up your visa when you arrive.</p><h3>What is the \"approval letter\"?</h3><p>The \"<span><span>Visa approval letter</span></span>\" is a letter issued by Vietnam Immigration Department&nbsp; that allows you to enter and exit Vietnam for a given time period. With the approval letter, you can pick up your visa upon arrival at one of the&nbsp; three international airports in Vietnam (Hanoi, Ho&nbsp;Chi&nbsp;Minh&nbsp;City and Da Nang).</p><p>At the airport, the corresponding authority will verify the details on the approval letter based on your passport and travel documents. As long as you make sure you input the correct details when applying, you will surely be granted entry upon arrival in Vietnam with the approval letter. However, it is strongly advised that you read our website and follow all the instructions carefully to avoid problems or delays at the airport.</p><p><span><span>Visa-on-Arrival Counters:</span></span></p><p>Hanoi airport visa-on-arrival counter.<br>Ho&nbsp;Chi Minh city airport map - Ho Chi Minh city airport visa-on-arrival counter.</p><h3>How do I receive my visa approval letter?</h3><p>A colored scanned copy of the approval letter will be sent to you&nbsp;<span>by email</span>, so please make sure that you have provided us with the&nbsp;<span>correct email address</span>.</p><p>You can also request a copy by fax. In this case, please provide us with your fax number and email it to&nbsp;<a href=\"mailto:sales@vietnamvisa.org\" class=\"f-link\">v</a>ietnamvisatours@gmail.com</p><p>Note:&nbsp;<em>the approval letter is in PDF format, so please make sure you have the latest version of&nbsp;</em><a target=\"_blank\" href=\"http://get.adobe.com/reader/\" class=\"f-link\"><em>Adobe Acrobat reader</em></a><em>&nbsp;in order to open the file.</em></p><h3>Do you require a scan of my passport scan?</h3><p>In most cases, a passport scan is not required for an online visa application. However, if the Immigration office wishes to verify the information you provide, you are required to send them a scan copy of your passport. In such cases, we will notify you by email immediately.</p><h3>What is stamping fee and how much is it?</h3><p>The stamping fee is the fee you are required to pay at the Vietnamese airport in order to get the official visa stamped in your passport. The stamp fee must be in cash, no credit cards are accepted.</p><h3>Stamp fee at the airport (price per person)</h3><p>25 USD for single 1 month/3 month</p><p>50 USD for multiple entry</p><p>Currencies accepted: Vietnam Dong (VND) and USD (US Dollars)</p><h3>What credit/debit cards are accepted?</h3><p>We currently accept both Debit/Credit cards and PAYPAL for payment of our approval letter service fee. These include: Visa, MasterCard, American Express, JCB and Diners Club. Please click here for payment guidelines.</p><h3>Tips: My credit card number is correct, but it was not accepted. Why?</h3><p>•	The card expiration date was entered incorrectly.</p><p>•	You have reached your credit limit</p><p>•	There was a computer error.</p><p>•	Your Visa Verified password / Master Secure Code were entered incorrectly.</p><h3>How long does it take to get the approval letter?</h3><p>Normally, the approval letter is processed and emailed you within two (2) to three (03) business days (excluding Saturday, Sunday and National Holidays).</p><p>If you submit your application and pay the fee before 12.00 PM Vietnam time on a Working day (Monday-Friday), we will send you the letter of approval by 18:00 PM on the following (next) working day.</p><p><br></p><h3>Note</h3><p><em>The above processing time does not apply for Friday afternoon (after 12.00 PM) + Saturday and Sunday. Please consider the time difference between Vietnam and your country. For current Vietnam time, please click here.</em></p><p><em>Note: the visa counter at Vietnam airport is 24/7 open so if you already have the approval letter, you can still pick up your visa at Vietnam airport on weekend.</em></p><p><em><p>3 month visa: for 3 month visa approval letter, it may take up to 7-10 working days.</p></em></p><p><br></p><h3>What if I travel to Vietnam by Land or Cruise?</h3><p>Please be advised that visa on arrival service is good for air travel only, if you plan to enter Vietnam by land or cruise, you will need to contact the Embassy to obtain your visa in advance.</p><p><span>In short:</span><span>Visa-on-Arrival is NOT available for entry by land and cruise ship.</span></p><h3>For multiple entry Visa approval letter, at the first time I entry Vietnam by air, then back to Vietnam, can I entry by bus in next time?</h3><p>Yes, you can.</p><h3>Is there any problem if I change the airport to pick up visa?</h3><p>It does not matter when you change the airport to pick up visa. You can pick it up at 3 international airports such as Hanoi, Danang and Hochiminh.</p><h3>Should I book for the flight first or after receiving my visa?</h3><p>We would like to recommend that you should get the visa on arrival first and then book your flight. Certainly, the date of arrival must be ensured before applying for the visa.</p><h3>How should I do if I want to travel to Vietnam for more than one month but there is only visa for business?</h3><p>It is fine to entry Vietnam with business visa while your real purpose is for travelling.</p><h3>Is it ok when my visa approval letter includes many names of strangers?</h3><p>No, it is Share visa approval letter which often is issued at high season. All of these people applied Vietnam Visa at the same time with you, therefore Immigration Department sent these Visas with you at the same paper and the same time for saving time.</p><h3>What are differences between Share visa and private visa?</h3><p>There are many names of customers on only one document which is called share visa. It often is sent to foreigners when they apply for Vietnam visa in same time in high season. In contrast, private visa just only show your name (and your partners) and also this must be more expensive than share visa.</p><p><br></p>', '<p><span>INTRODUCTION</span></p><p>These Terms and Conditions apply whenever you visit this website regardless of location. Access to this website and the purchase of our product is conditional upon you reading and accepting all of the Terms and Conditions and the Privacy Policy. Our Privacy Policy and the Terms and Conditions may change from time to time. This Terms and Conditions statement applies solely to the information presented on this Website: https://vietnamvisatours.com/.&nbsp;<br></p><p><span>In these Terms and Conditions \"we, our, us\" refers to Vietnamvisatours.com&nbsp;</span></p><p><span>PRIVACY POLICY</span><br></p><p><span>Please review our Privacy Policy, which also governs your visit to Vietnamvisa.org to understand our practices. Our Privacy Policy is provided on a separate webpage.</span></p><p>COPYRIGHT<br></p><p><span>This Website or any portion of this Website may not be reproduced, duplicated, copied, sold, resold, visited, or otherwise exploited for any commercial purpose without express written consent of Vietnamvisa.org. You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including images, text, page layout, or form) of our website without express written consent. You may not use any meta tags or any other \"hidden text\" utilizing our name or trademarks without our permission.</span><br><span>&nbsp;</span><br><span>You may not use any Vietnamvisa.org logo or other proprietary graphic or trademark as part of the link without express written permission. All content included on this Website, such as text, graphics, logos, button icons, and images is the property of our website or its content suppliers, and is protected by international copyright and trademark laws.</span></p><p></p><p><span>ABOUT OUR PRODUCT</span></p><p></p><p><span>This website is dedicated to providing Vietnam Visa applicants with all the help they need in order to successfully apply for a Vietnam Visa and enter Vietnam. We cannot guarantee that your visa application will be approved in any circumstances but we do guarantee that if you follow our instructions you will be exceptionally well prepared. Vietnamvisa.org cannot be held responsible for any inaccuracy arising from changes to such legislation and policy. You as the customer are encouraged to seek additional guidance if required by contacting us for additional specific information regarding your application. Any information provided by our employees on non-migration related matters should only be interpreted as general information, and you as the customer should obtain professional legal advice regarding these matters if so required.</span></p><p>As a private company we do not have the authority to grant you a visa of any kind. We can only assist and advise travelers who wish to visit Vietnam. The final decision on all Vietnam visa applications rests solely with the local Vietnam Embassy or Consulate in your home country. The price we charge for our Vietnam Visa Application does not relate to any fees charged by the Vietnam Embassy or Consulate.<br></p><p><span>VOCABULARY</span></p><p></p><p><span>Date format:</span><span>&nbsp;dd/mm/yyyy - 12th June 1980</span></p><p><span>Time Zone:</span><span>&nbsp;Vietnam standard time - GMT +7</span></p><p><span>Working days:</span><span>&nbsp;All week days except Saturday and Sunday.</span></p><p><span>Working hours:</span><span>&nbsp;8.00 AM to 16.00 PM every working days.</span></p><p><span>Multiple / Single entry:</span><span>&nbsp;Multiple is interpreted as multiple entries, not multiple applicants.</span></p><p><span>Multiple entries&nbsp;</span><span>means you are allowed to enter / exit Vietnam multiple times within a given period of time (1, 3 or 6 months). For example: 6 month multiple entry visa means - you are allowed to enter / exit Vietnam multitple times from the intended date of arrival provided plus 6 calendar consecutive months.</span></p><p><span>PROCESSING TIME</span><span>&nbsp;</span><span>AND SERVICE COMPLETION&nbsp;</span></p><p><span>Processing time for arranging pre-approved letter offered by Vietnamvisa.net is based on processing time provided by Vietnam Immigration Department under normal circumstances, which is 2 – 3 working days.&nbsp;</span><span>Processing time will be starting from the next business day after you pay and notify us your payment receipt.</span><span>&nbsp;Vietnam Immigration Department may request additional documents and may delay and/or deny processing at their discretion without further explanations.</span></p><p></p><p>Our service provided is completed once the letter of approval is sent to the email address you submitted during the application process. You are required to notify us if you do not receive the letter in time, if no email from you informing us that you do not receive the letter within 7 days, the service is understood to be completed. We are not responsible for any delay/loss caused by the Wrong email addresses supplied by applicants or the situation that applicants do not notify us by email that approval letter is not received.</p><p><span>CANCELLATION AND REFUNDS</span></p><p>You are permitted to make a cancel request if your booking status is \"wait payment\" or \"pay done\".</p><p>We cannot make refunds when an application has been successfully submitted according to the terms and conditions outlined on the application form, which you agreed to when you submitted your application to Vietnamvisa.org. Once your visa application status is put under \"payment received\" or \"under processing\", we are unable to reimburse you the visa fee.</p><p>All the fees will be refunded to your account in case your application is declined by the Immigration Department. In case your visa application is declined by the Immigration Department, all the paid fees will be refunded to your account.</p><p>It is imperative that you supply us with all the correct information required for your requested visa at the time of your intended departure. We cannot be held responsible for any visa granted incorrectly or refused entry due to incorrect visa information. Though every effort will be made on our part to correct any visa issues prior to departure, no refund will be given by us in the event of false or incorrect information being supplied at the time of issue. We strongly recommend that you check your visa confirmation letter against your passport and personal information prior to departure.</p><p>Immigration officers sometimes make mistakes. We suggest that you should check the details on the approval letter carefully. If you find any errors on the letter of approval, please inform us immediately by EMAIL and wait until the visa approval letter is fixed. If we do not receive any email for error correction within 7 days from the time we send out the letter of approval or at least 30 minutes before your departure time (applied for urgent 2 working hour service), we will not be responsible for any failed applications, declined entries. Furthermore, we will not liable if customer cancelled unilaterally the visa and used other service from other companies before the mistake is fixed. All compensation requests will be refused in that case.</p><p>This visa is applicable to air travel only, so by applying through our website, you agree that you will fly to Vietnam in order to get your visa stamped. We will not refund in case you DO NOT enter Vietnam by air once your visa is approved.</p><p>We cannot refund fees paid to government agencies. To receive a refund for this fee you must contact the relevant agency directly</p><p><span>DISCLAIMERS</span></p><p></p><p><span>We are not responsible for any loss, delay or cancellation of your flight ticket, tour or accommodation booking made for your trip to Vietnam in case your visa application is declined by the Immigration Department of Vietnam. In this case, we will refund you the full amount paid for our service.</span></p><p><span>Normally, it takes 2 working days to process an approval letter, however, there are also exceptions, delay due to unforseen problems since the process is highly dependent on the Immigration Department of Vietnam. We strongly recommend that you apply for a visa at least 1-2 weeks in advance to avoid any problems.&nbsp;</span></p><p><span>The letter of approval is issued separately for each application, however, in some cases (in high seasons and urgent processing requests), it is issued on a shared basis for all applicants who apply for a visa at the same time or same date of arrival based on the Immigration Department sole decision. If you have special request for separate letter of approval, please select Share Visa when applying.&nbsp;</span></p><p><span>Please note that we also reserve the right to refuse to any visa requests</span></p><p></p>');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `SETTING`
--
ALTER TABLE `SETTING`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `SETTING`
--
ALTER TABLE `SETTING`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
  
  ALTER TABLE `TOUR` ADD `PRICE_TYPE` VARCHAR(100) NULL AFTER `PRICE`;
ALTER TABLE `TOUR` ADD `IS_SHOW_ON_HOME_PAGE` TINYINT NULL AFTER `IS_HOT`;


--
-- Table structure for table `TOUR_PRICE_GROUP`
--

CREATE TABLE `TOUR_PRICE_GROUP` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TOUR_PRICE_GROUP`
--

INSERT INTO `TOUR_PRICE_GROUP` (`ID`, `NAME`) VALUES
(0, 'Homestay/private room'),
(1, 'Homestay/dorm room'),
(2, '2* Hotel'),
(3, '3* Hotel'),
(4, '4* Hotel'),
(5, '5* Hotel'),
(6, '3* Cruise'),
(7, '4* Cruise'),
(8, '4* cruise ++'),
(9, '5* Cruise'),
(10, 'Group tour'),
(11, 'Private tour');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `TOUR_PRICE_GROUP`
--
ALTER TABLE `TOUR_PRICE_GROUP`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TOUR_PRICE_GROUP`
--
ALTER TABLE `TOUR_PRICE_GROUP`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
  
  
  
  
--
-- Table structure for table `TOUR_PRICE_GROUP_DETAIL`
--

CREATE TABLE `TOUR_PRICE_GROUP_DETAIL` (
  `ID` int(11) NOT NULL,
  `TOUR_TYPE_ID` int(11) NOT NULL,
  `TOUR_PRICE_GROUP_ID` int(11) NOT NULL,
  `FROM_PAX` smallint(6) DEFAULT NULL,
  `TO_PAX` smallint(6) DEFAULT NULL,
  `PRICE` double NOT NULL,
  `IS_ADD_PRICE` tinyint(4) DEFAULT '0',
  `ORDER` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for table `TOUR_PRICE_GROUP_DETAIL`
--
ALTER TABLE `TOUR_PRICE_GROUP_DETAIL`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `TOUR_PRICE_GROUP_DETAIL`
--
ALTER TABLE `TOUR_PRICE_GROUP_DETAIL`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=292;

