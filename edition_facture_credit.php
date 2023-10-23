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



  $solde=$caisse->balanceClient($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['num_client'], "gnf");  ?>

<div class="container-fluid">
  <a class="btn btn-info text-center fw-bold my-2" href="facturations.php"><i class="fa-solid fa-backward"></i></a>

  <div class="row">
    <div class="card m-auto my-2 col-sm-12 col-md-4">
      <div class="card-body">
        <h5 class="card-title">Edition de la facture N° <?=$_SESSION['num_facture_edition'];?></h5>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Nom du Client : <?=$caisse->nomClient($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['num_client'])['nom_client'];?></li>
        <li class="list-group-item">Facturée le : <?=(new DateTime($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['date_cmd']))->format("d/m/Y");?></li>
        <li class="list-group-item">Montant de la facture : <?=$configuration->formatNombre($total_action+$retour_facture);?></li>
        <li class="list-group-item">Montant Retour : <?=$configuration->formatNombre($retour_facture);?></li>
        <li class="list-group-item">Total Action : <?=$configuration->formatNombre($total_action);?></li>
  
        <li class="list-group-item">
          Etat Livraison : <?=$caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['etatliv'];?>
          <a href="" class="btn btn-info" onclick="return alerte()">Tout Livrer</a>
        </li>
  
        <li class="list-group-item bg-<?=$configuration->colorSolde($caisse->balanceClient($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['num_client'], "gnf"));?> p-2">Balance Client : <?=$configuration->formatNombre($caisse->balanceClient($caisse->infosFactureByNumero($_SESSION['num_facture_edition'])['num_client'], "gnf")); ?></li>
  
  
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
  
        <a class="card-link btn btn-danger" onclick="return alerteS();" href="comptasemaine.php?num_cmd=<?=$_SESSION['num_facture_edition'];?>&total=<?=$total_action ;?>">Supprimer</a>
  
      </div>
    </div> 
  
    <div class="col-sm-12 col-md-8">
      <table class="table table-bordered table-striped table-hover align-middle text-center">
  
        <thead>
  
          <tr>
            <th>Référence</th>
            <th>Qtité cmd</th>
            <th>Qtité Livré</th>
            <th>Reste à Livré</th>
            <th>Livraison</th>
            <th>Choix Stock</th>
            <th></th>
          </tr>
  
        </thead>
  
        <tbody><?php
  
          $total=0;
          $totqtiteliv=0;
  
          $products=$DB->query('SELECT commande.id as idc, productslist.id as id, sum(quantity) as quantity, sum(qtiteliv) as qtiteliv, commande.prix_vente as prix_vente, designation, num_cmd, codecat, type, Marque FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ? GROUP BY (id) order by(type)', array($_SESSION['num_facture_edition']));
          $totqtite=0;
          foreach ($products as $product){
  
            $qtitecmd=$product->quantity;
            $totqtite+=$qtitecmd;
  
            $qtiteliv=$product->qtiteliv;
  
            $totqtiteliv+=$qtiteliv;
  
            $reste=$qtitecmd-$qtiteliv;
  
            if ($reste==0) {
              $etat='livraison terminée';
            }else{
              $etat='en-cours';
            } ?>
  
            <form class="form" method="GET" action="livraison_traitement.php?numcmdmodif=<?=$_SESSION['num_facture_edition'];?>">
  
              <tr>           
  
                <td class="text-start"><?=strtolower($product->Marque); ?></td>
  
                <td><?= $product->quantity; ?></td>
  
                <td><?= $product->qtiteliv; ?></td>
  
                <td><?= $reste; ?></td>
  
                <input class="form-control" type="hidden" name="id" value="<?=$product->id;?>">
  
                <input class="form-control" type="hidden" name="idc" value="<?=$product->idc;?>">
  
                <input class="form-control" type="hidden" name="numcmd" value="<?=$product->num_cmd;?>">
  
                <input class="form-control" type="hidden" name="type" value="<?=$product->type;?>">
  
                <input class="form-control" type="hidden" name="marque" value="<?=$product->Marque;?>">
  
                <td><?php if ($reste==0) {echo $etat;}else{?><input class="form-control" type="float" name="qtiteliv" max="<?=$reste;?>" placeholder="inserer la qtité"><?php }?></td>
  
                <td><?php if ($reste==0) {echo $etat;}else{?>
                  <select class="form-select" name="lstock" required="" >
  
                    <option></option><?php
  
                    foreach ($panier->listeStock() as $values) {
  
                      $reststock=$DB->querys("SELECT quantite as qtite FROM `".$values->nombdd."` WHERE idprod='{$product->id}'");
  
                      $typegros='en_gros';
  
                      $searchengros=$DB->querys("SELECT Marque as marque FROM `".$values->nombdd."` inner join productslist on idprod=productslist.id  WHERE idprod='{$product->id}'");
  
                      $engros=$DB->querys("SELECT id FROM productslist  WHERE Marque='{$searchengros['marque']}' and type='{$typegros}'");
  
                      $restengros=$DB->querys("SELECT quantite as qtite FROM `".$values->nombdd."` WHERE idprod='{$engros['id']}'");
  
                      if ($product->type!='en_gros') {
                        if (!empty($restengros['qtite'])) {?>
  
                          <option value="<?=$values->id;?>"><?=$values->nomstock.' dispo carton '.$restengros['qtite'];?></option><?php
                        }
                      }
  
                      if (!empty($reststock['qtite'])) {?>
  
                        <option value="<?=$values->id;?>"><?=$values->nomstock.' dispo '.$reststock['qtite'];?></option><?php
                      }
                      
                    }?>              
                  </select><?php }?>
                </td>
  
                <td><?php 
                  if ($reste==0) {
                    echo $etat;
                  }else{?>
                    <button class="btn btn-primary" type="submit" name="validl" onclick="return alerteL();" >Livrer</button><?php 
                  }?>
                </td>
  
              </tr>
            </form><?php
          }?>     
  
        </tbody>
  
        <tfoot>
          <tr>
            <th class="text-start">Totaux</th>
            <th><?=number_format($totqtite,0,',',' ');?></th>
            <th><?=number_format($totqtiteliv,0,',',' ');?></th>
            <th><?=number_format($totqtite-$totqtiteliv,0,',',' ');?></th>
            <th><a href="?numcmdmodif=<?=$_SESSION['num_facture_edition'];?>" class="btn btn-warning" type="submit" name="validl" onclick="return alerteL();" >Tout Livrer</a></th>
          </tr>
        </tfoot>
  
      </table>
    </div>

  </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
  function alerte(){
    return(confirm('Confirmer cette opération'));
  }

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

  function alerteL(){
      return(confirm('Confirmer la livraison'));
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