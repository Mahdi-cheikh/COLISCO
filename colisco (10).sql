-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 03:48 PM
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
-- Database: `colisco`
--

-- --------------------------------------------------------

--
-- Table structure for table `colis`
--

CREATE TABLE `colis` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `photos` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `object` varchar(255) NOT NULL,
  `exact_dimensions` tinyint(1) DEFAULT NULL,
  `format` varchar(50) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `ville_dep` varchar(255) NOT NULL,
  `pickup_type_dep` enum('domicile','point-relais') NOT NULL,
  `has_coordinates_dep` tinyint(1) NOT NULL DEFAULT 0,
  `ville_arr` varchar(255) NOT NULL,
  `pickup_type_arr` enum('domicile','point-relais') NOT NULL,
  `has_coordinates_arr` tinyint(1) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colis`
--

INSERT INTO `colis` (`id`, `user_name`, `photos`, `quantity`, `object`, `exact_dimensions`, `format`, `weight`, `additional_info`, `ville_dep`, `pickup_type_dep`, `has_coordinates_dep`, `ville_arr`, `pickup_type_arr`, `has_coordinates_arr`, `price`, `created_at`) VALUES
(5, 'mehdi cheikh', 'upload/67f6cbb981784_images (8).jpg', 1, 'moto-cross', 1, 'grand', '10-20', 'Dimensions et poids · Batterie. N.C. · Angle de chasse. 27°19\' · Dimensions (mm). 2 183 x 827 x 1 265mm', 'nabeul', 'domicile', 1, 'sousse', 'domicile', 1, 210.00, '2025-04-09 19:34:17'),
(7, 'mehdi cheikh', 'upload/67f6fd4128471_1681314797-9980-photo.jpg', 1, 'trotinette électrique ', 1, 'petit', '5-10', '*L x l x H = 1 144 x 480 x 1 178 mm, largeur du plateau = 160 mm : garer la trottinette dans le cadre de mesure et mesurer sa longueur, sa largeur et sa hauteur.', 'gafsa', 'domicile', 1, 'korbous', 'domicile', 1, 33.00, '2025-04-09 23:05:37'),
(29, 'salma essaies', 'upload/67fda39688626_prado-bicyclette-vtt-9024l-24-pouces-noir-amp-vert.jpg', 2, 'mountain bike, all-terrain bike, off-roader', 1, 'moyen', '5-10', 'The majority of the bikes in our list can comfortably clear a 2.8”- 3” tire, on rims between 30-50mm width, be it a 26, 27.5, or 29er in diameter', 'béja', 'domicile', 1, 'nabeul', 'domicile', 1, 200.00, '2025-04-15 00:08:54'),
(31, 'salma essaies', 'upload/67fda4fc755cd_photo-1579765754037-5bfef757251a.jpg', 2, 'desktop computer', 1, 'moyen', '5-10', 'eight (inch / cm), 13.8 / 35, 11.42 / 29 ; Width (inch / cm), 6.1 / 15.4, 3.65 / 9.26 ;', 'sousse', 'point-relais', 1, 'nabeul', 'domicile', 1, 120.00, '2025-04-15 00:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `commenter_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_name`, `commenter_name`, `comment`, `created_at`, `rating`) VALUES
(5, 'abir guezmil', 'salma essaies', 'test testtt ', '2025-04-14 12:32:02', 4),
(6, 'abir guezmil', 'mehdi cheikh', 'test  22\r\n', '2025-04-14 12:35:19', 5),
(8, 'abir guezmil', 'omar dridi', 'test test  ', '2025-04-14 12:47:06', 4),
(9, 'Mehdi Cheikh', 'salma essaies', 'services trés exellent ', '2025-04-15 00:18:36', 4),
(10, 'salma essaies', 'mehdi cheikh', 'EXCELLENT ', '2025-04-15 00:32:13', 5),
(11, 'omar dridi', 'mehdi cheikh', 'service excellent ', '2025-04-15 21:03:27', 5);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `timestamp`) VALUES
(9, 'omar dridi', 'mehdi cheikh', 'salut mehdi ', '2025-04-15 01:29:42'),
(10, 'omar dridi', 'mehdi cheikh', 'je peut livrer votre colis', '2025-04-15 01:30:02'),
(11, 'salma essaies', 'mehdi cheikh', 'bonjour mehdi', '2025-04-15 01:31:04'),
(12, 'Mehdi Cheikh', 'salma essaies', 'BONJOUR SALMA', '2025-04-15 01:31:52'),
(13, 'Mehdi Cheikh', 'omar dridi', 'OK ', '2025-04-15 01:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `trajets`
--

CREATE TABLE `trajets` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `search_type` varchar(50) NOT NULL,
  `departure_city` varchar(255) NOT NULL,
  `arrival_city` varchar(255) NOT NULL,
  `detour` int(11) NOT NULL,
  `max_amount` varchar(50) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `round_trip` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trajets`
