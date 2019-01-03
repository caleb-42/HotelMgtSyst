-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2019 at 06:24 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

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
  `expense_ref` varchar(100) NOT NULL,
  `expense_description` varchar(400) NOT NULL,
  `expense_cost` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_expense_payments`
--

CREATE TABLE IF NOT EXISTS `account_expense_payments` (
  `id` int(11) NOT NULL,
  `expense_ref` varchar(100) NOT NULL,
  `payment_index` int(11) NOT NULL DEFAULT '1',
  `txn_date` date NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `date_of_payment` date NOT NULL,
  `balance` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `txn_worth` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL
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
-- Table structure for table `account_sessions`
--

CREATE TABLE IF NOT EXISTS `account_sessions` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `logged_on_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_off_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logged_on_state` varchar(50) NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `account_users`
--

CREATE TABLE IF NOT EXISTS `account_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_users`
--

INSERT INTO `account_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$08a5e2f2a4f3cf5d52989uezmO8uyWJpL5ifsvJHnQpC9026fnHB.');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE IF NOT EXISTS `admin_settings` (
  `id` int(11) NOT NULL,
  `shop_settings` varchar(300) NOT NULL,
  `property_value` varchar(400) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
(7, 'restaurant_bottom_msg', 'come back to enjoy our first class meals'),
(8, 'restaurant_top_msg', 'For catering service please call');

-- --------------------------------------------------------

--
-- Table structure for table `admin_staff`
--

