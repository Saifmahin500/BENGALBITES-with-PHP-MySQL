-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2025 at 08:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BengalBitesDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `photo`, `created_at`) VALUES
(2, 'Admin', '$2y$10$3rNjSUaZ0p.SrjNfvIX3Q.w3HXxd2.nD8HahvbMQNFPgnOl/Uvmfm', 'saifmahin500@gmail.com', '1755963402-445026739_863740485589199_2716904704286492140_n.jpg', '2025-08-04 10:09:35');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sizes` varchar(200) DEFAULT NULL,
  `colors` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('open','ordered') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 7, 'ordered', '2025-09-02 13:03:42', '2025-09-19 22:16:25'),
(2, 2, 'open', '2025-09-18 18:19:03', '2025-09-18 18:19:03'),
(3, 7, 'ordered', '2025-09-19 22:18:25', '2025-09-19 22:18:37'),
(4, 7, 'ordered', '2025-09-19 22:34:00', '2025-09-19 22:38:02'),
(5, 7, 'ordered', '2025-09-19 22:44:40', '2025-09-19 22:45:00'),
(6, 7, 'ordered', '2025-09-19 22:52:21', '2025-09-19 22:52:49'),
(7, 7, 'ordered', '2025-09-19 22:55:16', '2025-09-19 22:55:35'),
(8, 7, 'ordered', '2025-09-20 01:10:54', '2025-09-20 01:11:30'),
(9, 7, 'ordered', '2025-09-20 01:14:11', '2025-09-20 01:14:22'),
(10, 7, 'ordered', '2025-09-20 01:25:40', '2025-09-20 01:25:53'),
(11, 7, 'ordered', '2025-09-20 03:49:34', '2025-09-20 03:57:19'),
(12, 7, 'ordered', '2025-09-20 04:21:52', '2025-09-20 04:24:14'),
(13, 8, 'open', '2025-09-20 04:36:47', '2025-09-20 04:36:47'),
(14, 7, 'open', '2025-09-20 04:40:32', '2025-09-20 04:40:32'),
(15, 9, 'ordered', '2025-09-21 10:43:29', '2025-09-21 10:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `qty`, `unit_price`, `created_at`) VALUES
(4, 2, 19, 2, 1999.00, '2025-09-18 18:19:03'),
(5, 2, 25, 2, 2290.00, '2025-09-18 18:19:06'),
(6, 2, 34, 1, 4500.00, '2025-09-18 18:19:09'),
(7, 2, 29, 1, 899.00, '2025-09-18 21:24:14'),
(59, 13, 55, 1, 130.00, '2025-09-20 04:36:47');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(6) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(4, 'Foods', '2025-07-31'),
(6, 'Desserts', '2025-09-20'),
(7, 'Beverages', '2025-09-20'),
(8, 'Combo Meals', '2025-09-20'),
(9, 'Pasta & Noodles', '2025-09-20'),
(10, 'Fried & Snacks', '2025-09-20'),
(11, 'Fried & Snacks', '2025-09-20'),
(12, 'Sandwich & Wraps', '2025-09-20'),
(13, 'Pizza', '2025-09-20'),
(14, 'Burgers', '2025-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text DEFAULT NULL,
  `is_replied` tinyint(1) DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `reply_text` text DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`id`, `name`, `email`, `subject`, `message`, `is_replied`, `is_read`, `reply_text`, `replied_at`, `created_at`) VALUES
(2, 'saif', 'saifpwad@gmail.com', 'req', 'hello', 1, 1, 'hii', '2025-08-23 21:14:03', '2025-08-23 15:12:11'),
(3, 'mahin', 'saifmahin500@gmail.com', 'req', 'gello', 1, 1, 'hello', '2025-08-23 21:15:42', '2025-08-23 15:15:14'),
(4, 'nomayen', 'nomayen.ohin@gmail.com', 'order cancel', 'My order cancel now \r\ni changed my mind', 1, 1, 'Thank You sir \nfor your report', '2025-08-23 21:17:47', '2025-08-23 15:17:18'),
(9, 'saif uddin', 'saifmahin500@gmail.com', 'req', '58546gujhggf', 1, 1, 'hello', '2025-08-24 10:40:07', '2025-08-24 03:36:36'),
(10, 'mohi uddin', 'saifpwad@gmail.com', 'req', 'dskjhgdsdg', 1, 1, 'salam', '2025-08-24 10:47:17', '2025-08-24 04:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `scope` enum('all','product') NOT NULL DEFAULT 'all',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `usage_count` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_percent`, `scope`, `status`, `start_date`, `end_date`, `usage_limit`, `usage_count`, `created_at`) VALUES
(1, 'mahin150', 15.00, 'product', 'active', '2025-09-19', '2025-09-21', NULL, 0, '2025-09-19 18:53:27'),
(2, 'big10', 10.00, 'all', 'active', '2025-09-19', '2025-09-22', 10, 0, '2025-09-19 19:05:13'),
(3, 'save10', 10.00, 'all', 'active', '2025-09-20', '2025-09-21', 2, 0, '2025-09-20 02:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_products`
--

CREATE TABLE `coupon_products` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon_products`
--

INSERT INTO `coupon_products` (`id`, `coupon_id`, `product_id`) VALUES
(1, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `change_type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `change_type`, `quantity`, `remarks`, `created_at`) VALUES
(15, 58, 'in', 10, 'Added By Mahin', '2025-09-21 04:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `global_order_id` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `coupon_code` varchar(64) NOT NULL,
  `coupon_discount` decimal(10,2) NOT NULL,
  `payable_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','delivered','completed','canceled') NOT NULL DEFAULT 'pending',
  `area` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `delivery_man_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `global_order_id`, `user_id`, `user_name`, `phone`, `address`, `product_id`, `quantity`, `order_date`, `coupon_code`, `coupon_discount`, `payable_amount`, `status`, `area`, `total_amount`, `delivery_man_id`) VALUES
