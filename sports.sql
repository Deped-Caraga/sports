-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 31, 2023 at 06:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sports`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_08_20_035240_create_sessions_table', 1),
(7, '2021_08_20_035930_add_google_id_column_in_users_table', 2),
(8, '2021_08_20_064721_create_permission_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 2),
(36, 'App\\Models\\User', 3),
(35, 'App\\Models\\User', 4),
(18, 'App\\Models\\User', 5),
(31, 'App\\Models\\User', 5),
(33, 'App\\Models\\User', 5),
(31, 'App\\Models\\User', 6),
(33, 'App\\Models\\User', 6),
(31, 'App\\Models\\User', 7),
(33, 'App\\Models\\User', 7),
(31, 'App\\Models\\User', 8),
(33, 'App\\Models\\User', 8),
(31, 'App\\Models\\User', 11),
(33, 'App\\Models\\User', 11),
(31, 'App\\Models\\User', 13),
(33, 'App\\Models\\User', 13),
(31, 'App\\Models\\User', 14),
(33, 'App\\Models\\User', 14),
(31, 'App\\Models\\User', 16),
(33, 'App\\Models\\User', 16),
(31, 'App\\Models\\User', 167),
(32, 'App\\Models\\User', 167),
(33, 'App\\Models\\User', 167),
(31, 'App\\Models\\User', 312),
(32, 'App\\Models\\User', 312),
(33, 'App\\Models\\User', 312),
(31, 'App\\Models\\User', 515),
(33, 'App\\Models\\User', 515),
(31, 'App\\Models\\User', 618),
(33, 'App\\Models\\User', 618),
(18, 'App\\Models\\User', 696),
(28, 'App\\Models\\User', 696),
(29, 'App\\Models\\User', 696),
(31, 'App\\Models\\User', 696),
(32, 'App\\Models\\User', 696),
(18, 'App\\Models\\User', 25967),
(2, 'App\\Models\\User', 26006),
(18, 'App\\Models\\User', 26006),
(19, 'App\\Models\\User', 26006),
(20, 'App\\Models\\User', 26006),
(22, 'App\\Models\\User', 26006),
(23, 'App\\Models\\User', 26006),
(2, 'App\\Models\\User', 26104),
(20, 'App\\Models\\User', 26104),
(2, 'App\\Models\\User', 26114),
(18, 'App\\Models\\User', 26114),
(19, 'App\\Models\\User', 26114),
(20, 'App\\Models\\User', 26114),
(18, 'App\\Models\\User', 26115),
(2, 'App\\Models\\User', 26156);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('douglas.harvey@example.com', '$2y$10$ANr6ylJbQWuk0yFAok7U/uciulsFrFMLvX1th8eQc5oixGg/gOMRi', '2021-10-05 01:13:49');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(34, 'Manage Users', 'web', NULL, NULL),
(35, 'Add Score', 'web', NULL, NULL),
(36, 'Validate Score', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('iMsmRVGLRkwKNqLngSlTzePOj8LbwxQcvPipDhLZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.54', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjQ4bDB1RUdlQXE0ZHkyYkhPcVFXNUw3aFBKS1QxYzJhWEtWMG9PNSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9naWZ0d2l6YXJkLnRlc3QiO319', 1673871275),
('rpEKaiM4Bi4j6h2rgWQmXbqDED34eJIesJeehrET', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.54', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2dVSWJDMjhUdzdQNWhuRnRDYTRQR2pGcHdscDNndm5XbVZGZVVnRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHA6Ly9naWZ0d2l6YXJkLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1673870479);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `event_name` varchar(1000) NOT NULL,
  `event_venue` varchar(1000) NOT NULL,
  `event_date_from` date NOT NULL,
  `event_date_to` date NOT NULL,
  `event_logo` varchar(100) NOT NULL,
  `header1` varchar(1000) NOT NULL,
  `header2` varchar(1000) NOT NULL,
  `header3` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bronze_winners`
--

CREATE TABLE `tbl_bronze_winners` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `score_bronze_id` int NOT NULL,
  `name` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coach_bronzes`
--

CREATE TABLE `tbl_coach_bronzes` (
  `id` int NOT NULL,
  `score_bronze_id` int NOT NULL,
  `coach_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coach_golds`
--

CREATE TABLE `tbl_coach_golds` (
  `id` int NOT NULL,
  `score_gold_id` int NOT NULL,
  `coach_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_coach_silvers`
--

CREATE TABLE `tbl_coach_silvers` (
  `id` int NOT NULL,
  `score_silver_id` int NOT NULL,
  `coach_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `id` int NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `event_type` int NOT NULL,
  `event_picture` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_events`
--

INSERT INTO `tbl_events` (`id`, `event_name`, `event_type`, `event_picture`) VALUES
(9, 'Archery', 1, '9.png'),
(10, 'Arnis', 1, '10.png'),
(11, 'Athletics', 1, '11.png'),
(12, 'Badminton', 1, '12.png'),
(13, 'Baseball', 1, '13.png'),
(14, 'Basketball', 1, '14.png'),
(15, 'Billiards', 1, '15.png'),
(16, 'Boxing', 1, '16.png'),
(17, 'Chess', 1, '17.png'),
(18, 'Football', 1, '18.png'),
(19, 'Futsal', 1, '19.png'),
(20, 'Gymnastics', 1, '20.png'),
(21, 'Sepak Takraw', 1, '21.png'),
(22, 'Softball', 1, '22.png'),
(23, 'Special Games', 2, '23.png'),
(24, 'Swimming', 1, '24.png'),
(25, 'Table Tennis', 1, '25.png'),
(26, 'Tennis', 1, '26.png'),
(27, 'Taekwondo', 1, '27.png'),
(28, 'Volleyball', 1, '28.png'),
(30, 'Wushu', 3, '30.png'),
(31, 'Wrestling', 1, '31.png'),
(32, 'PENCAK SILAT', 3, '32.png'),
(33, 'Dance Sports', 3, '33.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_categories`
--

