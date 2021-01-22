-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2021 at 04:58 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_auth_ci3`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_menu_role`
--

CREATE TABLE `access_menu_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `access_role_user`
--

CREATE TABLE `access_role_user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access_role_user`
--

INSERT INTO `access_role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `access_submenu_role`
--

CREATE TABLE `access_submenu_role` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `submenu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(33) NOT NULL,
  `icon` varchar(122) DEFAULT NULL,
  `url` varchar(122) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon`, `url`) VALUES
(1, 'Permission', '', ''),
(6, 'Master', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_role`
--

CREATE TABLE `model_has_role` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `model_type` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model_has_role`
--

INSERT INTO `model_has_role` (`id`, `model_id`, `role_id`, `model_type`) VALUES
(115, 1, 1, 'Menu_model'),
(276, 2, 2, 'User_model'),
(277, 1, 2, 'Menu_model'),
(278, 1, 1, 'User_model');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Pemilik'),
(4, 'Pegawai');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(22) NOT NULL,
  `value` varchar(44) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `status`) VALUES
(1, 'theme_admin', 'azzara', 0),
(2, 'theme_public', 'default', 0),
(12, 'name_app', 'Super Admin', 0),
(14, 'Alamat', 'Kamp. Sarroanging Desa Mappilawing', 0),
(15, 'my_fb', 'http://facebook.com', 0),
(16, 'my_github', 'http://github.com/tantangin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `submenus`
--

CREATE TABLE `submenus` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(22) NOT NULL,
  `icon` varchar(122) NOT NULL,
  `url` varchar(122) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `is_access` enum('public','private') NOT NULL DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `submenus`
--

INSERT INTO `submenus` (`id`, `menu_id`, `name`, `icon`, `url`, `status`, `is_access`) VALUES
(8, 1, 'Menu', '', 'permission/menu', 1, 'public'),
(9, 1, 'Submenu', '', 'permission/submenu', 1, 'public'),
(10, 1, 'Role', '', 'permission/role', 1, 'public'),
(11, 1, 'User', '', 'permission/user', 1, 'public'),
(12, 6, 'Barang', '', 'admin/barang', 1, 'public');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(22) NOT NULL,
  `email` varchar(30) NOT NULL,
  `name` varchar(122) NOT NULL,
  `email_verified_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) NOT NULL,
  `profile` varchar(122) NOT NULL DEFAULT 'default.jpg',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `name`, `email_verified_at`, `password`, `profile`, `created_at`, `updated_at`, `remember_token`, `status`) VALUES
(1, 'Super Admin', 'super-admin@gmail.com', 'Super Admin', '2020-10-08 09:15:55', '$2y$10$eJAlF9R.YwO9ZVKUm9XBHeA9u2CGixQq1.JPy7X4m2euDMVYoBWbi', 'default.jpg', '2020-10-08 09:15:55', '2020-10-08 09:15:55', 'R6EcSZdB42z8rW1mOkIsxs11HNEaPiMan7v94uVpvC7cPy5mMM5j1d4S8egft4FbbPO7ML4FTz7WGFnhHF_1aQ==', 1),
(2, 'irsanm', 'irsan00mansyur@gmail.com', 'Irsan Mansyur', '2021-01-20 21:22:13', '$2y$10$bpqXOjfyRMrGXAOF1JyzFO/NFXbzksq.Rpu7iU0QSCYi8xJp.WwCy', 'default.jpg', '2021-01-20 21:22:13', '2021-01-20 21:22:13', 'AF9589bdvWsc2gpLPOU8vizpBvWlan_dEu/NrgpgsY//hWDN48cXyIyDlCjkVAD14Ox4Hga_AjmJF6LB7dwAhA==', 1);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `model_type` varchar(226) NOT NULL,
  `model_id` int(11) NOT NULL,
  `ip_address` varchar(99) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `model_type`, `model_id`, `ip_address`, `created_at`, `updated_at`) VALUES
(10, 'User_model', 1, '127.0.0.1', '2021-01-12 00:00:06', '2021-01-21 13:23:18'),
(11, 'User_model', 2, '127.0.0.1', '2021-01-21 00:00:00', '2021-01-21 13:42:32'),
(12, 'User_model', 1, '127.0.0.1', '2021-01-21 00:00:00', '2021-01-21 13:43:17'),
(13, 'User_model', 1, '127.0.0.1', '2021-01-11 00:00:06', '2021-01-21 13:23:18'),
(14, 'User_model', 1, '127.0.0.1', '2021-01-10 00:00:00', '2021-01-21 13:43:17'),
(15, 'User_model', 1, '127.0.0.1', '2021-01-12 00:00:06', '2021-01-21 13:23:18'),
(16, 'User_model', 1, '127.0.0.1', '2021-01-21 00:00:00', '2021-01-21 13:43:17'),
(17, 'User_model', 1, '127.0.0.1', '2021-01-11 00:00:06', '2021-01-21 13:23:18'),
(18, 'User_model', 1, '127.0.0.1', '2021-01-10 00:00:00', '2021-01-21 13:43:17'),
(19, 'User_model', 1, '127.0.0.1', '2021-01-01 00:00:06', '2021-01-21 13:23:18'),
(20, 'User_model', 3, '127.0.0.1', '2021-01-21 00:00:00', '2021-01-21 17:45:56'),
(21, 'User_model', 9, '127.0.0.1', '2021-01-21 00:00:00', '2021-01-21 18:18:07'),
(22, 'User_model', 1, '127.0.0.1', '2021-01-22 00:00:00', '2021-01-22 00:28:22'),
(23, 'User_model', 2, '127.0.0.1', '2021-01-22 00:00:00', '2021-01-22 00:33:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_menu_role`
--
ALTER TABLE `access_menu_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_menu_role_ibfk_1` (`menu_id`),
  ADD KEY `access_menu_role_ibfk_2` (`role_id`);

--
-- Indexes for table `access_role_user`
--
ALTER TABLE `access_role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `access_role_user_ibfk_1` (`role_id`);

--
-- Indexes for table `access_submenu_role`
--
ALTER TABLE `access_submenu_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `access_submenu_role_ibfk_1` (`role_id`),
  ADD KEY `submenu_id` (`submenu_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_role`
--
ALTER TABLE `model_has_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `name_2` (`name`);

--
-- Indexes for table `submenus`
--
ALTER TABLE `submenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_menu_role`
--
ALTER TABLE `access_menu_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `access_role_user`
--
ALTER TABLE `access_role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `access_submenu_role`
--
ALTER TABLE `access_submenu_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `model_has_role`
--
ALTER TABLE `model_has_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `submenus`
--
ALTER TABLE `submenus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_menu_role`
--
ALTER TABLE `access_menu_role`
  ADD CONSTRAINT `access_menu_role_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_menu_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_role_user`
--
ALTER TABLE `access_role_user`
  ADD CONSTRAINT `access_role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_submenu_role`
--
ALTER TABLE `access_submenu_role`
  ADD CONSTRAINT `access_submenu_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_submenu_role_ibfk_2` FOREIGN KEY (`submenu_id`) REFERENCES `submenus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submenus`
--
ALTER TABLE `submenus`
  ADD CONSTRAINT `submenus_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
