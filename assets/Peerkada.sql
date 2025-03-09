-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 09, 2025 at 07:07 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Peerkada`
--

-- --------------------------------------------------------

--
-- Table structure for table `members_profile`
--

CREATE TABLE `members_profile` (
  `USER_ID` int NOT NULL,
  `NAME` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ID_NUMBER` int NOT NULL,
  `TITLE` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `COLLEGE` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `SCHOOL_YR` int NOT NULL,
  `COURSE` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `EMAIL_ADD` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `PHONE_NUM` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ADDRESS` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `BIRTH` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `SEX` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `PASSWORD` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ROLE` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='4';

--
-- Dumping data for table `members_profile`
--

INSERT INTO `members_profile` (`USER_ID`, `NAME`, `ID_NUMBER`, `TITLE`, `COLLEGE`, `SCHOOL_YR`, `COURSE`, `EMAIL_ADD`, `PHONE_NUM`, `ADDRESS`, `BIRTH`, `SEX`, `PASSWORD`, `ROLE`) VALUES
(1, 'Admin', 1, 'Admin', 'Admin', 1, 'Admin', 'admin@admin.com', '001', 'Admin', '0003-01-02', 'Admin', '$2y$10$CWw8VVRWpt8qJ6kW6IspSesdoq7rulU9DvpmojcBl3oX4byCsalM2', 'admin'),
(2, 'Scanner', 2, 'Scanner', 'Scanner', 2, '002', 'scanner@scanner.com', '002', '002', '2025-02-21', 'scanner', '$2y$10$gDJe4sIWXskM.lQTSHkeg.sHEiOzLRSuF/NgcpnFyswpke8qDIzz6', 'scanner');

-- --------------------------------------------------------

--
-- Table structure for table `table_attendance`
--

CREATE TABLE `table_attendance` (
  `ATTENDANCE_ID` int NOT NULL,
  `STUDENTID` int NOT NULL,
  `TIMEIN` time DEFAULT NULL,
  `TIMEOUT` time DEFAULT NULL,
  `LOGDATE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members_profile`
--
ALTER TABLE `members_profile`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `table_attendance`
--
ALTER TABLE `table_attendance`
  ADD PRIMARY KEY (`ATTENDANCE_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members_profile`
--
ALTER TABLE `members_profile`
  MODIFY `USER_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `table_attendance`
--
ALTER TABLE `table_attendance`
  MODIFY `ATTENDANCE_ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
