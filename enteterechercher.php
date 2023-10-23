<div class="col-sm-12 col-md-2 pb-3 " style="background-color: #253553;"><?php 
  if (!empty($_SESSION['proformat'])) {?> 
    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="printproformat.php?ticket&proformat=<?=$_SESSION['num_cmdp'];?>" target="_blank">Imprimer le Proformat</a></div>
    </div><?php 
    unset($_SESSION['proformat']); 
  }else{
    if (isset($_GET['recreditc'])) {

      $_SESSION['num_cmdp']=$_GET['recreditc'];
    }?>

    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="printticket.php?ticket" target="_blank">Imprimer la Facture</a></div>
    </div>

    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="prepacommande.php?bon" target="_blank">Prépa-Commandes</a></div>
    </div>

    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="boncommande.php?bon" target="_blank">Bon de Livraison</a></div>
    </div>
    <div class="row mt-3">
      <div class="col" ><a style="width: 100%; " class="btn btn-light text-center fw-bold" href="livraison.php?livraison=<?=$_SESSION['num_cmdp'];?>" target="_blank">Livraison</a></div>
    </div><?php 
  }?>
</div>