CREATE TABLE `tbl_event_categories` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `category_level` varchar(100) NOT NULL,
  `category_sex` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event_categories`
--

INSERT INTO `tbl_event_categories` (`id`, `event_id`, `category_level`, `category_sex`) VALUES
(3, 9, 'Secondary', 'Boys'),
(4, 9, 'Secondary', 'Girls'),
(5, 10, 'Secondary', 'Boys'),
(6, 10, 'Elementary', 'Boys'),
(7, 10, 'Elementary', 'Girls'),
(8, 10, 'Secondary', 'Girls'),
(9, 11, 'Elementary', 'Boys'),
(10, 11, 'Elementary', 'Girls'),
(11, 11, 'Secondary', 'Boys'),
(12, 11, 'Secondary', 'Girls'),
(13, 12, 'Elementary', 'Girls'),
(14, 12, 'Elementary', 'Boys'),
(15, 12, 'Secondary', 'Girls'),
(16, 12, 'Secondary', 'Boys'),
(17, 13, 'Elementary', 'Boys'),
(18, 13, 'Secondary', 'Boys'),
(19, 14, 'Elementary', 'Boys'),
(20, 14, 'Secondary', 'Girls'),
(21, 14, 'Secondary', 'Boys'),
(22, 15, 'Secondary', 'Boys'),
(23, 16, 'Secondary', 'Boys'),
(24, 17, 'Elementary', 'Boys'),
(25, 17, 'Elementary', 'Girls'),
(26, 17, 'Secondary', 'Girls'),
(27, 17, 'Secondary', 'Boys'),
(28, 18, 'Elementary', 'Boys'),
(29, 18, 'Secondary', 'Boys'),
(30, 19, 'Secondary', 'Girls'),
(31, 20, 'Elementary', 'Boys'),
(32, 20, 'Elementary', 'Girls'),
(33, 20, 'Secondary', 'Boys'),
(34, 20, 'Secondary', 'Girls'),
(35, 21, 'Elementary', 'Boys'),
(37, 21, 'Secondary', 'Boys'),
(38, 21, 'Secondary', 'Girls'),
(39, 22, 'Elementary', 'Girls'),
(40, 22, 'Secondary', 'Girls'),
(41, 23, 'Both', 'Girls'),
(42, 23, 'Both', 'Boys'),
(43, 24, 'Elementary', 'Boys'),
(44, 24, 'Elementary', 'Girls'),
(45, 24, 'Secondary', 'Boys'),
(46, 24, 'Secondary', 'Girls'),
(51, 25, 'Elementary', 'Boys'),
(52, 25, 'Elementary', 'Girls'),
(53, 25, 'Secondary', 'Boys'),
(54, 25, 'Secondary', 'Girls'),
(55, 26, 'Elementary', 'Boys'),
(56, 26, 'Elementary', 'Girls'),
(60, 26, 'Secondary', 'Boys'),
(61, 26, 'Secondary', 'Girls'),
(62, 27, 'Elementary', 'Boys'),
(63, 27, 'Elementary', 'Girls'),
(64, 27, 'Secondary', 'Boys'),
(65, 27, 'Secondary', 'Girls'),
(66, 28, 'Elementary', 'Boys'),
(67, 28, 'Elementary', 'Girls'),
(69, 28, 'Secondary', 'Girls'),
(70, 28, 'Secondary', 'Boys'),
(72, 23, 'Both', 'Mixed'),
(74, 31, 'Secondary', 'Boys'),
(75, 31, 'Secondary', 'Girls'),
(76, 15, 'Secondary', 'Girls'),
(77, 30, 'Secondary', 'Girls'),
(78, 30, 'Secondary', 'Boys'),
(81, 32, 'Secondary', 'Boys'),
(82, 32, 'Secondary', 'Girls'),
(83, 33, 'Secondary', 'Mixed'),
(84, 33, 'Elementary', 'Mixed');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event_sub_categories`
--

CREATE TABLE `tbl_event_sub_categories` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `sub_category` varchar(200) NOT NULL,
  `validated_by` int DEFAULT NULL,
  `validated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_event_sub_categories`
--

