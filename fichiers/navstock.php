<div class="col-sm-12 col-md-2 pb-3" style="background-color: #253553;"> 
    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="ajoutstock.php?listep">Liste des Stocks</a></div>
    </div>

    <div class="row mt-3">

      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="ajout.php?listep">Liste des Produits</a></div>
    </div>
    
    <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="categorie.php">Liste des Catégories</a></div></div>
    <?php 

    if ($_SESSION['level']>6) {?>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="ajout.php?ajoutprod">Nouveau Produit</a></div></div>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="editionfacturefournisseur.php?recette">Achats Fournisseurs</a></div></div>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="editionreceptionf.php?transfert">Approvision...init</a></div></div>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="commandetrans.php?transfert">Transfert des Produits</a></div></div>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="transfertprod.php?listetrans">Liste des Transferts</a></div></div>

        <div class="row mt-3"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="listeapprovisionnement.php?listeapp">Liste des Approvisionnements</a></div></div><?php 
    }?>
</div>

<?php require 'footer.php';?>