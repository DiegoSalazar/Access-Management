-- phpMyAdmin SQL Dump
-- version 3.1.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2009 at 02:21 PM
-- Server version: 5.1.32
-- PHP Version: 5.2.9-1

--SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `deeniesdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--
USE deeniesdb

CREATE TABLE IF NOT EXISTS `deeniesdb`.`discounts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `desc` varchar(100) NOT NULL,
  `amount` mediumtext NOT NULL,
  `operation` enum('minus','percent') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=16 ;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `desc`, `amount`, `operation`) VALUES
(8, '15% Off Wednesdays', '15', 'percent'),
(15, 'Wednesday couples 10 dollars off', '10', 'minus');

-- --------------------------------------------------------

--
-- Table structure for table `door_fees`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`door_fees` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `male` varchar(7) NOT NULL,
  `female` varchar(7) NOT NULL,
  `couple` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=9 ;

--
-- Dumping data for table `door_fees`
--

INSERT INTO `door_fees` (`id`, `day`, `male`, `female`, `couple`) VALUES
(1, 'Monday', '50,75', '5,5', '35,35'),
(2, 'Tuesday', '50,75', '5,5', '35,35'),
(3, 'Wednesday', '50,75', '5,5', '35,35'),
(4, 'Thursday', '50,75', '5,5', '35,35'),
(5, 'Friday', '50,85', '5,10', '55,55'),
(6, 'Saturday', '50,X', '5,10', '60,60'),
(7, 'Sunday', '50,85', '5,10', '50,50');

-- --------------------------------------------------------

--
-- Table structure for table `enroll_period`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`enroll_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `membership` varchar(20) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=160 ;

--
-- Dumping data for table `enroll_period`
--

INSERT INTO `enroll_period` (`id`, `mem_id`, `membership`, `start_date`, `end_date`) VALUES
(152, 96, '1_Year', '2009-04-29', '2010-04-29'),
(153, 97, '1_Month', '2009-04-29', '2009-05-29'),
(154, 98, '1_Month', '2009-04-29', '2009-05-29'),
(155, 99, '1_Year', '2009-04-29', '2010-04-29'),
(156, 100, '3_Months', '2009-04-29', '2009-07-29'),
(157, 101, '1_Year', '2009-05-01', '2010-05-01'),
(158, 102, '1_Year', '2009-05-10', '2010-05-10'),
(159, 103, '3_Months', '2009-05-10', '2009-08-10');

-- --------------------------------------------------------

--
-- Table structure for table `entrance_log`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`entrance_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL COMMENT 'foreign key',
  `date_in` varchar(10) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `staff` varchar(20) NOT NULL COMMENT 'employee that checked the member in',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=158 ;

--
-- Dumping data for table `entrance_log`
--

INSERT INTO `entrance_log` (`id`, `mem_id`, `date_in`, `time_in`, `staff`) VALUES
(139, 97, '2009-04-29', '1:55am', 'diego'),
(140, 98, '2009-04-29', '1:57am', 'diego'),
(141, 99, '2009-04-29', '2:01am', 'diego'),
(142, 100, '2009-04-29', '2:41am', 'diego'),
(143, 101, '2009-05-01', '2:36pm', 'diego'),
(144, 101, '2009-05-01', '2:36pm', 'diego'),
(145, 101, '2009-05-09', '2:10pm', 'diego'),
(146, 100, '2009-05-09', '2:12pm', 'diego'),
(147, 97, '2009-05-10', '11:16am', 'diego'),
(148, 98, '2009-05-10', '11:16am', 'diego'),
(149, 99, '2009-05-10', '11:20am', 'diego'),
(150, 99, '2009-05-10', '11:22am', 'diego'),
(151, 102, '2009-05-10', '11:24am', 'diego'),
(152, 102, '2009-05-10', '11:24am', 'diego'),
(153, 102, '2009-05-10', '12:38pm', 'diego'),
(154, 102, '2009-05-10', '12:38pm', 'diego'),
(155, 99, '2009-05-10', '12:43pm', 'diego'),
(156, 100, '2009-05-10', '12:52pm', 'diego'),
(157, 103, '2009-05-10', '12:59pm', 'diego');

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`hours` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `day_start` varchar(4) NOT NULL,
  `day_end` varchar(4) NOT NULL,
  `night_start` varchar(4) NOT NULL,
  `night_end` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=8 ;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id`, `day`, `day_start`, `day_end`, `night_start`, `night_end`) VALUES
(1, 'Monday', '9am', '5pm', '5pm', '4am'),
(2, 'Tuesday', '9am', '5pm', '5pm', '4am'),
(3, 'Wednesday', '9am', '5pm', '5pm', '5pm'),
(4, 'Thursday', '9am', '5pm', '5pm', '5pm'),
(5, 'Friday', '9am', '5pm', '5pm', '5pm'),
(6, 'Saturday', '9am', '5pm', '5pm', '5pm'),
(7, 'Sunday', '9am', '5pm', '5pm', '5pm');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_num` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `type` enum('male','female','couple') NOT NULL,
  `status` enum('newby','active','disabled') NOT NULL DEFAULT 'newby',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_num` (`member_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=104 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `member_num`, `email`, `type`, `status`, `date_created`) VALUES
