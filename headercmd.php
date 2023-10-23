<?php  

if ($_SESSION['level']>=6) {?>
  <div class="col-sm-12 col-md-3 my-2">
    <a class="btn btn-warning" href="commandetrans.php?transfert">Transfert Produits</a>
  </div> 

  <div class="col-sm-12 col-md-3 my-2">
    <a class="btn btn-warning" href="transfertprod.php?listetrans">Liste des Transferts</a>
  </div>

  <div class="col-sm-12 col-md-3 my-2">
    <a class="btn btn-warning" href="listeapprovisionnement.php?listeapp">Liste des Approvisionnements</a>
  </div><?php 
}?>

  