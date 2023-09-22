<?php require 'headerv2.php';
$_SESSION['num_facture_edition']=$_GET['numcmdmodif'];
if (isset($_GET['signe'])) {
  $now=date("Y-m-d");
  $DB->insert("UPDATE payement SET signe='{$now}' WHERE num_cmd='{$_SESSION['num_facture_edition']}' ");?>
  <div class="alert alert-success">facture signée avec succèe !!!</div><?php
}

if (isset($_GET['solder'])) {
  $now=date("Y-m-d");
  $soldemaj=$_GET['solder'];
  $DB->insert("UPDATE payement SET date_solde='{$now}', solde_facture='{$soldemaj}' WHERE num_cmd='{$_SESSION['num_facture_edition']}' ");?>
  <div class="alert alert-success">facture soldé avec succèe !!!</div><?php
}

$retour_facture=-$caisse->retourFactureByNumero($_SESSION['num_facture_edition'])['montant'];
$total_action = $caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['Total']-$caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['remise'];

$queryReste = $DB->querys("SELECT SUM(Total-remise-solde_facture) as reste, solde_facture as solde FROM payement where num_cmd ='{$_SESSION['num_facture_edition']}' ");

$resteSolde=$caisse->resteSoldeFactureClient($_SESSION['num_facture_edition'])["reste"];
$ancienSolde=$queryReste['solde'];
$soldeActuel=$queryReste['solde']+$resteSolde;


if ($caisse->soldeClient($_SESSION['client_credit'], 'gnf')>= 0) {
  $bg='danger';
  $solde=$caisse->soldeClient($_SESSION['client_credit'], 'gnf');
}else{
  $bg="success";
  $solde=-$caisse->soldeClient($_SESSION['client_credit'], 'gnf');
}?>

<div class="container-fluid">

  <div class="card m-auto my-2" style="width: 25rem;">
    <div class="card-body">
      <h5 class="card-title">Edition de la facture N° <?=$_SESSION['num_facture_edition'];?></h5>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Nom du Client <?=$caisse->nomClient($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['num_client'])['nom_client'];?></li>
      <li class="list-group-item">Facturée le <?=(new DateTime($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['date_cmd']))->format("d/m/Y");?></li>
      <li class="list-group-item">Montant de la facture : <?=$configuration->formatNombre($total_action+$retour_facture);?></li>
      <li class="list-group-item">Montant Retour : <?=$configuration->formatNombre($retour_facture);?></li>
      <li class="list-group-item">Total Action : <?=$configuration->formatNombre($total_action);?></li>

      <li class="list-group-item bg-<?=$bg;?>">Solde Client : <?=$configuration->formatNombre($solde);?></li>

      <li class="list-group-item">Signé le : <?= (empty($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['signe'])) ? "" : (new DateTime($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['signe']))->format("d/m/Y");?>  </li>

    </ul>
    <div class="card-body"><?php 
      if ((empty($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['signe']))) {?>
        <a href="?signe&numcmdmodif=<?=$_SESSION['num_facture_edition'];?>" onclick="return alerteSigner()" class="card-link btn btn-info">Signé</a><?php 
      }

      if ($solde>=$resteSolde and $resteSolde > 0 ) {?>
        <a href="?solder=<?=$soldeActuel;?>&numcmdmodif=<?=$_SESSION['num_facture_edition'];?>" onclick="return alerteSolder()" class="card-link btn btn-success">Solder la facture</a><?php
      }?>

      <a class="card-link btn btn-warning" onclick="return alerteM();" href="modifventeprod.php?numcmdmodif=<?=$_SESSION['num_facture_edition'];?>">Modifier</a>

    </div>
  </div><?php 
  require_once "nav_facturation.php";?> 
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
  function alerteS(){
    return(confirm('Valider la suppression'));
  }

  function alerteM(){
    return(confirm('Voulez-vous vraiment modifier cette vente?'));
  }
  function alerteSigner(){
    return(confirm('Voulez-vous vraiment signer cette facture ?'));
  }
  function alerteSolder(){
    return(confirm('Voulez-vous vraiment solder cette vente?'));
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