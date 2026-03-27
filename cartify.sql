-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2026 at 01:11 PM
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
-- Database: `cartify`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `zip_code` varchar(20) DEFAULT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `total_orders` int(11) DEFAULT 1,
  `total_spent` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `first_name`, `last_name`, `email`, `phone`, `address`, `city`, `state`, `country`, `zip_code`, `order_number`, `total_amount`, `total_orders`, `total_spent`, `created_at`) VALUES
(1, 'Shanza', 'Naveed', 'shanzanaveed005@gmail.com', '2345144444', 'kahuta', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20251227-5581', 10.00, 1, 10.00, '2025-12-27 19:35:39'),
(2, 'Ayesha', 'yasmeen', 'shanzanaveed005@gmail.com', '2345144444', 'abcdfgh', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260105-9929', 1999.00, 1, 1999.00, '2026-01-05 16:09:02'),
(3, 'aleeza', 'maryam', 'shanzanaveed005@gmail.com', '022211234567', 'kahuta', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260105-8125', 0.00, 1, 0.00, '2026-01-05 16:12:08'),
(4, 'Irsa', 'maryam', 'shanzanaveed005@gmail.com', '03001234567', 'kahuta', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260105-3872', 0.00, 1, 0.00, '2026-01-05 16:13:14'),
(5, 'Rubab', 'Fatima', 'shanzanaveed005@gmail.com', '03112345678', 'ara mohallah', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260106-7943', 701999.00, 1, 701999.00, '2026-01-06 04:38:38'),
(6, 'Rubab', 'Fatima', 'irsarazzaq1@gmail.com', '03112345678', 'ara mohallah', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260106-2779', 701999.00, 1, 701999.00, '2026-01-06 04:44:33'),
(7, 'Rubab', 'Fatima', 'irsarazzaq1@gmail.com', '03112345678', 'ara mohallah', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260106-4554', 701999.00, 1, 701999.00, '2026-01-06 04:44:50'),
(8, 'shanza', 'naveed', 'shanzanaveed005@gmail.com', '2345144444', 'kahuta', 'kahuta', 'punjab', 'Pakistan', '47330', 'ORD-20260106-1150', 701999.00, 1, 701999.00, '2026-01-06 06:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `sold_count` int(11) DEFAULT 0,
  `status` enum('active','inactive','draft') DEFAULT 'active',
  `image` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `sku`, `brand`, `category`, `product_price`, `discount_price`, `stock`, `sold_count`, `status`, `image`, `short_description`, `description`, `created_at`) VALUES
(1, 'White iphone', 'TSH-001', 'iphone', 'phone', 2500.00, 1999.00, 50, 0, 'active', 'iphone.jfif', 'Pure cotton comfort fit t-shirt.', 'This is a high-quality cotton t-shirt perfect for summer wear and casual outings.', '2025-12-23 14:21:31'),
(2, 'jacket', 'PROD-008', 'wooley wonders', 'fashion', 3000.00, 2900.00, 10, 0, 'active', 'jacket.jfif', 'brown jacket', 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeemmm', '2025-12-26 16:50:25'),
(3, 'cardigan', 'PROD-006', 'wooley wonders', 'fashion', 3000.00, 2500.00, 5, 0, 'active', '1766764358_WhatsApp Image 2025-12-24 at 7.57.18 PM.jpeg', 'soft and warm', 'a knitted jumper fastening down the front.', '2025-12-27 19:32:23'),
(4, 'Tint', 'PROD-009', 'Rivaj', 'beauty', 250.00, 230.00, 5, 0, 'active', 'tint.jpg', 'Jelly tint', 'Best for dried lips', '2025-12-29 17:57:02'),
(5, 'football', 'PROD-016', 'FB', 'sports', 500.00, 0.00, 10, 0, 'active', 'download (6).jfif', '', '', '2026-01-05 15:57:19'),
(6, 'foundation', 'PROD-011', 'Rivaj', 'beauty', 5000.00, 0.00, 8, 0, 'active', 'download (2).jfif', '', '', '2026-01-05 15:58:23'),
(7, 'Muffler', 'PROD-012', 'wooley wonders', 'fashion', 400.00, 390.00, 5, 3, 'active', 'download (9).jfif', 'warm and soft', '', '2026-01-05 15:59:49'),
(8, 'Novel', 'PROD-013', 'books', '', 1000.00, 900.00, 7, 1, 'active', 'download (7).jfif', '', '', '2026-01-05 16:01:05'),
(9, 'Pen', 'PROD-014', 'stationary', '', 99.99, 80.00, 4, 1, 'active', 'pen.png', 'abc', 'sss', '2026-01-05 16:03:39'),
(10, 'lip balm', 'PROD-019', 'Rhode', 'beauty', 5000.00, 4500.00, 10, 1, 'active', 'rhode.jfif', '', '', '2026-01-05 16:04:40'),
(11, 'Phone', 'PROD-021', 'Iphone', 'mobile', 700000.00, 699999.00, 5, 1, 'active', 'download (3).jfif', 'iphone', 'orange color phone', '2026-01-06 04:31:59'),
(12, 'Macbook', 'PROD-022', 'Apple', 'laptops', 800000.00, 700000.00, 4, 0, 'active', 'download (4).jfif', 'Metallic grey', '64 TB', '2026-01-06 04:36:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_items_order` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
