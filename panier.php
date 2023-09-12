<?php

if (isset($_GET['delPanier'])) {

	$DB->delete('DELETE FROM validpaie WHERE id = ? and pseudov=?', array($_GET['delPanier'], $_SESSION['idpseudo']));

	$DB->delete('DELETE FROM validvente where pseudop=?', array($_SESSION['idpseudo']));

	unset($_SESSION['alertesvirement']);
	unset($_SESSION['banque']);
}

if (isset($_POST['devise'])) {

	$prodverifdevise = $DB->querys("SELECT montantdevise FROM devise where idvente='{$_SESSION['lieuvente']}' ");

	if (empty($prodverifdevise)) {

		$DB->insert("INSERT INTO devise (nomdevise, montantdevise, idvente) VALUES(?, ?, ?)", array($_POST['nom'], $_POST['devise'], $_SESSION['lieuvente']));
	}else{

		$DB->insert('UPDATE devise SET montantdevise=? where nomdevise=? and idvente=?', array($_POST['devise'], $_POST['nom'], $_SESSION['lieuvente']));

	}

}

if (isset($_GET['desig'])) {
	if ($panier->adresse()!='KOULA MATCO SARL') {
		$prodvalidcverif = $DB->querys('SELECT quantite FROM validpaie where id_produit=? and pseudov=?', array($_GET['idc'], $_SESSION['idpseudo']));

		if (empty($prodvalidcverif)) {
					
			$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($_GET['idc'], 1, 1, $_GET['pv'], $_SESSION['idpseudo']));

		}else{

			$qtitesup=$prodvalidcverif['quantite']+1;

			$DB->insert('UPDATE validpaie SET quantite=? where id_produit=? and pseudov=?', array($qtitesup, $_GET['idc'], $_SESSION['idpseudo']));

		}
	}else{

		$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($_GET['idc'], 1, 1, $_GET['pv'], $_SESSION['idpseudo']));
	}

}

	
if (isset($_GET['clientvip'])) {
	$_SESSION['clientvip']=$_GET['clientvip'];
	$_SESSION['clientvipAlert']=$_GET['clientvip'];
	unset($_SESSION['clientvipcash']);
}else{
	$_SESSION['clientvipAlert']=0;
}

if (isset($_POST['clientvip'])) {
	$_SESSION['clientvip']=$_POST['clientvip'];
	$_SESSION['clientvipAlert']=$_POST['clientvip'];
	unset($_SESSION['clientvipcash']);
}else{
	$_SESSION['clientvipAlert']=0;
}

if (isset($_POST['clientvipcash'])) {
	$_SESSION['clientvipcash']=$_POST['clientvipcash'];
	unset($_SESSION['clientvip']);
}

if (empty($_SESSION['clientvip'])) {
	$_SESSION['clientvip']=0;
}

if ($panier->adresse()=='KOULA BUSINESS TRADING (K.B.T Sarl)' or $panier->adresse()=='ETS CHELAM') {

	if (!empty($_SESSION['clientvip'])) {
		$verifclient= $DB->querys("SELECT restriction FROM client where id='{$_SESSION['clientvip']}'");

		if ($verifclient['restriction']=='bloque') {
			$_SESSION['restriction']='bloqué';
			$com="Ce compte est bloqué, merci de contacter le responsable!!!";
		}else{

			$_SESSION['restriction']='ok';
			$com="";

		}
	}else{

		$_SESSION['restriction']='ok';
		$com="";

	}
}else{

	$_SESSION['restriction']='ok';
	$com="";

}

$com1="Compte bloqué, contacter le responsable!!!";

if (isset($_POST['banque'])) {
	$_SESSION['banque']=$_POST['banque'];
	unset($_SESSION['alertesvirement']);
}

$nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];
if (isset($_GET['scanneur'])) {
	$_SESSION['scanner']=$_GET['scanneur'];

	$prodstock = $DB->querys("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id where `".$nomtab."`.codeb=:id", array('id'=>$_GET['scanneur']));

	$prodvalidcverif = $DB->querys('SELECT quantite FROM validpaie where id_produit=? and pseudov=?', array($prodstock['id'], $_SESSION['idpseudo']));

	if (empty($prodvalidcverif)) {

		$DB->insert('INSERT INTO validpaie (id_produit, codebvc, quantite, pvente, pseudov, datecmd) VALUES(?, ?, ?, ?, ?, now())', array($prodstock['id'], 1, 1, $prodstock['prix_vente'], $_SESSION['idpseudo']));
	}else{

		$qtitesup=$prodvalidcverif['quantite']+1;

		$DB->insert('UPDATE validpaie SET quantite=? where id_produit=? and pseudov=?', array($qtitesup, $prodstock['id'], $_SESSION['idpseudo']));

	}
}

