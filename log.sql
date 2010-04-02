-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 08, 2009 at 12:12 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `deeniesdb`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `log`
-- 

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL auto_increment,
  `timestamp` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii AUTO_INCREMENT=15 ;

-- 
-- Dumping data for table `log`
-- 

