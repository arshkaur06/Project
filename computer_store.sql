-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2025 at 05:13 AM
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
-- Database: `computer_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptops'),
(2, 'Desktops'),
(3, 'Monitors'),
(4, 'Keyboards'),
(5, 'Mouse'),
(6, 'Graphic Cards');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_email`, `total_price`, `created_at`) VALUES
(1, 'hsaini@yahoo.com', 2808.89, '2025-07-22 02:50:00'),
(2, 'hsaini@yahoo.com', 2808.89, '2025-07-22 02:51:53'),
(3, 'hsaini@yahoo.com', 7207.89, '2025-07-22 02:52:23'),
(4, 'hsaini@yahoo.com', 649.77, '2025-07-22 02:54:20'),
(5, 'hsaini@yahoo.com', 5018.78, '2025-07-22 02:54:50'),
(6, 'hsaini@yahoo.com', 2808.89, '2025-07-22 02:58:18'),
(7, 'hsaini@yahoo.com', 2808.89, '2025-07-22 03:01:08'),
(8, 'hsaini@yahoo.com', 2808.89, '2025-07-22 03:03:44'),
(9, 'hsaini@yahoo.com', 7237.88, '2025-07-22 03:07:01'),
(10, 'psmith01@gmail.com', 7207.89, '2025-07-22 03:10:54'),
(11, 'psmith01@gmail.com', 10016.78, '2025-07-22 03:11:29'),
(12, 'psmith01@gmail.com', 4428.99, '2025-07-22 03:15:26'),
(13, 'hsingh@gmail.com', 4428.99, '2025-07-22 03:16:36'),
(14, 'hsaini@yahoo.com', 5207.89, '2025-07-22 03:54:56'),
(15, 'hsaini@yahoo.com', 4708.89, '2025-07-22 16:12:27'),
(16, 'psmith01@gmail.com', 4708.89, '2025-07-23 18:38:41'),
(17, 'psmith01@gmail.com', 2808.89, '2025-07-23 18:39:30'),
(18, 'psmith01@gmail.com', 2808.89, '2025-07-23 18:43:57'),
(19, 'psmith01@gmail.com', 2808.89, '2025-07-23 18:48:22'),
(20, 'psmith01@gmail.com', 3118.78, '2025-07-23 18:49:55'),
(21, 'psmith01@gmail.com', 3118.78, '2025-07-23 20:15:01'),
(22, 'psmith01@gmail.com', 4708.89, '2025-07-23 20:24:15'),
(23, 'c.alex@gmail.com', 7207.89, '2025-07-23 20:26:50'),
(24, 'c.alex@gmail.com', 1608.89, '2025-07-23 21:38:42'),
(25, 'c.alex@gmail.com', 3648.00, '2025-07-23 21:41:47'),
(26, 'c.alex@gmail.com', 2808.89, '2025-07-24 13:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 8, 2, 1, 2499.00),
(2, 8, 3, 1, 309.89),
(3, 9, 2, 1, 2499.00),
(4, 9, 3, 1, 309.89),
(5, 9, 4, 1, 4399.00),
(6, 9, 7, 1, 29.99),
(7, 10, 2, 1, 2499.00),
(8, 10, 3, 1, 309.89),
(9, 10, 4, 1, 4399.00),
(10, 11, 3, 2, 309.89),
(11, 11, 2, 2, 2499.00),
(12, 11, 4, 1, 4399.00),
(13, 12, 7, 1, 29.99),
(14, 12, 4, 1, 4399.00),
(15, 13, 4, 1, 4399.00),
(16, 13, 7, 1, 29.99),
(17, 14, 3, 1, 309.89),
(18, 14, 4, 1, 4399.00),
(19, 14, 5, 1, 499.00),
(20, 15, 3, 1, 309.89),
(21, 15, 4, 1, 4399.00),
(22, 19, 2, 1, 2499.00),
(23, 19, 3, 1, 309.89),
(24, 20, 3, 2, 309.89),
(25, 20, 2, 1, 2499.00),
(26, 21, 3, 2, 309.89),
(27, 21, 2, 1, 2499.00),
(28, 22, 3, 1, 309.89),
(29, 22, 4, 1, 4399.00),
(30, 23, 3, 1, 309.89),
(31, 23, 2, 1, 2499.00),
(32, 23, 4, 1, 4399.00),
(33, 24, 3, 1, 309.89),
(34, 24, 14, 1, 1299.00),
(35, 25, 1, 1, 1149.00),
(36, 25, 2, 1, 2499.00),
(37, 26, 2, 1, 2499.00),
(38, 26, 3, 1, 309.89);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category_id`) VALUES
(1, 'Dell Laptop', 'Dell Inspiron 15.6\" FHD Touchscreen Laptop, Intel Core i7-1255U, 1TB SSD, 32GB RAM, Intel Iris Xe Graphics, Win11,Black', 1149.00, 'Dell 17.png', 1),
(2, 'MacBook Pro', 'Open Box - Apple MacBook Pro 14.2\" (Fall 2024) - Space Black (Apple M4 Pro / 24GB RAM / 512GB SSD) - En', 2499.00, 'Mac.png', 0),
(3, 'Lenovo Monitor', 'Brand New - Lenovo ThinkVision T27p-10 - Type 61DA - 27\" Monitor - UHD, IPS, HDMI, DP, USBC - 4k Display (3840 x 2160)', 309.89, 'Lenovo2.png', 3),
(4, 'MSI Gaming Laptop', 'MSI Vector A18 HX 18\" Gaming Laptop - Cosmos Grey (AMD Ryzen 9 9955HX/32GB RAM/2TB SSD/GeForce RTX 5080)', 4399.00, 'MSI.png', 1),
(5, 'EVGA Graphic Cards', 'EVGA GeForce GTX 1660 SUPER Graphic Card - 6 GB GDDR5', 499.00, 'GC1.png', 6),
(6, 'ASUS Graphic Card', 'ASUS Prime RTX 5070 Ti OC 16GB GDDR7 Video Card', 1219.00, 'GC2.png', 6),
(7, 'Logitech mouse', 'Logitech M325S Wireless Optical Mouse - Black', 29.99, 'Mouse1.png', 5),
(8, 'Lenovo Desktop', 'Lenovo IdeaCentre Desktop PC - Luna Grey (Intel Core i7-13620H/16GB RAM/1TB SSD/Windows 11)\r\n', 1149.00, 'Lenovo Desktop.png', 2),
(9, 'Razer Gaming Keyboard', 'Razer BlackWidow V4 X Mechanical Gaming Keyboard with Chroma RGB - Black', 189.99, 'Keyboard1.png', 4),
(10, 'HP Gaming Laptop', 'HP OMEN MAX 16 16\" Gaming Laptop - Shadow Black (Intel Core Ultra 7 255HX/16GB RAM/1TB SSD/GeForce RTX 5060)', 2799.00, 'HP.png', 1),
(11, 'Dell Laptop', 'Refurbished -Excellent Condition Dell 7410 Laptop - 16GB RAM, SUPER FAST 1 TB NVME , Quad-Core 10th Gen Intel i5 10310U, Full HD - 1920 x 1080-Win. 11 Pro ( FREE LAPTOP BAG )', 469.00, 'Dell 17.png', 1),
(13, 'Razer Gaming Mouse', 'Razer DeathAdder Essential 6400 DPI Gaming Mouse - Black', 39.00, 'Mouse2.png', 5),
(14, 'Dell Laptop', 'Dell Inspiron 15.6\" FHD Touchscreen Laptop, Intel Core i7-1255U, 1TB SSD, 32GB RAM, Intel Iris Xe Graphics, Win11,Black', 1299.00, 'Dell2.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `postalCode` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `userName`, `email`, `password`, `address`, `city`, `province`, `postalCode`, `created_at`) VALUES
(1, 'Arshdeep', 'Kaur', 'akur', 'akaur@gmail.com', '$2y$12$ueXRgdnLGFFVNzlgoym46.MVnmttHRTWZ4NmneiwxyoJzNM5PFbH2', '180  St South', 'Elizabeth', 'Ontario', 'L6Y 1R7', '2025-07-21 23:28:47'),
(2, 'Harry', 'Saini', 'Harry', 'hsaini@yahoo.com', '$2y$12$nI10DVaZgkxD9kSxBAUVhuzrBwwyvmv/VCgKj/O2bFpoBoXatdiOi', '163 Tiller Trail', 'Brampton', 'Ontario', 'L6X 4S9', '2025-07-22 02:42:48'),
(3, 'Parry', 'Smith', 'Parry', 'psmith01@gmail.com', '$2y$12$WawOO9uCGOh3XX7NkH8ouutx9unZUkwOv6M0VwhTV/ZVELRU8rmMC', '163 Tiller Trail', 'Brampton', 'Ontario', 'L6X 4S9', '2025-07-22 03:10:29'),
(4, 'Harry', 'Singh', 'Harry', 'hsingh@gmail.com', '$2y$12$WWAc2lVJLs9ezh/14lBiUeVxmO2t0XoHICaCqzSMKPYKJgiel3Zym', '70 Yellow Brick Rd', 'Brampton', 'Ontario', 'L6V 4K9', '2025-07-22 03:16:08'),
(5, 'Celeena', 'Alex', 'Celeena', 'c.alex@gmail.com', '$2y$12$c7LT2dysNCcyNCcK8CO9s.FPfz7oWAH6zQ7w3BhH3lSoMZ6LkqwiS', '180  St South', 'Elizabeth', 'Ontario', 'L6Y 1R7', '2025-07-23 20:26:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
