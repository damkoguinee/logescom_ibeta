<?php require 'headerv2.php';?>

<div class="container-fluid">

    <div class="row"><?php
      require 'navfournisseur.php';?>

      <div class="col-sm-12 col-md-10"><?php 
      
        if (isset($_POST['validap'])) {
          $idprod=$panier->h($_POST['idprod']);
          $qtite=$panier->h($panier->espace($_POST['qtite']));
          $pa=$panier->h($panier->espace($_POST['pa']));
          $taux=$panier->h($panier->espace($_POST['taux']));
          $tauxgnf=$panier->h($panier->espace($_POST['tauxgnf']));
          $transporteur=$panier->h($_POST['fourni']);
          $cmd=$panier->h($_POST['cmd']); 
          $idc=$panier->h($_POST['idc']); 

          $prodinit= $DB->querys("SELECT livre FROM gestiontransporteur WHERE id='{$idc}'");
          $livre=$prodinit['livre']+$qtite;

          $DB->insert("UPDATE gestiontransporteur SET livre='{$livre}' WHERE id='{$idc}' ");

          $DB->insert('INSERT INTO gestionreception (idprod, qtite, pv, taux, tauxgnf, client, cmd, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($idprod, $qtite, $pa, $taux, $tauxgnf, $transporteur, $cmd));  ?>

          <div class="alert alert-success">Produit transferé avec sucèe!!!</div> <?php
        }?>

        <div class="row">
          <div class="col-sm-12 col-md-12" style="overflow: auto;"><?php 
            require 'gestionportefeuille.php';?>
            <table class="table table-hover table-bordered table-striped table-responsive text-center">

              <form class="form" method="GET" action="gestiontransport.php" id="suite" name="term">

                <thead><?php 

                  if (isset($_GET['bl'])) {
                    $_SESSION['bl']=$_GET['bl'];
                  }?>

                  <tr>
                    <th colspan="8">
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionselection.php?bl=<?=$_SESSION['bl'];?>&recette">Pré-Selection</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionchoixfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Selection</a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionpanierfournisseur?bl=<?=$_SESSION['bl'];?>&recette">Panier  <?=strtoupper($_SESSION['bl']);?> </a>
                      <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionachatfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Livraison</a>
                      <a class="btn btn-success fw-bold mx-1 text-white" href="?bl=<?=$_SESSION['bl'];?>&recette">Départ Pays</a> 
                    </th>
                  </tr>

                  <tr>

                    <th colspan="8">
                      <input class="form-control" type = "search" name = "terme" placeholder="rechercher un produit" onchange="this.form.submit()"/>
                    </th>
                  </tr>
        

                  <tr>
                    <th>N°</th>
                    <th>Cmd</th>
                    <th>Référence</th>
                    <th>Transporteur</th>
                    <th>Transf/Qtité</th>
                    <th>Qtité transf</th>
                    <th></th>  
                  </tr>

                </thead>
              </form>

            <tbody>

              <?php
              $tot_achat=0;
              $tot_revient=0;
              $tot_vente=0;
              $qtiteR=0;
              $qtiteS=0;

              if (!isset($_GET['termeliste'])) {

                if (isset($_GET['terme'])) {

                  if (isset($_GET["terme"])){

                      $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                      $terme = $_GET['terme'];
                      $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                      $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                      $_SESSION['terme']=$terme;
                  }

                  if (isset($terme)){

                      $terme = strtolower($terme);
                      $products = $DB->query("SELECT gestiontransporteur.id as idc, idprod, designation, Marque, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestiontransporteur inner join productslist on productslist.id=idprod WHERE codeb LIKE ? OR Marque LIKE ? OR Marque LIKE ? order by(Marque)",array($terme, "%".$terme."%", "%".$terme."%"));
                  }else{

                    $message = "Vous devez entrer votre requete dans la barre de recherche";

                  }

                  if (empty($products)) {?>

                    <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

                  }

                }else{

                  if (!empty($_SESSION['terme'])) {
                    
                    $products = $DB->query("SELECT gestiontransporteur.id as idc, idprod, designation, Marque, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestiontransporteur inner join productslist on productslist.id=idprod WHERE codeb LIKE ? OR Marque LIKE ? OR Marque LIKE ? order by(designation)",array($_SESSION['terme'], "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

                  }else{

                    $products = $DB->query("SELECT gestiontransporteur.id as idc, idprod, designation, Marque, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestiontransporteur inner join productslist on productslist.id=idprod order by(Marque) LIMIT 50");
                  }
                }
              }else{

                  $products = $DB->query("SELECT gestiontransporteur.id as idc, idprod, designation, client, qtite, pv, taux, tauxgnf, cmd, dateop, livre FROM gestiontransporteur inner join productslist on productslist.id=idprod WHERE id= ? order by(Marque)",array($_GET['termeliste']));
              }

              if (!empty($products)) {

                foreach ($products as $key=> $product){
                  $reste=($product->qtite-$product->livre);
                  if ($reste==0) {
                    $bg='success';
                  }elseif($product->livre!=0){
                    $bg='warning';
                  } else {
                    $bg='danger';
                  }
                  
                  $color='';?>

                  <tr>
                    <td class="bg-<?=$bg;?>"><?=$key+1;?></td> 
                    <td class="bg-<?=$bg;?>"><?=(new DateTime($product->dateop))->format("d/m/Y");?></td>

                    <form class="form bg-<?=$bg;?>" action="gestiontransport.php" method="POST">
                      <td class="bg-<?=$bg;?>"><?=$product->cmd; ?>
                      <td class="bg-<?=$bg;?>"><?= ucwords(strtolower($product->Marque)); ?>
                        <input class="form-control" type="hidden" name="idprod" value="<?=$product->idprod; ?>"/>
                        <input class="form-control" type="hidden" name="cmd" value="<?=$product->cmd; ?>"/>
                        <input class="form-control" type="hidden" name="fourni" value="<?=$product->client; ?>"/>
                        <input class="form-control" type="hidden" name="pa" value="<?=$product->pv; ?>"/>
                        <input class="form-control" type="hidden" name="taux" value="<?=$product->taux; ?>"/>
                        <input class="form-control" type="hidden" name="tauxgnf" value="<?=$product->tauxgnf; ?>"/>
                        <input class="form-control" type="hidden" name="idc" value="<?=$product->idc; ?>"/>
                      </td>
                      <td class="bg-<?=$bg;?>"><?=$panier->nomClient($product->client); ?></td>
                      <td class="bg-<?=$bg;?>"><?= $product->livre; ?> / <?= $product->qtite; ?></td><?php 
                      if ($reste!=0) {?>
                        <td class="bg-<?=$bg;?>"><input type="number"  name="qtite" min="0" max="<?=$reste;?>" required class="form-control"></td>

                        <td class="bg-<?=$bg;?>"><button class="btn btn-primary" type="submit" name="validap" onclick="return alerteT();">Confirmer le départ</button></td><?php
                      } else {?>
                        <td class="bg-<?=$bg;?>">clos</td>
                        <td class="bg-<?=$bg;?>">clos</td><?php
                      }?>
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