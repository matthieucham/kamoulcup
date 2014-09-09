-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 06 Septembre 2014 à 21:03
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `kamoulcup`
--

-- --------------------------------------------------------

--
-- Structure de la table `km_const_salaire_classe`
--

CREATE TABLE IF NOT EXISTS `km_const_salaire_classe` (
  `scl_id` int(11) NOT NULL,
  `scl_salaire` decimal(3,1) NOT NULL,
  `scl_seuil_inf` decimal(3,2) NOT NULL,
  `scl_seuil_sup` decimal(3,2) NOT NULL,
  `scl_next_up` int(11) NOT NULL,
  `scl_next_down` int(11) NOT NULL,
  PRIMARY KEY (`scl_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_ekyp_budget`
--

CREATE TABLE IF NOT EXISTS `km_ekyp_budget` (
  `ekb_ekyp_id` int(11) NOT NULL,
  `ekb_budget` decimal(3,1) NOT NULL,
  `ekb_ms` decimal(3,1) NOT NULL,
  PRIMARY KEY (`ekb_ekyp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_ekyp_score`
--

CREATE TABLE IF NOT EXISTS `km_ekyp_score` (
  `eks_ekyp_id` int(11) NOT NULL,
  `eks_journee_id` int(11) NOT NULL,
  `eks_score` float NOT NULL,
  PRIMARY KEY (`eks_ekyp_id`,`eks_journee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_engagement`
--

CREATE TABLE IF NOT EXISTS `km_engagement` (
  `eng_id` int(11) NOT NULL AUTO_INCREMENT,
  `eng_ekyp_id` int(11) NOT NULL,
  `eng_joueur_id` int(11) NOT NULL,
  `eng_salaire` decimal(3,1) NOT NULL,
  `eng_date_arrivee` datetime NOT NULL,
  `eng_date_depart` datetime DEFAULT NULL,
  `eng_montant` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`eng_id`),
  UNIQUE KEY `eng_ekyp_id` (`eng_ekyp_id`,`eng_joueur_id`,`eng_date_arrivee`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=280 ;

-- --------------------------------------------------------

--
-- Structure de la table `km_finances`
--

CREATE TABLE IF NOT EXISTS `km_finances` (
  `fin_id` int(11) NOT NULL AUTO_INCREMENT,
  `fin_ekyp_id` int(11) NOT NULL,
  `fin_date` date NOT NULL,
  `fin_transaction` decimal(4,1) NOT NULL,
  `fin_solde` decimal(4,1) NOT NULL,
  `fin_event` mediumtext NOT NULL,
  PRIMARY KEY (`fin_id`),
  KEY `fin_ekyp_id` (`fin_ekyp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Structure de la table `km_join_joueur_salaire`
--

CREATE TABLE IF NOT EXISTS `km_join_joueur_salaire` (
  `jjs_joueur_id` int(11) NOT NULL,
  `jjs_salaire_classe_id` int(11) NOT NULL DEFAULT '1',
  `jjs_journee_id` int(11) NOT NULL,
  PRIMARY KEY (`jjs_joueur_id`,`jjs_journee_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_joueur_perf`
--

CREATE TABLE IF NOT EXISTS `km_joueur_perf` (
  `jpe_joueur_id` int(11) NOT NULL,
  `jpe_match_id` int(11) NOT NULL,
  `jpe_score` float NOT NULL,
  PRIMARY KEY (`jpe_joueur_id`,`jpe_match_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_liste_transferts`
--

CREATE TABLE IF NOT EXISTS `km_liste_transferts` (
  `ltr_engagement_id` int(11) NOT NULL,
  `ltr_montant` decimal(3,1) NOT NULL,
  PRIMARY KEY (`ltr_engagement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_mercato`
--

CREATE TABLE IF NOT EXISTS `km_mercato` (
  `mer_id` int(11) NOT NULL AUTO_INCREMENT,
  `mer_date_ouverture` datetime NOT NULL,
  `mer_date_fermeture` datetime NOT NULL,
  `mer_processed` tinyint(1) NOT NULL,
  PRIMARY KEY (`mer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Structure de la table `km_offre`
--

CREATE TABLE IF NOT EXISTS `km_offre` (
  `off_joueur_id` int(11) NOT NULL,
  `off_mercato_id` int(11) NOT NULL,
  `off_montant` decimal(3,1) NOT NULL,
  `off_ekyp_id` int(11) NOT NULL,
  `off_winner` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`off_joueur_id`,`off_mercato_id`,`off_ekyp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `km_selection_ekyp_match`
--

CREATE TABLE IF NOT EXISTS `km_selection_ekyp_match` (
  `sem_match_id` int(11) NOT NULL,
  `sem_engagement_id` int(11) NOT NULL,
  `substitute` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sem_match_id`,`sem_engagement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `ekyp` ADD `km` TINYINT( 1 ) NOT NULL DEFAULT '0';

CREATE TABLE IF NOT EXISTS `km_championnat` (
  `chp_id` int(11) NOT NULL AUTO_INCREMENT,
  `chp_nom` text NOT NULL,
  `chp_first_journee_id` int(11) NOT NULL,
  `chp_nb_journees` int(11) NOT NULL,
  PRIMARY KEY (`chp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Structure de la table `km_join_ekyp_championnat`
--

CREATE TABLE IF NOT EXISTS `km_join_ekyp_championnat` (
  `jec_ekyp_id` int(11) NOT NULL,
  `jec_championnat_id` int(11) NOT NULL,
  PRIMARY KEY (`jec_ekyp_id`,`jec_championnat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
