<?php require 'headerv2.php';?>

<div class="container-fluid"> 

  <div class="row"><?php 
    
    require 'navstock.php';?> 

    <div class="col-sm-12 col-md-10" style="overflow: auto; height:90vh;"> <?php 

      if (isset($_POST['design'])) {
        $_SESSION['design']=$_POST['design'];
        
      }else{
        if (isset($_POST['designinp'])) {
          $_SESSION['designinp']=$_POST['designinp'];
          
        }else{
          $_SESSION['designinp']=$_SESSION['designinp'];
          
        }
      }

      if (isset($_GET['op_inv'])) {
        $_SESSION['op_inv']=$_GET['op_inv'];

      }

      
      if (isset($_GET['nomstock'])) {
        
        $nomstock=$_GET['nomstock'];
        $_SESSION['idnomstock']=$_GET['nomstock'];
        
      }elseif (isset($_GET['stockgeneral'])) {        
        $nomstock=$_GET['stockgeneral'];    
        $_SESSION['nomstock']=$nomstock;
        $_SESSION['idnomstock']=0;
      }
      if (isset($_GET['nomstock']) and $_GET['nomstock']!=0) {

        $_SESSION['nomtab_inv']=$panier->nomStock($_SESSION['idnomstock'])[1];

      }

      if (isset($_POST['boutique_select']) and $_POST['boutique_select']!="general") {
        $_SESSION['nomtab_inv']=$panier->nomStock($_POST['boutique_select'])[1];
        $_SESSION['nomboutique']=$panier->nomStock($_POST['boutique_select'])[0];

      }elseif(!empty($_SESSION['nomtab_inv'])){
        $_SESSION['nomtab_inv']=$_SESSION['nomtab_inv'];
      }else{
        $_SESSION['nomtab_inv']=$panier->nomStock($_SESSION['lieuvente'])[1];
        $_SESSION['nomboutique']=$panier->nomStock($_SESSION['lieuvente'])[0];
      }

      

      if (isset($_POST['idprod_inv_saisie'])) {
        $nombdd=$panier->espace($_POST['nombdd']);
        $idbdd=$panier->espace($_POST['idbdd']);
        $idprod=$panier->espace($_POST['idprod_inv_saisie']);
        $qtite=$panier->espace($_POST['qtite']);
        $qtiteinit=$panier->espace($_POST['qtiteinit']);
        $balance=$qtite-$qtiteinit;
        $prodverif= $DB->querys("SELECT *FROM inventaire  WHERE id_prod_inv='{$idprod}' and stock_inv='{$idbdd}' and num_inv='{$_SESSION['op_inv']}' ");
        if (empty($prodverif['id'])) {
          $DB->insert("INSERT INTO inventaire (num_inv, id_prod_inv, qtite_init, qtite_inv, balance_inv, stock_inv, idpers_inv, coment_inv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($_SESSION['op_inv'], $idprod, $qtiteinit, $qtite, $balance, $idbdd, $_SESSION['idpseudo'], "anomalie inventaire"));
        }else{
          $DB->delete("DELETE from inventaire where id_prod_inv='{$idprod}' and stock_inv='{$idbdd}' and num_inv='{$_SESSION['op_inv']}' ");
          $DB->insert("INSERT INTO inventaire (num_inv, id_prod_inv, qtite_init, qtite_inv, balance_inv, stock_inv, idpers_inv, coment_inv) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($_SESSION['op_inv'], $idprod, $qtiteinit, $qtite, $balance, $idbdd, $_SESSION['idpseudo'], "anomalie inventaire"));
        }
        //$DB->insert("UPDATE `".$nombdd."` SET quantite= ? WHERE idprod = ?", array( $qtite, $_POST['id']));
        
      }?>

      <table class="table table-hover table-bordered table-striped table-responsive text-center">          
        <thead class="sticky-top bg-danger">                     
          <tr>
            <th colspan="10" >
              
                <!-- <form action="" method="POST">
                  <select class="form-select mx-1" type="text" name="boutique_select" onchange="this.form.submit()" ><?php 
                    if (!empty($_SESSION['nomtab_inv'])) {?>
                      <option value="<?=$_SESSION['nomtab_inv'];?>">Inventaire <?=$_SESSION['nomboutique'];?></option><?php
                    }else{?>
                      <option>Selectionnez</option><?php
                    }

                    foreach($caisse->nomBoutiqueByLieu() as $value){?>
                      <option value="<?=$value->id;?>"><?=$value->nomstock;?></option><?php
                    }?>
                    <option value="general">Général</option>
                  </select>
                </form> -->

                <div class="d-flex justify-content-between">

                  <div class="bg-info p-2">Tableau d'inventaire</div>

                  <form class="form row" action="" method="POST">
                    <select class="form-select mx-1" type="text" name="design" onchange="this.form.submit()" ><?php 
                      if (!empty($_SESSION['design'])) {?>
                        <option value="<?=$_SESSION['design'];?>"><?=$panier->nomCategorie($_SESSION['design'])?></option><?php
                      }else{?>
                        <option></option><?php
                      }

                      foreach($panier->recherchestock() as $value){?>
                        <option value="<?=$value->id;?>"><?=$value->nom;?></option><?php
                      }?>
                    </select>
                  </form>
                  <form class="form row" action="" method="POST">
                    <input class="form-control" type="text" name="designinp" onchange="this.form.submit()" >
                  </form>
                  <a href="inventaire_traitement.php?toutregler&id_inv=<?=$_SESSION['op_inv'];?>" class="btn btn-danger" onclick="return alerteAction();">Tout Régler</a>
                </div>

              </div>
            </th>
          </tr>

          <tr>
            <th></th>
            <th>MVP</th>
            <th>Catégorie</th>
            <th>Référence</th>
            <th>Qtité total</th><?php 
            foreach ($caisse->listeStockLieuvente() as $key => $valuec) {?>
              <th><?=$valuec->nomstock;?></th>
              <?php 
            }?>
            <th>Balance</th>  
            <th>Ajustement</th>  
          </tr>

          </thead>

        <tbody>

          <?php
          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0;

            if (isset($_POST['design'])) {
              $productst = $DB->query("SELECT * FROM productslist where codecat='{$_SESSION['design']}' ORDER BY (designation)");
            }else{
              if (!empty($_SESSION['designinp'])) {
  
                $productst = $DB->query("SELECT *FROM productslist where designation LIKE ? or Marque LIKE ? ORDER BY (designation)", array("%".$_SESSION['designinp']."%", "%".$_SESSION['designinp']."%"));
              }else{
  
                $productst = $DB->query("SELECT *FROM productslist ORDER BY (designation) ");
              }
            }
          

          

          foreach ($productst as $key=> $product):
            
            $qtites=0;
            foreach ($caisse->listeStockLieuvente() as $valueS) {
              $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` where idprod='{$product->id}' ");                
              $qtites+=$prodstock['qtite'];                            
            }?>

            <tr>
              <td><?=$key+1;?></td>
              <td class="text-start"><a href="stockmouv.php?desig=<?=$product->id;?>" class="btn btn-success">MVP</a></td>
              <td class="text-start"><?= ucwords(strtolower($caisse->nomCategorie($product->codecat)['nom'])); ?></td>
              <td class="text-start"><?= ucwords(strtolower($product->Marque)); ?></td>
            
              <td style="text-align: center;"><?= $qtites; ?></td><?php
              foreach ($caisse->listeStockLieuvente() as $valuef) {
                $prodinv= $DB->querys("SELECT *FROM inventaire  WHERE id_prod_inv='{$product->id}' and stock_inv='{$valuef->id}' and num_inv='{$_SESSION['op_inv']}' ");
                
                $qtiteinv=$prodinv['qtite_inv'];
                $etat=$prodinv['etat_inv']; ?>
                <form action="" method="POST"><?php 
                  $prodstock = $DB->querys("SELECT quantite as qtite FROM `".$valuef->nombdd."` where idprod='{$product->id}' ");
                  $qtiteb=$prodstock['qtite']; ?> 
                  <td><?php 
                    if ($etat != "ok") {?>
                      <input class="form-control text-end" type="text" name="qtite" placeholder="<?= $qtiteb." - ".$qtiteinv; ?>" onchange="this.form.submit()"><?php 
                    }else{?>
                      <?= $qtiteb." - ".$qtiteinv; 

                    }?>

                  </td>

                  <input type="hidden" name="idprod_inv_saisie" value="<?= $product->id; ?>">
                  <input type="hidden" name="nombdd" value="<?= $valuef->nombdd; ?>">
                  <input type="hidden" name="idbdd" value="<?= $valuef->id; ?>">
                  <input type="hidden" name="qtiteinit" value="<?= $qtiteb; ?>">
                </form><?php
              }
              $prodbalance = $DB->querys("SELECT sum(balance_inv) as balance, etat_inv as etat FROM inventaire  WHERE id_prod_inv='{$product->id}' and num_inv='{$_SESSION['op_inv']}' ");
              $balance=$prodbalance['balance'];
              $etat=$prodbalance['etat']; ?>
              <td><?= $balance; ?></td>
              <td><?php 
                if ($etat == "ok") {
                  ?>
                  <a href="inventaire_traitement.php?annuler_ajuster&idprod_ajust=<?=$product->id;?>&id_inv=<?=$_SESSION['op_inv'];?>" class="btn btn-warning" onclick="return alerteAction();">Annuler</a><?php
                }else{?>
                  <a href="inventaire_traitement.php?ajuster&idprod_ajust=<?=$product->id;?>&id_inv=<?=$_SESSION['op_inv'];?>" class="btn btn-danger" onclick="return alerteAction();">Régler</a><?php

                }?>
              </td>
            </tr>
              
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div> 
</div><?php 
require "footer.php" ; ?>


<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?stockgeneral',
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
      return(confirm('Attention, vous êtes sur le point de supprimer un produit!!! Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteAction(){
        return(confirm('Confirmez-vous cette action ?'));
    }

</script> 