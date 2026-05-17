-- phpMyAdmin SQL Dump
-- version 5.2.2deb1+deb13u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 15, 2026 at 11:34 AM
-- Server version: 11.8.6-MariaDB-0+deb13u1 from Debian
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_listing`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `overview` text DEFAULT NULL,
  `poster_path` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `vote_average` decimal(3,1) DEFAULT NULL,
  `genre_ids` varchar(255) DEFAULT NULL,
  `backdrop_path` varchar(255) DEFAULT NULL,
  `vote_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `tmdb_id`, `title`, `overview`, `poster_path`, `release_date`, `vote_average`, `genre_ids`, `backdrop_path`, `vote_count`, `created_at`, `updated_at`) VALUES
(1, 550, 'Test Movie', 'Test Description', '/avatar0.jpeg', '2001-01-01', 8.9, '28, 18', NULL, 100, '2026-05-15 11:34:40', NULL),
(2, 246, 'Avatar: The Last Airbender', 'The story follows Aang, the young Avatar, as he learns to master all four elements and bring balance to the world.\r\n', '/qe70Lo75TLTPr6uxOPktlHxz6Nf.jpg', '2005-02-21', 9.3, '16, 10765, 10759', NULL, 45, '2026-05-15 11:34:40', NULL),
(4, 450, 'Fight Club', 'Test Description', NULL, '2012-12-12', 8.9, '28, 18', NULL, 100, '2026-05-15 11:34:40', NULL),
(5, 123, 'asdsa', 'asdads', NULL, '2012-12-12', 9.0, '12', NULL, 100, '2026-05-15 11:34:40', NULL),
(7, 200, 'asdasd', 'adadsad', NULL, '2313-12-31', 7.0, '123', NULL, 123, '2026-05-15 11:34:40', NULL),
(8, 125, 'asdasdasdsad', 'asdasd', NULL, '2312-12-12', 8.9, NULL, NULL, NULL, '2026-05-15 11:34:40', NULL),
(9, 1235, 'asdasd', 'asdsadad', NULL, '2323-12-31', 8.0, NULL, NULL, NULL, '2026-05-15 11:34:40', NULL),
(10, 12345, 'asdasd', 'asdasdasdsad', NULL, '2323-12-12', 5.0, NULL, NULL, NULL, '2026-05-15 11:34:40', NULL),
(12, 299534, 'Avengers: Endgame', 'After the devastating events of Avengers: Infinity War, the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos\' actions and restore order to the universe once and for all, no matter what consequences may be in store.', '/assets/uploads/posters/1778841104_avengersEndgame.webp', '2019-04-24', 8.2, NULL, NULL, 100, '2026-05-15 11:34:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'avatar.webp',
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `profile_pic`, `is_admin`, `created_at`) VALUES
(1, 'gbrllsn', 'sean@example.com', '$2y$12$yS/KSW.xlAgFSWzKu9eGxuTqv/ahSnrVeDAwUOnBNGbru.UPGnbQa', 'avatar.webp', 1, '2026-05-13 17:17:41'),
(2, 'yannis', 'yannis@example.com', '$2y$12$qDRJoM.R./n2eEch17EAJeEd8Odpn/TwAUrCEMmQ9Q.s2AJ6ZUoDq', 'avatar.webp', 0, '2026-05-13 17:30:46'),
(3, 'thope', 'trisha@example.com', '$2y$12$bW4JOkVTog.ETzgFBzGvTup2zQtIB2mCn55oFXpYzgLV5704ADujG', 'avatar.webp', 0, '2026-05-14 12:13:10'),
(4, 'asda', 'asd@asd', '$2y$12$ZiG66jENWSzuq7cGSiPRNu.SBPfHcyZtgzmN.h7.9SmSOz.bkE7F.', 'avatar.webp', 0, '2026-05-14 12:38:27'),
(5, 'shenaiah', 'shen@example.com', '$2y$12$ggZR9bwqrsotRwPEO6C00e/6kThNTKvc7cCLNRw8lnQsgRmMf6niq', 'avatar.webp', 0, '2026-05-15 09:26:03'),
(6, 'aengelat', 'nea@example.com', '$2y$12$SaAQ5e.z0hy.CddLY22atuaSkZBOqROjzV32LsYI6LlMATVElIxYu', 'avatar.webp', 0, '2026-05-15 11:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_reviews`
--

CREATE TABLE `user_reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `status` enum('watched','watching','want_to_watch') DEFAULT 'want_to_watch',
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 10),
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_reviews`
--

INSERT INTO `user_reviews` (`id`, `user_id`, `movie_id`, `status`, `rating`, `review`, `created_at`) VALUES
(1, 2, 12, 'want_to_watch', 9, '', '2026-05-15 08:24:22'),
(4, 2, 9, 'want_to_watch', 10, 'haha', '2026-05-15 08:27:52'),
(6, 5, 2, 'want_to_watch', 10, 'I love it', '2026-05-15 09:33:05'),
(9, 6, 12, 'want_to_watch', 10, 'WOW AMAZING', '2026-05-15 11:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
(1, 2, 9, '2026-05-15 08:41:07'),
(2, 5, 9, '2026-05-15 09:50:51'),
(3, 6, 12, '2026-05-15 11:27:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tmdb_id` (`tmdb_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_interaction` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_watch` (`user_id`,`movie_id`),
  ADD KEY `watchlist_movie_fk` (`movie_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_reviews`
--
ALTER TABLE `user_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_reviews`
--
ALTER TABLE `user_reviews`
  ADD CONSTRAINT `user_reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `watchlist_movie_fk` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
