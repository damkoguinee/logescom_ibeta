<?php
require '_header.php';
$pseudo=$_SESSION['idpseudo'];
$prodvente = $DB->querys("SELECT *FROM validvente where pseudop='{$pseudo}' ");

$lieuventecaisse=$panier->lieuVenteCaisse($_POST['compte'])[0];
$initial=$panier->adresseinit($lieuventecaisse)[0];   

$DB->insert(" CREATE TABLE IF NOT EXISTS `ventecommission` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`numc` varchar(50) NOT NULL,
`numcmd` varchar(50) NOT NULL,
`montant` double NULL,
`idclient` int(11) NOT NULL,
`idpers` int(11) NOT NULL,
`dateop` datetime,
PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ");

if (is_null($_SESSION['clientvip']) and is_null($_SESSION['clientvipcash'])) {

	header("Location: index.php");
		
}else{

	if (isset($_POST['proformat'])) {

		$_SESSION['proformat']='proformat';

		$products= $DB->query("SELECT id_produit as id, validpaie.quantite as qtite, pvente FROM validpaie where pseudov='{$_SESSION['idpseudo']}' order by(validpaie.id)");

		$date = date('y') . '0000';

		$maximum = $DB->querys('SELECT max(id) AS max_id FROM proformat');

		$numero_commande = $date + $maximum['max_id'] + 1;

		$init=$initial.'p';

		$_SESSION['num_cmdp']=$init.$numero_commande;

		foreach($products as $product){
			$id=$product->id;			
			$price_vente=$product->pvente;
			$qtite=$product->qtite;

			if (!empty($_SESSION['clientvipcash'])) {

				$DB->insert('INSERT INTO proformat (id_produit, num_pro, prix_vente, quantity, vendeur, id_client, nomclient, lieuvente, datepro) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($id, $init.$numero_commande, $price_vente, $qtite, $_SESSION['idpseudo'], 0, $_SESSION['clientvipcash'], $lieuventecaisse));
			}else{

				$DB->insert('INSERT INTO proformat (id_produit, num_pro, prix_vente, quantity, vendeur, id_client, lieuvente, datepro) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $init.$numero_commande, $price_vente, $qtite, $_SESSION['idpseudo'], $_SESSION['clientvip'], $lieuventecaisse));

			}

			$_SESSION['panier'] = array();
			$_SESSION['panieru'] = array();
			$_SESSION['error']=array();
			$_SESSION["seleclient"]=array();
			$_SESSION["montant_paye"]=array();
			$_SESSION['remise']=array();
			$_SESSION['product']=array();
			//unset($_SESSION['clientvip']);
			//unset($_SESSION['clientvipcash']);

			//$DB->delete('DELETE FROM validpaie');
			//$DB->delete('DELETE FROM validvente');

			header("Location: recherche.php");
		}

		unset($_SESSION['clientvip']);
		unset($_SESSION['clientvipcash']);
					

	}elseif($prodvente['virement']!=0 and empty($_SESSION['banque'])){

		header("Location: index.php");

		$alertesvirement='Selectionnez le compte pour le versement banque';

		$_SESSION['alertesvirement']=$alertesvirement;

	}elseif($prodvente['cheque']!=0 and empty($prodvente['numcheque'])){
		header("Location: index.php");

		$alertescheque='entrer le numéro du chèque';

		$_SESSION['alerteschequep']=$alertescheque;

	}else{

		$date = date('y') . '0000';

		$maximum = $DB->querys('SELECT max(id) AS max_id FROM numerocommande ');

		$numero_commande = $date + $maximum['max_id'] + 1;

		$init=$initial;

		$_SESSION['num_cmdp']=$init.$numero_commande;

		$DB->insert('INSERT INTO numerocommande (numero) VALUES(?)', array($init.$numero_commande));

		if (empty($_POST['fraisup'])) {
			$fraisup=0;
		}else{
			$fraisup=$panier->espace($_POST['fraisup']);
		}

		$reste=$panier->espace($_POST['reste'])+$fraisup;
		if ($reste!=0) {
			$origine="vente credit";
		}else{
			$origine="vente cash";
		}

		

		$pseudo=$_SESSION['idpseudo'];

		$numclient=$_SESSION['clientvip'];
		if (empty($_POST['datev'])) {
			$datev=date("Y-m-d h:i");
		}else{
			$datev=$panier->h($_POST['datev']);
		}


		unset($_SESSION['$quantite_rest']); //pour vider en cas de commande > au stock    

		if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

			$etat='totalite';
			$total=$panier->totalcom()+$fraisup;

		}else{

			$etat='credit';
			$total=$panier->totalcom()+$fraisup;
		}

		$products= $DB->query("SELECT id_produit as id, productslist.designation as designation, validpaie.quantite as qtite, pvente, Marque, nbrevente, type FROM validpaie inner join productslist on productslist.id=id_produit where pseudov='{$pseudo}' order by(validpaie.id)");

		$cumbenef=0;

		foreach($products as $product){		

			$name= $product->Marque;
			$marque=$product->Marque;
			$designation=$product->designation;
			$id=$product->id;			
			$price_vente=$product->pvente;
			
			$quantity=$product->qtite;
			$numcmd=$init.$numero_commande;

			$idstock=$panier->h($_POST['stockd']);

			if (!empty($_POST['stockd'])) {

				$nomtab=$panier->nomStock($_POST['stockd'])[1];
			}else{

				$nomtab=$panier->nomStock(1)[1];

			}

			$idstock=$panier->nomStock($_POST['stockd'])[2];

			$prodprixrevient=$DB->querys("SELECT prix_revient as previent  FROM `".$nomtab."` WHERE idprod='{$product->id}'");
			
			$price_revient=$prodprixrevient['previent'];
			
			if (!empty($_POST['datev'])) {
				$datep=$panier->h($_POST['datev']);
			}else{
				$datep=date('Y-m-d');
			}

			$prodpromo= $DB->querys("SELECT * FROM promotion where idprod='{$id}' and dated<='{$datep}' and datef>='{$datep}' ");

			if (!empty($prodpromo)) {

				$achatmin=$prodpromo['achatmin'];
				$achatmax=$prodpromo['achatmax'];
				$qtitepromo=$prodpromo['qtite'];

				if ($achatmin<=$quantity and $achatmax>$quantity) {
					
					$qtiteplus=$quantity+$qtitepromo;

				}else{
					$qtiteplus=$quantity;
				}
			}else{
				$qtiteplus=$quantity;

				$achatmin=0;
				$achatmax=0;
			}
			
			$qtiteliv=$qtiteplus;

			$type=$product->type;

			$recupliaison=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'en_gros'));

			$liaison=$recupliaison['id'];

			$recupliaisonp=$DB->querys("SELECT id  FROM productslist WHERE Marque=? and type=? ", array($marque, 'paquet'));

			$liaisonp=$recupliaisonp['id'];

			$qtiteinit=$DB->querys("SELECT quantite  FROM `".$nomtab."` WHERE idprod=? ", array($id));

			$qtiterest=$qtiteinit['quantite']-$qtiteliv;

			$quantite=$qtiterest;

			$DB->insert('INSERT INTO commande (id_produit, prix_vente, prix_revient, quantity, num_cmd, id_client) VALUES(?, ?, ?, ?, ?, ?)', array($id, $price_vente, $price_revient, $quantity, $init.$numero_commande, $numclient));

			// Promotion 

			if ($achatmin<=$quantity and $achatmax>$quantity) {

				$DB->insert('INSERT INTO commande (id_produit, prix_vente, prix_revient, quantity, num_cmd, id_client) VALUES(?, ?, ?, ?, ?, ?)', array($id, 0, $price_revient, $qtitepromo, $init.$numero_commande, $numclient));

			}

			//**********************vente avec livraison directe***********************	
			var_dump($_POST['stockd']);
			if (!empty($_POST['stockd'])) {

				//****************Gestion de detail***************************

				if ($type=="en_gros") {      

					$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?",array($quantite, $id));

				}elseif($type=="paquet"){

					if ($quantite>0) {

						$quantite_det=$quantite;

						$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "paquet"));

					}else{

						$products=$DB->querys("SELECT quantite, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

						$quantite_gros=$products["quantite"]-1;

						$quantite_det=$products["qtiteintp"]+$quantite;

						if ($products["quantite"]>0) {

						$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros		         

						$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

						$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($liaison, $origine, $numclient, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

						$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $origine, $numclient, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintp"], $idstock));


						}else{

						$quantite_detail0=$quantite;
						$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
						}
					}

				}elseif($type=="detail"){

					if ($quantite>0) {

						$quantite_det=$quantite;

						$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ? AND type=?", array($quantite_det, $id, "detail"));

					}else{

						$products=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaison)); //Recuperation du  produit en gros

						$productsp=$DB->querys("SELECT quantite, qtiteintd, qtiteintp FROM `".$nomtab."` WHERE idprod=?", array($liaisonp)); //Recuperation du  produit en gros

						$quantite_gros=$products["quantite"]-1;

						$quantite_grosp=$productsp["quantite"]-1;

						$quantite_det=$products["qtiteintd"]+$quantite;

						$quantite_paq=$products["qtiteintp"]+$quantite;

						if ($productsp["quantite"]>0) {

							if ($products["quantite"]>0) {

								$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

								$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail


								$DB->insert('INSERT INTO stockmouv (idstock,origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($liaison,$origine,$numclient, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

								$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $origine,$numclient,'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

							}else{

								$quantite_detail0=$quantite;
								$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
							}

						}else{// partie à affiner

						if ($products["quantite"]>0) {

							$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_gros, $liaison)); // mettre a jour en gros

							$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_det, $id));// mettre a jour le detail

							$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($liaison,$origine, $numclient, 'ouvc'.$init.$numero_commande, 'sortie', -1, $idstock)); 

							$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id,$origine, $numclient, 'ouvc'.$init.$numero_commande, 'entree', $products["qtiteintd"], $idstock));

						}else{

							$quantite_detail0=$quantite;
							$DB->insert("UPDATE `".$nomtab."` SET quantite = ? WHERE idprod = ?", array($quantite_detail0, $id)); // mettre a jour le detail
						}

						}
					}
				}

				//****************Fin Gestion detail************************** 

				//$qtiteinitcmd=$DB->querys("SELECT qtiteliv  FROM commande WHERE id_produit=? and num_cmd=? ", array($id, $numcmd));

				$productidc=$DB->querys("SELECT id as idc  FROM commande WHERE id_produit=? and num_cmd=? ", array($id, $numcmd));

				$idc=$productidc['idc'];

				$qtitecmd=$qtiteliv;
				$DB->insert("UPDATE commande SET qtiteliv=?, etatlivcmd=? WHERE id_produit=? and num_cmd=? ", array($qtitecmd, 'livre', $id, $init.$numero_commande));

				$DB->insert('INSERT INTO stockmouv (idstock, origine, client, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, $origine, $numclient, 'liv'.$init.$numero_commande, 'sortie', -$qtiteliv, $idstock));  

				$DB->insert("INSERT INTO livraison (id_produitliv, idcmd, quantiteliv , numcmdliv, id_clientliv, livreur, idstockliv, dateliv) VALUES(?, ?, ?, ?, ?, ?, ?, now())", array($id, $idc, $qtiteliv, $init.$numero_commande, $numclient, $_SESSION['idpseudo'], $idstock));


			}

			//**********************fin vente livraiosn*******************************				
		}



		//************************ GESTION TABLE PAYEMENT PAYEMENT TOTALITE***************

		$prodvente = $DB->querys("SELECT *FROM validvente where pseudop='{$pseudo}' ");
		if (($panier->espace($_POST['reste'])+$fraisup)<=0) {
			$surplus=$panier->espace($_POST['reste']);
			$reste=$_POST['reste']+$fraisup;
		}else{
			$surplus=0;
			$reste=$_POST['reste']+$fraisup;
		}
		$montantpaye=$panier->totalpaye()+$surplus;
		$reliquat=-$panier->espace($_POST['reste']);
		$montantreliquat=$panier->totalpaye();
		$virement=$prodvente['virement'];
		$cheque=$prodvente['cheque'];
		$montantgnf=$prodvente['montantpgnf'];
		$remise=$prodvente['remise'];
		if (empty($remise)) {
			$remise=0;
		}
		
		$gnf=$prodvente['montantpgnf']+$prodvente['virement']+$prodvente['cheque'];
		$eu=$prodvente['montantpeu'];
		$us=$prodvente['montantpus'];
		$cfa=$prodvente['montantpcfa'];
		$caisse=$panier->h($_POST['compte']);

		$numeropaie=$prodvente['numcheque'];
		$banqcheque=$prodvente['banqcheque'];
		$datealerte=$_POST['dateal'];
		$numeropaievir='';
		if (empty($_SESSION['clientvipcash'])) {
			$_SESSION['clientvipcash']='';
		}
		if (($panier->espace($_POST['reste'])+$fraisup)<=0) {

			if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

				$insert->insertPayement($init.$numero_commande, $total, $fraisup, $montantreliquat, $remise, $reste, $etat,'nonlivre', $pseudo, $numclient, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev,$datealerte);
				$insert->insertDecaissement('reli'.$init.$numero_commande, $reliquat, 'gnf', 'espèces','','',$caisse,'reliquat fact '.$init.$numero_commande,$numclient,$lieuventecaisse,$_SESSION['idpseudo'],$datev);
				$insert->insertBanque($numclient,$caisse,'vente'.$init.$numero_commande,'vente',$origine,'reliquat n°'.$init.$numero_commande,-$reliquat,'gnf','especes',$numeropaie,$banqcheque,$lieuventecaisse,$datev);

			}else{
				$insert->insertPayement($init.$numero_commande, $total, $fraisup, $montantpaye, $remise, $reste, $etat,'nonlivre', $pseudo, $numclient, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev,$datealerte);
				
			}
		}else{
			$insert->insertPayement($init.$numero_commande, $total, $fraisup,$montantpaye, $remise, $reste, $etat,'nonlivre', $pseudo, $numclient, $_SESSION['clientvipcash'], $caisse, $lieuventecaisse, $datev,$datealerte);
		}
		

		//$maximum = $DB->querys('SELECT max(num_cmd) AS num_cmd FROM payement ');

		$reste=$panier->espace($_POST['reste'])+$fraisup;

		if ($reste<=0) {
			$insert->insertBulletin($numclient, 'reste à payer',$init.$numero_commande,0,'gnf',$caisse,$lieuventecaisse, $datev);			
		}else{
			$insert->insertBulletin($numclient, 'reste à payer',$init.$numero_commande,-$reste,'gnf',$caisse,$lieuventecaisse, $datev);				

		}

		$cumbenef=0;
			
		// $prodtop=$DB->querys('SELECT id_client, montant, benefice FROM topclient WHERE id_client=?', array($numclient));

		// $newbenef=$prodtop['benefice']+$cumbenef;
		// $newmontant=$prodtop['montant']+$total;

		// if (empty($prodtop)) {

		// 	$DB->insert('INSERT INTO topclient (id_client, montant, benefice, pseudo) VALUES(?, ?, ?, ?)', array($numclient, $total, $cumbenef, $_SESSION["idpseudo"]));
		// }else{

		// 	$DB->insert('UPDATE topclient SET montant = ?, benefice=? WHERE id_client = ?', array($newmontant, $newbenef, $numclient));
		// }
		if ($reste!=0) {
			$origine="vente credit";
		}else{
			$origine="vente cash";
		}
		if ((($panier->espace($_POST['reste'])+$fraisup))<0) {// Pour separer le surplus d'especes et autres modes de vente

			if (!empty($cheque) or !empty($eu) or !empty($us) or !empty($cfa)) {

				if (!empty($prodvente['virement'])) {
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$virement,'virement','especes',$numeropaievir,'',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$montantgnf,'gnf','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$eu,'eu','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$us,'us','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cfa,'cfa','especes','','',$lieuventecaisse,$datev);

				}else{
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$montantgnf,'gnf','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$eu,'eu','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$us,'us','especes','','',$lieuventecaisse,$datev);
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cfa,'cfa','especes','','',$lieuventecaisse,$datev);
					
					// $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantgnf), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					// $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($eu), 'eu', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					// $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($us), 'us', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

					// $DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($cfa), 'cfa', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));
				}

				if (!empty($prodvente['cheque'])) {
					$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cheque,'cheque','especes',$numeropaie,$banqcheque,$lieuventecaisse,$datev);

					//$DB->insert('INSERT INTO banque (id_banque, typeent, montant, libelles, numero, typep, numeropaie, banqcheque, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', $cheque, 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, 'cheque', $numeropaie, $banqcheque, $lieuventecaisse, $datev));
				}
				//*********************************fin banque****************************

				

				if (!empty($prodvente['virement'])) {
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$virement,'virement',1,'','','',$datev);

					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
				}

				if (!empty($prodvente['cheque'])) {
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$cheque,'cheque',1,$numeropaie, $banqcheque,'non traite',$datev);

					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
				}

				if (!empty($prodvente['montantpgnf'])) {
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$montantgnf,'gnf',1,'', '','',$datev);

					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
				}

				if (!empty($prodvente['montantpeu'])) {

					$taux=$panier->devise('euro');
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$eu,'eu',$taux,'', '','',$datev);
					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
				}

				if (!empty($prodvente['montantpus'])) {

					$taux=$panier->devise('us');
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$us,'us',$taux,'', '','',$datev);
					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
				}

				if (!empty($prodvente['montantpcfa'])) {

					$taux=$panier->devise('cfa');
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$cfa,'cfa',$taux,'', '','',$datev);
					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
				}
				//********************************fin modep*****************************

			}else{// Pour annuler le surplus en cas de paiement par especes	
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$montantpaye,'gnf','especes','','',$lieuventecaisse,$datev);
					
				//$DB->insert('INSERT INTO banque (id_banque, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compte'], 'vente', ($montantpaye), 'gnf', 'vente n°'.$init.$numero_commande, 'vente'.$init.$numero_commande, $lieuventecaisse, $datev));

				//*********************************fin banque****************************
				if (!empty($prodvente['montantpgnf'])) {
					$insert->insertModep($init.$numero_commande,$caisse,$numclient,$montantpaye,'gnf',1,'', '','',$datev);
					//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantpaye, 'gnf', 1, $datev, $caisse));
				}
				//********************************fin modep*****************************
			}

		}else{

			if (!empty($prodvente['virement'])) {
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$virement,'virement','especes',$numeropaievir,'',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$montantgnf,'gnf','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$eu,'eu','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$us,'us','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cfa,'cfa','especes','','',$lieuventecaisse,$datev);

			}else{
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$montantgnf,'gnf','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$eu,'eu','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$us,'us','especes','','',$lieuventecaisse,$datev);
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cfa,'cfa','especes','','',$lieuventecaisse,$datev);
			}

			if (!empty($prodvente['cheque'])) {
				$insert->insertBanque($numclient,$_POST['compte'],'vente'.$init.$numero_commande,'vente',$origine,'vente n°'.$init.$numero_commande,$cheque,'cheque','especes',$numeropaie,$banqcheque,$lieuventecaisse,$datev);
			}

			if (!empty($prodvente['virement'])) {
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$virement,'virement',1,'','','',$datev);

				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $virement, 'virement', 1, $datev, $caisse));
			}

			if (!empty($prodvente['cheque'])) {
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$cheque,'cheque',1,$numeropaie, $banqcheque,'non traite',$datev);

				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, numerocheque, banquecheque, datefact, caisse) VALUES(?, ?, ?,  ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cheque, 'cheque', 1, $numeropaie, $banqcheque, $datev, $caisse));
			}

			if (!empty($prodvente['montantpgnf'])) {
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$montantgnf,'gnf',1,'', '','',$datev);

				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $montantgnf, 'gnf', 1, $datev, $caisse));
			}

			if (!empty($prodvente['montantpeu'])) {

				$taux=$panier->devise('euro');
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$eu,'eu',$taux,'', '','',$datev);
				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $eu, 'eu', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpus'])) {

				$taux=$panier->devise('us');
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$us,'us',$taux,'', '','',$datev);
				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $us, 'us', $taux, $datev, $caisse));
			}

			if (!empty($prodvente['montantpcfa'])) {

				$taux=$panier->devise('cfa');
				$insert->insertModep($init.$numero_commande,$caisse,$numclient,$cfa,'cfa',$taux,'', '','',$datev);
				//$DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, datefact, caisse) VALUES(?, ?, ?, ?, ?, ?, ?)', array($init.$numero_commande, $numclient, $cfa, 'cfa', $taux, $datev, $caisse));
			}
			
		}

		$numeroliv=$init.$numero_commande;

		$verifliv= $DB->querys("SELECT *FROM livraison where numcmdliv='{$numeroliv}' ");

		if (!empty($verifliv)) {
			$DB->insert("UPDATE payement SET etatliv=? WHERE num_cmd=? ", array('livre', $init.$numero_commande));
		}

		if (!empty($_POST['clientCom'])) {
			$montantCom=$panier->h($panier->espace($_POST['montantCom']));
			$clientCom=$panier->h($_POST['clientCom']);
			$prodc=$DB->querys("SELECT max(id) as id FROM ventecommission");
			$numcount=$prodc['id']+1;
			$numc="commission".$numcount;
			$insert->insertVenteCommission($numc, $init.$numero_commande,$montantCom,$clientCom, $_SESSION['idpseudo'], $datev);		
			$insert->insertBulletin($clientCom, $numc,$init.$numero_commande,$montantCom,'gnf',$caisse,$lieuventecaisse, $datev);			
		}

		

		require 'fraisup.php';

		//require 'transfert.php'; //pour effectuer le transfert stock vers boutiques

		$_SESSION['panier'] = array();
		$_SESSION['panieru'] = array();
		$_SESSION['error']=array();
		$_SESSION['clientvip']=array();
		$_SESSION["montant_paye"]=array();
		$_SESSION['remise']=array();
		$_SESSION['product']=array();
		unset($_SESSION['banque']);
		unset($_SESSION['proformat']);
		unset($_SESSION['alertesvirement']);
		unset($_SESSION['alerteschequep']);
		unset($_SESSION['clientvipcash']);
		unset($_SESSION['clientvip']);
		unset($_SESSION['clientCom']);

		$DB->delete("DELETE FROM validpaie where pseudov='{$pseudo}' ");
		$DB->delete("DELETE FROM validvente where pseudop='{$pseudo}' ");

		// if (!empty($panier->nomClientad($numclient)[3])) {

		// 	ini_set( 'display_errors', 1);
		// 	error_reporting( E_ALL );
		// 	$from = "logescom@bbsguinee.com";
		// 	$to =strtolower($panier->nomClientad($numclient)[3]);
		// 	$subject = "votre facture numéro ".$init.$numero_commande;
		// 	$message = "Cher Client, Merci de trouver votre facture en cliquant sur ce lien http://bbsguinee.com/logescom/accueilclient.php?lienclient=".$numclient;
		// 	$headers = "From:" . $from;
		// 	mail($to,$subject,$message, $headers);
		// }

		header("Location: facturations.php?payement");

		unset($_POST);
		unset($_GET);

		//header("Location: ticket_pdf.php");
	}
}?>

</body>
</html>

			

	


		
