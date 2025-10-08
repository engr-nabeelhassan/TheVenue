-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 12:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2019-10-21 13:37:09', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Database: `the_venue`
--
CREATE DATABASE IF NOT EXISTS `the_venue` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `the_venue`;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_date` date NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `total_guests` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `event_start_at` datetime NOT NULL,
  `event_end_at` datetime NOT NULL,
  `event_status` enum('In Progress','Completed','Cancelled','Postponed') NOT NULL DEFAULT 'In Progress',
  `payment_status` varchar(255) NOT NULL,
  `payment_option` enum('advance','full') DEFAULT NULL,
  `advance_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `items_subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `items_discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `invoice_net_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `invoice_total_paid` decimal(12,2) NOT NULL DEFAULT 0.00,
  `invoice_closing_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount_in_words` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `invoice_date`, `customer_id`, `customer_name`, `event_type`, `total_guests`, `event_start_at`, `event_end_at`, `event_status`, `payment_status`, `payment_option`, `advance_amount`, `items_subtotal`, `items_discount_amount`, `invoice_net_amount`, `invoice_total_paid`, `invoice_closing_amount`, `amount_in_words`, `remarks`, `created_at`, `updated_at`) VALUES
(1, '2025-10-01', 14, 'Fatima Noor', 'Wedding', 400, '2025-10-07 19:00:00', '2025-10-07 23:30:00', 'In Progress', 'Cheque', 'advance', 215000.00, 450000.00, 50000.00, 400000.00, 215000.00, 185000.00, 'One Lakh Eighty Five Thousand Rupees Only', 'Pending Payment After Event', '2025-10-07 01:09:02', '2025-10-07 07:37:48'),
(3, '2025-10-02', 13, 'Adnan Latif', 'Wedding', 500, '2025-10-08 20:00:00', '2025-10-08 23:59:00', 'In Progress', 'Cash', 'advance', 35000.00, 600000.00, 60000.00, 540000.00, 35000.00, 505000.00, 'Five Lakh Five Thousand Rupees Only', NULL, '2025-10-07 02:00:45', '2025-10-07 07:36:19'),
(6, '2025-10-03', 12, 'Maria Khan', 'Wedding', 650, '2025-10-09 20:00:00', '2025-10-09 23:59:00', 'Completed', 'Online Transaction', 'advance', 300000.00, 720000.00, 31400.00, 688600.00, 300000.00, 388600.00, 'Three Lakh Eighty Eight Thousand Six Hundred Rupees Only', 'Stage Requirements', '2025-10-07 09:13:50', '2025-10-07 09:13:50'),
(7, '2025-10-04', 11, 'Imran Sheikh', 'Wedding', 1000, '2025-10-11 12:00:00', '2025-10-11 16:00:00', 'Postponed', 'Cheque', 'advance', 490000.00, 1250000.00, 0.00, 1250000.00, 490000.00, 760000.00, 'Seven Lakh Sixty Thousand Rupees Only', 'Date Pending, Not Confirm.', '2025-10-07 09:19:58', '2025-10-08 04:51:29'),
(8, '2025-10-06', 10, 'Ayesha Siddiqui', 'Corporate', 0, '2025-10-12 18:00:00', '2025-10-12 23:59:00', 'Cancelled', 'Cash', 'full', 0.00, 450000.00, 0.00, 450000.00, 450000.00, 0.00, 'Zero Rupees Only', 'Not Confirmed.', '2025-10-07 10:01:04', '2025-10-08 04:28:50'),
(9, '2025-10-07', 9, 'Faisal Qureshi', 'Birthday', 200, '2025-10-13 14:30:00', '2025-10-13 18:59:00', 'Completed', 'Cash', 'advance', 65000.00, 180000.00, 0.00, 180000.00, 65000.00, 115000.00, 'One Lakh Fifteen Thousand Rupees Only', 'Pending Payment Check Rs: 115,000.', '2025-10-07 10:07:32', '2025-10-07 10:07:32'),
(10, '2025-10-07', 7, 'Usman Tariq', 'Other', 150, '2025-10-17 15:00:00', '2025-10-17 18:59:00', 'Postponed', 'Cash', 'advance', 130000.00, 230000.00, 0.00, 230000.00, 130000.00, 100000.00, 'One Lakh Rupees Only', 'Payement Success, Stage Lights Added Also.', '2025-10-07 10:12:40', '2025-10-07 10:12:40'),
(11, '2025-10-07', 8, 'Zainab Rehman', 'Birthday', 300, '2025-10-31 14:15:00', '2025-10-31 18:59:00', 'In Progress', 'Cheque', 'advance', 400000.00, 580000.00, 10000.00, 570000.00, 400000.00, 170000.00, 'One Lakh Seventy Thousand Rupees Only', 'Pending Payement Event Day.', '2025-10-07 10:19:03', '2025-10-07 10:19:03'),
(12, '2025-09-22', 5, 'Bilal Ahmed', 'Wedding', 500, '2025-10-22 14:30:00', '2025-10-22 18:00:00', 'Cancelled', 'Cheque', 'full', 0.00, 300000.00, 0.00, 300000.00, 300000.00, 0.00, 'Zero Rupees Only', 'Full Payment Done, Confirm Program', '2025-10-07 10:22:35', '2025-10-07 10:22:35'),
(13, '2025-10-08', 4, 'Sara Khan', 'Wedding', 850, '2025-10-27 19:00:00', '2025-10-27 22:30:00', 'In Progress', 'Cash', 'advance', 430000.00, 640000.00, 0.00, 640000.00, 430000.00, 210000.00, 'Two Lakh Ten Thousand Rupees Only', 'Pending Payment After Event.', '2025-10-08 04:40:42', '2025-10-08 04:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `booking_items`
--

CREATE TABLE `booking_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `sr_no` int(10) UNSIGNED NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_type` enum('percent','lump') NOT NULL,
  `discount_value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `net_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_items`
