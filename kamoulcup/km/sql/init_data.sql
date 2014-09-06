
INSERT INTO `km_const_salaire_classe` (`scl_id`, `scl_salaire`, `scl_seuil_inf`, `scl_seuil_sup`, `scl_next_up`, `scl_next_down`) VALUES
(1, '4.0', '0.00', '6.10', 2, 1),
(2, '6.0', '6.10', '6.30', 3, 1),
(3, '7.0', '6.30', '6.50', 4, 2),
(4, '8.0', '6.50', '6.75', 5, 3),
(5, '9.0', '6.75', '7.10', 6, 4),
(6, '10.0', '7.10', '7.60', 7, 5),
(7, '12.0', '7.60', '8.00', 8, 6),
(8, '14.0', '8.00', '8.40', 9, 7),
(9, '16.0', '8.40', '8.90', 10, 8),
(10, '20.0', '8.90', '0.00', 10, 9);


INSERT INTO `km_finances` ( `fin_ekyp_id` , `fin_date` , `fin_transaction` , `fin_solde` , `fin_event` )
SELECT id, now( ) , 100.0, 100.0, 'Creation de la franchise' FROM ekyp WHERE km =1