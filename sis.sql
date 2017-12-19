-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2013 at 03:22 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sis`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_record`
--

CREATE TABLE IF NOT EXISTS `student_record` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(30) NOT NULL,
  `mname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `addr` text NOT NULL,
  `gender` varchar(6) NOT NULL,
  `course` varchar(50) NOT NULL,
  `year` int(10) NOT NULL,
  `section` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `student_record`
--

INSERT INTO `student_record` (`ID`, `fname`, `mname`, `lname`, `addr`, `gender`, `course`, `year`, `section`) VALUES
(3, 'Roldan', 'Desperadoz', 'Raymundo', 'Banago, Bacolod City', 'Male', 'BSIS', 2, 'B'),
(4, 'Michael Jhon', 'Desperadoz', 'Lacaba', 'Airport, Bacolod City', 'Male', 'BSCS', 3, 'C'),
(5, 'Neil', 'Desperadoz', 'Soledad', 'Talisay, Negros Occ.', 'Male', 'BSIT', 2, 'A'),
(6, 'Eduardo', 'Desperadoz', 'Lapuos', 'Balaring, Silay, Neg. Occ.', 'Male', 'BSCE', 2, 'C');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