if (isset($_POST['pvente']) or isset($_POST['quantity'])) {
	$pvente=$panier->espace($_POST['pvente']);
	
	$DB->insert('UPDATE validpaie SET quantite=?, pvente=? where id=? and pseudov=?', array($_POST['quantity'], $pvente, $_POST['idv'], $_SESSION['idpseudo']));
}

if (isset($_POST['remise']) or isset($_POST['gnfpaye']) or isset($_POST['europaye']) or isset($_POST['uspaye']) or isset($_POST['cfapaye'])) {
	$remise=$panier->h($panier->espace($_POST['remise']));
	$montantgnf=$panier->h($panier->espace($_POST['gnfpaye']));
	$montanteu=$panier->h($panier->espace($_POST['europaye']));
	$montantus=$panier->h($panier->espace($_POST['uspaye']));
	$montantcfa=$panier->h($panier->espace($_POST['cfapaye']));
	$montantvir=$panier->h($panier->espace($_POST['virement']));
	$montantcheq=$panier->h($panier->espace($_POST['cheque']));
	$numcheque=$panier->h($_POST['numcheque']);
	$banqcheque=$panier->h($_POST['banqcheque']);

	$prodverifv=$DB->querys('SELECT id from validvente where pseudop=?', array($_SESSION['idpseudo']));

	if (empty($prodverifv)) {

		$DB->insert('INSERT INTO validvente (remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque, numcheque, banqcheque, pseudop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($remise, $montantgnf, $montanteu, $montantus, $montantcfa, $montantvir, $montantcheq, $numcheque, $banqcheque, $_SESSION['idpseudo']));
	}else{
	
		$DB->insert('UPDATE validvente SET remise=?, montantpgnf=?, montantpeu=?, montantpus=?, montantpcfa=?, virement=?, cheque=?, numcheque=?, banqcheque=? where pseudop=?', array($remise, $montantgnf, $montanteu, $montantus, $montantcfa, $montantvir, $montantcheq, $numcheque, $banqcheque, $_SESSION['idpseudo']));
	}

	
}	

$total=$panier->total();

$totalpaye=$panier->totalpaye();

$adress = $DB->querys('SELECT * FROM adresse ');

if ($adress['nom_mag']=='ETS BBS (Beauty Boutique Sow)') {

	$products=$DB->query("SELECT productslist.id as id, validpaie.id as idv, id_produit, validpaie.quantite as quantite, productslist.designation as designation, Marque, pvente, prix_vente as prix_vente, productslist.type as type, productslist.qtiteint as qtiteint, productslist.qtiteintp as qtiteintp FROM validpaie inner join productslist on productslist.id=validpaie.id_produit inner join `".$nomtab."` on idprod=productslist.id where pseudov='{$_SESSION['idpseudo']}' order by(validpaie.id) desc ");

}else{

	$products=$DB->query("SELECT productslist.id as id, validpaie.id as idv, id_produit, validpaie.quantite as quantite, productslist.designation as designation, Marque, pvente, prix_vente as prix_vente, productslist.type as type, productslist.qtiteint as qtiteint, productslist.qtiteintp as qtiteintp FROM validpaie inner join productslist on productslist.id=validpaie.id_produit inner join `".$nomtab."` on idprod=productslist.id where pseudov='{$_SESSION['idpseudo']}' order by(validpaie.id)");
}

$prodvente = $DB->querys('SELECT remise, montantpgnf, montantpeu, montantpus, montantpcfa, virement, cheque, numcheque, banqcheque FROM validvente where pseudop=?', array($_SESSION['idpseudo']));

$prodcredit= $DB->querys("SELECT *FROM limitecredit where idclient='{$_SESSION['clientvip']}' ");
$limiteCredit=$prodcredit['montant'];

if (!empty($products)) {?>

	<table class="table table-hover table-bordered table-striped table-responsive text-center fw-bold">
		<thead>
			<!-- <tr><?php 
				if ($_SESSION['restriction']=='ok') {?>

					<th>Selectionnez le Client</th><?php
					
				}else{?>

					<th style="color:white; background-color:red;"><?=$com;?></th><?php

				}
				if (!empty($_SESSION['clientvip'])) {
					if(-$panier->compteClient($_SESSION['clientvip'], "gnf")>$limiteCredit){?>
						<th colspan="4" style="color:white; background-color:red;"><?=$com1;?></th><?php
					}else{?>
						<th colspan="4">Solde Client</th><?php
					} 
				}?>
				
			</tr> -->
			<tr>
				<th>
					<div class="container-fluid">
						<div class="row">
							<div class="col-3">
								<form class="form" method="POST" action="index.php"><?php 
									if (!empty($_SESSION['clientvipcash'])) {?>

										<input class="form-control" type="text" name="clientvipcash" value="<?=$_SESSION['clientvipcash'];?>" onchange="this.form.submit()"/><?php

									}else{?>
										<input class="form-control" type="text" name="clientvipcash" placeholder="Entrer client cash" onchange="this.form.submit()"/><?php 
									}?>
								
								</form>
							</div>

							<div class="col-6">

								<form class="form" method="POST" action="index.php">
									<div class="row">
										<div class="col-6">

											<input class="form-control" id="search-user" type="text" name="client" placeholder="rechercher un client" />
										</div>
										<div class="col-6">											
											<select class="form-select" type="text" name="clientvip" onchange="this.form.submit()"><?php 

												if (!empty($_SESSION['clientvip'])) {?>

													<option value="<?=$_SESSION['clientvip'];?>"><?=$panier->nomClient($_SESSION['clientvip']);?></option><?php 
												}else{?>

													<option></option><?php
												}

												$type1='client';
												$type2='clientf';
												
												foreach($panier->clientF($type1, $type2) as $product){?>

													<option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
												}?>
											</select>
										</div>

										<div class="bg-danger" id="result-search"></div>
									</div>
								</form>
							</div>
							
							<div class="col-3">
								<div class="row"><?php

									if (!empty($_SESSION['clientvip'])) { 

										foreach ($panier->monnaie as $valuem) {
											if (!empty($panier->compteClient($_SESSION['clientvip'], $valuem))) {?>
												<div class="col">

													Solde <?=strtoupper($valuem);?>: <?=number_format(-$panier->compteClient($_SESSION['clientvip'], $valuem),0,',',' ');?>
												</div><?php
											}
											
										}
									}?>
								</div>
							</div>
						</div>
					</div>
				</th>
			</tr>

		</thead>

	</table>

	<table class="table table-hover table-bordered table-striped table-responsive text-center fw-bold">

		<thead>
			<th>Désignation</th>
			<th>Dispo</th>
			<th>P. Unit</th>
			<th>Qtité</th>
			<th>P. Total</th>
			<th>Retirer</th>

		</thead><?php
		$totachat=0;

		$qtitetot=0;
		$qtitetotp=0;
		$qtitetotd=0;

		foreach($products as $product){
			$qtites=0;

			if ($product->type=='en_gros') {
				$qtitetot+=$product->quantite;
			}elseif ($product->type=='detail') {
				$qtitetotd+=$product->quantite;
			}else{

				$qtitetotp+=$product->quantite;
			}

			foreach ($panier->listeStock() as $valueS) {

				$prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

				$qtites+=$prodstock['qtite'];

				
			}

			$etatliv='nonlivre';

			$prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

			$restealivrer=$qtites-$prodcmd['qtite'];
			
			$totachat+=$product->pvente*$product->quantite;

			if ($product->quantite > $qtites) {
				$color='danger';
			}elseif ($product->quantite==$qtites) {
				$color='warning';
			}else{
				$color='success';

			}?>

			<form class="form" id='monform' method="POST" action="index.php">
				<tbody><?php
					if ($product->type=='paquet') {

						$typegros='en_gros';

						$engros=$DB->querys("SELECT id, qtiteint, qtiteintp FROM productslist  WHERE Marque='{$product->Marque}' and type='{$typegros}'");

						if (empty($engros['qtiteintp'])) {
							$douzaine='';
						}else{
							$douzaine=(($engros['qtiteint'])/($engros['qtiteintp']));
						}
						
						$designation=$product->Marque.' int '.$douzaine;
					}else{
						$designation=$product->Marque;
					}?>

					<td class="text-<?=$color;?>"><?= ucwords(strtolower($designation)); ?>
						<input class="form-control" type="hidden" name="id" value="<?=$product->id;?>">
						<input class="form-control" type="hidden" name="idv" value="<?=$product->idv;?>">
					</td>

					<td class="text-<?=$color;?> text-center"><?=$restealivrer;?></td><?php
					

					if ($_SESSION['init']=='kmco') {
						if ($product->pvente==0) {?>

							<td><input class="form-control text-center text-<?=$color;?>"  type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>"></td><?php

						}else{?>

							<td><input class="form-control text-center text-<?=$color;?>"  type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>"></td><?php
						}
					}else{

						if ($product->pvente==0) {?>

							<td style="width: 20%;"><input class="form-control text-center text-<?=$color;?>"  type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>" onchange="this.form.submit()" ></td><?php

						}else{?>

							<td style="width: 20%;"><input class="form-control text-center text-<?=$color;?>"  type="text" min="0" name="pvente" value="<?=number_format($product->pvente,0,',',' ');?>" onchange="this.form.submit()" ></td><?php
						}
					}?>

					<td style="width: 15%;"><input class="form-control text-center fw-bold text-<?=$color;?>" type="text" min="0" name="quantity" value="<?=$product->quantite;?>" onchange="this.form.submit()"></td>

					<td class="text-<?=$color;?>"><?=number_format($product->pvente*$product->quantite,0,',',' ');?></td>
					<td>
						<a href="index.php?delPanier=<?= $product->idv;?>&montantsup=<?=$product->pvente*$product->quantite;?>" class="del"><i class="fa-solid fa-trash fs-4 m-auto mt-2 text-center" style="color: #d41633;"></i>
					</td>

				</tbody>
			</form><?php
		}?>

	</table>

	<table class="table table-hover table-bordered table-striped table-responsive fw-bold">
		<thead>
			<tr>
				<th>

					<div class="row"><?php

						$proddevise=$DB->query("SELECT *From devise where idvente='{$_SESSION['lieuvente']}'");
						if (empty($proddevise)) {
							$initdevise=0;

							$proddevise=$DB->query("SELECT *From devise where idvente='{$initdevise}'");
						}

						foreach ($proddevise as $key => $valued) {?><?=$valued->nomdevise;?>
							<div class="col-4">

								<form class="form" method="POST" action="index.php" >

									<input class="form-control" type="hidden" name="nom" value="<?=$valued->nomdevise;?>"><input class="form-control" type="text" name="devise" value="<?=$valued->montantdevise;?>" onchange="this.form.submit()">
								</form>
							</div><?php 
						}?>
					</div>
				</th><?php

				if (isset($_POST['gnfpaye']) or isset($_POST['europaye']) or isset($_POST['uspaye']) or isset($_POST['cfapaye'])){

					if ($total>0) {?>

						<th class="bg-danger text-white text-center fs-5">Reste <label><?=" ". number_format(($total),0,',',' '); ?></label></th><?php

					}else{?>

						<th class="bg-success text-white text-center fs-5">Rendu <label><?=" ". number_format(($total),0,',',' '); ?></label></th><?php
					}

				}else{?>

					<th class="bg-danger text-white text-center fs-5">TOTAL <label><?=" ". number_format(($total),0,',',' '); ?></label></th><?php
				}?>

			</tr>
		</thead>
	</table>

	<table class="table table-hover table-bordered table-striped table-responsive text-center fw-bold">

		<!-- <thead>
			<tr>
				<th>REMISE</th>
				<th colspan="2">GNF Payé</th>
				<th>Euro Payé</th>
				<th style="width:20%;">US Payé</th>
				<th colspan="2">CFA Payé</th>                   
			</tr>

		</thead> -->

		<tbody>
			<form class="form" id='remise' method="POST" action="index.php">
				<input class="form-control" type="hidden" min="0" name="remise" value="<?=number_format($prodvente['remise'],0,',',' ');?>">
				<input class="form-control" type="hidden" min="0"   name="gnfpaye" value="<?=number_format($prodvente['montantpgnf'],0,',',' ');?>">
				<input class="form-control" type="hidden" min="0" name="europaye" value="<?=number_format($prodvente['montantpeu'],0,',',' ');?>">
				<input class="form-control" type="hidden" min="0" name="uspaye" value="<?=number_format($prodvente['montantpus'],0,',',' ');?>">
				<input class="form-control" type="hidden" min="0" name="cfapaye" value="<?=number_format($prodvente['montantpcfa'],0,',',' ');?>">
				<input class="form-control" type="hidden" name="virement" value="<?=number_format($prodvente['virement'],0,',',' ');?>">
				<input class="form-select" type="hidden" name="banque">
				<input class="form-select" type="hidden" name="banqcheque">
				<input class="form-control" type="hidden" name="numcheque" placeholder="N° du Chèque"/>
				<input class="form-control" type="hidden" name="cheque" placeholder="montant du Chèque"  onchange="this.form.submit()" >
				<!-- <tr>						

					<td><input class="form-control" type="text" min="0" onchange="this.form.submit()" name="remise" value="<?=number_format($prodvente['remise'],0,',',' ');?>"></td>

					<td colspan="2"><?php 
						if (!empty($_SESSION['clientvipcash'])) {?>
							<input class="form-control" type="text" min="0"  required=""  onchange="this.form.submit()" name="gnfpaye" value="<?=number_format($prodvente['montantpgnf'],0,',',' ');?>"><?php 
						}else{?>

							<input class="form-control" type="text" min="0" onchange="this.form.submit()" name="gnfpaye" value="<?=number_format($prodvente['montantpgnf'],0,',',' ');?>"><?php 
						}?>
					</td>

					<td><input class="form-control" type="text" min="0" onchange="this.form.submit()" name="europaye" value="<?=number_format($prodvente['montantpeu'],0,',',' ');?>"></td>


					<td><input class="form-control" type="text" min="0" onchange="this.form.submit()" name="uspaye" value="<?=number_format($prodvente['montantpus'],0,',',' ');?>"></td>

					<td colspan="2"><input class="form-control" type="text" min="0" onchange="this.form.submit()" name="cfapaye" value="<?=number_format($prodvente['montantpcfa'],0,',',' ');?>"></td>

				</tr> -->
				<!-- </tbody> -->
			<!-- <thead>
				<tr><?php 
					if (!empty($_SESSION['alertesvirement'])) {?>
						<th colspan="2"><?=$_SESSION['alertesvirement'];?></div></th><?php 
					}else{?>
						<th colspan="2">Versement Banque</th><?php 
					}?>

					<th colspan="3">Chèque</th>

					<th colspan="2">T. Payé</th>
				</tr>
				</thead> -->
				<!-- <tbody>

					<tr>

						<td><input class="form-control" type="text" name="virement" value="<?=number_format($prodvente['virement'],0,',',' ');?>" onchange="this.form.submit()"></td>

						<td><?php 
							if ($prodvente['virement']!=0) {?>

								<select class="form-select" type="text" name="banque" required="" onchange="this.form.submit()"><?php

							}else{?>

								<select class="form-select" type="text" name="banque" onchange="this.form.submit()"><?php
							}
								

							if (!empty($_SESSION['banque'])) {?>
								
								<option value="<?=$_SESSION['banque'];?>"><?=$panier->nomBanquefecth($_SESSION['banque']);?></option><?php
							}else{?>

								<option></option><?php
							}

							foreach($panier->nomBanqueVire() as $product){?>

								<option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
							}?>
						</select></td>

						<td colspan="3">
							<div class="row">
								<div class="col-4">
									<input class="form-control" type="text" name="numcheque" value="<?=$prodvente['numcheque'];?>" placeholder="N° du Chèque" onchange="this.form.submit()"/><?php
									if (!empty($_SESSION['alerteschequep']) and empty($prodvente['numcheque'])) {?>
										<div class="bg-danger"><?=$_SESSION['alerteschequep'];?></div><?php 
									}?>
								</div>
								<div class="col-4">

									<select class="form-select" type="text" name="banqcheque" onchange="this.form.submit()">
										<option value="ecobank">Ecobank</option>
										<option value="bicigui">Bicigui</option>
										<option value="vistagui">Vistagui</option>
										<option value="bsic">Bsic</option>
										<option value="uba">UBA</option>
										<option value="banque islamique">Banque islamique</option>
										<option value="skye bank">Skye Banq</option>
										<option value="bci">BCI</option>
										<option value="fbn">FBN</option>
										<option value="societe generale">Société Générale</option>
										<option value="orabank">Orabank</option>
										<option value="vistabank">Vista Bank</option>
										<option value="asses">Asses</option>
										<option value="bpmg">BPMG</option>
										<option value="afriland">Afriland</option>
									</select>
								</div>
								<div class="col-4">

									<input class="form-control" type="text" name="cheque" value="<?=number_format($prodvente['cheque'],0,',',' ');?>" placeholder="montant du Chèque"  onchange="this.form.submit()" >
								</div>
							</div>
						</td>

						<th colspan="2" class="bg-success"><?= number_format(($totalpaye),0,',',' '); ?></th>	
					</tr>
				</tbody> -->

			</form>

			<thead>
				<tr>
					<th colspan="2">Frais Sup</th>
					<th>Date Alerte</th>
					<th>Date Vente</th>
					<!-- <th colspan="2">Compte de Dépôt</th>							 -->
					<th colspan="2">Livré</th>
				</tr>
			</thead>

			<tbody>

			<form class="form" id='payement' method="POST" action="payement.php"><?php

				if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

					<tr>
						<td colspan="2"><input class="form-control"  type="text" min="0" name="fraisup"></td>								

						<td><input class="form-control" type="date" name="dateal"></td>

						<td>
							<input class="form-control" type="date" name="datev">
							<input class="form-control" type="hidden" name="compte" value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>">
						</td>

						<!-- <td colspan="2">
							<select class="form-select"  name="compte" required="" ><?php
								$type='Banque';

								foreach($caisse->nomTypeCaisse() as $product){?>

									<option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
								}
								foreach($caisse->listBanque() as $product){?>

									<option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
								}?>
							</select>
						</td> -->

						<td colspan="2">
							<select class="form-select" type="text" name="stockd">

								<option></option>						
								<option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option>
								<!-- <?php 

								if ($_SESSION['level']>6) {

									foreach($panier->listeStock() as $product){?>

									<option value="<?=$product->id;?>"><?=strtoupper($product->nomstock);?></option><?php

									}
								}?> -->
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="3"><?php 
							if (isset($_GET['clientCom'])) {
								$_SESSION['clientCom']=$_GET['clientCom'];
							}?>
							<div class="row">
								<div class="col-6"><?php 
									if (empty($_SESSION['clientCom'])) {?>
										<input class="form-control" id="search-userCom" type="text" name="clientCom" placeholder="Client pour la commission" /><?php 
									}else{?>

										<input class="form-control" id="search-userCom" type="text" name="clientCom" placeholder="<?=$panier->nomClient($_SESSION['clientCom']);?>" />
										<input class="form-control" type="hidden" name="clientCom" value="<?=$_SESSION['clientCom'];?>" /><?php 
									}?>

									
								</div>
							
								<div class="col-6">
									<input class="form-control" type="text" name="montantCom" placeholder="montant de la commission" >
								</div>
							</div>
							<div class="bg-danger" id="result-searchCom"></div>
						</td><?php
						if (-$panier->compteClient($_SESSION['clientvipAlert'], "gnf")>$limiteCredit) {?>
							<td class="bg-danger">Compte Bloqué</td><?php
						}else{

							if (empty($_SESSION['clientvip']) and empty($_SESSION['clientvipcash'])) {
							}else{?>

								<input class="form-control" type="hidden" name="reste" value="<?=$panier->total();?>">

								<td><button class="btn btn-warning" type="submit" name="proformat">Proformat</button></td><?php

								if (!empty($_SESSION['clientvipcash'])) {

									if ($total<=0) {?>
										
										<td><button class="btn btn-success w-100"  type="submit" name="payer">Valider</button></td><?php
									}

								}else{?>

									<td><?php 
										if ($_SESSION['restriction']=='ok') {?>

											<button class="btn btn-success"  type="submit" name="payer">Valider</button><?php 
										}?>
									</td><?php

								} 
							}
						}?>

					</tr><?php

				}else{

					if ($panier->licence()=="expiree") {?>

						<div class="alertes">Votre licence est expirée contactez DAMKO</div><?php
					}

				}?>
			</form>
		</tbody>

		<tbody>
			<tr><?php 

				if($qtitetot!=0){?>
					<td>Nbre d'articles: <?=$qtitetot;?></td><?php 
				}

				if($qtitetotp!=0){?>
					<td>Paquet(s): <?=$qtitetotp;?></td><?php 
				}

				if($qtitetotd!=0){?>
					<td>Détail(s): <?=$qtitetotd;?></td><?php 
				}?>
			</tr>
		</tbody>
	</table><?php
}else{
	
}?>





