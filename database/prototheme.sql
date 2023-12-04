-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 03:02 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prototheme`
--

-- --------------------------------------------------------

--
-- Table structure for table `travel_destinations`
--

CREATE TABLE `travel_destinations` (
  `id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `continent` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cost` varchar(150) NOT NULL,
  `travel_days` varchar(150) NOT NULL,
  `distance` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `travel_destinations`
--

INSERT INTO `travel_destinations` (`id`, `place`, `image_path`, `continent`, `description`, `cost`, `travel_days`, `distance`, `created_at`, `status`) VALUES
(1, 'Singapore', 'uploads/destinations/singapore.jpg', '', 'Singapore, officially the Republic of Singapore, is a sovereign island city-state in maritime Southeast.', '10000', 'Approx 2 night trip', '1000', '2023-12-02 15:18:48', b'1'),
(2, 'Thailand', '', '', 'Thailand is a Southeast Asian country. It\'s known for tropical beaches, opulent royal palaces', '10000', 'Approx 2 night trip', '1200', '2023-12-02 15:27:24', b'1'),
(3, 'Paris', '', '', 'Paris, France\'s capital, is a major European city and a global center for art, fashion, gastronomy and', '12000', 'Approx 2 night trip', '1100', '2023-12-02 15:28:01', b'1'),
(4, 'New Zealand', '', '', 'New Zealand is an island country in the southwestern Pacific Ocean. It consists of two', '38800', 'Approx 1 night trip', '1300', '2023-12-02 15:28:45', b'1'),
(5, 'Bora Bora', '', '', 'Bora Bora is a small South Pacific island northwest of Tahiti in French Polynesia. Surrounded by sand', '38800', 'Approx 2 night 2 day trip', '1000', '2023-12-02 15:29:32', b'1'),
(6, 'London', '', '', 'London, the capital of England and the United Kingdom, is a 21st-century city with history', '3880', 'Approx 3 night 2 day trip', '1000', '2023-12-02 15:30:15', b'1'),
(8, 'Uganda', 'uploads/destinations/kampala.jpeg', '', 'A parl of africa', '500', 'A one days trip', '200', '2023-12-03 13:39:17', b'1'),
(9, 'Mombasa', 'uploads/destinations/ERD.png', 'Africa', 'The place that welcomes you to east Africa', '600', 'i day trip', '400km', '2023-12-04 04:29:55', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='table for users';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `status`) VALUES
(1, 'Test Admin 1', 'admin1@prototheme.com', '$2y$10$LNNJr0J1JQwv5r9iHqD2CexCgw.MaPf0UKvlkQEICisb5A76Zr/ja', '2023-12-02 12:38:35', b'0'),
(2, 'Test Admin 2', 'admin2@prototheme.com', '$2y$10$U6nbQ/PqzgAQVQjB9b57puCsz1B/pbgYHCZImFGv7BJKcyBld34/6', '2023-12-02 12:38:35', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `travel_destinations`
--
ALTER TABLE `travel_destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `travel_destinations`
--
ALTER TABLE `travel_destinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