INSERT INTO `tbl_event_sub_categories` (`id`, `category_id`, `sub_category`, `validated_by`, `validated_at`) VALUES
(14, 3, '30 Meters Distance', NULL, NULL),
(16, 3, '50 Meters Distance', NULL, NULL),
(17, 3, '60 Meters Distance', NULL, NULL),
(18, 3, '1440 Round (Single Fita)', NULL, NULL),
(21, 4, '30M', NULL, NULL),
(22, 4, '40M', NULL, NULL),
(23, 4, '50M', NULL, NULL),
(24, 4, '60M', NULL, NULL),
(25, 4, 'Single Fita', NULL, NULL),
(54, 8, 'Full Contact Pin Weight (37 - 40 kgs.)', NULL, NULL),
(59, 9, '110 Meters hurdles', NULL, NULL),
(62, 9, 'High Jump ', NULL, NULL),
(63, 9, 'Long Jump', NULL, NULL),
(64, 9, 'Triple Jump', NULL, NULL),
(65, 9, 'Shot Put', NULL, NULL),
(66, 9, 'Discus Throw', NULL, NULL),
(67, 9, 'Javelin Throw', NULL, NULL),
(68, 10, '100 Meters Dash', NULL, NULL),
(71, 10, '400M Dash', NULL, NULL),
(72, 10, '800M Run', NULL, NULL),
(73, 10, '1500 Meters Run', NULL, NULL),
(74, 10, '400 Meters L Hurdles', NULL, NULL),
(76, 10, '100 Meters High Hurdles', NULL, NULL),
(77, 10, '4x100 Relay', NULL, NULL),
(78, 10, '4x400 Relay', NULL, NULL),
(79, 10, 'High Jump ', NULL, NULL),
(80, 10, 'Long Jump', NULL, NULL),
(81, 10, 'Triple Jump', NULL, NULL),
(82, 10, 'Shot Put', NULL, NULL),
(83, 10, 'Discus Throw', NULL, NULL),
(84, 10, 'Javelin Throw', NULL, NULL),
(85, 11, '100 Meters Dash', NULL, NULL),
(86, 11, '200 Meters Dash', NULL, NULL),
(87, 11, '3000-Meter Steeple Chase', NULL, NULL),
(88, 11, '400M Dash', NULL, NULL),
(89, 11, '800M Run', NULL, NULL),
(90, 11, '1500 Meter Run', NULL, NULL),
(92, 11, '5000 meter run', NULL, NULL),
(93, 11, '400M Low Hurdles', NULL, NULL),
(94, 11, '110M High Hurdles', NULL, NULL),
(95, 11, '4x100 Relay', NULL, NULL),
(96, 11, '4x400 Relay', NULL, NULL),
(97, 11, 'High Jump', NULL, NULL),
(98, 11, 'Long Jump', NULL, NULL),
(99, 11, 'Triple Jump', NULL, NULL),
(100, 11, 'Shot Put', NULL, NULL),
(101, 11, 'Discus Throw', NULL, NULL),
(102, 11, 'Javelin Throw', NULL, NULL),
(104, 12, '100 Meters Dash', NULL, NULL),
(105, 12, '200 Meters Dash', NULL, NULL),
(107, 12, '400M Dash', NULL, NULL),
(108, 12, '800M Run', NULL, NULL),
(109, 12, '1500 Meters run', NULL, NULL),
(110, 12, '400 Meters Hurdles', NULL, NULL),
(113, 12, '4x100 Relay', NULL, NULL),
(114, 12, '4x400 Relay', NULL, NULL),
(115, 12, 'High Jump', NULL, NULL),
(116, 12, 'Long Jump', NULL, NULL),
(117, 12, 'Triple Jump', NULL, NULL),
(118, 12, 'Shot Put', NULL, NULL),
(119, 12, 'Discus Throw', NULL, NULL),
(120, 12, 'Javelin Throw', NULL, NULL),
(142, 22, '9-Ball Singles', NULL, NULL),
(143, 22, '8-Ball Singles', NULL, NULL),
(147, 23, 'Pin Weight 14-16 years old (44kg. - 46kg.)', NULL, NULL),
(148, 23, 'Light Flyweight 17-18 years old (46kg. - 49kg.)', NULL, NULL),
(149, 24, 'Blitz - Individual', NULL, NULL),
(150, 24, 'Blitz - Team', NULL, NULL),
(151, 24, 'Standard - Individual', NULL, NULL),
(152, 24, 'Standard - Team', NULL, NULL),
(153, 25, 'CHESS Blitz-Individual Category', NULL, NULL),
(154, 25, 'CHESS Blitz-Team Category', NULL, NULL),
(155, 25, 'CHESS Standard individual Category', NULL, NULL),
(156, 25, 'CHESS Standard-Team Category', NULL, NULL),
(157, 26, 'CHESS Blitz-Individual Cat.', NULL, NULL),
(158, 26, 'CHESS Blitz-Team Cat.', NULL, NULL),
(159, 26, 'CHESS Standard-Individual Cat.', NULL, NULL),
(160, 26, 'CHESS Standard-Team Cat.', NULL, NULL),
(161, 27, 'Blitz - Individual', NULL, NULL),
(162, 27, 'Blitz - Team', NULL, NULL),
(163, 27, 'Standard - Individual', NULL, NULL),
(164, 27, 'Standard - Team', NULL, NULL),
(165, 17, 'BASEBALL', NULL, NULL),
(166, 18, 'BASEBALL', NULL, NULL),
(167, 19, 'BASKETBALL', NULL, NULL),
(168, 20, 'BASKETBALL', NULL, NULL),
(169, 21, 'BASKETBALL', NULL, NULL),
(170, 28, 'FOOTBALL', NULL, NULL),
(171, 29, 'FOOTBALL', NULL, NULL),
(172, 30, 'FUTSAL', NULL, NULL),
(177, 31, 'MAG - Individual All Around (Cluster 1)', NULL, NULL),
(178, 31, 'MAG - Team (cluster 2)', NULL, NULL),
(217, 35, 'Doubles Competition', NULL, NULL),
(218, 37, 'Regu Event', NULL, NULL),
(219, 37, 'Team Event', NULL, NULL),
(221, 39, 'SOFTBALL', NULL, NULL),
(222, 40, 'SOFTBALL', NULL, NULL),
(256, 44, '200M individual Medley', NULL, NULL),
(270, 45, '400 LC Meter Freestyle', NULL, NULL),
(304, 51, 'Singles', NULL, NULL),
(306, 51, 'Doubles', NULL, NULL),
(307, 52, 'Singles', NULL, NULL),
(308, 52, 'mixed doubles', NULL, NULL),
(309, 52, 'Doubles', NULL, NULL),
(310, 53, 'Singles', NULL, NULL),
(311, 53, 'Mixed Doubles', NULL, NULL),
(312, 53, 'Doubles', NULL, NULL),
(313, 54, 'Singles', NULL, NULL),
(314, 54, 'mixed doubles', NULL, NULL),
(315, 54, 'Doubles', NULL, NULL),
(316, 55, 'Singles Competition', NULL, NULL),
(318, 55, 'Doubles Competition', NULL, NULL),
(319, 56, 'Singles', NULL, NULL),
(321, 56, 'Doubles', NULL, NULL),
(325, 60, 'Singles', NULL, NULL),
(327, 60, 'Doubles', NULL, NULL),
(328, 61, 'Singles', NULL, NULL),
(330, 61, 'Doubles', NULL, NULL),
(361, 65, 'Fin Weight', NULL, NULL),
(362, 65, 'Fly Weight', NULL, NULL),
(364, 65, 'Feather Weight', NULL, NULL),
(373, 66, 'VOLLEYBALL', NULL, NULL),
(374, 67, 'VOLLEYBALL', NULL, NULL),
(376, 69, 'VOLLEYBALL', NULL, NULL),
(377, 70, 'VOLLEYBALL', NULL, NULL),
(380, 41, 'V.I 100M  Dash Totally Blind', NULL, NULL),
(381, 41, 'V.I 100M Low Vision Dash', NULL, NULL),
(382, 42, 'V.I 100M Dash Totally Blind', NULL, NULL),
(384, 42, 'V.I 100M Low Vision Dash', NULL, NULL),
(393, 42, 'V.I Standing Long Jump Low Vision', NULL, NULL),
(395, 42, 'V.I Standing Long Jump Totally Blind', NULL, NULL),
(396, 41, 'V.I Standing Long Jump Low Vision', NULL, NULL),
(398, 41, 'V.I Standing Long Jump Partially Blind', NULL, NULL),
(399, 41, 'I.D 200M 15 and Below', NULL, NULL),
(400, 42, 'I.D 200M 15 and Below', NULL, NULL),
(401, 42, 'I.D 200M 16 and Above', NULL, NULL),
(402, 41, 'I.D 200M 16 and Above', NULL, NULL),
(403, 9, '800M Run', NULL, NULL),
(404, 41, 'I.D 400M 16 and Above', NULL, NULL),
(405, 41, 'I.D 400M 15 and Below', NULL, NULL),
(406, 42, 'I.D 400M 15 and Below', NULL, NULL),
(407, 42, 'I.D 400M 16 and Above', NULL, NULL),
(415, 42, 'I.D Shot Put 15 and below', NULL, NULL),
(416, 41, 'I.D Shot Put 16 Above', NULL, NULL),
(417, 41, 'I.D Shot Put 15 Below', NULL, NULL),
(418, 42, 'I.D Shot Put 16 and Above', NULL, NULL),
(419, 72, 'I.D BOCCE TEAM EVENT', NULL, NULL),
(422, 42, 'V.I Shot Put Totally Blind', NULL, NULL),
(424, 41, 'V.I Shot Put Low Vision', NULL, NULL),
(425, 42, 'V.I Shot Put Low Vision', NULL, NULL),
(427, 42, '50M Freestyle (I.D. - Open Cat.)', NULL, NULL),
(428, 42, '50M Breastroke (I.D. - Open Cat.)', NULL, NULL),
(429, 42, '50M Backstroke (I.D. - Open Cat.)', NULL, NULL),
(430, 41, '50M Backstroke', NULL, NULL),
(431, 41, '50M Breaststroke', NULL, NULL),
(432, 41, '50M Freestyle', NULL, NULL),
(433, 42, 'I.D 4x100 M Relay 16 and Above', NULL, NULL),
(434, 42, 'I.D 4x100 M Relay 15 and Below', NULL, NULL),
(435, 41, 'I.D 4x100 M Relay 15 and Below', NULL, NULL),
(436, 41, 'I.D 4x100 M Relay 16 and Above', NULL, NULL),
(437, 9, '100 M Dash', NULL, NULL),
(444, 9, '400M Hurdle', NULL, NULL),
(463, 10, '200M Dash', NULL, NULL),
(467, 38, 'DOUBLE TAKRAW', NULL, NULL),
(469, 75, 'cadets - 40Kg (13-15)', NULL, NULL),
(470, 75, 'cadets - 44Kg (13-15)', NULL, NULL),
(473, 75, 'junior - 48Kg (13-15)', NULL, NULL),
(475, 75, 'junior - 52Kg (13-15)', NULL, NULL),
(477, 75, 'cadets - 48 kgs (16-18)', NULL, NULL),
(479, 76, '8 Balls', NULL, NULL),
(480, 76, '9 Balls', NULL, NULL),
(481, 3, '70 Meters Distance', NULL, NULL),
(482, 5, 'Full Contact Pin Weight (43-47 kgs.)', NULL, NULL),
(483, 8, 'Full Contact Half Light Weight (52 - 56 kgs)', NULL, NULL),
(484, 5, 'Full Contact Feather Weight (51 - 55 kgs.)', NULL, NULL),
(485, 5, 'Full Contact Bantam Weight (47 - 51 kgs.)', NULL, NULL),
(486, 5, 'Full Contact Half Light Weight (60 - 65 kgs.)', NULL, NULL),
(487, 5, 'Full Contact Extra Light Weight (55 - 60 kgs.)', NULL, NULL),
(488, 8, 'Full Contact Feather Weight (44 - 48 kgs.)', NULL, NULL),
(489, 8, 'Full Contact Extra Light Weight (48 - 52 kgs.)', NULL, NULL),
(490, 8, 'Full Contact Bantam Weight (40 - 44 kgs.)', NULL, NULL),
(491, 77, 'CATEGORY B 42 KGS', NULL, NULL),
(492, 77, 'CATEGORY B 45 KGS', NULL, NULL),
(493, 77, 'CATEGORY A 48 KGS', NULL, NULL),
(494, 77, 'CATEGORY A 52 KGS', NULL, NULL),
(503, 31, 'MAG - Mushroom (Cluster 1)', NULL, NULL),
(504, 31, 'MAG - Floor Exercise (Cluster 1)', NULL, NULL),
(505, 31, 'MAG - Floor Exercise (Cluster 2)', NULL, NULL),
(506, 31, 'MAG - Mushroom (Cluster 2)', NULL, NULL),
(507, 31, 'MAG - Individual All Around (Cluster 2)', NULL, NULL),
(510, 32, 'WAG - Individual All Around (Cluster 1)', NULL, NULL),
(511, 32, 'WAG - Individual All Around (Cluster 2)', NULL, NULL),
(517, 32, 'WAG - Balance Beam (Cluster 1)', NULL, NULL),
(519, 32, 'WAG - Balance Beam (Cluster 2)', NULL, NULL),
(520, 32, 'WAG - Floor Exercise (Cluster 2)', NULL, NULL),
(521, 32, 'WAG - Floor Exercise (Cluster 1)', NULL, NULL),
(522, 32, 'WAG - uneven bars (cluster 2)', NULL, NULL),
(524, 6, 'Individual Likha Anyo Double Weapon', NULL, NULL),
(526, 7, 'individual Likha Anyo Single Weapon', NULL, NULL),
(528, 5, 'Individual Likha Anyo Double Weapon', NULL, NULL),
(529, 8, 'Individual Double Weapon', NULL, NULL),
(532, 65, 'POOMSAE INDIVIDUAL category A (below 59 kg)', NULL, NULL),
(533, 65, 'POOMSAE INDIVIDUAL category B (over 59 kg)', NULL, NULL),
(537, 65, 'Team Poomsae Group Girls', NULL, NULL),
(538, 62, 'Individual Poomsae Category A (128 cm-144 cm)', NULL, NULL),
(539, 62, 'Individual Poomsae Category B (over 144 cm)', NULL, NULL),
(540, 63, 'Individual Poomsae Category B (over 144 cm)', NULL, NULL),
(541, 63, 'individual Poomsae Category A (128 cm-144 cm)', NULL, NULL),
(542, 42, 'BOCCE SINGLE', NULL, NULL),
(545, 62, 'Mixed Pair Poomsae (Counted in Girls per Rules)', NULL, NULL),
(546, 41, 'BOCCE SINGLE', NULL, NULL),
(547, 63, 'Team Poomsae Girls (Group Girls)', NULL, NULL),
(549, 74, 'Cadets - 42 kgs.', NULL, NULL),
(550, 75, 'junior - 56 kgs (16-18)', NULL, NULL),
(551, 75, 'cadets - 52 kgs (16-18)', NULL, NULL),
(557, 75, 'junior - 60 kgs (16-18)', NULL, NULL),
(558, 42, 'I.D Running Long Jump 15 and Below', NULL, NULL),
(559, 42, 'I.D Running Long Jump 16 and Above', NULL, NULL),
(560, 41, 'I.D Running Long Jump 16 Above', NULL, NULL),
(561, 41, 'I.D Running Long Jump 15 and Below', NULL, NULL),
(562, 72, 'I.D BOCCE DOUBLES', NULL, NULL),
(563, 62, 'KYUROGI PLAYER 1', NULL, NULL),
(564, 62, 'KYUROGI PLAYER 3', NULL, NULL),
(565, 62, 'KYUROGI PLAYER 2', NULL, NULL),
(567, 63, 'KYUROGI player 2', NULL, NULL),
(568, 63, 'KYUROGI player 1', NULL, NULL),
(569, 62, 'Team Poomsae Boys (Group Boys)', NULL, NULL),
(571, 81, 'Tanding Boys CLASS A 42-45 KGS', NULL, NULL),
(572, 81, 'TANDING Boys CLASS B  45-48 KGS', NULL, NULL),
(573, 81, 'TANDING Boys CLASS C  48-51 KGS', NULL, NULL),
(574, 81, 'SENI Boys TUNGGAL', NULL, NULL),
(575, 81, 'SENI Boys GANDA', NULL, NULL),
(576, 81, 'REGU', NULL, NULL),
(577, 82, '42-45 KGS', NULL, NULL),
(578, 82, '45-48 KGS', NULL, NULL),
(579, 82, '48-51 KGS', NULL, NULL),
(580, 82, 'SENI Girls TUNGGAL', NULL, NULL),
(581, 82, 'SENI Girls GANDA', NULL, NULL),
(582, 82, 'REGU', NULL, NULL),
(583, 5, 'Team (Synchronized) Likha Anyo Double Weapon', NULL, NULL),
(584, 5, 'Team (Synchronized) Likha Anyo Single Weapon', NULL, NULL),
(585, 5, 'Individual Likha Espada y Daga', NULL, NULL),
(586, 6, 'Team (synchronized)  likha anyo Single Weapon', NULL, NULL),
(587, 8, 'Team (Synchronized) Likha Anyo Single Weapon', NULL, NULL),
(588, 6, 'Individual Likha Anyo Espada Y Daga', NULL, NULL),
(589, 8, 'Team (Synchronized) Likha Anyo Double Weapon', NULL, NULL),
(591, 8, 'Team (Synchronized) Likha Anyo Espada y Daga', NULL, NULL),
(592, 7, 'Team (Synchronized) Likha Anyo Single Weapon', NULL, NULL),
(593, 8, 'INDIVIDUAL likha ESPADA Y DAGA', NULL, NULL),
(594, 7, 'Individual Likha Anyo Espada y Daga', NULL, NULL),
(595, 5, 'Team (Synchronized) Likha Anyo Espada y Daga', NULL, NULL),
(596, 6, 'Team (synchronized) likha anyo Double Weapon', NULL, NULL),
(598, 6, 'TEAM (synchronized) likha anyo ESPADA Y DAGA', NULL, NULL),
(599, 6, 'Team (Mixed) Likha Anyo Double Weapon', NULL, NULL),
(600, 7, 'Team (Synchronized) Likha Anyo Espada y Daga', NULL, NULL),
(601, 32, 'WAG - VAULT (Cluster 1)', NULL, NULL),
(602, 32, 'WAG - VAULT (Cluster 2)', NULL, NULL),
(604, 83, 'Junior (Standard) Quickstep', NULL, NULL),
(605, 83, 'Junior (Standard) Tango', NULL, NULL),
(606, 83, 'Junior (Standard) Waltz', NULL, NULL),
(607, 83, 'Junior (Latin) Cha Cha Rumba Jive', NULL, NULL),
(609, 83, 'Junior (Latin) Cha Cha Cha', NULL, NULL),
(610, 84, 'Juvenile (Standard) Waltz', NULL, NULL),
(611, 84, 'Juvenile (Standard) Quick Step', NULL, NULL),
(612, 84, 'Juvenile (Standard) Tango', NULL, NULL),
(613, 84, 'Juvenile (Latin) Jive', NULL, NULL),
(614, 84, 'Juvenile (Latin) Cha Cha Cha', NULL, NULL),
(615, 84, 'Juvenile (Latin) Samba', NULL, NULL),
(616, 72, 'V.I Goal Ball', NULL, NULL),
(617, 38, 'Team Regu', NULL, NULL),
(618, 14, 'individual Doubles', NULL, NULL),
(619, 13, 'individual Singles', NULL, NULL),
(620, 13, 'Individual Doubles', NULL, NULL),
(621, 14, 'individual Singles', NULL, NULL),
(622, 13, 'Individual Mixed Doubles', NULL, NULL),
(623, 16, 'Individual Singles', NULL, NULL),
(624, 16, 'Team Tie', NULL, NULL),
(625, 16, 'Individual Doubles', NULL, NULL),
(626, 15, 'individual singles', NULL, NULL),
(627, 15, 'individual doubles', NULL, NULL),
(628, 15, 'team tie', NULL, NULL),
(629, 14, 'team tie', NULL, NULL),
(644, 65, 'Light Weight', NULL, NULL),
(645, 65, 'Welter Weight', NULL, NULL),
(646, 65, 'light middle Weight', NULL, NULL),
(648, 64, 'Finweight', NULL, NULL),
(649, 65, 'Bantam Weight', NULL, NULL),
(655, 23, 'Bantam Weight 17-18 years old (56kg.)', NULL, NULL),
(656, 23, '54-56 Kg Lightweight (Youth Boys)', NULL, NULL),
(657, 23, 'Light Weight 17-18 years old (60kg.)', NULL, NULL),
(659, 23, 'Light Flyweight 14-16 years old (48kg.)', NULL, NULL),
(660, 23, 'Flyweight 14-16 years old (50kg.)', NULL, NULL),
(661, 23, 'Light Bantam Weight 17-18 years old (54kg.)', NULL, NULL),
(662, 33, 'Floor Exercise', NULL, NULL),
(663, 31, 'MAG - Vault (Cluster 1)', NULL, NULL),
(664, 31, 'MAG - Vault (Cluster 2)', NULL, NULL),
(668, 23, 'Bantam Weight 14-16 years old (54kg.)', NULL, NULL),
(669, 23, 'Flyweight 17-18 years old (52kg.)', NULL, NULL),
(673, 3, 'Team Event (70 meters)', NULL, NULL),
(674, 4, 'Team (60m)', NULL, NULL),
(675, 3, 'Olympic Round (70 meters)', NULL, NULL),
(676, 4, 'Olympic Round (60m)', NULL, NULL),
(677, 3, 'Mixed Team (60 meters)', NULL, NULL),
(679, 78, 'Group B - under 42 kgs.', NULL, NULL),
(680, 43, '200 LC Meter Freestyle', NULL, NULL),
(681, 44, '13 & Under 200 LC Meter Freestyle', NULL, NULL),
(684, 43, '100 LC Meter Backstroke', NULL, NULL),
(685, 44, '13 & Under 100 LC Meter Backstroke', NULL, NULL),
(688, 43, '50 LC Meter Butterfly', NULL, NULL),
(689, 44, '13 & Under 50 LC Meter Butterfly', NULL, NULL),
(692, 43, '100 LC Meter Freestyle', NULL, NULL),
(693, 44, '13 & under 100 LC Meter Freestyle', NULL, NULL),
(695, 44, '13 & Under 4x50 LC Meter Medley Relay', NULL, NULL),
(700, 43, '50 LC Meter Breastsroke', NULL, NULL),
(701, 44, '13 & Under 50 LC Meter Breaststroke', NULL, NULL),
(704, 44, '13 & under 400 LC Meter Medley Relay', NULL, NULL),
(705, 44, '13 & under 400 LC Meter Freestyle', NULL, NULL),
(706, 43, '400 LC Meter Freestyle', NULL, NULL),
(707, 43, '50 LC Meter Backstroke', NULL, NULL),
(708, 44, '13 & under 50 LC Meter Backstroke', NULL, NULL),
(713, 43, '50 LC Meter Freestyle', NULL, NULL),
(715, 44, '13 & under 50 LC Meter Freestyle', NULL, NULL),
(720, 43, '100 LC Meter Breastroke', NULL, NULL),
(721, 44, '13 & under 100 LC Meter Breaststroke', NULL, NULL),
(723, 43, '100 LC Meter Butterfly', NULL, NULL),
(724, 44, '13 & Under 100 LC Meter Butterfly', NULL, NULL),
(730, 44, '13 & Under 4x50 LC Meter Freestyle Relay', NULL, NULL),
(732, 44, '13 & Under 400 LC Meter Freestyle Relay', NULL, NULL),
(739, 12, '100M Hurdles', NULL, NULL),
(742, 42, 'Shot Put Partially Blind', NULL, NULL),
(743, 41, 'V.I Standing Long Jump Totally Blind', NULL, NULL),
(744, 42, 'V.I Standing Long Jump Partially Blind', NULL, NULL),
(745, 8, 'Individual Likha Anyo Single Weapon', NULL, NULL),
(746, 6, 'Individual Likha Anyo Single Weapon', NULL, NULL),
(747, 5, 'Individual Likha Anyo Single Weapon', NULL, NULL),
(748, 42, '100 Meter Dash 15 and Below', NULL, NULL),
(749, 41, '100 Meter Dash 15 and Below', NULL, NULL),
(750, 42, 'V.I. 100 Meter Dash Partially Blind', NULL, NULL),
(751, 41, 'V.I. Shot Put Partially Blind', NULL, NULL),
(752, 41, 'V.I. Shot Put Totally Blind', NULL, NULL),
(753, 42, 'I.D. 100 Meter Dash 16 and Above', NULL, NULL),
(754, 41, 'I.D 100 Meter Dash 16 and Above', NULL, NULL),
(755, 7, 'Team (Synchronized Mixed) Likha Anyo Double Weapon', NULL, NULL),
(756, 41, 'V.I. 100 Meter Dash Partially Blind', NULL, NULL),
(757, 32, 'WAG uneven bars (Cluster 1)', NULL, NULL),
(764, 11, '2000-Meter Walk', NULL, NULL),
(765, 12, '2000M Walk', NULL, NULL),
(767, 35, 'Regu Competition', NULL, NULL),
(768, 82, '39-42 KGS', NULL, NULL),
(769, 82, '51-54 KGS', NULL, NULL),
(770, 81, 'TANDING Boys CLASS  D 51-54 KGS', NULL, NULL),
(771, 81, 'TANDING Boys CLASS E 54-57 KGS', NULL, NULL),
(772, 12, '3000M Run', NULL, NULL),
(774, 32, 'Aerobic Gymnastics - Individual', NULL, NULL),
(776, 32, 'Aerobic Gymnastics - Trio', NULL, NULL),
(783, 84, 'Juvenile (Standard) Grade C', NULL, NULL),
(784, 83, 'Grade C Latin Junior', NULL, NULL),
(785, 83, 'Grade C Junior Standard', NULL, NULL),
(789, 84, 'Grade C (Latin)', NULL, NULL),
(791, 21, '3X3', NULL, NULL),
(792, 20, '3X3', NULL, NULL),
(796, 7, 'Individual Likha Anyo Double Weapon', NULL, NULL),
(801, 83, 'C (Standard) Waltz  Tango Quickstep', NULL, NULL),
(802, 83, 'C. Latin Cha Cha Rumba Jive', NULL, NULL),
(803, 82, 'TANDING Girls Class A', NULL, NULL),
(804, 82, 'TANDING Girls Class B', NULL, NULL),
(805, 82, 'TANDING Girls Class C', NULL, NULL),
(806, 82, 'TANDING Girls Class D', NULL, NULL),
(807, 82, 'TANDING Girls Class E', NULL, NULL),
(808, 9, '200m dash', NULL, NULL),
(809, 9, '400m dash', NULL, NULL),
(810, 9, '4 x 100m relay', NULL, NULL),
(811, 9, '4 x 400m relay', NULL, NULL),
(812, 14, 'individual mixed doubles', NULL, NULL),
(813, 31, 'Horizontal Bar (cluster 1)', NULL, NULL),
(814, 31, 'Horizontal Bar (cluster 2)', NULL, NULL),
(815, 43, '200 LC Meter Individual Medley', NULL, NULL),
(816, 43, '400 LC Meter Freestyle Relay', NULL, NULL),
(817, 43, '400 LC Meter Medley Relay', NULL, NULL),
(818, 43, '200 LC Meter Freestyle Relay', NULL, NULL),
(819, 43, '200 LC Meter Medley Relay', NULL, NULL),
(820, 42, 'Boys S7 (O.H. - Single Below Knee) shot put', NULL, NULL),
(821, 42, 'Boys S8 (O.H. - Single Above Knee) shot put', NULL, NULL),
(822, 42, 'Boys S9 (O.H. - Open Cat.) shot put', NULL, NULL),
(823, 42, 'Boys S10 (O.H. - Open Cat.) shot put', NULL, NULL),
(824, 41, 'Girls S7 (O.H. - Single Below Knee) shot put', NULL, NULL),
(825, 41, 'Girls S8 (O.H. - Single Above Knee) shot put', NULL, NULL),
(826, 41, 'Girls S9 (O.H. - Double Below Knee) shot put', NULL, NULL),
(827, 41, 'Girls S10 (O.H. - Single Below Knee & Above Knee)  shot put', NULL, NULL),
(828, 41, 'Girls S11 (O.H. - Special Participation)  shot put', NULL, NULL),
(829, 41, 'Girls S12 (O.H. - Special Participation) shot put', NULL, NULL),
(832, 42, '50m freestyle (O.H. - Single Above)', NULL, NULL),
(833, 42, '50m freestyle (O.H. - Single Below)', NULL, NULL),
(834, 42, '50m freestyle (O.H. - Double Above)', NULL, NULL),
(835, 42, '50m freestyle (O.H. - Double Below)', NULL, NULL),
(836, 41, '50m freestyle (O.H. - Single Above)', NULL, NULL),
(837, 41, '50m freestyle (O.H. - Single Below)', NULL, NULL),
(838, 41, '50m freestyle (O.H. - Double Above)', NULL, NULL),
(839, 41, '50m freestyle (O.H. - Double Below)', NULL, NULL),
(840, 42, '50m backstroke (O.H. - Single Above)', NULL, NULL),
(841, 42, '50m backstroke (O.H. - Single Below)', NULL, NULL),
(842, 42, '50m backstroke (O.H. - Double Above)', NULL, NULL),
(843, 42, '50m backstroke (O.H. - Double Below)', NULL, NULL),
(844, 41, '50m backstroke (O.H. - Single Above)', NULL, NULL),
(845, 41, '50m backstroke (O.H. - Single Below)', NULL, NULL),
(846, 41, '50m backstroke (O.H. - Double Below)', NULL, NULL),
(847, 41, '50m backstroke (O.H. - Double Above)', NULL, NULL),
(848, 42, '50m breastroke (O.H. - Single Above)', NULL, NULL),
(849, 42, '50m breastroke (O.H. - Single Below)', NULL, NULL),
(850, 42, '50m breastroke  (O.H. - Double Above)', NULL, NULL),
(851, 42, '50m breastroke (O.H. - Double Below)', NULL, NULL),
(852, 41, '50m breastroke (O.H. - Single Above)', NULL, NULL),
(853, 41, '50m breastroke (O.H. - Single Below)', NULL, NULL),
(854, 41, '50m breastroke (O.H. - Double Below)', NULL, NULL),
(855, 51, 'Mixed Doubles', NULL, NULL),
(856, 51, 'Team', NULL, NULL),
(857, 55, 'Team Competition', NULL, NULL),
(858, 7, 'Team (Synchronized) Likha Anyo Double Weapon', NULL, NULL),
(859, 13, 'Team Tie', NULL, NULL),
(861, 32, 'Individual All Around (CLUSTER 1)', NULL, NULL),
(862, 32, 'Individual All Around (cluster 2)', NULL, NULL),
(863, 32, 'team championship', NULL, NULL),
(864, 11, 'Pole Vault', NULL, NULL),
(865, 52, 'team', NULL, NULL),
(866, 16, 'Individual Mixed Doubles', NULL, NULL),
(867, 63, 'kyorugi player 3', NULL, NULL),
(868, 63, 'Mixed Pair Poomsae', NULL, NULL),
(869, 56, 'Team Competition', NULL, NULL),
(870, 4, 'mixed team (60m)', NULL, NULL),
(871, 33, 'Vault', NULL, NULL),
(872, 33, 'Mushroom', NULL, NULL),
(873, 33, 'Horizontal Bar', NULL, NULL),
(874, 33, 'Individual All Around', NULL, NULL),
(876, 45, '100 LC Meter Backstroke', NULL, NULL),
(877, 45, '200 LC Meter Butterfly', NULL, NULL),
(878, 45, '200 LC Meter Individual Medley', NULL, NULL),
(879, 45, '200 LC Meter Breaststroke', NULL, NULL),
(880, 45, '50 LC Meter Butterfly', NULL, NULL),
(881, 45, '50 LC Meter Breaststroke', NULL, NULL),
(882, 45, '50 LC Meter Backstroke', NULL, NULL),
(883, 45, '50 LC Meter Freestyle', NULL, NULL),
(884, 45, '1500 LC Meter Freestyle', NULL, NULL),
(885, 45, '100 LC Meter Freestyle', NULL, NULL),
(886, 45, '100 LC Meter Butterfly', NULL, NULL),
(887, 15, 'individual mixed doubles', NULL, NULL),
(888, 45, '200 LC Meter Backstroke', NULL, NULL),
(889, 45, '100 LC Meter Breaststroke', NULL, NULL),
(890, 45, '200 LC Meter Freestyle', NULL, NULL),
(891, 45, '400 LC Meter Freestyle Relay', NULL, NULL),
(892, 45, '400 LC Meter Individual Medley', NULL, NULL),
(893, 45, '400 LC Meter Medley Relay', NULL, NULL),
(894, 45, '200 LC Meter Freestyle Relay', NULL, NULL),
(895, 45, '200 LC Meter Medley Relay', NULL, NULL),
(896, 53, 'Team', NULL, NULL),
(897, 64, 'Flyweight', NULL, NULL),
(898, 64, 'Bantamweight', NULL, NULL),
(899, 64, 'Featherweight', NULL, NULL),
(900, 64, 'Lightweight', NULL, NULL),
(901, 64, 'Welter Weight', NULL, NULL),
(902, 64, 'Light Middle Weight', NULL, NULL),
(903, 64, 'Middle Weight', NULL, NULL),
(904, 64, 'Light Heavyweight', NULL, NULL),
(905, 64, 'Heavy Weight', NULL, NULL),
(906, 64, 'Individual Poomsae Category A (below 59 kg)', NULL, NULL),
(907, 64, 'Individual Poomsae Category B (over 59 kg)', NULL, NULL),
(908, 64, 'Team Poomsae Group Boys', NULL, NULL),
(909, 64, 'Mixed Pair Poomsae (Counted in Girls per Rules)', NULL, NULL),
(910, 60, 'Team Competition', NULL, NULL),
(911, 78, 'Group B - 42 kgs. - 45 kgs.', NULL, NULL),
(912, 78, 'Group B - 45 kgs. - 48 kgs.', NULL, NULL),
(913, 78, 'Group A - 45 kgs. - 48 kgs.', NULL, NULL),
(914, 78, 'Group A - 48 kgs. - 52 kgs.', NULL, NULL),
(915, 78, 'Group A - 52 kgs. - 56 kgs.', NULL, NULL),
(916, 74, 'Cadets - 46 kgs.', NULL, NULL),
(917, 74, 'Cadets - 50 kgs.', NULL, NULL),
(918, 74, 'Cadets - 54 kgs.', NULL, NULL),
(919, 74, 'Junior - 54 kgs.', NULL, NULL),
(920, 74, 'Junior - 58 kgs.', NULL, NULL),
(921, 74, 'Junior - 62 kgs.', NULL, NULL),
(922, 74, 'Junior - 66 kgs.', NULL, NULL),
(923, 34, 'rg rope', NULL, NULL),
(924, 34, 'rg ribbon', NULL, NULL),
(925, 34, 'rg ball', NULL, NULL),
(926, 34, 'rg clubs', NULL, NULL),
(927, 33, 'rg individual all around', NULL, NULL),
(928, 33, 'rg team championship', NULL, NULL),
(929, 34, 'wag-vault', NULL, NULL),
(930, 34, 'wag - uneven bars', NULL, NULL),
(931, 34, 'wag - balance beam', NULL, NULL),
(932, 34, 'wag - floor exercise', NULL, NULL),
(933, 34, 'wag - individual all around', NULL, NULL),
(934, 34, 'wag - team championship', NULL, NULL),
(935, 46, '400 LC Meter Freestyle', NULL, NULL),
(936, 46, '100 LC Meter Backstroke', NULL, NULL),
(937, 46, '200 LC Meter Butterfly', NULL, NULL),
(938, 46, '200 LC Meter Individual Medley', NULL, NULL),
(939, 46, '200 LC Meter Breaststroke', NULL, NULL),
(940, 46, '50 LC Meter Butterfly', NULL, NULL),
(941, 46, '50 LC Meter Breaststroke', NULL, NULL),
(942, 46, '50 LC Meter Backstroke', NULL, NULL),
(943, 46, '50 LC Meter Freestyle', NULL, NULL),
(944, 46, '100 LC Meter Freestyle', NULL, NULL),
(945, 46, '100 LC Meter Butterfly', NULL, NULL),
(946, 46, '200 LC Meter Backstroke', NULL, NULL),
(947, 46, '100 LC Meter Breastroke', NULL, NULL),
(948, 46, '200 LC Meter Freestyle', NULL, NULL),
(949, 46, '800 LC Meter Freestyle', NULL, NULL),
(950, 46, '400 LC Meter Freestyle Relay', NULL, NULL),
(951, 46, '400 LC Meter Individual Medley', NULL, NULL),
(952, 46, '400 LC Meter Medley Relay', NULL, NULL),
(953, 46, '200 LC Meter Freestyle Relay', NULL, NULL),
(954, 46, '200 LC Meter Medley Relay', NULL, NULL),
(955, 54, 'team', NULL, NULL),
(956, 65, 'middle weight', NULL, NULL),
(957, 65, 'heavy weight', NULL, NULL),
(958, 65, 'light heavy weight', NULL, NULL),
(959, 65, 'Mixed Pair Poomsae', NULL, NULL),
(960, 61, 'team compitation', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gold_winners`
--

CREATE TABLE `tbl_gold_winners` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `score_gold_id` int NOT NULL,
  `name` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scores`
--

CREATE TABLE `tbl_scores` (
  `id` int NOT NULL,
  `sub_category_id` int NOT NULL,
  `gold` int NOT NULL,
  `encoded_by` int NOT NULL,
  `encoded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score_bronzes`
--

CREATE TABLE `tbl_score_bronzes` (
  `id` int NOT NULL,
  `sub_category_id` int NOT NULL,
  `bronze` int NOT NULL,
  `encoded_by` int NOT NULL,
  `encoded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score_silvers`
--

CREATE TABLE `tbl_score_silvers` (
  `id` int NOT NULL,
  `sub_category_id` int NOT NULL,
  `silver` int NOT NULL,
  `encoded_by` int NOT NULL,
  `encoded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_silver_winners`
--

CREATE TABLE `tbl_silver_winners` (
  `id` int NOT NULL,
  `event_id` int NOT NULL,
  `score_silver_id` int NOT NULL,
  `name` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teams`
--

CREATE TABLE `tbl_teams` (
  `id` int NOT NULL,
  `team_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_teams`
--

INSERT INTO `tbl_teams` (`id`, `team_name`) VALUES
(1, 'AGUSAN DEL NORTE'),
(2, 'AGUSAN DEL SUR'),
(3, 'BAYUGAN CITY'),
(4, 'BISLIG CITY'),
(5, 'BUTUAN CITY'),
(6, 'CABADBARAN CITY'),
(7, 'DINAGAT ISLANDS'),
(8, 'SIARGAO ISLAND'),
(9, 'SURIGAO CITY'),
(10, 'SURIGAO DEL NORTE'),
(11, 'SURIGAO DEL SUR'),
(12, 'TANDAG CITY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `profile_picture`, `email`, `sex`, `bday`, `contact`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `created_at`, `updated_at`, `google_id`, `facebook_id`) VALUES
(1, 'Administrator', '1.png', 'admin@admin.com', NULL, NULL, NULL, NULL, '$2y$10$T.EPHUvQ.KtJrWnmaBdcCuhu/M9qgFi.ZzJ3MjkY8sxj.cL2Jki0C', NULL, NULL, NULL, NULL, '2023-01-17 05:23:15', '2023-03-31 06:56:10', '104844677583640629664', NULL),
(2, 'User 3 - Encoder', '2.jpg', 'user3@gmail.com', 'male', '2023-02-01', 'none', NULL, '$2y$10$DGOprUimhy1bYYuFEKF.keMYIHyy200OSUKy1d7yQ/ef0yUnAWLEu', NULL, NULL, NULL, NULL, NULL, '2023-03-31 06:55:49', NULL, NULL),
(3, 'User2 - Validator', NULL, 'user2@user2.com', NULL, NULL, NULL, NULL, '$2y$10$4d2EdjDCZ9HD8.wELW3S7.V.ESJowfZsiRAqavjLUg.xrnew2mjeO', NULL, NULL, NULL, NULL, '2023-02-10 08:22:01', '2023-03-31 06:55:27', NULL, NULL),
(4, 'User1 - Encoder', NULL, 'user@user.com', NULL, NULL, NULL, NULL, '$2y$10$ZrJ2Q/lvj5Qf.KU2m2bLKegF1Pz9UEJGCtrmU6ADdV7FmfjacDLfK', NULL, NULL, NULL, NULL, '2023-02-10 08:22:30', '2023-03-31 06:55:12', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bronze_winners`
--
ALTER TABLE `tbl_bronze_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `score_bronze_id` (`score_bronze_id`);

--
-- Indexes for table `tbl_coach_bronzes`
--
ALTER TABLE `tbl_coach_bronzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_bronze_id` (`score_bronze_id`);

--
-- Indexes for table `tbl_coach_golds`
--
ALTER TABLE `tbl_coach_golds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_coach_golds_ibfk_1` (`score_gold_id`);

--
-- Indexes for table `tbl_coach_silvers`
--
ALTER TABLE `tbl_coach_silvers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_silver_id` (`score_silver_id`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_event_categories`
--
ALTER TABLE `tbl_event_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `tbl_event_sub_categories`
--
ALTER TABLE `tbl_event_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_gold_winners`
--
ALTER TABLE `tbl_gold_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `tbl_gold_winners_ibfk_1` (`score_gold_id`);

--
-- Indexes for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `gold` (`gold`),
  ADD KEY `encoded_by` (`encoded_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_score_bronzes`
--
ALTER TABLE `tbl_score_bronzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `gold` (`bronze`),
  ADD KEY `encoded_by` (`encoded_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_score_silvers`
--
ALTER TABLE `tbl_score_silvers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_category_id` (`sub_category_id`),
  ADD KEY `gold` (`silver`),
  ADD KEY `encoded_by` (`encoded_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `tbl_silver_winners`
--
ALTER TABLE `tbl_silver_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `score_silver_id` (`score_silver_id`);

--
-- Indexes for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_bronze_winners`
--
ALTER TABLE `tbl_bronze_winners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coach_bronzes`
--
ALTER TABLE `tbl_coach_bronzes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_coach_golds`
--
ALTER TABLE `tbl_coach_golds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_coach_silvers`
--
ALTER TABLE `tbl_coach_silvers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_events`
--
ALTER TABLE `tbl_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_event_categories`
--
ALTER TABLE `tbl_event_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tbl_event_sub_categories`
--
ALTER TABLE `tbl_event_sub_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=961;

--
-- AUTO_INCREMENT for table `tbl_gold_winners`
--
ALTER TABLE `tbl_gold_winners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_score_bronzes`
--
ALTER TABLE `tbl_score_bronzes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_score_silvers`
--
ALTER TABLE `tbl_score_silvers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_silver_winners`
--
ALTER TABLE `tbl_silver_winners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_teams`
--
ALTER TABLE `tbl_teams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_bronze_winners`
--
ALTER TABLE `tbl_bronze_winners`
  ADD CONSTRAINT `tbl_bronze_winners_ibfk_1` FOREIGN KEY (`score_bronze_id`) REFERENCES `tbl_score_bronzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_coach_bronzes`
--
ALTER TABLE `tbl_coach_bronzes`
  ADD CONSTRAINT `tbl_coach_bronzes_ibfk_1` FOREIGN KEY (`score_bronze_id`) REFERENCES `tbl_score_bronzes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_coach_golds`
--
ALTER TABLE `tbl_coach_golds`
  ADD CONSTRAINT `tbl_coach_golds_ibfk_1` FOREIGN KEY (`score_gold_id`) REFERENCES `tbl_scores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_coach_silvers`
--
ALTER TABLE `tbl_coach_silvers`
  ADD CONSTRAINT `tbl_coach_silvers_ibfk_1` FOREIGN KEY (`score_silver_id`) REFERENCES `tbl_score_silvers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_event_sub_categories`
--
ALTER TABLE `tbl_event_sub_categories`
  ADD CONSTRAINT `tbl_event_sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_event_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_gold_winners`
--
ALTER TABLE `tbl_gold_winners`
  ADD CONSTRAINT `tbl_gold_winners_ibfk_1` FOREIGN KEY (`score_gold_id`) REFERENCES `tbl_scores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  ADD CONSTRAINT `tbl_scores_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `tbl_event_sub_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tbl_scores_ibfk_2` FOREIGN KEY (`gold`) REFERENCES `tbl_teams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_score_bronzes`
--
ALTER TABLE `tbl_score_bronzes`
  ADD CONSTRAINT `tbl_score_bronzes_ibfk_1` FOREIGN KEY (`sub_category_id`) REFERENCES `tbl_event_sub_categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tbl_silver_winners`
--
ALTER TABLE `tbl_silver_winners`
  ADD CONSTRAINT `tbl_silver_winners_ibfk_1` FOREIGN KEY (`score_silver_id`) REFERENCES `tbl_score_silvers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
