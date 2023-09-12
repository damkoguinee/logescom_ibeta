<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];?>
    <div class="container-fluid">

      <div class="row"><?php 

        require 'navversement.php';?>

        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
          if ($_SESSION['level']>=3) {
            $prodep=$DB->query('SELECT id, nom FROM categorierecette');

            if (isset($_GET['deleteret'])) {

                $DB->delete("DELETE from recette where numdec='{$_GET['deleteret']}'");

                $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

                <div class="alert alert-success">Suppression reussi!!</div><?php 
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

                $datenormale=(new DateTime($dates))->format('d/m/Y');
              }
            }

            if (isset($_POST['categorie'])) {
              $_SESSION['categoriedep']=$_POST['categorie'];
            }

            if (isset($_POST['magasin'])) {
              $_SESSION['magasinrecet']=$_POST['magasin'];
            }

            if(isset($_POST["categins"])){

              $cate=$_POST['cate'];

              $products=$DB->query('SELECT nom FROM categorierecette WHERE nom= ?', array($cate));

              if (empty($products)) {

                $DB->insert('INSERT INTO categorierecette (nom) VALUES (?)', array($cate));

              }else{?>

                <div class="alert alert-warning">Cette catégorie existe déjà</div><?php

              }
            }

            if(isset($_GET["categ"])){?>
              <form method="POST" class="form">
                <legend>Ajouter une catégorie</legend>
                <label class="form-label">Nom de la catégorie</label>
                <input class="form-control" type="text" name="cate" required="">
                <button class="btn btn-primary my-2" type="submit" name="categins" id="form" onclick="return alerteV();" >Ajouter</button>
              </form><?php
            }
            if (isset($_GET['ajoutdep']) or isset($_POST['categins']) or isset($_GET["categ"])) {?>

              <form class="form" method="POST" enctype="multipart/form-data">                    
                <label class="form-label">Catégorie Recette</label>
                  <div class="row mb-2">
                    <div class="col-sm-12 col-md-6">
                      <select class="form-select" name="categorie" required="">
                        <option></option><?php
                        foreach ($prodep as $value) {?>

                          <option value="<?=$value->id;?>"><?=ucfirst($value->nom);?></option><?php 
                        }?>
                      </select>
                    </div>
                    <div class="col-sm-12 col-md-6"><a class="btn btn-info" href="recette.php?categ">Ajouter une catégorie</a></div>
                  </div>
                  <div class="mb-1">
                    <label class="form-label">Montant Décaissé*</label>
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <input class="form-control" id="numberconvert" type="text"   name="montant" min="0" required=""> 
                      </div>
                      <div class="col-sm-12 col-md-6">                                  
                        <div class="bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="convertnumber"></div>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-1">
                    <div class="col-sm-12 col-md-3">
                      <label class="form-label">Devise*</label>
                      <select class="form-select" name="devise" required="" ><?php 
                        foreach ($panier->monnaie as $valuem) {?>
                            <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                        }?>
                      </select>
                    </div>
                    <div class="col-sm-12 col-md-3"> 
                      <label class="form-label">Mode de Payement*</label>
                      <select class="form-select" name="mode_payement" required="" ><?php 
                        foreach ($panier->modep as $value) {?>
                          <option value="<?=$value;?>"><?=$value;?></option><?php 
                        }?>
                      </select>
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <label class="form-label">Compte de dépôt*</label>
                      <select class="form-select"  name="compte" required=""><?php
                        $type='banque';
                        foreach($caisse->nomTypeCaisse() as $product){?>

                          <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                        }

                        foreach($caisse->listBanque() as $product){?>

                          <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                        }?>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-2">
                    <div class="col-sm-12 col-md-4">
                      <label class="form-label">Commentaires*</label>
                      <input class="form-control" type="text" name="coment" required="">
                    </div>
                    <div class="col-sm-12 col-md-4">
                      <label class="form-label">Date de rétraît</label>
                      <input class="form-control" type="date" name="datedep">
                    </div>
                  </div>
        
                  <button class="btn btn-primary my-2" id="form"  type="submit" name="valid" onclick="return alerteV();">Décaisser</button> 
                </form><?php             
              }


              if (isset($_POST['valid'])){            

                if ($_POST['montant']<0){?>

                  <div class="alert alert-warning">FORMAT INCORRECT</div><?php

                }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>

                  <div class="alert alert-warning">Echec montant decaissé est > au montant disponible en caisse</div><?php

                }else{                         

                  if (!empty($_POST['montant']) and !empty($_POST['categorie']) and !empty($_POST['compte'])) {

                    $numdec = $DB->querys('SELECT max(id) AS id FROM recette ');
                    $numdec=$numdec['id']+1;

                    $categorie=$_POST['categorie'];
                    $montant=$panier->h($_POST['montant']);
                    $devise=$panier->h($_POST['devise']);
                    $motif=$panier->h($_POST['coment']);
                    $payement=$_POST['mode_payement'];
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

                    $DB->insert('INSERT INTO recette (numdec, categorie, montant, devisedep, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?,  ?)',array('depr'.$numdec, $categorie, $montant, $devise, $payement, $motif, $compte, $lieuventeret, $dateop));

                    $DB->insert('INSERT INTO banque (id_banque, clientbanque,typeent,origine,montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,"","recette","recette", $montant, $motif, 'depr'.$numdec, $devise, $lieuventeret, $dateop));?>
                    <div class="alert alert-success">Récette enregistrée avec succèe!!</div><?php

                  } else{?>

                    <div class="alert alert-warning">Saisissez tous les champs vides</div><?php

                  }

                }

              }
              if (!isset($_GET['ajoutdep'])) {?>
                <table class="table table-bordered table-hover table-striped ">

                  <thead class="sticky-top bg-light text-center">
                    <tr><th  colspan="11" height="30"><?="Liste des Recettes " .$datenormale ?> <a class="btn btn-warning" href="recette.php?ajoutdep">Enregistrer une Recette</a></th></tr>

                    <tr>
                      <th colspan="11">
                        <div class="d-flex justify-content-between">                   
                          <form class="form d-flex justify-content-between" method="POST"><?php

                            if (isset($_POST['j1'])) {?>

                              <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                            }else{?>

                              <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php

                            }

                            if (isset($_POST['j2'])) {?>

                              <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                            }else{?>

                              <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php

                            }?>
                          </form>
                          <form class="from" method="POST" ><?php 
        
                            if (isset($_POST['j1']) or isset($_POST['categorie'])) {?>
        
                              <select class="form-select" name="categorie" required="" onchange="this.form.submit()" ><?php 
                                if (isset($_POST['categorie'])) {?>
        
                                    <option value="<?=$_POST['categorie'];?>"><?=ucfirst($panier->nomCategorierecette($_POST['categorie']));?></option><?php
                                    
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
                      </th>                 
                    </tr>

                    <tr>
                      <th>N°</th>
                      <th>Date</th>
                      <th>Catégorie</th>
                      <th>Motif</th>                  
                      <th>GNF</th>
                      <th>$</th>
                      <th>€</th>
                      <th>CFA</th>
                      <th>V. Banque</th>
                      <th>Chèque</th>
                      <th>Actions</th>
                    </tr>

                  </thead>

                  <tbody><?php 

                    if (isset($_POST['j1'])) {
                      $products= $DB->query('SELECT *FROM recette WHERE lieuvente=:lieu and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('lieu'=>$_SESSION['lieuvente'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));
                    }elseif (isset($_POST['categorie'])) {  
                      $products= $DB->query('SELECT * FROM recette  WHERE lieuvente=:lieu and categorie= :client and DATE_FORMAT(date_payement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_payement, \'%Y%m%d\')<= :date2 order by(id) desc', array('lieu'=>$_SESSION['lieuvente'], 'client' => $_SESSION['categoriedep'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));                  

                    }else{
                      $products= $DB->query('SELECT *FROM recette  WHERE lieuvente=:lieu and YEAR(date_payement) = :annee order by(id) desc', array('lieu'=>$_SESSION['lieuvente'], 'annee' => date('Y')));   
                    }

                    $montantgnf=0;
                    $montanteu=0;
                    $montantus=0;
                    $montantcfa=0;
                    $virement=0;
                    $cheque=0;
                    foreach ($products as $keyv=> $product ){?>

                      <tr>
                        <td class="text-center"><?= $keyv+1; ?></td>
                        <td class="text-center"><?=(new DateTime($product->date_payement))->format("d/m/Y"); ?></td>
                        <td><?= ucwords(strtolower($panier->nomCategorierecette($product->categorie))); ?></td>
                        <td><?= ucwords(strtolower($product->coment)); ?></td><?php

                        if ($product->devisedep=='gnf' and $product->payement=='espèces') {

                          $montantgnf+=$product->montant;?>

                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td>

                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td><?php

                        }elseif ($product->devisedep=='us') {
                          $montantus+=$product->montant;?>

                          <td></td>
                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td><?php
                        }elseif ($product->devisedep=='eu') {
                          $montanteu+=$product->montant;?>

                          <td></td>
                          <td></td>
                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td>
                          <td></td>
                          <td></td>
                          <td></td><?php
                        }elseif ($product->devisedep=='aed') {
                          $montantcfa+=$product->montant;?>

                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td>
                          <td></td>
                          <td></td><?php

                        }elseif ($product->payement=='virement') {
                          $virement+=$product->montant;?>

                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td>
                          <td></td><?php
                        }elseif ($product->payement=='chèque') {
                          $cheque+=$product->montant;?>

                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td class="text-end"><?=$configuration->formatNombre($product->montant); ?></td><?php
                        }?>
                        <td><?php if ($_SESSION['level']>=6){?><a onclick="return alerteS();" class="btn btn-danger" href="recette.php?deleteret=<?=$product->numdec;?>">Annuler</a><?php };?></td>
                      
                      </tr><?php 
                    }?>

                  </tbody>

                  <tfoot>
                    <tr>
                      <th colspan="4">Totaux Recette</th>
                      <th class="text-end"><?=$configuration->formatNombre($montantgnf);?></th>
                      <th class="text-end"><?=$configuration->formatNombre($montantus);?></th>
                      <th class="text-end"><?=$configuration->formatNombre($montanteu);?></th>
                      <th class="text-end"><?=$configuration->formatNombre($montantcfa);?></th>
                      <th class="text-end"><?=$configuration->formatNombre($virement);?></th>
                      <th class="text-end"><?=$configuration->formatNombre($cheque);?></th>
                    </tr>
                  </tfoot>

                </table><?php
              }

            }else{

                echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
            }?>
          </div>
        </div>
    </div><?php 

  }
    require 'footer.php';?> 
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

