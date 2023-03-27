-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2022-06-10 17:03:14
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `vote`
--
CREATE DATABASE IF NOT EXISTS `vote` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `vote`;

-- --------------------------------------------------------

--
-- 表的结构 `carinfo`
--

CREATE TABLE `carinfo` (
  `id` int(11) NOT NULL,
  `carName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `carDesc` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `carPic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `carNum` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `carinfo`
--

INSERT INTO `carinfo` (`id`, `carName`, `carDesc`, `carPic`, `carNum`) VALUES
(1, '奥迪A7', '奥迪A7是一款定位介于C级行政/公务和D级豪华轿车之间的四门运动豪华Coupe轿跑车，尺寸上略大于没有加长过的C级行政轿车，小于D级豪华轿车。', '1.jpg', 10),
(2, '奔弛C63', '奔驰C63 AMG旅行版曾作为F1医疗车，发动机将搭载6.2L V8引擎，最大功率可达336千瓦，最大扭矩为600牛。米。C63 AMG Estate完全颠覆了旅行车的定义。厂家对款奔驰C63 AMG全车进行了大面积的遮掩覆盖。但可以清楚的看出大灯曲线变得较为修长，前保险杠进行了全新的设计，双杠设计的前格栅变成了单杠，另外反光镜也重新做了调整。内饰中修改后的中控台增加了COMAND播放功能。', '2.jpg', 25),
(3, '别克君威', '作为别克品牌最成功的战略车型之一，君威凭借潮流、动感、科技的产品形象和全面的技术实力深受用户青睐。别克君威汇聚通用汽车全球先进技术，在承袭传统优势的同时，针对新时期消费者不断提升的用车需求，以革新的产品实力带来新驾值之美，实现动感型格、驾乘品质、科技属性的再次进化。', '3.jpg', 20),
(5, '吉普牧马人', '吉普牧马人Jeep最新的Rock-Trac分时四驱系统是Jeep牧马人Rubicon(罗宾汉)超强攀爬能力的核心所在，也是目前业内最专业的机械式四驱系统。Jeep牧马人车型自诞生以来，就一直被作为全世界越野爱好者的终极向往，它象征着自由和激情，以及对更纯粹生活方式的理解和追求。', '5.jpg', 8),
(6, '路虎揽胜', '路虎揽胜是路虎的旗下的豪华SUV。路虎揽胜经过精心设计成为有史以来精致、强悍的路虎。采用最新的车身和底盘技术，无论是其越野能力的广度和可通过性，还是公路的操控和舒适性，车辆的全地形性能都被提升到另一个层面。', '7.jpg', 2),
(7, '宝马X7', '宝马X7是宝马公司旗下一款汽车。\n宝马X7将在美国南卡罗来纳州的宝马斯巴腾堡工厂投产，并已在2018洛杉矶车展上首发亮相，计划于 2019 年正式进入中国市场。', '6.jpg', 30),
(8, '英菲尼迪QX80', '英菲尼迪QX80是英菲尼迪旗下的一款商务车，采用了5.6L发动机，满足商务接待的需求。', '8.jpg', 15);

-- --------------------------------------------------------

--
-- 表的结构 `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `userName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pw` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `userinfo`
--

INSERT INTO `userinfo` (`id`, `userName`, `pw`, `email`, `pic`, `admin`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '', '', 1),
(2, 'zhang', 'e10adc3949ba59abbe56e057f20f883e', '', '', 0),
(3, 'phpcms', 'e10adc3949ba59abbe56e057f20f883e', '269856@qq.com', '', 0),
(4, 'admin11', 'e10adc3949ba59abbe56e057f20f883e', '111@qq.com', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `votedetail`
--

CREATE TABLE `votedetail` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `voteTime` datetime NOT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `votedetail`
--

INSERT INTO `votedetail` (`id`, `userID`, `carID`, `voteTime`, `ip`) VALUES
(32, 1, 8, '2022-06-05 16:20:50', '127.0.0.1'),
(33, 1, 8, '2022-06-05 16:31:40', '127.0.0.1'),
(34, 1, 8, '2022-06-05 16:33:41', '127.0.0.1'),
(35, 1, 8, '2022-06-05 16:34:50', '127.0.0.1'),
(36, 1, 8, '2022-06-05 16:36:16', '127.0.0.1'),
(37, 1, 7, '2022-06-05 16:58:13', '127.0.0.1'),
(38, 1, 5, '2022-06-08 16:50:33', '127.0.0.1'),
(39, 1, 7, '2022-06-08 16:52:15', '127.0.0.1'),
(40, 1, 7, '2022-06-08 16:53:47', '127.0.0.1');

--
-- 转储表的索引
--

--
-- 表的索引 `carinfo`
--
ALTER TABLE `carinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `votedetail`
--
ALTER TABLE `votedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carID` (`carID`),
  ADD KEY `userID` (`userID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `carinfo`
--
ALTER TABLE `carinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `votedetail`
--
ALTER TABLE `votedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 限制导出的表
--

--
-- 限制表 `votedetail`
--
ALTER TABLE `votedetail`
  ADD CONSTRAINT `votedetail_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `votedetail_ibfk_2` FOREIGN KEY (`carID`) REFERENCES `carinfo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