--

INSERT INTO `booking_items` (`id`, `booking_id`, `sr_no`, `item_description`, `quantity`, `rate`, `discount_type`, `discount_value`, `net_amount`, `created_at`, `updated_at`) VALUES
(26, 3, 1, 'Package Full Stage', 1.00, 600000.00, 'percent', 10.00, 540000.00, '2025-10-07 07:36:19', '2025-10-07 07:36:19'),
(27, 1, 1, 'Package Hall Full', 1.00, 450000.00, 'lump', 50000.00, 400000.00, '2025-10-07 07:37:48', '2025-10-07 07:37:48'),
(30, 6, 1, 'Stage Booking & Drinks', 1.00, 70000.00, 'percent', 2.00, 68600.00, '2025-10-07 09:13:50', '2025-10-07 09:13:50'),
(31, 6, 2, 'Rent', 1.00, 650000.00, 'lump', 30000.00, 620000.00, '2025-10-07 09:13:50', '2025-10-07 09:13:50'),
(35, 9, 1, 'Package Deal', 1.00, 180000.00, 'percent', 0.00, 180000.00, '2025-10-07 10:07:32', '2025-10-07 10:07:32'),
(36, 10, 1, 'Deal Package AZ', 1.00, 230000.00, 'percent', 0.00, 230000.00, '2025-10-07 10:12:40', '2025-10-07 10:12:40'),
(37, 11, 1, 'Rent', 1.00, 400000.00, 'lump', 10000.00, 390000.00, '2025-10-07 10:19:03', '2025-10-07 10:19:03'),
(38, 11, 2, 'Stage & Lights', 1.00, 50000.00, 'percent', 0.00, 50000.00, '2025-10-07 10:19:03', '2025-10-07 10:19:03'),
(39, 11, 3, 'Soft Drinks', 1.00, 110000.00, 'percent', 0.00, 110000.00, '2025-10-07 10:19:03', '2025-10-07 10:19:03'),
(40, 11, 4, 'SMD Screens', 1.00, 20000.00, 'percent', 0.00, 20000.00, '2025-10-07 10:19:03', '2025-10-07 10:19:03'),
(41, 12, 1, 'Deals Some Items', 1.00, 300000.00, 'percent', 0.00, 300000.00, '2025-10-07 10:22:35', '2025-10-07 10:22:35'),
(43, 8, 1, 'Venue Rent', 1.00, 450000.00, 'percent', 0.00, 450000.00, '2025-10-08 04:28:50', '2025-10-08 04:28:50'),
(47, 13, 1, 'Package + Smd', 1.00, 640000.00, 'percent', 0.00, 640000.00, '2025-10-08 04:41:41', '2025-10-08 04:41:41'),
(49, 7, 1, 'Package Full Event', 1.00, 1250000.00, 'percent', 0.00, 1250000.00, '2025-10-08 04:51:29', '2025-10-08 04:51:29');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `cnic` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `cnic`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(3, 'Ahmed Raza', '42101-1234567-1', '0301-1234567', 'Gulshan-e-Iqbal, Karachi', '2025-10-07 00:53:20', '2025-10-07 00:53:20'),
(4, 'Sara Khan', '42201-2345678-2', '0333-2345678', 'Clifton Block 5, Karachi', '2025-10-07 00:56:59', '2025-10-07 00:56:59'),
(5, 'Bilal Ahmed', '42301-3456789-3', '0312-3456789', 'North Nazimabad Block H, Karachi', '2025-10-07 00:57:24', '2025-10-07 00:57:24'),
(6, 'Hina Ali', '42102-4567890-4', '0345-4567890', 'PECHS Block 2, Karachi', '2025-10-07 00:57:51', '2025-10-07 00:57:51'),
(7, 'Usman Tariq', '42203-5678901-5', '0300-5678901', 'Gulistan-e-Johar Block 15, Karachi', '2025-10-07 00:58:16', '2025-10-07 01:02:12'),
(8, 'Zainab Rehman', '42104-6789012-6', '0321-6789012', 'DHA Phase 6, Karachi', '2025-10-07 00:58:39', '2025-10-07 00:58:39'),
(9, 'Faisal Qureshi', '42302-7890123-7', '0311-7890123', 'Malir Cantt, Karachi', '2025-10-07 00:59:01', '2025-10-07 00:59:01'),
(10, 'Ayesha Siddiqui', '42105-8901234-8', '0332-8901234', 'Bahadurabad, Karachi', '2025-10-07 00:59:26', '2025-10-07 00:59:26'),
(11, 'Imran Sheikh', '42204-9012345-9', '0346-9012345', 'Saddar, Karachi', '2025-10-07 00:59:47', '2025-10-07 00:59:47'),
(12, 'Maria Khan', '42303-0123456-0', '0315-0123456', 'Korangi No. 5, Karachi', '2025-10-07 01:00:09', '2025-10-07 01:00:09'),
(13, 'Adnan Latif', '42106-2345678-9', '0302-2345678', 'Nazimabad No. 3, Karachi', '2025-10-07 01:00:31', '2025-10-07 01:00:31'),
(14, 'Fatima Noor', '42205-3456789-1', '0323-3456789', 'North Karachi Sector 11-B, Karachi', '2025-10-07 01:01:13', '2025-10-07 01:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_27_000000_add_event_status_to_bookings_table', 1),
(5, '2025_01_27_000001_create_payments_table', 1),
(6, '2025_09_25_000000_create_customers_table', 1),
(7, '2025_09_25_062948_add_username_unique_and_role_to_users_table', 1),
(8, '2025_09_26_000000_create_bookings_table', 1),
(9, '2025_09_26_000001_create_booking_items_table', 1),
(10, '2025_09_26_000002_add_foreign_keys_after_tables_exist', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `receipt_date` date NOT NULL,
  `payment_method` enum('Debit','Credit') NOT NULL,
  `payment_status` enum('Cash','Cheque','Online Transaction') NOT NULL,
  `previous_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `add_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remaining_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `customer_id`, `customer_name`, `contact`, `receipt_date`, `payment_method`, `payment_status`, `previous_balance`, `add_amount`, `remaining_balance`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 11, 8, 'Zainab Rehman', '0321-6789012', '2025-10-07', 'Credit', 'Online Transaction', 170000.00, 60000.00, 110000.00, NULL, '2025-10-07 10:32:16', '2025-10-07 10:32:16'),
