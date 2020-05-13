-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2020 at 02:57 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wpl3_upb_states`
--

CREATE TABLE `wpl3_upb_states` (
  `id` int(45) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wpl3_upb_states`
--

INSERT INTO `wpl3_upb_states` (`id`, `name`, `created`) VALUES
(1, 'Alabama', '2020-02-20 06:03:54'),
(2, 'Alaska', '2020-02-20 06:03:54'),
(3, 'Arizona', '2020-02-20 06:03:54'),
(4, 'Arkansas', '2020-02-20 06:03:54'),
(5, 'California', '2020-02-20 06:03:54'),
(6, 'Colorado', '2020-02-20 06:03:54'),
(7, 'Connecticut', '2020-02-20 06:03:54'),
(8, 'Delaware', '2020-02-20 06:03:54'),
(9, 'District of Columbia', '2020-02-20 06:03:54'),
(10, 'Florida', '2020-02-20 06:03:54'),
(11, 'Georgia', '2020-02-20 06:03:54'),
(12, 'Hawaii', '2020-02-20 06:03:54'),
(13, 'Idaho', '2020-02-20 06:03:54'),
(14, 'Illinois', '2020-02-20 06:03:55'),
(15, 'Indiana', '2020-02-20 06:03:55'),
(16, 'Iowa', '2020-02-20 06:03:55'),
(17, 'Kansas', '2020-02-20 06:03:55'),
(18, 'Kentucky', '2020-02-20 06:03:55'),
(19, 'Louisiana', '2020-02-20 06:03:55'),
(20, 'Maine', '2020-02-20 06:03:55'),
(21, 'Maryland', '2020-02-20 06:03:55'),
(22, 'Massachusetts', '2020-02-20 06:03:55'),
(23, 'Michigan', '2020-02-20 06:03:55'),
(24, 'Minnesota', '2020-02-20 06:03:55'),
(25, 'Mississippi', '2020-02-20 06:03:55'),
(26, 'Missouri', '2020-02-20 06:03:55'),
(27, 'Montana', '2020-02-20 06:03:55'),
(28, 'Nebraska', '2020-02-20 06:03:55'),
(29, 'Nevada', '2020-02-20 06:03:55'),
(30, 'New Hampshire', '2020-02-20 06:03:55'),
(31, 'New Jersey', '2020-02-20 06:03:55'),
(32, 'New Mexico', '2020-02-20 06:03:55'),
(33, 'New York', '2020-02-20 06:03:55'),
(34, 'North Carolina', '2020-02-20 06:03:55'),
(35, 'North Dakota', '2020-02-20 06:03:55'),
(36, 'Ohio', '2020-02-20 06:03:55'),
(37, 'Oklahoma', '2020-02-20 06:03:55'),
(38, 'Oregon', '2020-02-20 06:03:55'),
(39, 'Pennsylvania', '2020-02-20 06:03:55'),
(40, 'Rhode Island', '2020-02-20 06:03:55'),
(41, 'South Carolina', '2020-02-20 06:03:55'),
(42, 'South Dakota', '2020-02-20 06:03:55'),
(43, 'Tennessee', '2020-02-20 06:03:55'),
(44, 'Texas', '2020-02-20 06:03:55'),
(45, 'Utah', '2020-02-20 06:03:55'),
(46, 'Vermont', '2020-02-20 06:03:55'),
(47, 'Virginia', '2020-02-20 06:03:55'),
(48, 'Washington', '2020-02-20 06:03:55'),
(49, 'West Virginia', '2020-02-20 06:03:56'),
(50, 'Wisconsin', '2020-02-20 06:03:56'),
(51, 'Wyoming', '2020-02-20 06:03:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wpl3_upb_states`
--
ALTER TABLE `wpl3_upb_states`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wpl3_upb_states`
--
ALTER TABLE `wpl3_upb_states`
  MODIFY `id` int(45) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
