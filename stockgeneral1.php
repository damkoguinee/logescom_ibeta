<?php require 'headerv2.php';

if (isset($_GET['nomstock']) and $_GET['nomstock']!=0) {

    $_SESSION['nomtab']=$panier->nomStock($_SESSION['idnomstock'])[1];

}else{

    $_SESSION['idnomstock']=0;
    $_SESSION['nomstock']='stock general';

}?>
<div class="container-fluid">

	<div class="row"><?php
    	require 'navstock.php';?>

    	<div class="col-sm-12 col-md-10"><?php 

  			$colspan=count($panier->listeStock());?>
          	<table class="table table-hover table-bordered table-striped table-responsive text-center">		

				<thead>

					<tr>
						<th colspan="<?=$colspan+4;?>"><?="Etat du Stock à la date du " .date('d/m/Y'); ?><a class="btn btn-warning" href="printstock1.php?stock=<?=$_GET['recherche'];?>" target="_blank" ><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a> 

						<input class="form-control" id="search-user" type="text" name="recherchgen" placeholder="rechercher un produit" />

						<div class="bg-danger" id="result-search"></div></th>
					</tr>

					<tr>
						<th>Reference</th><?php

						foreach ($panier->listeStock() as $value) {?>

							<th><?=$value->nomstock;?></th><?php
						}?>

						<th>Total</th>
						<th>Non Livré</th>
						<th>dispo</th>

					</tr>

				</thead>

				<tbody><?php 

					foreach ($panier->listeProduit() as $key => $valuep) {?>

						<tr>
							<td class="text-start"><?=ucwords(strtolower($valuep->Marque));?></td><?php

							$totqtite=0;

							foreach ($panier->listeStock() as $valueS) {

								$prodqtite = $DB->querys("SELECT quantite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$valuep->id}'");

								$totqtite+=$prodqtite['quantite'];

								if (empty($prodqtite['quantite'])) {
									$qtite='';
								}else{
									$qtite=number_format($prodqtite['quantite'],0,',',' ');
								} ?>

								<td style="text-align: center;"><?=$qtite;?></td><?php


							}

							$prodcmd=$DB->querys("SELECT sum(quantity-qtiteliv) as qtitenl from commande where id_produit='{$valuep->id}'");

							$nonlivre=$prodcmd['qtitenl'];

							$dispo=$totqtite-$nonlivre;

							if (empty($totqtite)) {
								$totqtite='';
							}else{
								$totqtite=number_format($totqtite,0,',',' ');
							}


							if (empty($nonlivre)) {
								$nonlivre='';
							}else{
								$nonlivre=number_format($nonlivre,0,',',' ');
							}

							if (empty($dispo)) {
								$dispo='';
							}else{
								$dispo=number_format($dispo,0,',',' ');
							}?>

							<td><?=$totqtite;?></td>

							<td><?=$nonlivre;?></td>

							<td><?=$dispo;?></td>    				

						</tr><?php
					}?>

				</tbody>
			</table>
  		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?stockgeneral',
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