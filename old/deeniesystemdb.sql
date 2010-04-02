-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 12, 2008 at 08:32 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `deeniesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `enroll_period`
--

CREATE TABLE `enroll_period` (
  `id` int(6) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL,
  `start_date` varchar(10) NOT NULL,
  `end_date` varchar(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `enroll_period`
--

INSERT INTO `enroll_period` (`id`, `mem_num`, `start_date`, `end_date`) VALUES
(37, 38, '08-01-2008', '11-01-2008'),
(38, 39, '08-01-2008', '08-02-2008'),
(41, 42, '08-01-2008', '09-01-2008'),
(42, 43, '08-01-2008', '09-28-2008'),
(45, 46, '08-01-2008', '09-28-2008'),
(46, 47, '08-01-2008', '08-02-2008'),
(47, 48, '08-02-2008', '11-02-2008'),
(48, 50, '09-01-2008', '10-01-2008'),
(49, 51, '09-25-2008', '09-25-2009'),
(50, 52, '09-25-2008', '09-26-2008'),
(51, 53, '09-25-2008', '09-26-2008'),
(52, 54, '09-25-2008', '09-28-2008'),
(53, 55, '09-25-2008', '12-25-2008'),
(54, 56, '09-26-2008', '09-27-2008'),
(56, 59, '09-26-2008', '09-27-2008'),
(57, 60, '09-27-2008', '12-29-2008'),
(58, 61, '09-27-2008', '09-27-2009'),
(60, 63, '09-27-2008', ''),
(61, 64, '09-27-2008', ''),
(62, 65, '09-27-2008', ''),
(63, 66, '09-27-2008', ''),
(64, 67, '09-27-2008', '09-28-2008'),
(65, 68, '09-27-2008', '10-27-2008'),
(66, 69, '09-27-2008', '09-28-2009'),
(67, 70, '09-27-2008', '09-28-2008'),
(68, 71, '09-28-2008', '12-30-2008'),
(69, 72, '09-30-2008', '01-02-2009'),
(70, 73, '10-02-2008', '01-04-2009'),
(71, 74, '10-04-2008', '01-06-2009'),
(72, 75, '10-06-2008', '01-08-2009'),
(73, 76, '10-08-2008', '01-10-2009'),
(74, 77, '10-10-2008', '11-12-2008'),
(75, 78, '10-12-2008', '10-13-2008');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_num` int(6) NOT NULL auto_increment,
  `email` varchar(30) NOT NULL,
  `mem_type` enum('single','couple') NOT NULL,
  PRIMARY KEY  (`member_num`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_num`, `email`, `mem_type`) VALUES
(38, 'joe@mail.com', 'couple'),
(39, 'emily@mail.com', 'single'),
(42, 'jack@dude,com', 'single'),
(43, 'dick@you.com', 'single'),
(46, 'john@thedickens.com', 'single'),
(47, 'lilia@themoon.com', 'single'),
(48, 'dane@donson.com', 'couple'),
(49, 'dan@mail.com', 'single'),
(50, 'dan@mail.com', 'single'),
(51, 'test@test.test', 'couple'),
(52, 'joana@tesla.com', 'single'),
(53, 'joe@dick.com', 'single'),
(54, 'rem@u.com', 'couple'),
(55, 'marjarendon@yahoo.com', 'couple'),
(56, 'tom@me.com', 'single'),
(59, 'jacktaht@mybutt.com', 'single'),
(60, 'test@me.com', 'single'),
(61, 'test@test.com', 'couple'),
(62, '', 'single'),
(63, '', 'single'),
(64, '', 'single'),
(65, '', 'single'),
(66, '', 'single'),
(67, 'Dude@man.com', 'single'),
(68, 'test@yo.com', 'single'),
(69, 'test@me.com', 'couple'),
(70, 'jade@me.com', 'single'),
(71, 'dickens@me.com', 'couple'),
(72, 'please@work.com', 'couple'),
(73, 'yes@no.com', 'couple'),
(74, 'try@this.com', 'couple'),
(75, 'new@try.com', 'couple'),
(76, 'aa@aa.com', 'couple'),
(77, 'please@work.com', 'single'),
(78, 'test@test.com', 'single');

-- --------------------------------------------------------

--
-- Table structure for table `member_enter`
--

CREATE TABLE `member_enter` (
  `id` int(11) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL COMMENT 'foreign key',
  `date_in` varchar(10) NOT NULL,
  `time_in` varchar(10) NOT NULL,
  `staff` varchar(20) NOT NULL COMMENT 'employee that checked the member in',
  `door_fee` int(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `member_enter`
--

INSERT INTO `member_enter` (`id`, `mem_num`, `date_in`, `time_in`, `staff`, `door_fee`) VALUES
(21, 38, '08-01-2008', '1:50pm', 'diego', 50),
(22, 43, '08-01-2008', '1:55pm', 'diego', 120),
(23, 51, '09-25-2008', '6:31pm', 'diego', 50),
(24, 52, '09-25-2008', '6:34pm', 'diego', 5),
(25, 53, '09-25-2008', '6:36pm', 'diego', 100),
(26, 54, '09-25-2008', '7:28pm', 'diego', 60),
(27, 55, '09-25-2008', '7:46pm', 'diego', 50),
(28, 55, '09-25-2008', '7:54pm', 'diego', 50),
(29, 55, '09-25-2008', '7:57pm', 'diego', 50),
(30, 55, '09-25-2008', '8:01pm', 'diego', 50),
(31, 56, '09-26-2008', '3:37pm', 'diego', 70),
(34, 59, '09-26-2008', '6:37pm', 'diego', 5),
(37, 55, '09-26-2008', '6:39pm', 'diego', 120),
(38, 55, '09-26-2008', '6:40pm', 'diego', 20),
(39, 60, '09-27-2008', '2:55pm', 'diego', 70),
(40, 60, '09-27-2008', '2:59pm', 'diego', 70),
(41, 60, '09-27-2008', '3:01pm', 'diego', 70),
(42, 61, '09-27-2008', '3:06pm', 'diego', 3000),
(43, 61, '09-27-2008', '3:06pm', 'diego', 0),
(44, 60, '09-27-2008', '3:07pm', 'diego', 70),
(45, 50, '09-27-2008', '3:13pm', 'diego', 250),
(46, 43, '09-27-2008', '3:30pm', 'diego', 170),
(47, 43, '09-27-2008', '3:33pm', 'diego', 50),
(48, 43, '09-27-2008', '3:53pm', 'diego', 50),
(49, 43, '09-27-2008', '3:55pm', 'diego', 50),
(50, 43, '09-27-2008', '3:58pm', 'diego', 50),
(51, 43, '09-27-2008', '4:07pm', 'diego', 50),
(52, 43, '09-27-2008', '4:17pm', 'diego', 50),
(53, 43, '09-27-2008', '4:21pm', 'diego', 170),
(54, 43, '09-27-2008', '4:24pm', 'diego', 170),
(55, 43, '09-27-2008', '4:25pm', 'diego', 50),
(56, 54, '09-27-2008', '7:41pm', 'diego', 60),
(57, 46, '09-27-2008', '7:45pm', 'diego', 220),
(58, 71, '09-28-2008', '3:15pm', 'diego', 80),
(59, 71, '09-29-2008', '3:19pm', 'diego', 0),
(60, 72, '09-30-2008', '3:36pm', 'diego', 20),
(61, 73, '10-02-2008', '3:42pm', 'diego', 20),
(62, 74, '10-04-2008', '3:50pm', 'diego', 80),
(63, 75, '10-06-2008', '3:59pm', 'diego', 20),
(64, 76, '10-08-2008', '4:04pm', 'diego', 20),
(65, 76, '10-10-2008', '4:23pm', 'diego', 150),
(66, 77, '10-10-2008', '4:25pm', 'diego', 20),
(67, 77, '10-12-2008', '4:30pm', 'diego', 50);

-- --------------------------------------------------------

--
-- Table structure for table `member_info`
--

CREATE TABLE `member_info` (
  `id` int(6) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL COMMENT 'foreign key',
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `fname2` varchar(20) default 'none',
  `lname2` varchar(20) default 'none',
  `gender` varchar(6) NOT NULL,
  `bday` varchar(10) NOT NULL,
  `bday2` varchar(10) default 'n/a',
  `anniv` varchar(15) default 'n/a',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `member_info`
--

INSERT INTO `member_info` (`id`, `mem_num`, `fname`, `lname`, `fname2`, `lname2`, `gender`, `bday`, `bday2`, `anniv`) VALUES
(38, 38, 'Joe', 'Smith', 'Jane', 'Smith', 'couple', '03/04/1954', '', '06/23/1978'),
(39, 39, 'Emily', 'Johnson', 'none', 'none', 'female', '12/12/1985', '', 'n/a'),
(42, 42, 'Jack', 'Williams', 'none', 'none', 'male', '12/12/1985', '', 'n/a'),
(43, 43, 'Dick', 'Harper', 'none', 'none', 'male', '10/28/1985', '', 'n/a'),
(46, 46, 'John', 'Dickens', 'none', 'none', 'male', '12/12/1964', 'n/a', 'n/a'),
(47, 47, 'Lilia', 'Nubis', 'none', 'none', 'female', '08/02/1975', 'n/a', 'n/a'),
(48, 48, 'Dane', 'Donson', 'Donna', 'Donson', 'couple', '09/30/1965', '09/27/1970', '12/12/1988'),
(49, 50, 'Dan', 'Lebowski', 'none', 'none', 'male', '02/06/1978', 'n/a', 'n/a'),
(50, 51, 'Test1', 'Test1', 'Test2', 'Test2', 'couple', '02/06/1978', '04/03/1960', '06/23/1978'),
(51, 52, 'Joana', 'Tesla', 'none', 'none', 'female', '02/06/1979', 'n/a', 'n/a'),
(52, 53, 'Joe', 'Dick', 'none', 'none', 'male', '09/12/1974', 'n/a', 'n/a'),
(53, 54, 'Maguy1', 'Lastname', 'Emily', 'Barrett', 'couple', '04/12/1966', '08/06/1970', '06/23/1978'),
(54, 55, 'Marja', 'Lenard', 'Tom', 'Lenard', 'couple', '08/05/1965', '02/12/1950', '02/07/2000'),
(55, 56, 'Tom', 'Hasit', 'none', 'none', 'male', '04/12/1966', 'n/a', 'n/a'),
(57, 59, 'jakye', 'jacker', 'none', 'none', 'female', '02/06/1978', 'n/a', 'n/a'),
(58, 60, 'test2', 'test2', 'none', 'none', 'male', '04/12/1966', 'n/a', 'n/a'),
(59, 61, 'TestDude', 'Dude', 'TestChick', 'Test', 'couple', '04/12/1966', '6', '06/23/1978'),
(61, 63, '', '', 'none', 'none', 'male', 'MM/DD/YYYY', 'n/a', 'n/a'),
(62, 64, '', '', 'none', 'none', 'male', 'MM/DD/YYYY', 'n/a', 'n/a'),
(63, 65, '', '', 'none', 'none', 'male', 'MM/DD/YYYY', 'n/a', 'n/a'),
(64, 66, '', '', 'none', 'none', 'male', 'MM/DD/YYYY', 'n/a', 'n/a'),
(65, 67, 'Dude', 'Man', 'none', 'none', 'male', '10/28/1985', 'n/a', 'n/a'),
(66, 68, 'TEsting', 'Validation', 'none', 'none', 'male', '02/22/1944', 'n/a', 'n/a'),
(67, 69, 'Test', 'Valid', 'Test2', 'Valid2', 'couple', '04/12/1966', '02/12/1950', '06/23/1978'),
(68, 70, 'Jade', 'test', 'none', 'none', 'female', '09/12/1974', 'n/a', 'n/a'),
(69, 71, 'Dickens', 'Omalley', 'Jade', 'Dickens', 'couple', '03/04/1954', '04/03/1960', '06/23/1978'),
(70, 72, 'This', 'Time', 'Please', 'Work', 'couple', '04/12/1966', '08/06/1970', '06/23/1978'),
(71, 73, 'How', 'About', 'This', 'Time', 'couple', '03/04/1954', '02/12/1950', '06/23/1978'),
(72, 74, 'And', 'Now', 'Try', 'This', 'couple', '03/04/1955', '02/12/1950', '04/16/1969'),
(73, 75, 'New', 'Try', 'Please', 'Word', 'couple', '03/04/1954', '04/03/1960', '04/16/1969'),
(74, 76, 'Again', 'Now', 'Please', 'ThisTime', 'couple', '09/12/1974', '04/03/1960', '06/23/1978'),
(75, 77, 'The', 'TEst', 'none', 'none', 'male', '03/04/1954', 'n/a', 'n/a'),
(76, 78, 'Another', 'Test', 'none', 'none', 'male', '03/04/1954', 'n/a', 'n/a');

-- --------------------------------------------------------

--
-- Table structure for table `member_score`
--

CREATE TABLE `member_score` (
  `id` int(6) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL COMMENT 'foreign key',
  `nudity` tinytext NOT NULL,
  `sex_act` tinytext NOT NULL,
  `swinging` tinytext NOT NULL,
  `police` tinytext NOT NULL,
  `agree` tinytext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `member_score`
--

INSERT INTO `member_score` (`id`, `mem_num`, `nudity`, `sex_act`, `swinging`, `police`, `agree`) VALUES
(38, 38, '1', '1', '1', '1', '1'),
(39, 39, '1', '1', '1', '1', '1'),
(42, 42, '1', '1', '1', '1', '1'),
(43, 43, '1', '1', '1', '1', '1'),
(46, 46, '1', '1', '1', '1', '1'),
(47, 47, '1', '1', '1', '1', '1'),
(48, 48, '1', '1', '1', '1', '1'),
(49, 50, '1', '1', '1', '1', '1'),
(50, 51, '1', '1', '1', '1', '1'),
(51, 52, '1', '1', '1', '1', '1'),
(52, 53, '1', '1', '1', '1', '1'),
(53, 54, '1', '1', '1', '1', '1'),
(54, 55, '1', '1', '1', '1', '1'),
(55, 56, '1', '1', '1', '1', '1'),
(57, 59, '1', '1', '1', '1', '1'),
(58, 60, '1', '1', '1', '1', '1'),
(59, 61, '1', '1', '1', '1', '1'),
(61, 63, '', '', '', '', ''),
(62, 64, '', '', '', '', ''),
(63, 65, '', '', '', '', ''),
(64, 66, '', '', '', '', ''),
(65, 67, '1', '1', '1', '1', '1'),
(66, 68, '1', '2', '1', '2', '1'),
(67, 69, '1', '1', '1', '1', '1'),
(68, 70, '1', '1', '1', '1', '1'),
(69, 71, '1', '1', '1', '1', '1'),
(70, 72, '1', '1', '1', '1', '1'),
(71, 73, '1', '1', '1', '1', '1'),
(72, 74, '1', '1', '1', '1', '1'),
(73, 75, '1', '1', '1', '1', '1'),
(74, 76, '1', '1', '1', '1', '1'),
(75, 77, '1', '1', '1', '1', '1'),
(76, 78, '1', '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mem_price`
--

CREATE TABLE `mem_price` (
  `id` int(11) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL COMMENT 'foreign key',
  `mem_length` varchar(15) NOT NULL COMMENT 'length of membership',
  `cost` varchar(6) NOT NULL,
  `paid_mem_fee` enum('Yes','No') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `mem_price`
--

INSERT INTO `mem_price` (`id`, `mem_num`, `mem_length`, `cost`, `paid_mem_fee`) VALUES
(35, 38, 'Three Months', '100', 'No'),
(36, 39, 'One Day', '5', 'No'),
(39, 42, 'One Month', '200', 'No'),
(40, 43, 'One Day', '120', 'No'),
(43, 46, 'One Day', '120', 'No'),
(44, 47, 'One Day', '5', 'No'),
(45, 48, 'Three Months', '100', 'No'),
(46, 50, 'One Month', '200', 'No'),
(47, 51, 'One Year', '150', 'No'),
(48, 52, 'One Day', '5', 'No'),
(49, 53, 'One Day', '20', 'No'),
(50, 54, 'One Day', '20', 'No'),
(51, 55, 'Three Months', '100', 'No'),
(52, 56, 'One Day', '20', 'No'),
(54, 59, 'One Day', '5', 'No'),
(55, 60, 'One Day', '20', 'No'),
(56, 61, 'One Year VIP', '3000', 'No'),
(58, 63, '', '', 'No'),
(59, 64, '', '', 'No'),
(60, 65, '', '', 'No'),
(61, 66, '', '', 'No'),
(62, 67, 'One Day', '20', 'No'),
(63, 68, 'One Month', '200', 'No'),
(64, 69, 'One Day', '20', 'No'),
(65, 70, 'One Day', '5', 'No'),
(66, 71, 'One Day', '0', 'No'),
(67, 72, 'Three Months', '20', 'No'),
(68, 73, 'Three Months', '20', 'No'),
(69, 74, 'Three Months', '0', 'No'),
(70, 75, 'Three Months', 'Array', 'No'),
(71, 76, 'Three Months', '150', 'No'),
(72, 77, 'One Month', '', 'Yes'),
(73, 78, 'One Day', '120', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `partners_info`
--

CREATE TABLE `partners_info` (
  `id` int(11) NOT NULL auto_increment,
  `mem_num` int(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `bday` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `partners_info`
--

INSERT INTO `partners_info` (`id`, `mem_num`, `email`, `fname`, `lname`, `bday`) VALUES
(1, 48, '', 'Donna', 'Donson', '08/06/1970'),
(2, 51, '', 'Test2', 'Test2', '04/03/1960'),
(3, 54, '', 'Emily', 'Barrett', '08/06/1970'),
(4, 55, '', 'Tom', 'Lenard', '02/12/1950'),
(5, 61, '', 'TestChick', 'Test', '6'),
(6, 69, '', 'Test2', 'Valid2', '02/12/1950'),
(7, 71, '', 'Jade', 'Dickens', '04/03/1960'),
(8, 72, '', 'Please', 'Work', '08/06/1970'),
(9, 73, '', 'This', 'Time', '02/12/1950'),
(10, 74, '', 'Try', 'This', '02/12/1950'),
(11, 75, '', 'Please', 'Word', '04/03/1960'),
(12, 76, '', 'Please', 'ThisTime', '04/03/1960');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) NOT NULL auto_increment,
  `type` enum('admin','user') NOT NULL,
  `username` varchar(20) NOT NULL,
  `hashed_pw` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=armscii8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `username`, `hashed_pw`) VALUES
(6, 'admin', 'marja', 'f865b53623b121fd34ee5426c792e5c33af8c227'),
(7, 'admin', 'diego', '2ed1cecb36161ab7d99697aa52db95f3a83578f0');
