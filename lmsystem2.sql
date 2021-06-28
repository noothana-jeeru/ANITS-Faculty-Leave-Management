-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2021 at 05:28 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lmsystem2`
--

-- --------------------------------------------------------

--
-- Table structure for table `holydays`
--

CREATE TABLE `holydays` (
  `id` int(11) NOT NULL,
  `DATEs` date NOT NULL,
  `DESCRIPTIONs` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holydays`
--

INSERT INTO `holydays` (`id`, `DATEs`, `DESCRIPTIONs`) VALUES
(24, '2020-05-25', 'Ramzan'),
(25, '2020-05-31', 'Sunday'),
(26, '2020-06-01', 'Sunday'),
(27, '2020-06-07', 'Sunday'),
(28, '2020-06-14', 'Sunday'),
(29, '2020-06-21', 'Sunday'),
(30, '2020-06-28', 'Sunday'),
(31, '2020-08-02', 'Sunday'),
(32, '2020-08-09', 'Sunday'),
(33, '2020-08-16', 'Sunday'),
(34, '2020-08-23', 'Sunday'),
(35, '2020-08-30', 'Sunday'),
(36, '2020-09-06', 'Sunday'),
(37, '2020-08-11', 'Covid 19'),
(38, '2020-08-12', 'Covid 19'),
(39, '2020-08-13', 'Covid 19');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `EMPID` int(11) NOT NULL,
  `EMPNAME` varchar(60) NOT NULL,
  `REMARKS` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `DATE`, `EMPID`, `EMPNAME`, `REMARKS`) VALUES
(9, '2020-05-19', 3778, 'user2', '0.5 CL reduced due to late coming.');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `id` int(11) NOT NULL,
  `EMPID` int(11) NOT NULL,
  `EMPNAME` varchar(60) NOT NULL,
  `DEPARTMENT` varchar(60) NOT NULL,
  `USERNAME` varchar(30) NOT NULL,
  `PASSWORDS` text NOT NULL,
  `CL` decimal(4,1) UNSIGNED NOT NULL DEFAULT 0.0,
  `EL` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `OD` decimal(4,1) UNSIGNED NOT NULL DEFAULT 0.0,
  `PERMISIONS` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `LOP` decimal(4,1) UNSIGNED NOT NULL DEFAULT 0.0,
  `LATECOMING` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `PERMISIONFLAG` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`id`, `EMPID`, `EMPNAME`, `DEPARTMENT`, `USERNAME`, `PASSWORDS`, `CL`, `EL`, `OD`, `PERMISIONS`, `LOP`, `LATECOMING`, `PERMISIONFLAG`) VALUES
