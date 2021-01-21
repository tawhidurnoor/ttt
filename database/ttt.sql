-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 04:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ttt`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(16, 14, 6, 1),
(29, 9, 1, 1),
(30, 9, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cat_slug` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `cat_slug`) VALUES
(1, 'Sharee', 'sharee'),
(2, 'Churi', 'churi'),
(3, 'Mala', 'mala'),
(4, 'Necklace', 'necklace'),
(5, 'Anklet', 'anklet'),
(6, 'Other Jewelries', 'other-jewelries'),
(7, 'Wrist Watch', 'wrist-watch'),
(8, 'Panjabee', 'panjabee'),
(9, 'Hand Bag', 'hand-bag'),
(10, 'Money Bag', 'money-bag'),
(11, 'Teep', 'teep'),
(12, 'Packages', 'packages');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`id`, `sales_id`, `product_id`, `quantity`) VALUES
(14, 9, 11, 2),
(15, 9, 13, 5),
(16, 9, 3, 2),
(17, 9, 1, 3),
(18, 10, 13, 3),
(19, 10, 2, 4),
(20, 10, 19, 5);

-- --------------------------------------------------------

--
-- Table structure for table `featured_products`
--

CREATE TABLE `featured_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `featured_products`
--

INSERT INTO `featured_products` (`id`, `product_id`) VALUES
(1, 1),
(2, 3),
(3, 5),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `photo` varchar(200) NOT NULL,
  `date_view` date NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `slug`, `price`, `photo`, `date_view`, `counter`) VALUES
(1, 12, 'Student Couple Package 2', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà¦Ÿà¦¿à¦¤à§‡ à¦¥à¦¾à¦•à¦¬à§‡à¦ƒ</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"font-size: 15px; color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;\">à§§.à¦à¦•à¦Ÿà¦¿ à¦¹à¦¾à¦«à¦¸à¦¿à¦²à§à¦• à¦…à¦²à¦…à¦­à¦¾à¦° à¦¸à§à¦¤à¦¾à¦° à¦•à¦¾à¦œ à¦•à¦°à¦¾ à¦¶à¦¾à§œà¦¿à¥¤à¦¬à§à¦²à¦¾à¦‰à¦œ à¦ªà¦¿à¦¸ à¦¨à§‡à¦‡à¥¤à¦¶à¦¾à§œà¦¿à¦° à§­ à¦Ÿà¦¾ à¦•à¦¾à¦²à¦¾à¦° à¦¹à¦¬à§‡à¥¤</span><span style=\"font-size: 15px; color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif;\">à¦•à¦¾à¦²à§‹,à¦¨à§€à¦²,à¦®à§à¦¯à¦¾à¦°à§à¦¨,à¦¸à¦¬à§à¦œ,à¦œà¦²à¦ªà¦¾à¦‡,à¦ªà§‡à¦·à§à¦Ÿ,à¦¬à§‡à¦—à§à¦¨à§€à¥¤</span></p><p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à§¨.à¦à¦•à¦Ÿà¦¿ à¦²à¦¿à¦²à§‡à¦¨ à¦ªà¦¾à¦žà§à¦œà¦¾à¦¬à§€à¥¤à¦¯à§‡à¦•à§‹à¦¨à§‹ à¦¸à¦¾à¦‡à¦œà§‡à¦° à¦¯à§‡à¦•à§‹à¦¨à§‹ à¦•à¦¾à¦²à¦¾à¦°à§‡ à¦¦à§‡à¦“à§Ÿà¦¾ à¦¯à¦¾à¦¬à§‡à¥¤à¦¬à¦¾à¦šà§à¦šà¦¾à¦¦à§‡à¦° à¦“ à¦¹à¦¬à§‡à¥¤</span></p><p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à§©.à¦¹à¦¾à¦¤à§‡ à¦¤à§ˆà¦°à¦¿ à¦®à¦¾à¦²à¦¾à¥¤</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à§ª.à¦à¦• à¦ªà¦¾à¦¤à¦¾ à¦Ÿà¦¿à¦ªà¥¤</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦ªà§à¦°à§‹ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà§‡à¦° à¦®à§‚à¦²à§à¦¯ à§§à§¨à§¯à§¦ à¦Ÿà¦¾à¦•à¦¾à¥¤</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦¢à¦¾à¦•à¦¾à¦° à¦®à¦§à§à¦¯à§‡ à¦¹à§‹à¦®à¦¡à§‡à¦²à¦¿à¦­à¦¾à¦°à¦¿ à¦†à¦° à¦¢à¦¾à¦•à¦¾à¦° à¦¬à¦¾à¦‡à¦°à§‡ à¦•à§à¦¯à¦¾à¦¶ à¦…à¦¨ à¦¡à§‡à¦²à¦¿à¦­à¦¾à¦°à¦¿ à¦•à¦°à¦¾ à¦¹à§Ÿà¥¤à¦²à§à¦¯ à§§à§¨à§¯à§¦ à¦Ÿà¦¾à¦•à¦¾à¥¤</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦¢à¦¾à¦•à¦¾à¦° à¦®à¦§à§à¦¯à§‡ à¦¹à§‹à¦®à¦¡à§‡à¦²à¦¿à¦­à¦¾à¦°à¦¿ à¦†à¦° à¦¢à¦¾à¦•à¦¾à¦° à¦¬à¦¾à¦‡à¦°à§‡ à¦•à§à¦¯à¦¾à¦¶ à¦…à¦¨ à¦¡à§‡à¦²à¦¿à¦­à¦¾à¦°à¦¿ à¦•à¦°à¦¾ à¦¹à§Ÿà¥¤</span><br></p>', 'student-couple-package-2', 1290, '.jpg', '2021-01-21', 4),
(2, 1, 'Dhupian Half Silk', '<div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\">à¦§à§à¦ªà¦¿à§Ÿà¦¾à¦¨ à¦¹à¦¾à¦«à¦¸à¦¿à¦²à§à¦• à¦œà¦¾à¦®à¦¦à¦¾à¦¨à§€à¥¤</div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\">à¦ªà§à¦°à§‹ à¦¶à¦¾à§œà¦¿à¦¤à§‡ à¦¸à§à¦¤à¦¾à¦° à¦•à¦¾à¦œà¥¤à¦†à¦à¦šà¦²à§‡ à¦ªà¦¿à¦Ÿà¦¾ à¦•à¦¾à¦œà¥¤</div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\">à§§à§¨.à§« à¦¹à¦¾à¦¤</div><div dir=\"auto\" style=\"font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\">à¦¬à§à¦²à¦¾à¦‰à¦œà¦ªà¦¿à¦¸ à¦¨à§‡</div>', 'dhupian-half-silk', 790, 'dhupian-half-silk.jpg', '2021-01-21', 1),
(3, 12, 'Student Package 13', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">\"à¦¸à§à¦Ÿà§à¦¡à§‡à¦¨à§à¦Ÿ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œ-à§§à§©\"</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦ªà§à¦°à§‹ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà§‡à¦° à¦®à§‚à¦²à§à¦¯ à§¯à§¯à§¦ à¦Ÿà¦¾à¦•à¦¾</span><br></p>', 'student-package-13', 990, 'student-package-13.jpg', '2021-01-20', 1),
(4, 12, 'Student Package 12', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">\"à¦¸à§à¦Ÿà§à¦¡à§‡à¦¨à§à¦Ÿ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œ-à§§à§¨\"</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦ªà§à¦°à§‹ à¦ªà§à¦¯à¦¾à¦•à§‡à¦œà§‡à¦° à¦®à§‚à¦²à§à¦¯ à§­à§®à§¦ à¦Ÿà¦¾à¦•à¦¾</span><br></p>', 'student-package-12', 780, 'student-package-12.jpg', '2021-01-21', 1),
(5, 1, 'Kota Sharee', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px; white-space: pre-wrap;\">à¦•à§‹à¦Ÿà¦¾ à¦¶à¦¾à§œà¦¿</span><span class=\"pq6dq46d tbxw36s4 knj5qynh kvgmc6g5 ditlmg2l oygrvhab nvdbi5me sf5mxxl7 gl3lb2sf hhz5lgdu\" style=\"margin: 0px 1px; height: 16px; width: 16px; display: inline-flex; vertical-align: middle; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\"><img height=\"16\" width=\"16\" alt=\"ðŸ’™\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t6c/1/16/1f499.png\" style=\"border: 0px;\"></span><span class=\"pq6dq46d tbxw36s4 knj5qynh kvgmc6g5 ditlmg2l oygrvhab nvdbi5me sf5mxxl7 gl3lb2sf hhz5lgdu\" style=\"margin: 0px 1px; height: 16px; width: 16px; display: inline-flex; vertical-align: middle; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\"><img height=\"16\" width=\"16\" alt=\"ðŸ’›\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t15/1/16/1f49b.png\" style=\"border: 0px;\"></span><span class=\"pq6dq46d tbxw36s4 knj5qynh kvgmc6g5 ditlmg2l oygrvhab nvdbi5me sf5mxxl7 gl3lb2sf hhz5lgdu\" style=\"margin: 0px 1px; height: 16px; width: 16px; display: inline-flex; vertical-align: middle; font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; color: rgb(5, 5, 5); font-size: 15px; white-space: pre-wrap;\"><img height=\"16\" width=\"16\" alt=\"ðŸ–¤\" src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t0/1/16/1f5a4.png\" style=\"border: 0px;\"></span></p>', 'kota-sharee', 990, 'kota-sharee.jpg', '2021-01-21', 1),
(6, 12, 'Student Couple Package 5', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">\"à¦¸à§à¦Ÿà§à¦¡à§‡à¦¨à§à¦Ÿ à¦•à¦¾à¦ªà¦² à¦ªà§à¦¯à¦¾à¦•à§‡à¦œ-à§«\"</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦®à§‚à¦²à§à¦¯à¦ƒà§§à§¦à§®à§¦ à¦Ÿà¦¾à¦•à¦¾</span><br></p>', 'student-couple-package-5', 1080, 'student-couple-package-5.jpg', '2021-01-21', 1),
(7, 12, 'Student Couple Package 4', '<p><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">\"à¦¸à§à¦Ÿà§à¦¡à§‡à¦¨à§à¦Ÿ à¦•à¦¾à¦ªà¦² à¦ªà§à¦¯à¦¾à¦•à§‡à¦œ-à§ª\"</span><br style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\"><span style=\"color: rgb(5, 5, 5); font-family: &quot;Segoe UI Historic&quot;, &quot;Segoe UI&quot;, Helvetica, Arial, sans-serif; font-size: 15px;\">à¦®à§‚à¦²à§à¦¯à¦ƒà§¯à§¯à§¦ à¦Ÿà¦¾à¦•à¦¾</span><br></p>', 'student-couple-package-4', 990, 'student-couple-package-4.jpg', '2021-01-21', 4);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pay_id` varchar(50) NOT NULL,
  `sales_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `pay_id`, `sales_date`) VALUES
(9, 9, 'PAY-1RT494832H294925RLLZ7TZA', '2020-05-10'),
(10, 9, 'PAY-21700797GV667562HLLZ7ZVY', '2020-05-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` int(1) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `activate_code` varchar(15) NOT NULL,
  `reset_code` varchar(15) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `type`, `firstname`, `lastname`, `address`, `contact_info`, `photo`, `status`, `activate_code`, `reset_code`, `created_on`) VALUES