(11, 'ORD68CD81D91BB0B', 7, 'saif', '01856590532', ' sdfghjk', 14, 1, '2025-09-19 22:16:25', 'big10', 62.45, 687.55, 'pending', 'mirpur', 750.00, 0),
(12, 'ORD68CD81D91BB0B', 7, 'saif', '01856590532', ' sdfghjk', 16, 1, '2025-09-19 22:16:25', 'big10', 62.45, 436.55, 'pending', 'mirpur', 499.00, 0),
(13, 'ORD68CD825D8F008', 7, 'saif', '01856590532', ' asdfghj', 15, 1, '2025-09-19 22:18:37', '', 0.00, 550.00, 'pending', 'mirpur', 550.00, 0),
(14, 'ORD68CD825D8F008', 7, 'saif', '01856590532', ' asdfghj', 20, 1, '2025-09-19 22:18:37', '', 0.00, 2190.00, 'pending', 'mirpur', 2190.00, 0),
(15, 'ORD68CD86EA73B44', 7, 'saif', '01856590532', ' feni', 18, 1, '2025-09-19 22:38:02', '', 0.00, 1999.00, 'pending', 'mirpur', 1999.00, 0),
(16, 'ORD68CD86EA73B44', 7, 'saif', '01856590532', ' feni', 27, 1, '2025-09-19 22:38:02', '', 0.00, 4500.00, 'pending', 'mirpur', 4500.00, 0),
(17, 'ORD68CD888C068CD', 7, 'saif', '01856590532', ' dhaka', 14, 1, '2025-09-19 22:45:00', '', 0.00, 750.00, 'pending', 'mirpur', 750.00, 0),
(18, 'ORD68CD888C068CD', 7, 'saif', '01856590532', ' dhaka', 18, 1, '2025-09-19 22:45:00', '', 0.00, 1999.00, 'pending', 'mirpur', 1999.00, 0),
(19, 'ORD68CD8A61990F1', 7, 'saif', '01856590532', ' Dhaka,bangladesh', 23, 1, '2025-09-19 22:52:49', 'big10', 89.45, 809.55, 'pending', 'mirpur', 899.00, 0),
(20, 'ORD68CD8A61990F1', 7, 'saif', '01856590532', ' Dhaka,bangladesh', 24, 1, '2025-09-19 22:52:49', 'big10', 89.45, 800.55, 'pending', 'mirpur', 890.00, 0),
(21, 'ORD68CD8B0774715', 7, 'saif', '01856590532', ' Dhaka', 14, 1, '2025-09-19 22:55:35', 'big10', 62.45, 687.55, 'pending', 'mirpur', 750.00, 0),
(22, 'ORD68CD8B0774715', 7, 'saif', '01856590532', ' Dhaka', 16, 1, '2025-09-19 22:55:35', 'big10', 62.45, 436.55, 'pending', 'mirpur', 499.00, 0),
(23, 'ORD68CDAAE2A786C', 7, 'saif', '01856590532', ' dhaka', 26, 1, '2025-09-20 01:11:30', 'big10', 154.58, 2344.42, 'pending', 'mirpur', 2499.00, 0),
(24, 'ORD68CDAAE2A786C', 7, 'saif', '01856590532', ' dhaka', 10, 1, '2025-09-20 01:11:30', 'big10', 154.58, 395.42, 'pending', 'mirpur', 550.00, 0),
(25, 'ORD68CDAAE2A786C', 7, 'saif', '01856590532', ' dhaka', 20, 1, '2025-09-20 01:11:30', 'big10', 154.58, 2035.42, 'pending', 'mirpur', 2190.00, 0),
(26, 'ORD68CDAAE2A786C', 7, 'saif', '01856590532', ' dhaka', 14, 1, '2025-09-20 01:11:30', 'big10', 154.58, 595.42, 'pending', 'mirpur', 750.00, 0),
(27, 'ORD68CDAAE2A786C', 7, 'saif', '01856590532', ' dhaka', 21, 1, '2025-09-20 01:11:30', 'big10', 154.58, 1585.42, 'pending', 'mirpur', 1740.00, 0),
(28, 'ORD68CDAB8E4ECB3', 7, 'saif', '01856590532', ' dhaka', 25, 1, '2025-09-20 01:14:22', '', 0.00, 2290.00, 'pending', 'mirpur', 2290.00, 0),
(29, 'ORD68CDAE41D3E1A', 7, 'saif', '01856590532', ' FENI', 22, 1, '2025-09-20 01:25:53', '', 0.00, 2399.00, 'pending', 'mirpur', 2399.00, 0),
(30, 'ORD68CDD1BF567BE', 7, 'saif', '01856590532', ' Dhaka,Bangladesh', 37, 2, '2025-09-20 03:57:19', 'big10', 43.50, 376.50, 'pending', 'mirpur 2', 420.00, 0),
(31, 'ORD68CDD1BF567BE', 7, 'saif', '01856590532', ' Dhaka,Bangladesh', 39, 1, '2025-09-20 03:57:19', 'big10', 43.50, 406.50, 'pending', 'mirpur 2', 450.00, 0),
(32, 'ORD68CDD80E616F3', 7, 'saif Mahin', '01856590532', ' Mirpur 2', 38, 2, '2025-09-20 04:24:14', '', 0.00, 800.00, 'pending', 'Dhaka', 800.00, 0),
(33, 'ORD68CDD80E616F3', 7, 'saif Mahin', '01856590532', ' Mirpur 2', 57, 1, '2025-09-20 04:24:14', '', 0.00, 240.00, 'pending', 'Dhaka', 240.00, 0),
(34, 'ORD68CF82E010E59', 9, 'Nomayen', '01856590532', ' MIRPUR 2', 36, 2, '2025-09-21 10:45:20', 'SAVE10', 89.50, 350.50, 'delivered', 'Dhaka', 440.00, 0),
(35, 'ORD68CF82E010E59', 9, 'Nomayen', '01856590532', ' MIRPUR 2', 59, 3, '2025-09-21 10:45:20', 'SAVE10', 89.50, 1260.50, 'delivered', 'Dhaka', 1350.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `unit_price` int(8) NOT NULL,
  `selling_price` int(8) NOT NULL,
  `stock_amount` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `product_image`, `unit_price`, `selling_price`, `stock_amount`, `category_id`, `created_at`) VALUES
