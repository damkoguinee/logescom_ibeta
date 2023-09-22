<?php require 'headerv2.php';?>
<div class="container-fluid mt-3">
  <div class="row"><?php 
    require 'navstock.php';?>

    <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
      if (isset($_POST['qtiter'])) {

        $nomtab1=$panier->nomStock($_POST['departs'])[1];

        $idstock1=$panier->nomStock($_POST['departs'])[2];

        $nomtab2=$panier->nomStock($_POST['departr'])[1];

        $idstock2=$panier->nomStock($_POST['departr'])[2];

        $id=$panier->h($_POST['id']);

        $qtite=$panier->h($_POST['qtiter']);

        $depart = $DB->querys("SELECT quantite as qtite FROM `".$nomtab1."` WHERE idprod=?", array($id));

        $qtited=$depart['qtite']-$qtite;

        $DB->insert("UPDATE `".$nomtab1."` SET quantite= ? WHERE idprod = ?", array($qtited, $id));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'sortie', -$qtite, $idstock1));


        $reception = $DB->querys("SELECT quantite as qtite FROM `".$nomtab2."` WHERE idprod=?", array($id));

        $qtiter=$reception['qtite']+$qtite;

        $DB->insert("UPDATE `".$nomtab2."` SET quantite= ? WHERE idprod = ?", array($qtiter, $id));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'transp', 'entree', $qtite, $idstock2));

        $DB->insert('INSERT INTO transferprod (idprod, stockdep, quantitemouv, stockrecep, exect, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, $idstock1, $qtite, $idstock2, $_SESSION['idpseudo']));

      }

      if (isset($_POST['qtiteap'])) {

        $nomtab1=$panier->nomStock($_POST['departap'])[1];

        $idstock1=$panier->nomStock($_POST['departap'])[2];

        $id=$panier->h($_POST['idap']);

        $qtite=$panier->h($_POST['qtiteap']);

        $depart = $DB->querys("SELECT quantite as qtite FROM `".$nomtab1."` WHERE idprod=?", array($id));

        $qtited=$depart['qtite']+$qtite;

        $DB->insert("UPDATE `".$nomtab1."` SET quantite= ? WHERE idprod = ?", array($qtited, $id));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($id, 'trans', 'entree', $qtite, $idstock1));

      }?>

      <table class="table table-hover table-bordered table-striped table-responsive text-center">
        <form class="form" method="GET" action="commandetrans.php" id="suite">

          <thead>

            <tr>
              <th colspan="6">
                <div class="row">
                  <div class="col-6">
                    <input class="form-control" type = "search" name = "terme" placeholder="rechercher un produit" onKeyUp="suivant(this,'s', 10)" onchange="document.getElementById('suite').submit()"/>
                  </div>
                  <div class="col-6">
                    <input class="form-control"  id="search-user" type="text" name="client" placeholder="rechercher dans une liste" />
                    <div class="bg-danger" id="result-search"></div>
                  </div>
              </th>
            </tr>       

            <tr>
              <th>N°</th>
              <th>Reference</th>        
              <th>Magasin de Retraît</th>
              <th>Qtite Transférer</th>
              <th>Magasin de Réception</th>
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
          $type="en_gros";
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
                $type="en_gros";
                $terme = strtolower($terme);
                $products = $DB->query("SELECT * FROM productslist WHERE (designation LIKE ? OR Marque LIKE ?) and type LIKE ? order by(Marque)",array("%".$terme."%", "%".$terme."%", $type));
              }else{

              $message = "Vous devez entrer votre requete dans la barre de recherche";

              }

              if (empty($products)) {?>

                <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

              }

            }else{

              if (!empty($_SESSION['terme'])) {
                
                $products = $DB->query("SELECT * FROM productslist WHERE (designation LIKE ? OR Marque LIKE ?) and type LIKE ? order by(Marque)",array("%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%", $type));

              }else{

                $products = $DB->query("SELECT * FROM productslist where type='{$type}' order by(Marque) LIMIT 50");
              }
            }
          }else{

            $products = $DB->query("SELECT * FROM productslist WHERE id='{$_GET['termeliste']}' and type='{$type}' order by(Marque)");
          }

          if (!empty($products)) {

            foreach ($products as $key=> $product){

              if ($product->type=='paquet') {
                $color='green';
              }elseif ($product->type=='detail') {
                $color='blue';
              }else{
                $color='';
              }?>

              <tr>
                <td><?=$key+1;?></td>  

                <td><?= ucwords(strtolower($product->Marque)); ?></td>

                <form action="commandetrans.php" method="POST">

                  <td>
                    <select class="form-select" name="departs" required="">
                      <option></option><?php 

                      if ($_SESSION['level']>6) {                 

                        foreach ($panier->listeStock() as $value) {

                          $reststock=$DB->querys("SELECT quantite as qtite FROM `".$value->nombdd."` WHERE idprod='{$product->id}'");

                            if (!empty($reststock['qtite'])) {?>

                              <option value="<?=$value->id;?>"><?=$value->nomstock.' dispo '.$reststock['qtite'];?></option><?php
                            }
                        }
                      }else{

                        foreach ($panier->listeStockzone() as $value) {

                          $reststock=$DB->querys("SELECT quantite as qtite FROM `".$value->nombdd."` WHERE idprod='{$product->id}'");

                            if (!empty($reststock['qtite'])) {?>

                              <option value="<?=$value->id;?>"><?=$value->nomstock.' dispo '.$reststock['qtite'];?></option><?php
                            }
                        }

                      }?>
                    </select>
                  </td>

                  <td><input class="form-control" type="number" name="qtiter" min="0"/><input class="form-control" type="hidden" name="id" value="<?=$product->id;?>"></td>

                  <td>
                    <select class="form-select" name="departr" required="">
                      <option></option><?php 

                      foreach ($panier->listeStock() as $value) {?>

                        <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php
                      }?>
                    </select>
                  </td>

                  <td><button class="btn btn-success" type="submit" name="valids" onclick="return alerteT();" >Déplacer</button></td>

                </form>


              </tr><?php
            }
          }?>


        </tbody>

      </table>    
    </div>
  </div>
</div>
  <?php require 'footer.php';?> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?transfert',
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