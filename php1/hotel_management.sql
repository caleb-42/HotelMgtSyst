-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2018 at 07:17 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `frontdesk_bookings`
--

INSERT INTO `frontdesk_bookings` (`id`, `booking_ref`, `room_number`, `room_id`, `room_category`, `room_rate`, `guest_name`, `guest_id`, `no_of_nights`, `net_cost`, `guests`, `check_in_date`, `expected_checkout_date`, `expected_checkout_time`, `checked_out`, `check_out_time`) VALUES
(1, 'BK_1341', 201, 'RM_83783', 'deluxe', 35000, 'Gilean', 'LOD_84034', 2, 70000, 0, '2018-11-13 11:28:49', '2018-11-14', '12:28:49', 'NO', '0000-00-00 00:00:00'),
(2, 'BK_1341', 202, 'RM_46008', 'deluxe', 35000, 'Gilean', 'LOD_84034', 1, 35000, 0, '2018-11-13 11:28:49', '2018-11-14', '12:28:49', 'NO', '0000-00-00 00:00:00'),
(3, 'BK_27379', 101, 'RM_95000', 'standard', 25000, 'Gilean', 'LOD_84034', 1, 25000, 0, '2018-11-13 11:30:52', '2018-11-14', '12:30:52', 'NO', '0000-00-00 00:00:00'),
(4, 'BK_88854', 102, 'RM_29128', 'standard', 25000, 'Gilean', 'LOD_84034', 1, 25000, 0, '2018-11-13 11:32:54', '2018-11-14', '12:32:54', 'YES', '2018-11-13 11:35:27'),
(5, 'BK_58388', 101, 'RM_95000', 'standard', 25000, 'Jill', 'LOD_32676', 1, 25000, 0, '2018-11-13 11:45:19', '2018-11-14', '12:45:19', 'NO', '0000-00-00 00:00:00'),
(6, 'BK_84612', 303, 'RM_81686', 'deluxe', 35000, 'Jill', 'LOD_32676', 1, 35000, 0, '2018-11-13 11:46:48', '2018-11-14', '12:46:48', 'YES', '2018-11-13 11:48:57'),
(7, 'BK_84612', 102, 'RM_29128', 'standard', 25000, 'Jill', 'LOD_32676', 1, 25000, 0, '2018-11-13 11:46:48', '2018-11-14', '12:46:48', 'YES', '2018-11-13 11:48:57'),
(8, 'BK_24078', 201, 'RM_83783', 'deluxe', 35000, 'Jane', 'LOD_9588', 1, 35000, 0, '2018-11-13 11:58:32', '2018-11-14', '12:58:32', 'NO', '0000-00-00 00:00:00'),
(9, 'BK_94058', 101, 'RM_95000', 'standard', 25000, 'Jane', 'LOD_9588', 1, 25000, 0, '2018-11-13 11:59:22', '2018-11-14', '12:59:22', 'YES', '2018-11-13 12:25:11'),
(10, 'BK_3777', 102, 'RM_29128', 'standard', 25000, 'Jane', 'LOD_9588', 1, 25000, 0, '2018-11-13 12:00:06', '2018-11-14', '13:00:06', 'YES', '2018-11-13 12:13:35'),
(11, 'BK_30440', 201, 'RM_83783', 'deluxe', 35000, 'Roy', 'LOD_23029', 1, 35000, 0, '2018-11-13 12:29:20', '2018-11-14', '13:29:20', 'NO', '0000-00-00 00:00:00'),
(12, 'BK_22863', 101, 'RM_95000', 'standard', 25000, 'Roy', 'LOD_23029', 1, 25000, 0, '2018-11-13 12:30:27', '2018-11-14', '13:30:27', 'YES', '2018-11-13 12:41:02'),
(13, 'BK_14346', 202, 'RM_46008', 'deluxe', 35000, 'Roy', 'LOD_23029', 1, 35000, 0, '2018-11-13 12:30:54', '2018-11-14', '13:30:54', 'YES', '2018-11-13 12:31:24'),
(14, 'BK_62851', 202, 'RM_46008', 'deluxe', 35000, 'Osho', 'LOD_52952', 1, 35000, 0, '2018-11-13 12:42:31', '2018-11-14', '13:42:31', 'YES', '2018-11-13 12:44:41'),
(15, 'BK_23042', 101, 'RM_95000', 'standard', 25000, 'Osho', 'LOD_52952', 2, 50000, 0, '2018-11-13 12:43:20', '2018-11-15', '13:43:20', 'NO', '0000-00-00 00:00:00'),
(16, 'BK_23042', 303, 'RM_81686', 'deluxe', 35000, 'Osho', 'LOD_52952', 2, 70000, 0, '2018-11-13 12:43:20', '2018-11-15', '13:43:20', 'YES', '2018-11-13 12:44:29'),
(17, 'BK_68033', 102, 'RM_29128', 'standard', 25000, 'Osho', 'LOD_52952', 2, 50000, 0, '2018-11-13 12:43:48', '2018-11-15', '13:43:48', 'YES', '2018-11-13 12:44:17');

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
  `visit_count` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `frontdesk_guests`
