-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: sdb-h.hosting.stackcp.net
-- Generation Time: May 10, 2022 at 12:11 AM
-- Server version: 10.4.18-MariaDB-log
-- PHP Version: 7.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(12) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `game` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `game`) VALUES
(1, 'Westminster 1st - Women\'s', 'basketball,football,rugby'),
(2, 'Westminster 1st - Men\'s', 'cricket,football,rugby');

-- --------------------------------------------------------

--
-- Table structure for table `fixture`
--

CREATE TABLE `fixture` (
  `id` int(11) NOT NULL,
  `team_a` varchar(255) NOT NULL,
  `team_b` varchar(255) NOT NULL,
  `date` text NOT NULL,
  `time` text NOT NULL,
  `venue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fixture`
--

INSERT INTO `fixture` (`id`, `team_a`, `team_b`, `date`, `time`, `venue`) VALUES
(1, 'Westminster 1st', 'West London 1st', 'April 04 2023', '6:00', 'Walworth Academy'),
(3, 'Westminster 1st', 'Essex 2nd', 'April 04 2023', '6:00', 'Walworth Academy'),
(5, 'Essex 2nd', 'West London 1st', '09/03/2021', '19:00', 'Regents park'),
(6, 'Essex 2nd', 'Westminster 1st', '09/03/2021', '19:00', 'Regents park'),
(7, 'teamtest1', 'Essex 2nd', '09/03/2021', '19:00', 'other test');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `games` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`games`) VALUES
('basketball,rugby,cricket,football');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `team_a` varchar(255) NOT NULL,
  `team_b` varchar(255) NOT NULL,
  `team_a_score` int(255) NOT NULL,
  `team_b_score` int(11) NOT NULL,
  `time` text NOT NULL,
  `venue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `team_a`, `team_b`, `team_a_score`, `team_b_score`, `time`, `venue`) VALUES
(1, 'Essex 2nd', 'Westminster 1st', 3, 3, 'April 04 2019', 'University of Essex Sports Arena');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(255) NOT NULL,
  `team_event` varchar(255) NOT NULL,
  `team_game` varchar(255) NOT NULL,
  `players` int(11) NOT NULL,
  `win` int(11) NOT NULL,
  `draw` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `team_event`, `team_game`, `players`, `win`, `draw`, `lost`, `points`) VALUES
(1, 'Essex 2nd', 'Westminster 1st - Women\'s', 'basketball', 8, 8, 0, 1, 25),
(2, 'Westminster 1st', 'Westminster 1st - Women\'s', 'basketball', 7, 6, 0, 1, 18),
(3, 'West London 1st', 'Westminster 1st - Women\'s', 'basketball', 8, 8, 0, 0, 24),
(6, 'teamtest1', 'Westminster 1st - Men\'s', 'rugby', 8, 3, 0, 1, 25),
(7, 'teamtest2', 'Westminster 1st - Women\'s', 'rugby', 8, 8, 0, 1, 29),
(8, 'teamtest12', 'Westminster 1st - Men\'s', 'cricket', 8, 8, 0, 1, 29),
(9, 'teamtest123', 'Westminster 1st - Men\'s', 'cricket', 8, 8, 0, 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(12) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fixture`
--
ALTER TABLE `fixture`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
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
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `fixture`
--
ALTER TABLE `fixture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
