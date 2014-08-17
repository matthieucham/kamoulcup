-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 17 Août 2014 à 10:32
-- Version du serveur: 5.1.41
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `kamoulcup`
--

-- --------------------------------------------------------

--
-- Structure de la table `bonus_joueur`
--

CREATE TABLE IF NOT EXISTS `bonus_joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joueur_id` int(11) NOT NULL,
  `type` enum('AS','ASP','UNFP_ET','UNFP_BY','UNFP_BP','UNFP_BK') NOT NULL,
  `valeur` decimal(3,1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `buteurs`
--

CREATE TABLE IF NOT EXISTS `buteurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rencontre_id` int(11) NOT NULL,
  `dom_ext` enum('DOM','EXT') NOT NULL,
  `buteur_id` int(11) NOT NULL,
  `passeur_id` int(11) NOT NULL,
  `penalty` tinyint(1) NOT NULL DEFAULT '0',
  `prolongation` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `choix_draft`
--

CREATE TABLE IF NOT EXISTS `choix_draft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poule_id` int(11) NOT NULL,
  `ekyp_id` int(11) NOT NULL,
  `order` smallint(6) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `id_lequipe` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `departage_vente`
--

CREATE TABLE IF NOT EXISTS `departage_vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vente_id` int(11) NOT NULL,
  `montant_initial` decimal(3,1) NOT NULL,
  `montant_nouveau` decimal(3,1) DEFAULT NULL,
  `ekyp_id` int(11) NOT NULL,
  `date_expiration` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ekyp`
--

CREATE TABLE IF NOT EXISTS `ekyp` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant',
  `nom` varchar(48) NOT NULL,
  `presentation` mediumtext,
  `logo` varchar(100) DEFAULT NULL COMMENT 'adresse du logo de l''ekyp',
  `poule_id` int(11) NOT NULL,
  `budget` decimal(4,1) NOT NULL DEFAULT '100.0',
  `bonus` decimal(3,2) NOT NULL DEFAULT '0.00',
  `score` float NOT NULL DEFAULT '0',
  `revente_ba` int(11) NOT NULL DEFAULT '0' COMMENT 'nb de reventes BA',
  `complete` tinyint(1) NOT NULL DEFAULT '0',
  `tactique_id` int(11) NOT NULL,
  `draft_order` smallint(6) NOT NULL DEFAULT '0',
  `score1` float NOT NULL DEFAULT '0',
  `score2` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `enchere`
--

CREATE TABLE IF NOT EXISTS `enchere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vente_id` int(11) NOT NULL,
  `date_envoi` datetime NOT NULL,
  `auteur` int(11) NOT NULL,
  `montant` decimal(3,1) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `exclue` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `vente_id` (`vente_id`,`auteur`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `feed_resolutions`
--

CREATE TABLE IF NOT EXISTS `feed_resolutions` (
  `date_enregistrement` datetime NOT NULL,
  `resolution_id` int(11) NOT NULL,
  `xml` longtext CHARACTER SET utf8 NOT NULL,
  `updatee` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`resolution_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `historique_debug`
--

CREATE TABLE IF NOT EXISTS `historique_debug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vente_id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL,
  `texte_debug` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `ekyp_concernee_id` int(11) NOT NULL,
  `joueur_concerne_id` int(11) NOT NULL,
  `type` enum('TR','NO','VE','AC','SE') NOT NULL,
  `complement_float` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date` (`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE IF NOT EXISTS `joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poste` set('G','D','M','A') NOT NULL,
  `prenom` varchar(32) DEFAULT NULL,
  `nom` varchar(32) NOT NULL,
  `id_lequipe` varchar(32) DEFAULT NULL,
  `id_ws` int(11) DEFAULT NULL,
  `club_id` int(11) DEFAULT NULL,
  `score` float NOT NULL DEFAULT '0',
  `matchs_joues` int(11) NOT NULL DEFAULT '0',
  `score1` float NOT NULL DEFAULT '0',
  `score2` float NOT NULL DEFAULT '0',
  `last_score` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `journee`
--

CREATE TABLE IF NOT EXISTS `journee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `palmares`
--

CREATE TABLE IF NOT EXISTS `palmares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_enregistrement` datetime NOT NULL,
  `trophee` text NOT NULL,
  `score_premier` float NOT NULL,
  `nom_premier` text NOT NULL,
  `effectif_premier` text NOT NULL,
  `score_deuxieme` float NOT NULL,
  `nom_deuxieme` text NOT NULL,
  `effectif_deuxieme` text NOT NULL,
  `score_troisieme` float NOT NULL,
  `nom_troisieme` text NOT NULL,
  `effectif_troisieme` text NOT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `nom_premier` (`nom_premier`),
  FULLTEXT KEY `trophee` (`trophee`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE IF NOT EXISTS `parametres` (
  `cle` varchar(32) NOT NULL,
  `valeur` varchar(15) NOT NULL,
  PRIMARY KEY (`cle`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `delai_encheres` int(11) NOT NULL,
  `reventes_autorisees` tinyint(1) NOT NULL DEFAULT '1',
  `coeff_bonus_achat` decimal(3,2) NOT NULL DEFAULT '0.00',
  `poule_id` int(11) NOT NULL,
  `draft` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `poule`
--

CREATE TABLE IF NOT EXISTS `poule` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant',
  `nom` varchar(32) NOT NULL COMMENT 'nom de la poule',
  `ouverte` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

CREATE TABLE IF NOT EXISTS `prestation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joueur_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `note_lequipe` decimal(3,1) DEFAULT NULL,
  `note_ff` decimal(3,1) DEFAULT NULL,
  `note_sp` decimal(3,1) DEFAULT NULL,
  `note_d` decimal(3,1) DEFAULT NULL,
  `note_e` decimal(3,1) DEFAULT NULL,
  `but_marque` int(11) NOT NULL DEFAULT '0',
  `passe_dec` int(11) NOT NULL DEFAULT '0',
  `penalty_marque` int(11) NOT NULL DEFAULT '0',
  `defense_vierge` tinyint(1) NOT NULL DEFAULT '0',
  `defense_unpenalty` tinyint(1) NOT NULL DEFAULT '0',
  `defense_unbut` tinyint(1) NOT NULL DEFAULT '0',
  `troisbuts` tinyint(1) NOT NULL DEFAULT '0',
  `troisbuts_unpenalty` tinyint(1) NOT NULL DEFAULT '0',
  `club_id` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `penalty_obtenu` int(11) NOT NULL DEFAULT '0',
  `minutes` int(11) DEFAULT NULL,
  `double_bonus` tinyint(1) NOT NULL DEFAULT '0',
  `leader` tinyint(1) NOT NULL DEFAULT '0',
  `arrets` int(11) NOT NULL DEFAULT '0',
  `encaisses` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `joueur_id` (`joueur_id`,`match_id`),
  UNIQUE KEY `joueur_id_2` (`joueur_id`,`match_id`),
  KEY `score` (`score`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `rencontre`
--

CREATE TABLE IF NOT EXISTS `rencontre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `club_dom_id` int(11) NOT NULL,
  `club_ext_id` int(11) NOT NULL,
  `buts_club_dom` int(11) NOT NULL,
  `buts_club_ext` int(11) NOT NULL,
  `journee_id` int(11) DEFAULT NULL,
  `elimination` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `resolution`
--

CREATE TABLE IF NOT EXISTS `resolution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vente_id` int(11) NOT NULL,
  `montant_gagnant` decimal(3,1) DEFAULT NULL,
  `montant_deuxieme` decimal(3,1) DEFAULT NULL,
  `gagnant_id` int(11) DEFAULT NULL,
  `reserve` int(11) NOT NULL DEFAULT '0' COMMENT 'flag qui vaut 1 si prix reserve pas atteint',
  `annulee` int(11) NOT NULL DEFAULT '0' COMMENT 'flag qui vaut 1 si vente annulée pour cause d''insolvabilité',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stats_ekyps`
--

CREATE TABLE IF NOT EXISTS `stats_ekyps` (
  `journee_id` int(11) NOT NULL,
  `ekyp_id` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `classement` tinyint(2) NOT NULL DEFAULT '0',
  `score1` float NOT NULL DEFAULT '0',
  `score2` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`journee_id`,`ekyp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `stats_joueurs`
--

CREATE TABLE IF NOT EXISTS `stats_joueurs` (
  `journee_id` int(11) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  `score` float NOT NULL DEFAULT '0',
  `score1` float NOT NULL DEFAULT '0',
  `score2` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`journee_id`,`joueur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tactique`
--

CREATE TABLE IF NOT EXISTS `tactique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` tinytext NOT NULL,
  `nb_g` tinyint(1) NOT NULL,
  `nb_d` tinyint(1) NOT NULL,
  `nb_m` tinyint(1) NOT NULL,
  `nb_a` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `transfert`
--

CREATE TABLE IF NOT EXISTS `transfert` (
  `joueur_id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `prix_achat` decimal(3,1) NOT NULL DEFAULT '0.0',
  `ekyp_id` int(11) DEFAULT NULL,
  `anciennete` int(3) NOT NULL DEFAULT '0',
  `transfert_date` date NOT NULL,
  `poule_id` int(11) NOT NULL,
  `definitif` tinyint(1) NOT NULL DEFAULT '0',
  `coeff_bonus_achat` decimal(3,2) NOT NULL DEFAULT '1.00',
  `draft` tinyint(1) NOT NULL DEFAULT '0',
  `choix_draft` smallint(6) NOT NULL DEFAULT '0',
  UNIQUE KEY `TRANSFERT_IDX` (`joueur_id`,`session_id`),
  UNIQUE KEY `joueur_id` (`joueur_id`,`ekyp_id`,`poule_id`,`draft`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'passwd md5',
  `droit` int(11) NOT NULL DEFAULT '1',
  `ekyp_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE IF NOT EXISTS `vente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_soumission` datetime NOT NULL,
  `date_finencheres` datetime DEFAULT NULL,
  `type` enum('PA','MV','RE') NOT NULL DEFAULT 'PA',
  `session_id` int(11) DEFAULT NULL,
  `joueur_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `montant` decimal(3,1) NOT NULL,
  `resolue` int(11) NOT NULL DEFAULT '0',
  `poule_id` int(11) NOT NULL,
  `prix_reserve` decimal(3,1) NOT NULL DEFAULT '0.0',
  `departage_attente` int(11) NOT NULL DEFAULT '0' COMMENT 'nombre d''ekyps a departager car offre égales',
  `coeff_bonus_achat` decimal(3,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`,`session_id`,`joueur_id`),
  KEY `date_soumission` (`date_soumission`),
  KEY `date_finencheres` (`date_finencheres`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
