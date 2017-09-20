--
-- Phire CMS MySQL Database
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
('installed', ''),
('updated', ''),
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
  `permissions` text,
  PRIMARY KEY (`id`),
  INDEX `role_name` (`name`),
  CONSTRAINT `fk_role_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `[{prefix}]roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `[{prefix}]roles` (`id`, `parent_id`, `name`, `permissions`) VALUES
(1, NULL, 'Admin', NULL);

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
  `email` varchar(255),
  `active` int(1) DEFAULT '0',
  `verified` int(1) DEFAULT '0',
  `attempts` int(16) DEFAULT '0',
  PRIMARY KEY (`id`),
  INDEX `role_id` (`role_id`),
  UNIQUE `username` (`username`),
  INDEX `active` (`active`),
  INDEX `attempts` (`attempts`),
  CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `[{prefix}]roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `[{prefix}]tokens`;
CREATE TABLE IF NOT EXISTS `[{prefix}]tokens` (
  `user_id` int(16) NOT NULL,
  `token` varchar(255) NOT NULL,
  `refresh` varchar(255) NOT NULL,
  `expires` int(16) NOT NULL, -- 0, never expires
  `requests` int(16) DEFAULT '0',
  UNIQUE `access_token` (`user_id`, `token`, `refresh`),
  CONSTRAINT `fk_token_user_id` FOREIGN KEY (`user_id`) REFERENCES `[{prefix}]users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
  `description` text DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `order` int(16) NOT NULL,
  `assets` text DEFAULT NULL,
  `installed` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updates` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `module_folder` (`folder`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

SET FOREIGN_KEY_CHECKS = 1;