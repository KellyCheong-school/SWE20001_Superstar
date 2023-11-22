-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: ictstu-db1.cc.swin.edu.au
-- Generation Time: Aug 16, 2023 at 06:52 AM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.3.33

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) NOT NULL,
  `order_cost` float DEFAULT NULL,
  `order_time` datetime DEFAULT NULL,
  `order_status` varchar(10) DEFAULT NULL,
  `firstname` varchar(25) DEFAULT NULL,
  `lastname` varchar(25) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `street` varchar(40) DEFAULT NULL,
  `suburb` varchar(20) DEFAULT NULL,
  `state` varchar(3) DEFAULT NULL,
  `postcode` varchar(4) DEFAULT NULL,
  `contact` varchar(5) DEFAULT NULL,
  `departureDate` date DEFAULT NULL,
  `returnDate` date DEFAULT NULL,
  `flight` varchar(15) DEFAULT NULL,
  `cabin` varchar(15) DEFAULT NULL,
  `features` varchar(40) DEFAULT NULL,
  `numTickets` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `cardType` varchar(10) DEFAULT NULL,
  `cardName` varchar(40) DEFAULT NULL,
  `cardNumber` varchar(16) DEFAULT NULL,
  `expiryDate` varchar(5) DEFAULT NULL,
  `cvv` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_time`, `order_status`, `firstname`, `lastname`, `email`, `phone`, `street`, `suburb`, `state`, `postcode`, `contact`, `departureDate`, `returnDate`, `flight`, `cabin`, `features`, `numTickets`, `comment`, `cardType`, `cardName`, `cardNumber`, `expiryDate`, `cvv`) VALUES
(3, 2250, '2023-06-17 18:06:01', 'Paid', 'John', 'Doe', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-06-17', '2023-06-23', 'Singapore', 'Economy Class', 'Gourmet Dining, Premium Entertainment', 5, 'Lol', 'Visa', 'OMG', '4444444444444444', '12-24', '123'),
(5, 4250, '2023-06-17 21:16:56', 'Fulfilled', 'Peter', 'Wong', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-06-26', '2023-06-30', 'Bali, Indonesia', 'Business Class', 'Gourmet Dining', 5, 'Haha', 'Visa', 'Wong', '4444444444444444', '12-25', '123'),
(6, 300, '2023-06-17 21:17:51', 'Paid', 'Bruce', 'Lee', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-06-29', '2023-07-01', 'Singapore', 'Economy Class', '', 1, 'Im Poor', 'Visa', 'Bruce', '4444444444444444', '12-24', '321'),
(7, 4200, '2023-06-17 21:19:19', 'Fulfilled', 'Adeline', 'Ong', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-06-21', '2023-06-24', 'Tokyo, Japan', 'Economy Class', 'Gourmet Dining', 2, 'Hii', 'Visa', 'Adeline', '4444444444444444', '12-23', '123'),
(9, 13250, '2023-06-17 21:43:52', 'Archived', 'ivyyyyyyyyyyyyyyyyyyyy', 'Wick', 'abc@mail.com', '999', 'abcabcabcabcabca', 'abc', 'VIC', '3122', 'email', '2023-06-19', '2023-06-27', 'Tokyo, Japan', 'First Class', 'Gourmet Dining, Premium Entertainment', 5, 'yayyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy', 'Visa', 'ok', '4444444444444444', '09-50', '1234'),
(12, 5300, '2023-06-17 22:11:16', 'Pending', 'Jason', 'Tan', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-06-17', '2023-06-20', 'Tokyo, Japan', 'First Class', 'Gourmet Dining, Premium Entertainment', 2, 'Hehe', 'Visa', 'Jason', '4123456789123456', '10-23', '1234'),
(13, 2550, '2023-06-17 23:54:24', 'Pending', 'Danny', 'Heng', 'abc@mail.com', '999', '2, OMG Street', 'OMG Street', 'VIC', '3122', 'email', '2023-06-28', '2023-06-30', 'Tokyo, Japan', 'First Class', 'Premium Entertainment', 1, 'I like music', 'Visa', 'Danny', '4123456789123456', '12-23', '345'),
(14, 1500, '2023-06-18 17:35:56', 'Paid', 'Aiman', 'Zulkifli', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'email', '2023-06-21', '2023-06-24', 'Bali, Indonesia', 'Economy Class', '', 3, 'h', 'Visa', 'Aiman', '4123456789123456', '12-23', '123'),
(15, 2350, '2023-06-20 10:23:50', 'Pending', 'Jimmy', 'See', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'email', '2023-06-21', '2023-06-24', 'Tokyo, Japan', 'Business Class', 'Gourmet Dining', 1, 'Hello', 'Visa', 'Jimmy', '4123456789123456', '12-23', '123'),
(16, 6300, '2023-06-20 11:02:20', 'Pending', 'Jason', 'Tan', 'abc@mail.com', '123', '2, OMG Street', 'Klang', 'VIC', '3122', 'email', '2023-06-21', '2023-06-23', 'Tokyo, Japan', 'Economy Class', 'Gourmet Dining', 3, 'hi', 'Visa', 'Jason', '4123456789123456', '12-23', '321'),
(17, 2350, '2023-06-26 21:17:37', 'Pending', 'Jason', 'Tan', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'email', '2023-06-29', '2023-07-01', 'Tokyo, Japan', 'Business Class', 'Gourmet Dining', 1, '', 'Visa', 'OMG', '4123456789123456', '12-23', '123'),
(18, 2600, '2023-07-11 12:51:00', 'Pending', 'aa', 'aa', 'a@gmail.com', '1111111111', 'aa', 'aa', 'VIC', '3030', 'post', '2023-07-12', '2023-07-14', 'Tokyo, Japan', 'First Class', 'Gourmet Dining', 1, 'aa', 'Visa', 'aa', '4111111111111111', '02-25', '111'),
(19, 3300, '2023-08-15 23:22:57', 'Pending', 'Jason', 'Tan', 'abc@mail.com', '999', '2, OMG Street', 'Klang', 'VIC', '3122', 'post', '2023-08-16', '2023-08-19', 'Bali, Indonesia', 'First Class', 'Gourmet Dining', 3, 'hi', 'Visa', 'OMG', '4444444444444444', '12-23', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
