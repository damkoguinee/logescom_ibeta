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

          if (isset($_POST['devise'])) {
            $_SESSION['deviseselect']=$_POST['devise'];
          }elseif (isset($_POST['j1'])) {
            $_SESSION['deviseselect']=$_SESSION['deviseselect'];
          }else{
            $_SESSION['deviseselect']='gnf';
          };
          
          if (isset($_GET['clientsearch'])) {
            $_SESSION['client_rapport']=$_GET['clientsearch'];
          }else{
            $_SESSION['client_rapport']=0;
          }?>
          <div class="row" >          
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="sticky-top bg-secondary text-center">
                <tr><th colspan="7"><?="Rapport Client ".$caisse->nomClient($_SESSION['client_rapport'])['nom_client'];?></th></tr>

                <tr>
                    <th colspan="6">
                        <div class="d-flex justify-content-between ">
                            <form method="POST">
                                <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                                <div class="bg-danger" id="result-search"></div>                            
                            </form><?php 
                            if (!empty($_SESSION['client_rapport'])) {?>
                                <form class="form" method="POST">
                                    <select class="form-select" name="devise" required="" onchange="this.form.submit()"><?php
                                        if (!empty($_SESSION['deviseselect'])) {?>
                                
                                            <option value="<?=$_SESSION['deviseselect'];?>"><?=$_SESSION['deviseselect'];?></option><?php
                                        } 
                                        foreach ($panier->monnaie as $valuem) {?>
                                            <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                                        }?>
                                    </select>
                                </form>
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
                                </form><?php 
                            }?>
                        </div>
                    </th>                
                </tr>

                <tr>
                    <th>N°</th>
                    <th>Date</th>
                    <th>Libellés</th>
                    <!-- <th>Type de Paie</th> -->
                    <th>
                      Débiter<br/>
                      <label class="bg-info p-1"><?=$configuration->formatNombre(-$caisse->cumulRapportClient($_SESSION['date1'], $_SESSION['date2'],  $_SESSION['client_rapport'], $_SESSION['deviseselect'],"debiter")['montant']);?></label>
                    </th>
                    <th>
                      Créditer<br/>
                      <label class="bg-info p-1"><?=$configuration->formatNombre($caisse->cumulRapportClient($_SESSION['date1'], $_SESSION['date2'],  $_SESSION['client_rapport'], $_SESSION['deviseselect'],"crediter")['montant']);?></label>
                    </th>
                    <th>
                      <label class="bg-info p-1">SOLDE <?=$configuration->formatNombre($caisse->soldeRapportClient($_SESSION['date1'], $_SESSION['date2'],  $_SESSION['client_rapport'], $_SESSION['deviseselect'])['montant']);?></label>
                    </th>
                </tr>
                </thead>
                <tbody><?php
                    $montantdebit=0;
                    $montantcredit=0;
                    $solde=0;
                    foreach ($caisse->rapportClient($_SESSION['date1'], $_SESSION['date2'],  $_SESSION['client_rapport'], $_SESSION['deviseselect']) as $key=> $value ){
                        if ($value->libelles=='reste à payer') {
                            $libelles="vente facturation";
                        }else{
                            $libelles=$value->libelles;
                        }
                        $solde += $value->montant ; ?>
                        <tr>
                            <td class="text-center"><?=$key+1;?></td>
                            <td class="text-center"><?=(new DateTime($value->date_versement))->format("d/m/Y H:i"); ?></td>
                            <td><?= ucwords(strtolower($libelles)); ?></td>
                            <!-- <td class="text-center"><?= ucwords(strtolower($value->typep)); ?></td>  --><?php
                            if ($value->montant<0) {
                                $montantdebit+=$value->montant;?>
                                <td class="text-end"><?=$configuration->formatNombre(-1*$value->montant,0,',',' ');?></td>
                                <td></td><?php
                            }else{
                                $montantcredit+=$value->montant;?>
                                <td></td>
                                <td class="text-end"><?=$configuration->formatNombre($value->montant,0,',',' ');?></td><?php
                            }?> 
                            <td class="text-end"><?=$configuration->formatNombre($solde);?></td>                            
                        </tr><?php 
                    } ?>   
                </tbody>
            </table>
          </div>
        </div> 

      </div><?php 
        require_once "nav_facturation.php";

  }else{
    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
  }
  require 'footer.php';
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
                  url: 'recherche_utilisateur.php?rapport_client',
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