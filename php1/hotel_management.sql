-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2018 at 01:06 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `frontdesk_bookings`
--

INSERT INTO `frontdesk_bookings` (`id`, `booking_ref`, `room_number`, `room_id`, `room_category`, `room_rate`, `guest_name`, `guest_id`, `no_of_nights`, `net_cost`, `guests`, `check_in_date`, `expected_checkout_date`, `expected_checkout_time`, `checked_out`, `check_out_time`) VALUES
(1, 'BK_45683', 202, 'RM_64917', 'deluxe', 33000, 'Ewere', 'LOD_4157', 4, 0, 3, '2018-10-29 13:11:47', '2018-11-02', '14:11:47', 'NO', '0000-00-00 00:00:00'),
(2, 'BK_45683', 102, 'RM_66480', 'standard', 15000, 'Ewere', 'LOD_4157', 4, 0, 3, '2018-10-29 13:11:47', '2018-11-02', '14:11:47', 'NO', '0000-00-00 00:00:00'),
(3, 'BK_45683', 103, 'RM_71638', 'standard', 15000, 'Ewere', 'LOD_4157', 4, 0, 3, '2018-10-29 13:11:47', '2018-11-02', '14:11:47', 'NO', '0000-00-00 00:00:00'),
(4, 'BK_72921', 202, 'RM_64917', 'deluxe', 33000, 'Ewere', 'LOD_74919', 4, 132000, 3, '2018-10-29 13:22:41', '2018-11-02', '14:22:41', 'NO', '0000-00-00 00:00:00'),
(5, 'BK_72921', 102, 'RM_66480', 'standard', 15000, 'Ewere', 'LOD_74919', 4, 60000, 3, '2018-10-29 13:22:41', '2018-11-02', '14:22:41', 'NO', '0000-00-00 00:00:00'),
(6, 'BK_72921', 103, 'RM_71638', 'standard', 15000, 'Ewere', 'LOD_74919', 4, 60000, 3, '2018-10-29 13:22:41', '2018-11-02', '14:22:41', 'NO', '0000-00-00 00:00:00'),
(7, 'BK_61513', 202, 'RM_64917', 'deluxe', 33000, 'Ewere', 'LOD_1439', 4, 132000, 3, '2018-10-29 14:25:12', '2018-11-02', '15:25:12', 'NO', '0000-00-00 00:00:00'),
(8, 'BK_61513', 102, 'RM_66480', 'standard', 15000, 'Ewere', 'LOD_1439', 4, 60000, 3, '2018-10-29 14:25:12', '2018-11-02', '15:25:12', 'NO', '0000-00-00 00:00:00'),
(9, 'BK_61513', 103, 'RM_71638', 'standard', 15000, 'Ewere', 'LOD_1439', 4, 60000, 3, '2018-10-29 14:25:12', '2018-11-02', '15:25:12', 'NO', '0000-00-00 00:00:00'),
(10, 'BK_17122', 202, 'RM_64917', 'deluxe', 33000, 'Ewere', 'LOD_85838', 4, 132000, 3, '2018-10-29 14:29:04', '2018-11-02', '15:29:04', 'NO', '0000-00-00 00:00:00'),
(11, 'BK_17122', 102, 'RM_66480', 'standard', 15000, 'Ewere', 'LOD_85838', 4, 60000, 3, '2018-10-29 14:29:04', '2018-11-02', '15:29:04', 'NO', '0000-00-00 00:00:00'),
(12, 'BK_17122', 103, 'RM_71638', 'standard', 15000, 'Ewere', 'LOD_85838', 4, 60000, 3, '2018-10-29 14:29:04', '2018-11-02', '15:29:04', 'NO', '0000-00-00 00:00:00'),
(13, 'BK_99636', 202, 'RM_64917', 'deluxe', 33000, 'Ewere', 'LOD_39049', 4, 132000, 3, '2018-10-29 14:32:22', '2018-11-02', '15:32:22', 'NO', '0000-00-00 00:00:00'),
(14, 'BK_99636', 102, 'RM_66480', 'standard', 15000, 'Ewere', 'LOD_39049', 4, 60000, 3, '2018-10-29 14:32:22', '2018-11-02', '15:32:22', 'NO', '0000-00-00 00:00:00'),
(15, 'BK_99636', 103, 'RM_71638', 'standard', 15000, 'Ewere', 'LOD_39049', 4, 60000, 3, '2018-10-29 14:32:22', '2018-11-02', '15:32:22', 'NO', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `frontdesk_guests`
--

INSERT INTO `frontdesk_guests` (`id`, `guest_id`, `guest_name`, `guest_type_gender`, `phone_number`, `contact_address`, `total_rooms_booked`, `checked_in`, `check_in_date`, `room_outstanding`, `restaurant_outstanding`, `checked_out`, `visit_count`) VALUES
(1, 'LOD_7079', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:19:32', 4000, 0, 'NO', 1),
(2, 'LOD_38431', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:21:02', 4000, 0, 'NO', 1),
(3, 'LOD_22872', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:21:23', 4000, 0, 'NO', 1),
(4, 'LOD_45572', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:22:49', 4000, 0, 'NO', 1),
(5, 'LOD_49593', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:24:07', 4000, 0, 'NO', 1),
(6, 'LOD_72942', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:24:26', 4000, 0, 'NO', 1),
(7, 'LOD_778', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:25:52', 4000, 0, 'NO', 1),
(8, 'LOD_31817', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:26:14', 4000, 0, 'NO', 1),
(9, 'LOD_81566', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:27:01', 4000, 0, 'NO', 1),
(10, 'LOD_91717', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:28:12', 4000, 0, 'NO', 1),
(11, 'LOD_13034', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:28:57', 4000, 0, 'NO', 1),
(12, 'LOD_27909', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:30:20', 4000, 0, 'NO', 1),
(13, 'LOD_78011', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:30:40', 4000, 0, 'NO', 1),
(14, 'LOD_88818', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:31:03', 4000, 0, 'NO', 1),
(15, 'LOD_68875', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:36:33', 4000, 0, 'NO', 1),
(16, 'LOD_12269', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:39:04', 4000, 0, 'NO', 1),
(17, 'LOD_36074', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:39:37', 4000, 0, 'NO', 1),
(18, 'LOD_64841', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:40:01', 4000, 0, 'NO', 1),
(19, 'LOD_49585', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:41:31', 4000, 0, 'NO', 1),
(20, 'LOD_86533', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:42:43', 4000, 0, 'NO', 1),
(21, 'LOD_44378', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:43:25', 4000, 0, 'NO', 1),
(22, 'LOD_53514', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 14:47:09', 4000, 0, 'NO', 1),
(23, 'LOD_53520', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:16:09', 4000, 0, 'NO', 1),
(24, 'LOD_47464', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:17:37', 4000, 0, 'NO', 1),
(25, 'LOD_24584', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:18:13', 4000, 0, 'NO', 1),
(26, 'LOD_59098', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:18:35', 4000, 0, 'NO', 1),
(27, 'LOD_10891', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:24:24', 4000, 0, 'NO', 1),
(28, 'LOD_25216', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:25:24', 4000, 0, 'NO', 1),
(29, 'LOD_22313', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:26:17', 4000, 0, 'NO', 1),
(30, 'LOD_33748', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:30:24', 4000, 0, 'NO', 1),
(31, 'LOD_41139', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:31:12', 4000, 0, 'NO', 1),
(32, 'LOD_93609', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:32:13', 4000, 0, 'NO', 1),
(33, 'LOD_7935', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:32:45', 4000, 0, 'NO', 1),
(34, 'LOD_22147', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:34:06', 4000, 0, 'NO', 1),
(35, 'LOD_97157', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:34:47', 4000, 0, 'NO', 1),
(36, 'LOD_61284', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:36:38', 4000, 0, 'NO', 1),
(37, 'LOD_18129', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:37:27', 4000, 0, 'NO', 1),
(38, 'LOD_55168', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:39:01', 4000, 0, 'NO', 1),
(39, 'LOD_20626', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:43:23', 4000, 0, 'NO', 1),
(40, 'LOD_62754', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-25 15:43:35', 4000, 0, 'NO', 1),
(41, 'LOD_5464', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-26 10:14:09', 4000, 0, 'NO', 1),
(42, 'LOD_6808', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-26 14:44:01', 4000, 0, 'NO', 1),
(43, 'LOD_32915', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:36:47', 4000, 0, 'NO', 1),
(44, 'LOD_68655', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:37:33', 4000, 0, 'NO', 1),
(45, 'LOD_73613', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:38:48', 4000, 0, 'NO', 1),
(46, 'LOD_41612', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:42:38', 4000, 0, 'NO', 1),
(47, 'LOD_85035', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:56:03', 4000, 0, 'NO', 1),
(48, 'LOD_27647', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 12:58:05', 4000, 0, 'NO', 1),
(49, 'LOD_13433', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 13:06:02', 4000, 0, 'NO', 1),
(50, 'LOD_31219', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 13:08:36', 4000, 0, 'NO', 1),
(51, 'LOD_4157', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 13:11:47', 4000, 0, 'NO', 1),
(52, 'LOD_74919', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 13:22:41', 4000, 0, 'NO', 1),
(53, 'LOD_1439', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 14:25:12', 4000, 0, 'NO', 1),
(54, 'LOD_5989', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 14:28:29', 4000, 0, 'NO', 1),
(55, 'LOD_85838', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 14:29:04', 4000, 0, 'NO', 1),
(56, 'LOD_39049', 'Ewere', 'male', '08023456789', 'webplay nigeria ltd', 3, 'YES', '2018-10-29 14:32:22', 4000, 0, 'NO', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `frontdesk_payments`
--

INSERT INTO `frontdesk_payments` (`id`, `frontdesk_txn`, `payment_index`, `txn_date`, `amount_paid`, `date_of_payment`, `amount_balance`, `net_paid`, `txn_worth`, `guest_id`, `means_of_payment`, `frontdesk_rep`) VALUES
(1, 'BK_9989', 1, '2018-10-26 11:14:09', 54000, '2018-10-26 10:14:09', 9000, 54000, 63000, 'LOD_5464', 'POS', ''),
(2, 'BK_9989', 2, '2018-10-26 11:14:09', 2000, '2018-10-26 14:55:52', 7000, 56000, 63000, 'LOD_5464', 'CASH', 'Joan'),
(3, 'BK_9989', 3, '2018-10-26 11:14:09', 2000, '2018-10-26 14:57:16', 5000, 58000, 63000, 'LOD_5464', 'CASH', 'Joan'),
(4, 'BK_9989', 4, '2018-10-26 11:14:09', 2000, '2018-10-26 14:58:36', 3000, 60000, 63000, 'LOD_5464', 'CASH', 'Joan'),
(5, 'BK_9989', 5, '2018-10-26 11:14:09', 2000, '2018-10-26 15:00:19', 1000, 62000, 63000, 'LOD_5464', 'CASH', 'Joan'),
(6, 'BK_9989', 6, '2018-10-26 11:14:09', 1000, '2018-10-26 15:06:19', 0, 63000, 63000, 'LOD_5464', 'CASH', 'Joan'),
(7, 'BK_36427', 1, '2018-10-29 13:38:49', 200000, '2018-10-29 12:38:49', 52000, 200000, 252000, 'LOD_73613', 'POS', ''),
(8, 'BK_40627', 1, '2018-10-29 13:42:38', 200000, '2018-10-29 12:42:38', 52000, 200000, 252000, 'LOD_41612', 'POS', ''),
(9, 'BK_80034', 1, '2018-10-29 13:56:03', 200000, '2018-10-29 12:56:03', 52000, 200000, 252000, 'LOD_85035', 'POS', ''),
(10, 'BK_27091', 1, '2018-10-29 13:58:05', 200000, '2018-10-29 12:58:05', 52000, 200000, 252000, 'LOD_27647', 'POS', ''),
(11, 'BK_32006', 1, '2018-10-29 14:06:02', 200000, '2018-10-29 13:06:02', 52000, 200000, 252000, 'LOD_13433', 'POS', ''),
(12, 'BK_44563', 1, '2018-10-29 14:08:36', 200000, '2018-10-29 13:08:36', 52000, 200000, 252000, 'LOD_31219', 'POS', ''),
(13, 'BK_45683', 1, '2018-10-29 14:11:47', 200000, '2018-10-29 13:11:47', 52000, 200000, 252000, 'LOD_4157', 'POS', ''),
(14, 'BK_72921', 1, '2018-10-29 14:22:42', 200000, '2018-10-29 13:22:42', 52000, 200000, 252000, 'LOD_74919', 'POS', ''),
(15, 'BK_61513', 1, '2018-10-29 15:25:12', 200000, '2018-10-29 14:25:12', 52000, 200000, 252000, 'LOD_1439', 'POS', ''),
(16, 'BK_17122', 1, '2018-10-29 15:29:04', 200000, '2018-10-29 14:29:04', 52000, 200000, 252000, 'LOD_85838', 'POS', ''),
(17, 'BK_99636', 1, '2018-10-29 15:32:22', 200000, '2018-10-29 14:32:22', 52000, 200000, 252000, 'LOD_39049', 'POS', '');

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservations`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reservation_ref` varchar(100) NOT NULL,
  `guest_name` varchar(200) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(200) NOT NULL DEFAULT '',
  `reserved_date` date NOT NULL,
  `no_of_nights` int(11) NOT NULL,
  `inquiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `room_id` varchar(100) NOT NULL,
  `room_rate` int(11) NOT NULL,
  `room_total_cost` int(11) NOT NULL,
  `room_category` varchar(200) NOT NULL,
  `booked` varchar(20) NOT NULL DEFAULT 'NO',
  `booking_ref` varchar(100) NOT NULL DEFAULT '',
  `cancelled` varchar(100) NOT NULL DEFAULT 'NO',
  `deposit_confirmed` varchar(100) NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `frontdesk_reservations`
--

INSERT INTO `frontdesk_reservations` (`id`, `reservation_ref`, `guest_name`, `phone_number`, `email`, `reserved_date`, `no_of_nights`, `inquiry_date`, `room_id`, `room_rate`, `room_total_cost`, `room_category`, `booked`, `booking_ref`, `cancelled`, `deposit_confirmed`) VALUES
(1, 'akja', 'john', '', '', '2018-10-30', 4, '2018-10-28 16:55:16', 'RM_25367', 0, 0, 'deluxe', 'NO', '', 'NO', 'no'),
(2, 'asdnmes', 'mark', '', '', '2018-11-15', 6, '2018-10-28 16:55:16', 'RM_25367', 0, 0, 'deluxe', 'NO', '', 'NO', 'no'),
(3, 'RESV_28039', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-20', 4, '2018-10-30 16:08:06', 'RM_64917', 33000, 132000, 'deluxe', 'NO', '', 'NO', 'NO'),
(4, 'RESV_6723', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-20', 4, '2018-10-30 16:09:13', 'RM_64917', 33000, 132000, 'deluxe', 'NO', '', 'NO', 'NO'),
(5, 'RESV_6723', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-23', 4, '2018-10-30 16:09:13', 'RM_66480', 15000, 60000, 'standard', 'NO', '', 'NO', 'NO'),
(6, 'RESV_6723', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-22', 4, '2018-10-30 16:09:13', 'RM_71638', 15000, 60000, 'standard', 'NO', '', 'NO', 'NO'),
(7, 'RESV_98424', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-20', 2, '2018-10-30 16:10:22', 'RM_64917', 33000, 66000, 'deluxe', 'NO', '', 'NO', 'NO'),
(8, 'RESV_98424', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-23', 3, '2018-10-30 16:10:22', 'RM_66480', 15000, 45000, 'standard', 'NO', '', 'NO', 'NO'),
(9, 'RESV_98424', 'Ewere', '08023456789', 'tegogs@gmail.com', '2018-11-22', 4, '2018-10-30 16:10:22', 'RM_71638', 15000, 60000, 'standard', 'NO', '', 'NO', 'NO');

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
  `means_of_payment` varchar(100) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `frontdesk_rooms`
--

INSERT INTO `frontdesk_rooms` (`id`, `room_number`, `room_id`, `room_rate`, `room_category`, `features`, `current_guest_id`, `guests`, `booked`, `booking_ref`, `booked_on`, `booking_expires`, `reserved`, `reserved_by`, `reservation_ref`, `reservation_date`, `reserved_nights`, `days_till_reservation_date`, `reservation_expiry`) VALUES
(1, 100, 'RM_25367', 33000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(2, 101, 'RM_85965', 15000, 'standard', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(3, 102, 'RM_66480', 15000, 'standard', '', 'LOD_39049', 3, 'NO', 'BK_99636', '2018-10-29 14:32:22', '2018-11-02 02:32:22', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(4, 103, 'RM_71638', 15000, 'standard', '', 'LOD_39049', 3, 'NO', 'BK_99636', '2018-10-29 14:32:22', '2018-11-02 02:32:22', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(5, 200, 'RM_51704', 33000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(6, 201, 'RM_60146', 33000, 'deluxe', '', '', 0, 'NO', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00'),
(7, 202, 'RM_64917', 33000, 'deluxe', '', 'LOD_39049', 3, 'NO', 'BK_99636', '2018-10-29 14:32:22', '2018-11-02 02:32:22', 'NO', '', '', '0000-00-00', 0, NULL, '0000-00-00');

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
  `total_rooms_booked` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `frontdesk_txn`
--

INSERT INTO `frontdesk_txn` (`id`, `booking_ref`, `total_rooms_booked`, `total_cost`, `deposited`, `balance`, `means_of_payment`, `payment_status`, `frontdesk_rep`) VALUES
(1, 'BK_9989', 3, 63000, 63000, 0, 'POS', 'PAID FULL', 'Ada'),
(2, 'BK_36427', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(3, 'BK_40627', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(4, 'BK_80034', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(5, 'BK_27091', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(6, 'BK_32006', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(7, 'BK_44563', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(8, 'BK_45683', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(9, 'BK_72921', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(10, 'BK_61513', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(11, 'BK_17122', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada'),
(12, 'BK_99636', 3, 252000, 200000, 52000, 'POS', 'UNBALANCED', 'Ada');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `restaurant_customers`
--

INSERT INTO `restaurant_customers` (`id`, `customer_id`, `full_name`, `gender`, `phone_number`, `contact_address`, `outstanding_balance`) VALUES
(1, 'LOD_001', 'Tegogo', '', '', '', 0),
(5, 'RES_58046', 'Ewere', 'male', '08023456789', '20 adesuwa rd. benin', -2060),
(6, 'RES_99116', 'Ryan', 'male', '09098407743', '25 Adesuwa Rd. Benin', 0),
(7, 'RES_18294', 'Ryan', 'male', '08023456789', '20 adesuwa rd. benin', 0),
(8, 'RES_44598', 'Harvey Reynolds', 'male', '08023456789', '20 adesuwa rd. benin', 0),
(9, 'RES_61893', 'john', 'male', '90980980', 'sapele', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `restaurant_discount`
--

INSERT INTO `restaurant_discount` (`id`, `discount_name`, `lower_limit`, `upper_limit`, `discount_item`, `discount_value`) VALUES
(1, '800+', 800, 1499, 'all', 5),
(2, '1500+', 1500, 0, 'all', 9),
(5, 'sprite+15', 2000, 4500, 'sprite', 15),
(10, 'sprite+45', 4500, 8000, 'sprite', 50),
(14, 'sprite+70', 8000, 0, 'sprite', 55),
(15, 'erg', 0, 400, 'all', 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `restaurant_items`
--

INSERT INTO `restaurant_items` (`id`, `item`, `type`, `category`, `description`, `current_price`, `discount_rate`, `discount_criteria`, `discount_available`, `shelf_item`, `current_stock`, `last_stock_update`, `reg_date`) VALUES
(1, 'heineken', 'beer', 'alcohol', 'can (33cl)', 300, 0, 0, '', 'yes', 26, '0000-00-00 00:00:00', '2018-07-25 12:56:22'),
(2, 'fanta', 'soft drink', 'drinks', 'plastic (33cl)', 200, 0, 0, '', 'yes', 115, '0000-00-00 00:00:00', '2018-07-25 12:58:25'),
(3, 'sharwama', 'chicken', 'snacks', 'medium', 1200, 0, 0, '', 'no', NULL, '0000-00-00 00:00:00', '2018-07-28 12:34:06'),
(4, 'hot-dog', 'beef', 'snacks', 'medium', 1000, 0, 0, '', 'no', NULL, '0000-00-00 00:00:00', '2018-07-28 12:37:18'),
(5, 'chin chin', 'yum yum', 'snacks', 'packed', 50, 0, 0, '', 'yes', 80, '2018-10-12 13:43:12', '2018-10-12 13:43:12'),
(7, 'pizza', 'beef, chicken', 'big-snacks', 'medium', 5000, 0, 0, '', 'no', NULL, NULL, '2018-10-12 14:15:40'),
(8, 'hizza', 'mutton', 'big-snack', 'small', 5000, 0, 0, '', 'no', NULL, NULL, '2018-10-12 14:17:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `restaurant_payments`
--

INSERT INTO `restaurant_payments` (`id`, `restaurant_txn`, `txn_date`, `amount_paid`, `date_of_payment`, `amount_balance`, `net_paid`, `txn_worth`, `customer_id`, `means_of_payment`) VALUES
(1, '00003', '2018-08-21 16:25:01', 5000, '2018-08-21 15:25:01', 2200, 0, 7200, 'LOD_001', ''),
(2, '00003', '2018-08-21 16:28:05', 5000, '2018-08-21 15:28:05', 2200, 0, 7200, 'LOD_001', ''),
(3, '00004', '2018-08-21 16:28:34', 5000, '2018-08-21 15:28:34', 2200, 0, 7200, 'LOD_001', ''),
(4, '00005', '2018-08-22 12:43:52', 5000, '2018-08-22 11:43:52', 2200, 0, 7200, 'LOD_001', ''),
(5, '00006', '2018-08-22 12:44:16', 5000, '2018-08-22 11:44:16', 2200, 0, 7200, 'LOD_001', ''),
(6, '00007', '2018-08-22 12:47:23', 5000, '2018-08-22 11:47:23', 2200, 0, 7200, 'LOD_001', ''),
(7, '00008', '2018-08-22 12:48:20', 5000, '2018-08-22 11:48:20', 2200, 0, 7200, 'LOD_001', ''),
(8, '00009', '2018-08-22 12:48:53', 5000, '2018-08-22 11:48:53', 2200, 0, 7200, 'LOD_001', ''),
(9, '00010', '2018-10-05 16:26:03', 5000, '2018-10-05 15:26:03', 5000, 2200, 7200, 'LOD_001', 'CASH'),
(10, '00011', '2018-10-05 16:29:01', 5000, '2018-10-05 15:29:01', 5000, 2200, 7200, 'LOD_001', 'CASH'),
(11, '00012', '2018-10-10 14:21:32', 1500, '2018-10-10 13:21:32', 1500, 320, 1820, 'RES_58046', 'CASH'),
(12, '00013', '2018-10-10 14:31:56', 1500, '2018-10-10 13:31:56', 1500, 320, 1820, 'RES_58046', 'CASH'),
(13, '00012', '2018-10-10 14:21:32', 300, '2018-10-11 00:48:18', 1200, 620, 1820, 'RES_58046', 'CASH'),
(14, '00012', '2018-10-10 14:21:32', 300, '2018-10-11 00:55:39', 900, 920, 1820, 'RES_58046', 'CASH'),
(15, '00014', '2018-10-12 10:48:21', 230, '2018-10-12 09:48:21', 2500, 230, 2730, '', 'Cash'),
(16, '00015', '2018-10-12 10:50:08', 638, '2018-10-12 09:50:08', 1000, 638, 1638, 'RES_58046', 'Cash'),
(17, '00012', '2018-10-10 14:21:32', 50, '2018-10-12 15:10:38', 850, 970, 1820, 'RES_58046', 'Cash'),
(18, '00015', '2018-10-12 10:50:08', 1000, '2018-10-12 15:11:20', 0, 1638, 1638, 'RES_58046', 'Cash'),
(19, '00013', '2018-10-10 14:31:56', 320, '2018-10-12 15:11:56', 1180, 640, 1820, 'RES_58046', 'Cash'),
(20, '00013', '2018-10-10 14:31:56', 1180, '2018-10-12 15:12:21', 0, 1820, 1820, 'RES_58046', 'Cash'),
(21, '00012', '2018-10-10 14:21:32', 850, '2018-10-12 15:12:37', 0, 1820, 1820, 'RES_58046', 'Cash');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

--
-- Dumping data for table `restaurant_sales`
--

INSERT INTO `restaurant_sales` (`id`, `sales_ref`, `item`, `type`, `quantity`, `unit_cost`, `net_cost`, `discount_rate`, `discounted_net_cost`, `discount_amount`, `sold_by`) VALUES
(34, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(35, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(36, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(37, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(38, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(39, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(40, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(41, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(42, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(43, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(44, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(45, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(46, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(47, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(48, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(49, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(50, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(51, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(52, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(53, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(54, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(55, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(56, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(57, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(58, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(59, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(60, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(61, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(62, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(63, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(64, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(65, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(66, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(67, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(68, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(69, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(70, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(71, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(72, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(73, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(74, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(75, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(76, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(77, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(78, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(79, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(80, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(81, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(82, '00003', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(83, '00003', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(84, '00003', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(85, '00004', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(86, '00004', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(87, '00004', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(88, '00005', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(89, '00005', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(90, '00005', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(91, '00006', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(92, '00006', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(93, '00006', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(94, '00007', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(95, '00007', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(96, '00007', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(97, '00008', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(98, '00008', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(99, '00008', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(100, '00009', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(101, '00009', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(102, '00009', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(103, '00010', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(104, '00010', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(105, '00010', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(106, '00011', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'webplay'),
(107, '00011', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'webplay'),
(108, '00011', 'hot-dog', 'beef', 6, 1000, 6000, 0, 6000, 0, 'webplay'),
(109, '00013', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'teevee'),
(110, '00013', 'fanta', 'soft drink', 4, 200, 800, 0, 800, 0, 'teevee'),
(111, '00014', 'heineken', 'beer', 4, 300, 1200, 0, 1200, 0, 'teevee'),
(112, '00014', 'fanta', 'soft drink', 9, 200, 1800, 0, 1800, 0, 'teevee'),
(113, '00015', 'heineken', 'beer', 6, 300, 1800, 0, 1800, 0, 'teevee');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `restaurant_sessions`
--

INSERT INTO `restaurant_sessions` (`id`, `user_name`, `role`, `logged_on_time`, `logged_off_time`, `logged_on_state`, `duration`) VALUES
(1, 'teevee', 'admin', '2018-10-08 11:58:39', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(2, 'teevee', 'admin', '2018-10-08 11:59:32', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(3, 'teevee', 'admin', '2018-10-08 12:01:07', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(4, 'teevee', 'admin', '2018-10-08 12:08:16', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(5, 'teevee', 'admin', '2018-10-08 12:09:57', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(6, 'teevee', 'admin', '2018-10-08 12:11:35', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(7, 'teevee', 'admin', '2018-10-08 12:13:32', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(8, 'teevee', 'admin', '2018-10-08 12:14:33', '2018-10-08 12:14:42', 'LOGGED OFF', '00:00:00'),
(9, 'teevee', 'admin', '2018-10-08 12:15:41', '2018-10-09 11:09:51', 'LOGGED OFF', '00:00:00'),
(10, 'teevee', 'admin', '2018-10-10 13:20:15', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(11, 'teevee', 'admin', '2018-10-21 13:03:02', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(12, 'teevee', 'admin', '2018-10-21 13:04:49', '0000-00-00 00:00:00', 'TERMINATED', '00:00:00'),
(13, 'teevee', 'admin', '2018-10-21 13:07:59', '0000-00-00 00:00:00', 'LOGGED IN', '00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `restaurant_stock`
--

INSERT INTO `restaurant_stock` (`id`, `txn_id`, `txn_ref`, `item`, `item_id`, `category`, `prev_stock`, `quantity`, `route`, `new_stock`, `txn_date`) VALUES
(1, 1, 'fanta_2_00001', 'fanta', 2, 'drinks', 100, 20, 'added', 120, '2018-08-23 13:12:53'),
(2, 1, 'heineken_1_00001', 'heineken', 1, 'drinks', 32, 20, 'added', 52, '2018-08-23 13:13:54'),
(3, 2, 'fanta_2_00002', 'fanta', 2, 'drinks', 120, 20, 'added', 140, '2018-08-23 13:14:49');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `restaurant_txn`
--

INSERT INTO `restaurant_txn` (`id`, `txn_ref`, `total_items`, `total_cost`, `transaction_discount`, `discounted_total_cost`, `deposited`, `balance`, `txn_time`, `customer_ref`, `pay_method`, `payment_status`, `sales_rep`) VALUES
(1, '00001', 2, 2000, 0, 2000, 1500, 500, '2018-07-30 14:53:50', 'cus_001', 'cash', '', 'ugo'),
(2, '00002', 3, 3500, 0, 3500, 3500, 0, '2018-07-30 14:56:00', 'cus_002', 'cash', '', 'wigho'),
(3, '00003', 3, 8000, 10, 7200, 5000, 2200, '2018-08-21 15:28:05', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(4, '00004', 3, 8000, 10, 7200, 5000, 2200, '2018-08-21 15:28:34', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(5, '00005', 3, 8000, 10, 7200, 5000, 2200, '2018-08-22 11:43:52', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(6, '00006', 3, 8000, 10, 7200, 5000, 2200, '2018-08-22 11:44:16', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(7, '00007', 3, 8000, 10, 7200, 5000, 2200, '2018-08-22 11:47:23', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(8, '00008', 3, 8000, 10, 7200, 5000, 2200, '2018-08-22 11:48:20', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(9, '00009', 3, 8000, 10, 7200, 5000, 2200, '2018-08-22 11:48:54', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(10, '00010', 3, 8000, 10, 7200, 5000, 2200, '2018-10-05 15:26:03', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(11, '00011', 3, 8000, 10, 7200, 5000, 2200, '2018-10-05 15:29:01', 'LOD_001', 'CASH', 'UNBALANCED', 'webplay'),
(12, '00012', 2, 2000, 9, 1820, 1820, 0, '2018-10-10 13:21:33', 'RES_58046', 'Cash', 'PAID FULL', 'teevee'),
(13, '00013', 2, 2000, 9, 1820, 1820, 0, '2018-10-10 13:31:56', 'RES_58046', 'Cash', 'PAID FULL', 'teevee'),
(14, '00014', 2, 3000, 9, 2730, 230, 2500, '2018-10-12 09:48:21', '', 'Cash', 'UNBALANCED', 'teevee'),
(15, '00015', 1, 1800, 9, 1638, 1638, 0, '2018-10-12 09:50:08', 'RES_58046', 'Cash', 'PAID FULL', 'teevee');

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
(1, 'teevee', 'tego', 'admin', '$2y$11$b3cb67270240259fe9594OLsKAIJzQtPPONf6T0Mi8NADtr5HpTNe');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