(96, 'M1', 'imawesome@me.com', 'male', 'disabled', '2009-04-29 01:48:54'),
(97, 'M97', 'wild@me.com', 'male', 'active', '2009-04-29 01:50:52'),
(98, 'M98', 'dan@rather.com', 'male', 'active', '2009-04-29 01:55:47'),
(99, 'C99', 'larry@mail.com', 'couple', 'active', '2009-04-29 02:00:06'),
(100, 'C100', 'larry@mail.com', 'couple', 'active', '2009-04-29 02:09:21'),
(101, 'C101', 'maill@mail.com', 'couple', 'active', '2009-05-01 14:35:16'),
(102, 'M102', 'mail@me.com', 'male', 'active', '2009-05-10 11:23:43'),
(103, 'F103', 'mastermindxs@gmail.com', 'female', 'active', '2009-05-10 12:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`memberships` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `membership` varchar(10) NOT NULL,
  `male` varchar(6) NOT NULL,
  `female` varchar(6) NOT NULL,
  `couple` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=4 ;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `membership`, `male`, `female`, `couple`) VALUES
(1, '1_Month', '150', 'X', 'X'),
(2, '3_Months', 'X', '25', '85'),
(3, '1_Year', '500', 'X', '200');

-- --------------------------------------------------------

--
-- Table structure for table `member_info`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`member_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL COMMENT 'foreign key',
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `bday` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=173 ;

--
-- Dumping data for table `member_info`
--

INSERT INTO `member_info` (`id`, `mem_id`, `fname`, `lname`, `email`, `bday`) VALUES
(165, 96, 'Bill', 'Awesome', 'imawesome@me.com', '1988-04-15'),
(166, 97, 'Wild', 'Bill', 'wild@me.com', '1977-09-06'),
(167, 98, 'Dan', 'Rather', 'dan@rather.com', '1964-09-04'),
(168, 99, 'Larry', 'Wagner', 'larry@mail.com', '1988-04-08'),
(169, 100, 'Andrew', 'Sid', 'larry@mail.com', '1975-04-16'),
(170, 101, 'John', 'Smith', 'maill@mail.com', '1988-05-12'),
(171, 102, 'Dick', 'Harper', 'mail@me.com', '1988-05-11'),
(172, 103, 'Jane', 'Smith', 'mastermindxs@gmail.com', '1977-05-11');

-- --------------------------------------------------------

--
-- Table structure for table `partners_info`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`partners_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `bday` varchar(10) NOT NULL,
  `anniv` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `partners_info`
--

INSERT INTO `partners_info` (`id`, `mem_id`, `email`, `fname`, `lname`, `bday`, `anniv`) VALUES
(26, 99, 'amy@mail.com', 'Amy', 'Wagner', '1988-04-04', '2007-04-13'),
(27, 100, 'amy@mail.com', 'Ashley', 'Sid', '1974-04-15', '1995-04-13'),
(28, 101, 'mail@mail.com', 'Jane', 'Smith', '1988-05-09', '2007-05-04');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mem_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mem_fee` int(6) NOT NULL DEFAULT '0',
  `raw_door_fee` int(11) NOT NULL DEFAULT '0',
  `door_fee` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `discounts` varchar(255) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=106 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `mem_id`, `date`, `mem_fee`, `raw_door_fee`, `door_fee`, `total`, `discounts`) VALUES
(105, 103, '2009-05-10 12:59:01', 25, 5, 5, 30, ''),
(104, 100, '2009-05-10 12:52:45', 0, 50, 50, 50, ''),
(103, 99, '2009-05-10 12:43:02', 0, 50, 40, 40, '$10 Off'),
(102, 102, '2009-05-10 12:38:23', 0, 50, 42, 42, '15 Percent Off'),
(101, 102, '2009-05-10 12:38:22', 0, 50, 42, 42, '15 Percent Off'),
(100, 102, '2009-05-10 11:24:41', 0, 50, 50, 50, ''),
(99, 102, '2009-05-10 11:24:17', 500, 50, 42, 542, '15 Percent Off'),
(98, 99, '2009-05-10 11:22:29', 0, 50, 50, 50, ''),
(97, 99, '2009-05-10 11:20:33', 0, 50, 50, 50, ''),
(96, 98, '2009-05-10 11:16:45', 0, 50, 42, 42, '15 Percent Off'),
(95, 97, '2009-05-10 11:16:30', 0, 50, 50, 50, ''),
(94, 100, '2009-05-09 14:12:26', 0, 60, 60, 60, ''),
(93, 101, '2009-05-09 14:10:51', 0, 60, 60, 60, ''),
(92, 101, '2009-05-01 14:36:29', 0, 55, 55, 55, ''),
(91, 101, '2009-05-01 14:36:05', 200, 55, 47, 247, '15 Percent Off'),
(90, 100, '2009-04-29 02:41:54', 85, 35, 0, 85, '$50 Off'),
(89, 99, '2009-04-29 02:01:14', 200, 35, 31, 231, '10 Percent Off'),
(88, 98, '2009-04-29 01:57:01', 150, 75, 25, 175, '$50 Off'),
(87, 97, '2009-04-29 01:55:57', 150, 75, 64, 214, '15 Percent Off');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `deeniesdb`.`users` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `type` enum('admin','staff') NOT NULL,
  `username` varchar(20) NOT NULL,
  `hashed_pw` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `username`, `hashed_pw`) VALUES
(13, 'admin', 'diego', '2ed1cecb36161ab7d99697aa52db95f3a83578f0'),
(49, 'admin', 'marja', '65992e3a4419d7b560e369bdba5c110b835487a6'),
(97, 'staff', 'tech', 'c95ee47689a0aaec70c3eb950244657722c69b1f'),
(98, 'staff', 'tech2', 'fa3abec7ffc000fb54a0d786b0de1f8f5bed98e8'),
(100, 'staff', 'tech3', 'da39a3ee5e6b4b0d3255bfef95601890afd80709');
