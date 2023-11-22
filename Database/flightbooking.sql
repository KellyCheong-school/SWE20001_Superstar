-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 21, 2023 at 12:56 PM
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
-- Database: `flightbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `cabin` varchar(50) NOT NULL,
  `features` text,
  `num_tickets` int(11) NOT NULL,
  `selected_flight_id` int(11) NOT NULL,
  `selected_departure_date` date NOT NULL,
  `selected_arrival_city` varchar(255) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking_status` varchar(255) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `cabin`, `features`, `num_tickets`, `selected_flight_id`, `selected_departure_date`, `selected_arrival_city`, `flight_id`, `member_id`, `booking_date`, `booking_status`) VALUES
(1, 'First Class', 'Flight Meal', 2, 6, '2023-11-25', 'Singapore', 6, 2, '2023-11-04 13:25:13', 'Complete'),
(2, 'Economy Class', 'Flight Meal, Baggage Protection', 1, 7, '2023-11-24', 'Tokyo, Japan', 7, 2, '2023-11-04 13:26:07', 'Complete'),
(3, 'First Class', 'Flight Meal, Baggage Protection', 1, 6, '2023-11-25', 'Singapore', 6, 3, '2023-11-04 13:27:10', 'Complete'),
(4, 'Economy Class', 'Flight Meal', 2, 7, '2023-11-24', 'Tokyo, Japan', 7, 3, '2023-11-04 13:28:21', 'Complete'),
(6, 'First Class', 'Flight Meal, Baggage Protection', 1, 7, '2023-11-24', 'Tokyo, Japan', 7, 1, '2023-11-04 13:32:29', 'Complete'),
(7, 'Business Class', '-', 3, 8, '2023-11-25', 'Bali, Indonesia', 8, 1, '2023-11-04 13:39:05', 'Pending'),
(8, 'Business Class', 'Baggage Protection', 2, 6, '2023-11-25', 'Singapore', 6, 1, '2023-11-04 14:44:40', 'Pending'),
(9, 'Business Class', 'Flight Meal', 2, 7, '2023-11-24', 'Tokyo, Japan', 7, 1, '2023-11-04 14:58:28', 'Pending'),
(10, 'First Class', 'Flight Meal', 2, 6, '2023-11-25', 'Singapore', 6, 1, '2023-11-06 03:06:36', 'Pending'),
(11, 'First Class', 'Flight Meal', 2, 6, '2023-11-25', 'Singapore', 6, 1, '2023-11-13 08:56:55', 'Pending'),
(12, 'First Class', 'Flight Meal', 4, 9, '2023-11-22', 'Singapore', 9, 1, '2023-11-13 11:07:41', 'Pending'),
(13, 'First Class', 'Flight Meal', 1, 7, '2023-11-24', 'Tokyo, Japan', 7, 1, '2023-11-13 12:05:06', 'Pending'),
(14, 'Economy Class', 'Flight Meal, Baggage Protection', 2, 6, '2023-11-25', 'Singapore', 6, 1, '2023-11-13 14:20:51', 'Pending'),
(15, 'First Class', '-', 3, 7, '2023-11-24', 'Tokyo, Japan', 7, 6, '2023-11-21 06:20:51', 'Complete');

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
(1, 'Tokyo, Japan', '64df347f4c85e.jpg', 'AeroStar offers premium flight services to Tokyo, Japan.', 2200),
(2, 'Singapore', '2_2e_64e0316b67f32.jpg', 'Singapore is a city that never fails to impress, and at AeroStar, we are committed to providing our passengers with a seamless and comfortable journey to this exciting destination.', 300),
(3, 'Bali, Indonesia', '64e034099a420.jpg', 'AeroStar provides premium flight services to Bali, Indonesia, offering a seamless and comfortable journey to this tropical paradise. With our modern aircraft, skilled pilots, and attentive crew, we ensure a safe and enjoyable flight experience for all our passengers.', 500),
(4, 'europe', '4_europe.jpg', 'yay', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `departure_datetime` datetime DEFAULT NULL,
  `arrival_datetime` datetime DEFAULT NULL,
  `departure_city` varchar(255) DEFAULT NULL,
  `arrival_city` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `departure_datetime`, `arrival_datetime`, `departure_city`, `arrival_city`, `duration`, `price`) VALUES
(6, '2023-11-25 19:17:00', '2023-11-25 21:18:00', 'Kuala Lumpur, Malaysia', 'Singapore', 121, '300.00'),
(7, '2023-11-30 09:18:00', '2023-11-30 16:18:00', 'Kuala Lumpur, Malaysia', 'Tokyo, Japan', 420, '2000.00'),
(8, '2023-11-25 16:19:00', '2023-11-25 20:19:00', 'Kuala Lumpur, Malaysia', 'Bali, Indonesia', 240, '500.00'),
(9, '2023-11-22 19:50:00', '2023-11-22 21:50:00', 'Kuala Lumpur, Malaysia', 'Singapore', 120, '300.00');

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `username`, `password`, `full_name`, `dob`, `email`, `phone`) VALUES
(2, 'admin', 'password', 'ADMIN', '2003-10-06', 'admin@mail.com', '60-126697896'),
(3, 'Ervin996', 'Ervin%9', 'Ervin Tee', '2004-06-05', 'ervin@mail.com', '60-126678960'),
(5, 'Benjiwin08', '%enj1w1n', 'Benjiwin Wong', '2000-10-10', 'benjiwin@mail.com', '60-176927880'),
(6, 'Jason96', 'J@50n', 'Jason Tan', '2000-10-20', 'jason96@mail.com', '60-162227980'),
(7, 'Kelly666', 'Ke!1y', 'Kelly Cheong', '2000-11-09', 'kelly6@mail.com', '60-198947660');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `passport_number` varchar(20) DEFAULT NULL,
  `passport_expiry` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `full_name`, `dob`, `email`, `phone`, `passport_number`, `passport_expiry`) VALUES
