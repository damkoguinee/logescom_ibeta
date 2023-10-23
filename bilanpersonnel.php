<?php
require 'headerv2.php';?>

<div class="container-fluid mt-3">
  <div class="row"><?php 

    require 'navpers.php';?>

    <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

		if (!empty($_SESSION['pseudo'])) {

			$client=$_GET['id'];
			$devise=$_GET['devise'];

			$soldea=0;
			$solded=0;
			$soldes=0;
			$soldet=0;
			$solde=0;
			$zero=0;

			$prod =$DB->query("SELECT bulletin.nom_client as client, libelles, numero, montant, date_versement, devise, lieuvente FROM bulletin WHERE nom_client='{$client}' and devise='{$devise}' ORDER BY (date_versement)");
			?>

			<table class="table table-hover table-bordered table-striped table-responsive text-center">

				<thead>
					<tr>
						<th colspan="6">Relevé de <?=$panier->nomPersonnelId($client);?>
						<a class="btn btn-light fs-4" href="#"><i class="fa-solid fa-file-pdf" style="color: #801443;"></i></a>
						<a class="btn btn-light fs-4" href="csv.php?personnelbull=<?=$client;?>" target="_blank"><i class="fa-solid fa-file-excel" style="color: #27511f;"></i></a>
					</th>

						<th style="font-size: 20px; color: orange;">Compte <?=strtoupper($devise);?></th>
					</tr>

					<tr>
						<th>Ordre</th>
						<th>Date</th>
						<th>Désignation</th>
						<th>Facturation</th>
						<th>Encaissement</th>
						<th>Décaissement</th>
						<th>Solde</th>
					</tr>
				</thead>
				<tbody><?php 
					$solde=0;
					foreach ($prod as $key => $value) {

						$produit =$DB->query("SELECT * FROM commande WHERE num_cmd='{$value->numero}'");

						$solde+=$value->montant;?>

						<tr>
							<td style="text-align: center;"><?=$key+1;?></td>

							<td style="text-align: center;"><?=(new dateTime($value->date_versement))->format('d/m/Y');?></td><?php 

							if ($value->libelles=='reste à payer') {

								$soldea+=$value->montant;?>

								<td>
									<a class="text-danger" href="recherche.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' facture '.$value->numero;?></a>
								</td>
								
								<td class="bg-<?=$panier->colorb($value->montant);?> text-white"><?=number_format((-1)*$value->montant,0,',',' ');?></td>

								<td></td>
								<td></td>
								<td class="bg-<?=$panier->colorb($solde);?> text-white"><?=number_format(-$solde,0,',',' ');?></td><?php

							}elseif($value->libelles!='reste à payer' and $value->montant>=0){

								$solded+=$value->montant;?>

								<td><a class="text-danger" href="versement.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
								<td></td>						
								<td class="bg-<?=$panier->colorb($value->montant);?> text-white"><?=number_format($value->montant,0,',',' ');?></td>
								<td></td>
								<td class="bg-<?=$panier->colorb($solde);?> text-white"><?=number_format(-$solde,0,',',' ');?></td><?php

							}else{

								$soldes+=$value->montant;;?>

								<td><a class="text-danger" href="dec.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
								<td></td>
								<td></td>	

								<td class="bg-<?=$panier->colorb($value->montant);?> text-white"><?=number_format((-1)*$value->montant,0,',',' ');?></td>

								<td class="bg-<?=$panier->colorb($solde);?> text-white"><?=number_format(-$solde,0,',',' ');?></td><?php

							}?>
						</tr><?php 
					}?>
				</tbody>

			</table>
		</div>
	</div>
</div><?php
	// code...
}