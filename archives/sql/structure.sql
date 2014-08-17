-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 17 Août 2014 à 10:41
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `kcup_archives`
--

-- --------------------------------------------------------

--
-- Structure de la table `palmares`
--

CREATE TABLE IF NOT EXISTS `palmares` (
  `titre` varchar(128) NOT NULL,
  `date_competition` date NOT NULL,
  `url_site` varchar(256) NOT NULL,
  `sql_backup_filename` varchar(256) NOT NULL,
  `zip_backup_filename` varchar(128) NOT NULL,
  `vainqueur` varchar(64) NOT NULL,
  `vainqueur_roster` mediumtext NOT NULL,
  `deuxieme` varchar(64) NOT NULL,
  `deuxieme_roster` mediumtext NOT NULL,
  `troisieme` varchar(64) NOT NULL,
  `troisieme_roster` mediumtext NOT NULL,
  `vainqueur_score` float NOT NULL,
  `deuxieme_score` float NOT NULL,
  `troisieme_score` float NOT NULL,
  `type` enum('L1','NA') NOT NULL DEFAULT 'L1',
  PRIMARY KEY (`titre`),
  UNIQUE KEY `date_competition` (`date_competition`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
