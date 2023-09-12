<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {
  if ($_SESSION['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php
        //require 'navventecredit.php';?>
        <div class="col col-sm-12 col-md-12" style=" height:600px;overflow: auto;"><?php
          if (!isset($_POST['magasin'])) {

            if (!isset($_POST['j1'])) {

              $_SESSION['date']=date("Ymd");  
              $dates = $_SESSION['date'];
              $dates = new DateTime( $dates );
              $dates = $dates->format('Ymd'); 
              $_SESSION['date']=$dates;
              $_SESSION['date1']=$dates;
              $_SESSION['date2']=$dates;
              $_SESSION['dates1']=$dates; 

            }else{

              $_SESSION['date01']=$_POST['j1'];
              $_SESSION['date1'] = new DateTime($_SESSION['date01']);
              $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
              
              $_SESSION['date02']=$_POST['j2'];
              $_SESSION['date2'] = new DateTime($_SESSION['date02']);
              $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

              $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
              $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');  
            }
          }

          if (isset($_POST['j2']) or isset($_POST['magasin'])) {

            $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

          }else{

            $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
          }

          if (isset($_POST['clientliv'])) {
            $_SESSION['clientliv']=$_POST['clientliv'];
          }
          
          if (isset($_GET['clientsearch'])) {
            $_SESSION['client_credit']=$_GET['clientsearch'];
          }else{
            $_SESSION['client_credit']=0;
          }?>
          <div class="row" >
          
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="sticky-top bg-secondary text-center">

                <tr><th colspan="13"><?="Liste des Produits Facturés " .$datenormale ?></th></tr>

                <tr>
                    <th colspan="11">
                    <div class="d-flex justify-content-between ">
                        <form class="form d-flex" method="POST"><?php
                        if (isset($_POST['j1'])) {?>

                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                        }else{?>
                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php
                        }

                        if (isset($_POST['j2'])) {?>
                            <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php
                        }else{?>
                            <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php
                        }?>
                        </form>

                        <form method="POST">
                        <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                        <div class="bg-danger" id="result-search"></div>
                        
                        </form>
                    </div>
                    </th>                
                </tr>

                <tr>
                    <th>N°</th>
                    <th>Etat</th>
                    <th>N° Fact</th>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Référence</th>
                    <th>Qtite</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th>Prix Achat</th>
                    <th>Commission</th>
                </tr>
                </thead>
                <tbody><?php
                $etat="vente credit";
                if (isset($_POST['j1'])) {
                    $products=$DB->query("SELECT *FROM payement inner join commande on payement.num_cmd=commande.num_cmd where type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY (commande.id) DESC");
                }elseif (isset($_GET['clientsearch'])) {

                    $products=$DB->query("SELECT *FROM payement inner join commande on payement.num_cmd=commande.num_cmd where type_vente='{$etat}' and num_client='{$_GET['clientsearch']}' and lieuvente='{$_SESSION['lieuvente']}' ORDER BY (commande.id) DESC ");                

                }else {
                    $products =$DB->query("SELECT *FROM payement inner join commande on payement.num_cmd=commande.num_cmd WHERE type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' ORDER BY (commande.id) DESC LIMIT 100 "); 
                }

                $cumul_com=0;

                foreach ($products as $key=> $product ){

                    $cumul_com+=0;?>

                    <tr>
                    <td class="text-center"><?=$key+1;?></td>
                    <td class="text-center"></td>
                    <td><a class="btn btn-info fs-6" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><i class="fa-solid fa-file-pdf"></i><?= $product->num_cmd; ?></a></td>

                    <td class="text-center"><?=(new dateTime($product->date_cmd))->format("d/m/Y"); ?></td>

                    <td><?= $panier->nomClient($product->num_client); ?></td>

                    <td><?=$caisse->nomProduit($product->id_produit)['Marque']; ?></td>

                    <td class="text-end"><?=$configuration->formatNombre($product->quantity); ?></td>

                    <td class="text-end"><?=$configuration->formatNombre($product->prix_vente); ?></td>
                    
                    <td class="text-end"><?=$configuration->formatNombre($product->quantity*$product->prix_vente); ?></td>
                    <td class="text-end"><?=$configuration->formatNombre($product->prix_revient); ?></td>

                    <td class="text-end"><?=$configuration->formatNombre(0); ?></td>
                    </tr><?php 
                } ?>   
                </tbody>

                <tfoot>
                <tr>
                    <th colspan="4"></th>
                    <th class="text-end"><?= $configuration->formatNombre(0);?></th>
                </tr>
                </tfoot>
            </table>
          </div>
        </div>
      </div><?php 
  }else{
    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
  }
}?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  $(document).ready(function(){
      $('#search-user').keyup(function(){
          $('#result-search').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'recherche_utilisateur.php?clientfact',
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

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
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