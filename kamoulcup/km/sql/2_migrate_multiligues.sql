DROP TABLE `km_ekyp_budget`;


CREATE TABLE IF NOT EXISTS `km_franchise` (
  `fra_id` int(11) NOT NULL AUTO_INCREMENT,
  `fra_nom` varchar(256) NOT NULL,
  PRIMARY KEY (`fra_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO km_franchise( fra_id, fra_nom )
SELECT id, nom
FROM ekyp
WHERE km =1;

ALTER TABLE `utilisateur` ADD `franchise_id` INT NULL ;
UPDATE `utilisateur` SET franchise_id = ( SELECT fra_id
FROM km_franchise
WHERE fra_id = ekyp_id ) ;


ALTER TABLE km_join_ekyp_championnat DROP PRIMARY KEY;
ALTER TABLE `km_join_ekyp_championnat` ADD `ins_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ;
ALTER TABLE `km_join_ekyp_championnat` CHANGE `jec_ekyp_id` `ins_franchise_id` INT( 11 ) NOT NULL ,
CHANGE `jec_championnat_id` `ins_championnat_id` INT( 11 ) NOT NULL ;
ALTER TABLE `kamoulcup`.`km_join_ekyp_championnat` ADD UNIQUE `unique_franchise_champ` ( `ins_franchise_id` , `ins_championnat_id` ) ;
RENAME TABLE km_join_ekyp_championnat TO km_inscription;


CREATE TABLE IF NOT EXISTS `km_championnat_round` (
  `cro_id` int(11) NOT NULL AUTO_INCREMENT,
  `cro_championnat_id` int(11) NOT NULL,
  `cro_journee_id` int(11) NOT NULL,
  `cro_processed` tinyint(1) NOT NULL DEFAULT '0',
  `cro_numero` int(11) NOT NULL,
  PRIMARY KEY (`cro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `km_championnat_round` DROP `cro_processed`;
ALTER TABLE `km_championnat_round` ADD `cro_status` ENUM( 'CREATED', 'PLAYED', 'PROCESSED', 'CANCELLED', 'ARCHIVED' ) NOT NULL DEFAULT 'CREATED';



ALTER TABLE `km_championnat` ADD `chp_status` ENUM( 'CREATED', 'STARTED', 'FINISHED', 'CANCELLED', 'ABORTED' ) NOT NULL DEFAULT 'CREATED';
UPDATE `kamoulcup`.`km_championnat` SET `chp_status` = 'STARTED' WHERE `km_championnat`.`chp_first_journee_numero` =14;

CREATE TABLE IF NOT EXISTS `km_palmares` (
  `pal_franchise_id` int(11) NOT NULL,
  `pal_championnat_id` int(11) NOT NULL,
  `pal_ranking` int(11) NOT NULL,
  `pal_score` int(11) NOT NULL,
  PRIMARY KEY (`pal_franchise_id`,`pal_championnat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `km_mercato` ADD `mer_championnat_id` INT NOT NULL ;
UPDATE `km_mercato` SET mer_championnat_id = ( SELECT chp_id
FROM km_championnat
WHERE km_championnat.chp_first_journee_numero =14 );

ALTER TABLE `km_ekyp_score` DROP `eks_championnat_id` ;
RENAME TABLE `km_ekyp_score` TO km_franchise_score;
ALTER TABLE `km_franchise_score` CHANGE `eks_ekyp_id` `fsc_inscription_id` INT( 11 ) NOT NULL ,
CHANGE `eks_journee_id` `fsc_round_id` INT( 11 ) NOT NULL ;

TRUNCATE `km_franchise_score`;

UPDATE `km_engagement` SET eng_ekyp_id = ( SELECT ins_id
FROM km_inscription
WHERE ins_franchise_id = eng_ekyp_id
AND ins_championnat_id = (
SELECT chp_id
FROM km_championnat
WHERE km_championnat.chp_first_journee_numero =14 ) );
ALTER TABLE `km_engagement` CHANGE `eng_ekyp_id` `eng_inscription_id` INT( 11 ) NOT NULL ;

UPDATE `km_finances` SET fin_ekyp_id = ( SELECT ins_id
FROM km_inscription
WHERE ins_franchise_id = fin_ekyp_id
AND ins_championnat_id = (
SELECT chp_id
FROM km_championnat
WHERE km_championnat.chp_first_journee_numero =14 ) ) ;
ALTER TABLE `km_finances` CHANGE `fin_ekyp_id` `fin_inscription_id` INT( 11 ) NOT NULL ;

UPDATE `km_offre` SET off_ekyp_id = ( SELECT ins_id
FROM km_inscription
WHERE ins_franchise_id = off_ekyp_id
AND ins_championnat_id = (
SELECT mer_championnat_id
FROM km_mercato
WHERE mer_id=off_mercato_id ) ) ;
ALTER TABLE `km_offre` CHANGE `off_ekyp_id` `off_inscription_id` INT( 11 ) NOT NULL ;

update `km_selection_ekyp_journee` set sej_journee_id=(select cro_id from km_championnat_round inner join km_championnat on chp_id=cro_championnat_id inner join km_inscription on ins_championnat_id=chp_id inner join km_engagement on eng_inscription_id=ins_id where cro_journee_id=sej_journee_id and eng_id=sej_engagement_id)

RENAME TABLE `km_selection_ekyp_journee` TO km_selection_round;
ALTER TABLE `km_selection_round` CHANGE `sej_engagement_id` `sro_engagement_id` INT( 11 ) NOT NULL ,
CHANGE `sej_journee_id` `sro_round_id` INT( 11 ) NOT NULL ,
CHANGE `sej_substitute` `sro_substitute` TINYINT( 1 ) NOT NULL DEFAULT '0';



