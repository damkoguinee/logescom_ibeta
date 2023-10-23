<?php require 'headerv2.php';?>

<div class="container-fluid"> 

  <div class="row"><?php 
    
    require 'navstock.php';?> 

    <div class="col-sm-12 col-md-10" style="overflow: auto; height:90vh;"> <?php 

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

      if (isset($_POST['id'])) {
        $pv=$panier->espace($_POST['pv']);
        foreach ($caisse->listeStockLieuvente() as $valueS) {                         
          $DB->insert("UPDATE `".$valueS->nombdd."` SET prix_vente= ? WHERE idprod = ?", array($pv, $_POST['id']));
        }
      }?>
      
      <table class="table table-hover table-bordered table-striped table-responsive text-center">          
        <thead class="sticky-top bg-danger">            
          <tr>
            <th colspan="6" >
              <form class="d-flex justify-content-between" action="" method="POST">
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

                <input class="form-control" type="text" name="designinp" onchange="this.form.submit()" >

                <!-- <a class="mx-2" href="printstock.php?stock=<?=$_SESSION['idnomstock'];?>&type=<?="Carton";?>&carton" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                
                <a class="mx-2" href="csv.php?stock=<?=$_SESSION['nomtab'];?>&type=<?="Carton";?>&carton" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/excel.jpg"></a>  -->
              </form>
            </th>
          </tr>

          <tr>
            <th></th>
            <th>MVP</th>
            <th>Référence</th>
            <th>Qtité</th>
            <th>P.Revient</th>
            <th>P.Vente</th>  
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

              $productst = $DB->query("SELECT * FROM productslist where codecat='{$_SESSION['design']}' ORDER BY (designation)");
            }else{

              $productst = $DB->query("SELECT *FROM productslist ORDER BY (designation)");
            }
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
              $prodstock = $DB->querys("SELECT sum(quantite) as qtite, prix_revient, prix_vente  FROM `".$valueS->nombdd."` where idprod='{$product->id}' ");                
              $qtites+=$prodstock['qtite'];                            
              $prix_revient=$prodstock['prix_revient'];                            
              $prix_vente=$prodstock['prix_vente'];                            
            }            
            if ($qtites!=0) {?>

              <tr>

                <form action="" method="POST">
                  <td><?=$key+1;?></td>
                  <td class="text-start"><a href="stockmouv.php?desig=<?=$product->id;?>" class="btn btn-success">MVP</a></td>
                  <td class="text-start"><?= ucwords(strtolower($product->Marque)); ?> <input type="hidden" name="id" value="<?= $product->id; ?>"></td>
                  <td style="text-align: center;"><?= $qtites; ?></td>
                  <td class="text-end"><?= $configuration->formatNombre($prix_revient); ?></td>
                  <td><?php if ($products['statut']!="vendeur") {?><input class="form-control text-end" type="text" name="pv" value="<?= $configuration->formatNombre($prix_vente); ?>" onchange="this.form.submit()"><?php }?></td>
                </form>
              </tr><?php 
            }?>
              
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

</script> 