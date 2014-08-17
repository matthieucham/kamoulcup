-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 26 Juillet 2012 à 20:58
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kcupeuro2012`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL auto_increment,
  `nom` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL COMMENT 'passwd md5',
  `droit` int(11) NOT NULL default '1',
  `ekyp_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `password`, `droit`, `ekyp_id`) VALUES
(37, 'admin', '5a09db7278f0f44ddeec1dd8f952777c', 5, NULL),
(6, 'Lo de Mars', '9a0cbb86e54bbe73325e72597916cc84', 2, NULL),
(4, 'Goupil', '9bf31c7ff062936a96d3c8bd1f8f2ff3', 3, 11),
(69, 'Milhouse', '90a6e6dcf025e19e1d39f52049ac0009', 1, 9),
(7, 'doumdoum', '9d5fcdd9016a8e52af9f13e28be71456', 3, 10),
(8, 'baygonsec', '1bcfef4e2e1f7ceeabfcc846ff0e1878', 3, 4),
(9, 'Latrell', 'dcf2bbf150e85801f036805a09b0b54f', 1, 12),
(29, 'Patogaz', '6142d77b323159d5ffa0bf17f44a6ab1', 1, NULL),
(12, 'beLIEve', '4cdd09333bb655c7af168f6f40e35c5e', 1, 7),
(13, 'vito', '9e5cc01407df050d72d255e80a7e4c94', 1, NULL),
(14, 'zaza', '476cf3418e4b42cca38e600180bb42ea', 1, NULL),
(15, 'Superpippo', 'c70eb7e1b3fac1971a167d348cec46a0', 1, 9),
(16, 'Charlie Brown', '3783da7904ad09ea85ba18526f073919', 5, NULL),
(18, 'matu', '76264ba2b64bd4fadfa5c929b88db9c8', 1, NULL),
(19, 'Axl', 'cfd68ae54076b9b13fd497039ed1b8b2', 3, 13),
(20, 'N14', 'aea155ee6f6266a9b4c11e99af45235e', 1, 3),
(21, 'Kenneth', '322cb643c702d0e9231f8aeef5bdca3e', 1, 10),
(22, 'bomba', 'ad41db22db601836acee0eecd71eb81b', 3, 11),
(23, 'ABAD', 'da64a6a6b5af2833d86905cccfb54e46', 3, 2),
(24, 'jack bauer', '3362ba0798d19de2c9048fdfcdf5ea34', 1, NULL),
(25, 'L''Amandier', '48b661538ce401fda167c1be0aca0ee5', 1, NULL),
(26, 'Tony Adams', '718a36d6e73457f1a89c1e30170e32d4', 1, NULL),
(27, 'Emile Durkheim', '5421837612f4a0496387a94242b64e23', 1, 6),
(68, 'support', '758695d1e09c3d255ef5988f2aa6f60b', 1, NULL),
(30, 'peterelephanto', '82349de11e998a11427c08ee129ff545', 1, NULL),
(31, 'Nusra', '5728b9c413c741a5e46cea2d493cd8f1', 1, NULL),
(32, 'loustic is back', '0c9d6f1e2c114a19ef61c86bfd1838fa', 1, NULL),
(34, 'Niederbacher', '0654d48ebc33648a2df0e2b30653daad', 1, NULL),
(35, 'Enzo El Principe', 'f57de6dc450a131d487e8266915db6a6', 1, NULL),
(36, 'Jihaime', '545affcb9814d39ab1efc28c0f4d1319', 1, NULL),
(39, 'Johann Gambolputty', 'dce97c21670b7c7efaaa6d784b09ba8d', 1, 12),
(40, 'Bar à Donna', 'ee9e8023a4e7faa911074bfa0c0b0c36', 1, 16),
(41, 'Selga', 'b1933e2b3c3d99c62d2831f448c98f6f', 1, 16),
(42, 'Numero_6', '39f972ec391b7e3562c4f30732fdb2df', 1, NULL),
(44, 'El Chibre De Oro', 'b5c9540f89aa43521619e55aa875762b', 1, NULL),
(45, 'Schweinsteiger', 'e371446e7486f95359c65e5d1f867501', 1, NULL),
(62, 'MEEM', '640ab97e5a962627b4eb3f686a566dd5', 1, NULL),
(46, 'Fier Panpan', '41d6aa337d90950e68f32a4979a5129d', 3, 14),
(47, 'Bernard Fat', '0b6b24a29a61c257406265a6cd22d9ca', 1, NULL),
(48, 'Big Rach', 'a479a1a0b970a9479c72572c72b01492', 1, 5),
(49, 'nonoz', '4be93258b70f02e433731bbc1ffee36a', 1, NULL),
(50, 'fraangelico', '7881350db66c08672a8c00ebe8eaec8a', 1, NULL),
(51, 'Wobblie', '808217196925833ff4099eea204e8fdc', 3, NULL),
(52, 'Massive', '545affcb9814d39ab1efc28c0f4d1319', 1, NULL),
(64, 'popo', '7f381f7278795c3af571bab12e42559c', 1, NULL),
(53, 'Kro''', 'a05427af1280eba83fa6e4196cc47eda', 1, NULL),
(54, 'Manu', 'f13bb1bed03db9d68a7d9a48aafeec78', 1, 15),
(55, 'AdF', '5e43cb0bc49c2d035fdc069fdc5a658a', 3, NULL),
(56, 'Leo', '580de5ab77587b23213e2c7023129047', 1, 1),
(57, 'gébé', '190985360a35bfd8990f4fc041ca7483', 1, NULL),
(58, 'Gilliatt', 'fb28cf539693ba5db4df07de297bf603', 1, 8),
(63, 'Ze Mayor Queen', '47425f409a7dd007d6e86c27a97e3e5d', 3, 1),
(59, 'cavalier sans tête', 'a71c748aa1c8ef6bac76792dac80294e', 1, NULL),
(60, 'Robero jr.', '5147f24cbdd2ab4f75c39090d4c34af6', 1, NULL),
(61, 'saco', 'd937ded6336a449bacc529bd3299f99a', 1, NULL),
(65, 'Brouche', '52a12063ea0852a1088deb387d095212', 3, 3),
(66, 'Forrest', 'bd2a87a2378cd2a937e503aa57ee49d4', 1, 11),
(70, 'zozo', '32cad5868737721ff84cd90c66384e78', 1, 14),
(71, 'Olaf', '65001fda0f2daa5141f5b3b8c1c2c43b', 1, 14),
(72, 'JeanBen', '670a87f7b9ef848f2c4df6a1f3f2c4b4', 1, 15),
(73, 'DNCG', '02585943f61e1cb91be167f1fbcdddce', 3, 2),
(74, 'un con', '5320e12e7ee4fe8484fe5f510fa711e5', 1, 15),
(75, 'Crampon', '399c1b8daca5867d0bba7e65fc624c45', 1, 46),
(76, 'Le Poulpe', 'b9147e9cf9a5e10301965d499cd211e6', 1, 21),
(77, 'Liv', '39831409f1e682343b653cee5a12764d', 1, 48),
(78, 'Flying Panda', 'ce61649168c4550c2f7acab92354dc6e', 1, 47),
(79, 'Ttournesol', 'c9c9c6538c4f6d6c7132a5d997c4b04f', 1, 6),
(80, 'Teddy S.', 'cb09a52da0badfda232734e9d53f67f9', 1, 47);

