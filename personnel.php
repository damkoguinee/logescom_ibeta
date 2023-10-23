<?php
require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {
    
    if ($_SESSION['statut']!='vendeur') {?>

		<div class="container-fluid">

			<div class="row"><?php 

				require 'navpers.php';?>

				<div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

					if (isset($_GET['ajout_en'])) {?>
			
						<form class="form" method="POST" action="personnel.php">

							<fieldset><legend>Ajouter un Personnel</legend>
								<div class="mb-2">
									<label class="form-label">Type personnel*</label><select class="form-select" type="text" name="perso" required="">
										<option></option>
										<option value="responsable">Responsable</option>
										<option value="vendeur">Vendeur</option>
										<option value="livreur">Livreur</option>
										<option value="nettoyeur">Nettoyeur</option>
										<option value="securite">Sécurité</option>
									</select> 
								</div>

								<div class="mb-2">
									<label class="form-label">Nom & Prénom*</label>
									<input class="form-control" type="text" name="nom" required="">
								</div>

								<div class="mb-2">
									<label for="salaires" class="form-label">Salaires*</label>
									<input class="form-control" type="text" name="salaires" id="salaires" required="">
								</div>

								<div class="container-fluid">
									<div class="row">
										<div class="col">

											<div class="mb-2">
												<label class="form-label">Téléphone</label>
												<input class="form-control" type="text" name="tel" >
											</div>
										</div>

										<div class="col">
											<div class="mb-2">
												<label class="form-label">Email</label>
												<input class="form-control" type="text" name="mail" maxlength="100">
											</div>
										</div>
									</div>
								</div>

								<div class="container-fluid">
									<div class="row">
										<div class="col">
											<div class="mb-2">
												<label class="form-label">Pseudo</label>
												<input class="form-control" type="text" name="pseudo" >
											</div>
										</div>

										<div class="col">

											<div class="mb-2">
												<label class="form-label">Mot de Passe*</label>
												<input class="form-control" type="text" name="mdp" >
											</div>
										</div>
									</div>
								</div>

								<div class="container-fluid">
									<div class="row">
										<div class="col">

											<div class="mb-2"><label class="form-label">Lieu de Vente*</label><select class="form-select" type="text" name="lieuvente" required="">
												<option></option><?php 
												foreach ($panier->listeStock() as $value) {?>
													
													<option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
												}?></select>
											</div>
										</div>

										<div class="col">

											<div class="mb-2">
												<label class="form-label">Niveau*</label>
												<select class="form-select" type="number" name="niv" required="">
													<option value="1">Niveau 1</option>
													<option value="2">Niveau 2</option>
													<option value="3">Niveau 3</option>
													<option value="4">Niveau 4</option>
													<option value="5">Niveau 5</option>
													<option value="6">Niveau 6</option>
													<option value="7">Niveau 7</option>

												</select>  
											</div>
										</div>
									</div>
								</div>
							</fieldset>
					
							<button class="btn btn-primary" type="submit" name="ajouteen">Valider</button>
						</form><?php
					}

					if(isset($_POST['ajouteen'])){

						if($_POST['nom']!=""  and $_POST['perso']!=""){
							
							$nom=addslashes(Htmlspecialchars($_POST['nom']));
							$salaires=addslashes(Htmlspecialchars($_POST['salaires']));
							$phone=addslashes(Htmlspecialchars($_POST['tel']));
							$pseudo=addslashes(Nl2br(Htmlspecialchars($_POST['pseudo'])));
							$mdp=addslashes(Nl2br(Htmlspecialchars($_POST['mdp'])));
							$type=addslashes(Nl2br(Htmlspecialchars($_POST['perso'])));
							$niveau=addslashes(Nl2br(Htmlspecialchars($_POST['niv'])));
							$email=addslashes(Nl2br(Htmlspecialchars($_POST['mail'])));
							$lieuvente=addslashes(Nl2br(Htmlspecialchars($_POST['lieuvente'])));

							$mdp=password_hash($mdp, PASSWORD_DEFAULT);			

							$nb=$DB->querys('SELECT id from login where nom=:nom', array(
							'nom'=>$nom
							));

							if(!empty($nb)){?>
								<div class="alert alert-warning">Ce Personnel est déjà enregistré</div><?php
							}else{

								$nb=$DB->querys('SELECT max(id) as id from login');


								$matricule=$nb['id']+1;
								$matricule='pers'.$matricule;

								$DB->insert('INSERT INTO login(identifiant, nom, telephone, email, pseudo, mdp, level, statut, lieuvente, dateenreg) values(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($matricule, $nom, $phone, $email, $pseudo, $mdp, $niveau, $type, $lieuvente));

								$DB->insert('INSERT INTO personnel(identifiant, nom, salaires, telephone, email, lieuvente, dateenreg) values(?, ?, ?, ?, ?, ?, now())', array($matricule, $nom, $salaires, $phone, $email, $lieuvente));

								?>	

								<div class="alert alert-success">Personnel ajouté avec succée!!!</div><?php
							}

						

						}else{?>	

							<div class="alert alert-warning">Remplissez les champs vides</div><?php
						}
					}


					if (isset($_GET['modif_en'])) {?>
				
						<form class="form" method="POST" action="personnel.php">

							<fieldset><legend>Modifier un personnel</legend><?php

								$prodm=$DB->querys('SELECT * from login where id=:mat', array('mat'=>$_GET['modif_en']));
								
								$prodpers=$DB->querys('SELECT * from personnel where identifiant=:mat', array('mat'=>"pers".$_GET['modif_en']));?>
								<div class="mb-2">
									<label class="form-label">Type personnel</label><select class="form-select" type="text" name="perso" required="">
										<option value="<?=$prodm['statut'];?>"><?=$prodm['statut'];?></option>
										<option value="responsable">Responsable</option>
										<option value="vendeur">Vendeur</option>
										<option value="livreur">Livreur</option>
										<option value="nettoyeur">Nettoyeur</option>
										<option value="securite">Sécurité</option>
									</select>

									<input class="form-control"  type="hidden" name="id" value="<?=$_GET['modif_en'];?>"> 
								</div>

								<div class="mb-2">
									<label class="form-label">Nom</label>
									<input class="form-control" type="text" name="nom" value="<?=$prodm['nom'];?>" required="">
								</div>

								<div class="mb-2">
									<label for="salaires" class="form-label">Salaires*</label>
									<input class="form-control" type="text" name="salaires" value="<?=$prodpers['salaires'];?>" id="salaires" required="">
								</div>

								<div class="container-fluid">
									<div class="row">
										<div class="col">

											<div class="mb-2">
												<label class="form-label">Téléphone</label>
												<input class="form-control" type="text" name="tel" value="<?=$prodm['telephone'];?>" >
											</div>
										</div>

										<div class="col">

											<div class="mb-2">
												<label class="form-label">Email</label>
												<input class="form-control" type="text" name="mail" value="<?=$prodm['email'];?>" >
											</div>
										</div>
									</div>
								</div>
								<div class="container-fluid">
									<div class="row">
										<div class="col">

											<div class="mb-2">
												<label class="form-label">Pseudo</label>
												<input class="form-control" type="text" name="pseudo" value="<?=$prodm['pseudo'];?>" >
											</div>
										</div>

										<div class="col">

											<div class="mb-2">
												<label class="form-label">Mot de Passe</label>
												<input class="form-control" type="text" name="mdp" >
											</div>
										</div>
									</div>
								</div>

								<div class="mb-2"><label class="form-label">Lieu de Vente</label>
									<select class="form-select" type="text" name="lieuvente" required="">
										<option value="<?=$prodm['lieuvente'];?>"><?=$panier->nomStock($prodm['lieuvente'])[0];?></option><?php 
										foreach ($panier->listeStock() as $value) {?>
											
											<option value="<?=$value->id;?>"><?=ucwords($value->nomstock);?></option><?php
										}?>
									</select>
								</div>

								<div class="mb-2">
									<label class="form-label">Niveau</label>
									<select class="form-select" type="number" name="niv" required="">
										<option value="<?=$prodm['level'];?>"><?=$prodm['level'];?></option>
										<option value="1">Niveau 1</option>
										<option value="2">Niveau 2</option>
										<option value="3">Niveau 3</option>
										<option value="4">Niveau 4</option>
										<option value="5">Niveau 5</option>
										<option value="6">Niveau 6</option>
										<option value="7">Niveau 7</option>
									</select>  
								</div>

							</fieldset>
							
							<button class="btn btn-primary" type="submit" name="modifen">Modifier</button>
						</form><?php
					}

					if(isset($_POST['modifen'])){
							
						$nom=addslashes(Htmlspecialchars($_POST['nom']));
						$salaires=addslashes(Htmlspecialchars($_POST['salaires']));
						$phone=addslashes(Htmlspecialchars($_POST['tel']));
						$pseudo=addslashes(Nl2br(Htmlspecialchars($_POST['pseudo'])));
						$mdp=addslashes(Nl2br(Htmlspecialchars($_POST['mdp'])));
						$type=addslashes(Nl2br(Htmlspecialchars($_POST['perso'])));
						$niveau=addslashes(Nl2br(Htmlspecialchars($_POST['niv'])));
						$email=addslashes(Nl2br(Htmlspecialchars($_POST['mail'])));
						$lieuvente=addslashes(Nl2br(Htmlspecialchars($_POST['lieuvente'])));

						$mdp=password_hash($mdp, PASSWORD_DEFAULT);			

						$DB->insert('UPDATE login SET nom = ?, telephone=?, email=?, pseudo=?, mdp=?, level=?, statut=?, lieuvente=?  WHERE id = ?', array($nom, $phone, $email, $pseudo, $mdp, $niveau, $type, $lieuvente, $_POST['id']));
						$DB->insert('UPDATE personnel SET nom = ?, salaires=?, telephone=?, email=?, lieuvente=?  WHERE identifiant = ?', array($nom, $phone, $email, $salaires, $lieuvente, $_POST['id']));?>	
						<div class="alert alert-success"> Modification effectuée avec succée!!!</div><?php
						
					}

					// fin modification

					if (isset($_GET['enseig']) or isset($_POST['ajouteen'])  or isset($_GET['del_en']) or isset($_GET['del_pers']) or isset($_POST['modifen']) or isset($_GET['matiereen']) or isset($_GET['personnel']) or isset($_GET['payempcherc'])) {

						if (isset($_GET['del_pers'])) {

							$DB->delete('DELETE FROM login WHERE id = ?', array($_GET['del_pers']));
							$DB->delete('DELETE FROM personnel WHERE identifiant = ?', array($_GET['del_pers']));?>

							<div class="alert alert-success">Suppression reussie!!!</div><?php 
						}


						$statut='personnel';
						$level=6;
						$prodm=$DB->query("SELECT * from login where type='{$statut}' and lieuvente='{$_SESSION['lieuvente']}'");
						?>
				
						<table class="table table-hover table-bordered table-striped table-responsive">


							<thead>
								<tr>
									<th colspan="3" >Liste des personnels</th>

									<th colspan="5"><a class="btn btn-info" href="personnel.php?ajout_en" style="color: white;">Ajouter un personnel</a></th>
									
								</tr>

								<tr>
									<th>Nom & Prénom</th>
									<th>Fonction</th>
									<th>Salaire</th>
									<th>Phone</th>
									<th>E.mail</th>
									<th>Identifiant</th>

									<th colspan="2"></th>
								</tr>

							</thead>

							<tbody><?php

								if (empty($prodm)) {
									# code...
								}else{

									foreach ($prodm as $formation) {
										
										$prodpers=$DB->querys("SELECT salaires from personnel where identifiant='{$formation->identifiant}'");?>

										<tr>

											<td><?=ucwords($formation->nom);?></td>

											<td><?=ucfirst($formation->statut);?></td>

											<td class="text-end"><?=number_format($prodpers['salaires'],0,',',' ');?></td>

											<td><?=$formation->telephone;?></td>

											<td><?=$formation->email;?></td>

											<td><?=$formation->pseudo;?></td>
											

											<td class="text-center"><a class="btn btn-warning" href="personnel.php?modif_en=<?=$formation->id;?>">Modifier</a></div>

											<td class="text-center"><a class="btn btn-danger" href="personnel.php?del_pers=<?=$formation->id;?>" onclick="return alerteS();">Supprimer</a></div>
										</tr><?php

									}
								}?>

							
							</tbody>

						</table><?php
					}?>
				</div>
			</div>
		</div><?php
	}
	
}?>

<?php require 'footer.php';?>		

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>