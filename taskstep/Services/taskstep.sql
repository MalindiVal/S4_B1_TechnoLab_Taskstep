-- Désactivation temporaire des contraintes pour éviter les erreurs de FK pendant l'import
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `items`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `contexts`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `sections`;
DROP TABLE IF EXISTS `users`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
 /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
 /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 /*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

-- Table `users`
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table `sections`
CREATE TABLE `sections` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `fancy_title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table `contexts`
CREATE TABLE `contexts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table `projects`
CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table `settings`
CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `tips` tinyint(1) NOT NULL DEFAULT 1,
  `stylesheet` enum('default.css','modern.css','professional.css') NOT NULL DEFAULT 'default.css',
  `session` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table `items`
CREATE TABLE `items` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `section_id` int(10) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `url` varchar(2083) DEFAULT NULL,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `context_id` int(10) UNSIGNED DEFAULT NULL,
  `project_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Indexes
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contexts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `context_id` (`context_id`),
  ADD KEY `project_id` (`project_id`);

-- Auto-increment
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `sections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `contexts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Contraintes (foreign keys)
ALTER TABLE `contexts`
  ADD CONSTRAINT `contexts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `settings`
  ADD CONSTRAINT `settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`context_id`) REFERENCES `contexts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `items_ibfk_4` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

-- Insertion des données
INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'Test', 'taskstep');

INSERT INTO `sections` (`id`, `title`, `fancy_title`) VALUES
(1, 'ideas', 'Ideas'),
(2, 'tobuy', 'Might want to buy'),
(3, 'immediate', 'Immediate'),
(4, 'week', 'This week'),
(5, 'month', 'This month'),
(6, 'year', 'This year'),
(7, 'lifetime', 'Some day maybe');

INSERT INTO `contexts` (`id`, `user_id`, `title`) VALUES
(2, 1, 'NewContext'),
(3, 1, 'NewContext');

INSERT INTO `projects` (`id`, `user_id`, `title`) VALUES
(2, 1, 'NewProject'),
(3, 1, 'NewProject');

INSERT INTO `settings` (`id`, `user_id`, `tips`, `stylesheet`, `session`) VALUES
(8, 1, 0, 'default.css', 1);

INSERT INTO `items` (`id`, `user_id`, `title`, `date`, `start_date`, `end_date`, `section_id`, `notes`, `url`, `done`, `context_id`, `project_id`) VALUES
(4, 1, 'Task or step title', '2025-05-10', '0000-00-00 00:00:00', NULL, 3, 'tgk,fhdhd', 'syjfhgnyjrky', 0, 2, 2),
(5, 1, 'Task or step title', '2025-05-15', '0000-00-00 00:00:00', NULL, 6, 'tgk,fhdhd', 'syjfhgnyjrky', 0, 2, 3);

-- Réactivation des contraintes
SET FOREIGN_KEY_CHECKS = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
 /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
 /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
