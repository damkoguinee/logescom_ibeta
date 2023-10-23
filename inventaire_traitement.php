<?php require '_header.php';

    if (isset($_GET['ajuster'])) {
        $idprod_inv = $_GET['idprod_ajust'];
        $prodinv = $DB->query("SELECT *FROM inventaire WHERE num_inv = '{$_SESSION['op_inv']}' AND id_prod_inv = '{$idprod_inv}' ");
        
        foreach ($prodinv as $key => $valueinv) {
            $nomtab_ajust=$panier->nomStock($valueinv->stock_inv)[1];

            $verifstock = $DB->querys("SELECT *FROM `".$nomtab_ajust."` WHERE idprod = ? ", array($valueinv->id_prod_inv));

            if ($verifstock['quantite'] != $valueinv->qtite_inv) {
            
                if ($valueinv->balance_inv>0) {
                $entree = "entree";
                }else{
                $entree = "sortie";
                }

                $nomtab_ajust=$panier->nomStock($valueinv->stock_inv)[1];
                $DB->insert("UPDATE `".$nomtab_ajust."` SET quantite= ? WHERE idprod = ?", array($valueinv->qtite_inv, $valueinv->id_prod_inv));

                $DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, coment, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($valueinv->id_prod_inv, "ajustement stock", "", $_SESSION['op_inv'], $entree, $valueinv->balance_inv, $valueinv->stock_inv, "inv ".$_SESSION['op_inv'], $_SESSION['idpseudo']));
                $etat_inv="ok";
                $DB->insert("UPDATE inventaire SET etat_inv = '{$etat_inv}' WHERE num_inv = '{$_SESSION['op_inv']}' AND id_prod_inv = '{$valueinv->id_prod_inv}' ");

            }
            
        }

        header('Location: inventaire.php');


    }

    if (isset($_GET['toutregler'])) {
        $etat_inv="ok";
        $prodinv = $DB->query("SELECT *FROM inventaire WHERE num_inv = '{$_SESSION['op_inv']}' AND etat_inv != '{$etat_inv}' ");
        
        foreach ($prodinv as $key => $valueinv) {
            $nomtab_ajust=$panier->nomStock($valueinv->stock_inv)[1];

            $verifstock = $DB->querys("SELECT *FROM `".$nomtab_ajust."` WHERE idprod = ? ", array($valueinv->id_prod_inv));

            if ($verifstock['quantite'] != $valueinv->qtite_inv) {
            
                if ($valueinv->balance_inv>0) {
                $entree = "entree";
                }else{
                $entree = "sortie";
                }

                $nomtab_ajust=$panier->nomStock($valueinv->stock_inv)[1];
                $DB->insert("UPDATE `".$nomtab_ajust."` SET quantite= ? WHERE idprod = ?", array($valueinv->qtite_inv, $valueinv->id_prod_inv));

                $DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, coment, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($valueinv->id_prod_inv, "ajustement stock", "", $_SESSION['op_inv'], $entree, $valueinv->balance_inv, $valueinv->stock_inv, "inv ".$_SESSION['op_inv'], $_SESSION['idpseudo']));
                
                $DB->insert("UPDATE inventaire SET etat_inv = '{$etat_inv}' WHERE num_inv = '{$_SESSION['op_inv']}' AND id_prod_inv = '{$valueinv->id_prod_inv}' ");

            }
            
        }

        header('Location: inventaire.php');


    }

    if (isset($_GET['valid_ano'])) {
        $id_prod_ano = $_GET['id_prod_ano'];
        $qtite_ano = $_GET['qtite_ano'];
        $lieu_ano = $_GET['lieu_ano'];
            
        if ($qtite_ano>0) {
            $entree = "entree";
        }else{
            $entree = "sortie";
        }

        $nomtab_ajust=$panier->nomStock($lieu_ano)[1];

        $prodqtite = $DB->querys("SELECT *FROM `".$nomtab_ajust."` WHERE idprod = '{$id_prod_ano}'  ");

        $qtite_stock=$prodqtite['quantite'];
        $qtite = $prodqtite['quantite'] +  $qtite_ano ;


        $DB->insert("UPDATE `".$nomtab_ajust."` SET quantite= ? WHERE idprod = ?", array($qtite, $id_prod_ano));

        $DB->insert("INSERT INTO inventaire (id_prod_inv, qtite_init, qtite_inv, balance_inv, stock_inv, idpers_inv, etat_inv, coment_inv) VALUES (?, ?,  ?, ?, ?, ?, ?, ?)", array($id_prod_ano,  $qtite_stock, $qtite,  $qtite_ano, $lieu_ano, $_SESSION['idpseudo'], "ok", "reglage direct anomalie"));

        $DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, coment, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id_prod_ano, "anomalie stock", "", "anomalie", $entree, $qtite_ano, $lieu_ano, "anomalie ", $_SESSION['idpseudo']));

        unset($_SESSION['recherchgen']);

        header('Location: anomalie_stock.php');

    }
    
      


