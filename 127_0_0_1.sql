-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2025 at 01:25 PM
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
(6, '2025-10-01', 9, 'Ahtsham', 'Wedding', 500, '2025-09-30 22:00:00', '2025-10-02 13:00:00', 'In Progress', 'Cash', 'advance', 4000.00, 415000.00, 3000.00, 412000.00, 4000.00, 408000.00, NULL, NULL, '2025-10-01 02:28:51', '2025-10-03 00:05:57'),
(7, '2025-10-01', 8, 'Jameel Shaikh', 'Birthday', 200, '2025-10-10 05:00:00', '2025-10-12 13:00:00', 'In Progress', 'Cash', 'advance', 500.00, 20000.00, 0.00, 20000.00, 500.00, 19500.00, NULL, NULL, '2025-10-01 02:36:16', '2025-10-01 02:36:16'),
(8, '2025-10-01', 12, 'Muneeb', 'Corporate', 200, '2025-10-05 05:00:00', '2025-10-05 07:00:00', 'Cancelled', 'Cash', 'advance', 50000.00, 500000.00, 0.00, 500000.00, 50000.00, 450000.00, 'Five Lac Only.', 'Pending Payment In 450,000 In After Event Cheque', '2025-10-01 04:42:05', '2025-10-01 04:42:05'),
(9, '2025-10-01', 5, 'Faisal Baksh', 'Birthday', 50, '2025-10-01 05:00:00', '2025-10-01 13:00:00', 'Postponed', 'Cash', 'full', 0.00, 50000.00, 0.00, 50000.00, 50000.00, 0.00, NULL, NULL, '2025-10-01 04:46:58', '2025-10-01 04:46:58'),
(10, '2025-10-01', 4, 'kasim', 'Corporate', 100, '2025-10-01 05:00:00', '2025-10-01 13:00:00', 'In Progress', 'Cash', 'full', 0.00, 100000.00, 0.00, 100000.00, 100000.00, 0.00, NULL, NULL, '2025-10-01 04:57:08', '2025-10-01 04:57:08'),
(11, '2025-10-01', 4, 'kasim', 'Corporate', 100, '2025-10-01 05:00:00', '2025-10-01 13:00:00', 'In Progress', 'Cash', 'advance', 50000.00, 500000.00, 0.00, 500000.00, 50000.00, 450000.00, NULL, NULL, '2025-10-01 04:58:36', '2025-10-01 04:58:36'),
(12, '2025-10-01', 11, 'Arif Hussain', 'Wedding', 600, '2025-10-08 15:00:00', '2025-10-08 18:59:00', 'In Progress', 'Online Transaction', 'advance', 365000.00, 700000.00, 35000.00, 665000.00, 365000.00, 300000.00, 'Three Lakh Rupees Only', 'Pending Payment After Event.', '2025-10-01 06:22:12', '2025-10-01 06:22:12'),
(13, '2025-10-03', 12, 'Muneeb', 'Birthday', 500, '2025-10-03 05:00:00', '2025-10-03 13:00:00', 'Completed', 'Cash', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Zero Rupees Only', NULL, '2025-10-03 00:09:29', '2025-10-03 00:09:29'),
(14, '2025-10-03', 12, 'Muneeb', 'Wedding', 0, '2025-10-03 05:00:00', '2025-10-03 13:00:00', 'In Progress', 'Cash', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Zero Rupees Only', NULL, '2025-10-03 00:09:45', '2025-10-03 00:09:45'),
(15, '2025-10-03', 10, 'Tariq Hussain', 'Wedding', 5000, '2025-10-03 05:00:00', '2025-10-03 13:00:00', 'In Progress', 'Cash', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Zero Rupees Only', NULL, '2025-10-03 00:10:29', '2025-10-03 00:10:29'),
(16, '2025-10-03', 5, 'Faisal Baksh', 'Wedding', 1, '2025-10-03 05:00:00', '2025-10-03 13:00:00', 'In Progress', 'Cash', NULL, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Zero Rupees Only', NULL, '2025-10-03 00:10:55', '2025-10-03 00:10:55'),
(17, '2025-10-06', 1, 'Ali', 'Wedding', 300, '2025-10-05 19:00:00', '2025-10-07 03:00:00', 'In Progress', 'Cash', 'advance', 10000.00, 400000.00, 20000.00, 380000.00, 10000.00, 370000.00, 'Three Lakh Seventy Thousand Rupees Only', 'Pending Payment After Event.', '2025-10-06 02:47:06', '2025-10-06 05:47:20'),
(18, '2025-10-06', 10, 'Tariq Hussain', 'Wedding', 1000, '2025-10-09 00:00:00', '2025-10-11 08:00:00', 'In Progress', 'Cash', 'full', 0.00, 111110.00, 0.00, 111110.00, 111110.00, 0.00, 'Zero Rupees Only', NULL, '2025-10-06 06:19:54', '2025-10-06 06:21:24');

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
(8, 7, 1, 'Package', 1.00, 20000.00, 'percent', 0.00, 20000.00, '2025-10-01 02:36:16', '2025-10-01 02:36:16'),
(9, 8, 1, 'VENUE Package', 1.00, 500000.00, 'percent', 0.00, 500000.00, '2025-10-01 04:42:05', '2025-10-01 04:42:05'),
(10, 9, 1, 'DRINKS', 500.00, 100.00, 'percent', 0.00, 50000.00, '2025-10-01 04:46:58', '2025-10-01 04:46:58'),
(11, 10, 1, 'Package', 100000.00, 1.00, 'percent', 0.00, 100000.00, '2025-10-01 04:57:08', '2025-10-01 04:57:08'),
(12, 11, 1, 'Package', 1.00, 500000.00, 'percent', 0.00, 500000.00, '2025-10-01 04:58:36', '2025-10-01 04:58:36'),
(13, 12, 1, 'Package &Stage Setup', 1.00, 700000.00, 'percent', 5.00, 665000.00, '2025-10-01 06:22:13', '2025-10-01 06:22:13'),
(14, 6, 1, 'Package', 1.00, 400000.00, 'percent', 0.00, 400000.00, '2025-10-03 00:05:57', '2025-10-03 00:05:57'),
(15, 6, 2, 'Stage Setup', 1.00, 15000.00, 'lump', 3000.00, 12000.00, '2025-10-03 00:05:57', '2025-10-03 00:05:57'),
(16, 13, 1, 'Setup', 1.00, 0.00, 'percent', 0.00, 0.00, '2025-10-03 00:09:29', '2025-10-03 00:09:29'),
(17, 14, 1, 'setup 2', 0.00, 0.00, 'percent', 0.00, 0.00, '2025-10-03 00:09:45', '2025-10-03 00:09:45'),
(18, 15, 1, 'stafhe', 0.00, 0.00, 'percent', 0.00, 0.00, '2025-10-03 00:10:29', '2025-10-03 00:10:29'),
(19, 16, 1, 'sikandr', 0.00, 0.00, 'percent', 0.00, 0.00, '2025-10-03 00:10:55', '2025-10-03 00:10:55'),
(22, 17, 1, 'Package', 1.00, 400000.00, 'percent', 5.00, 380000.00, '2025-10-06 05:47:20', '2025-10-06 05:47:20'),
(24, 18, 1, 'f', 1.00, 111110.00, 'percent', 0.00, 111110.00, '2025-10-06 06:21:24', '2025-10-06 06:21:24');

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
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `cnic`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Ali', '45203-12345678-3', '0312-3456789', 'Gulshan Iqbal Karachi', '2025-09-25 05:51:56', '2025-09-29 02:30:06'),
(3, 'Sikandar', '45203-12345678-8', '0312-3456723', 'Jouhar Mor Karachi', '2025-09-29 02:31:05', '2025-09-29 02:31:05'),
(4, 'kasim', '45203-12345678-5', '0312-8338092', 'Karimabad Hyderbad', '2025-09-30 05:23:28', '2025-09-30 05:24:55'),
(5, 'Faisal Baksh', '45203-12345678-1', '0312-8338843', 'Jacambad', '2025-09-30 05:25:41', '2025-09-30 05:25:41'),
(6, 'Sheeraz', '45202-12345648-1', '0309-8338092', 'Sukkur', '2025-09-30 05:26:40', '2025-09-30 05:26:40'),
(7, 'Khan Naseem', '45205-12345678-9', '0305-8338092', 'Khairpur', '2025-09-30 05:27:23', '2025-09-30 05:27:30'),
(8, 'Jameel Shaikh', '45303-12345678-1', '0301-8338333', 'Jamshoro', '2025-09-30 05:28:28', '2025-09-30 05:28:28'),
(9, 'Ahtsham', '45207-12345678-5', '0334-8338453', 'Lahore Punjab', '2025-09-30 05:29:33', '2025-09-30 05:29:33'),
(10, 'Tariq Hussain', '45403-12393678-5', '0333-6738092', 'Mosamiyat', '2025-09-30 05:31:04', '2025-09-30 05:31:04'),
(11, 'Arif Hussain', '43103-12345678-5', '0333-6738435', 'Kiranchi', '2025-09-30 05:31:41', '2025-10-06 02:03:33'),
(12, 'Muneeb', '45102-48465467-0', '0329-83380092', 'Safoora Chowk', '2025-09-30 23:52:29', '2025-09-30 23:52:29');

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
(4, '2025_09_25_062948_add_username_unique_and_role_to_users_table', 2),
(5, '2025_09_25_093639_create_customers_table', 3),
(6, '2025_09_25_000000_create_customers_table', 4),
(7, '2025_09_26_000000_create_bookings_table', 5),
(8, '2025_09_26_000001_create_booking_items_table', 5),
(9, '2025_01_27_000000_add_event_status_to_bookings_table', 6),
(10, '2025_01_27_000001_create_payments_table', 6),
(11, '2025_09_26_000002_add_foreign_keys_after_tables_exist', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('nabeelkhoso46@gmail.com', '$2y$12$f54Hfyjcsb59RoLPYl.Y1u12kABoI2RCuqKJRkGhvIBD4OYIN6e4y', '2025-09-30 01:08:27'),
('venue@example.com', '$2y$12$7PtJalKe/wCoSg2tdNwlWezp4EcSEhYOBS7SStZ.8LTuHHCCPM1HG', '2025-09-30 02:14:48'),
('venue@test.com', '$2y$12$pQK.DDkRrHDMJiDHo4mizu9Hb4yc.5rDHuWMdlXG8ht5a8tZIpH/m', '2025-09-29 23:36:27');

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
(1, 12, 11, 'Arif Hussain', '0333-67380435', '2025-10-03', 'Credit', 'Cash', 665000.00, 15000.00, 650000.00, 'Some Payment Collect', '2025-10-03 00:29:56', '2025-10-03 00:29:56'),
(2, 12, 11, 'Arif Hussain', '0333-67380435', '2025-10-03', 'Debit', 'Cash', 650000.00, 78000.00, 728000.00, NULL, '2025-10-03 02:40:50', '2025-10-03 04:47:54'),
(3, 9, 5, 'Faisal Baksh', '0312-8338843', '2025-10-03', 'Credit', 'Cash', 50000.00, 35000.00, 15000.00, NULL, '2025-10-03 04:51:57', '2025-10-03 04:51:57'),
(5, 7, 8, 'Jameel Shaikh', '0301-8338333', '2025-10-03', 'Credit', 'Cheque', 20000.00, 6000.00, 14000.00, 'Recive', '2025-10-03 05:05:55', '2025-10-03 05:05:55'),
(6, 12, 11, 'Arif Hussain', '0333-67380435', '2025-10-06', 'Credit', 'Online Transaction', 650000.00, 150000.00, 500000.00, NULL, '2025-10-05 23:07:00', '2025-10-05 23:07:00'),
(7, 12, 11, 'Arif Hussain', '0333-67380435', '2025-10-06', 'Credit', 'Cheque', 500000.00, 10000.00, 490000.00, NULL, '2025-10-06 00:05:16', '2025-10-06 00:05:16'),
(8, 11, 4, 'kasim', '0312-8338092', '2025-10-06', 'Credit', 'Cheque', 600000.00, 55000.00, 545000.00, NULL, '2025-10-06 00:17:55', '2025-10-06 00:17:55');

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
('5wSbW8kkloRj64GGhEqGqlJmzcAaoWKpe8yl1iKJ', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoianFEOEFtN012ZWJFbE5YYUlkS3BYT1FidHplRTQ2SlpuT3d1WFFSZCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1759747681),
('NrU3zzDaLNLyV1BqOc9e0wieI2jRJkE5NYStnOb2', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV3FvckdHaFN3WE9xUUpid0d2bnNhaWs4WVgxS3dVVHBRdHYzZERobCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQ/bW9udGg9MTAmeWVhcj0yMDI1Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODt9', 1759749871);

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
(8, 'Venue', 'venue@example.com', NULL, '$2y$12$mOaOCoD3LNBs.3.Pi04lkOAaaCeqOltUdOFOEeG6AE64Te6xU4mlG', 'user', '0P83QESSd5vvauEXwjWNV7ZFwz5aQm4gpYXURZAacVxKzTBJpCu3SgMToUxA', '2025-09-29 23:45:16', '2025-09-30 01:35:18');

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
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `booking_items`
--
ALTER TABLE `booking_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
