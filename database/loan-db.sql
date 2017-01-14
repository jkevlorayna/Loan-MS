-- phpMyAdmin SQL Dump
-- version 4.2.8
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2017 at 12:08 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loan-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beneficiary`
--

CREATE TABLE IF NOT EXISTS `tbl_beneficiary` (
`Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `MemberId` int(11) NOT NULL,
  `Relationship` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_beneficiary`
--

INSERT INTO `tbl_beneficiary` (`Id`, `Name`, `MemberId`, `Relationship`) VALUES
(1, 'Beneficiary 1', 0, 'Husband'),
(2, 'Beneficiary 2', 0, 'Children'),
(3, 'test', 0, 'test'),
(4, 'asd', 38, 'asdasd'),
(5, 'adsad', 38, 'asd'),
(6, 'test', 37, 'tesasdasd'),
(7, '123', 37, '231'),
(8, 'son', 0, 'son'),
(9, 'mother', 0, 'mother'),
(10, 'ad', 0, 'adad'),
(11, 'asdad', 0, '232'),
(12, 'ad', 0, 'adad'),
(13, 'asdad', 0, '232'),
(14, 'ad', 44, 'adad'),
(15, 'asdad', 44, '232'),
(16, 'nellen sausa', 0, 'cousin'),
(17, 'lady lee', 46, 'sister'),
(18, 'marie rojo', 47, 'sister'),
(19, 'michelle ann sotela', 48, 'sister');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
`Id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_desc` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`Id`, `category_name`, `category_desc`) VALUES
(24, 'Hotels', 'Hotels List'),
(25, 'Resorts', '0'),
(26, 'Beach', '0'),
(27, 'Restuarant', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_center`
--

