
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
SELECT id, now( ) , 100.0, 100.0, 'Creation de la franchise' FROM ekyp WHERE km =1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,10,0 from joueur where prenom="Loïc" and nom="Perrin" on duplicate key update jjs_salaire_classe_id=10;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,10,0 from joueur where prenom="Rémy" and nom="Cabella" on duplicate key update jjs_salaire_classe_id=10;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,10,0 from joueur where prenom="Salvatore" and nom="Sirigu" on duplicate key update jjs_salaire_classe_id=10;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,10,0 from joueur where prenom="Vincent" and nom="Enyeama" on duplicate key update jjs_salaire_classe_id=10;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,10,0 from joueur where prenom="Zlatan" and nom="Ibrahimovic" on duplicate key update jjs_salaire_classe_id=10;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,9,0 from joueur where prenom="Daniel" and nom="Wass" on duplicate key update jjs_salaire_classe_id=9;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,9,0 from joueur where prenom="Serge" and nom="Aurier" on duplicate key update jjs_salaire_classe_id=9;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,9,0 from joueur where prenom="Marko" and nom="Basa" on duplicate key update jjs_salaire_classe_id=9;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,9,0 from joueur where prenom="James" and nom="Rodriguez" on duplicate key update jjs_salaire_classe_id=9;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,9,0 from joueur where prenom="Henri" and nom="Bedimo" on duplicate key update jjs_salaire_classe_id=9;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="David Ramirez" and nom="Ospina" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Pape N'Diaye" and nom="Souaré" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Layvin" and nom="Kurzawa" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Alexandre" and nom="Lacazette" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="" and nom="Thiago Silva" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Wissam" and nom="Ben Yedder" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Romain" and nom="Hamouma" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Simon" and nom="Kjaer" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Salomon" and nom="Kalou" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,8,0 from joueur where prenom="Vincent" and nom="Aboubakar" on duplicate key update jjs_salaire_classe_id=8;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Stéphane" and nom="Ruffier" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Papy Mison" and nom="Djilobodji" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Sébastien" and nom="Corchia" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Grégory" and nom="Sertic" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Ricardo" and nom="Carvalho" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Lucas" and nom="Moura" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="André-Pierre" and nom="Gignac" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Issa" and nom="Cissokho" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Moustapha" and nom="Sall" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,7,0 from joueur where prenom="Edinson" and nom="Cavani" on duplicate key update jjs_salaire_classe_id=7;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Bafétimbi " and nom="Gomis" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Benoît" and nom="Costil" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="" and nom="Mariano" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Jérémy" and nom="Toulalan" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Bruno" and nom="Ecuele Manga" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Danijel" and nom="Subasic" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Florent" and nom="Balmont" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Prince" and nom="Oniangué" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Mathieu" and nom="Bodmer" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Oswaldo" and nom="Vizcarrondo" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="" and nom="Alex" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Aissa" and nom="Mandi" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Thimothée" and nom="Kolodziejczak" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Thiago" and nom="Motta" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Sébastien" and nom="Squillaci" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Jeremy" and nom="Sorbon" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Yann" and nom="Jouffre" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Franck" and nom="Béria" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Sylvain" and nom="Armand" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,6,0 from joueur where prenom="Grzegorz" and nom="Krychowiak" on duplicate key update jjs_salaire_classe_id=6;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Mevlut" and nom="Erding" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Clément" and nom="Grenier" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Idrissa" and nom="Gueye" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Mathieu" and nom="Valbuena" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Fabien " and nom="Lemoine" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Joao" and nom="Moutinho" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Cédric" and nom="Carrasso" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Anthony" and nom="Lopes" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Tongo Hamed" and nom="Doumbia" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Romain" and nom="Genevois" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Julien" and nom="Faussurier" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Julian" and nom="Palmieri" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Blaise" and nom="Matuidi" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Christophe" and nom="Kerbrat" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Rémy" and nom="Riou" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="François" and nom="Clerc" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Martin" and nom="Braithwaite" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Lamine" and nom="Sané" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Nicolas" and nom="Nkoulou" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,5,0 from joueur where prenom="Dimitri " and nom="Payet" on duplicate key update jjs_salaire_classe_id=5;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="N'Dri" and nom="Romaric" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Filip" and nom="Djordjevic" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Marco" and nom="Verratti" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Florian" and nom="Thauvin" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Wesley" and nom="Lautoa" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Kossi" and nom="Agassa" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Sherrer" and nom="Maxwell" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Benjamin" and nom="Corgnet" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Wahbi" and nom="Khazri" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Romain" and nom="Alessandrini" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Younousse" and nom="Sankharé" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Daniel" and nom="Congré" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Nolan" and nom="Roux" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Carlos" and nom="Henrique" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Vitorino" and nom="Hilton" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Mustapha" and nom="Yatabaré" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Raphaël" and nom="Guerreiro" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Serge" and nom="Gakpé" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Rio" and nom="Mavuba" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,4,0 from joueur where prenom="Mickael" and nom="Tacalfred" on duplicate key update jjs_salaire_classe_id=4;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Youssouf" and nom="Sabaly" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Issiaga" and nom="Sylla" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="François-Joseph" and nom="Modesto" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Carlos Roberto" and nom="Carlão" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Andrea" and nom="Raggi" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Alejandro" and nom="Bedoya" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Jean II" and nom="Makoun" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Maxime" and nom="Gonalons" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Abdelhamid" and nom="El Kaoutari" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Mounir" and nom="Obbadi" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Claudio" and nom="Beauvue" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Kévin" and nom="Monnet-Paquet" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Anthony" and nom="Weber" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Etienne" and nom="Didot" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Gregory" and nom="Van der Wiel" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Roy" and nom="Contout" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Romain" and nom="Danzé" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Christian" and nom="Brüls" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Ezequiel" and nom="Lavezzi" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Clément" and nom="Chantôme" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Samuel" and nom="Umtiti" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Benjamin" and nom="André" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Geoffrey" and nom="Jourdren" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Nicolas" and nom="Maurice-Belay" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Henri" and nom="Saivet" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Lucas" and nom="Deaux" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Ryad" and nom="Boudebouz" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Benjamin" and nom="Stambouli" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Kévin" and nom="Bérigaud" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,3,0 from joueur where prenom="Cédric" and nom="Mongongu" on duplicate key update jjs_salaire_classe_id=3;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Lionel" and nom="Mathis" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Foued" and nom="Kadir" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Paul" and nom="Lasne" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Franck" and nom="Tabanou" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Arthur" and nom="Masuaku" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Matthieu" and nom="Dossevi" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Uros" and nom="Spajic" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Odaïr" and nom="Fortes" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Morgan" and nom="Sanson" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Eric" and nom="Abidal" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Jérémie" and nom="Aliadière" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Emmanuel" and nom="Rivière" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Olivier" and nom="Sorlin" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Jacques-Alaixys" and nom="Romao" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Cheick" and nom="Diabaté" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Gueïda" and nom="Fofana" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Steve" and nom="Mandanda" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Gary" and nom="Kagelmacher" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Sébastien" and nom="Roudet" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Siaka" and nom="Tiéné" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Milan " and nom="Bisevac" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Valentin" and nom="Eysseric" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Lucas" and nom="Orbán" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Antoine" and nom="Devaux" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Grégory" and nom="Bourillon" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Cédric" and nom="Bakambu" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="André" and nom="Ayew" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Cheikh" and nom="M'Bengué" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Didier" and nom="Digard" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,2,0 from joueur where prenom="Floyd" and nom="Ayité" on duplicate key update jjs_salaire_classe_id=2;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nathan" and nom="Sinkala" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Oumar" and nom="Sissoko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Youssouf" and nom="Koné" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrien" and nom="Rabiot" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Jussiê" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Stéphane" and nom="Bahoken" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yassine" and nom="Jebbour" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zaniou" and nom="Sana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Danijel" and nom="Aleksic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Brison" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Andreas" and nom="Wolf" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vincent" and nom="Bessat" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bakary" and nom="Koné" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pierre-Yves" and nom="Polomat" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yohan" and nom="Mollo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florent" and nom="Chaigneau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yohan" and nom="Cabaye" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yannick" and nom="Cahuzac" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Paulin" and nom="Puel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alexi" and nom="Peuget" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Christophe" and nom="Bahebeck" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dario" and nom="Cvitanich" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Antoine" and nom="Conte" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pape Abdou" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cheick" and nom="Doukouré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jessy" and nom="Pi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoulaye" and nom="Diallo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Ayew" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Aldo" and nom="Angoula" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="François" and nom="Moubandjé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas" and nom="Saint-Ruf" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mehdi" and nom="Zeffane" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Benoît" and nom="Pedretti" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cheick Fantamady" and nom="Diarra" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoulaye" and nom="Keita" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas" and nom="Penneteau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joris" and nom="Marveaux" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Thierry" and nom="Argelier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Tinhan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nabil" and nom="Fekir" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Loïc" and nom="Poujol" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Valère" and nom="Germain" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nemanja" and nom="Pejcinovic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nampalys" and nom="Mendy" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonas" and nom="Martin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Valerica" and nom="Gaman" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eric" and nom="Tié Bi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Saïd" and nom="Benrahma" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sloan" and nom="Privat" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Emanuel" and nom="Herrera" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mickael" and nom="Malsa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabien" and nom="Dao Castellana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jaroslav" and nom="Plasil" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marco" and nom="Da Silva" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxime" and nom="Barthelme" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lindsay" and nom="Rose" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Stefan" and nom="Popescu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mohamed " and nom="Fofana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mustapha" and nom="Diallo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Flavio" and nom="Roma" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoul Razzagui" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gabriel" and nom="Cichero" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cyril" and nom="Hennion" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mads" and nom="Albaek" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Oberhauser" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Geoffrey" and nom="Kondogbia" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lucas" and nom="Digne" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Théo" and nom="Pellenard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Djibril" and nom="Cissé " on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Matthieu" and nom="Sans" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Enzo" and nom="Crivelli" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Malherbe" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lloyd" and nom="Palun" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ryan" and nom="Mendes" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Fauré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Diego" and nom="Rolan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fahid" and nom="Ben Khalfallah" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Tiécoro" and nom="Keita" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Birama" and nom="Touré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Salim" and nom="Arrache" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ilan" and nom="Boccara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Ligali" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dominik" and nom="Furman" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Djakaridja" and nom="Koné" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mickaël" and nom="Landreau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adama" and nom="Ba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ali" and nom="Ahamada" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Grégoire" and nom="Puel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Brandão" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas" and nom="Benezet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="John " and nom="Boye" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Miguel" and nom="Lopes" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marvin" and nom="Martin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Rozehnal" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Harry" and nom="Novillo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Fabinho" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Réveillère" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Pitroïpa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Itay" and nom="Shechter" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florian" and nom="Raspentino" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Simon" and nom="Pouplin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabien" and nom="Audard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lionel" and nom="Zouma" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Ducourtioux" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Beauverger" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vivian" and nom="Matheus" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Laurent" and nom="Bonnart" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Laurent" and nom="Abergel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas" and nom="Isimat-Mirin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vujadin" and nom="Savic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Marquinhos" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Araújo" and nom="Ilan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrien" and nom="Hunou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Azbe" and nom="Jug" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Franck" and nom="Honorat" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kenny" and nom="Lala" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ricardo" and nom="Faty" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Romain" and nom="Achili" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Bellion" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sigamary" and nom="Diarra" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas" and nom="de Préville" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Claude" and nom="Goncalves" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrien" and nom="Regattin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Thibault" and nom="Giresse" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Petrus" and nom="Boumal" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gaëtan" and nom="Bong" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Olivier" and nom="Veigneau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Daniel" and nom="Akpa-Akpro" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ibrahim" and nom="Sissoko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Johan" and nom="Cavalli" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Johan" and nom="Audel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Stoppila" and nom="Sunzu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Clément" and nom="Badin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Diego" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Christopher" and nom="Glombard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alexy" and nom="Bosetti" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rodrigues" and nom="Diego Rigonato" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ronald" and nom="Zubar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yaya" and nom="Banana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mickaël" and nom="Salamone" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pantxi" and nom="Sirieix" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Simon" and nom="Falette" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mathieu " and nom="Peybernes" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marc" and nom="Vidal" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fernando" and nom="Aristeguieta" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Benjamin" and nom="Lecomte" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yves-Marie" and nom="Kerjean" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bertrand" and nom="Laquait" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Thomas" and nom="Guerbert" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Ménez" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Uwa Echiejile" and nom="Elderson" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Frick" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Delvin" and nom="Ndinga" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Kanté" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Sablé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoulaye" and nom="Doucouré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Grégory" and nom="Cerdan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yannick" and nom="Aguemon" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Corentin" and nom="Tolisso" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ibrahima" and nom="Touré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Landry" and nom="Nguemo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adama" and nom="Niané" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sergio" and nom="Romero" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Amavi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Papa Demba" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gaëtan" and nom="Charbonnier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Benoît" and nom="Trémoulinas" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Moussa" and nom="M'Bow" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yoann" and nom="Gourcuff" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Morgan" and nom="Amalfitano" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Johnny" and nom="Placide" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Benoît" and nom="Cheyrou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Amavi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Victor Hugo" and nom="Montaño" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Steven" and nom="Langil" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Christophe" and nom="Jallet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abraham" and nom="Guié Guié" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Chaker" and nom="Alhadur" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Steeve" and nom="Elana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eliran" and nom="Atar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gadji" and nom="Tallo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Eduardo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Majeed " and nom="Waris" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maka" and nom="Mary" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cedric" and nom="Orengo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrian" and nom="Mutu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ladislas" and nom="Douniama" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Claudiu" and nom="Keserü" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rachid" and nom="Alioui" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémie" and nom="Bréchet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gilles" and nom="Sunu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabrice" and nom="Pancrate" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Armel" and nom="Kana-Biyik" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Oscar" and nom="Trejo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabrice" and nom="Begeorgi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Junior" and nom="Tallo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Baptiste" and nom="Valette" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dusan" and nom="Veskovac" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Hadi" and nom="Sacko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florent" and nom="Ghisolfi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Martial" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Grégory" and nom="Pujol" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Andres Ramiro" and nom="Escobar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Onyekachi" and nom="Apam" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yoann" and nom="Wachter" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gary" and nom="Coulibaly" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alexander" and nom="N'Doumbou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoulaye" and nom="Touré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lucas" and nom="Veronese" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joshua" and nom="Nadeau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Mensah" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Djigla" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vincent" and nom="Pajot" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kian" and nom="Hansen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rachid" and nom="Ghezzal" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Quercia" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jessy" and nom="Moulin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Tùlio" and nom="De Melo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Mayi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Souleymane" and nom="Diawara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Steven" and nom="Moreira" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Souleymane" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vital" and nom="N'Simba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Benjamin" and nom="Mendy" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Max-Alain" and nom="Gradel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vincent" and nom="Di Stefano" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Osei" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Berthomier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Pied" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Tiémoué" and nom="Bakayoko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Souahilo" and nom="Meité" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Mandrea" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pavle" and nom="Ninkov" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Brandon" and nom="Deville" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yuri" and nom="Yakovenko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdou" and nom="Traoré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Diacko" and nom="Fofana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Arnold" and nom="Mvuemba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Luigi" and nom="Bruins" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mamadou" and nom="Samassa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Denis" and nom="Tonucci" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yoric" and nom="Ravet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Arthur" and nom="Delalande" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dimitri" and nom="Foulquier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marcel" and nom="Tisserand" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Idriss" and nom="Saadi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Wesley" and nom="Saïd" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Antoine" and nom="Capinielli" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Emmanuel" and nom="Mayuka" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gianni" and nom="Bruno" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="M'Baye" and nom="Niang" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mana" and nom="Dembélé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joris" and nom="Correa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yassine" and nom="Benzia" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kalilou" and nom="Traoré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Faubert" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gaël" and nom="Danic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rodrigo" and nom="Castro" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Delaplace" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="David" and nom="Sauget" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Chris" and nom="Malonga" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pierrick" and nom="Cros" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Veretout" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Brou Benjamin" and nom="Angoua" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Paul" and nom="Charruau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Johann" and nom="Durand" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Silvio" and nom="Romero" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dimitar" and nom="Berbatov" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Djibril" and nom="Sidibé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Pascal" and nom="Mignot" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Hountondji" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nadjib" and nom="Baouia" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Laurent" and nom="Pionnier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Baïssama" and nom="Sankoh" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mahamane" and nom="Traoré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mouhamadou-Naby" and nom="Sarr" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Vincent" and nom="Nogueira" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nacer" and nom="Barazite" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Anin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ismaël" and nom="Bangoura" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mathieu" and nom="Gorgelin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Baptiste" and nom="Reynet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mohammed" and nom="Rabiu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Aboubacar" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bryan" and nom="Dabo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nordine" and nom="Ait Yahya" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marc" and nom="Planus" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabrice" and nom="Abriel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Thierry" and nom="Doubaï" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bryan" and nom="Constant" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dorian" and nom="Lévêque" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zoumana" and nom="Camara" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marc-Aurèle" and nom="Caillard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Loris" and nom="Nery" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Erwin" and nom="Zelazny" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Amadou" and nom="Soukouna" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rémi" and nom="Mulumba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Atila" and nom="Turan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pierre-Alain" and nom="Frau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Carl" and nom="Medjani" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Remiti" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kamel" and nom="Ghilas" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabien" and nom="Robert" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lucas" and nom="Mendes" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mario" and nom="Lemina" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dusan" and nom="Djuric" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ludovic" and nom="Genest" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Reynald" and nom="Lemaître" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mohamed" and nom="Soly" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jimmy " and nom="Briand" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Hervin" and nom="Ongenda" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yohan" and nom="Eudeline" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joachim" and nom="Eickmayer" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Baptiste" and nom="Pierazzi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alessandro" and nom="Crescenzi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sidy" and nom="Koné" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kamil" and nom="Grosicki" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxime" and nom="Poundjé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bocundji" and nom="Ca" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Faouzi" and nom="Ghoulam" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Divock" and nom="Origi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Facundo" and nom="Bertoglio" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Xavier" and nom="Pentecôte" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxence" and nom="Derrien" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="André" and nom="Biyogo Poko " on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Josuha" and nom="Guilavogui" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Allan" and nom="Saint-Maximin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Brice" and nom="Dja Djédjé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Larry" and nom="Azouni" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kamal" and nom="Issah" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Amine" and nom="Oudhriri" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alassane" and nom="Pléa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abdoulaye" and nom="Sané" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ludovic" and nom="Obraniak" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabrice" and nom="Apruzesse" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Thomas" and nom="Vincensini" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Karim" and nom="Aït Fana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Martins Pereira" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Giannelli" and nom="Imbula" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Edouard" and nom="Butin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Terence" and nom="Makengo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Enzo" and nom="Reale" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Abel" and nom="Aguilar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Saber" and nom="Khalifa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Borja" and nom="Lopez" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Aymen" and nom="Abdennour" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Chahir" and nom="Belghazouani" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dany" and nom="Maury" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Raffidine" and nom="Abdullah" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Brice" and nom="Samba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ismaël Tiémoko" and nom="Diomandé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Grenddy" and nom="Perozo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gennaro" and nom="Bracigliano" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Laurent" and nom="Dos Santos" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Koffi" and nom="Djidji" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zana" and nom="Allée" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Emerson" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ronny" and nom="Rodelin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Genest" and nom="Ludovic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ola" and nom="Toivonen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gilles" and nom="Cioni" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Issa" and nom="Baradji" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Le Tallec" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anders" and nom="Konradsen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Renaud" and nom="Cohade" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="John Jairo" and nom="Ruiz" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Baptiste" and nom="Valette" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lucas" and nom="Ocampos" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Paul" and nom="Baysse" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrien" and nom="Trebel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lamine" and nom="Koné" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gaël" and nom="Vena" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eric" and nom="Bauthéac" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Johan" and nom="Audel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Gomis" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yohan" and nom="Cabate" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dorian" and nom="Klonaridis" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Hengbart" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Gaëtan" and nom="Courtet" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Albert" and nom="Rafetraniaina" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Scribe" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jesper" and nom="Hansen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Hugo" and nom="Guichard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rod" and nom="Fanni" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Romaric" and nom="N'Gouma" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Aadil" and nom="Assana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mouhamadou" and nom="Dabo " on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yacine" and nom="Bammou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kevin" and nom="Olimpa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marco" and nom="Ruben" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fabrice" and nom="Ehret" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joseph" and nom="Barbato" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kurt" and nom="Zouma" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yohann" and nom="Pelé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joris" and nom="Delle" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eloge" and nom="Enza-Yamissi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Morel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fares" and nom="Bahlouli" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eduardo" and nom="Ribeiro dos Santos" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sébastien" and nom="Chabbert" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Barel" and nom="Mouko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sambou" and nom="Yatabaré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mike" and nom="Maignan" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Francis" and nom="Massampu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Razak" and nom="Boukari" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jeffrey" and nom="Assoumin" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Marco" and nom="Ilaimaharitra" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mathieu" and nom="Deplagne" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Guillaume" and nom="Hoarau" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Magno" and nom="Novaes" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Driss" and nom="Trichard" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Franck" and nom="Signorino" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Steeve" and nom="Yago" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rémy" and nom="Vercoutre" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maor" and nom="Melikson" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Neeskens" and nom="Kebano" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julien" and nom="Féret" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kévin " and nom="Theophile Catherine" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Giorgios" and nom="Tzavellas" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dennis" and nom="Oliech" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Steed" and nom="Malbranque" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florentin" and nom="Pogba" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mehdi" and nom="Mostefa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mbaye" and nom="Diagne" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pedrinho" and nom="Miguel Da Silva" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Paul-Georges" and nom="Ntep" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Toifilou" and nom="Maoulida" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zakarya" and nom="Abarouai" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Quentin" and nom="Pereira" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adrien" and nom="Thomasson" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérôme" and nom="Roussillon" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Anthony" and nom="Mounier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Axel" and nom="Ngando" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="José" and nom="Saez" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxime" and nom="Blanc" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jakob" and nom="Poulsen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Aurelian" and nom="Chitu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Cambon" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Saliou" and nom="Ciss" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cheikh" and nom="N'Diaye" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rémi" and nom="Gomis" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Ferri" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Alain" and nom="Traoré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sadio" and nom="Diallo" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Clinton" and nom="N'Jie" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Garry" and nom="Bocaly" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bilal" and nom="Ouali" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jamel" and nom="Saihi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="William" and nom="Le Pogam" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zakarie" and nom="Labidi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Joseph" and nom="Lopy" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Radamel" and nom="Falcao" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rafael" and nom="Dias" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mouez" and nom="Hassen" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Younes" and nom="Kaabouni" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Javier" and nom="Pastore" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Olivier" and nom="Blondel" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Ilias" and nom="Hassani" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Opa" and nom="Nguette" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Pape Amodou" and nom="Sougou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Claude" and nom="Dielna" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Fatih" and nom="Atik" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mamadou" and nom="Sakho" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="" and nom="Fabinho" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jérémy" and nom="Clément" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Teddy" and nom="Mézague" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nélson" and nom="Oliveira" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Guillermo" and nom="Ochoa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Milos" and nom="Krasic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Adama" and nom="Soumaoro" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Leca" and nom="Jean-Louis" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sambou" and nom="Yatabaré" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Féthi" and nom="Harek" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mickael" and nom="Leca" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mathieu" and nom="Coutadeur" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kassim" and nom="Abdallah" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lamine" and nom="Gassama" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bryan" and nom="Pelé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florent" and nom="André" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nicolas " and nom="Douchez" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Nabil" and nom="Dirar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Saad" and nom="Trabelsi" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mohamed" and nom="Sissoko" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mihai" and nom="Roman" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Christophe" and nom="Mandanne" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean" and nom="Deza" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Guy-Roland" and nom="Ndy Assembé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Zacharie" and nom="Boucher" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Neal" and nom="Maupay" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jean-Louis" and nom="Leca" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Kingsley" and nom="Coman" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Djamel" and nom="Bakar" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Diaranké" and nom="Fofana" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Drissa" and nom="Diakité" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Théo" and nom="Defourny" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Yannick" and nom="Ferreira Carrasco" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Georges-Kevin" and nom="N'Koudou" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Dan" and nom="Nistor" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Cédric" and nom="Barbosa" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mehdi" and nom="Fenouche" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Eden" and nom="Ben Basat" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Florian" and nom="Marange" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Julian" and nom="Jeanvier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Matthieu" and nom="Chalmé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Sanjin" and nom="Prcic" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxime" and nom="Baca" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Clarck" and nom="N'Sikulu" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Rudy" and nom="Mater" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Lucas" and nom="Rougeaux" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Bengali Fodé" and nom="Koita" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Paul" and nom="Babiloni" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Axel" and nom="Maraval" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Banel" and nom="Nicolita" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Maxime" and nom="Dupé" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jonathan" and nom="Zebina" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Saliou" and nom="Ciss" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Jordan" and nom="Astier" on duplicate key update jjs_salaire_classe_id=1;

insert into km_join_joueur_salaire(jjs_joueur_id,jjs_salaire_classe_id,jjs_journee_id) select id,1,0 from joueur where prenom="Mody" and nom="Traoré" on duplicate key update jjs_salaire_classe_id=1;