(1, 'jason96', 'J@50n', 'Jason Tan', '2003-10-06', 'jason379@mail.com', '60-162227980', 'A10468897', '2023-11-16'),
(2, 'Benjiwin08', '%enj1w1n', 'Benjiwin Wong', '2003-02-06', 'benjiwin@mail.com', '60-176927880', 'A10476589', '2024-12-31'),
(3, 'Kelly666', 'Ke!1y', 'Kelly Cheong', '2003-07-11', 'kelly@mail.com', '60-198947660', 'A10347764', '2024-12-31'),
(4, 'Ervin89', 'Ervin%9', 'Ervin Tee', '2000-10-20', 'ervin@mail.com', '60-123456789', 'A10339764', '2024-5-31'),
(5, 'John996', 'J0hn#!ck', 'John Wick', '2001-11-11', 'john@mail.com', '60-123456789', 'A10567889', '2024-11-30'),
(6, 'Ben', '123456', 'Benny', '2002-11-23', 'BenWong@gamil.com', '60-182221890', 'A12345678', '2024-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `passport` varchar(50) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`id`, `booking_id`, `name`, `dob`, `passport`, `expiry`) VALUES
(1, 1, 'Ervin Tee', '2000-10-20', 'A10339764', '2023-12-31'),
(2, 4, 'Jane Sim', '2003-11-01', 'A13365789', '2023-11-30'),
(5, 7, 'Ervin Tee', '2000-10-20', 'A10339764', '2023-11-30'),
(6, 7, 'Benjiwin Wong', '2003-02-06', 'A10476589', '2024-12-31'),
(7, 8, 'Ervin Tee', '2000-10-20', 'A10339764', '2024-05-31'),
(8, 9, 'Ervin Tee', '2000-10-20', 'A10339764', '2024-05-31'),
(9, 10, 'John Wick', '2001-11-11', 'A10567889', '2024-11-30'),
(10, 11, 'John Wick', '2001-11-11', 'A10567889', '2024-11-30'),
(11, 12, 'John Wick', '2001-11-11', 'A10567889', '2024-11-30'),
(12, 12, 'Ervin Tee', '2000-10-20', 'A10339764', '2024-05-31'),
(13, 12, 'Jane Sim', '2003-11-01', 'A13365789', '2023-11-30'),
(14, 14, 'Ervin Tee', '2000-10-20', 'A10339764', '2024-05-31'),
(15, 15, 'Kelly Cheong', '2000-10-09', 'A12345677', '2024-12-09'),
(16, 15, 'Jason Tan', '2001-11-09', 'A12345688', '2025-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `booking_id`, `card_type`, `card_name`, `card_number`, `expiry_date`, `cvv`, `totalPrice`) VALUES
(1, 1, 'Visa', 'Benjiwin Wong', '4136578698712323', '12-23', '669', '1640.00'),
(2, 2, 'Visa', 'Benjiwin Wong', '4136578698712323', '12-23', '669', '2070.00'),
(3, 3, 'Mastercard', 'Kelly Cheong', '5136578698712323', '12-24', '745', '870.00'),
(4, 4, 'Mastercard', 'Kelly Cheong', '5136578698712323', '12-24', '745', '4040.00'),
(6, 6, 'Visa', 'Jason Tan', '4635915304795398', '12-25', '379', '2570.00'),
(7, 7, 'Visa', 'Jason Tan', '4635915304795398', '12-25', '379', '2250.00'),
(8, 8, 'Visa', 'Jason Tan', '4635915304795398', '12-25', '379', '1150.00'),
(9, 9, 'Visa', 'Jason Tan', '4635915304795398', '12-25', '379', '4540.00'),
(10, 10, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '1640.00'),
(11, 11, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '1640.00'),
(12, 12, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '3280.00'),
(13, 13, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '2520.00'),
(14, 14, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '690.00'),
(15, 12, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '3280.00'),
(16, 14, 'American Express', 'Ervin Tee', '342062021186141', '11-24', '596', '690.00'),
(17, 15, 'Visa', 'Benny', '4123456789012345', '09-25', '123', '7500.00');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` int(10) NOT NULL,
  `promotionheader` varchar(60) DEFAULT NULL,
  `promotiondesc` text,
  `promotionimg` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`promotion_id`, `promotionheader`, `promotiondesc`, `promotionimg`) VALUES
(3, 'Raya Fixed Fares', 'Balik Kampung to Sabah & Sarawak from RM199', '3_promo2.png'),
(4, 'Pack up! It\'s go time', 'All-in one-way fare from RM35', '4_promo3.jpg'),
(7, 'FACES, a faster boarding experience', 'Get ready for a quicker and seamless travel experience.', '654eff29da8ce.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `selected_flight_id` (`selected_flight_id`),
  ADD KEY `flight_id` (`flight_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`destination_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `destination_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`selected_flight_id`) REFERENCES `flights` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`),
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
