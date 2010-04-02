-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 08, 2009 at 12:13 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `deeniesdb`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `memberships`
-- 

CREATE TABLE `memberships` (
  `id` int(6) NOT NULL auto_increment,
  `membership` varchar(20) NOT NULL,
  `male` varchar(6) NOT NULL,
  `female` varchar(6) NOT NULL,
  `couple` varchar(6) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `memberships`
-- 

INSERT INTO `memberships` VALUES (1, '1_Month', '150', 'X', 'X');
INSERT INTO `memberships` VALUES (2, '3_Months', 'X', '25', '85');
INSERT INTO `memberships` VALUES (3, '1_Year', '500', 'X', '200');
INSERT INTO `memberships` VALUES (7, '1_Yr_Couples_VIP', 'X', 'X', 'X');
INSERT INTO `memberships` VALUES (8, '1_Yr_Singles_VIP', 'X', 'X', 'X');
