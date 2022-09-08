-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 08 sep. 2022 à 16:54
-- Version du serveur : 8.0.30-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `description` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `tagline` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `avatar_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar_alt` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `cv_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `user_id`, `description`, `tagline`, `avatar_url`, `avatar_alt`, `cv_url`) VALUES
(1, 78, 'Donec id mauris aliquam, interdum turpis pharetra, lacinia dolor. Ut commodo id ligula id placerat. Curabitur purus erat, placerat in metus nec, dictum rhoncus massa. Vivamus nec tincidunt nunc.', 'Quisque a sapien justo. Vestibulum lacinia, odio in semper maximus, mauris turpis porta lacus, nec interdum lectus leo id lacus. Nunc ornare tempus est a efficitur.', 'uploads/cbaeb55cab9cc7adc5faf8a262c76a63.svg', 'alt of my avatar', 'uploads/b577c5e8628134fdb0d182c557958dbd.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `status`, `content`, `updated_at`, `created_at`) VALUES
(80, 78, 18, 1, 'Hello, nice post ! 💯', '2022-09-08 14:53:09', '2022-09-08 14:53:09'),
(81, 78, 19, 1, 'Amazing post, cool. 😎', '2022-09-08 14:54:20', '2022-09-08 14:54:20');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `caption` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alt_cover_image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `caption`, `content`, `cover_image`, `alt_cover_image`, `slug`, `updated_at`, `created_at`) VALUES
(18, 78, 'Duis congue diam a erat', 'Etiam fringilla aliquet elit quis scelerisque. Aenean imperdiet consectetur eros, vel faucibus elit iaculis consectetur.', 'Integer fermentum massa libero, in viverra nunc pharetra in. Pellentesque egestas orci et justo euismod porttitor. \r\n\r\nAenean nec lacus ut mauris lobortis laoreet iaculis vitae justo. In hac habitasse platea dictumst. Vivamus tempor, sapien ut pharetra aliquam, metus ante tincidunt sem, et lobortis risus massa at lorem. \r\n\r\nPhasellus id turpis ultrices, egestas quam at, pretium mauris. Curabitur pulvinar ipsum id mattis fringilla. Nunc auctor nunc at lectus ultrices, nec dapibus risus fermentum. \r\n\r\nSed in metus gravida, mattis nibh volutpat, facilisis dui.', 'uploads/7115620906b08b5eaa9fd2b2ff77ac4d.png', 'boxer picture in black and white', 'duis-congue-diam-a-erat', '2022-09-08 13:56:57', '2022-09-08 13:56:57'),
(19, 78, 'Sed ullamcorper massa metus', 'In blandit diam eget ipsum vehicula bibendum. Phasellus nisl odio, congue quis odio a, volutpat finibus augue.', 'Integer semper, quam in egestas tempus, felis mauris accumsan turpis, non ultrices mauris dolor eu orci. Donec ligula tortor, viverra in magna nec, fermentum laoreet eros. Nulla consequat augue ac mauris pellentesque rhoncus. Nullam tristique dapibus ex molestie sollicitudin. Sed ultrices convallis nisl, vitae scelerisque mauris consequat sit amet.', 'uploads/1306532d5e358736bc9794e79c7b9d76.svg', 'pixel art', 'sed-ullamcorper-massa-metus', '2022-09-08 13:58:05', '2022-09-08 13:58:05'),
(20, 78, 'Phasellus et velit at odio faucibus euismod', 'Pellentesque purus dui, tempor in fringilla in, lacinia vel eros. Pellentesque elit orci, placerat sed euismod nec, faucibus id nunc.', 'Vestibulum sed massa vitae eros feugiat tempor a in turpis. Duis at neque lorem. Nullam rutrum sollicitudin sem eget commodo. Sed ac pharetra justo, vel ullamcorper nulla. Donec pretium, neque a convallis venenatis, diam lectus malesuada elit, et laoreet mi metus non mi. Fusce auctor, massa quis porttitor cursus, ipsum elit porta mauris, ac blandit ligula neque at ante. Duis at interdum nibh.', 'uploads/3915834375f8c8401b9de6a283e408fb.jpg', 'robert de niro in taxi driver', 'phasellus-et-velit-at-odio-faucibus-euismod', '2022-09-08 14:00:33', '2022-09-08 14:00:33'),
(21, 78, 'In blandit diam eget', 'Suspendisse eleifend bibendum ex, a rhoncus odio laoreet eget. Nunc id hendrerit turpis, id ullamcorper enim.', 'In quis ligula id arcu finibus hendrerit id vehicula dui. Donec ac nisi id ex tincidunt interdum quis at justo. Nulla lobortis tincidunt nulla, ac convallis lacus mattis non. Duis congue diam a erat interdum, a aliquam lacus vehicula. Etiam fringilla aliquet elit quis scelerisque. Aenean imperdiet consectetur eros, vel faucibus elit iaculis consectetur. Maecenas nec suscipit lacus. Sed felis velit, euismod nec nulla ut, ornare ullamcorper lacus. Suspendisse maximus justo arcu, id consequat orci imperdiet vel. Nullam tristique sapien quis metus posuere euismod. Etiam fringilla feugiat ex, ac gravida est hendrerit nec.', 'uploads/54d04e4fdcddef13510423088476670b.jpg', 'a man dancing with a woman', 'in-blandit-diam-eget', '2022-09-08 14:01:45', '2022-09-08 14:01:45'),
(22, 78, 'Etiam tempor non leo', 'Nulla tincidunt dolor et neque malesuada efficitur.', 'Nulla consequat augue ac mauris pellentesque rhoncus. Nullam tristique dapibus ex molestie sollicitudin. Sed ultrices convallis nisl, vitae scelerisque mauris consequat sit amet. Pellentesque commodo elit risus, a sollicitudin turpis dapibus lacinia. Etiam tempor non leo et pellentesque. Fusce aliquam orci in felis elementum, sit amet tincidunt dolor dignissim. Curabitur sollicitudin arcu eu pulvinar porttitor. Vestibulum sed massa vitae eros feugiat tempor a in turpis. Duis at neque lorem. Nullam rutrum sollicitudin sem eget commodo. Sed ac pharetra justo, vel ullamcorper nulla. Donec pretium, neque a convallis venenatis, diam lectus malesuada elit, et laoreet mi metus non mi. Fusce auctor, massa quis porttitor cursus, ipsum elit porta mauris, ac blandit ligula neque at ante. Duis at interdum nibh.', 'uploads/935e52725108e78e5167619eedf67169.jpg', 'photo from story tale in america', 'etiam-tempor-non-leo', '2022-09-08 14:03:33', '2022-09-08 14:03:33'),
(23, 78, 'Nullam tristique dapibus', 'Curabitur sollicitudin arcu eu pulvinar porttitor.', 'Duis pulvinar non nunc eget volutpat. Suspendisse eleifend bibendum ex, a rhoncus odio laoreet eget. Nunc id hendrerit turpis, id ullamcorper enim. In quis ligula id arcu finibus hendrerit id vehicula dui. Donec ac nisi id ex tincidunt interdum quis at justo. Nulla lobortis tincidunt nulla, ac convallis lacus mattis non. Duis congue diam a erat interdum, a aliquam lacus vehicula. Etiam fringilla aliquet elit quis scelerisque. Aenean imperdiet consectetur eros, vel faucibus elit iaculis consectetur.', 'uploads/54368d768eed115e58716a60180d2df9.jpg', 'raging bull movie illustration', 'nullam-tristique-dapibus', '2022-09-08 14:04:52', '2022-09-08 14:04:52'),
(24, 78, 'Vestibulum sed massa vitae', 'Sed ultrices convallis nisl, vitae scelerisque mauris consequat sit amet.', 'Nulla tincidunt dolor et neque malesuada efficitur. Curabitur euismod, dui ac efficitur varius, enim velit molestie nulla, sit amet sollicitudin nibh leo eu sapien. Morbi a felis mattis, tristique erat nec, posuere nisi. Fusce euismod quis nibh quis vestibulum. Phasellus et velit at odio faucibus euismod. Pellentesque purus dui, tempor in fringilla in, lacinia vel eros. Pellentesque elit orci, placerat sed euismod nec, faucibus id nunc.', 'uploads/4f207abd277f28bef5310e646be1ddcc.jpg', 'matt damon taking coffee', 'vestibulum-sed-massa-vitae', '2022-09-08 14:07:01', '2022-09-08 14:07:01');

-- --------------------------------------------------------

--
-- Structure de la table `social_network`
--

CREATE TABLE `social_network` (
  `id` bigint NOT NULL,
  `icon_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(2048) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `social_network`
