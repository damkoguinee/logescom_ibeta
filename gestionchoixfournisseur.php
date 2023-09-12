<?php require 'headerv2.php';?>

<div class="container-fluid">

  <div class="row"><?php
    //require 'navfournisseur.php';?>

    <div class="col-sm-12 col-md-12"><?php

      if (isset($_GET['deletevers'])) {

        $id=$_GET['deletevers'];

        $numero=$_GET['idprod'];
        $depart=$_GET['depart'];
        $nomtabdep=$panier->nomStock($depart)[1];
        $qtitesup=$_GET['qtite'];
        $dateop=$_GET['dateop'];
        $bl=$_SESSION['bl'];

        $qtiteiniti=$DB->querys("SELECT quantite, prix_revient as pr FROM `".$nomtabdep."` WHERE idprod=?", array($numero));

        $prodcmd=$DB->querys("SELECT quantite, previent as pr FROM achat WHERE id_produitfac=? and numfact=?", array($numero, $bl));

        $qtiteinit=$qtiteiniti['quantite'];
        $pri=$qtiteiniti['pr'];

        $qtiteaug=$qtiteiniti['quantite']-$qtitesup;

        $prmoyen=$panier->espace(number_format(((($qtiteinit*$pri)-($prodcmd['quantite']*$prodcmd['pr']))/(($qtiteinit-$prodcmd['quantite']))),0,',','')); 

        $DB->insert("UPDATE `".$nomtabdep."` SET quantite = ?, prix_revient=? WHERE idprod= ?", array($qtiteaug, $prmoyen, $numero));

        $DB->delete('DELETE FROM stockmouv WHERE id = ?', array($id));

        $DB->delete('DELETE FROM achat WHERE id_produitfac=? and numfact=?', array($numero, $bl));?>

          <div class="alerteV">L'approvisionnement a été bien annulé</div><?php
      }

      if (isset($_POST['pv'])) {

        $idprod=$panier->h($_POST['idprod']);
        $pv=$panier->h($panier->espace($_POST['pv']));
        $fournisseur=$panier->h($_POST['fourni']);
        $cmd=$panier->h($_POST['bl']); 
        $idc=$panier->h($_POST['idc']); 

        $prodverif= $DB->querys("SELECT *FROM gestionchoixfournisseur WHERE idprod='{$idprod}' and fournisseur='{$fournisseur}' and cmd='{$cmd}' ");
        if (!empty($prodverif['id'])) {
            $DB->insert("UPDATE gestionchoixfournisseur SET pv='{$pv}' WHERE id='{$idc}' ");
            
        } else {
            $DB->insert('INSERT INTO gestionchoixfournisseur (idprod, pv, fournisseur, cmd, dateop) VALUES(?, ?, ?, ?, now())', array($idprod, $pv, $fournisseur, $cmd));                
        }

      }

      if (isset($_POST['validachat'])) {
        $idprod=$panier->h($_POST['idprod']);
        $pv=$panier->h($panier->espace($_POST['pv']));
        $qtite=$panier->h($panier->espace($_POST['qtite']));
        $fournisseur=$panier->h($_POST['fourni']);
        $cmd=$panier->h($_POST['bl']); 
        $idc=$panier->h($_POST['idc']); 
        $taux=$panier->h($panier->espace($_POST['taux']));
        $tauxgnf=$panier->h($panier->espace($_POST['tauxgnf']));
        $devise=$panier->h($_POST['devise']); 

        $prodverif= $DB->querys("SELECT *FROM gestionachatfournisseur WHERE idprod='{$idprod}' and cmd='{$cmd}' ");
        if (!empty($prodverif['id'])) {
          $DB->insert("UPDATE gestionachatfournisseur SET fournisseur='{$fournisseur}', pv='{$pv}', qtite='{$qtite}' , devise='{$devise}' , taux='{$taux}', tauxgnf='{$tauxgnf}' WHERE idprod='{$idprod}' and cmd='{$cmd}' ");
            
        } else {
          $DB->insert('INSERT INTO gestionachatfournisseur (idprod, qtite, pv, taux, tauxgnf, devise, fournisseur, cmd, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($idprod, $qtite, $pv, $taux, $tauxgnf, $devise, $fournisseur, $cmd));                
        }
        
        $DB->insert("UPDATE gestionselection SET quantite='{$qtite}' WHERE idprod='{$idprod}' and cmd='{$cmd}' ");
        ?>
        <div class="alert alert-success">Produit acheté avec sucèe!!!</div> <?php
      }
      if (isset($_GET['bl'])) {
        $_SESSION['bl']=$_GET['bl'];
      }
      $cols=sizeof($panier->listeStock());
      $colf=sizeof($panier->clientf('fournisseur', 'fournisseur'));
      $col=$cols+$colf;?>

      <div class="row">
        <div class="col-sm-12 col-md-12" style="overflow: auto;">
          <?php require "gestionportefeuille.php";?>
          <table class="table table-hover table-bordered table-striped text-center">
            <thead style="font-size:12px;">
            
              <tr>
                <th colspan=<?=$col+12;?>>
                  <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <form class="form" method="GET" action="gestionchoixfournisseur.php" id="suite" name="term">
                        <select name="categorie" id="" class="form-select" onchange="this.form.submit()">
                          <option value="">Recherchez par Catégorie</option><?php
                          for ($i=1; $i < 20; $i++) { 
                            $cat="Q".$i;?>
                            <option value="<?=$cat;?>"><?=$cat;?></option><?php
                          }?>
                        </select>
                      </form>
                    </div>
                    <div class="col">
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionselection.php?bl=<?=$_SESSION['bl'];?>&recette">Pré-Selection <?=strtoupper($_SESSION['bl']);?> </a>
                      <a class="btn btn-success fw-bold mx-1 text-white" href="?bl=<?=$_SESSION['bl'];?>&recette">Voir Selection</a>                  
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionpanierfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Panier</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Livraison</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport?bl=<?=$_SESSION['bl'];?>&recette">Départ Pays</a>
                    </div>
                  </div>
                </th>
              </tr>

                     

              <tr>
              <th>N°</th>
                <th>Cat</th>
                <th style="width:120px;">Référence</th><?php 
                foreach ($panier->listeStock() as $key => $value) {?>
                  <th><?=$value->nomstock;?></th><?php
                }?>
                <th>Dispo</th>
                <th>En-Cours</th> 
                <th>Total</th><?php 
                $type='fournisseur';
                foreach ($panier->clientf($type, $type) as $key => $value) {?>
                  <th><?=$value->nom_client;?></th><?php
                }?>                      
                <th>Fournisseur</th> 
                <th>qtite</th>
                <th>Prix GNF</th>
                <th>P.Revient(+8%)</th>
                <th>Total Revient</th>
                <th></th>
              </tr>

            </thead>               

            <tbody style="font-size:14px;">

              <?php
              $tot_achat=0;
              $tot_revient=0;
              $tot_vente=0;
              $qtiteR=0;
              $qtiteS=0;
              $type='en_gros';

              if (isset($_GET["categorie"]) and $_GET["categorie"]=="general"){
                $_SESSION['selectionChoix']='';
              }elseif (isset($_GET["categorie"])){
                $_SESSION['selectionChoix']=$_GET["categorie"];
              }else{
                if (!empty($_SESSION['selectionChoix'])) {
                  $_SESSION['selectionChoix']=$_SESSION['selectionChoix'];
                }else{
                  $_SESSION['selectionChoix']='';
                }

              }

              if (empty($_SESSION['selectionChoix'])) {

                if (isset($_GET["categorie"]) and $_GET["categorie"]!="general"){

                  $_GET["terme"] = htmlspecialchars($_GET["categorie"]); //pour sécuriser le formulaire contre les failles html
                  $terme = $_GET['terme'];
                  $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                  $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                  $_SESSION['selectionChoix']=$terme;

                  $products = $DB->query("SELECT idprod as id, Marque, quantite, pr, categorie, cmd FROM productslist inner join gestionselection on idprod=productslist.id WHERE categorie='{$terme}' and cmd='{$_SESSION['bl']}' ");
                }else{
                  $products = $DB->query("SELECT idprod as id, Marque, quantite, pr, categorie, cmd FROM productslist inner join gestionselection on idprod=productslist.id where cmd='{$_SESSION['bl']}' ");
                }
              }else{

                if (!empty($_SESSION['selectionChoix'])) {
                  
                  $products = $DB->query("SELECT idprod as id, Marque, quantite, pr, categorie, cmd FROM productslist inner join gestionselection on idprod=productslist.id WHERE categorie='{$_SESSION['selectionChoix']}' and cmd='{$_SESSION['bl']}' ");

                }else{

                  $products = $DB->query("SELECT idprod as id, Marque, quantite, pr, categorie, cmd FROM productslist inner join gestionselection on idprod=productslist.id where type='{$type}' and cmd='{$_SESSION['bl']}' order by(designation) LIMIT 50");
                }
              }
              

              if (!empty($products)) {

                foreach ($products as $key=> $product){
                  $qtites=0;
                  $pr=0; // a completer
                  foreach ($panier->listeStock() as $valueS) {

                    $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` where idprod='{$product->id}' ");
                      
                    $qtites+=$prodstock['qtite'];                            
                  }

                  $prodachat= $DB->querys("SELECT id FROM gestionachatfournisseur where idprod='{$product->id}' and cmd='{$_SESSION['bl']}' ");

                  if (!empty($prodachat['id'])) {
                    $color='success';
                  }else{
                    $color='';
                  }?>

                  <tr class="bg-<?=$color;?>">
                    <td class="pt-3"><?=$key+1;?></td>
                    <td class="pt-3" style="color:<?=$color;?>"><?= ucwords(strtolower($product->categorie)); ?></td>
                    <td class="pt-3" style="color:<?=$color;?>"><?= ucwords(strtolower($product->Marque)); ?></td><?php
                    foreach ($panier->listeStock() as $valuef) {
                      $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valuef->nombdd."` where idprod='{$product->id}' ");
                      $qtiteb=$prodstock['qtite']; ?> 
                      <td><?=number_format($qtiteb,0,',',' ');?></td><?php
                    }?>
                    <td class="bg-<?=$color;?> "><?=$qtites;?></td>
                    <td class="bg-<?=$color;?> "><?=$commande->orderInprogressById($product->id)['qtite'];?></td>
                    <td class="bg-<?=$color;?> "><?=$qtites+$commande->orderInprogressById($product->id)['qtite'];?></td><?php

                    foreach ($panier->clientf('fournisseur', 'fournisseur') as $valuef) {

                      $pv=$DB->querys("SELECT *FROM gestionchoixfournisseur WHERE fournisseur='{$valuef->id}' and idprod='{$product->id}' and  cmd='{$_SESSION['bl']}' ");                    ?> 

                      <form class="form" action="gestionchoixfournisseur.php" method="POST">                                

                        <td><input class="form-control" type="text" name="pv" value="<?=number_format($pv['pv'],0,',',' ');?>" onchange="this.form.submit()" /></td>
                        <input class="form-control" type="hidden" name="idprod"  value="<?=$product->id;?>" />
                        <input class="form-control" type="hidden" name="fourni" value="<?=$valuef->id;?>" />
                        <input class="form-control" type="hidden" name="bl" value="<?=$product->cmd;?>" />
                        <input class="form-control" type="hidden" name="idc" value="<?=$pv['id'];?>" />
                      
                      </form><?php 
                    }
                      
                    $pvmin=$DB->querys("SELECT min(pv) as pv, fournisseur FROM gestionchoixfournisseur WHERE idprod='{$product->id}' and  cmd='{$_SESSION['bl']}' group by pv "); ?>
                    <form action="gestionchoixfournisseur.php" method="POST" class="form" >
                      <input class="form-control" type="hidden" name="idprod"  value="<?=$product->id;?>" />
                      <input class="form-control" type="hidden" name="taux"  value="<?=$_SESSION['taux'];?>" />
                      <input class="form-control" type="hidden" name="tauxgnf"  value="<?=$_SESSION['taux1'];?>" />
                      <input class="form-control" type="hidden" name="devise"  value="<?=$_SESSION['devise'];?>" />
                      <input class="form-control" type="hidden" name="pv"  value="<?=$pvmin['pv'];?>" />
                      <input class="form-control" type="hidden" name="fourni" value="<?=$pvmin['fournisseur'];?>" />
                      <input class="form-control" type="hidden" name="bl" value="<?=$_SESSION['bl'];?>" />
                      <input class="form-control" type="hidden" name="idc" value="<?=$pv['id'];?>" />
                      <td class="bg-secondary text-white fw-bold bg-<?=$color;?> ">
                        <select class="form-select" name="fourni" required="">
                          <option value="<?=$pvmin['fournisseur'];?>"><?=$panier->nomClient($pvmin['fournisseur']);?></option><?php 
                          foreach ($panier->clientf('fournisseur', 'fournisseur') as $value) {?>
                            <option value="<?=$value->id;?>"><?=$panier->nomClient($value->id);?></option><?php 
                          }?>
                        </option>
                      </td>
                      <td><input class="form-control" type="text" name="qtite" value="<?=$product->quantite;?>" required="" min="0" placeholder="entrer la qtite" /> <?php

                      $prodgnf=$DB->querys("SELECT *FROM gestionachatfournisseur WHERE idprod='{$product->id}' and  cmd='{$_SESSION['bl']}' ");
                      if (!empty($prodgnf['id'])) {
                        $pvgnf=$prodgnf['pv']*$prodgnf['tauxgnf'];
                      }else{
                        if (!empty($_SESSION['taux1'])) {
                          $pvgnf=$pvmin['pv']*$_SESSION['taux1'];                          
                        }else{
                          $pvgnf=0;
                        }
                      }
                      $prgnf=$pvgnf*(1+(($panier->estimationpr)/100));
                      $prtot=$prgnf*$product->quantite; ?>

                      <td><?=number_format($pvgnf,0,',',' ');?></td>
                      <td><?=number_format($prgnf,0,',',' ');?></td>
                      <td><?=number_format($prtot,0,',',' ');?></td>
                      
                      <td class="bg-secondary text-white"><?php if(!empty($_SESSION['taux'])){?><button class="btn btn-primary" type="submit" name="validachat" onclick="return alerteV();">Ajouter</button><?php }?></td>
                    </form>                     
                  </tr><?php
                }
              }?>
            </tbody>

          </table>
        </div>
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