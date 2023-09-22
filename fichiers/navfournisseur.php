<div class="col-sm-12 col-md-2 pb-3" style="background-color: #253553;"><?php 

  if ($_SESSION['level']>6) {?>

      <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="editionfacturefournisseur.php?recette">Gestion des Commandes</a></div></div>

      <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="gestionachatfournisseur.php?transfert">Fournisseurs vers Transporteurs</a></div></div>

      <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="gestiontransport.php?listetrans">Transporteurs vers Client Final</a></div></div>

      <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="gestionreception.php?listeapp">Receptionner</a></div></div><?php 
  }?>
</div>