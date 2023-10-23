<?php require 'headerv2.php';
$_SESSION['num_facture_edit_achat']=$_GET['numcmdmodif'];
$bl = $caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['bl'];
$prodverif= $DB->querys("SELECT *FROM stockmouv  WHERE coment='{$bl}' ");
if (isset($_GET['solder'])) {
  $now=date("Y-m-d");
  $etatfp="paye";
  $DB->insert("UPDATE achat_fournisseur SET datepaie='{$now}', etat_achatf='{$etatfp}' WHERE id ='{$_SESSION['num_facture_edit_achat']}' ");?>
  <div class="alert alert-success">facture payé avec succèe !!!</div><?php
}


if ($caisse->soldeClient($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['id_client'], 'gnf')>= 0) {
  $bg='danger';
  $solde=$caisse->soldeClient($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['id_client'], 'gnf');
}else{
  $bg="success";
  $solde=-$caisse->soldeClient($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['id_client'], 'gnf');
}?>

<div class="container-fluid">
    <a class="btn btn-info text-center fw-bold my-2" href="achat_fournisseur.php"><i class="fa-solid fa-backward"></i></a>

  <div class="card m-auto my-2" style="width: 50rem;">
    <div class="card-body">
      <h5 class="card-title">Edition de la facture achat N° <?=$_SESSION['num_facture_edit_achat'];?></h5>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">Nom du Client <?=$caisse->nomClient($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['id_client'])['nom_client'];?></li>

      <li class="list-group-item">Facturée le <?=(new DateTime($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['dateop']))->format("d/m/Y");?></li>

      <li class="list-group-item">Montant de la facture : <?=$configuration->formatNombre($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['montant']);?></li>

      <li class="list-group-item bg-<?=$bg;?>">Solde Client : <?=$configuration->formatNombre($solde);?></li>

      <li class="list-group-item">Payé le : <?= (empty($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['datepaie'])) ? "" : (new DateTime($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['datepaie']))->format("d/m/Y");?>  </li>

    </ul>
    <div class="card-body"><?php
      if ($caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['etat_achatf']!="paye") {?>
        <a href="?solder&numcmdmodif=<?=$_SESSION['num_facture_edit_achat'];?>" onclick="return alerteSolder()" class="card-link btn btn-success">Payer la facture</a><?php
      }?>

      <a class="card-link btn btn-warning" onclick="return alerteM();" href="achat_fournisseur.php?update=<?=$caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['numedit'];?>">Modifier</a>

      <?php if ($_SESSION['level']>=6 and empty($prodverif['id'])){?><a class="card-link btn btn-danger" onclick="return alerteS();" href="achat_fournisseur.php?deleteret=<?=$caisse->achatClientFournisseurById($_SESSION['num_facture_edit_achat'])['numedit'];?>">Supprimer</a><?php }?>

    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
  function alerteS(){
    return(confirm('Confirmer la suppression'));
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