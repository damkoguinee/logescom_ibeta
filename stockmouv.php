<?php require 'headerv2.php';

if (isset($_GET['desig'])) {
  $_SESSION['desig']=$_GET['desig'];
}else{
  $_SESSION['desig']='';
}

  $_SESSION['nomtab']=$panier->nomStock($_SESSION['lieuvente'])[1];
  $_SESSION['idnomstock']=$panier->nomStock($_SESSION['lieuvente'])[2]; ?>

  <div class="container-fluid">

    <div class="row">

      <?php require 'navstock.php';?> 
      

      <div class="col-sm-12 col-md-10" style="overflow: auto; height:90vh;">

        <table class="table table-hover table-bordered table-striped table-responsive text-center">          
          <thead class="sticky-top bg-danger">
            <tr>
              <th colspan="8">
                <table class="table table-hover table-bordered table-striped table-responsive text-center" >
                  <tbody>
                    <tr>
                      <td class="bg-success bg-opacity-50 text-white">Stock Actuel</td>
                      <td class="bg-success bg-opacity-50 text-white"><?=$caisse->qtiteLieuventeProduit($_SESSION['desig']);?></td>
                      <td class="bg-success bg-opacity-50 text-white">Stock Précedent</td>
                      <td class="bg-success bg-opacity-50 text-white"><?=$configuration->formatNombre($caisse->stockInitial($_SESSION['desig'])['qtite']);?></td>
                    </tr>

                    <tr>
                      <td class="bg-success bg-opacity-50 text-white">Entrées</td>
                      <td class="bg-success bg-opacity-50 text-white"><?=$caisse->stockEntrees($_SESSION['desig'], $_SESSION['lieuvente'])['qtite'];?></td>
                      <td class="bg-success bg-opacity-50 text-white">Sorties</td>
                      <td class="bg-success bg-opacity-50 text-white"><?=-1*$caisse->stockSorties($_SESSION['desig'], $_SESSION['lieuvente'])['qtite'];?></td>
                    </tr>
                  </tbody>
                </table>
              </th>
            </tr>
            <tr>
              <th colspan="8">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-sm-6 col-md-6">
                      <input class="form-control" id="search-user" type="text" name="desig" placeholder="rechercher un produit" />
                      <div class="bg-danger" id="result-search"></div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <label class="bg-warning p-2"><?="Mouvement(s) ".$panier->nomProduit($_SESSION['desig']);?></label>
                      <a class="btn btn-info" href="">Entrées</a>
                      <a class="btn btn-danger" href="">Sorties</a>
                    </div>
                  </div>
                </div>
              </th>
            </tr>
            
            <tr>
              <th>Date</th>
              <th>Entrée</th>
              <th>Sortie</th>
              <th>Stock</th>
              <th>Origine</th>
              <th>Client</th>
              <th>N°Op</th>
              <th>Commentaire</th>
            </tr>
          </thead>

        <tbody>

          <?php
          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0;

          if (isset($_GET['desig'])) {

            $prodstockmouv = $DB->query("SELECT * FROM stockmouv where idstock='{$_SESSION['desig']}' and lieuvente_mouv ='{$_SESSION['lieuvente']}' order by(id) ");
            
          }else{

            $prodstockmouv=array();

          }

          $soldestock=0;
          $keyent=0;
          $keysort=0;
          $keyret=0;
          $keyper=0;

          foreach ($prodstockmouv as $keye=> $entree){
            $provenance=$entree->origine;

            $soldestock+=$entree->quantitemouv; ?>

            <tr>
              <td><?=(new DateTime($entree->dateop))->format('d/m/Y');?></td><?php 
              if ($entree->quantitemouv>0) {?>
                <td><?= $entree->quantitemouv; ?></td>
                <td></td><?php
              }else{?>
                <td></td>
                <td><?= -1*$entree->quantitemouv; ?></td>
                <?php

              }?>
              <td class="fw-bold"><?=$soldestock;?></td>
              <td><?=$entree->origine;?></td>
              <td class="text-start"><?=$caisse->nomClient($entree->client)['nom_client'];?></td>
              <td><?=$entree->numeromouv;?></td>
              <td><?=$entree->coment."  ".$panier->nomStock($entree->idnomstock)[0];?></td>
            </tr><?php 
          }?>

        </tbody>
      </table>
    </div> 
  </div>  

<script type="text/javascript">
    function alerteS(){
      return(confirm('Attention, vous êtes sur le point de supprimer un produit!!! Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?stockmouv',
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