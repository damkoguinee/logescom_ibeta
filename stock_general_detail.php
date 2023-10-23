<?php require 'headerv2.php';?>

<div class="container-fluid"> 

  <div class="row"><?php 
    
   // require 'navstock.php';?> 

    <div class="col-sm-12 col-md-12" style="overflow: auto; height:90vh;"> <?php 

      if (isset($_POST['design'])) {
        $_SESSION['design']=$_POST['design'];

      }elseif(!empty($_SESSION['design'])){

        $_SESSION['design']=$_SESSION['design'];

      }else{
        $_SESSION['design']='';
      }

      if (isset($_POST['designinp'])) {
        $_SESSION['designinp']=$_POST['designinp'];

      }elseif(!empty($_SESSION['designinp'])){
        $_SESSION['designinp']=$_SESSION['designinp'];
      }else{
        $_SESSION['designinp']='';
      }

      if (isset($_GET['nomstock'])) {
        unset($_SESSION['design']);
        unset($_SESSION['designinp']);

      }

      $_SESSION['nomtab']=$panier->nomStock($_SESSION['lieuvente'])[1];

      if (isset($_POST['id'])) {
        $pa=$panier->espace($_POST['pa']);
        $pr=$panier->espace($_POST['pr']);
        $pv=$panier->espace($_POST['pv']);
        $perime=$_POST['perime'];
        if (empty($perime)) {
          $DB->insert("UPDATE `".$_SESSION['nomtab']."` SET prix_achat=?, prix_revient=?, prix_vente= ?, quantite= ? WHERE id = ?", array($pa,  $pr, $pv, $_POST['qtite'], $_POST['id']));
        }else{
           $DB->insert("UPDATE `".$_SESSION['nomtab']."` SET prix_achat=?, prix_revient=?, prix_vente= ?, quantite= ?, dateperemtion=? WHERE id = ?", array($pa,  $pr, $pv, $_POST['qtite'], $perime, $_POST['id']));
        }
      }?>

      <table class="table table-hover table-bordered table-striped table-responsive text-center" style="width:140vw;">          
        <thead class="sticky-top bg-danger">            
          <tr>
            <th colspan="19" ><?php 
              if (isset($_GET['recherchgen'])) {?>
                <table class="table table-hover table-bordered table-striped table-responsive text-center" style="width:100vw;">
                  <tbody>
                    <tr>
                      <td class="bg-success bg-opacity-50 text-white">Qtité Restante</td>
                      <td class="bg-success bg-opacity-50 text-white"><?=$caisse->qtiteLieuventeProduit($_GET['recherchgen']);?></td>

                      <td class="bg-secondary bg-opacity-50 ">Nbre Vente</td>
                      <td class="bg-secondary bg-opacity-50 "><?=$caisse->nbreVenteProduit($_GET['recherchgen'])['nbre'];?></td>

                      <td class="bg-secondary bg-opacity-25 ">Nbre Entré</td>
                      <td class="bg-secondary bg-opacity-25 "><?=$commande->nbreCmdRecuByIdprodByBoutique($_GET['recherchgen'], $_SESSION['lieuvente'], "recepfinterne")['qtite']+$commande->nbreCmdRecuByIdprodByBoutique($_GET['recherchgen'], $_SESSION['lieuvente'], "recepfcmd")['qtite'];?></td>
                    </tr>

                    <tr>
                      <td class="bg-primary bg-opacity-50 text-white">P-Revient</td>
                      <td class="bg-primary bg-opacity-50 text-white"><?=$configuration->formatNombre($caisse->infoProduitStock($_SESSION['nomtab'], $_GET['recherchgen'])['prix_revient']);?></td>
                      
                      <td class="bg-danger bg-opacity-25 ">Anomalie</td>
                      <td class="bg-danger bg-opacity-25 ">0</td>

                      <td class="bg-success-subtle bg-opacity-50 ">cmd</td>
                      <td class="bg-success-subtle bg-opacity-50 "><?=$commande->nbreCmdConfirmeByIdprod($_GET['recherchgen'])['nbre'];?></td>
                    </tr>

                    <tr>
                      <td class="bg-light bg-opacity-50 ">P-AED</td>
                      <td class="bg-light bg-opacity-50 "><?= $configuration->formatNombre($commande->dernierPrixAchatCmd($_GET['recherchgen'])['pv']); ?></td>
                      
                      <td class="bg-info bg-opacity-25">P-Vente</td>
                      <td class="bg-info bg-opacity-25" colspan="3"><?=$configuration->formatNombre($caisse->infoProduitStock($_SESSION['nomtab'], $_GET['recherchgen'])['prix_vente']);?></td>
                    </tr>
                  </tbody>
                </table><?php
              }?>

              <form class="d-flex justify-content-between" action="" method="POST">
              <a class="btn btn-info text-center fw-bold" href="stockgeneral.php"><i class="fa-solid fa-backward"></i></a>
                <div class="col-sm-6 col-md-4"><?php 
                  if (isset($_GET['recherchgen'])) {?>
                    <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="<?=$caisse->nomProduit($_GET['recherchgen'])['Marque'];?>" /><?php 
                  }else{?>
                    <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un produit" /><?php 
                  }?>
                  <div class="bg-danger" id="result-search"></div> 
                </div>

                <div class="col-sm-6 col-md-4">
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
                </div>
                <div class="col-sm-6 col-md-4">

                  <input class="form-control" type="text" name="designinp" onchange="this.form.submit()" >

                  <!-- <a class="mx-2" href="printstock.php?stock=<?=$_SESSION['lieuvente'];?>&type=<?="Carton";?>&carton" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                  
                  <a class="mx-2" href="csv.php?stock=<?=$_SESSION['nomtab'];?>&type=<?="Carton";?>&carton" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/excel.jpg"></a>  -->
                </div>
              </form>
            </th>
          </tr>

          <tr>
            <th colspan="7"></th>
            <th>8%</th>
            <th></th>
            <th></th>
            <th></th>
            <th colspan="3">Reception Totale</th>
            <th></th>
            <th colspan="3">Sortie Totale</th>
            <th></th>
          </tr>

          <tr>
            <th>N°</th>
            <th>Pro v</th>
            <th>Référence</th>
            <th>Désignation</th>
            <th>Qtité</th>
            <th>P.AED</th>
            <th>P.Achat GNF</th>
            <th>P.Revient</th>
            <th>P.Vente</th>  
            <th>Total sans pro v</th>  
            <th>Total Marchandise</th>  
            <th>CMD Réçu</th>  
            <th>Achat Réçu</th>  
            <th bg-success>Total entrée</th>  
            <th>Anomalie</th> 
            <th>VF</th> 
            <th>VD</th> 
            <th bg-danger>Tot Sortie</th> 
            <th>CMD</th>
          </tr>

        </thead>

        <tbody>

          <?php
          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0;

          if (empty($_POST['designinp'])) {

            if (!empty($_SESSION['design'])) {

              $productst = $DB->query("SELECT idprod, Marque, designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id  FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where codecat='{$_SESSION['design']}' ORDER BY (designation)");
            }else{

              $productst = $DB->query("SELECT idprod, Marque, designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where quantite!=0 ORDER BY (designation)");
            }
          }else{

            if (!empty($_SESSION['designinp'])) {

              $productst = $DB->query("SELECT idprod, Marque, designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion,  `".$_SESSION['nomtab']."`.id as id  FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where designation LIKE ? or  Marque LIKE ? ORDER BY (designation)", array("%".$_SESSION['designinp']."%", "%".$_SESSION['designinp']."%"));
            }else{

              $productst = $DB->query("SELECT idprod, Marque, designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where quantite!=0 ORDER BY (designation) ");
            }
          }

          foreach ($productst as $key=> $product):

            $qtite_stock_general=0;
            foreach ($panier->listeStockLieuvente() as $valueS) {
              $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` where idprod='{$product->idprod}' ");
              $qtite_stock_general+=$prodstock['qtite'];
            }
            if (empty($product->dateperemtion)) {
              $dateperemption=$product->dateperemtion;
            }else{
              $dateperemption=$product->dateperemtion;
            }

            $tot_achat+=$product->prix_achat*$product->quantite;
            $tot_revient+=$product->prix_revient*$product->quantite;
            $tot_vente+=$product->prix_vente*$product->quantite;
            $quantite+=$product->quantite;
            
            $prix_revient_cmd=$commande->dernierPrixAchatCmd($product->idprod)['pv']*$commande->dernierPrixAchatCmd($product->idprod)['tauxgnf']*(1+(8/100));
            if (empty( $prix_revient_cmd)) {
                $prix_revient_cmd=$product->prix_revient;
            } ?>

            <tr>
              <form action="" method="POST">
                <td><?=$key+1;?></td>
                <td>Etat</td>
                <td class="text-start"><a href="stockmouv.php?desig=<?=$product->idprod;?>" class="btn btn-success"><?= ucwords(strtolower($product->Marque)); ?></a></td>
                <td class="text-start"><?= ucwords(strtolower($product->designation)); ?></td>
                <td class="text-center"><?= $qtite_stock_general; ?></td>
                <td><?= $configuration->formatNombre($commande->dernierPrixAchatCmd($product->idprod)['pv']); ?></td>
                <td><?= $configuration->formatNombre($commande->dernierPrixAchatCmd($product->idprod)['pv']*$commande->dernierPrixAchatCmd($product->idprod)['tauxgnf']); ?></td>
                <td><?= $configuration->formatNombre($prix_revient_cmd); ?></td>
                <td><?= $configuration->formatNombre($product->prix_vente); ?></td>
                <td><?= $configuration->formatNombre($product->quantite* $prix_revient_cmd); ?></td>
                <td><?= $configuration->formatNombre($product->quantite* $prix_revient_cmd); ?></td>
                <td class="text-center"><?=$commande->nbreCmdRecuByIdprodByBoutique($product->idprod, $_SESSION['lieuvente'], "recepfcmd")['qtite'];?></td>
                <td class="text-center"><?=$commande->nbreAchatRecuByIdprodByBoutique($product->idprod, $_SESSION['lieuvente'], "recepfinterne")['qtite'];?></td>
                <td class="text-center bg-success bg-opacity-50"><?=$commande->nbreCmdRecuByIdprodByBoutique($product->idprod, $_SESSION['lieuvente'], "recepfinterne")['qtite']+$commande->nbreCmdRecuByIdprodByBoutique($product->idprod, $_SESSION['lieuvente'], "recepfcmd")['qtite'];?></td>
                <td></td>
                <td class="text-center"><?=$caisse->nbreVenteProduitById($product->idprod, "vente credit" , "livre")['qtite'];?></td>
                <td class="text-center"><?=$caisse->nbreVenteProduitById($product->idprod, "vente cash" , "livre")['qtite'];?></td>
                <td class="text-center bg-danger bg-opacity-50"><?=$caisse->nbreVenteProduitById($product->idprod, "vente cash" , "livre")['qtite']+$caisse->nbreVenteProduitById($product->idprod, "vente credit" , "livre")['qtite'];?></td>
                <td class="text-center bg-info bg-opacity-50"><?=$commande->nbreCmdConfirmeByIdprod($product->idprod)['nbre'];?></td>
              </form>
            </tr>
              
          <?php endforeach ?>

        </tbody>
      </table>
    </div><?php 
    //require_once("nav_stock_lat.php");?>
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
                    url: 'rechercheproduit.php?stock_general_detail',
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

</script> 