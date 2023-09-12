<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {
  if ($_SESSION['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php
        //require 'navventecredit.php';?>
        <div class="col col-sm-12 col-md-12" style="overflow: auto;"><?php

          if (isset($_GET['deletemodif'])) {

            $DB->delete('DELETE FROM validpaiemodif WHERE pseudov=?', array($_SESSION['idpseudo']));

            $DB->delete('DELETE FROM validventemodif where pseudop=?', array($_SESSION['idpseudo']));

            $_SESSION['panier'] = array();
            $_SESSION['panieru'] = array();
            $_SESSION['error']=array();
            $_SESSION['clientvip']=array();
            $_SESSION["montant_paye"]=array();
            $_SESSION['remise']=array();
            $_SESSION['product']=array();
            unset($_SESSION['banque']);
            unset($_SESSION['proformat']);
            unset($_SESSION['alertesvirement']);
            unset($_SESSION['alerteschequep']);
            unset($_SESSION['clientvipcash']);
          }
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
                    <td colspan="2" class="text-center">Situation de <?=$caisse->nomClient($_SESSION['client_credit'])['nom_client'].' '.$caisse->nomClient($_SESSION['client_credit'])['telephone'];?></td>
                  </tr><?php                  
                }?>
                <tr>
                  <td>
                    <table class="table table-bordered table-striped table-hover align-middle mt-2 mx-1">
                      <thead>
                        <tr>
                          <th class="bg-secondary">BALANCE</th>
                          <th class="bg-<?=$color;?> text-end">
                            <a class="btn btn-info" href="bulletin.php?clientsearch=<?=$_SESSION['client_credit'];?>"><?=$configuration->formatNombre($caisse->soldeClient($_SESSION['client_credit'], 'gnf'));?></a>
                          </th>                
                        </tr>
                        <tr>
                          <th class="bg-warning">ACHAT CLIENTS-FOUR</th>
                          <th class="bg-warning text-end">
                            <a class="btn btn-info" href="achat_fournisseur.php?search_fact=<?=$_SESSION['client_credit'];?>"><?=$configuration->formatNombre($caisse->montantFactureClientFournisseur($_SESSION['client_credit'], 'gnf', 'non paye')['montant']);?></a>
                          </th>
                        </tr>
                        <tr>
                          <th class="bg-light">FAC NON PAYER</th>
                          <th class="bg-light text-end"><?=$configuration->formatNombre($caisse->montantFactureClient($_SESSION['client_credit'], 'credit')['montant']);?></th>
                        </tr>
                      </thead>
                    </table>
                  </td>
                  <td>
                    <table class="table table-bordered table-striped table-hover align-middle mt-2">
                      <thead>
                        <tr>
                          <th class="">TOTAL FAC</th>
                          <th class=" text-end"><?=$configuration->formatNombre(0);?></th>                
                        </tr>
                        <tr>
                          <th class="">PAYER</th>
                          <th class=" text-end"><?=$configuration->formatNombre(0);?></th>
                        </tr>
                        <tr>
                          <th class="bg-light">FAC IMPAYER</th></th>
                          <th class="bg-light text-end"><?=$configuration->formatNombre(0);?></th></th>
                        </tr>
                      </thead>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          
          <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="sticky-top bg-light text-center">

              <!-- <tr><th colspan="13"><?="Liste des Facturations Crédits " .$datenormale ?></th></tr> -->

              <tr>
                <th colspan="13">
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
                <th>N° Fact</th>
                <th>Date</th>
                <th>Client</th>
                <th>Total-Fac</th>
                <th>Remise</th>
                <th>Montant Payer</th>
                <th>Retour-Fac</th>
                <th>Total Act</th>
                <th>Signé le</th>
                <th>Etat</th>
                <th colspan="2"></th>
              </tr>
            </thead>
            <tbody><?php
              $etat="vente credit";
              if (isset($_POST['j1'])) {
                $products=$DB->query("SELECT *FROM payement where type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY (id) DESC");
              }elseif (isset($_GET['clientsearch'])) {

                $products=$DB->query("SELECT *FROM payement where type_vente='{$etat}' and num_client='{$_GET['clientsearch']}' and lieuvente='{$_SESSION['lieuvente']}' ORDER BY (id) DESC ");                

              }else {
                $products =$DB->query("SELECT *FROM payement WHERE type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' ORDER BY (id) DESC "); 
              }

              $cumulmontanremp=0;
              $cumulmontantotp=0;
              $cumulmontanrestp=0;

              foreach ($products as $key=> $product ){

                $cumulmontanremp+=$product->remise;
                $cumulmontantotp+=$product->Total-$product->remise;
                $cumulmontanrestp+=$product->montantpaye; ?>

                <tr>
                  <td class="text-center"><?=$key+1;?></td>

                  <td><a class="btn btn-info fs-6" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><i class="fa-solid fa-file-pdf"></i><?= $product->num_cmd; ?></a></td>

                  <td class="text-center"><?=(new dateTime($product->date_cmd))->format("d/m/Y"); ?></td>

                  <td><?= $panier->nomClient($product->num_client); ?></td>

                  <td class="text-end"><?=$configuration->formatNombre($product->Total-$product->remise); ?></td>

                  <td class="text-end"><?=$configuration->formatNombre($product->remise); ?></td>

                  <td class="text-end"><?=$configuration->formatNombre($product->montantpaye); ?></td>

                  <td class="text-end"><?=$configuration->formatNombre(0); ?></td>

                  <td class="text-end"><?=$configuration->formatNombre(0); ?></td>

                  <td class="text-center">signe</td>
                  <td class="text-center"><?= $product->etat; ?></td>
                  <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-warning" onclick="return alerteM();" href="modifventeprod.php?numcmdmodif=<?=$product->num_cmd;?>"><i class="fa fa-edit"></i></a><?php };?></td>

                  <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-danger" onclick="return alerteS();" href="comptasemaine.php?num_cmd=<?=$product->num_cmd;?>&total=<?=$product->Total-$product->remise;?>"><i class="fa fa-trash"></i></a><?php };?></td>
                </tr><?php 
              } ?>   
            </tbody>

            <tfoot>
              <tr>
                <th colspan="4"></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulmontantotp);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulmontanremp);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulmontanrestp);?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>

      <div class="d-flex justify-content-between" style="position: fixed; top:92%; width:80%;">
        <a  class="btn btn-info text-center fw-bold" href="facturations.php">FACTURATIONS</a> 
        <a  class="btn btn-success text-center fw-bold" href="retour_vente_credit.php">RETOUR FAC</a> 
        <a  class="btn btn-primary text-center fw-bold" href="achat_fournisseur.php">ACHAT PRODUIT</a>
        <a  class="btn btn-warning text-center fw-bold" href="produit_factures.php">PRODUITS FACTURES</a>
        <a  class="btn btn-primary text-center fw-bold" href="ventecommission.php?commission">Commissions</a>            
        <a  class="btn btn-success text-center fw-bold" href="#">RAPPORT</a>            
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