--

INSERT INTO `trajets` (`id`, `user_name`, `search_type`, `departure_city`, `arrival_city`, `detour`, `max_amount`, `frequency`, `date`, `round_trip`) VALUES
(2, 'Mehdi Cheikh', 'sur-mon-trajet', 'monastir', 'nabeul', 35, '80', 'one-time', '2025-04-24', 1),
(3, 'Mehdi Cheikh', 'sur-mon-trajet', 'KORBOUS', 'bembla', 7, '77', 'one-time', '2025-04-11', 1),
(5, 'omar dridi', 'autour-de-moi', 'Kairouan', 'sousse', 5, '70', 'one-time', '2025-04-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userregistration`
--

CREATE TABLE `userregistration` (
  `user_id` int(11) NOT NULL,
  `user_type` enum('Particulier','Professionnel') NOT NULL,
  `user_profile` enum('Expéditeur','Transporteur') NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `birth_date` date NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `referral_code` varchar(50) DEFAULT NULL,
  `accepts_terms` tinyint(1) NOT NULL,
  `accepts_newsletter` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userregistration`
--

INSERT INTO `userregistration` (`user_id`, `user_type`, `user_profile`, `first_name`, `last_name`, `birth_date`, `nationality`, `email`, `password`, `phone_number`, `referral_code`, `accepts_terms`, `accepts_newsletter`, `created_at`, `updated_at`) VALUES
(22, 'Particulier', 'Expéditeur', 'salma', 'essaies', '2025-10-15', 'tunisie', 'salmaesseies@gmail.com', '1234', '23 434 455', '1234', 1, 1, '2025-04-10 09:10:26', '2025-04-10 09:10:26'),
(27, 'Particulier', 'Expéditeur', 'Mehdi', 'Cheikh', '2025-04-03', 'australie', 'mehedicheikh@gmail.com', '12345', '29774784', '12345', 1, 1, '2025-04-12 01:03:20', '2025-04-12 01:03:20'),
(31, 'Professionnel', 'Expéditeur', 'omar', 'dridi', '2025-05-01', 'afghanistan', 'omardridi@gmail.com', '1234', '29 874 888', '1234', 1, 1, '2025-04-13 21:37:39', '2025-04-13 21:37:39'),
(32, 'Particulier', 'Expéditeur', 'abir', 'guezmil', '2025-05-02', 'argentine', 'abirguezmil@gmail.com', '1234', ' 99 989 474', '1234', 1, 1, '2025-04-13 21:40:00', '2025-04-13 21:40:00'),
(33, 'Particulier', 'Expéditeur', 'admin', '', '2025-04-16', 'tunisie', 'admin@gmail.com', '1234', '29 774 784', '1234', 1, 1, '2025-04-14 09:05:24', '2025-04-15 00:02:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(117, 'salmaesseies@gmail.com', '123456', '2025-04-11 17:05:54', '2025-04-11 17:35:10'),
(118, 'mehedicheikh@gmail.com', '12345', '2025-04-11 17:40:11', '2025-04-11 17:40:11'),
(119, 'salmaesseies@gmail.com', '1234', '2025-04-11 18:57:45', '2025-04-11 18:57:45'),
(120, 'mehedicheikh@gmail.com', '12345', '2025-04-12 01:03:26', '2025-04-12 01:03:26'),
(121, 'mehedicheikh@gmail.com', '12345', '2025-04-12 01:06:02', '2025-04-12 01:06:02'),
(122, 'mehedicheikh@gmail.com', '12345', '2025-04-12 01:26:12', '2025-04-12 01:26:12'),
(123, 'mehedicheikh@gmail.com', '12345', '2025-04-12 02:36:28', '2025-04-12 02:36:28'),
(124, 'mehedicheikh@gmail.com', '12345', '2025-04-12 11:28:33', '2025-04-12 11:28:33'),
(125, 'mehedicheikh@gmail.com', '12345', '2025-04-12 11:30:15', '2025-04-12 11:30:15'),
(126, 'mehedicheikh@gmail.com', '12345', '2025-04-12 11:30:48', '2025-04-12 11:30:48'),
(127, 'mehedicheikh@gmail.com', '12345', '2025-04-12 11:36:32', '2025-04-12 11:36:32'),
(128, 'mehedicheikh@gmail.com', '12345', '2025-04-12 12:07:02', '2025-04-12 12:07:02'),
(129, 'mehedicheikh@gmail.com', '12345', '2025-04-12 13:36:32', '2025-04-12 13:36:32'),
(130, 'mehedicheikh@gmail.com', '12345', '2025-04-12 14:22:38', '2025-04-12 14:22:38'),
(131, 'mehedicheikh@gmail.com', '12345', '2025-04-13 14:28:02', '2025-04-13 14:28:02'),
(132, 'mehedicheikh@gmail.com', '12345', '2025-04-13 16:32:54', '2025-04-13 16:32:54'),
(133, 'omardridi@gmail.com', '1234', '2025-04-13 16:42:14', '2025-04-13 16:42:14'),
(134, 'omardridi@gmail.com', '1234', '2025-04-13 16:46:52', '2025-04-13 16:46:52'),
(135, 'abirguezmil@gmail.com', '1234', '2025-04-13 16:53:50', '2025-04-13 16:53:50'),
(136, 'mehedicheikh@gmail.com', '12345', '2025-04-13 17:20:57', '2025-04-13 17:20:57'),
(137, 'abirguezmil@gmail.com', '1234', '2025-04-13 17:35:31', '2025-04-13 17:35:31'),
(138, 'mehedicheikh@gmail.com', '12345', '2025-04-13 17:54:57', '2025-04-13 17:54:57'),
(139, 'salmaesseies@gmail.com', '1234', '2025-04-13 17:59:26', '2025-04-13 17:59:26'),
(140, 'salmaesseies@gmail.com', '1234', '2025-04-13 18:05:28', '2025-04-13 18:05:28'),
(141, 'mehedicheikh@gmail.com', '12345', '2025-04-13 20:24:14', '2025-04-13 20:24:14'),
(142, 'mehedicheikh@gmail.com', '12345', '2025-04-13 20:25:01', '2025-04-13 20:25:01'),
(143, 'mehedicheikh@gmail.com', '12345', '2025-04-13 20:56:37', '2025-04-13 20:56:37'),
(144, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:09:58', '2025-04-13 21:09:58'),
(145, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:12:23', '2025-04-13 21:12:23'),
(146, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:20:45', '2025-04-13 21:20:45'),
(147, 'omardridi@gmail.com', '1234', '2025-04-13 21:27:44', '2025-04-13 21:27:44'),
(148, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:29:49', '2025-04-13 21:29:49'),
(149, 'salmaesseies@gmail.com', '1234', '2025-04-13 21:30:43', '2025-04-13 21:30:43'),
(150, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:31:46', '2025-04-13 21:31:46'),
(151, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:35:15', '2025-04-13 21:35:15'),
(152, 'omardridi@gmail.com', '1234', '2025-04-13 21:37:46', '2025-04-13 21:37:46'),
(153, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:40:08', '2025-04-13 21:40:08'),
(154, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:42:15', '2025-04-13 21:42:15'),
(155, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:52:01', '2025-04-13 21:52:01'),
(156, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:53:45', '2025-04-13 21:53:45'),
(157, 'mehedicheikh@gmail.com', '12345', '2025-04-13 21:54:27', '2025-04-13 21:54:27'),
(158, 'abirguezmil@gmail.com', '1234', '2025-04-13 21:55:22', '2025-04-13 21:55:22'),
(159, 'mehedicheikh@gmail.com', '12345', '2025-04-13 22:57:41', '2025-04-13 22:57:41'),
(160, 'mehedicheikh@gmail.com', '12345', '2025-04-14 09:11:17', '2025-04-14 09:11:17'),
(161, 'mehedicheikh@gmail.com', '12345', '2025-04-14 09:28:05', '2025-04-14 09:28:05'),
(162, 'abirguezmil@gmail.com', '1234', '2025-04-14 09:28:36', '2025-04-14 09:28:36'),
(163, 'mehedicheikh@gmail.com', '12345', '2025-04-14 09:34:28', '2025-04-14 09:34:28'),
(164, 'test@gmail.com', '1234', '2025-04-14 12:15:46', '2025-04-14 12:15:46'),
(165, 'mehedicheikh@gmail.com', '12345', '2025-04-14 12:18:53', '2025-04-14 12:18:53'),
(166, 'mehedicheikh@gmail.com', '12345', '2025-04-14 12:54:48', '2025-04-14 12:54:48'),
(167, 'abirguezmil@gmail.com', '1234', '2025-04-14 12:57:45', '2025-04-14 12:57:45'),
(168, 'mehedicheikh@gmail.com', '12345', '2025-04-14 12:58:36', '2025-04-14 12:58:36'),
(169, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:01:04', '2025-04-14 13:01:04'),
(170, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:03:08', '2025-04-14 13:03:08'),
(171, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:14:48', '2025-04-14 13:14:48'),
(172, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:17:57', '2025-04-14 13:17:57'),
(173, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:24:11', '2025-04-14 13:24:11'),
(174, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:32:58', '2025-04-14 13:32:58'),
(175, 'mehedicheikh@gmail.com', '12345', '2025-04-14 13:51:59', '2025-04-14 13:51:59'),
(176, 'mehedicheikh@gmail.com', '12345', '2025-04-14 23:49:19', '2025-04-14 23:49:19'),
(177, 'mehedicheikh@gmail.com', '12345', '2025-04-15 00:07:05', '2025-04-15 00:07:05'),
(178, 'salmaesseies@gmail.com', '1234', '2025-04-15 00:07:49', '2025-04-15 00:07:49'),
(179, 'mehedicheikh@gmail.com', '12345', '2025-04-15 00:19:05', '2025-04-15 00:19:05'),
(180, 'omardridi@gmail.com', '1234', '2025-04-15 00:20:40', '2025-04-15 00:20:40'),
(181, 'salmaesseies@gmail.com', '1234', '2025-04-15 00:30:35', '2025-04-15 00:30:35'),
(182, 'mehedicheikh@gmail.com', '12345', '2025-04-15 00:31:40', '2025-04-15 00:31:40'),
(183, 'mehedicheikh@gmail.com', '12345', '2025-04-15 00:34:38', '2025-04-15 00:34:38'),
(184, 'mehedicheikh@gmail.com', '12345', '2025-04-15 10:44:24', '2025-04-15 10:44:24'),
(185, 'mehedicheikh@gmail.com', '12345', '2025-04-15 11:21:49', '2025-04-15 11:21:49'),
(186, 'mehedicheikh@gmail.com', '12345', '2025-04-15 20:57:23', '2025-04-15 20:57:23'),
(187, 'mehedicheikh@gmail.com', '12345', '2025-04-15 21:02:48', '2025-04-15 21:02:48'),
(188, 'mehedicheikh@gmail.com', '12345', '2025-04-16 13:18:02', '2025-04-16 13:18:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colis`
--
ALTER TABLE `colis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trajets`
--
ALTER TABLE `trajets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userregistration`
--
ALTER TABLE `userregistration`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colis`
--
ALTER TABLE `colis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `trajets`
--
ALTER TABLE `trajets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `userregistration`
--
ALTER TABLE `userregistration`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
