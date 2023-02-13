-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2023 at 08:34 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_work` time DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `emp_name`, `emp_code`, `check_in`, `check_out`, `total_work`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Ajeet Kumar', 'SWE260', '2023-01-27 22:56:38', '2023-01-27 23:19:32', '00:22:54', NULL, '2023-01-27 17:26:38', '2023-01-27 17:49:32'),
(4, 'Ashish kumar', 'SWE264', '2023-01-26 23:28:31', '2023-01-26 23:33:38', '00:05:07', NULL, '2023-01-26 17:58:31', '2023-01-26 18:03:38'),
(11, 'Ajeet Kumar', 'SWE260', '2023-01-28 21:06:23', '2023-01-28 23:44:31', '02:38:08', NULL, '2023-01-28 15:36:23', '2023-01-28 18:14:31'),
(13, 'Ajeet Kumar', 'SWE260', '2023-01-25 14:50:58', '2023-01-25 22:52:00', '08:01:02', NULL, '2023-01-25 17:20:58', '2023-01-25 17:22:00'),
(14, 'Amit Kumar', 'SWE261', '2023-01-25 14:52:27', '2023-01-25 22:53:01', '08:00:34', NULL, '2023-01-25 17:22:27', '2023-01-25 17:23:01'),
(15, 'Ajeet Kumar', 'SWE260', '2023-01-30 20:59:33', '2023-01-30 23:36:50', '02:37:17', NULL, '2023-01-30 15:29:33', '2023-01-30 18:06:50'),
(16, 'Amit Kumar', 'SWE261', '2023-01-30 21:12:21', '2023-01-30 21:12:38', '00:00:17', NULL, '2023-01-30 15:42:21', '2023-01-30 15:42:38'),
(17, 'Ajeet Kumar', 'SWE260', '2023-01-31 21:00:11', '2023-01-31 23:36:12', '02:36:01', NULL, '2023-01-31 15:30:11', '2023-01-31 18:06:12'),
(18, 'Amit Kumar', 'SWE261', '2023-01-31 21:01:18', '2023-01-31 23:35:46', '02:34:28', NULL, '2023-01-31 15:31:18', '2023-01-31 18:05:46'),
(19, 'Ajeet Kumar', 'SWE260', '2023-02-01 00:04:03', '2023-02-01 20:58:19', '20:54:16', NULL, '2023-01-31 18:34:03', '2023-02-01 15:28:19'),
(20, 'Amit Kumar', 'SWE261', '2023-02-01 00:04:43', '2023-02-01 20:58:49', '20:54:06', NULL, '2023-01-31 18:34:43', '2023-02-01 15:28:49'),
(21, 'Ajeet Kumar', 'SWE260', '2023-02-02 00:49:25', '2023-02-02 21:26:47', '20:37:22', NULL, '2023-02-01 19:19:25', '2023-02-02 15:56:47'),
(22, 'Amit Kumar', 'SWE261', '2023-02-02 20:55:29', '2023-02-02 21:26:06', '00:30:37', NULL, '2023-02-02 15:25:29', '2023-02-02 15:56:06'),
(23, 'Ashish kumar', 'SWE264', '2023-02-06 21:23:37', '2023-02-06 23:28:25', '02:05:18', NULL, '2023-02-06 15:53:37', '2023-02-06 15:53:37'),
(24, 'Ajeet Kumar', 'SWE260', '2023-02-06 21:24:08', '2023-02-06 23:28:25', '02:04:17', NULL, '2023-02-06 15:54:08', '2023-02-06 17:58:25'),
(25, 'Amit Kumar', 'SWE261', '2023-02-06 21:24:40', '2023-02-06 23:27:56', '02:03:16', NULL, '2023-02-06 15:54:40', '2023-02-06 17:57:56'),
(26, 'Ajeet Kumar', 'SWE260', '2023-02-08 21:29:58', NULL, NULL, NULL, '2023-02-08 15:59:58', '2023-02-08 15:59:58'),
(27, 'Amit Kumar', 'SWE261', '2023-02-08 21:30:18', NULL, NULL, NULL, '2023-02-08 16:00:18', '2023-02-08 16:00:18'),
(28, 'Ajeet Kumar', 'SWE260', '2023-02-09 21:04:20', NULL, NULL, NULL, '2023-02-09 15:34:20', '2023-02-09 15:34:20'),
(29, 'Amit Kumar', 'SWE261', '2023-02-09 21:04:48', NULL, NULL, NULL, '2023-02-09 15:34:48', '2023-02-09 15:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `contact_email`, `contact_mobile`, `company_name`, `company_logo`, `start_date`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(10, 'Infosys', '485kumarashish@gmail.com', '08127426564', 'Infosys Infotech', '1675539426Tulips.jpg', '2023-02-16', 'SWE264', 'SWE264', '2023-02-04 17:33:38', '2023-02-04 19:37:06'),
(11, 'Trisqure', '485ashishkumar@gmail.com', '8114278804', NULL, NULL, '2022-03-01', 'SWE264', NULL, '2023-02-06 15:34:06', '2023-02-06 15:34:06'),
(12, 'Mawai', 'mawai@mail.com', '8127426564', 'Mawai Infotech', NULL, '2023-02-01', 'SWE264', NULL, '2023-02-07 18:35:32', '2023-02-07 18:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

CREATE TABLE `employee_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `DOB` date NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personal_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `personal_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_add` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_add` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pincode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sallary` bigint(20) NOT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acc_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_master`
--

INSERT INTO `employee_master` (`id`, `password`, `usertype`, `status`, `first_name`, `last_name`, `position`, `emp_code`, `father_name`, `DOB`, `gender`, `profile_photo`, `personal_email`, `company_email`, `email_verified_at`, `personal_mobile`, `company_mobile`, `current_add`, `permanent_add`, `pincode`, `city`, `state`, `country`, `sallary`, `bank_name`, `acc_no`, `ifsc`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(23, '$2y$10$IPrK6fT6MI3LRmxIoQv8GetQ26O3Eng9PzjU67nx71ptprNAnzs4q', 1, '1', 'Ashish', 'kumar', 'HR', 'SWE264', 'Mr. Nanhe Lal', '2022-08-05', 'male', NULL, 'ok@gmail.com', '485ashishkumar@gmail.com', NULL, '8127426565', '8127426564', 'VIJAI PATTI TURKAULI SONPURA', 'Malhipur Sultanpur Uttar Pradesh', '230124', 'PRATAPGHAR', 'UTTAR PRADESH', 'India', 12600, 'Paytm Payment Bank', '918114278804', 'PYTM0123456', 'SWE264', 'SWE264', '2023-01-23 10:21:18', '2023-02-01 19:17:32'),
(26, '$2y$10$VvjCfSGq9P3kIBTShcQ92.TyH.U7/okK3QYnL7ZkQ1RXfP92WAaVa', 0, '1', 'Amit', 'Kumar', 'Develper', 'SWE261', 'Mr. Father', '2000-01-01', 'male', '1674494533Lighthouse.jpg', 'ajeet@gmai.com', '485kumarashish@gmail.com', NULL, '08127426564', '8127426565', 'VIJAI PATTI TURKAULI SONPURA', 'Malhipur Sultanpur Uttar Pradesh', '230124', 'PRATAPGHAR', 'UTTAR PRADESH', 'India', 15000, 'Union Bank Of India', '431941916728', 'UNION0123456', 'SWE264', 'SWE264', '2023-01-23 10:35:49', '2023-02-03 17:05:52'),
(38, '$2y$10$m7MSZhFxBs/t323P9TrzguVf0jQ37rn1QRIf6BMub16yZ1kUgC3sO', 0, '1', 'Ajeet', 'Kumar', 'Senior Accountant', 'SWE260', 'Mr. Nanhe Lal', '2000-01-01', 'male', '1674574955strawberryamp_kiwi_1_518326.jpg', 'ajeet@gmail.com', 'okdd@gmail.com', NULL, '8114278804', '8127426511', 'VIJAI PATTI TURKAULI SONPURA', 'Malhipur Sultanpur Uttar Pradesh', '230124', 'PRATAPGHAR', 'UTTAR PRADESH', 'India', 12600, 'Paytm Payment Bank1', '918114278806', 'PYTM0123456', 'SWE264', 'SWE264', '2023-01-24 10:12:35', '2023-02-03 17:06:46'),
(42, '$2y$10$HxMFgBny5Ykd4tOxuK6wBeh5UkNzE.JlHwsQaPXkMSelOxNtxyI0e', 0, '1', 'Suman', 'Yadav', 'Developer', 'SWE262', 'Wasudev Yadav', '2000-02-05', 'male', '1675188130Tulips.jpg', 'suman@gmai.com', 'suman@mawaimail.com', NULL, '81274265555', '81274266666', 'VIJAI PATTI TURKAULI SONPURA', 'Malhipur Sultanpur Uttar Pradesh', '230124', 'PRATAPGHAR', 'UTTAR PRADESH', 'India', 8220, 'State Bank Of India', '9181274265555', 'PYTM01234567', 'SWE264', 'SWE264', '2023-01-31 18:02:10', '2023-02-10 18:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 2),
(13, '2023_01_20_165925_create_employees_table', 2),
(19, '2023_01_25_235547_create_attendances_table', 3),
(21, '2023_02_02_231237_create_ratings_table', 4),
(22, '2023_02_03_235608_create_clients_table', 5),
(24, '2023_02_04_225452_create_projects_table', 6),
(27, '2023_02_08_220208_create_weekly_ratings_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_dev_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_emp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `timeline` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_change_date` datetime DEFAULT NULL,
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_url`, `project_dev_url`, `client`, `working_emp`, `budget`, `created_date`, `start_date`, `end_date`, `timeline`, `status`, `status_change_date`, `payment_status`, `target_status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Payroll', 'www.trisquare.com', '192.168.1:33', '11', 'SWE260', '500000', '2023-02-07', '2023-03-01', '2023-05-30', 90, 'PR', NULL, 'PN', 'FN', 'SWE264', 'SWE264', '2023-02-07 16:30:15', '2023-02-07 16:57:38'),
(8, 'ABC', 'ABC.COM', '121212', '11', 'SWE261', '30000', '2023-02-08', '2023-02-08', '2023-05-09', 90, 'ST', '2023-02-08 00:00:00', 'PN', 'FN', 'SWE264', 'SWE264', '2023-02-07 19:29:52', '2023-02-07 19:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attedance_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_work` time DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `attedance_id`, `emp_code`, `rating`, `description`, `date`, `check_in`, `check_out`, `total_work`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '20', 'SWE261', 4, 'Good', '2023-02-03', '2023-02-01 00:04:43', '2023-02-01 20:58:49', '20:54:06', NULL, '2023-02-03 16:33:10', '2023-02-03 16:33:10'),
(2, '19', 'SWE260', 5, 'Testing', '2023-02-03', '2023-02-01 00:04:03', '2023-02-01 20:58:19', '20:54:16', NULL, '2023-02-03 17:01:39', '2023-02-03 17:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weekly_ratings`
--

CREATE TABLE `weekly_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attedance_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrk_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cln_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cln_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cln_rating` int(11) DEFAULT NULL,
  `cln_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rqt_date` date DEFAULT NULL,
  `rt_date` date DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_work` time DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rqt_emp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weekly_ratings`
--

INSERT INTO `weekly_ratings` (`id`, `attedance_id`, `wrk_emp_code`, `cln_id`, `cln_email`, `rt_status`, `cln_rating`, `cln_description`, `rqt_date`, `rt_date`, `check_in`, `check_out`, `total_work`, `updated_by`, `rqt_emp_code`, `created_at`, `updated_at`) VALUES
(100, '25', 'SWE261', '11', '485ashishkumar@gmail.com', 'RQ', NULL, NULL, '2023-02-11', NULL, '2023-02-06 21:24:40', '2023-02-06 23:27:56', '02:03:16', NULL, 'SWE264', '2023-02-10 19:29:47', '2023-02-10 19:29:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_master`
--
ALTER TABLE `employee_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_master_emp_code_unique` (`emp_code`),
  ADD UNIQUE KEY `employee_master_personal_email_unique` (`personal_email`),
  ADD UNIQUE KEY `employee_master_company_email_unique` (`company_email`),
  ADD UNIQUE KEY `employee_master_personal_mobile_unique` (`personal_mobile`),
  ADD UNIQUE KEY `employee_master_company_mobile_unique` (`company_mobile`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `weekly_ratings`
--
ALTER TABLE `weekly_ratings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `employee_master`
--
ALTER TABLE `employee_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `weekly_ratings`
--
ALTER TABLE `weekly_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
