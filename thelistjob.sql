-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 27, 2015 at 02:17 PM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thelistjob`
--

-- --------------------------------------------------------

--
-- Table structure for table `apikey`
--

CREATE TABLE IF NOT EXISTS `apikey` (
  `api_key` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`api_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apikey`
--

INSERT INTO `apikey` (`api_key`, `timestamp`) VALUES
('tejpratap', '2015-05-13 12:07:34');

-- --------------------------------------------------------

--
-- Table structure for table `c1fd0870fe8e2e2a12041e0b53525f31`
--

CREATE TABLE IF NOT EXISTS `c1fd0870fe8e2e2a12041e0b53525f31` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movieTodo` varchar(1000) DEFAULT NULL,
  `tvTodo` varchar(1000) DEFAULT NULL,
  `podcastTodo` varchar(1000) DEFAULT NULL,
  `musicTodo` varchar(1000) DEFAULT NULL,
  `musicPlaylist` varchar(1000) DEFAULT NULL,
  `podcastPlaylist` varchar(1000) DEFAULT NULL,
  `dummy1` varchar(1000) DEFAULT NULL,
  `dummy2` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `c1fd0870fe8e2e2a12041e0b53525f31`
--

INSERT INTO `c1fd0870fe8e2e2a12041e0b53525f31` (`id`, `movieTodo`, `tvTodo`, `podcastTodo`, `musicTodo`, `musicPlaylist`, `podcastPlaylist`, `dummy1`, `dummy2`) VALUES
(1, '<name>Avengers: Age of Ultron</name><id>tt2395427</id>', '<name>The Big Bang Theory</name><id>1418</id>', NULL, '<name><name>Simple plan</name></name>', NULL, NULL, NULL, NULL),
(2, '<name>Project Almanac</name><id>tt2436386</id>', '<name>The Flash</name><id>60735</id>', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '<name>Insurgent</name><id>tt2908446</id>', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, '<name>Friends</name><id>1668</id>', NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `timestamp`) VALUES
('tejpratap36@gmail.com', '9860637720', '2015-05-26 10:25:09');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
