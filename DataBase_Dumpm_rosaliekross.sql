-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 09, 2020 at 08:28 PM
-- Server version: 10.2.32-MariaDB
-- PHP Version: 5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rosaliekross`
--

-- --------------------------------------------------------

--
-- Table structure for table `ControlStatus`
--

CREATE TABLE `ControlStatus` (
  `id` int(11) NOT NULL,
  `ControlPos` varchar(55) NOT NULL,
  `Control_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ControlStatus`
--

INSERT INTO `ControlStatus` (`id`, `ControlPos`, `Control_id`) VALUES
(1, 'ManualMode', 1),
(2, 'AutomaticMode', 0),
(3, 'NightMode', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Devices`
--

CREATE TABLE `Devices` (
  `id` int(11) NOT NULL,
  `Device_code` int(10) NOT NULL,
  `Device_name` varchar(55) NOT NULL,
  `AverageTemp` varchar(5) NOT NULL,
  `NightTemp` int(11) DEFAULT NULL,
  `Date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `User_id` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Devices`
--

INSERT INTO `Devices` (`id`, `Device_code`, `Device_name`, `AverageTemp`, `NightTemp`, `Date_added`, `User_id`) VALUES
(37, 2222, 'Kamer Test', '3', 5, '2020-08-08 00:51:13', '1'),
(47, 3333, 'Keukenraam', '40', 2, '2020-08-08 05:21:44', '1'),
(50, 1111, 'Kamer Roos', '33', 40, '2020-08-09 20:17:51', '2'),
(51, 2222, 'Keuken', '10', NULL, '2020-08-09 20:25:00', '2'),
(52, 4444, 'Test kamer', '12', NULL, '2020-08-09 20:27:24', '1');

-- --------------------------------------------------------

--
-- Table structure for table `OverviewDevices`
--

CREATE TABLE `OverviewDevices` (
  `id` int(11) NOT NULL,
  `deviceCode_id` int(11) NOT NULL,
  `UserSettings_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `CurrentTemp` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `OverviewDevices`
--

INSERT INTO `OverviewDevices` (`id`, `deviceCode_id`, `UserSettings_id`, `User_id`, `CurrentTemp`) VALUES
(2, 1111, 1111, 0, NULL),
(3, 2222, 2222, 0, NULL),
(5, 3333, 3333, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `SensorData`
--

CREATE TABLE `SensorData` (
  `id` int(6) UNSIGNED NOT NULL,
  `sensor` varchar(30) NOT NULL,
  `temp` varchar(10) DEFAULT NULL,
  `humidity` varchar(10) DEFAULT NULL,
  `windowPos` varchar(10) DEFAULT NULL,
  `deviceCode` varchar(11) NOT NULL,
  `reading_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `SensorData`
--

INSERT INTO `SensorData` (`id`, `sensor`, `temp`, `humidity`, `windowPos`, `deviceCode`, `reading_time`) VALUES
(1, 'DHT11', '20', '55', 'Open', '1111', '2020-08-08 02:57:57'),
(2, 'DHT11', '25', '50', 'Close', '1111', '2020-08-08 02:57:57'),
(3, 'DHT11', '27', '55', 'Open', '1111', '2020-08-08 02:58:14'),
(4, 'DHT11', '30', '50', 'Close', '1111', '2020-08-08 02:58:14'),
(6, 'DHT11', '32', '50', 'Close', '1111', '2020-08-08 02:58:31'),
(27, 'DH11', '28.00', '50.00', 'closed', '1111', '2020-08-08 03:32:24'),
(877, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:19:19'),
(878, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:19:43'),
(879, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:20:05'),
(880, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:20:26'),
(881, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:20:49'),
(882, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:21:10'),
(883, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:21:32'),
(884, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:21:58'),
(885, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:22:19'),
(886, 'DH11', '29.00', '46.00', 'closed', '1111', '2020-08-09 20:23:26'),
(887, 'DH11', '29.00', '47.00', 'Open', '1111', '2020-08-09 20:23:48'),
(888, 'DH11', '29.00', '46.00', 'Open', '1111', '2020-08-09 20:24:09'),
(889, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:24:31'),
(890, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:24:53'),
(891, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:25:16'),
(892, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:25:34'),
(893, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:25:53'),
(894, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:26:10'),
(895, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:26:31'),
(896, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:26:51'),
(897, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:27:15'),
(898, 'DH11', '29.00', '46.00', 'Closed', '1111', '2020-08-09 20:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `idd` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`idd`, `user_name`, `password`, `name`) VALUES
(1, 'Jeroen', 'kip', 'Jeroen'),
(2, 'Roos', 'abc', 'Roos');

-- --------------------------------------------------------

--
-- Table structure for table `UserSettings`
--

CREATE TABLE `UserSettings` (
  `id` int(11) NOT NULL,
  `AverageTemp` varchar(10) NOT NULL,
  `Device_code` int(44) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `WindowController`
--

CREATE TABLE `WindowController` (
  `id` int(11) NOT NULL,
  `Device_code` int(11) NOT NULL,
  `Pos` varchar(10) DEFAULT NULL,
  `ControllerMode` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `WindowController`
--

INSERT INTO `WindowController` (`id`, `Device_code`, `Pos`, `ControllerMode`) VALUES
(1, 1111, '180', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ControlStatus`
--
ALTER TABLE `ControlStatus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Devices`
--
ALTER TABLE `Devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `OverviewDevices`
--
ALTER TABLE `OverviewDevices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `SensorData`
--
ALTER TABLE `SensorData`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`idd`);

--
-- Indexes for table `UserSettings`
--
ALTER TABLE `UserSettings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `WindowController`
--
ALTER TABLE `WindowController`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ControlStatus`
--
ALTER TABLE `ControlStatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Devices`
--
ALTER TABLE `Devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `OverviewDevices`
--
ALTER TABLE `OverviewDevices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `SensorData`
--
ALTER TABLE `SensorData`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=899;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `idd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `UserSettings`
--
ALTER TABLE `UserSettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `WindowController`
--
ALTER TABLE `WindowController`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
