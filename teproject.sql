-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 06:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `year` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `name`, `year`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1st year 1st semester', '2025', NULL, NULL, NULL, NULL),
(2, '1st year 2nd semester', '2025', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-adbullah@gmail.com|127.0.0.1', 'i:1;', 1753975533),
('laravel-cache-adbullah@gmail.com|127.0.0.1:timer', 'i:1753975533;', 1753975533),
('laravel-cache-ali@gmail.com|127.0.0.1', 'i:1;', 1753886639),
('laravel-cache-ali@gmail.com|127.0.0.1:timer', 'i:1753886639;', 1753886639),
('laravel-cache-arafat@gmail.com|127.0.0.1', 'i:1;', 1753968693),
('laravel-cache-arafat@gmail.com|127.0.0.1:timer', 'i:1753968693;', 1753968693),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:13:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:9:\"role_list\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"role_create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:9:\"role_edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"role_delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:20:\"role_permission_edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"admin_create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:18:\"student_evaluation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:18:\"teacher_evaluation\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"course_upload\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:21:\"department_management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"batch_management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"course_management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:19:\"question_management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"SuperAdmin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"Student\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:7:\"Teacher\";s:1:\"c\";s:3:\"web\";}}}', 1754062686);

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Into to computer', 'cse001', NULL, NULL, '2025-07-26 09:45:54', '2025-07-26 09:45:54'),
(2, 'Computer Funamental', 'cse002', NULL, NULL, '2025-07-27 09:17:58', '2025-07-27 09:17:58'),
(3, 'Computer Funamental 202', 'cse00222', NULL, NULL, '2025-07-27 09:25:24', '2025-07-27 09:25:24'),
(4, 'Math', 'math001', NULL, NULL, '2025-07-27 09:30:30', '2025-07-27 09:30:30');

-- --------------------------------------------------------

--
-- Table structure for table `course_evaluation_comments`
--

CREATE TABLE `course_evaluation_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `comment_data` text DEFAULT NULL,
  `year` year(4) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_evaluation_comments`
--

INSERT INTO `course_evaluation_comments` (`id`, `department_id`, `teacher_id`, `student_id`, `course_id`, `comment_data`, `year`, `batch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(7, 1, 26, 2, 1, 'JRSFJRTSJJHSJHJDHG', '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(8, 1, 26, 2, 2, 'GHDFGDHGHGFHGF', '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `course_evaluation_data`
--

CREATE TABLE `course_evaluation_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `department_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `ratting` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_evaluation_data`
--

INSERT INTO `course_evaluation_data` (`id`, `department_id`, `teacher_id`, `student_id`, `course_id`, `question_id`, `ratting`, `year`, `batch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(55, 1, 26, 2, 1, 2, 4, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(56, 1, 26, 2, 1, 3, 5, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(57, 1, 26, 2, 1, 4, 4, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(58, 1, 26, 2, 1, 5, 5, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(59, 1, 26, 2, 1, 6, 3, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(60, 1, 26, 2, 1, 7, 5, '2025', 1, 2, 2, '2025-07-31 09:53:33', '2025-07-31 09:53:33'),
(61, 1, 26, 2, 2, 2, 5, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(62, 1, 26, 2, 2, 3, 4, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(63, 1, 26, 2, 2, 4, 5, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(64, 1, 26, 2, 2, 5, 4, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(65, 1, 26, 2, 2, 6, 3, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(66, 1, 26, 2, 2, 7, 5, '2025', 1, 2, 2, '2025-07-31 09:53:51', '2025-07-31 09:53:51'),
(67, 1, 26, 2, 4, 2, 5, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07'),
(68, 1, 26, 2, 4, 3, 4, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07'),
(69, 1, 26, 2, 4, 4, 5, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07'),
(70, 1, 26, 2, 4, 5, 4, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07'),
(71, 1, 26, 2, 4, 6, 5, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07'),
(72, 1, 26, 2, 4, 7, 4, '2025', 1, 2, 2, '2025-07-31 09:54:07', '2025-07-31 09:54:07');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Department of Computer Science', 'CSE', NULL, NULL, NULL, NULL),
(2, 'Department of Social Science', 'SS', NULL, NULL, NULL, NULL),
(5, 'Department Of English', 'ENG', NULL, NULL, '2025-07-28 07:29:39', '2025-07-28 07:29:39');

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
(4, '2025_07_22_145818_create_permission_tables', 1),
(5, '2025_07_22_161707_create_personal_access_tokens_table', 1),
(6, '2025_07_25_141306_create_questions_table', 1),
(7, '2025_07_26_112526_create_departments_table', 1),
(8, '2025_07_26_112534_create_courses_table', 1),
(9, '2025_07_26_112543_create_batches_table', 1),
(10, '2025_07_26_113554_create_teacher_wise_courses_table', 1),
(11, '2025_07_26_113603_create_student_wise_courses_table', 1),
(14, '2025_07_30_162503_create_course_evaluation_data_table', 2),
(15, '2025_07_30_162920_create_course_evaluation_comments_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 26),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 21),
(3, 'App\\Models\\User', 22),
(3, 'App\\Models\\User', 23);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role_list', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(2, 'role_create', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(3, 'role_edit', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(4, 'role_delete', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(5, 'role_permission_edit', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(6, 'admin_create', 'web', '2025-07-31 08:58:45', '2025-07-31 08:58:45'),
(7, 'student_evaluation', 'web', '2025-07-31 08:58:59', '2025-07-31 08:58:59'),
(8, 'teacher_evaluation', 'web', '2025-07-31 08:59:11', '2025-07-31 08:59:11'),
(9, 'course_upload', 'web', '2025-07-31 09:01:25', '2025-07-31 09:01:25'),
(10, 'department_management', 'web', '2025-07-31 09:03:43', '2025-07-31 09:03:43'),
(11, 'batch_management', 'web', '2025-07-31 09:03:52', '2025-07-31 09:03:52'),
(12, 'course_management', 'web', '2025-07-31 09:04:00', '2025-07-31 09:04:00'),
(13, 'question_management', 'web', '2025-07-31 09:04:45', '2025-07-31 09:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `created_at`, `updated_at`) VALUES
(2, 'Classes of this section as per schedule began and ended on time', '2025-07-30 08:04:28', '2025-07-30 08:04:28'),
(3, 'The faculty member was available during student consultation hours', '2025-07-30 08:04:38', '2025-07-30 08:04:38'),
(4, 'While consulting, the faculty member was helpful', '2025-07-30 08:05:20', '2025-07-30 08:05:20'),
(5, 'The faculty member was adequately prepared for the class', '2025-07-30 08:05:38', '2025-07-30 08:05:38'),
(6, 'The faculty member had good command over the subject matter of the course', '2025-07-30 08:05:55', '2025-07-30 08:05:55'),
(7, 'The faculty member\'s communication and delivery skills were very good', '2025-07-30 08:06:06', '2025-07-30 08:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'web', '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(2, 'Teacher', 'web', '2025-07-26 09:45:28', '2025-07-26 09:45:28'),
(3, 'Student', 'web', '2025-07-26 09:45:39', '2025-07-26 09:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 3),
(8, 2),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1);

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
('W7jWQikBuZE7FcaquJhBLFzPAgD9IpbFIaNqVnPc', 26, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 13; Pixel 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaWxqVkhZNTV6N25jeFRuUmRQMTFRcE9uRW1ad3ZzTFhFYnFnODZJWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ldmFsdWF0aW9uL3RlYWNoZXIiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyNjtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTM5NzczMDE7fX0=', 1753977486);

-- --------------------------------------------------------

--
-- Table structure for table `student_wise_courses`
--

CREATE TABLE `student_wise_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_wise_courses`
--

INSERT INTO `student_wise_courses` (`id`, `student_id`, `course_id`, `department_id`, `year`, `batch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(25, 17, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(26, 18, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(27, 19, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(28, 20, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(29, 21, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(30, 22, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:56', '2025-07-30 07:28:56'),
(31, 23, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:56', '2025-07-30 07:28:56'),
(32, 17, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:21', '2025-07-30 07:59:21'),
(33, 18, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:21', '2025-07-30 07:59:21'),
(34, 19, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:21', '2025-07-30 07:59:21'),
(35, 20, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:22', '2025-07-30 07:59:22'),
(36, 21, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:22', '2025-07-30 07:59:22'),
(37, 22, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:22', '2025-07-30 07:59:22'),
(38, 23, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:22', '2025-07-30 07:59:22'),
(39, 2, 2, 1, '2025', 1, 1, 1, '2025-07-30 08:46:00', '2025-07-30 08:46:00'),
(40, 2, 1, 1, '2025', 1, 2, 2, '2025-07-30 08:53:25', '2025-07-30 08:53:25'),
(41, 2, 4, 1, '2025', 1, 2, 2, '2025-07-30 08:53:58', '2025-07-30 08:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_wise_courses`
--

CREATE TABLE `teacher_wise_courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `year` year(4) NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_wise_courses`
--

INSERT INTO `teacher_wise_courses` (`id`, `teacher_id`, `course_id`, `department_id`, `year`, `batch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 26, 1, 1, '2025', 1, 1, 1, '2025-07-30 07:28:54', '2025-07-30 07:28:54'),
(6, 26, 1, 2, '2025', 1, 1, 1, '2025-07-30 07:59:21', '2025-07-30 07:59:21'),
(7, 26, 2, 1, '2025', 1, 1, 1, '2025-07-30 08:46:00', '2025-07-30 08:46:00'),
(8, 26, 4, 1, '2025', 1, 2, 2, '2025-07-30 09:37:53', '2025-07-30 09:37:53');

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
  `dept_id` int(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `dept_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SuperAdmin', 'superadminuser@gmail.com', '2025-07-26 09:31:30', '$2y$12$aONIDN6S2Z.1razoVoxv7uDOpcbLZyQ45obAPPf/vadoW3BqVdzNa', NULL, NULL, '2025-07-26 09:31:30', '2025-07-26 09:31:30'),
(2, 'SM RAKIBUL ISLAM NAIM', 'nayeem373737@gmail.com', NULL, '$2y$12$Okhysd0H0o2mxUqk660sjOwPP.8SBkcNplWjJi50EjzvqE4V7e7hW', 1, NULL, '2025-07-26 09:35:24', '2025-07-26 09:35:24'),
(16, 'MD. ARAFAT', 'arafrat@gmail.com', NULL, '$2y$12$Okhysd0H0o2mxUqk660sjOwPP.8SBkcNplWjJi50EjzvqE4V7e7hW', 1, NULL, '2025-07-30 07:28:54', '2025-07-30 07:28:54'),
(17, 'md. akbar', 'akbar@gmail.com', NULL, '$2y$12$//S4/YUiUhFQCt6uwgI1jOt9nWKZOyq8kXNgphhf5RZY/EPhcBufK', 1, NULL, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(18, 'md. akbar ali', 'ali@gmail.com', NULL, '$2y$12$TLm3aMz0hhfQ1OkzWH31sOWdO6VW/Je4XFCEJ40Eld1w6nhYHTXDy', 1, NULL, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(19, 'md. sahnto', 'shanto@gmail.com', NULL, '$2y$12$eqvtTUBx.NxjQ7e/hMMbkuxIM5dq8HAW/pDoXh7gQpYzbGbWIYRFK', 1, NULL, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(20, 'md alim', 'alim@gmail.com', NULL, '$2y$12$8vQWMaBsXU4NGSWmDStQtubUI/P49NTJAuY5FWrqefFOwwaf0cCne', 1, NULL, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(21, 'sakib al hasn', 'sakib@gmail.com', NULL, '$2y$12$kpAvq6CPZJ8Rr7.egCxEHeD3mgk.BEeRGAIsmaxlfy5t9tODUUArW', 1, NULL, '2025-07-30 07:28:55', '2025-07-30 07:28:55'),
(22, 'leo messi', 'messi@gmail.com', NULL, '$2y$12$jdCHNLXD6UzI8K5YR5fGV.U3sfM31F8u/6ucqYdujTASbQHPXZgRa', 1, NULL, '2025-07-30 07:28:56', '2025-07-30 07:28:56'),
(23, 'Neymar', 'neymar@gmail.com', NULL, '$2y$12$tN5DVwtkH/Ih1kLbf9iJK.0c9WcQi3DeHkObUhJcSYL89PzM3WOtW', 1, NULL, '2025-07-30 07:28:56', '2025-07-30 07:28:56'),
(24, 'MD alamin', 'alamin@gmail.com', NULL, '$2y$12$sc9iDdb1l/98.eZsCW72TO6m9ZlkuUkHNxTJ8QZxH7wOG5Hhc/FoK', 1, NULL, '2025-07-30 08:46:00', '2025-07-30 08:46:00'),
(25, 'Imran Sarkar', 'imran@gmail.com', NULL, '$2y$12$BYYd93wlTksWxuXa6CUJ4uU.rH.QtgZ92mUJYpzCTnFnhAGwZ.lgC', 1, NULL, '2025-07-30 09:37:53', '2025-07-30 09:37:53'),
(26, 'Abdullah', 'abdullah@gmail.com', NULL, '$2y$12$gBl5obu7tILtx7pFUjJLiOuHWDwJwiel2cieclU9jTgLB6iHvoSB2', 1, NULL, '2025-07-31 07:32:57', '2025-07-31 07:32:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_code_unique` (`code`);

--
-- Indexes for table `course_evaluation_comments`
--
ALTER TABLE `course_evaluation_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_evaluation_data`
--
ALTER TABLE `course_evaluation_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `student_wise_courses`
--
ALTER TABLE `student_wise_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_wise_courses_student_id_foreign` (`student_id`),
  ADD KEY `student_wise_courses_course_id_foreign` (`course_id`),
  ADD KEY `student_wise_courses_department_id_foreign` (`department_id`),
  ADD KEY `student_wise_courses_batch_id_foreign` (`batch_id`),
  ADD KEY `student_wise_courses_created_by_foreign` (`created_by`),
  ADD KEY `student_wise_courses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `teacher_wise_courses`
--
ALTER TABLE `teacher_wise_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_wise_courses_teacher_id_foreign` (`teacher_id`),
  ADD KEY `teacher_wise_courses_course_id_foreign` (`course_id`),
  ADD KEY `teacher_wise_courses_department_id_foreign` (`department_id`),
  ADD KEY `teacher_wise_courses_batch_id_foreign` (`batch_id`),
  ADD KEY `teacher_wise_courses_created_by_foreign` (`created_by`),
  ADD KEY `teacher_wise_courses_updated_by_foreign` (`updated_by`);

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
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_evaluation_comments`
--
ALTER TABLE `course_evaluation_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `course_evaluation_data`
--
ALTER TABLE `course_evaluation_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_wise_courses`
--
ALTER TABLE `student_wise_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `teacher_wise_courses`
--
ALTER TABLE `teacher_wise_courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_wise_courses`
--
ALTER TABLE `student_wise_courses`
  ADD CONSTRAINT `student_wise_courses_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_wise_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_wise_courses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `student_wise_courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_wise_courses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_wise_courses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teacher_wise_courses`
--
ALTER TABLE `teacher_wise_courses`
  ADD CONSTRAINT `teacher_wise_courses_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_wise_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_wise_courses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `teacher_wise_courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_wise_courses_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_wise_courses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
