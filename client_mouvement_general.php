<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {
  if ($_SESSION['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php
        //require 'nav_client_general.php';?>
        <div class="col col-sm-12 col-md-12" style="overflow: auto;"><?php

          
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
          }
          
          if ($panier->compteClient($_SESSION['client_credit'], "gnf")>0) {
            $color='danger';
            $credit=0;
          }else{
            $color="success";
            $credit=-$panier->compteClient($_SESSION['client_credit'], "gnf");
          }?>

          <div class="d-flex">
            <table class="table table-bordered table-striped table-hover align-middle mt-2 mx-1">
              <tbody><?php 
                if (!empty($_SESSION['client_credit'])) {?>
                  <tr>
                    <td colspan="2" class="text-center">
                      Situation de <?=$caisse->nomClient($_SESSION['client_credit'])['nom_client'].' '.$caisse->nomClient($_SESSION['client_credit'])['telephone'];?>
                      <label for="" class="bg-<?=$configuration->colorSolde($caisse->soldeClientNp($_SESSION['client_credit'], "gnf"));?> p-2">Solde: <?=$configuration->formatNombre($caisse->soldeClientNp($_SESSION['client_credit'], "gnf")); ?></label>
                    </td>
                  </tr><?php                  
                }?>
              </tbody>
            </table>
          </div> 
          <div class="row" style="overflow: auto;">         
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="sticky-top bg-light text-center">
                <tr>
                    <th colspan="12">
                      <div class="d-flex justify-content-between ">
                        <form method="POST">
                          <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                          <div class="bg-danger" id="result-search"></div>                        
                        </form>

                        <a class="btn btn-info text-center fw-bold" href="client_general.php?ajoutc">Clients</a>
                        <a class="btn btn-info text-center fw-bold" href="client_mouvement_general.php">Mouvement Général</a> 
                        <a class="btn btn-info text-center fw-bold" href="client.php?ajoutc">Nouveau Client</a>
                      </div>
                    </th>                
                </tr>

                <tr>
                    <th>N°</th>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Facture Totale</th>
                    <th>Facture Payé</th>
                    <th>Achat Tot</th>
                    <th>Achat Paye</th>
                    <th>Facture Impayer</th>
                    <th>Com Clients</th>
                    <th>Solde depot/retrait</th>
                    <th>Balance</th>
                    <th>
                        Solde GN<br/>
                        <label class="bg-info p-1"><?=$configuration->formatNombre(0);?></label>
                    </th>
                </tr>
                </thead>
                <tbody><?php 

                    foreach ($caisse->listClient("client","clientf") as $key=> $value ){?>
                        <tr>
                            <td class=" text-center " ><?=$key+1;?></td>

                            <td style="width: 10%;"><?= $value->nom_client; ?></td>

                            <td class="text-center"><?= $value->telephone; ?></td>

                            <td class=" text-end"><?=$configuration->formatNombre($caisse->montantFactureClientGeneral($value->id)[0]); ?></td>

                            <td class=" text-end"><?=$configuration->formatNombre($caisse->montantFactureClientGeneral($value->id)[1]); ?></td>

                            <td class=" text-end"><?=$configuration->formatNombre($caisse->totalAchatClientFournisseur($value->id, "gnf")["montant"]); ?></td>

                            <td class=" text-end"><?=$configuration->formatNombre($caisse->montantFactureClientFournisseur($value->id, "gnf", "paye")["montant"]); ?></td>

                            <td class=" text-end text-danger "><?=$configuration->formatNombre($caisse->montantFactureClientGeneral($value->id)[2]); ?></td>
                            
                            <td class=" text-end"><?=$configuration->formatNombre($caisse->montantVenteCommission($value->id)["montant"]); ?></td>
                            
                            <td class=" text-end"><?=$configuration->formatNombre($caisse->montantDepot($value->id, "gnf")["montant"]-$caisse->montantRetrait($value->id, "gnf")["montant"]); ?></td>

                            <td class=" text-end text-<?=$configuration->colorSolde($caisse->balanceClient($value->id, "gnf"));?>"><?=$configuration->formatNombre($caisse->balanceClient($value->id, "gnf")); ?></td>

                            <td class="text-end text-<?=$configuration->colorSolde($caisse->soldeClientNp($value->id, "gnf"));?>"><?=$configuration->formatNombre($caisse->soldeClientNp($value->id, "gnf")); ?></td>
                        </tr><?php 
                    }?>   
                </tbody>
            </table>
          </div>
        </div>
      </div>      
    </div><?php 
  }else{
    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
  }
}?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  $(document).ready(function(){
      $('#search-user').keyup(function(){
          $('#result-search').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'recherche_utilisateur.php?client_mouvement_general',
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