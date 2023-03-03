-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 03, 2023 at 02:24 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minia_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `useremail`, `username`, `password`, `token`, `created_at`, `name`, `lastname`, `category`) VALUES
(7, 'henry@gmail.com', 'Henry', '$2y$10$vC41AOMLc.nfBlZFOwukkuN/44tpQIlIjnGdRMMOVdlzOTf5fT5zq', '754bcf4b23f6b6f887e30182f22ac0b7bd577256d26e7e744546ac8403ee855a3aa236909dd98571731913e85f8dd1b1e7c9', '2020-09-24 17:53:37', 'Henry', 'Kenton', 1),
(11, 'edgardoruotolo@gmail.com', 'eruotolo', '$2y$10$ry7bIsp3ydbkvrZuepg8NeMmSxYcuSK5IBF3NTQjqoOtT82ad.9bi', '253ef9c81e64fb44bd4830151234619ce94c58a66a7c2212991242006a944d462a112c76720ce98a173e86a93f2119ffb795', '2023-03-02 12:40:19', 'Edgardo', 'Ruotolo', 1),
(19, 'jorge@indaga.me', 'Roberto', '$2y$10$eJMRephHqAl3t8SXHbs15ecNROEX5Ex0lxREmY6mg8h0jQIp1nMgu', 'eae1d8a6bf7e066169e84cad7fe215f8c88ed86f22b024c2dd3332d6946f18c1d6bab4fa8abbd1e4a81b75f65775e5017de2', '2023-03-03 11:53:51', 'Roberto', 'Chacon', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `id_Cat` int(11) NOT NULL,
  `cat_Nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`id_Cat`, `cat_Nombre`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `useremail` (`useremail`),
  ADD KEY `users_user_category_id_Cat_fk` (`category`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`id_Cat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `id_Cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_user_category_id_Cat_fk` FOREIGN KEY (`category`) REFERENCES `user_category` (`id_Cat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
