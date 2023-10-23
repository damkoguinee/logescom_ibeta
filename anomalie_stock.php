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

      if (isset($_GET['inventaire_form'])) {
        unset($_SESSION['design']);
        unset($_SESSION['designinp']);

      }

      if (isset($_GET['recherchgen'])) {
        $_SESSION['recherchgen']=$_GET['recherchgen'];

      }else{
        $_SESSION['recherchgen']='';
      }
      
      $_SESSION['nomtab_ano']=$panier->nomStock($_SESSION['lieuvente'])[1];
      ?>

        <table class="table table-hover table-bordered table-striped table-responsive text-center">          
            <thead class="sticky-top bg-danger">                     
                <tr>
                    <th colspan="6" >
                    
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

                        <form class="form row" action="" method="POST">
                        <div class="col-sm-12 col-md-4 bg-info">Anomalie Stock</div>
                        <div class="col-sm-12 col-md-3">
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
                        <div class="col-sm-12 col-md-3">
                            <input class="form-control" type="text" name="designinp" onchange="this.form.submit()" >
                        </div>
                        </form>

                    </div>
                    </th>
                </tr>

                <tr>
                    <th></th>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Qtité</th>
                    <th>Lieu</th>
                    <th>Prix-Revient</th>  
                    <th>Commentaires</th>  
                </tr>
            </thead>

            <tbody><?php
                $tot_achat=0;
                $tot_revient=0;
                $tot_vente=0;
                $quantite=0;

                if (empty($_POST['designinp'])) {

                    if (!empty($_SESSION['design'])) {

                        $productst = $DB->query("SELECT * FROM inventaire inner join productslist on productslist.id=id_prod_inv where codecat='{$_SESSION['design']}' ORDER BY (designation)");
                    }else{

                        $productst = $DB->query("SELECT *FROM inventaire inner join productslist on productslist.id=id_prod_inv ORDER BY (designation)");
                    }
                }else{

                    if (!empty($_SESSION['designinp'])) {

                        $productst = $DB->query("SELECT *FROM inventaire inner join productslist on productslist.id=id_prod_inv where designation LIKE ? or Marque LIKE ? ORDER BY (designation)", array("%".$_SESSION['designinp']."%", "%".$_SESSION['designinp']."%"));
                    }else{

                        $productst = $DB->query("SELECT *FROM inventaire inner join productslist on productslist.id=id_prod_inv ORDER BY (designation) ");
                    }
                }?>

                <form action="inventaire_traitement.php?valid_ano" method="GET" class="form">

                    <tr>
                        <td></td>
                        <td class="text-center"></td>
                        <td class="text-start"><?php 
                            if (isset($_GET['recherchgen'])) {?>
                                <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="<?=$caisse->nomProduit($_GET['recherchgen'])['Marque'];?>" /><?php 
                            }else{?>
                                <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un produit" /><?php 
                            }?>

                            <input type="hidden" name="id_prod_ano" value="<?=$_SESSION['recherchgen'];?>">
                            <div class="bg-danger" id="result-search"></div> 
                        </td>
                        <td class="text-center"><input class="form-control" type="number" name="qtite_ano" required ></td>
                        <td class="text-center">
                            <select name="lieu_ano"  class="form-select" required>
                                <option value=""></option><?php 
                                foreach ($caisse->listeStockLieuvente() as $key => $valuec) {?>
                                    <option value="<?=$valuec->id;?>"><?=$valuec->nomstock;?></option><?php 
                                }?>
                            </select>
                        </td>
                        <td colspan="2">
                            <button type="submit" name="valid_ano" class="btn btn-danger" onclick="return alerteV();" >Valider</button>
                        </td>
                    </tr>
                </form><?php

                foreach ($productst as $key=> $product){?>

                    <tr>
                        <td><?=$key+1;?></td>
                        <td class="text-center"><?= ( new dateTime($product->dateop))->format("d/m/Y");?></td>
                        <td class="text-start"><?= ucwords(strtolower($product->Marque)); ?></td>
                        <td class="text-center"><?= $product->balance_inv; ?></td>
                        <td class="text-center"><?= $panier->nomStock($product->stock_inv)[0]; ?></td>
                        <td><?=$configuration->formatNombre($caisse->infoProduitStock($_SESSION['nomtab_ano'], $product->id_prod_inv)['prix_revient']);?></td>
                        <td class="text-center"><?= $product->coment_inv; ?></td>
                    </tr><?php 
                }?>

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
                    url: 'rechercheproduit.php?anomalie_stock',
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

</script> a