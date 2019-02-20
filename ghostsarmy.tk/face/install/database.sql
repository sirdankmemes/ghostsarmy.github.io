-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 16 Août 2017 à 15:44
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test_facebook_tool`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `data` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `facebook_accounts`
--

DROP TABLE IF EXISTS `facebook_accounts`;
CREATE TABLE `facebook_accounts` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `fid` varchar(32) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token_name` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `cookies` text,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `facebook_groups`
--

DROP TABLE IF EXISTS `facebook_groups`;
CREATE TABLE `facebook_groups` (
  `id` int(11) NOT NULL,
  `account_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `privacy` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `facebook_schedules`
--

DROP TABLE IF EXISTS `facebook_schedules`;
CREATE TABLE `facebook_schedules` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `account_name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `group_type` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `privacy` varchar(255) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4,
  `title` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `time_post` datetime DEFAULT NULL,
  `time_post_show` datetime DEFAULT NULL,
  `delete_post` int(1) DEFAULT '0',
  `deplay` int(11) DEFAULT NULL,
  `repeat_post` int(1) DEFAULT '0',
  `repeat_time` int(11) DEFAULT NULL,
  `repeat_end` date DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `message_error` text,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `type` int(1) DEFAULT '2',
  `name` varchar(255) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `permission` text,
  `default_package` int(1) DEFAULT '0',
  `orders` int(11) DEFAULT '0',
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `package`
--

INSERT INTO `package` (`id`, `type`, `name`, `price`, `day`, `permission`, `default_package`, `orders`, `status`, `changed`, `created`) VALUES
(1, 0, 'Free', '0', 3, '{"maximum_account":1,"maximum_groups":5,"maximum_pages":5,"maximum_friends":5,"post":1,"post_wall_friends":1,"repost_pages":1,"join_groups":1,"add_friends":1,"unfriends":1,"invite_to_groups":1,"invite_to_pages":1,"accept_friend_request":1,"comment":1,"like":1,"search":1,"analytics":1}', 0, 0, 1, '2017-08-05 16:16:39', NULL),
(2, 2, 'Basic', '6.99', 30, '{"maximum_account":1,"maximum_groups":50,"maximum_pages":50,"maximum_friends":50,"post":1,"post_wall_friends":1,"repost_pages":1,"join_groups":1,"add_friends":1,"unfriends":1,"invite_to_groups":1,"invite_to_pages":1,"accept_friend_request":1,"comment":1,"like":1,"search":1,"analytics":1}', 0, 0, 1, '2017-08-05 16:26:53', NULL),
(3, 2, 'Standard', '15.99', 30, '{"maximum_account":2,"maximum_groups":500,"maximum_pages":500,"maximum_friends":500,"post":1,"post_wall_friends":1,"repost_pages":1,"join_groups":1,"add_friends":1,"unfriends":1,"invite_to_groups":1,"invite_to_pages":1,"accept_friend_request":1,"comment":1,"like":1,"search":1,"analytics":1}', 0, 0, 1, '2017-08-05 16:27:01', NULL),
(4, 2, 'Premium', '26.99', 30, '{"maximum_account":3,"maximum_groups":5000,"maximum_pages":5000,"maximum_friends":5000,"post":1,"post_wall_friends":1,"repost_pages":1,"join_groups":1,"add_friends":1,"unfriends":1,"invite_to_groups":1,"invite_to_pages":1,"accept_friend_request":1,"comment":1,"like":1,"search":1,"analytics":1}', 0, 0, 1, '2017-08-05 16:27:09', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `sandbox` int(1) DEFAULT '0',
  `currency` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `payment`
--

INSERT INTO `payment` (`id`, `paypal_email`, `sandbox`, `currency`) VALUES
(1, 'onepro166@gmail.com', 0, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `payment_history`
--

DROP TABLE IF EXISTS `payment_history`;
CREATE TABLE `payment_history` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `invoice` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `business` varchar(255) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_number` int(1) DEFAULT NULL,
  `address_street` varchar(255) DEFAULT NULL,
  `address_city` varchar(255) DEFAULT NULL,
  `address_country` varchar(255) DEFAULT NULL,
  `mc_gross` float DEFAULT NULL,
  `mc_currency` varchar(255) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `full_data` text,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `repost_history`
--

DROP TABLE IF EXISTS `repost_history`;
CREATE TABLE `repost_history` (
  `id` int(11) NOT NULL,
  `post_id` varchar(255) DEFAULT NULL,
  `page_id` varchar(255) DEFAULT NULL,
  `repost_id` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `repost_replace`
--

DROP TABLE IF EXISTS `repost_replace`;
CREATE TABLE `repost_replace` (
  `id` int(111) NOT NULL,
  `finds` text,
  `replaces` text,
  `uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `save`
--

DROP TABLE IF EXISTS `save`;
CREATE TABLE `save` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `message` text,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `caption` varchar(255) DEFAULT NULL,
  `url` text,
  `image` text,
  `status` int(1) DEFAULT '1',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `website_title` text,
  `website_description` text,
  `website_keyword` text,
  `logo` varchar(255) DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `upload_max_size` int(11) DEFAULT '5',
  `register` int(1) DEFAULT '1',
  `auto_active_user` int(1) DEFAULT '1',
  `default_language` varchar(255) DEFAULT NULL,
  `default_deplay` int(11) DEFAULT NULL,
  `default_deplay_post_now` int(11) DEFAULT NULL,
  `minimum_deplay` int(11) DEFAULT NULL,
  `minimum_deplay_post_now` int(11) NOT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `facebook_secret` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `google_secret` varchar(255) DEFAULT NULL,
  `twitter_id` varchar(255) DEFAULT NULL,
  `twitter_secret` varchar(255) DEFAULT NULL,
  `mail_type` int(1) DEFAULT '1',
  `mail_from_name` text,
  `mail_from_email` text,
  `mail_smtp_host` text,
  `mail_smtp_user` text,
  `mail_smtp_pass` text,
  `mail_smtp_port` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `settings`
--

INSERT INTO `settings` (`id`, `website_title`, `website_description`, `website_keyword`, `logo`, `theme_color`, `timezone`, `upload_max_size`, `register`, `auto_active_user`, `default_language`, `default_deplay`, `default_deplay_post_now`, `minimum_deplay`, `minimum_deplay_post_now`, `purchase_code`, `facebook_id`, `facebook_secret`, `google_id`, `google_secret`, `twitter_id`, `twitter_secret`, `mail_type`, `mail_from_name`, `mail_from_email`, `mail_smtp_host`, `mail_smtp_user`, `mail_smtp_pass`, `mail_smtp_port`) VALUES
(1, 'VTPoster - Facebook Marketing Tool', 'VTPoster - Facebook Marketing Tool', 'VTPoster - Facebook Marketing Tool', 'assets/images/logo.png', 'blue-grey', 'admin_timezone', 30, 0, 1, 'en', 30, 180, 5, 180, 'ITEM-PURCHASE-CODE', '', '', '', '', '', '', 1, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `user_management`
--

DROP TABLE IF EXISTS `user_management`;
CREATE TABLE `user_management` (
  `id` int(11) NOT NULL,
  `admin` int(1) DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `pid` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `maximum_account` int(11) DEFAULT '0',
  `maximum_groups` int(11) DEFAULT '0',
  `maximum_pages` int(11) DEFAULT '0',
  `maximum_friends` int(11) DEFAULT '0',
  `expiration_date` date DEFAULT NULL,
  `reset_key` text,
  `history_id` text,
  `timezone` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `user_management`
--

INSERT INTO `user_management` (`id`, `admin`, `type`, `pid`, `fullname`, `email`, `password`, `package_id`, `maximum_account`, `maximum_groups`, `maximum_pages`, `maximum_friends`, `expiration_date`, `reset_key`, `history_id`, `timezone`, `status`, `changed`, `created`) VALUES
(1, 1, 'direct', NULL, 'admin_fullname', 'admin_email', 'admin_password', 1, 3, 50, 50, 50, '2025-12-25', '0bd60843096706ed1692701257335be1', NULL, 'admin_timezone', 1, '2017-08-05 17:19:08', '2016-09-30 00:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facebook_accounts`
--
ALTER TABLE `facebook_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facebook_groups`
--
ALTER TABLE `facebook_groups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facebook_schedules`
--
ALTER TABLE `facebook_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payment_history`
--
ALTER TABLE `payment_history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `repost_history`
--
ALTER TABLE `repost_history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `repost_replace`
--
ALTER TABLE `repost_replace`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `save`
--
ALTER TABLE `save`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_management`
--
ALTER TABLE `user_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `facebook_accounts`
--
ALTER TABLE `facebook_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `facebook_groups`
--
ALTER TABLE `facebook_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `facebook_schedules`
--
ALTER TABLE `facebook_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `payment_history`
--
ALTER TABLE `payment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `repost_history`
--
ALTER TABLE `repost_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `repost_replace`
--
ALTER TABLE `repost_replace`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `save`
--
ALTER TABLE `save`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user_management`
--
ALTER TABLE `user_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