(36, 'Classic Beef Burger', 'Juicy beef patty with fresh lettuce, tomato, and cheese in a toasted bun.', '1758317427_1768ea64918f618d4a9c9be36d4965aa.jpg', 180, 220, 50, 14, '2025-09-19 21:30:27'),
(37, 'Chicken Cheese Burger', 'Grilled chicken with cheddar cheese, mayo, and fresh veggies in a soft bun.', '1758317486_8b0400b3c06c034c5e86db912330176d.jpg', 170, 210, 60, 14, '2025-09-19 21:31:26'),
(38, 'Margherita Pizza', 'Classic pizza with tomato sauce, mozzarella cheese, and fresh basil.', '1758317526_022afa9da86b8098ee62bdf1928cc60a.jpg', 350, 400, 40, 13, '2025-09-19 21:32:06'),
(39, 'Pepperoni Pizza', 'Delicious pizza topped with pepperoni slices and mozzarella cheese.', '1758317578_c519d4838c10d0c8ebfa7721f41705e3.jpg', 400, 450, 35, 13, '2025-09-19 21:32:58'),
(52, 'Club Sandwich', 'Layered sandwich with chicken, bacon, lettuce, tomato, and mayo.', '325519328.jpg', 150, 180, 70, 12, '2025-09-19 21:37:50'),
(53, 'Veggie Wrap', 'Soft tortilla wrap filled with fresh veggies and hummus.', '635133854.jpg', 120, 150, 80, 12, '2025-09-19 21:37:50'),
(54, 'French Fries', 'Crispy golden fries served with ketchup.', '133317287.jpg', 60, 80, 100, 10, '2025-09-19 21:37:50'),
(55, 'Chicken Nuggets', 'Crunchy chicken nuggets served with spicy dip.', '141761338.jpg', 100, 130, 90, 10, '2025-09-19 21:37:50'),
(56, 'Spaghetti Bolognese', 'Classic Italian pasta with rich meat sauce and parmesan.', '895307487.jpg', 220, 260, 50, 9, '2025-09-19 21:37:50'),
(57, 'Chicken Chow Mein', 'Stir-fried noodles with chicken and mixed vegetables.', '306753257.jpg', 200, 240, 60, 9, '2025-09-19 21:37:50'),
(58, 'Burger Combo', 'Beef burger with fries and a soft drink.', '76159432.jpg', 250, 300, 50, 8, '2025-09-19 21:37:50'),
(59, 'Combo Pack', 'Personal pizza with garlic bread and soda.', '761143203.jpg', 400, 450, 30, 8, '2025-09-19 21:37:50'),
(60, 'Cold Coffee', 'Chilled coffee with ice cream and whipped cream.', '340804574.jpg', 120, 150, 80, 7, '2025-09-19 21:37:50'),
(61, 'Fresh Lemonade', 'Refreshing lemonade with mint leaves.', '246798486.jpg', 80, 100, 90, 7, '2025-09-19 21:37:50'),
(62, 'Chocolate Brownie', 'Rich chocolate brownie topped with nuts.', '869105481.jpg', 100, 130, 50, 6, '2025-09-19 21:37:50'),
(63, 'Vanilla Ice Cream', 'Creamy vanilla ice cream served in a cup or cone.', '586653628.jpg', 90, 120, 70, 6, '2025-09-19 21:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `reset_token` varchar(255) NOT NULL,
  `reset_expires` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `password`, `token`, `verified`, `reset_token`, `reset_expires`, `created_at`) VALUES
