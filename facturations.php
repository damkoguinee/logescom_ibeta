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
                    <td colspan="2" class="text-center">
                      Situation de <?=$caisse->nomClient($_SESSION['client_credit'])['nom_client'].' '.$caisse->nomClient($_SESSION['client_credit'])['telephone'];?>
                      <label for="" class="bg-<?=$configuration->colorSolde($caisse->soldeClientNp($_SESSION['client_credit'], "gnf"));?> p-2">Solde: <?=$configuration->formatNombre($caisse->soldeClientNp($_SESSION['client_credit'], "gnf")); ?></label>
                    </td>
                  </tr><?php                  
                }?>
                <tr>
                  <td>
                    <table class="table table-bordered table-striped table-hover align-middle mt-2 mx-1">
                      <thead>
                        <tr>
                          <th class="bg-secondary">BALANCE</th>
                          <th class="bg-<?=$color;?> text-end">
                          <label for="" class="bg-<?=$configuration->colorSolde($caisse->balanceClient($_SESSION['client_credit'], "gnf"));?> p-2">Solde: <?=$configuration->formatNombre($caisse->balanceClient($_SESSION['client_credit'], "gnf")); ?></label>
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
                          <th class="bg-light text-end"><?=$configuration->formatNombre($caisse->montantFactureClientSolde($_SESSION['client_credit'], "credit")['montant']);?></th>
                        </tr>
                      </thead>
                    </table>
                  </td>
                  <td>
                    <table class="table table-bordered table-striped table-hover align-middle mt-2">
                      <thead>
                        <tr>
                          <th class="">TOTAL FAC</th>
                          <th class=" text-end"><?=$configuration->formatNombre($caisse->nbreFactureClientCredit($_SESSION['client_credit'], "credit")['nbre']);?></th>                
                        </tr>
                        <tr>
                          <th class="">PAYER</th>
                          <th class=" text-end"><?=$configuration->formatNombre($caisse->nbreFactureClientCreditPayer($_SESSION['client_credit'], "credit", 0)['nbre']);?></th>
                        </tr>
                        <tr>
                          <th class="bg-light">FAC IMPAYER</th></th>
                          <th class="bg-light text-end"><?=$configuration->formatNombre($caisse->nbreFactureClientCreditNonPayer($_SESSION['client_credit'], "credit", 0)['nbre']);?></th></th>
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
                <th colspan="14">
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
                <th>Retour-Fac</th>
                <th>Total Act</th>
                <th>Payé</th>
                <th>Date Paye</th>
                <th>Signé le</th>
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

              $cumulTotalFacture=0;
              $cumulMontantAction=0;
              $cumulMontantPaye=0;
              $cumulMontantRemise=0;
              $cumulMontantRetour=0;
              $zero=0;

              foreach ($products as $key=> $product ){
                $prodcmd=$DB->querys("SELECT sum(prix_vente*quantity) as montant FROM commande where num_cmd='{$product->num_cmd}' and quantity<'{$zero}' ");

                $retour=-$prodcmd['montant'];
                $cumulMontantRetour+=$retour;
                $totalFacture=$product->Total-$product->remise+$retour;
                $cumulTotalFacture += $totalFacture;

                $action=$totalFacture-$retour;
                $cumulMontantAction+=$action;
                
                $montantPaye=$product->solde_facture+$product->montantpaye;
                $cumulMontantPaye+=$montantPaye;

                $cumulMontantRemise+=$product->remise;

                $resteSolde=$caisse->resteSoldeFactureClient($product->num_cmd)["reste"];
                if ($resteSolde==0) {
                  $bg="success";
                  $textColor="white";                
                }else{
                  if (!empty($product->signe)) {
                    $bg="secondary";
                    $textColor="white";                
                  }else{
                    $bg="";
                    $textColor="";                
                  }
                }

                

                ?>

                <form action="?clientsearch=<?=$product->num_client;?>&client" method="GET">

                  <tr>
                    <td class="text-center bg-<?=$bg;?> text-<?=$textColor;?>"><?=$key+1;?></td>
                    <td class=" bg-<?=$bg;?> text-<?=$textColor;?>"><a class="btn btn-info fs-6" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><i class="fa-solid fa-file-pdf"></i><?= $product->num_cmd; ?></a></td>
                    <td class="text-center bg-<?=$bg;?> text-<?=$textColor;?>"><?=(new dateTime($product->date_cmd))->format("d/m/Y"); ?></td>
                    <td class=" bg-<?=$bg;?> text-<?=$textColor;?>"><?= $panier->nomClient($product->num_client); ?></td>
                    <td class="text-end bg-<?=$bg;?> text-<?=$textColor;?>"><?=$configuration->formatNombre($totalFacture); ?></td>
                    <td class="text-end bg-<?=$bg;?> text-<?=$textColor;?>"><?=$configuration->formatNombre($product->remise); ?></td>
                    <td class="text-end bg-<?=$bg;?> text-<?=$textColor;?>"><?=$configuration->formatNombre($retour); ?></td>
                    <td class="text-end bg-<?=$bg;?> text-<?=$textColor;?>"><?=$configuration->formatNombre($action); ?></td>
                    <td class="text-end bg-<?=$bg;?> text-<?=$textColor;?>"><?=$configuration->formatNombre($product->solde_facture+$product->montantpaye); ?></td>
                    <td class="text-center bg-<?=$bg;?> text-<?=$textColor;?>"><?= (empty($product->date_solde)) ? "" : (new DateTime($product->date_solde))->format("d/m/Y");?></td>
                    <td class="text-center bg-<?=$bg;?> text-<?=$textColor;?>"><?= (empty($product->signe)) ? "" : (new DateTime($product->signe))->format("d/m/Y");?></td>
                    <td><?php 
                      if ($resteSolde!=0) {?>
                        <input type="hidden" name="clientsearch" value="<?=$product->num_client;?>">
                        <input type="hidden" name="numcmd_check" value="<?=$product->num_cmd;?>">
                        <!-- <input class="form-check-input" type="checkbox" name="check" value="<?=$product->num_cmd;?>" id="flexCheckDefault" onchange="this.form.submit()">  -->
                        <?php                                   
                      }?>
                    </td>

                    </td>
                    <!-- <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-warning" onclick="return alerteM();" href="modifventeprod.php?numcmdmodif=<?=$product->num_cmd;?>"><i class="fa fa-edit"></i></a><?php };?></td> -->
                    <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-warning" href="edition_facture_credit.php?numcmdmodif=<?=$product->num_cmd;?>"><i class="fa fa-edit"></i></a><?php };?></td>
                    <!-- <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-danger" onclick="return alerteS();" href="comptasemaine.php?num_cmd=<?=$product->num_cmd;?>&total=<?=$product->Total-$product->remise;?>"><i class="fa fa-trash"></i></a><?php };?></td> -->
                  </tr>
                </form><?php 
              } ?>   
            </tbody>
            <tfoot>
              <tr>
                <th colspan="4"></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulTotalFacture);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulMontantRemise);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulMontantRetour);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulMontantAction);?></th>
                <th class="text-end"><?= $configuration->formatNombre($cumulMontantPaye);?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div><?php 
        require_once "nav_facturation.php";?>        
    </div><?php 
  }else{
    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";
  }

  require_once('footer.php');
}?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
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