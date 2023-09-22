<?php require 'headerv2.php';

if (isset($_GET['desig'])) {
  $_SESSION['desig']=$_GET['desig'];
}else{
  $_SESSION['desig']='';
}

  if (isset($_GET['stock'])) {
    
    $nomstock=$_GET['stock'];

    $_SESSION['nomstock']=$nomstock;
    $_SESSION['idnomstock']=$_GET['idnomstock'];

  }elseif (isset($_GET['stockgeneral'])) {
    
    $nomstock=$_GET['stockgeneral'];

    $_SESSION['nomstock']=$nomstock;
    $_SESSION['idnomstock']=0;
  }?>

  <div class="container-fluid"><?php

    require 'headerstock.php';?> 

    <div class="row">

      <?php require 'navstock.php';?> 

      <div class="col-sm-12 col-md-10" style="overflow: auto;">      

        <table class="table table-hover table-bordered table-striped table-responsive text-center">

          <form class="form" action="stockmouv.php" method="POST">

            <thead>
            

              <tr>

                <th colspan="2">

                  <div class="container-fluid">
                    <div class="row">

                      <div class="col-sm-6 col-md-6">

                        <input class="form-control" id="search-user" type="text" name="desig" placeholder="rechercher un produit" />

                        <div class="bg-danger" id="result-search"></div>
                      </div>

                      <div class="col-sm-6 col-md-6">
                        <?="Mouvement(s) ".$panier->nomProduit($_SESSION['desig']);?>
                      </div>
                    </div>
                  </div>
                </th>
              </tr>
          

            <tr>
              <th>Date</th>
              <th>Libellé</th>
              <th>Quantité
                <table>
                  <thead>
                    <tr>
                      <th style="width: 100px;">Entrée(s)</th>
                      <th style="width: 100px;">Sortie(s)</th>
                      <th style="width: 100px;">Stock</th>
                    </tr>
                  </thead>
                </table></th>
            </tr>

          </thead>
        </form>

        <tbody>

          <?php
          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0;

          if (isset($_GET['desig'])) {

            if ($_SESSION['nomstock']=='stock general') {

              $prodstockmouv = $DB->query("SELECT * FROM stockmouv inner join stock on idnomstock=stock.id where idstock='{$_SESSION['desig']}' order by(stockmouv.id) ");

            }else{

              $prodstockmouv = $DB->query("SELECT * FROM stockmouv where idstock='{$_SESSION['desig']}' and idnomstock='{$_SESSION['idnomstock']}' order by(id) ");
            }
          }else{

            $prodstockmouv=array();

          }

          $soldestock=0;
          $keyent=0;
          $keysort=0;
          $keyret=0;
          $keyper=0;

          foreach ($prodstockmouv as $keye=> $entree){

            if ($_SESSION['nomstock']=='stock general') {
              $provenance=' du '.$entree->nomstock;
            }else{
              $provenance='';
            }

            $soldestock+=$entree->quantitemouv;

            if ($entree->libelle=='entree') {

              $keyent+=1;

              $libelled='Approvisionnement N°'.$keyent.$provenance;

            }elseif ($entree->libelle=='ajustement') {

              $keyent+=1;

              $libelled='Ajustement stock N°'.$keyent.$provenance;        

            }elseif ($entree->libelle=='sortie') {

              $keysort+=1;

              $libelled='Vente N°'.$keysort.$provenance;        

            }elseif ($entree->libelle=='retour') {

              $keyret+=1;

              $libelled='Retour N°'.$keyret.$provenance;        

            }elseif ($entree->libelle=='retourp') {

              $keyret+=1;

              $libelled='Retour produit';        

            }elseif ($entree->libelle=='retourpc') {

              $keyret+=1;

              $libelled='Retour produit client';        

            }elseif ($entree->libelle=='pertes') {

              $keyper+=1;

              $libelled='Perte N°'.$keyper.' '.$provenance;        

            }?>

            <tr>
              <td><?=(new DateTime($entree->dateop))->format('d/m/Y');?></td>

              <td><?=ucfirst($libelled); ?></td>

              <td>
                <table>
                  <tbody>
                    <tr><?php 
                      if ($entree->libelle=='entree') {?>

                        <td style="width: 100px;"><?= $entree->quantitemouv; ?></td>
                        <td style="width: 100px;"></td><?php

                      }elseif ($entree->libelle=='sortie') {?>

                        <td style="width: 100px;"></td>                  
                        <td style="width: 100px;"><?= (-1)*$entree->quantitemouv; ?></td><?php 
                      }elseif ($entree->libelle=='retourp') {?>

                        <td style="width: 100px;"></td>                  
                        <td style="width: 100px;"><?= (-1)*$entree->quantitemouv; ?></td><?php 
                      }elseif ($entree->libelle=='retourpc') {?>

                        <td style="width: 100px;"><?= $entree->quantitemouv; ?></td>
                        <td style="width: 100px; "></td><?php

                      }else{?>

                        <td style="width: 100px;"></td>

                        <td style="width: 100px;"><?= $entree->quantitemouv; ?></td>
                        <?php

                      }?>

                      <td style="width: 100px;"><?=$soldestock;?></td>
                    </tr>
                  </tbody>
                </table>
              </td>
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