-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 21 juil. 2022 à 18:03
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `site`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) DEFAULT NULL,
  `montant` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(3) NOT NULL,
  `id_commande` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `quantite` int(3) NOT NULL,
  `prix` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `ville` varchar(20) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `statut` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(35, 'test', 'test', 'test', 'test', 'test@test.fr', 'f', 'test', 38000, 'test', 0),
(36, 'test2', '$2y$10$mddW2jzKLPA5deopI9qnLuMedBTM/4CkzUPF7ggTMCnNlqGVkpi1a', 'test2', 'test2', 'test2@test.fr', 'f', 'test2', 38002, 'test2', 0),
(37, 'test3', '$2y$10$t/HsQqOvhTDV8dAA59YY9eJRGqKCWfbxlQv6N5sZ0AYnHYQPnNlHm', 'test3', 'test3', 'test3@test.fr', 'f', 'test3', 38003, 'test3', 0),
(38, 'test4', 'test4', '$2y$10$h7DZufGhHF0dj', 'test4', 'test4@test.fr', 'f', 'test4', 38004, 'test4', 0),
(39, 'test5', '$2y$10$GvZXBLzfQ4bzegLJqvp0Pu49jak8I.Po/WKlWNCIbJLZU4NzKVFAq', 'test5', 'test5', 'test5@test.fr', 'f', 'test5', 38005, 'test5', 0),
(40, 'admin', '$2y$10$10hzgoJ.kqVrCz2IizBsyOroRc72kbR8m0.hvg/s42LwxtN2kc4a2', 'admin', 'admin', 'admin@admin.fr', 'f', 'admin', 38006, 'admin', 1),
(41, 'letest', '$2y$10$LZn9n/2ZpFKHGUSrMlwvherCbtQFpIjqqbWLNaSQBX6wamqhgcPfa', 'letest', 'letest', 'test@test.fr', 'f', 'test', 38000, 'letest', 0),
(42, 'letest2', '$2y$10$XfsmBQYF29VaVYBHD.iUseqD6LNmkandYu/FqVRKo7UiVRa6FH.I6', 'letest2', 'letest2', 'test@test.fr', 'f', 'test', 38000, 'letest2', 0),
(43, 'titi', '$2y$10$NvdnstaV8ojndO9oo0sEBuvPMkG9sFp3AOYX1Xw2H9un27GbgYnMe', 'titi', 'titi', 'titi@titi.fr', 'f', 'paris', 75000, 'test titi', 0),
(44, 'tata', '$2y$10$ww4/4bSVtJk5eyrLhz2MEuVHQMxT.COA8ifDRpDZUVOb9K.3A.c8K', 'tata', 'tata', 'tata@tata.fr', 'f', 'Grenoble', 38000, 'test tata', 0),
(45, 'toto', '$2y$10$kWor7dBJ1ccJXGWJh8MDYevpdya7INjm1WpnSJxyG7gt7ZupIRyJO', 'toto', 'toto', 'toto@toto.fr', 'm', 'Grenoble', 38100, 'test toto', 0),
(46, 'lili', '$2y$10$Lv2AOQqPXbITxpLHbdEpQeALThAqz6AG5BEzokw.rPHXjlFE4tA/a', 'lili', 'lili', 'lili@lili.fr', 'f', 'test', 38000, 'test lili', 0),
(47, 'blabla', '$2y$10$daIOFoa51hEMACL6TVwE8em8VrbRdLdzRvia7jV8FhOd6o/kvsm5O', 'blabla', 'blabla', 'blabla@bla.com', 'm', 'blabla', 11111, 'blabla blabla', 0),
(48, 'bleble', '$2y$10$eGagHedMdg7VwKEN0WRIteZ7N0F8sicpnWCCHrSziGLLhHMW86ySO', 'bleble', 'bleble', 'bleble@ble.com', 'f', 'bleble', 22222, 'bleble bleble', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `categorie` varchar(20) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(20) NOT NULL,
  `taille` varchar(5) NOT NULL,
  `public` enum('m','f','mixte') NOT NULL,
  `photo` varchar(250) NOT NULL,
  `prix` int(3) NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `public`, `photo`, `prix`, `stock`) VALUES
(18, '123', 'pantalon', 'pantalon', 'le beau pantalon blanc', 'blanc', 'M', 'm', 'photo/pantalon2.jpg', 80, 2),
(19, '555', 'pull', 'pull blanc', 'c&#039;est très confortable', 'blanc', 'M', 'mixte', 'photo/pull1.jpg', 45, 50);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `id_produit` (`id_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
