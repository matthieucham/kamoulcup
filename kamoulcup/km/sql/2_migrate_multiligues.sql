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


ALTER TABLE `km_championnat` ADD `chp_status` ENUM( 'CREATED', 'STARTED', 'FINISHED', 'CANCELLED', 'ABORTED' ) NOT NULL DEFAULT 'CREATED';
UPDATE `kamoulcup`.`km_championnat` SET `chp_status` = 'STARTED' WHERE `km_championnat`.`chp_first_journee_numero` =14;

CREATE TABLE IF NOT EXISTS `km_palmares` (
  `pal_franchise_id` int(11) NOT NULL,
  `pal_championnat_id` int(11) NOT NULL,
  `pal_ranking` int(11) NOT NULL,
  `pal_score` int(11) NOT NULL,
  PRIMARY KEY (`pal_franchise_id`,`pal_championnat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

