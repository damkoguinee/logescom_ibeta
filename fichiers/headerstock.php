<div class="col-sm-12 col-md-12 p-3 bg-success bg-opacity-50 mt-2 ">

  <div class="container-fluid">
    <div class="row"> <?php 

      if ($_SESSION['level']>=3) {?>

          <div class="col-sm-4 col-md-4"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="stockmouv.php">Mouv Produit <?=$panier->nomStock($_SESSION['idnomstock'])[0];?></a></div></div>

          <div class="col-sm-4 col-md-4"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="stockgeneral.php?nomstock=<?=$_SESSION['idnomstock'];?>">Voir <?=ucwords($panier->nomStock($_SESSION['idnomstock'])[0]);?></a></div></div>

          <div class="col-sm-4 col-md-4"><div class=" col text-center"><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="pertes.php?listep&?nomstock=<?=$_SESSION['idnomstock'];?>">Pertes <?=$panier->nomStock($_SESSION['idnomstock'])[0];?></a></div></div>

          <?php 
      }?>
    </div>
  </div>
</div>

<?php require 'footer.php';?>