(12, 3294, 'user4', 'INFORMATION_TECHNOLOGY', 'user4@gmail.com', '1234', '8.0', 12, '10.0', 2, '0.0', 0, 0),
(1, 3555, 'hod', 'INFORMATION_TECHNOLOGY', 'hod@gmail.com', '1234', '8.0', 12, '10.0', 2, '0.0', 0, 0),
(2, 3666, 'admin', 'INFORMATION_TECHNOLOGY', 'admin@gmail.com', '1234', '8.0', 12, '10.0', 2, '0.0', 0, 0),
(3, 3777, 'user', 'INFORMATION_TECHNOLOGY', 'user@gmail.com', '1234', '3.5', 9, '10.0', 0, '0.0', 0, 0),
(10, 3778, 'user2', 'INFORMATION_TECHNOLOGY', 'user2@gmail.com', '1234', '8.0', 12, '10.0', 2, '0.0', 0, 0),
(11, 3779, 'user3', 'INFORMATION_TECHNOLOGY', 'user3@gmail.com', '1234', '8.0', 12, '10.0', 2, '0.0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblleave`
--

CREATE TABLE `tblleave` (
  `LEAVEID` int(11) NOT NULL,
  `EMPID` int(11) NOT NULL,
  `DATESTART` date NOT NULL,
  `DATEEND` date NOT NULL,
  `NOOFDAYS` double NOT NULL,
  `SHIFT` text NOT NULL DEFAULT '---',
  `TYPEOFLEAVE` varchar(30) NOT NULL,
  `TIME` text NOT NULL DEFAULT '---',
  `REASON` text NOT NULL,
  `ADJUSTMENT` text NOT NULL,
  `LEAVESTATUS` varchar(30) NOT NULL,
  `ADMINREMARKS` text NOT NULL,
  `DATEPOSTED` date NOT NULL,
  `CL_USED` decimal(11,0) NOT NULL DEFAULT 0,
  `EL_USED` int(11) NOT NULL DEFAULT 0,
  `OD_USED` decimal(11,0) NOT NULL DEFAULT 0,
  `PERMISIONS__USED` int(11) NOT NULL DEFAULT 0,
  `HALFCL__USED` decimal(4,1) NOT NULL DEFAULT 0.0,
  `HALFOD__USED` decimal(4,1) NOT NULL DEFAULT 0.0,
  `LOP__USED` decimal(4,1) NOT NULL DEFAULT 0.0,
  `LATECOMING__USED` int(11) NOT NULL DEFAULT 0,
  `EXTRAPER__USED` decimal(4,1) UNSIGNED NOT NULL,
  `EMPNAME` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblleave`
--

INSERT INTO `tblleave` (`LEAVEID`, `EMPID`, `DATESTART`, `DATEEND`, `NOOFDAYS`, `SHIFT`, `TYPEOFLEAVE`, `TIME`, `REASON`, `ADJUSTMENT`, `LEAVESTATUS`, `ADMINREMARKS`, `DATEPOSTED`, `CL_USED`, `EL_USED`, `OD_USED`, `PERMISIONS__USED`, `HALFCL__USED`, `HALFOD__USED`, `LOP__USED`, `LATECOMING__USED`, `EXTRAPER__USED`, `EMPNAME`) VALUES
(365, 3778, '2020-05-28', '2020-05-30', 3, '---', 'Earned Leave', '---', 'Personal', '3/4 IT-B,1st period to user3;\r\n4/4 IT-C, 3rd period to user1', 'REJECTED', 'Leave Rejected', '2020-05-24', '0', 3, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user2'),
(366, 3777, '2020-05-26', '2020-05-26', 1, '---', 'Casual Leave', '---', 'Not feeling well.', '2/4 IT-A,2nd period assigned to user 2; 3/4 IT-A, 5th period assigned to user 3.', 'APPROVED', 'Leave Granted', '2020-05-24', '1', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(377, 3777, '2020-08-03', '2020-08-03', 1, '---', 'Casual Leave', '---', 'Personal', '1st Period -3/4 IT A \r\n3rd Period - 2/4 IT c ', 'APPROVED', 'OK', '2020-07-30', '1', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(381, 3777, '2020-08-10', '2020-08-10', 1, '---', 'Earned Leave', '---', 'km dffkgb', 'fnjkrngjk', 'APPROVED', 'approved', '2020-07-30', '0', 1, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(383, 3777, '2020-08-05', '2020-08-05', 1, '---', 'Permission', '14:30', 'mpogb', 'mkgbmfk', 'REJECTED', 'ok', '2020-07-30', '0', 0, '0', 1, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(384, 3777, '2020-08-10', '2020-08-11', 2, '---', 'Earned Leave', '---', 'jfk', 'nftnn', 'APPROVED', 'ok', '2020-07-30', '0', 2, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(385, 3777, '2020-08-05', '2020-08-05', 1, '---', 'Permission', '11:30', 'jhkmhgnf', 'trhyh', 'APPROVED', 'ok', '2020-07-30', '0', 0, '0', 1, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(386, 3777, '2020-08-06', '2020-08-06', 1, '---', 'Permission', '13:00', 'bfgmbkm', 'mkdfmkdg', 'APPROVED', 'approved', '2020-07-30', '0', 0, '0', 1, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(387, 3777, '2020-08-07', '2020-08-07', 0.5, '---', 'Extra Permission', '10:00', 'mbjgu', 'rtrhgn', 'APPROVED', 'ok', '2020-07-30', '0', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.5', 'user'),
(388, 3777, '2020-09-16', '2020-09-17', 2, '---', 'Casual Leave', '---', 'na ishtam', 'mee ishtam', 'REJECTED', 'LEave theesko', '2020-09-09', '2', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(389, 3777, '2020-09-16', '2020-09-16', 1, '---', 'Casual Leave', '---', 'gfntryhr', 'ghnghmymm', 'APPROVED', 'sarsarle', '2020-09-09', '1', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user'),
(390, 3777, '2021-01-20', '2021-01-21', 2, '---', 'Casual Leave', '---', 'COVID 19', 'dfsddekvmk', 'APPROVED', 'Approved', '2021-01-18', '2', 0, '0', 0, '0.0', '0.0', '0.0', 0, '0.0', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `holydays`
--
ALTER TABLE `holydays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EMPID` (`EMPID`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`EMPID`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tblleave`
--
ALTER TABLE `tblleave`
  ADD PRIMARY KEY (`LEAVEID`),
  ADD KEY `EMPID` (`EMPID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `holydays`
--
ALTER TABLE `holydays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblleave`
--
ALTER TABLE `tblleave`
  MODIFY `LEAVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD CONSTRAINT `EMPID` FOREIGN KEY (`EMPID`) REFERENCES `tblemployee` (`EMPID`);

--
-- Constraints for table `tblleave`
--
ALTER TABLE `tblleave`
  ADD CONSTRAINT `tblleave_ibfk_1` FOREIGN KEY (`EMPID`) REFERENCES `tblemployee` (`EMPID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
