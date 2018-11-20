-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2018 at 12:00 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_rooms`
--

CREATE TABLE IF NOT EXISTS `frontdesk_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_number` int(11) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `room_rate` int(11) NOT NULL,
  `room_category` varchar(100) NOT NULL,
  `features` varchar(400) NOT NULL DEFAULT '',
  `current_guest_id` varchar(200) NOT NULL DEFAULT '',
  `guests` int(11) NOT NULL DEFAULT '0',
  `booked` varchar(50) NOT NULL DEFAULT 'NO',
  `booking_ref` varchar(100) NOT NULL DEFAULT '',
  `booked_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `booking_expires` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reserved` varchar(50) NOT NULL DEFAULT 'NO',
  `reserved_by` varchar(200) NOT NULL DEFAULT '',
  `reservation_ref` varchar(100) NOT NULL DEFAULT '',
  `reservation_date` date NOT NULL DEFAULT '0000-00-00',
  `reserved_nights` int(11) NOT NULL DEFAULT '0',
  `days_till_reservation_date` int(11) DEFAULT NULL,
  `reservation_expiry` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `frontdesk_rooms`
--

INSERT INTO `frontdesk_rooms` (`id`, `room_number`, `room_id`, `room_rate`, `room_category`, `features`, `current_guest_id`, `guests`, `booked`, `booking_ref`, `booked_on`, `booking_expires`, `reserved`, `reserved_by`, `reservation_ref`, `reservation_date`, `reserved_nights`, `days_till_reservation_date`, `reservation_expiry`) VALUES
(1, 101, 'RM_20325', 20000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(2, 102, 'RM_40891', 20000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(3, 103, 'RM_76950', 20000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(4, 104, 'RM_12224', 20000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(5, 105, 'RM_28549', 20000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(6, 201, 'RM_36388', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(7, 202, 'RM_50984', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(8, 203, 'RM_13631', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(9, 204, 'RM_78303', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(10, 205, 'RM_79806', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