(2, 7, 11, 'Imran Sheikh', '0346-9012345', '2025-10-01', 'Credit', 'Cheque', 760000.00, 410000.00, 350000.00, 'Check Date : 11/03/2025', '2025-10-07 10:36:48', '2025-10-07 10:36:48'),
(3, 9, 9, 'Faisal Qureshi', '0311-7890123', '2025-10-02', 'Debit', 'Online Transaction', 115000.00, 5000.00, 120000.00, 'Additional Amount Soft Drinks Add, 5000/=', '2025-10-07 10:41:37', '2025-10-07 10:41:53'),
(4, 10, 7, 'Usman Tariq', '0300-5678901', '2025-10-04', 'Credit', 'Cash', 100000.00, 100000.00, 0.00, 'Clear Event.....', '2025-10-07 10:43:23', '2025-10-07 10:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hbHEW6glB6eXX8f5mXxiSKF6Usn8nKXMMbu51xak', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQThObEdtOU5EN0h0UUdGaFpJT0M4TVhjTEZUQ2E2U0F2dW44TEhCTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1759919835);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@thevenue.com', NULL, '$2y$12$LaGnqAHf/LGYwc9TGOYulO/0/XZnO0kSrmMSBu2mLRvtV.Jt.oO4K', 'admin', NULL, '2025-10-07 00:23:59', '2025-10-07 00:29:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_items_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_cnic_unique` (`cnic`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_index` (`booking_id`),
  ADD KEY `payments_customer_id_index` (`customer_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `booking_items`
--
ALTER TABLE `booking_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `booking_items`
--
ALTER TABLE `booking_items`
  ADD CONSTRAINT `booking_items_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