CREATE TABLE IF NOT EXISTS `tbl_center` (
`Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_center`
--

INSERT INTO `tbl_center` (`Id`, `Name`, `Address`) VALUES
(2, 'Center 3', 'Silay Sity'),
(3, 'Center 1', 'Silay City'),
(4, 'Center 2', 'Silay City'),
(5, 'Guinhalaran', 'Brgy.Guinhalaran, Silay City');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE IF NOT EXISTS `tbl_member` (
`Id` int(11) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `Middlename` varchar(100) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `MobileNo` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DateRegistered` date NOT NULL,
  `Age` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Business` varchar(200) NOT NULL,
  `CenterId` int(11) NOT NULL,
  `CoMaker` varchar(100) NOT NULL,
  `BirthDate` date NOT NULL,
  `ImageUrl` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`Id`, `Firstname`, `Lastname`, `Middlename`, `Gender`, `Address`, `MobileNo`, `Email`, `DateRegistered`, `Age`, `Status`, `Business`, `CenterId`, `CoMaker`, `BirthDate`, `ImageUrl`) VALUES
(25, 'Juan', 'Dela Cruz', 'D', 'Male', 'dasd', '', '', '2016-09-12', 13, 'Single', 'Sari - Sari Store', 2, '', '2003-08-20', '7453_Penguins.jpg'),
(27, 'Alfreds', 'Futterkiste', 'B', 'Male', 'da', 'dsad', '', '2016-09-17', 22, '', '', 3, '', '0000-00-00', '7096_Jellyfish.jpg'),
(28, 'Ana Trujillo', 'Emparedados y helados', 'B', 'Male', '', '', '', '2016-09-23', 0, '', '', 4, '', '0000-00-00', ''),
(31, 'White Clover', 'Markets', 'B', 'Female', 'dasd', '', '', '2016-09-07', 22, '', '', 2, '', '0000-00-00', ''),
(45, 'marie', 'rojo', 'f', 'Female', 'victorias', '0909897765', '', '2016-10-14', 25, 'Single', 'vendor', 5, '', '1991-01-09', ''),
(46, 'arian', 'baldostamon', 'c', 'Male', 'manapla', '', '', '2016-10-22', 21, 'Single', 'vendor', 5, '', '1995-10-03', ''),
(47, 'jeru', 'mijares', 'catalogo', 'Male', 'talisay', '0900965758', '', '2016-10-23', 21, 'Widow', 'vendor', 5, '', '1995-09-25', ''),
(48, 'anna mae', 'sotela', 'tumlos', 'Female', 'silay city', '09091234567', '', '2016-12-23', 20, 'Single', 'reseller', 5, '', '1996-12-19', '9242_Penguins.jpg'),
(49, 'NELLEN', 'SAUSA', 'AMBOT', 'Female', 'SILAY CITY', '0919999900', '', '2016-12-23', 23, 'Single', 'VENDOR', 2, '', '1993-10-30', '7355_Chrysanthemum.jpg'),
(50, 'ruby', 'yeso', 'melendrez', 'Female', 'brgy. 3,silay city', '', '', '2017-01-13', 20, 'Single', '', 2, '', '1996-08-15', '1745_Koala.jpg'),
(51, 'eliseo', 'beatingo', 'ayala', 'Female', 'guinhalaran, silay city', '123456678900', '', '2017-01-13', 23, 'Married', '', 5, '', '1993-03-21', '7861_Tulips.jpg'),
(52, 'dhanyel robert', 'canieso', 'juan', 'Male', 'brgy.5, silay city', '435-0789', '', '2017-01-13', 20, 'Single', '', 4, '', '1996-01-14', '3883_Desert.jpg'),
(53, 'john', 'lazy', 'yu', 'Male', 'silay city', '', '', '2017-01-13', 27, 'Married', 'fish vendor', 3, '', '1989-12-11', '2839_Hydrangeas.jpg'),
(54, 'inggo', 'moreno', 'luca', 'Male', 'silay city', '09234567800', '', '2017-01-13', 29, 'Separated', '', 2, '', '1987-08-31', '9401_Lighthouse.jpg'),
(55, 'jea', 'bautista', 'aguire', 'Male', 'cinco de noviembre, silay city', '09123456765', '', '2017-01-13', 38, 'Married', 'vendor', 4, '', '1978-06-27', '4966_Chrysanthemum.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_type`
--

CREATE TABLE IF NOT EXISTS `tbl_member_type` (
`Id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member_type`
--

INSERT INTO `tbl_member_type` (`Id`, `type`) VALUES
(1, 'Student'),
(3, 'Graduaties');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_payment` (
`Id` int(11) NOT NULL,
  `MemberId` int(11) NOT NULL,
  `Date` date NOT NULL,
  `KAB` decimal(12,2) NOT NULL,
  `CBU` decimal(12,2) NOT NULL,
  `MBA` decimal(12,2) NOT NULL,
  `CF` decimal(12,2) NOT NULL,
  `Total` decimal(12,2) NOT NULL,
  `Cycle` int(11) NOT NULL,
  `MF` decimal(12,2) NOT NULL,
  `LRF` decimal(12,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
`Id` int(11) NOT NULL,
  `role` varchar(100) NOT NULL,
  `OrderNo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`Id`, `role`, `OrderNo`) VALUES
(1, 'Loan Application', 1),
(2, 'Member', 2),
(3, 'Payment', 3),
(4, 'WithDraw', 4),
(5, 'Center', 5),
(6, 'User List', 6),
(7, 'User Type', 7),
(8, 'Loan Status', 8),
(9, 'Reports', 9),
(10, 'Setting', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

CREATE TABLE IF NOT EXISTS `tbl_setting` (
`Id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `settingKey` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`Id`, `title`, `settingKey`, `value`) VALUES
(4, 'Interest', 'INTEREST', '0.15'),
(6, 'CBU', 'CBU', '50'),
(7, 'MBA', 'MBA', '25'),
(8, 'MF', 'MF', '300'),
(9, 'CF', 'CF', '10'),
(10, 'LRF', 'LRF', '15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE IF NOT EXISTS `tbl_status` (
`Id` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`Id`, `Status`) VALUES
(2, 'Full Payment'),
(3, 'PastDue'),
(4, 'OverDue'),
(5, 'Restruct');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE IF NOT EXISTS `tbl_transaction` (
`Id` int(11) NOT NULL,
  `MemberId` decimal(11,0) NOT NULL,
  `Amount` decimal(12,2) NOT NULL,
  `WeeklyPayment` decimal(12,2) NOT NULL,
  `Date` date NOT NULL,
  `CBU` int(11) NOT NULL,
  `MBA` int(11) NOT NULL,
  `DueDate` date NOT NULL,
  `LoanStatus` varchar(100) NOT NULL,
  `TransactionStatus` varchar(100) NOT NULL,
  `DateReleased` date NOT NULL,
  `KAB` decimal(12,2) NOT NULL,
  `DateApproved` date NOT NULL,
  `Cycle` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`Id`, `MemberId`, `Amount`, `WeeklyPayment`, `Date`, `CBU`, `MBA`, `DueDate`, `LoanStatus`, `TransactionStatus`, `DateReleased`, `KAB`, `DateApproved`, `Cycle`) VALUES
(1, '25', '2000.00', '175.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Release', '2017-01-13', '100.00', '2016-12-23', 1),
(2, '27', '5000.00', '325.00', '2016-12-23', 50, 25, '0000-00-00', '', 'Release', '2016-12-23', '250.00', '2016-12-23', 1),
(3, '45', '2000.00', '175.00', '2016-12-23', 50, 25, '0000-00-00', '', 'Release', '2016-12-23', '100.00', '2016-10-14', 1),
(4, '46', '5000.00', '325.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '250.00', '2017-01-13', 1),
(5, '47', '3000.00', '225.00', '2016-12-23', 50, 25, '0000-00-00', '', 'Release', '2016-12-23', '150.00', '2016-10-23', 1),
(6, '28', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '200.00', '2017-01-13', 1),
(7, '31', '3000.00', '225.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '150.00', '2017-01-13', 1),
(9, '48', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Release', '2017-01-13', '200.00', '2017-01-13', 1),
(10, '49', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '200.00', '2017-01-13', 1),
(11, '55', '3000.00', '225.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '150.00', '2017-01-13', 1),
(12, '54', '3000.00', '225.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Pending', '0000-00-00', '150.00', '0000-00-00', 1),
(13, '53', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Pending', '0000-00-00', '200.00', '0000-00-00', 1),
(14, '50', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Pending', '0000-00-00', '200.00', '0000-00-00', 1),
(15, '54', '4000.00', '275.00', '2017-01-13', 50, 25, '0000-00-00', '', 'Approved', '0000-00-00', '200.00', '2017-01-13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
`user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `UserTypeId` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `name`, `username`, `password`, `UserTypeId`, `status`) VALUES
(4, 'Administrator', 'admin', 'admin', 0, 'Active'),
(8, 'das', 'sad', 'ds', 2, 'InActive'),
(9, 'das', 'das', 'dasd', 2, 'Active'),
(10, 'nellen sausa', 'nellen', 'nellen', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_user_roles` (
`Id` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AllowView` tinyint(4) NOT NULL,
  `AllowAdd` tinyint(4) NOT NULL,
  `AllowEdit` tinyint(4) NOT NULL,
  `AllowDelete` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`Id`, `RoleId`, `UserId`, `AllowView`, `AllowAdd`, `AllowEdit`, `AllowDelete`) VALUES
(49, 3, 5, 0, 0, 0, 0),
(50, 4, 5, 0, 0, 0, 0),
(51, 1, 3, 0, 0, 0, 0),
(52, 2, 3, 0, 0, 0, 0),
(53, 3, 3, 0, 0, 0, 0),
(54, 1, 10, 0, 0, 0, 0),
(55, 2, 10, 1, 0, 0, 0),
(56, 3, 10, 0, 0, 0, 0),
(57, 4, 10, 0, 0, 0, 0),
(58, 5, 10, 0, 0, 0, 0),
(59, 6, 10, 1, 0, 0, 0),
(60, 7, 10, 1, 0, 0, 0),
(61, 8, 10, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE IF NOT EXISTS `tbl_user_type` (
`Id` int(11) NOT NULL,
  `user_type` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`Id`, `user_type`) VALUES
(1, 'Manager'),
(2, 'Normal user');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdraw`
--

CREATE TABLE IF NOT EXISTS `tbl_withdraw` (
`Id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `MemberId` int(11) NOT NULL,
  `Amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_withdraw`
--

INSERT INTO `tbl_withdraw` (`Id`, `Date`, `MemberId`, `Amount`) VALUES
(3, '2016-10-18', 45, '100.00'),
(4, '2016-10-22', 46, '25.00'),
(5, '2016-10-22', 47, '10.00'),
(6, '2016-12-23', 25, '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year`
--

CREATE TABLE IF NOT EXISTS `tbl_year` (
`Id` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_year`
--

INSERT INTO `tbl_year` (`Id`, `year`) VALUES
(129, 2014),
(130, 2015),
(131, 2016),
(132, 2017),
(133, 2018),
(134, 2019),
(136, 2013);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_beneficiary`
--
ALTER TABLE `tbl_beneficiary`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_center`
--
ALTER TABLE `tbl_center`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_member_type`
--
ALTER TABLE `tbl_member_type`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_status`
--
ALTER TABLE `tbl_status`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
 ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_year`
--
ALTER TABLE `tbl_year`
 ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_beneficiary`
--
ALTER TABLE `tbl_beneficiary`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tbl_center`
--
ALTER TABLE `tbl_center`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `tbl_member_type`
--
ALTER TABLE `tbl_member_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_setting`
--
ALTER TABLE `tbl_setting`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_status`
--
ALTER TABLE `tbl_status`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tbl_year`
--
ALTER TABLE `tbl_year`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=137;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