CREATE TABLE IF NOT EXISTS `admin_staff` (
  `id` int(11) NOT NULL,
  `staff_id` varchar(100) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `department` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `contact_address` varchar(350) NOT NULL DEFAULT '',
  `role` varchar(200) NOT NULL,
  `current_salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$08a5e2f2a4f3cf5d52989uezmO8uyWJpL5ifsvJHnQpC9026fnHB.');

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_bookings`
--

CREATE TABLE IF NOT EXISTS `frontdesk_bookings` (
  `id` int(11) NOT NULL,
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
  `check_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_guests`
--

CREATE TABLE IF NOT EXISTS `frontdesk_guests` (
  `id` int(11) NOT NULL,
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
  `visit_count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_other_transactions`
--

CREATE TABLE IF NOT EXISTS `frontdesk_other_transactions` (
  `id` int(11) NOT NULL,
  `customer_ref` varchar(100) NOT NULL,
  `section` varchar(150) NOT NULL,
  `transaction_ref` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_payments`
--

CREATE TABLE IF NOT EXISTS `frontdesk_payments` (
  `id` int(11) NOT NULL,
  `frontdesk_txn` varchar(100) NOT NULL,
  `payment_index` int(11) NOT NULL DEFAULT '1',
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` int(11) NOT NULL,
  `date_of_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `amount_balance` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `txn_worth` int(11) NOT NULL,
  `guest_id` varchar(100) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservations`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservations` (
  `id` int(11) NOT NULL,
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
  `frontdesk_rep` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_reservation_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_reservation_txn` (
  `id` int(11) NOT NULL,
  `reservation_ref` varchar(100) NOT NULL,
  `total_rooms_reserved` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL DEFAULT '0',
  `balance` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL DEFAULT '',
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_rooms`
--

CREATE TABLE IF NOT EXISTS `frontdesk_rooms` (
  `id` int(11) NOT NULL,
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
  `reservation_expiry` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_room_categories`
--

CREATE TABLE IF NOT EXISTS `frontdesk_room_categories` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `rate` int(11) NOT NULL,
  `sales_rep` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_sessions`
--

CREATE TABLE IF NOT EXISTS `frontdesk_sessions` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `logged_on_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_off_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logged_on_state` varchar(50) NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frontdesk_sessions`
--

INSERT INTO `frontdesk_sessions` (`id`, `user_name`, `role`, `logged_on_time`, `logged_off_time`, `logged_on_state`, `duration`) VALUES
(1, 'admin', 'admin', '2019-01-02 04:36:36', '0000-00-00 00:00:00', 'LOGGED IN', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_txn`
--

CREATE TABLE IF NOT EXISTS `frontdesk_txn` (
  `id` int(11) NOT NULL,
  `booking_ref` varchar(100) NOT NULL,
  `guest_id` varchar(100) NOT NULL DEFAULT '',
  `total_rooms_booked` int(11) NOT NULL,
  `total_cost` int(11) NOT NULL,
  `deposited` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL DEFAULT '',
  `payment_status` varchar(100) NOT NULL,
  `frontdesk_rep` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frontdesk_users`
--

CREATE TABLE IF NOT EXISTS `frontdesk_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frontdesk_users`
--

INSERT INTO `frontdesk_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$08a5e2f2a4f3cf5d52989uezmO8uyWJpL5ifsvJHnQpC9026fnHB.');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_customers`
--

CREATE TABLE IF NOT EXISTS `restaurant_customers` (
  `id` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL DEFAULT '',
  `contact_address` varchar(200) NOT NULL DEFAULT '',
  `outstanding_balance` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_discount`
--

CREATE TABLE IF NOT EXISTS `restaurant_discount` (
  `id` int(11) NOT NULL,
  `discount_name` varchar(100) NOT NULL,
  `lower_limit` int(11) NOT NULL,
  `upper_limit` int(11) NOT NULL,
  `discount_item` varchar(200) NOT NULL DEFAULT 'all',
  `discount_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_items`
--

CREATE TABLE IF NOT EXISTS `restaurant_items` (
  `id` int(11) NOT NULL,
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
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_payments`
--

CREATE TABLE IF NOT EXISTS `restaurant_payments` (
  `id` int(11) NOT NULL,
  `restaurant_txn` varchar(100) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount_paid` int(11) NOT NULL,
  `date_of_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `amount_balance` int(11) NOT NULL,
  `net_paid` int(11) NOT NULL,
  `txn_worth` int(11) NOT NULL,
  `customer_id` varchar(100) NOT NULL,
  `means_of_payment` varchar(100) NOT NULL,
  `sales_rep` varchar(300) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_sales`
--

CREATE TABLE IF NOT EXISTS `restaurant_sales` (
  `id` int(11) NOT NULL,
  `sales_ref` varchar(200) NOT NULL,
  `item` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `net_cost` int(11) NOT NULL,
  `discount_rate` int(11) NOT NULL,
  `discounted_net_cost` int(11) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `sold_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_sessions`
--

CREATE TABLE IF NOT EXISTS `restaurant_sessions` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `logged_on_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logged_off_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logged_on_state` varchar(50) NOT NULL,
  `duration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_staff`
--

CREATE TABLE IF NOT EXISTS `restaurant_staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `position` varchar(150) NOT NULL,
  `contact_address` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_stock`
--

CREATE TABLE IF NOT EXISTS `restaurant_stock` (
  `id` int(11) NOT NULL,
  `txn_id` int(11) NOT NULL,
  `txn_ref` varchar(100) NOT NULL,
  `item` varchar(200) NOT NULL,
  `item_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `prev_stock` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  `route` varchar(50) NOT NULL DEFAULT '0',
  `new_stock` int(11) NOT NULL DEFAULT '0',
  `txn_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_txn`
--

CREATE TABLE IF NOT EXISTS `restaurant_txn` (
  `id` int(11) NOT NULL,
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
  `sales_rep` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_users`
--

CREATE TABLE IF NOT EXISTS `restaurant_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` char(60) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurant_users`
--

INSERT INTO `restaurant_users` (`id`, `user_name`, `user`, `role`, `password`) VALUES
(1, 'admin', 'Admin', 'admin', '$2y$11$08a5e2f2a4f3cf5d52989uezmO8uyWJpL5ifsvJHnQpC9026fnHB.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_expense_payments`
--
ALTER TABLE `account_expense_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_sessions`
--
ALTER TABLE `account_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_users`
--
ALTER TABLE `account_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_staff`
--
ALTER TABLE `admin_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_bookings`
--
ALTER TABLE `frontdesk_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_guests`
--
ALTER TABLE `frontdesk_guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_other_transactions`
--
ALTER TABLE `frontdesk_other_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_payments`
--
ALTER TABLE `frontdesk_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_reservations`
--
ALTER TABLE `frontdesk_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_reservation_txn`
--
ALTER TABLE `frontdesk_reservation_txn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_rooms`
--
ALTER TABLE `frontdesk_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_room_categories`
--
ALTER TABLE `frontdesk_room_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_sessions`
--
ALTER TABLE `frontdesk_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_txn`
--
ALTER TABLE `frontdesk_txn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontdesk_users`
--
ALTER TABLE `frontdesk_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_customers`
--
ALTER TABLE `restaurant_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_discount`
--
ALTER TABLE `restaurant_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_items`
--
ALTER TABLE `restaurant_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_payments`
--
ALTER TABLE `restaurant_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_sales`
--
ALTER TABLE `restaurant_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_sessions`
--
ALTER TABLE `restaurant_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_staff`
--
ALTER TABLE `restaurant_staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_stock`
--
ALTER TABLE `restaurant_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_txn`
--
ALTER TABLE `restaurant_txn`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_users`
--
ALTER TABLE `restaurant_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_expense_payments`
--
ALTER TABLE `account_expense_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `account_sessions`
--
ALTER TABLE `account_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `account_users`
--
ALTER TABLE `account_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `admin_staff`
--
ALTER TABLE `admin_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `frontdesk_bookings`
--
ALTER TABLE `frontdesk_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_guests`
--
ALTER TABLE `frontdesk_guests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_other_transactions`
--
ALTER TABLE `frontdesk_other_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_payments`
--
ALTER TABLE `frontdesk_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_reservations`
--
ALTER TABLE `frontdesk_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_reservation_txn`
--
ALTER TABLE `frontdesk_reservation_txn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_rooms`
--
ALTER TABLE `frontdesk_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_room_categories`
--
ALTER TABLE `frontdesk_room_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_sessions`
--
ALTER TABLE `frontdesk_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `frontdesk_txn`
--
ALTER TABLE `frontdesk_txn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frontdesk_users`
--
ALTER TABLE `frontdesk_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `restaurant_customers`
--
ALTER TABLE `restaurant_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_discount`
--
ALTER TABLE `restaurant_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_items`
--
ALTER TABLE `restaurant_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_payments`
--
ALTER TABLE `restaurant_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_sales`
--
ALTER TABLE `restaurant_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_sessions`
--
ALTER TABLE `restaurant_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_staff`
--
ALTER TABLE `restaurant_staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_stock`
--
ALTER TABLE `restaurant_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_txn`
--
ALTER TABLE `restaurant_txn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `restaurant_users`
--
ALTER TABLE `restaurant_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
