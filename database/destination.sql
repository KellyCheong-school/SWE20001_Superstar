-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 22, 2023 at 02:19 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `s104650807_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `destination_id` int(10) NOT NULL,
  `destinationname` varchar(25) DEFAULT NULL,
  `destinationimg` varchar(60) DEFAULT NULL,
  `destinationdesc` text,
  `destinationprice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`destination_id`, `destinationname`, `destinationimg`, `destinationdesc`, `destinationprice`) VALUES
(1, 'Tokyo, Japan', '64df347f4c85e.jpg', 'AeroStar offers premium flight services to Tokyo, Japan.', 2000),
(2, 'Singapore', '64e0316b67f32.jpg', 'Singapore is a city that never fails to impress, and at AeroStar, we are committed to providing our passengers with a seamless and comfortable journey to this exciting destination.', 300),
(3, 'Bali, Indonesia', '64e034099a420.jpg', 'AeroStar provides premium flight services to Bali, Indonesia, offering a seamless and comfortable journey to this tropical paradise. With our modern aircraft, skilled pilots, and attentive crew, we ensure a safe and enjoyable flight experience for all our passengers.', 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`destination_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `destination_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
