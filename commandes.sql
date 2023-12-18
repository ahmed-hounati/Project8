-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 18 déc. 2023 à 14:49
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4
SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
    time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;

/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de données : `dataware`
--
-- --------------------------------------------------------
--
-- Structure de la table `equipes`
--
CREATE TABLE `equipes` (
    `IDEquipe` int(11) NOT NULL,
    `NomEquipe` varchar(255) DEFAULT NULL,
    `Statut` varchar(50) DEFAULT NULL,
    `DateCreation` datetime NOT NULL DEFAULT curtime()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipes`
--
INSERT INTO
    `equipes` (
        `IDEquipe`,
        `NomEquipe`,
        `Statut`,
        `DateCreation`
    )
VALUES
    (1, 'TEAM', 'Active', '2023-11-24 11:06:47'),
    (2, 'TEAM2', 'Active', '2023-11-24 11:09:25'),
    (3, 'TEAM3', 'Inactive', '2023-11-24 11:09:25'),
    (4, 'TEAM4', 'Active', '2023-11-24 11:09:25'),
    (7, 'TEAM7', 'inActive', '2023-11-28 10:19:25');

-- --------------------------------------------------------
--
-- Structure de la table `perssonel`
--
CREATE TABLE `perssonel` (
    `Id` int(11) NOT NULL,
    `FirstName` varchar(255) DEFAULT NULL,
    `LastName` varchar(255) DEFAULT NULL,
    `Email` varchar(255) DEFAULT NULL,
    `Passdwd` varchar(255) DEFAULT NULL,
    `Tel` varchar(25) DEFAULT NULL,
    `IDTeam` int(11) DEFAULT NULL,
    `Statut` varchar(255) DEFAULT NULL,
    `DateCreation` datetime NOT NULL DEFAULT curtime(),
    `IDProject` int(11) DEFAULT NULL,
    `role` enum('user', 'scrum_master', 'product_owner') NOT NULL DEFAULT 'user'
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `perssonel`
--
INSERT INTO
    `perssonel` (
        `Id`,
        `FirstName`,
        `LastName`,
        `Email`,
        `Passdwd`,
        `Tel`,
        `IDTeam`,
        `Statut`,
        `DateCreation`,
        `IDProject`,
        `role`
    )
VALUES
    (
        1,
        'ahmed',
        'hounatiiiiiii',
        'ahmedhn99@gmail.com',
        '$2y$10$OAS/hPTyATDBGW1nZ7S73e4gN09HMBuXkC.Mdph.eypPQO2NrWjge',
        '0628493257',
        1,
        'active',
        '2023-11-24 15:16:08',
        1,
        'product_owner'
    ),
    (
        6,
        'mahdooooo',
        'aziz',
        'mahdiaziz@gmail.com',
        '$2y$10$8GllKUlBl827zqX6uNcS6uauoPJ2As8EpIOA4MKx.0dyZwZTgoqGO',
        '0695909100',
        2,
        'inActive',
        '2023-11-28 19:44:00',
        2,
        'user'
    ),
    (
        7,
        'nassim',
        'bonnani',
        'nassim1@gmail.com',
        '$2y$10$s2qSxvYribuEuJFZ8IYb7eakeThZUuWK3f4kf0ViWHfgaWowx3z1.',
        '0628553257',
        3,
        'active',
        '2023-11-28 19:57:47',
        2,
        'scrum_master'
    ),
    (
        8,
        'hamza',
        'himmi',
        'hamza@gmail.com',
        '$2y$10$/ERkKiLWGWGREFjocbBcHOhaN8lTGyuaa4rVrApmsxB2Br9KD.CS6',
        '061122334455',
        4,
        'active',
        '2023-11-28 20:02:28',
        1,
        'user'
    ),
    (
        9,
        'abdo',
        'lumii',
        'abdo@gmail.com',
        '$2y$10$GREuml0nvdIOlgYZ.2GFTO/YhotN1x.ydee.ZKM/9et5yf5W/2f9i',
        '7894560',
        7,
        'active',
        '2023-12-14 18:46:27',
        2,
        'user'
    ),
    (
        10,
        'moad',
        'toto',
        'toto@gmail.com',
        '$2y$10$qdgShjk8z0BDoZO0NVZDBuOHC5rHuOdcejvvrEGNUcxUGjpPWM0ce',
        '1234567890',
        1,
        'active',
        '2023-12-15 11:34:05',
        2,
        'user'
    );

-- --------------------------------------------------------
--
-- Structure de la table `projects`
--
CREATE TABLE `projects` (
    `IDProject` int(11) NOT NULL,
    `ProjectName` varchar(50) DEFAULT NULL,
    `Discription` varchar(255) DEFAULT NULL,
    `Datedepart` datetime NOT NULL DEFAULT curtime(),
    `Datedefini` varchar(10) DEFAULT NULL,
    `IDPO` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

--
-- Déchargement des données de la table `projects`
--
INSERT INTO
    `projects` (
        `IDProject`,
        `ProjectName`,
        `Discription`,
        `Datedepart`,
        `Datedefini`,
        `IDPO`
    )
VALUES
    (
        1,
        'brief',
        'this is project 1',
        '2023-11-28 11:07:35',
        '2023-30-12',
        0
    ),
    (
        2,
        'projectX',
        'halaloya',
        '2023-11-28 12:22:43',
        '2023-12-10',
        0
    );

--
-- Index pour les tables déchargées
--
--
-- Index pour la table `equipes`
--
ALTER TABLE
    `equipes`
ADD
    PRIMARY KEY (`IDEquipe`);

--
-- Index pour la table `perssonel`
--
ALTER TABLE
    `perssonel`
ADD
    PRIMARY KEY (`Id`),
ADD
    KEY `IDTeam` (`IDTeam`),
ADD
    KEY `IDProject` (`IDProject`);

--
-- Index pour la table `projects`
--
ALTER TABLE
    `projects`
ADD
    PRIMARY KEY (`IDProject`);

--
-- AUTO_INCREMENT pour les tables déchargées
--
--
-- AUTO_INCREMENT pour la table `equipes`
--
ALTER TABLE
    `equipes`
MODIFY
    `IDEquipe` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT pour la table `perssonel`
--
ALTER TABLE
    `perssonel`
MODIFY
    `Id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE
    `projects`
MODIFY
    `IDProject` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- Contraintes pour les tables déchargées
--
--
-- Contraintes pour la table `perssonel`
--
ALTER TABLE
    `perssonel`
ADD
    CONSTRAINT `perssonel_ibfk_1` FOREIGN KEY (`IDTeam`) REFERENCES `equipes` (`IDEquipe`),
ADD
    CONSTRAINT `perssonel_ibfk_2` FOREIGN KEY (`IDProject`) REFERENCES `projects` (`IDProject`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;