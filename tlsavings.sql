-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 13, 2018 at 11:45 AM
-- Server version: 10.1.22-MariaDB-
-- PHP Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tlsavings`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('junior@tlsavings.com', '$2y$10$irbCOtG.OS7h/fCIxJK.7eLJ6nRvPHTEPaW8wcdUlM9AQQbxpyERS', '2018-01-30 23:00:50'),
('nduovictor@gmail.com', '$2y$10$YTzUM6Ezp.k0Tr2c4Ldye.OAapqP0u7VrjgxiCGQp4id1RRvXTso2', '2018-01-31 13:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `title`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'current_pnm_value', 'Current PNM Value', '1000', 'This is the equivalent of one PNM in NGN', '2018-01-19 11:14:32', '2018-02-05 05:35:34'),
(2, 'check_profit_start', 'Check Profit Start', '2018-01-24 07:56:19', 'Date to start commision check', '2018-01-24 07:55:18', '2018-02-05 05:35:34'),
(3, 'ngn_withdrawal_charge', 'Withdrawal Charge', '300', 'This is the charge for each withdrawal', '2018-01-24 07:55:18', '2018-02-05 05:35:34'),
(4, 'ngn_conversion_charge', 'NGN Conversion Charge', '200', 'This is the charge for each NGN conversion to PNM', '2018-01-24 07:58:11', '2018-02-05 05:35:34'),
(5, 'check_shared_start', 'Check Shared Start', '2018-01-24 07:56:19', 'Date to start shared PNM check', '2018-01-24 08:36:41', '2018-02-05 05:35:34'),
(6, 'ngn_withdrawal_limit', 'NGN Withdrawal Limit', '50000', 'This is the ngn withdrawal limit per transaction ', '2018-01-24 12:51:03', '2018-02-05 05:35:34'),
(7, 'pnm_withdrawal_charge', 'Charge for PNM Withdrawals', '0.5', 'This is the charge for PNM withdrawals', '2018-01-26 10:23:45', '2018-02-05 05:35:34'),
(8, 'pnm_transfer_charge', 'Charge for PNM Transfer', '1', 'This is the charge for each PNM transfer', '2018-01-27 07:36:03', '2018-02-05 05:35:34'),
(9, 'pnm_conversion_charge', 'PNM Conversion Charge', '1', 'This is the charge for each NGN conversion to PNM', '2018-01-24 07:58:11', '2018-02-05 05:35:34'),
(10, 'ngn_withdrawal_duration', 'NGN Withdrawal Duration', '3-4 Working Days', 'This is the durations required for NGN withdrawal processing', '2018-02-03 21:29:14', '2018-02-05 05:35:34'),
(11, 'pnm_withdrawal_limit', 'PNM Withdrawal Limit', '40', 'This is the PNM withdrawal limit per transaction ', '2018-01-24 12:51:03', '2018-02-05 05:35:34'),
(12, 'pnm_withdrawal_duration', 'PNM Withdrawal Duration', '3-4 Working Days', 'This is the durations required for PNM withdrawal processing', '2018-02-03 21:29:14', '2018-02-05 05:35:34'),
(13, 'pnm_daily_withdrawal_limit', 'PNM Daily Withdrawal Limit', '3', 'Sets the limit of daily PNM withdrawals', '2018-02-05 02:46:00', '2018-02-05 05:35:34'),
(14, 'ngn_daily_withdrawal_limit', 'NGN Daily Withdrawal Limit', '3', 'Sets the limit of daily NGN withdrawals', '2018-02-05 02:46:00', '2018-02-05 05:35:34'),
(15, 'pnm_transfer_limit', 'PNM Transfer Limit', '10', 'Sets the PNM transfer limit', '2018-02-05 03:08:03', '2018-02-05 05:35:34'),
(16, 'pnm_conversion_limit', 'PNM Conversion Limit', '10', 'Sets the PNM conversion limit', '2018-02-05 03:08:03', '2018-02-05 05:35:34');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(32) NOT NULL,
  `from` varchar(45) NOT NULL,
  `to` varchar(45) NOT NULL,
  `amount` float NOT NULL DEFAULT '0',
  `value` float DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `status` enum('pending','requested','successful','failed') NOT NULL DEFAULT 'pending',
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_id`, `from`, `to`, `amount`, `value`, `description`, `type`, `status`, `remark`, `created_at`, `updated_at`) VALUES
(1, 'e185a7233545c20662a24ba6ce001a88', 'super', '78278190', 300, 1000, 'Admin added 300 PNM worth 300000 NGN', 'admin-holding', 'successful', 'credit', '2018-02-07 10:14:24', '2018-02-07 10:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `name` varchar(185) NOT NULL,
  `email` varchar(185) NOT NULL,
  `wallet_id` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pin` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'tlssavings/public/images/default-user.png',
  `account_number` varchar(45) NOT NULL,
  `wallet_address` varchar(45) NOT NULL,
  `private_key` varchar(45) NOT NULL,
  `type` enum('user','admin') NOT NULL DEFAULT 'user',
  `access_level` enum('5','4','3','2','1') NOT NULL DEFAULT '1',
  `status` enum('active','pending','blocked') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `name`, `email`, `wallet_id`, `password`, `pin`, `remember_token`, `avatar`, `account_number`, `wallet_address`, `private_key`, `type`, `access_level`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Super', 'Admin', 'super', 'admin@tlsavings.com', '78278190', '$2y$10$P/R4IT5G/Oi1Oh2cAYNYaeJdHKqKVQbZuNyj218vNo2oZElsqUY0i', '$2y$10$vn2VXuZNEYDHocJgMZJPVOL0STFoVfdkLxXTg1WlUqfffaFzslAbi', '9fsAFvm2bQsowJwMfRyl1N38JcGOnwQmcxHlvAdQkAfNuTwR9NOwhBSXiOEq', 'tlssavings/public/images/default-user.png', '0000000000', '3293489208', '124354542', 'admin', '4', 'active', '2018-01-21 10:57:29', '2018-02-05 08:19:15'),
(11, 'Victoria', 'Ndu', 'nvictor', 'nduovictor@gmail.com', 'bee318b23e412833148f77ce15818857', '$2y$10$I3fIh3F.xe2d2ZcKvptaQOo1pRGbhBM02dfoxKiuvamsJZVB703Nu', '$2y$10$CKQROooukC19sba8FqCjMeoK4E1EeH9ueJ.AL0WGZzQEaTgffY/Ni', NULL, NULL, '2013212111', 'bd82dd2a8b944f131d0a53bc1b473029', 'hjwehnsidoj8932784y3uhjj5489437yhjhj3', 'user', '1', 'active', '2018-02-05 08:26:42', '2018-02-05 14:28:55'),
(12, 'Chioma', 'Nwanna', 'chioma', 'tweenmailer@gmail.com', 'd0fe1d7190f5f1f3ab65c078ebfcb42b', '$2y$10$ZBNbZmSngTQJUMeOTRdhEu0hO/uHoA4vBbbvt.78S5PkltNXrt0Oe', '$2y$10$PlG9/RRejogdzUODX43okOqOX4vHMChGEcu8GaxGAdrkBM.NEWsn.', NULL, 'tlssavings/public/images/passport/AMrn22d7eUIHgPrV7rNp6OBrAImA0RCllejr5fm4.jpeg', '3004211939', 'dklfssopi238473yu2h3j2312kewdjk12', '1jk2133902i3on2iewiw203923jkfdsod', 'user', '1', 'active', '2018-02-05 16:27:54', '2018-02-05 16:27:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_metas`
--

CREATE TABLE `user_metas` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `wallet_address` varchar(40) NOT NULL,
  `private_key` varchar(64) NOT NULL,
  `account_number` varchar(185) NOT NULL,
  `residential_address` text,
  `dob` date DEFAULT NULL,
  `marital_status` enum('single','married','divorced') DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `contact_address` text,
  `phone_no` varchar(45) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `lga` varchar(255) DEFAULT NULL,
  `id_card_type` varchar(255) DEFAULT NULL,
  `id_card_no` varchar(255) DEFAULT NULL,
  `bvn` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_acc_no` varchar(255) DEFAULT NULL,
  `bank_acc_name` varchar(255) DEFAULT NULL,
  `form_location` varchar(255) DEFAULT NULL,
  `signature_location` varchar(255) DEFAULT NULL,
  `utility_bill_location` varchar(255) DEFAULT NULL,
  `idcard_location` varchar(255) DEFAULT NULL,
  `passport_location` varchar(255) DEFAULT NULL,
  `nok_contact_address` varchar(255) DEFAULT NULL,
  `nok_email` varchar(255) DEFAULT NULL,
  `nok_gender` enum('male','female') DEFAULT NULL,
  `nok_dob` date DEFAULT NULL,
  `nok_phone_no` varchar(255) DEFAULT NULL,
  `nok_relationship` varchar(255) DEFAULT NULL,
  `next_of_kin` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `mother_maiden_name` varchar(255) DEFAULT NULL,
  `office_phone_no` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `status` enum('registered','unregistered','pending') NOT NULL DEFAULT 'pending',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_metas`
--

INSERT INTO `user_metas` (`id`, `first_name`, `last_name`, `other_name`, `wallet_address`, `private_key`, `account_number`, `residential_address`, `dob`, `marital_status`, `gender`, `contact_address`, `phone_no`, `nationality`, `state`, `lga`, `id_card_type`, `id_card_no`, `bvn`, `occupation`, `bank_name`, `bank_acc_no`, `bank_acc_name`, `form_location`, `signature_location`, `utility_bill_location`, `idcard_location`, `passport_location`, `nok_contact_address`, `nok_email`, `nok_gender`, `nok_dob`, `nok_phone_no`, `nok_relationship`, `next_of_kin`, `spouse_name`, `mother_maiden_name`, `office_phone_no`, `landmark`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Victoria', 'Ndu', 'Kachi', 'bd82dd2a8b944f131d0a53bc1b473029', 'hjwehnsidoj8932784y3uhjj5489437yhjhj3', '2013212111', '256 Abak Road', '1994-10-23', 'single', 'female', '22 Rd B-Close Block 3 Flat', '08035024563', 'Nigerian', 'Imo', 'Ahiazu Mbaise', 'NYSC', 'AD/17A/3849', '333239404', '0024660400', 'Zenith Bank', '3002991220', 'Anita Sampson', 'tlssavings/public/images/forms/Sokj4QRuEs01xI7zgeDDfOixDKAJSpu4oRlcXhNT.jpeg', 'tlssavings/public/images/signatures/Sokj4QRuEs01xI7zgeDDfOixDKAJSpu4oRlcXhNT.jpeg', 'tlssavings/public/images/utility_bills/7DVDVNrrno5N8TKtReSBQo6Z1o0dwgPXybu8aFZC.jpeg', 'tlssavings/public/images/idcards/FReNPcRreO9QzuNSxRe94GBca0Fuxp3Fr2AXVH4G.jpeg', 'tlssavings/public/images/passport/ufiZCN20MY1I3sd9MO2rPXvomMCW2NXL8R0sXqlm.jpeg', 'Aguneze Mbaise', 'tweenmailer@gmail.com', 'female', '2018-02-05', NULL, 'Husband', 'Godwin Nwanna', 'Florenence Ahuruchioke Ndu', 'Osuagwu', '01441233', 'Steel House', 'registered', '2018-02-05 14:28:43', '2018-02-05 08:18:43'),
(2, 'Chioma', 'Nwanna', 'Okoli', 'dklfssopi238473yu2h3j2312kewdjk12', '1jk2133902i3on2iewiw203923jkfdsod', '3004211939', '22 Rd B-Close Block 3 Flat 2', '2018-02-05', 'single', NULL, '22 Rd B-Close Block 3 Flat 2', '08039461523', 'Nigerian', 'Imo', 'Mbaitoli', 'NYSC', 'Chioma Nwanna', '235423234322', '0024660400', 'Zenith', '8742216289', 'Chioma Nwanna', 'tlssavings/public/images/forms/bxQbSnOCskOILpwcmh1ww5Np1IHInKgMARVfSkA0.jpeg', 'tlssavings/public/images/signatures/bxQbSnOCskOILpwcmh1ww5Np1IHInKgMARVfSkA0.jpeg', 'tlssavings/public/images/utility_bills/rl1GwatwR2i8JDdEhs5Y6pr3ijZKZLyV9fVzrljC.jpeg', 'tlssavings/public/images/idcards/Teog94IRlypunC4VLOQsD1m7UYA03043aM7OJ9wZ.jpeg', 'tlssavings/public/images/passport/AMrn22d7eUIHgPrV7rNp6OBrAImA0RCllejr5fm4.jpeg', 'Aguneze Mbaise', 'nduovictor@gmail.com', 'male', '2018-02-05', NULL, 'Husband', 'Ndu Victor', 'Florenence Ahuruchioke Ndu', 'Osuagwu', '01441233', 'Empire Filling Station', 'registered', '2018-02-05 16:27:53', '2018-02-05 14:58:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_private_key_uindex` (`private_key`),
  ADD UNIQUE KEY `users_account_number_uindex` (`account_number`),
  ADD UNIQUE KEY `users_name_uindex` (`name`),
  ADD UNIQUE KEY `users_email_uindex` (`email`),
  ADD UNIQUE KEY `users_wallet_id_uindex` (`wallet_id`),
  ADD UNIQUE KEY `users_wallet_address_uindex` (`wallet_address`);

--
-- Indexes for table `user_metas`
--
ALTER TABLE `user_metas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_metas_private_key_uindex` (`private_key`),
  ADD UNIQUE KEY `user_metas_account_number_uindex` (`account_number`),
  ADD UNIQUE KEY `user_metas_wallet_address_uindex` (`wallet_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_metas`
--
ALTER TABLE `user_metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
