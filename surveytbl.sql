-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 11, 2018 at 05:35 PM
-- Server version: 10.0.28-MariaDB
-- PHP Version: 5.6.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mos`
--

-- --------------------------------------------------------

--
-- Table structure for table `surveytbl`
--

CREATE TABLE `surveytbl` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `surveyid` int(11) NOT NULL DEFAULT '0',
  `action` varchar(255) DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `surveysw` int(11) DEFAULT '0',
  `createdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveytbl`
--

INSERT INTO `surveytbl` (`id`, `surveyid`, `action`, `state`, `surveysw`, `createdate`) VALUES
(1, 1, 'p33', 3, 0, '2018-02-09 20:21:03'),
(2, 2, 'p50', 0, 0, '2018-02-09 22:52:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surveytbl`
--
ALTER TABLE `surveytbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surveytbl`
--
ALTER TABLE `surveytbl`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