--

INSERT INTO `frontdesk_guests` (`id`, `guest_id`, `guest_name`, `guest_type_gender`, `phone_number`, `contact_address`, `total_rooms_booked`, `checked_in`, `check_in_date`, `room_outstanding`, `restaurant_outstanding`, `checked_out`, `visit_count`) VALUES
(1, 'LOD_84034', 'Gilean', 'male', '', '', 1, 'NO', '2018-11-13 11:28:49', 29000, 0, 'YES', 2),
(2, 'LOD_32676', 'Jill', 'female', '', '', 0, 'NO', '2018-11-13 11:45:19', 50000, 0, 'YES', 2),
(3, 'LOD_9588', 'Jane', 'female', '', '', -1, 'YES', '2018-11-13 11:58:32', 32000, 0, 'NO', 2),
(4, 'LOD_23029', 'Roy', 'male', '', '', 1, 'YES', '2018-11-13 12:29:20', 65000, 0, 'NO', 1),
(5, 'LOD_52952', 'Osho', 'male', '', '', 1, 'YES', '2018-11-13 12:42:31', 83000, 0, 'NO', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `frontdesk_payments`
--

INSERT INTO `frontdesk_payments` (`id`, `frontdesk_txn`, `payment_index`, `txn_date`, `amount_paid`, `date_of_payment`, `amount_balance`, `net_paid`, `txn_worth`, `guest_id`, `means_of_payment`, `frontdesk_rep`) VALUES
(1, 'BK_1341', 1, '2018-11-13 12:28:49', 90000, '2018-11-13 11:28:49', 15000, 90000, 105000, 'LOD_84034', 'Cash', ''),
(2, 'BK_27379', 1, '2018-11-13 12:30:52', 5000, '2018-11-13 11:30:52', 20000, 5000, 25000, 'LOD_84034', 'Cash', ''),
(3, 'BK_88854', 1, '2018-11-13 12:32:54', 12000, '2018-11-13 11:32:54', 13000, 12000, 25000, 'LOD_84034', 'Cash', ''),
(4, 'BK_81855', 1, '2018-11-13 12:34:43', 11000, '2018-11-13 11:34:43', 14000, 11000, 25000, 'LOD_84034', 'Cash', ''),
(5, 'BK_58388', 1, '2018-11-13 12:45:20', 12000, '2018-11-13 11:45:20', 13000, 12000, 25000, 'LOD_32676', 'Cash', ''),
(6, 'BK_84612', 1, '2018-11-13 12:46:48', 23000, '2018-11-13 11:46:48', 37000, 23000, 60000, 'LOD_32676', 'Cash', ''),
(7, 'BK_24078', 1, '2018-11-13 12:58:32', 30000, '2018-11-13 11:58:32', 5000, 30000, 35000, 'LOD_9588', 'Cash', ''),
(8, 'BK_94058', 1, '2018-11-13 12:59:22', 12000, '2018-11-13 11:59:22', 13000, 12000, 25000, 'LOD_9588', 'Cash', ''),
(9, 'BK_3777', 1, '2018-11-13 13:00:06', 11000, '2018-11-13 12:00:06', 14000, 11000, 25000, 'LOD_9588', 'Cash', ''),
(10, 'BK_22863', 1, '2018-11-13 13:30:27', 20000, '2018-11-13 12:30:27', 5000, 20000, 25000, 'LOD_23029', 'Cash', ''),
(11, 'BK_14346', 1, '2018-11-13 13:30:54', 10000, '2018-11-13 12:30:54', 25000, 10000, 35000, 'LOD_23029', 'Cash', ''),
(12, 'BK_62851', 1, '2018-11-13 13:42:31', 12000, '2018-11-13 12:42:31', 23000, 12000, 35000, 'LOD_52952', 'Cash', ''),
(13, 'BK_23042', 1, '2018-11-13 13:43:20', 90000, '2018-11-13 12:43:20', 30000, 90000, 120000, 'LOD_52952', 'Cash', ''),
(14, 'BK_68033', 1, '2018-11-13 13:43:48', 20000, '2018-11-13 12:43:48', 30000, 20000, 50000, 'LOD_52952', 'Cash', ''),
(15, 'BK_23042', 2, '2018-11-13 13:43:20', 30000, '2018-11-13 12:49:06', 0, 120000, 120000, 'LOD_52952', 'Cash', 'admin');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `frontdesk_reservations`
--

INSERT INTO `frontdesk_reservations` (`id`, `reservation_ref`, `guest_name`, `guest_id`, `phone_number`, `email`, `reserved_date`, `no_of_nights`, `inquiry_date`, `room_id`, `room_number`, `room_rate`, `room_total_cost`, `room_category`, `booked`, `booking_ref`, `cancelled`, `deposit_confirmed`, `frontdesk_rep`) VALUES
(1, 'RESV_9876', 'tego', '', '788', 'tegus@gmail.com', '2018-11-16', 7, '2018-11-16 05:35:32', 'RM_46008', 202, 35000, 245000, 'deluxe', 'NO', '', 'NO', 'NO', 'admin'),
(2, 'RESV_32461', 'tego', '', '788', 'tegus@gmail.com', '2018-11-16', 7, '2018-11-16 05:39:29', 'RM_46008', 202, 35000, 245000, 'deluxe', 'NO', '', 'NO', 'NO', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservation_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservation_txn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_ref` varchar(100) NOT NULL,
  `total_rooms_reserved` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `frontdesk_rooms`
--

INSERT INTO `frontdesk_rooms` (`id`, `room_number`, `room_id`, `room_rate`, `room_category`, `features`, `current_guest_id`, `guests`, `booked`, `booking_ref`, `booked_on`, `booking_expires`, `reserved`, `reserved_by`, `reservation_ref`, `reservation_date`, `reserved_nights`, `days_till_reservation_date`, `reservation_expiry`) VALUES
(1, 101, 'RM_95000', 25000, 'standard', '', 'LOD_52952', 0, 'YES', 'BK_23042', '2018-11-13 12:43:20', '2018-11-15 00:43:20', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(2, 102, 'RM_29128', 25000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(3, 103, 'RM_68927', 25000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(4, 201, 'RM_83783', 35000, 'deluxe', '', 'LOD_23029', 0, 'YES', 'BK_30440', '2018-11-13 12:29:20', '2018-11-14 00:29:20', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(5, 202, 'RM_46008', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(6, 303, 'RM_81686', 35000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00');

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
  `means_of_payment` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `frontdesk_txn`
--

INSERT INTO `frontdesk_txn` (`id`, `booking_ref`, `guest_id`, `total_rooms_booked`, `total_cost`, `deposited`, `balance`, `means_of_payment`, `payment_status`, `frontdesk_rep`) VALUES
(1, 'BK_1341', '', 2, 105000, 90000, 15000, 'Cash', 'UNBALANCED', 'admin'),
(2, 'BK_27379', '', 1, 25000, 5000, 20000, 'Cash', 'UNBALANCED', 'admin'),
(3, 'BK_88854', '', 1, 25000, 12000, 13000, 'Cash', 'UNBALANCED', 'admin'),
(4, 'BK_81855', '', 1, 25000, 11000, 14000, 'Cash', 'UNBALANCED', 'admin'),
(5, 'BK_58388', '', 1, 25000, 12000, 13000, 'Cash', 'UNBALANCED', 'admin'),
(6, 'BK_84612', '', 2, 60000, 23000, 37000, 'Cash', 'UNBALANCED', 'admin'),
(7, 'BK_24078', '', 1, 35000, 30000, 5000, 'Cash', 'UNBALANCED', 'admin'),
(8, 'BK_94058', '', 1, 25000, 12000, 13000, 'Cash', 'UNBALANCED', 'admin'),
(9, 'BK_3777', '', 1, 25000, 11000, 14000, 'Cash', 'UNBALANCED', 'admin'),
(10, 'BK_22863', '', 1, 25000, 20000, 5000, 'Cash', 'UNBALANCED', 'admin'),
(11, 'BK_14346', '', 1, 35000, 10000, 25000, 'Cash', 'UNBALANCED', 'admin'),
(12, 'BK_62851', '', 1, 35000, 12000, 23000, 'Cash', 'UNBALANCED', 'admin'),
(13, 'BK_23042', '', 2, 120000, 120000, 0, 'Cash', 'PAID FULL', 'admin'),
(14, 'BK_68033', '', 1, 50000, 20000, 30000, 'Cash', 'UNBALANCED', 'admin');

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
(1, 'admin', 'Admin', 'admin', '$2y$11$de3461b5cdc4cd7ee9aa2u5H5puD0VxMLabU2gUzHOXHEpy4raJ52');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
