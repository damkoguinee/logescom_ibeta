<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];


    if ($_SESSION['level']>=3) {?>
      <div class="container-fluid">
        <div class="row"><?php 
          require 'navversement.php'; ?>

          <div class="col-sm-12 col-md-10"><?php
            if (isset($_GET['deleteret'])) {
              $DB->delete("DELETE from decdepense where numdec='{$_GET['deleteret']}'");
              $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");
              $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>
              <div class="alert alert-success">Suppression reussi!!</div><?php 
            }

            if (isset($_POST['valid'])){ 
              if ($_POST['montant']<0){?>
                <div class="alert alert-warning">FORMAT INCORRECT</div><?php
              }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>
                <div class="alert alert-warning">Echec montant decaissé est > au montant disponible en caisse</div><?php
              }else{                         

                if (!empty($_POST['montant']) and !empty($_POST['categorie']) and !empty($_POST['compte'])) {
                  $numdec = $DB->querys('SELECT max(id) AS id FROM decdepense ');
                  $numdec=$numdec['id']+1;
                  $categorie=$_POST['categorie'];
                  $montant=$panier->h($_POST['montant']);
                  $devise=$panier->h($_POST['devise']);
                  $motif=$panier->h($_POST['coment']);
                  $payement=$_POST['mode_payement'];
                  $compte_op=$panier->h($_POST['compte_op']);
                  $compte_op_nom=$panier->h($caisse->compteById($_POST['compte_op'])['nom_compte']);
                  $compte=$panier->h($_POST['compte']);
                  $dateop=$panier->h($_POST['datedep']);
                  if (empty($dateop)) {
                    $dateop=date("Y-m-d H:i");
                  }else{
                    $dateop=$dateop;
                  }
                  $lieuventeret=$panier->lieuVenteCaisse($compte)[0];
                  if(isset($_POST["env"])){
                    require "uploadep.php";
                  }
                  $DB->insert('INSERT INTO decdepense (numdec, categorie, montant, devisedep, payement, coment, cprelever, lieuvente, compte_op, idpers, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('retd'.$numdec, $categorie, $montant, $devise, $payement, $motif, $compte, $lieuventeret, $compte_op, $_SESSION['idpseudo'], $dateop));

                  $DB->insert('INSERT INTO banque (id_banque,origine,typeent,montant,libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,"depense",$compte_op_nom, -$montant, $motif, 'retd'.$numdec, $devise, $lieuventeret, $dateop));?>

                  <div class="alert alert-success">Retrait enregistré avec succèe!!</div><?php
                } else{?>
                  <div class="alert alert-warning">Saisissez tous les champs vides</div><?php
                }
              }
            }

            if (isset($_POST['categorie']) or isset($_POST['magasin'])) {

              $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

            }else{

              if (!isset($_POST['j1'])) {

                $_SESSION['date']=date("Ymd");  
                $dates = $_SESSION['date'];
                $dates = new DateTime( $dates );
                $dates = $dates->format('Ymd'); 
                $_SESSION['date']=$dates;
                $_SESSION['date1']=$dates;
                $_SESSION['date2']=$dates;
                $_SESSION['dates1']=$dates; 

              }else{

                $_SESSION['date01']=$_POST['j1'];
                $_SESSION['date1'] = new DateTime($_SESSION['date01']);
                $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
                
                $_SESSION['date02']=$_POST['j2'];
                $_SESSION['date2'] = new DateTime($_SESSION['date02']);
                $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

                $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
                $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');  
              }

              if (isset($_POST['j2'])) {

                $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

              }else{

                $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
              }
            }

            if (isset($_POST['categorie'])) {
              $_SESSION['categoriedep']=$_POST['categorie'];
            }

            if (isset($_POST['magasin'])) {
              $_SESSION['magasindep']=$_POST['magasin'];
            }
            if(isset($_POST["categins"])){

              $cate=$_POST['cate'];

              $products=$DB->query('SELECT nom FROM categoriedep WHERE nom= ?', array($cate));

              if (empty($products)) {

                $DB->insert('INSERT INTO categoriedep (nom) VALUES (?)', array($cate));

              }else{?>

                <div class="alert alert-warning">Cette catégorie existe déjà</div><?php

              }
            }

            $prodep=$DB->query('SELECT id, nom FROM categoriedep');

            if(isset($_GET["categ"])){?>

              <form class="form" method="POST">
                <legend>Ajouter une catégorie</legend>
                <div class="mb-1 col-sm-12 col-md-4">
                  <label class="form-label">Nom de la catégorie</label>
                  <input class="form-control" type="text" name="cate" required="">
                </div>
                <button class="btn btn-primary" type="submit" name="categins" id="form" onclick="return alerteV();">Ajouter</button>
              </form><?php
            }
            if (isset($_GET['ajoutdep']) or isset($_POST['categins']) or isset($_GET["categ"])) {?>

              <form class="form" method="POST"  enctype="multipart/form-data">
                <legend>Enregistrer une depense</legend>
                <label class="form-label">Catégorie de dépense</label>
                <div class="row">
                  <div class="col sm-12 col-md-8">
                    <select class="form-select" name="categorie" required="">
                      <option></option><?php
                      foreach ($prodep as $value) {?>

                        <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="col sm-12 col-md-4"><a class="btn btn-warning" href="decdepense.php?categ">Ajouter une catégorie</a></div>
                </div>
                <div class="mb-2 d-flex">
                  <div class="">
                    <label for="compte" class="form-label">Compte Op*</label>
                    <select class="form-select" name="compte_op" required="" >
                      <option value=""></option><?php 
                      foreach ($caisse->compteAll() as $valuec) {?>
                        <option value="<?=$valuec->id;?>"><?=ucfirst($valuec->nom_compte);?></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="row mx-2">
                    <label class="form-label">Montant Décaissé*</label>
                    <div class="col sm-12 col-md-6">
                      <input class="form-control" id="numberconvert" type="number"   name="montant" min="0" required="">
                    </div>
                    <div class="col sm-12 col-md-6"><label class="form-label"><div class="bg-success text-white p-2 fw-bold" id="convertnumber"></div></label></div>
                  </div>
                </div>
                <div class="row mb-1">
                  <div class="col sm-12 col-md-4">
                    <label class="form-label">Devise*</label>
                    <select class="form-select" name="devise" required="" ><?php 
                      foreach ($panier->monnaie as $valuem) {?>
                          <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="col sm-12 col-md-4">
                    <label class="form-label">Mode de Payement*</label>
                    <select class="form-select" name="mode_payement" required="" ><?php 
                      foreach ($panier->modep as $value) {?>
                        <option value="<?=$value;?>"><?=$value;?></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="col sm-12 col-md-4">
                    <label class="form-label">Compte à Prélever</label>
                    <select class="form-select"  name="compte" required="">
                      <option></option><?php
                      foreach($caisse->caisseList() as $product){?>
                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }?>
                    </select>
                  </div>
                </div>
                <div class="row mb-1"><label class="form-label">Commentaires</label><input class="form-control" type="text" name="coment" required=""></div>
                <div class="row mb-1">
                  <div class="col sm-12 col-md-6">
                    <label class="form-label">Justificatifs</label>
                    <input class="form-control" type="file" name="just[]"multiple id="photo" />
                    <input class="form-control" type="hidden" value="b" name="env"/>
                  </div>
                  <div class="col sm-12 col-md-6"><label class="form-label">Date Op</label><input class="form-control" type="date" name="datedep"></div>
                </div><?php        
                    if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>
                      <button class="btn btn-primary" id="form"  type="submit" name="valid" onclick="return alerteV();">Valider</button><?php
                    }else{?>
                      <div class="alert alert-danger"> Journée cloturée ou la licence est expirée </div><?php
                    }?>
                </fieldset> 
              </form><?php             
            }
            
            if (!isset($_GET['ajoutdep'])) {?>
              <table class="table table-bordered table-striped table-hover table-responsive text-center align-middle">
              <thead class="sticky-top bg-light">
                <tr><th colspan="12" ><?="Liste des Dépenses " .$datenormale ?> <a class="btn btn-warning" href="decdepense.php?ajoutdep">Enregistrer une dépense</a> <a class="btn btn-warning" href="printdepenses.php" target="_blank" ><img  style=" height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></th></tr>
                <tr>
                  <th colspan="12">
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <form class="form" method="POST"  id="suitec" name="termc">
                          <div class="row">
                            <div class="col sm-12 col-md-6"><?php
                              if (isset($_POST['j1']) or isset($_POST['categorie'])) {?>
                                <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_SESSION['date01'];?>"><?php
                              }else{?>
                                <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php
                              }?>
                            </div>
                            <div class="col sm-12 col-md-6"><?php
                              if (isset($_POST['j2']) or isset($_POST['categorie'])) {?>
                                <input class="form-control" type = "date" name = "j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()"><?php
                              }else{?>
                                <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php
                              }?>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-sm-12 col-md-6">
                        <form class="form" method="POST" ><?php 
                          if (!empty($_SESSION['date1']) or isset($_POST['categorie'])) {?>
                            <select class="form-select" name="categorie" required="" onchange="this.form.submit()"><?php 
                              if (isset($_POST['categorie'])) {?>
                                <option value="<?=$_POST['categorie'];?>"><?=ucfirst($panier->nomCategoriedep($_POST['categorie']));?></option><?php                                  
                              }else{?>
                                <option>Selectionnez une Catégorie</option><?php 
                              }
                              foreach ($prodep as $value) {?>
                                <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                              }?>
                            </select><?php 
                          }?>
                        </form> 
                      </div>
                    </div>
                  </th>                                   
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Just</th>
                  <th>Date</th>
                  <th>Catégorie</th>
                  <th>Motif</th>                  
                  <th>GNF</th>
                  <th>$</th>
                  <th>€</th>
                  <th>AED</th>
                  <th>V. Banque</th>
                  <th>Chèque</th>
                  <th>Actions</th>
                </tr>

              </thead>
              <tbody><?php 
                $salaires=4;
                if (isset($_POST['j1'])) {
                  $products= $DB->query("SELECT *FROM decdepense WHERE categorie!='{$salaires}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(id) desc");
                  
                }elseif (isset($_POST['categorie'])) {
                  $products= $DB->query("SELECT * FROM decdepense  WHERE categorie='{$_SESSION['categoriedep']}'and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(id) desc");
                  
                }else{
                  
                  $products= $DB->query("SELECT *FROM decdepense WHERE categorie!='{$salaires}' and lieuvente='{$_SESSION['lieuvente']}' order by(id) desc");
                                   
                }

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                $virement=0;
                $cheque=0;
                foreach ($products as $keyv=> $product ){?>
                  <tr>
                    <td><?= $keyv+1; ?></td>
                    <td style="text-align: center"><?php
                      $num=$product->numdec;
                      $nom_dossier="justificatifdep/".$product->numdec."/";
                      if (file_exists($nom_dossier)) {
                        $dossier=opendir($nom_dossier);
                        while ($fichier=readdir($dossier)) {

                            if ($fichier!='.' && $fichier!='..') {?>

                                <a class="btn btn-warning" href="justificatifdep/<?=$product->numdec;?>/<?=$fichier;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a><?php
                            }
                        }closedir($dossier);
                      }?>
                    </td>
                    <td><?=(new DateTime($product->date_payement))->format("d/m/Y"); ?></td>
                    <td><?= ucwords(strtolower($panier->nomCategoriedep($product->categorie))); ?></td>
                    <td><?= ucfirst(strtolower($product->coment)); ?></td><?php
                    if ($product->devisedep=='gnf' and ($product->payement=='espèces' OR $product->payement=='especes')) {
                      $montantgnf+=$product->montant;?>

                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td><?php

                    }elseif ($product->devisedep=='us') {
                      $montantus+=$product->montant;?>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td><?php
                    }elseif ($product->devisedep=='eu') {
                      $montanteu+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td>
                      <td></td><?php
                    }elseif ($product->devisedep=='aed') {
                      $montantcfa+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td><?php

                    }elseif ($product->payement=='virement') {
                      $virement+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td><?php
                    }elseif ($product->payement=='chèque') {
                      $cheque+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td><?php
                    }?>
                    <td><?php if ($_SESSION['level']>=6){?><a onclick="return alerteS();" class="btn btn-danger" href="decdepense.php?deleteret=<?=$product->numdec;?>">Annuler</a><?php };?></td>
                    
                  </tr><?php 
                }?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5">Totaux Décaissements</th>
                  <th class="text-end"><?= $configuration->formatNombre($montantgnf);?></th>
                  <th class="text-end"><?= $configuration->formatNombre($montantus);?></th>
                  <th class="text-end"><?= $configuration->formatNombre($montanteu);?></th>
                  <th class="text-end"><?= $configuration->formatNombre($montantcfa);?></th>
                  <th class="text-end"><?= $configuration->formatNombre($virement);?></th>
                  <th class="text-end"><?= $configuration->formatNombre($cheque);?></th>
                </tr>
              </tfoot>
            </table><?php
        }

    }else{

        echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
    }

}else{


}?>   
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<script>
    $(document).ready(function(){
        $('#numberconvert').keyup(function(){
            $('#convertnumber').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'convertnumber.php?convertdec',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#convertnumber').append(data);
                        }else{
                          document.getElementById('convertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
  </script> 

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

