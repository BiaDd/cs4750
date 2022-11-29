-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 03:07 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipen`
--

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `emailID` int(11) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `grocerycart`
--

CREATE TABLE `grocerycart` (
  `cartID` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocerycart`
--

INSERT INTO `grocerycart` (`cartID`, `totalPrice`) VALUES
(1, '0.00'),
(15, '0.00'),
(16, '0.00'),
(17, '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredientID` int(11) NOT NULL,
  `ingredientName` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `ingredientType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`ingredientID`, `ingredientName`, `price`, `ingredientType`) VALUES
(13, 'Salt', '0.10', 'Additive'),
(14, 'Pepper', '0.10', 'Additive'),
(15, 'Sugar', '0.10', 'Additive'),
(16, 'Vinegar', '0.10', 'Additive'),
(17, 'Flour', '0.10', 'Baking'),
(18, 'Rice', '0.10', 'Cereal'),
(19, 'Butter', '0.10', 'Dairy'),
(20, 'Milk', '0.10', 'Dairy'),
(21, 'Salmon', '0.10', 'Fish'),
(22, 'Tuna', '0.10', 'Fish'),
(23, 'Salmon', '0.10', 'Fish'),
(24, 'Anchovy', '0.10', 'Fish'),
(25, 'Apple', '0.10', 'Fruits'),
(26, 'Lime', '0.10', 'Fruits'),
(27, 'Orange', '0.10', 'Fruits'),
(28, 'Avocado', '0.10', 'Fruits'),
(29, 'Bacon', '0.10', 'Meats'),
(30, 'Chicken Breast', '0.10', 'Meats'),
(31, 'Ground Beef', '0.10', 'Meats'),
(32, 'Peanut', '0.10', 'Nuts'),
(33, 'Pecan', '0.10', 'Nuts'),
(34, 'Almond', '0.10', 'Nuts'),
(35, 'Shrimp', '0.10', 'Seafood'),
(36, 'Oyster', '0.10', 'Seafood'),
(37, 'Kaprika', '0.10', 'Seasonings'),
(38, 'Chili Powder', '0.10', 'Seasonings'),
(39, 'Cinnamon', '0.10', 'Seasonings'),
(40, 'Barbecue Sauce', '0.10', 'Sauces'),
(41, 'Soy Sauce', '0.10', 'Sauces'),
(42, 'Broccoli', '0.10', 'Vegetables'),
(43, 'Carrot', '0.10', 'Vegetables'),
(44, 'Spinach', '0.10', 'Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `recipe`
--

CREATE TABLE `recipe` (
  `recipeID` int(11) NOT NULL,
  `recipeName` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `rating` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `userID` int(11) DEFAULT NULL
) ;

--
-- Dumping data for table `recipe`
--

INSERT INTO `recipe` (`recipeID`, `recipeName`, `description`, `rating`, `price`, `userID`) VALUES
(30, 'rice cake', 'cake made of rice', '0.00', '0.00', 15),
(31, 'shrimp', 'just shrimp', '0.00', '0.00', 15),
(32, 'Broccoli Soy', 'Broccoli and soy sauce', '0.00', '0.20', 15),
(33, 'asd', 'asd', '0.00', '0.20', 15),
(34, 'Pizza', 'cheese pizza on bread', '0.00', '0.20', 15);

-- --------------------------------------------------------

--
-- Table structure for table `recipecart`
--

CREATE TABLE `recipecart` (
  `cartID` int(11) DEFAULT NULL,
  `recipeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `recipeingredient`
--

CREATE TABLE `recipeingredient` (
  `ingredientID` int(11) NOT NULL,
  `recipeID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recipeingredient`
--

INSERT INTO `recipeingredient` (`ingredientID`, `recipeID`, `quantity`) VALUES
(13, 33, 3),
(17, 30, 1),
(18, 30, 1),
(19, 34, 2),
(35, 31, 1),
(38, 34, 3),
(40, 34, 2),
(41, 32, 2),
(42, 32, 2);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewID` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `firstName`, `lastName`, `password`) VALUES
(1, 'admin', 'Admin', 'User', 'password'),
(15, 'testuser3', 'test', 'test', '$2y$10$Fw.9t3YBBErBfj4sddee2u0GfvnNGSPQmazpxzcFPfESYEeABS6LG'),
(16, 'testuser4', 'test', 'test', '$2y$10$VrF/5nfyjb1o4JHjXLCKMOJef2wS5OD7Pf9ohnyf1WCA/Gmaoa6pK'),
(17, 'pumpkinpie', 'pumpkin', 'pie', '$2y$10$5lIXG7WtEi2gGXI3l9a75uSZRE6n2IohKkrpMDRJ7XHzkeILv4Ou2');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `createUserCartRelationship` AFTER INSERT ON `user` FOR EACH ROW INSERT INTO usercart (userID, cartID) VALUES(NEW.userID, NEW.userID)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usercart`
--

CREATE TABLE `usercart` (
  `userID` int(11) NOT NULL,
  `cartID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usercart`
--

INSERT INTO `usercart` (`userID`, `cartID`) VALUES
(15, 15),
(16, 16),
(17, 17);

--
-- Triggers `usercart`
--
DELIMITER $$
CREATE TRIGGER `createCartForUser` AFTER INSERT ON `usercart` FOR EACH ROW INSERT INTO grocerycart (cartID, totalPrice)
VALUES(NEW.cartID, 0)
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`emailID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `grocerycart`
--
ALTER TABLE `grocerycart`
  ADD PRIMARY KEY (`cartID`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredientID`);

--
-- Indexes for table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`recipeID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `recipeingredient`
--
ALTER TABLE `recipeingredient`
  ADD PRIMARY KEY (`ingredientID`,`recipeID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `usercart`
--
ALTER TABLE `usercart`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `emailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grocerycart`
--
ALTER TABLE `grocerycart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `recipeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
