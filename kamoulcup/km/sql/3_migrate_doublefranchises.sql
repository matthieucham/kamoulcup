update utilisateur inner join km_franchise on fra_nom like concat(utilisateur.nom,'%')  inner join km_inscription on ins_franchise_id=fra_id set ins_franchise_id=franchise_id where utilisateur.nom in ('Axl','Goupil','Kenneth','Madness','Charlie Brown','beLIEve','ABAD')

-- Penser à supprimer les utilisateur ...2 ensuite.