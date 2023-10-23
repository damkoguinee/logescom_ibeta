<?php
require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  if ($_SESSION['level']>=3) {

    if(isset($_GET["delete"])){

      $numero=$_GET["delete"];

      $DB->delete("DELETE FROM categorie WHERE id = ?", array($numero));
    }

    if(isset($_POST["id"])){

      $numero=$panier->h($_POST['id']);
      $nom=$panier->h($_POST['nom']);
      $DB->insert("UPDATE categorie SET nom= ? WHERE id = ?", array($nom, $numero)); 
    }?>

    <div class="container-fluid">
      <div class="row">
        
        <?php require 'navstock.php';?>

        <div class="col-sm-12 col-md-10 my-1"><?php 

          $prodm=$DB->query("SELECT *from categorie order by(nom)");?>
            
          <table class="table table-hover table-bordered table-striped table-responsive text-center">

            <thead>
              <tr>                
                <th colspan="5">
                  <div class="d-flex justify-content-between">
                    Liste des Catégories
                    <a class="btn btn-warning" href="ajout.php?categ">Ajouter une Catégroie</a>
                  </div>
                </th>
              </tr>

              <tr>
                <th>N°</th>
                <th>Désignation</th>
                <th>Montant Total</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody><?php

              if (empty($prodm)) {
                # code...
              }else{
                $cumultranche=0;
                foreach ($prodm as $key=> $formation) {

                  $prodverif=$DB->querys("SELECT *from categorie inner join productslist on codecat=categorie.id inner join commande on productslist.id=id_produit where categorie.id='{$formation->id}'"); ?>
                  <tr>
                    <td style="text-align: center;"><?=$key+1;?></td>
                    <form class="form" method="POST" action="categorie.php">
                      <td><input class="form-control" type="text" name="nom" value="<?=ucwords(strtolower($formation->nom));?>"/><input class="form-control" type="hidden" name="id" value="<?=$formation->id;?>"></td>
                      <td class="text-end"><?=$configuration->formatNombre($caisse->montantStockByCategorie($formation->id));?></td>
                      <td><button class="btn btn-warning" type="submit" name="update">Modifier</button></td>
                    </form>
                    <td colspan="1">
                      <?php if ($products['statut']=='admin' and empty($prodverif['id'])) {?>                        
                        <a class="btn btn-danger" href="categorie.php?delete=<?=$formation->id;?>" onclick="return alerteS();">Supprimer</a><?php 
                      }?>
                    </td>
                  </tr><?php
                }

              }?>          
            </tbody>
          </table>
        </div>
      </div>
    </div><?php

  }else{?>

    <div class="alertes">VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES</div><?php
  }

}else{

}?>

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
</body>

</html>
