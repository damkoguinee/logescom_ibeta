<?php require 'header.php';

//$prod = $DB->query('SELECT *FROM produits');

// foreach ($prod as $key => $value) {
//     $id=$value->id;
//     $pr=$value->pu;
//     $pv=$value->pv;
//     //var_dump($pr, $pv);
//     $DB->insert('UPDATE produits SET pu=?, pv=? WHERE id = ?', array($pr, $pv, $id));


// 	// $pa=$value->prix_achat;
// 	// $pr=$value->prix_revient;

// 	// $id=$value->idprod;

// 	// $zero=0;

// 	// $prodverif = $DB->querys("SELECT * FROM commande where id_produit='{$id}' and prix_revient='{$zero}' ");

// 	// if ($prodverif['prix_revient']==0 or empty($prodverif['prix_revient']) or ($prodverif['prix_revient']>$prodverif['prix_vente'])) {

// 	// 	$DB->insert('UPDATE commande SET prix_revient=? WHERE id_produit = ?', array($pr, $id));
// 	// }
// }

// foreach ($prod as $key => $value) {
    
//     $stock=$DB->querys("SELECT *FROM productslist inner join stock1 on productslist.id=idprod where Marque='{$value->reference}' ");
//     $qtite=$value->qtite;
//     $pu=$value->pu;
//     $pv=$value->pv;
//     $id=$stock['idprod'];

//     //var_dump($qtite, $pu, $pv, $id);

//     $DB->insert('UPDATE stock1 SET quantite=?, prix_revient=?, prix_vente=? WHERE idprod = ?', array($qtite, $pu, $pv, $id));

//     $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, coment)VALUES(?, ?, ?, ?, ?, ?)', array($id, "recepf", "entree", $qtite, 1, "sans facture"));
// }

// $prod = $DB->query('SELECT *FROM clientinitial');

// foreach ($prod as $key => $value) {
//     $id1=$value->id;
//     $solde=-1*INTVAL($value->solde);
//     $client=$value->CLIENT;
//     $tel=$value->TELEPHONE;
//     //var_dump($solde);
//    // $DB->insert('UPDATE clientinitial SET solde=? WHERE id = ?', array($solde, $id));

//    $DB->insert('INSERT INTO client (nom_client, telephone, mail,  adresse, positionc, typeclient) VALUES(?, ?, ?, ?, ?, ?)', array($client, $tel, "", "", 1, "client"));

//    $max=$DB->querys("SELECT max(id) as id from client");
//    $id=$max['id'];

//    $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente) VALUES(?, ?, ?, ?, ?, ?, ?)', array($id, $solde, 'report solde', 'init', "gnf", 1, 1));
	
// }


