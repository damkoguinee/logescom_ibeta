<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];?>
  <div class="container-fluid">

    <div class="row"><?php
      require 'navversement.php';?>
      <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
        if ($products['level']>=3) {

          if (isset($_GET['deletevers'])) {

            $numero=$_GET['deletevers'];
            $DB->delete('DELETE FROM versement WHERE numcmd = ?', array($numero));

            $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));

            $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));

            $DB->delete('DELETE FROM modep WHERE numpaiep = ?', array($numero));?>

            <div class="alert alert-success">Le dépôt a bien été annulé</div><?php
          }

          if (!isset($_POST['magasin'])) {

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
          }

          if (isset($_POST['j2'])) {

            $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

          }else{

            $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
          }

          if (isset($_POST['clientliv'])) {
            $_SESSION['clientliv']=$_POST['clientliv'];
          }


          if (isset($_POST["valid"])) {

            if (empty($_POST["client"]) or empty($_POST["montant"]) or empty($_POST['devise'])) {?>

              <div class="alertes">Les Champs sont vides</div><?php

            }elseif($_POST['mode_payement']=='chèque' and empty($_POST['numcheque'])){
              header("Location: versement.php?ajout");

              $alertescheque='entrer le numéro du chèque';

              $_SESSION['alertescheque']=$alertescheque;

            }else{

              unset($_SESSION['alertescheque']);

              $montant=$panier->h($_POST['montant']);
              $devise=$panier->h($_POST['devise']);
              $client=$panier->h($_POST['client']);
              $motif=$panier->h($_POST['motif']);
              $payement=$_POST['mode_payement'];
              $compte=$panier->h($_POST['compte']);
              $compte_op=$panier->h($_POST['compte_op']);
              $compte_op_nom=$panier->h($caisse->compteById($_POST['compte_op'])['nom_compte']);
              $taux=$panier->h($_POST['taux']);
              $convert=$montant*$taux;
              $numcheque=$panier->h($_POST['numcheque']);
              $banquecheque=$panier->h($_POST['banquecheque']);

              if ($panier->lieuVenteCaisse($compte)[1]=='banque') {
                $lieuventeret=$_SESSION['lieuvente'];
              }else{
                $lieuventeret=$panier->lieuVenteCaisse($compte)[0];
              }
              $maximum = $DB->querys('SELECT max(id) AS max_id FROM versement ');

              $max=$maximum['max_id']+1;
              $dateop=$_POST['datedep'];
              if (empty($dateop)) {
                $dateop=date("Y-m-d H:i");
              }else{
                $dateop=$dateop;
              }

              $prodclient=$DB->querys("SELECT id, typeclient from client where id='{$_POST['client']}'");

              $DB->insert('INSERT INTO versement (numcmd, nom_client, montant, devisevers, numcheque, banquecheque, motif, type_versement, comptedep, lieuvente, compte_op, idpers, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array('dep'.$max, $client, $montant, $devise, $numcheque, $banquecheque, $motif, $payement, $compte, $lieuventeret, $compte_op, $_SESSION['idpseudo'], $dateop));

              if ($taux!=1) {        

                if ($prodclient['typeclient']!='Banque') {

                  $DB->insert('INSERT INTO bulletin (origine_bull, nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($compte_op_nom, $client, $convert, $motif, 'dep'.$max, 'gnf', $compte, $lieuventeret, $dateop));
                }
              }else{

                if ($prodclient['typeclient']!='Banque') {

                  $DB->insert('INSERT INTO bulletin (origine_bull, nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($compte_op_nom, $client, $montant, $motif, 'dep'.$max, $devise, $compte, $lieuventeret, $dateop));
                }

              }

              $DB->insert('INSERT INTO banque (id_banque,clientbanque,typeent,origine, montant, libelles, numero, devise, typep, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?,?, ?,?,?, ?, ?, ?, ?)', array($compte,$client,"depot", $compte_op_nom, $montant, $motif, 'dep'.$max, $devise, $payement, $lieuventeret, $numcheque, $banquecheque, $dateop));

              if ($prodclient['typeclient']=='Banque') {

                $DB->insert('INSERT INTO banque (id_banque,clientbanque,typeent,origine, montant, libelles, numero, devise, typep, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?,?, ?,?,?, ?, ?, ?, ?)', array($prodclient['id'],$client,"depot",$compte_op_nom, -$montant, $_POST['motif'], 'dep'.$max, $devise, $payement, $lieuventeret, $numcheque, $banquecheque, $dateop));
              }

              $DB->insert('INSERT INTO modep (numpaiep, client, montant, modep, taux, caisse, numerocheque, banquecheque, datefact) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array('dep'.$max, $client, $montant, $payement, $taux, $compte, $numcheque, $banquecheque, $dateop));
              if (isset($_POST["valid"])) {
                      
                $_SESSION['reclient']=$client;
                $_SESSION['nameclient']=$client;

                //header("Location:printversement.php");
          
              }?>
              <div class="alert alert-success">Retrait éffectué avec succèe</div><?php

            }

          }

          if (isset($_GET['ajout']) or isset($_GET['searchclientvers'])) {

            if (isset($_GET['searchclientvers']) ) {

              $_SESSION['searchclientvers']=$_GET['searchclientvers'];
            }else{
              $_SESSION['searchclientvers']=0;
            }
      
            if ($panier->compteClient($_SESSION['searchclientvers'], "gnf")>0) {
              $color='danger';
              $credit=0;
            }else{
              $color="success";
              $credit=-$panier->compteClient($_SESSION['searchclientvers'], "gnf");
            }?>

            <form class="form" method="POST">   

              <label class="form-label">Collaborateur*</label>
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="search-user" type="text" name="clients" placeholder="rechercher un collaborateur" />
                  <div class="bg-danger" id="result-search"></div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <select class="form-select" type="text" name="client"><?php
                    if (!empty($_SESSION['searchclientvers'])) {?>
                      <option value="<?=$_SESSION['searchclientvers'];?>"><?=$panier->nomClient($_SESSION['searchclientvers']);?></option><?php
                    }else{?>
                      <option></option><?php 
                    }?>
                  </select>
                </div>
              </div>
              <div class="my-2 text-white bg-<?=$color;?>">Solde Compte: <?=$configuration->formatNombre($panier->compteClient($_SESSION['searchclientvers'], 'gnf')); ?></div>
            
              
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
                <div class="mx-2">
                  <label class="form-label">Montant de dépôt*</label>
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <input class="form-control" id="numberconvert" type="text"   name="montant" min="0" required=""> 
                    </div>
                    <div class="col-sm-12 col-md-6">                                  
                      <div class="bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="convertnumber"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-12 col-md-2">
                  <label class="form-label">Devise*</label>
                  <select class="form-select" name="devise" required="" ><?php 
                    foreach ($panier->monnaie as $valuem) {?>
                        <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-2">
                  <label class="form-label">Taux*</label><input class="form-control" type="number" name="taux" value="1" required=""></div>
                <div class="col-sm-12 col-md-2"> 
                  <label class="form-label">Mode de Payement*</label>
                  <select class="form-select" name="mode_payement" required="" ><?php 
                    foreach ($panier->modep as $value) {?>
                      <option value="<?=$value;?>"><?=$value;?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-3">
                  <label class="form-label">N°Chèque</label>
                  <input class="form-control" type="text" name="numcheque">
                </div>
                <div class="col-sm-12 col-md-3">
                  <label class="form-label">Banque Chèque</label>
                  <select class="form-select" type="text" name="banquecheque">
                    <option></option>
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
                <!-- <div class="bg-warning"><?php if (isset($_POST['numcheque']) ) {?><?=$_SESSION['alertescheque'];?><?php };?></div> -->
              </div>
              <div class="row mb-2">
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
                <div class="col-sm-12 col-md-4">
                  <label class="form-label">Commentaires*</label>
                  <input class="form-control" type="text" name="motif" required="">
                </div>
                <div class="col-sm-12 col-md-4">
                  <label class="form-label">Date de dépôt</label>
                  <input class="form-control" type="date" name="datedep">
                </div>
              </div>
              <button class="btn btn-primary my-2" id="form"  type="submit" name="valid" onclick="return alerteV();">Valider</button>
            </form> <?php
          }

          if (!isset($_GET['ajout']) ) {?>
            <table class="table table-bordered table-hover table-striped ">

              <thead class="sticky-top bg-light text-center">
                <tr><th colspan="12" height="30"><?="Liste des dépôts " .$datenormale ?> <a class="btn  btn-warning" href="versement.php?ajout">Enregistrer un dépôt</a></th></tr>

                <tr>
                  <th colspan="12">
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
                      <form class="form" method="POST">
                        <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                          <div class="bg-danger" id="result-search"></div>
                      </form> 
                    </div>
                  </th>                 
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Date</th>
                  <th>Client</th>
                  <th>Motif</th>            
                  <th>GNF</th>
                  <th>$</th>
                  <th>€</th>
                  <th>AED</th>
                  <th>V. Banque</th>
                  <th>Chèque</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>

              <tbody><?php
              
                $cumulmontant=0;
                if (isset($_POST['j1'])) {
                  $products= $DB->query('SELECT versement.id as id, client.id as idc, numcmd, client.nom_client as nom_client, montant, motif, type_versement, devisevers, date_versement FROM versement inner join client on client.id=versement.nom_client  WHERE lieuvente=:lieu and DATE_FORMAT(date_versement, \'%Y%m%d\')>= :date1 and DATE_FORMAT(date_versement, \'%Y%m%d\')<= :date2 order by(versement.id)', array('lieu'=>$_SESSION['lieuvente'], 'date1' => $_SESSION['date1'], 'date2' => $_SESSION['date2']));  
                }elseif (isset($_GET['searchversclient'])) {            
                  $products= $DB->query('SELECT versement.id as id, client.id as idc, numcmd, client.nom_client as nom_client, montant, motif, type_versement, devisevers, date_versement FROM versement inner join client on client.id=versement.nom_client  WHERE lieuvente=:lieu and versement.nom_client = :client order by(versement.id)', array('lieu'=>$_SESSION['lieuvente'], 'client' => $_GET['searchversclient']));
                }else{            
                  $products= $DB->query('SELECT versement.id as id, client.id as idc, numcmd, client.nom_client as nom_client, montant, motif, type_versement, devisevers, date_versement FROM versement inner join client on client.id=versement.nom_client  WHERE lieuvente=:lieu  order by(versement.id) desc', array('lieu'=>$_SESSION['lieuvente']));
                }
            
                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                $virement=0;
                $cheque=0;
                foreach ($products as $keyd=> $product ){?>

                  <tr>
                    <td class="text-center"><?= $keyd+1; ?></td>
                    <td class="text-center"><?=(new DateTime($product->date_versement))->format("d/m/Y"); ?></td>
                    <td><?= $product->nom_client; ?></td>
                    <td><?= ucwords(strtolower($product->motif)); ?></td>
                    <?php

                    if ($product->devisevers=='gnf' and ($product->type_versement=='espèces' OR $product->type_versement=='especes')) {

                      $montantgnf+=$product->montant;?>

                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td><?php

                    }elseif ($product->devisevers=='us') {
                      $montantus+=$product->montant;?>

                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td><?php
                    }elseif ($product->devisevers=='eu') {
                      $montanteu+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td>
                      <td></td><?php
                    }elseif ($product->devisevers=='aed') {
                      $montantcfa+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td>
                      <td></td><?php

                    }elseif ($product->type_versement=='virement') {
                      $virement+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td>
                      <td></td><?php
                    }elseif ($product->type_versement=='chèque') {
                      $cheque+=$product->montant;?>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= $configuration->formatNombre($product->montant); ?></td><?php
                    }?>

                    <td class="text-center"><a href="printversement.php?numdec=<?=$product->id;?>&idc=<?=$product->idc;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></td>

                    <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-danger" onclick="return alerteS();" href="versement.php?deletevers=<?=$product->numcmd;?>">Annuler</a><?php };?></td>
                    
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4">Totaux Versements</th>
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

          echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

        }

      }else{

      }

      require 'footer.php';?> 
    </div>
  </div> 
    
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 

if (isset($_GET['client'])) {?>

  <script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?clientvers',
                      data: 'user=' + encodeURIComponent(utilisateur),
                      success: function(data){
                          if(data != ""){
                            $('#result-search').append(data);
                          }else{
                            document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                          }
                      }
                  })
              }
        
          });
      });
  </script><?php 
}else{?>

  <script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?versclient',
                      data: 'user=' + encodeURIComponent(utilisateur),
                      success: function(data){
                          if(data != ""){
                            $('#result-search').append(data);
                          }else{
                            document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                          }
                      }
                  })
              }
        
          });
      });
  </script><?php

} ?>

<script>
    $(document).ready(function(){
        $('#numberconvert').keyup(function(){
            $('#convertnumber').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'convertnumber.php?convertvers',
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


    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>
