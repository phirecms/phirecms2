--
-- Phire CMS 2 MySQL Database
--

-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `[{prefix}]config`;
CREATE TABLE IF NOT EXISTS `[{prefix}]config` (
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `config`
--

INSERT INTO `[{prefix}]config` (`setting`, `value`) VALUES
('domain', ''),
('document_root', ''),
('installed_on', '0000-00-00 00:00:00'),
('updated_on', '0000-00-00 00:00:00'),
('system_theme', 'default'),
('datetime_format', 'M j Y'),
('pagination', '25'),
('updates', '');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--
DROP TABLE IF EXISTS `[{prefix}]roles`;
CREATE TABLE IF NOT EXISTS `[{prefix}]roles` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `parent_id` int(16),
  `name` varchar(255) NOT NULL,
  `verification` int(1),
  `approval` int(1),
  `email_as_username` int(1),
  `email_required` int(1),
  `permissions` text,
  PRIMARY KEY (`id`),
  INDEX `user_role_name` (`name`),
  CONSTRAINT `fk_role_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `[{prefix}]roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2002 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `[{prefix}]roles` (`id`, `parent_id`, `name`, `verification`, `approval`, `email_as_username`, `email_required`, `permissions`) VALUES
(2001, NULL, 'Phire', 1, 1, 0, 0, 'a:2:{s:5:"allow";a:0:{}s:4:"deny";a:2:{i:0;a:2:{s:8:"resource";s:8:"register";s:10:"permission";N;}i:1;a:2:{s:8:"resource";s:11:"unsubscribe";s:10:"permission";N;}}}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `[{prefix}]users`;
CREATE TABLE IF NOT EXISTS `[{prefix}]users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `role_id` int(16),
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_name` varchar(255),
  `last_name` varchar(255),
  `company` varchar(255),
  `title` varchar(255),
  `email` varchar(255),
  `phone` varchar(255),
  `active` int(1),
  `verified` int(1),
  PRIMARY KEY (`id`),
  INDEX `user_role_id` (`role_id`),
  INDEX `username` (`username`),
  INDEX `user_email` (`email`),
  INDEX `user_first_name` (`first_name`),
  INDEX `user_last_name` (`last_name`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `[{prefix}]roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1001 ;

--
-- Dumping data for table `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `[{prefix}]modules`;
CREATE TABLE IF NOT EXISTS `[{prefix}]modules` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `order` int(16) NOT NULL,
  `assets` text,
  `updates` text,
  `installed_on` datetime,
  `updated_on` datetime,
  PRIMARY KEY (`id`),
  INDEX `module_folder` (`folder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3001 ;

--
-- Dumping data for table `modules`
--

--  --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;