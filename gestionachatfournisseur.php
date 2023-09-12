<?php require 'headerv2.php';?>

<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12 col-md-12"><?php 
      if (isset($_POST['validap'])) {
        $idprod=$panier->h($_POST['idprod']);
        $qtite=$panier->h($panier->espace($_POST['qtite']));
        $pa=$panier->h($panier->espace($_POST['pa']));
        $taux=$panier->h($panier->espace($_POST['taux']));
        $tauxgnf=$panier->h($panier->espace($_POST['tauxgnf']));
        $transporteur=$panier->h($_POST['transporteur']);
        $cmd=$panier->h($_POST['cmd']); 
        $idc=$panier->h($_POST['idc']); 

        $prodinit= $DB->querys("SELECT livre FROM gestionachatfournisseur WHERE id='{$idc}'");
        $livre=$prodinit['livre']+$qtite;

        $DB->insert("UPDATE gestionachatfournisseur SET livre='{$livre}' WHERE id='{$idc}' ");

        $DB->insert('INSERT INTO gestionachathist(idprod, qtite, lieu, cmd, dateop) VALUES(?, ?, ?, ?, now())', array($idprod, $qtite, $transporteur, $cmd));

        $prodinittrans= $DB->querys("SELECT *FROM gestiontransporteur WHERE idprod='{$idprod}' and cmd='{$cmd}' and client='{$transporteur}'");

        $livretrans=$prodinittrans['qtite']+$qtite;

        if (empty($prodinittrans['id'])) {

          $DB->insert('INSERT INTO gestiontransporteur (idprod, qtite, pv, taux, tauxgnf, client, cmd, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($idprod, $qtite, $pa, $taux, $tauxgnf, $transporteur, $cmd));

        }else{
          $DB->insert("UPDATE gestiontransporteur SET qtite='{$livretrans}' WHERE idprod='{$idprod}' and cmd='{$cmd}' and client='{$transporteur}' ");
        }?>

        <div class="alert alert-success">Produit transferé avec sucèe!!!</div> <?php
      }
      
      if (isset($_GET['bl'])) {
        $_SESSION['bl']=$_GET['bl'];
      }      
      $cols=sizeof($panier->listeStock());
      $colf=sizeof($panier->clientf('fournisseur', 'fournisseur'));
      $col=$cols+$colf;?>

      <div class="row">
        <div class="col-sm-12 col-md-12" style="overflow: auto;"><?php 
          require 'gestionportefeuille.php';?>
          <table class="table table-hover table-bordered table-striped table-responsive text-center">
            <thead>
              <tr>
                <th colspan="12">
                  <div class="row">
                    <div class="col-sm-5 col-md-3">
                      <form class="form" method="GET" action="gestionachatfournisseur.php" id="suite" name="term">
                        <select name="categorie" id="" class="form-select" onchange="this.form.submit()">
                          <option value="">Recherchez par fournisseur</option><?php
                          foreach ($panier->clientf('fournisseur', 'fournisseur') as $valuer) {?>
                            <option value="<?=$valuer->id;?>"><?=$valuer->nom_client;?></option><?php
                          }?>
                          <option value="general">liste générale</option>
                        </select>
                      </form>
                    </div>
                    <div class="col-sm-6 col-md-8">
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionselection.php?bl=<?=$_SESSION['bl'];?>&recette">Pré-Selection</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionchoixfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Selection</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionpanierfournisseur?bl=<?=$_SESSION['bl'];?>&recette">Panier  <?=strtoupper($_SESSION['bl']);?> </a>
                      <a class="btn btn-success fw-bold mx-1 text-white" href="?bl=<?=$_SESSION['bl'];?>&recette">Livraison</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport.php?bl=<?=$_SESSION['bl'];?>&recette">Départ Pays</a>
                    </div>
                  </div>
            
                </th>
              </tr>     

              <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Fournisseur</th>
                <th>Référence</th>
                <th>Prix AED</th>
                <th>~Prix $</th>
                <th>Prix GNF</th>
                <th>Liv/Cmd</th>
                <th>Qtité livré</th>
                <th>Lieu de Liv</th>
                <th colspan="2"></th>  
              </tr>

            </thead>

            <tbody>

              <?php
              $tot_achat=0;
              $tot_revient=0;
              $tot_vente=0;
              $qtiteR=0;
              $qtiteS=0; 
              if (isset($_GET["categorie"]) and $_GET["categorie"]=="general"){
                $_SESSION['selectionChoixLivraison']='';
              }elseif (isset($_GET["categorie"])){
                $_SESSION['selectionChoixLivraison']=$_GET["categorie"];
              }else{
                if (!empty($_SESSION['selectionChoixLivraison'])) {
                  $_SESSION['selectionChoixLivraison']=$_SESSION['selectionChoixLivraison'];
                }else{
                  $_SESSION['selectionChoixLivraison']='';
                }

              }

            


              if (empty($_SESSION['selectionChoixLivraison'])) {

                if (isset($_GET["categorie"]) and $_GET["categorie"]!="general"){

                  $_GET["terme"] = htmlspecialchars($_GET["categorie"]); //pour sécuriser le formulaire contre les failles html
                  $terme = $_GET['terme'];
                  $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                  $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                  $_SESSION['selectionChoixLivraison']=$terme;

                  $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE fournisseur='{$terme}' and cmd='{$_SESSION['bl']}' ");

                }else{
                  $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE cmd='{$_SESSION['bl']}' ");
                  
                }
              }else{

                if (!empty($_SESSION['selectionChoixLivraison'])) {
                  $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE fournisseur='{$_SESSION['selectionChoixLivraison']}' and cmd='{$_SESSION['bl']}' ");

                }else{

                  $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE cmd='{$_SESSION['bl']}' ");
                }
              }
              $cumulaed=0;
              $cumuldollard=0;
              $cumulgnf=0;
              $cumulqtite=0;
              $cumullivre=0;

              if (!empty($products)) {
                
                foreach ($products as $key=> $product){
                  $reste=($product->qtite-$product->livre);
                  $color='';
                  $aed=$product->pv;
                  $dollard=$product->pv/$product->taux;
                  $gnf=$product->pv*$product->tauxgnf;

                  $aedunit=$product->pv*$product->qtite;
                  $dollardunit=($product->pv/$product->taux)*$product->qtite;
                  $gnfunit=$product->pv*$product->tauxgnf*$product->qtite;
                  $qtite=$product->qtite;
                  $livre=$product->livre;
                  
                  $cumulaed+=$aedunit;
                  $cumuldollard+=$dollardunit;
                  $cumulgnf+=$gnfunit;
                  $cumulqtite+=$qtite;
                  $cumullivre+=$livre;?>

                  <tr>
                    <td><?=$key+1;?></td> 
                    <td><?=(new DateTime($product->dateop))->format("d/m/Y");?></td>

                    <form class="form" action="gestionachatfournisseur.php" method="POST">
                      <td><?=$panier->nomClient($product->fournisseur); ?></td>
                      <td style="color:<?=$color;?>"><?= ucwords(strtolower($product->Marque)); ?>
                        <input class="form-control" type="hidden" name="idprod" value="<?=$product->idprod; ?>"/>
                        <input class="form-control" type="hidden" name="cmd" value="<?=$product->cmd; ?>"/>
                        <input class="form-control" type="hidden" name="fourni" value="<?=$product->fournisseur; ?>"/>
                        <input class="form-control" type="hidden" name="pa" value="<?=$aed; ?>"/>
                        <input class="form-control" type="hidden" name="taux" value="<?=$product->taux; ?>"/>
                        <input class="form-control" type="hidden" name="tauxgnf" value="<?=$product->tauxgnf; ?>"/>
                        <input class="form-control" type="hidden" name="idc" value="<?=$product->idc; ?>"/>
                      </td>
                      <td><?=number_format($aed,0,',',' '); ?></td>
                      <td><?=number_format($dollard,2,',',' '); ?></td>
                      <td><?=number_format($gnf,0,',',' '); ?></td>
                      <td><?= $product->livre; ?> / <?= $product->qtite; ?></td><?php 
                      if ($reste!=0) {?>
                        <td><input type="number"  name="qtite" min="0" max="<?=$reste;?>" required class="form-control"></td>
                        <td>
                          <select name="transporteur" id="" class="form-select" required>
                            <option value=""></option><?php 
                            $type='transporteur';
                            foreach ($panier->clientf($type, $type) as $key => $value) {?>
                              <option value="<?=$value->id;?>"><?=$panier->nomClient($value->id);?></option><?php 
                            }?>
                          </select>
                        </td>

                        <td><button class="btn btn-primary" type="submit" name="validap" onclick="return alerteT();">Livrer</button></td><?php
                      } else {?>
                        <td class="text-success">clos</td>
                        <td class="text-success">clos</td>
                        <td class="text-success">clos</td><?php
                      }?>

                      <td class="m-0 p-0">
                        <table class="table table-hover table-bordered table-striped table-responsive text-center m-0 p-0">                        
                          <tbody>
                            <tr><?php 
                              $prodhis=$DB->query("SELECT *from gestionachathist where idprod='{$product->idprod}' and cmd='{$product->cmd}' order by(id) ");
                              foreach ($prodhis as $key => $valuehis) {?>
                                <td>L<?=$key+1;?><br><?=$valuehis->qtite;?></td><?php
                              } ?>

                              
                            </tr>
                          </tbody>
                        </table>
                      </td>
                      
                      
                  </form>
                </tr><?php
              }
            }?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4">Totaux</th>
              <th><?=number_format($cumulaed,0,',',' '); ?></th>
              <th><?=number_format($cumuldollard,2,',',' '); ?></th>
              <th><?=number_format($cumulgnf,0,',',' '); ?></th>
              <th><?=number_format($cumullivre,0,',',' '); ?> / <?=number_format($cumulqtite,0,',',' '); ?></th>
            </tr>
          </tfoot>

        </table>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?edition',
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
</script>


<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteT(){
        return(confirm('Confirmer le transfert des produits'));
    }

    function focus(){
    document.getElementById('reccode').focus();
  }

    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>  