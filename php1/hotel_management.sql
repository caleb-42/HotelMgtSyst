-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2018 at 03:28 PM
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
-- Table structure for table `account_expenses`
--

CREATE TABLE IF NOT EXISTS `account_expenses` (
  `id` int(11) NOT NULL,
  `expense` varchar(200) NOT NULL,
  `expense_description` varchar(400) NOT NULL,
  `expense_cost` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_salaries`
--

CREATE TABLE IF NOT EXISTS `account_salaries` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `salary_due` int(11) NOT NULL,
  `month` varchar(100) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_salary_payments`
--

CREATE TABLE IF NOT EXISTS `account_salary_payments` (
  `id` int(11) NOT NULL,
  `month` varchar(100) NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_staff`
--

CREATE TABLE IF NOT EXISTS `admin_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(100) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `department` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `contact_address` varchar(350) NOT NULL DEFAULT '',
  `role` varchar(200) NOT NULL,
  `current_salary` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_bookings`
--

CREATE TABLE IF NOT EXISTS `frontdesk_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_ref` varchar(200) NOT NULL,
  `reservation_ref` varchar(100) NOT NULL DEFAULT '',
  `room_number` int(11) NOT NULL,
  `room_id` varchar(200) NOT NULL,
  `room_category` varchar(200) NOT NULL,
  `room_rate` int(11) NOT NULL,
  `guest_name` varchar(200) NOT NULL,
  `guest_id` varchar(200) NOT NULL,
  `no_of_nights` int(11) NOT NULL,
  `net_cost` int(11) NOT NULL,
  `guests` int(11) NOT NULL DEFAULT '1',
  `check_in_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expected_checkout_date` date NOT NULL,
  `expected_checkout_time` time NOT NULL,
  `checked_out` varchar(30) NOT NULL DEFAULT 'NO',
  `check_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_guests`
--

CREATE TABLE IF NOT EXISTS `frontdesk_guests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guest_id` varchar(300) NOT NULL,
  `guest_name` varchar(100) NOT NULL,
  `guest_type_gender` varchar(200) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `contact_address` varchar(300) NOT NULL DEFAULT '',
  `total_rooms_booked` int(11) NOT NULL,
  `checked_in` varchar(11) NOT NULL DEFAULT 'YES',
  `check_in_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room_outstanding` int(11) NOT NULL,
  `restaurant_outstanding` int(11) NOT NULL DEFAULT '0',
  `checked_out` varchar(50) NOT NULL DEFAULT 'NO',
  `visit_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_other_transactions`
--

CREATE TABLE IF NOT EXISTS `frontdesk_other_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_ref` varchar(100) NOT NULL,
  `section` varchar(150) NOT NULL,
  `transaction_ref` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_payments`
--

CREATE TABLE IF NOT EXISTS `frontdesk_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frontdesk_txn` varchar(100) NOT NULL,
  `payment_index` int(11) NOT NULL DEFAULT '1',
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` int(11) NOT NULL,
  `date_of_payment` timestamp NOT NULL,
  `amount_balance` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `txn_worth` int(11) NOT NULL,
  `guest_id` varchar(100) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservations`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_ref` varchar(100) NOT NULL,
  `guest_name` varchar(200) NOT NULL,
  `guest_id` varchar(100) NOT NULL DEFAULT '',
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL DEFAULT '',
  `reserved_date` date NOT NULL,
  `no_of_nights` int(11) NOT NULL,
  `inquiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room_id` varchar(100) NOT NULL,
  `room_number` int(11) NOT NULL,
  `room_rate` int(11) NOT NULL,
  `room_total_cost` int(11) NOT NULL,
  `room_category` varchar(200) NOT NULL,
  `booked` varchar(20) NOT NULL DEFAULT 'NO',
  `booking_ref` varchar(100) NOT NULL DEFAULT '',
  `cancelled` varchar(100) NOT NULL DEFAULT 'NO',
  `deposit_confirmed` varchar(100) NOT NULL DEFAULT 'NO',
  `frontdesk_rep` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservation_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservation_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_ref` varchar(100) NOT NULL,
  `total_rooms_reserved` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL DEFAULT '',
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_sessions`
--

CREATE TABLE IF NOT EXISTS `frontdesk_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `logged_on_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_off_time` timestamp NOT NULL,
  `logged_on_state` varchar(50) NOT NULL,
  `duration` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_users`
--

CREATE TABLE IF NOT EXISTS `frontdesk_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `frontdesk_users`
--

INSERT INTO `frontdesk_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$7853161f6499ecca3308bOlIEPtYYesbxRdjayzLU/nc34uXHrWyi');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_customers`
--

CREATE TABLE IF NOT EXISTS `restaurant_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `contact_address` varchar(200) NOT NULL DEFAULT '',
  `outstanding_balance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_discount`
--

CREATE TABLE IF NOT EXISTS `restaurant_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_name` varchar(100) NOT NULL,
  `lower_limit` int(11) NOT NULL,
  `upper_limit` int(11) NOT NULL,
  `discount_item` varchar(200) NOT NULL DEFAULT 'all',
  `discount_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_items`
--

CREATE TABLE IF NOT EXISTS `restaurant_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(200) NOT NULL,
  `type` varchar(150) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(150) NOT NULL,
  `current_price` int(11) NOT NULL,
  `discount_rate` int(11) NOT NULL,
  `discount_criteria` int(11) NOT NULL,
  `discount_available` varchar(20) NOT NULL,
  `shelf_item` varchar(50) NOT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `last_stock_update` timestamp NULL DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_payments`
--

CREATE TABLE IF NOT EXISTS `restaurant_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurant_txn` varchar(100) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` int(11) NOT NULL,
  `date_of_payment` timestamp NOT NULL,
  `amount_balance` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `txn_worth` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_sales`
--

CREATE TABLE IF NOT EXISTS `restaurant_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_ref` varchar(200) NOT NULL,
  `item` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `net_cost` int(11) NOT NULL,
  `discount_rate` int(11) NOT NULL,
  `discounted_net_cost` int(11) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `sold_by` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_sessions`
--

CREATE TABLE IF NOT EXISTS `restaurant_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `logged_on_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_off_time` timestamp NOT NULL,
  `logged_on_state` varchar(50) NOT NULL,
  `duration` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_staff`
--

CREATE TABLE IF NOT EXISTS `restaurant_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `position` varchar(150) NOT NULL,
  `contact_address` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_stock`
--

CREATE TABLE IF NOT EXISTS `restaurant_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` int(11) NOT NULL,
  `txn_ref` varchar(100) NOT NULL,
  `item` varchar(200) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `prev_stock` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `route` varchar(50) NOT NULL DEFAULT '0',
  `new_stock` int(11) NOT NULL DEFAULT '0',
  `txn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_txn`
--

CREATE TABLE IF NOT EXISTS `restaurant_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_ref` varchar(100) NOT NULL,
  `total_items` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `transaction_discount` int(11) NOT NULL,
  `discounted_total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `txn_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_ref` varchar(100) NOT NULL,
  `pay_method` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `sales_rep` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_users`
--

CREATE TABLE IF NOT EXISTS `restaurant_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `restaurant_users`
--

INSERT INTO `restaurant_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$08a5e2f2a4f3cf5d52989uezmO8uyWJpL5ifsvJHnQpC9026fnHB.');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