(7, 'saif', 'saifmahin500@gmail.com', '01856590532', '$2y$10$.GuUIcAzE8snctp7jimB1ubv2TVMrbHJR9VWYpJa0fH2.JC8ltAy2', '', 1, '69c45640cf29e039a7e71fe3bda931fa', '2025-08-18 22:38:07', '2025-08-17 18:59:05'),
(8, 'Ohin', 'saifmahin46@gmail.com', '', '$2y$10$8jzf51xX1rMBeqFiKTUAXeLrFNzNxBr71oFK/8151M6U9s0UOORCm', '', 1, '', '0000-00-00 00:00:00', '2025-09-19 22:33:38'),
(9, 'Nomayen', 'nomayen.ohin@gmail.com', '', '$2y$10$zL5DGAqtXY5EjoZZl8JHrecctb108jgNJ5a5VbvUFeHw8GvknCXq2', '3a1219ff1abecf2f654c0c45853d3869', 1, '', '0000-00-00 00:00:00', '2025-09-21 04:42:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_cart_product` (`cart_id`,`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_message`
--
ALTER TABLE `contact_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_email` (`email`),
  ADD KEY `idx_contact_is_replied` (`is_replied`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_code` (`code`);

--
-- Indexes for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_coupon_product` (`coupon_id`,`product_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contact_message`
--
ALTER TABLE `contact_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupon_products`
--
ALTER TABLE `coupon_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_products`
--
ALTER TABLE `coupon_products`
  ADD CONSTRAINT `coupon_products_ibfk_1` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
