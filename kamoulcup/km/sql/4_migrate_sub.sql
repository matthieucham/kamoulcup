ALTER TABLE `km_selection_round` ADD `sro_sub_time` INT NOT NULL DEFAULT '0';
ALTER TABLE `km_selection_round` ADD `sro_selected` TINYINT( 1 ) NOT NULL DEFAULT '0';

UPDATE `km_selection_round` SET sro_selected =1 WHERE sro_substitute =0;

