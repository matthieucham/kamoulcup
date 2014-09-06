INSERT INTO `km_const_salaire_classe` (`scl_id`, `scl_salaire`, `scl_seuil_inf`, `scl_seuil_sup`, `scl_next_up`, `scl_next_down`) VALUES
(1, '4.0', '0.00', '6.10', 2, 1),
(2, '6.0', '6.10', '6.30', 3, 1),
(3, '7.0', '6.30', '6.50', 4, 2),
(4, '8.0', '6.50', '7.00', 5, 3),
(5, '9.0', '7.00', '7.50', 6, 4),
(6, '10.0', '7.50', '8.00', 7, 5),
(7, '12.0', '8.00', '8.50', 8, 6),
(8, '14.0', '8.50', '8.90', 9, 7),
(9, '16.0', '8.90', '9.20', 10, 8),
(10, '20.0', '9.20', '0.00', 10, 9);

INSERT INTO `km_finances` ( `fin_ekyp_id` , `fin_date` , `fin_transaction` , `fin_solde` , `fin_event` )
SELECT id, now( ) , 100.0, 100.0, 'Creation de la franchise' FROM ekyp WHERE km =1