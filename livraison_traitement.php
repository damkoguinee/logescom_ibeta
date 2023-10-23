<?php require_once("_header.php");


if (isset($_GET['id'])) {
    echo "fff";

    // $nomtab=$panier->nomStock($_GET['lstock'])[1];

    // $idstock=$panier->nomStock($_GET['lstock'])[2];
    
    // $qtiteliv=$panier->h($_GET['qtiteliv']);

    // $id=$panier->h($_GET['id']);

    // $idcmd=$panier->h($_GET['idc']);

    // $numcmd=$panier->h($_GET['numcmd']);

    // $type=$panier->h($_GET['type']);

    // $marque=$panier->h($_GET['marque']);

    // $recupliaison=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'en_gros'));

    // $liaison=$recupliaison['id'];

    // $recupliaisonp=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'paquet'));

    // $liaisonp=$recupliaisonp['id'];

    // $qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));

    // $qtiterest=$qtiteinit['quantite']-$qtiteliv;

    // $quantite=$qtiterest;

    // $cmdverif=$DB->querys("SELECT qtiteliv, quantity  FROM commande WHERE id_produit=? and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

    // if (($cmdverif['quantity']-$cmdverif['qtiteliv'])<$qtiteliv) {?>

    //   <div class="alertes">La quantité à livrer doit être <= <?=($cmdverif['quantity']-$cmdverif['qtiteliv']);?></div><?php
      

    // }else{

    //   //****************Gestion de detail***************************

    //   if ($type=="en_gros") {      

    //     $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?",array($quantite, $id));

    //   }elseif($type=="paquet"){

    //     if ($quantite>0) {

    //       $quantite_det=$quantite;

    //       $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "paquet"));

    //     }else{

    //       $products=$DB->querys("SELECT quantite, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

    //       $quantite_gros=$products["quantite"]-1;

    //       $quantite_det=$products["qtiteintp"]+$quantite;

    //       if ($products["quantite"]>0) {

    //         $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

    //         $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

    //         $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

    //         $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintp"], $idstock));

    //       }else{

    //         $quantite_detail0=$quantite;
    //         $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
    //       }
    //     }

    //   }elseif($type=="detail"){

    //     if ($quantite>0) {

    //       $quantite_det=$quantite;

    //       $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "detail"));

    //     }else{

    //       $products=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

    //       $productsp=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaisonp)); //Recuperation du  produit en gros

    //       $quantite_gros=$products["quantite"]-1;

    //       $quantite_det=$products["qtiteintd"]+$quantite;

    //       $quantite_paq=$products["qtiteintp"]+$quantite;

    //       if ($productsp["quantite"]>0) {

    //         if ($products["quantite"]>0) {

    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

    //           $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

    //             $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

    //         }else{

    //           $quantite_detail0=$quantite;
    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
    //         }

    //       }else{// partie à affiner

    //         if ($products["quantite"]>0) {

    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

    //           $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($liaison, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

    //             $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

    //         }else{

    //           $quantite_detail0=$quantite;
    //           $DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
    //         }

    //       }
    //     }
    //   }

    //   //****************Fin Gestion detail**************************           

    //   $qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

    //   $qtitecmd=$qtiteinitcmd['qtiteliv']+$qtiteliv;

    //   $DB->insert("UPDATE commande SET qtiteliv=? WHERE id_produit=?  and id=? and num_cmd=? ", array($qtitecmd, $id, $idcmd, $numcmd));

    //   $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'liv'.$numcmd, 'sortie', -$qtiteliv, $idstock));

    //   $qtiteinitcmd=$DB->querys("SELECT (quantity-qtiteliv) as reste  FROM commande WHERE id_produit=?  and id=? and num_cmd=? ", array($id, $idcmd, $numcmd));

    //   if ($qtiteinitcmd['reste']==0) {

    //     $DB->insert("UPDATE commande SET etatlivcmd=? WHERE id_produit=?  and id=? and num_cmd=? ", array('livre', $id, $idcmd, $numcmd));

    //   }else{

    //     $DB->insert("UPDATE commande SET etatlivcmd=? WHERE id_produit=?  and id=? and num_cmd=? ", array('encoursliv', $id, $idcmd, $numcmd));

    //   }

    //   $livreste=$DB->querys("SELECT etatlivcmd FROM commande WHERE num_cmd=:num and etatlivcmd!=:etat ", array('num'=>$numcmd, 'etat'=>'livre'));

    //   if (empty($livreste)) {

    //     $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('livre', $numcmd));
    //   }else{

    //     $DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('encoursliv', $numcmd));

    //   }

    //   $DB->insert("INSERT INTO livraison (id_produitliv, idcmd, quantiteliv , numcmdliv, id_clientliv, livreur, idstockliv, dateliv) VALUES(?, ?, ?, ?, ?, ?, ?, now())", array($id, $idcmd, $qtiteliv, $numcmd, $_SESSION['reclient'], $_SESSION['idpseudo'], $idstock));
    // }

}