-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2019 at 12:54 AM
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
-- Table structure for table `frontdesk_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(150) NOT NULL DEFAULT 'BOOKING',
  `booking_ref` varchar(100) NOT NULL,
  `guest_id` varchar(100) NOT NULL DEFAULT '',
  `total_rooms_booked` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL DEFAULT '',
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
