-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 09:17 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_order_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `fos_customer`
--

CREATE TABLE `fos_customer` (
  `Cus_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Mobile` varchar(11) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_customer`
--

INSERT INTO `fos_customer` (`Cus_ID`, `FirstName`, `LastName`, `Address`, `Mobile`, `Email`, `DateCreated`) VALUES
(3, 'Customer', 'Client', 'unilorin\r\n', '08023456789', 'user@example.com', '2021-09-22 16:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `fos_employee`
--

CREATE TABLE `fos_employee` (
  `Emp_ID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `JobTitle` varchar(100) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_employee`
--

INSERT INTO `fos_employee` (`Emp_ID`, `FirstName`, `LastName`, `JobTitle`, `Email`, `Address`, `PhoneNumber`, `DateCreated`) VALUES
(1, 'Staff', 'Employee', 'Cook', 'staff@example.com', 'F.O.S', '08098765432', '2021-09-22 16:22:05'),
(2, 'Admin', 'Administrator', 'Admininstrator', 'admin@example.com', 'Tanke Ilorin', '08034567892', '2021-09-23 08:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `fos_menu`
--

CREATE TABLE `fos_menu` (
  `Menu_ID` int(11) NOT NULL,
  `MenuCat_ID` int(11) NOT NULL,
  `MenName` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `Qtyinstock` int(11) NOT NULL DEFAULT 0,
  `BuyPrice` decimal(10,0) NOT NULL DEFAULT 0,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_menu`
--

INSERT INTO `fos_menu` (`Menu_ID`, `MenuCat_ID`, `MenName`, `Description`, `Qtyinstock`, `BuyPrice`, `DateCreated`) VALUES
(1, 1, 'Beef Burger', 'Description \r\n\r\nDescription \r\n\r\nDescription \r\n\r\nDescription \r\n\r\nDescription \r\n\r\nDescription \r\n\r\nDescription \r\n\r\nDescription \r\n\r\n', 10, '5000', '2021-09-17 16:23:54'),
(3, 1, 'Jam Doughnut', 'Sweet!!', 155, '500', '2021-09-22 08:00:23');

-- --------------------------------------------------------

--
-- Table structure for table `fos_menucategory`
--

CREATE TABLE `fos_menucategory` (
  `MenuCat_ID` int(11) NOT NULL,
  `MenName` varchar(255) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_menucategory`
--

INSERT INTO `fos_menucategory` (`MenuCat_ID`, `MenName`, `Image`, `DateCreated`) VALUES
(1, 'Snacks', 'http://localhost/food-os/uploads/b3bdf1b8e3-burger.jpg', '2021-09-16 12:33:06'),
(10, 'Cookees', 'http://localhost/food-os/uploads/8ab8041a81-1600652880_chicken.jpg', '2021-10-25 03:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `fos_order`
--

CREATE TABLE `fos_order` (
  `Ord_ID` int(11) NOT NULL,
  `Cus_ID` int(11) NOT NULL,
  `Emp_ID` int(11) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `ShippedDate` datetime DEFAULT NULL,
  `Status` enum('pending','delivered','in_route') NOT NULL DEFAULT 'pending',
  `Comments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_order`
--

INSERT INTO `fos_order` (`Ord_ID`, `Cus_ID`, `Emp_ID`, `OrderDate`, `ShippedDate`, `Status`, `Comments`, `DateCreated`) VALUES
(27, 3, 2, '2021-10-25 08:41:01', '2021-10-25 05:51:34', 'in_route', NULL, '2021-10-25 04:41:01'),
(29, 3, NULL, '2021-10-25 17:32:08', NULL, 'pending', NULL, '2021-10-25 13:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `fos_orderdetails`
--

CREATE TABLE `fos_orderdetails` (
  `OrderDetails_ID` int(11) NOT NULL,
  `Ord_ID` int(11) NOT NULL,
  `Menu_ID` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `UnitPrice` decimal(10,0) NOT NULL,
  `DateCreated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_orderdetails`
--

INSERT INTO `fos_orderdetails` (`OrderDetails_ID`, `Ord_ID`, `Menu_ID`, `Qty`, `UnitPrice`, `DateCreated`) VALUES
(19, 27, 1, 1, '5000', '2021-10-25 04:41:02'),
(21, 29, 1, 3, '5000', '2021-10-25 13:32:08');

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('cus','emp','adm','') NOT NULL DEFAULT 'cus',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fos_user`
--

INSERT INTO `fos_user` (`id`, `email`, `type`, `password`) VALUES
(1, 'user@example.com', 'cus', 'password'),
(2, 'admin@example.com', 'adm', 'password'),
(3, 'staff@example.com', 'emp', 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fos_customer`
--
ALTER TABLE `fos_customer`
  ADD PRIMARY KEY (`Cus_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Mobile` (`Mobile`);

--
-- Indexes for table `fos_employee`
--
ALTER TABLE `fos_employee`
  ADD PRIMARY KEY (`Emp_ID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`);

--
-- Indexes for table `fos_menu`
--
ALTER TABLE `fos_menu`
  ADD PRIMARY KEY (`Menu_ID`),
  ADD UNIQUE KEY `MenName` (`MenName`),
  ADD KEY `MenuCat_ID` (`MenuCat_ID`);

--
-- Indexes for table `fos_menucategory`
--
ALTER TABLE `fos_menucategory`
  ADD PRIMARY KEY (`MenuCat_ID`),
  ADD UNIQUE KEY `MenName` (`MenName`);

--
-- Indexes for table `fos_order`
--
ALTER TABLE `fos_order`
  ADD PRIMARY KEY (`Ord_ID`),
  ADD KEY `Cus_ID` (`Cus_ID`),
  ADD KEY `Emp_ID` (`Emp_ID`);

--
-- Indexes for table `fos_orderdetails`
--
ALTER TABLE `fos_orderdetails`
  ADD PRIMARY KEY (`OrderDetails_ID`),
  ADD KEY `Ord_ID` (`Ord_ID`),
  ADD KEY `Menu_ID` (`Menu_ID`);

--
-- Indexes for table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fos_customer`
--
ALTER TABLE `fos_customer`
  MODIFY `Cus_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fos_employee`
--
ALTER TABLE `fos_employee`
  MODIFY `Emp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fos_menu`
--
ALTER TABLE `fos_menu`
  MODIFY `Menu_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fos_menucategory`
--
ALTER TABLE `fos_menucategory`
  MODIFY `MenuCat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fos_order`
--
ALTER TABLE `fos_order`
  MODIFY `Ord_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `fos_orderdetails`
--
ALTER TABLE `fos_orderdetails`
  MODIFY `OrderDetails_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fos_customer`
--
ALTER TABLE `fos_customer`
  ADD CONSTRAINT `fos_customer_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `fos_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fos_employee`
--
ALTER TABLE `fos_employee`
  ADD CONSTRAINT `fos_employee_ibfk_1` FOREIGN KEY (`Email`) REFERENCES `fos_user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fos_menu`
--
ALTER TABLE `fos_menu`
  ADD CONSTRAINT `fos_menu_ibfk_1` FOREIGN KEY (`MenuCat_ID`) REFERENCES `fos_menucategory` (`MenuCat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fos_order`
--
ALTER TABLE `fos_order`
  ADD CONSTRAINT `fos_order_ibfk_1` FOREIGN KEY (`Cus_ID`) REFERENCES `fos_customer` (`Cus_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fos_order_ibfk_2` FOREIGN KEY (`Emp_ID`) REFERENCES `fos_employee` (`Emp_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fos_orderdetails`
--
ALTER TABLE `fos_orderdetails`
  ADD CONSTRAINT `fos_orderdetails_ibfk_1` FOREIGN KEY (`Ord_ID`) REFERENCES `fos_order` (`Ord_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fos_orderdetails_ibfk_2` FOREIGN KEY (`Menu_ID`) REFERENCES `fos_menu` (`Menu_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