(1, 'admin@admin.com', '$2y$10$pnlmheEyLZP2wwN5O5oqvuNDw8AAFWRtoaT4XjBY4uNiTxH6dKZRG', 1, 'Tawhidur', 'Noor', '', '', 'untitled-7662 web.jpg', 1, '', '', '2018-05-01'),
(9, 'amina35-2378@diu.edu.bd', '$2y$10$qNtfukpMRt0fqjshFFQwDOu4EVsk2iITAWaNs7wDa9qdh7rgu7z6q', 0, 'Shitul', 'Bhuiyan', 'RajarBajar, Dhaka', '09092735719', '83535714_2538250106445925_5198651071030886400_o (1).jpg', 1, 'k8FBpynQfqsv', 'wzPGkX5IODlTYHg', '2018-05-09'),
(12, 'christine@gmail.com', '$2y$10$ozW4c8r313YiBsf7HD7m6egZwpvoE983IHfZsPRxrO1hWXfPRpxHO', 0, 'Christine', 'becker', 'demo', '7542214500', 'female3.jpg', 1, '', '', '2018-07-09'),
(14, 'tawhidbadhan@gmail.com', '$2y$10$wP/ftVuygTjP3Er5CYEjM.yEXATUrFFit8er2PLf0e2r9F9Nv.nmS', 0, 'Tawhidur', 'Noor', '581/12, Yousuf Road(Beside 43 Engineers Company), Dhaka Cantonment', '01780640568', '95443730_2614427885494813_2806054635880579072_o.jpg', 1, '', '', '2020-10-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `featured_products`
--
ALTER TABLE `featured_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `featured_products`
--
ALTER TABLE `featured_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
