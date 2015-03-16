ALTER TABLE `km_finances` ADD `fin_code` ENUM( 'INIT', 'BUY', 'SELL', 'WAGE' ) NULL DEFAULT NULL ;

UPDATE `km_finances` SET fin_code = 'BUY' WHERE fin_event LIKE 'Achat du%'
UPDATE `km_finances` SET fin_code = 'INIT' WHERE fin_event LIKE 'Creation%'
UPDATE `km_finances` SET fin_code = 'INIT' WHERE fin_event LIKE 'Initialisation%'
UPDATE `km_finances` SET fin_code = 'SELL' WHERE fin_event LIKE 'Vente du%'