<?php require 'headerv2.php';?>

<div class="container-fluid">

  <div class="row"><?php
    //require 'navfournisseur.php';?>

    <div class="col-sm-12 col-md-12">

      <script>
        function suivant(enCours, suivant, limite){
          if (enCours.value.length >= limite)
          document.term[suivant].focus();
        }
      </script><?php

      if (isset($_POST['validap'])) {
        $idprod=$panier->h($_POST['idprod']);
        $pr=$panier->h($panier->espace($_POST['pr']));
        $qtite=$panier->h($panier->espace($_POST['qtite']));
        $cmd=$panier->h($_POST['cmd']); 
        $categorie=$panier->h($_POST['cat']); 

        $prodverif= $DB->querys("SELECT *FROM gestionselection WHERE idprod='{$idprod}' and cmd='{$cmd}' ");
        if (!empty($prodverif['id'])) {
          $DB->insert("UPDATE gestionselection SET pr='{$pr}', quantite='{$qtite}' , categorie='{$categorie}' WHERE idprod='{$idprod}' and cmd='{$cmd}' ");
            
        } else {
          $DB->insert('INSERT INTO gestionselection (idprod, quantite, pr, categorie, cmd, dateop) VALUES(?, ?, ?, ?, ?, now())', array($idprod, $qtite, $pr, $categorie, $cmd));                
        }?>
        <div class="alert alert-success">Produit selectionné avec sucèe!!!</div> <?php
      }?>
      <div class="row">
        <div class="col-sm-12 col-md-12" style="overflow: auto;">
          <table class="table table-hover table-bordered table-striped text-center">
            <thead><?php 
              $col=sizeof($panier->listeStock());

              if (isset($_GET['bl'])) {
                $_SESSION['bl']=$_GET['bl'];
              }?>

              <tr>
                <th colspan=<?=$col+10;?>>
                  
                  <a class="btn btn-success fw-bold mx-1 text-white" href="?bl=<?=$_SESSION['bl'];?>&recette">Pré-Selection <?=strtoupper($_SESSION['bl']);?> </a>
                  <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionchoixfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Selection</a>                  
                  <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionpanierfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Panier</a>
                  <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Livraison</a>
                  <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport?bl=<?=$_SESSION['bl'];?>&recette">Départ Pays</a>
                </th>
              </tr>

              <tr>
                <!-- <th colspan=<?=$col+3;?>>
                  <form class="form" method="GET" action="gestionselection.php" >
                    <select name="categorie" id="" class="form-select" onchange="this.form.submit()">
                      <option value="">Recherchez par Catégorie</option><?php
                      // foreach ($panier->recherchestock() as $key => $value) {?>
                      //   <option value="<?=$value->id;?>"><?=$panier->nomCategorie($value->id);?></option><?php
                      // }?>
                    </select>
                  </form>
                </th> -->
                <th colspan=<?=$col+10;?>>
                  <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <form class="form" method="GET" action="gestionselection.php">
                        <input class="form-control" type= "search" name="terme" placeholder="rechercher un produit" onchange="this.form.submit()"/>
                      </form>
                    </div>
                    <div class="col-sm-6 col-md-8">
                      <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                        <input onclick="return checkBox()" type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck1">Categorie</label>

                        <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck2">Boutique</label>

                        <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck3">Dispo</label>
                      </div>
                    </div>
                  </div>
                </th>
              </tr>        

              <tr>
                <th>N°</th>
                <th class="classCat1">Cat</th>
                <th>Référence</th><?php 
                foreach ($panier->listeStock() as $key => $value) {?>
                  <th><?=$value->nomstock;?></th><?php
                }?>
                <th>Dispo</th>
                <th>En-Cours</th> 
                <th>Total</th>
                <th>Qtite</th>
                <th>P.Revient</th>
                <th>Catégorie</th>
                <th colspan="1"></th>  
              </tr>

            </thead>               

            <tbody>

              <?php
              $tot_achat=0;
              $tot_revient=0;
              $tot_vente=0;
              $qtiteR=0;
              $qtiteS=0;
              $type='en_gros';

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
                      $products = $DB->query("SELECT productslist.id as id, designation, Marque, codecat FROM productslist inner join categorie on categorie.id=codecat WHERE type LIKE ? and (codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? OR nom LIKE ?) order by(Marque)",array($type, $terme, "%".$terme."%", "%".$terme."%", "%".$_SESSION['terme']."%"));
                  }else{

                  $message = "Vous devez entrer votre requete dans la barre de recherche";

                  }

                  if (empty($products)) {?>

                    <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

                  }

                }else{

                  if (!empty($_SESSION['terme'])) {
                    
                    $products = $DB->query("SELECT productslist.id as id, designation, Marque, codecat FROM productslist inner join categorie on categorie.id=codecat WHERE type LIKE ? and (codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? OR nom LIKE ?) order by(designation)",array($type, $_SESSION['terme'], "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

                  }else{

                    $products = $DB->query("SELECT productslist.id as id, designation, Marque, codecat FROM productslist where type='{$type}' order by(Marque) ");
                  }
                }
              }else{

                $products = $DB->query("SELECT productslist.id as id, designation, Marque, codecat FROM productslist WHERE id='{$_GET['termeliste']}' and type='{$type}' order by(Marque)");
              }

              if (!empty($products)) {

                foreach ($products as $key=> $product){
                  $qtites=0;
                  $pr=0; // a completer
                  foreach ($panier->listeStock() as $valueS) {

                    $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` where idprod='{$product->id}' ");
                      
                    $qtites+=$prodstock['qtite'];                            
                  }
                  $color="";?>
                  <form action="gestionselection.php" method="POST" class="form">

                    <tr class="bg-<?=$color;?>">
                      <td class="pt-3"><?=$key+1;?></td>
                      <td class="classCat2" class="pt-3"><?=$panier->nomCategorie($product->codecat);?></td>
                      <td class="pt-3" style="color:<?=$color;?>"><?= ucwords(strtolower($product->Marque)); ?></td><?php
                      foreach ($panier->listeStock() as $valuef) {
                        $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valuef->nombdd."` where idprod='{$product->id}' ");
                        $qtiteb=$prodstock['qtite']; ?> 
                        <td><?=number_format($qtiteb,0,',',' ');?></td><?php
                      }?>
                      <td class="bg-<?=$color;?> "><?=$qtites;?></td>
                      <td class="bg-<?=$color;?> "><?=$commande->orderInprogressById($product->id)['qtite'];?></td>
                      <td class="bg-<?=$color;?> "><?=$qtites+$commande->orderInprogressById($product->id)['qtite'];?></td>
                      <td class="bg-<?=$color;?> ">
                        <input class="form-control" type="hidden" name="idprod"  value="<?=$product->id;?>" />
                        <input class="form-control" type="hidden" name="cmd" value="<?=$_SESSION['bl'];?>" />
                        <input type="number" name="qtite" min="0" required  class="form-control">
                      </td>
                      <td><input type="text" name="pr" value="<?=number_format($pr,0,',',' ');?>" min="0" required  class="form-control"></td>
                      <td class="bg-<?=$color;?> ">
                        <select name="cat" id="" required class="form-select">
                          <option value=""></option><?php 
                          for ($i=1; $i < 20; $i++) { 
                            $cat="Q".$i;?>
                            <option value="<?=$cat;?>"><?=$cat;?></option><?php
                          }?>
                          
                        </select>
                      </td>
                      <td><button class="btn btn-primary" type="submit" name="validap" onclick="return alerteV();">Ajouter</button></td>
                    </tr>
                  </form><?php
                }
              }?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="js/script.js"></script>
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


    function checkBox() {
      let categorie= document.querySelector("#btncheck1").checked;
      let classCat1= document.querySelector(".classCat1");
      let classCat2= document.querySelector(".classCat2");
      if (categorie=== true) {
        classCat1.style.display="none";
        classCat2.style.display="none";
      }else{
        classCat1.style.display="block";
        classCat2.style.display="block";
      }
    }

</script>  