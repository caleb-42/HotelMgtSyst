-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2018 at 04:24 AM
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
-- Table structure for table `admin_settings`
--

CREATE TABLE IF NOT EXISTS `admin_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_settings` varchar(300) NOT NULL,
  `property_value` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `shop_settings`, `property_value`) VALUES
(1, 'shop_name', 'Webplay Nigeria Ltd'),
(2, 'shop_address', '52 Adesuwa rd, G.R.A benin city'),
(3, 'shop_contact', '09091953375'),
(4, 'shop_email', ''),
(5, 'frontdesk_bottom_msg', 'Hope you enjoyed your stay, please come by again'),
(6, 'frontdesk_top_msg', 'For bookings and reservations please call'),
(7, 'restaurant_bottom_msg', 'Hope you enjoyed our first class meals'),
(8, 'restaurant_top_msg', 'For catering service please call');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