--

INSERT INTO `social_network` (`id`, `icon_name`, `url`, `name`) VALUES
(1, 'entypo-social:github', 'http://www.github.com/klaxurit', 'GitHube'),
(2, 'akar-icons:twitter-fill', 'http://www.twitter.com/axurit_', 'Twitter'),
(3, 'ion:social-instagram', 'http://www.instagram.com/axurit19', 'Instagra'),
(30, 'typcn:social-linkedin', 'http://linkedin.com/juncahugo', 'LinkedIn'),
(59, 'iconnameskew', 'skewurla', 'skew');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(78, 'JUNCA', 'Hugo', 'Axurit', 'admin@admin.com', '$argon2id$v=19$m=65536,t=4,p=1$N2diUnJhSnFYdjQ0cHJIWQ$31F2BgbT16B3VamrUR4Fs4xtvIFl94U//KfXXk7l2bw', '2022-09-08 16:48:28', '2022-09-08 16:48:28'),
(79, 'DOE', 'John', 'Jojo', 'user@user.com', '$argon2id$v=19$m=65536,t=4,p=1$clR5Zm5CckdiRzgyR0d2WQ$plZ3VRNM8UjrFKtpZlGHITxuzylKYZyayjZJTysbXK8', '2022-09-08 16:53:40', '2022-09-08 16:53:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_user_id` (`user_id`),
  ADD KEY `comment_post_id` (`post_id`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_user_id` (`user_id`);

--
-- Index pour la table `social_network`
--
ALTER TABLE `social_network`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `social_network`
--
ALTER TABLE `social_network`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
