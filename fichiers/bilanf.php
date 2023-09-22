<?php
require 'header.php';

if (!empty($_SESSION['pseudo'])) {

	if ($products['level']>=3) {

		if (!isset($_POST['j1'])) {

		    $_SESSION['date']=date("Ymd");  
		    $dates = $_SESSION['date'];
		    $dates = new DateTime( $dates );
		    $dates = $dates->format('Ymd'); 
		    $_SESSION['date']=$dates;
		    $_SESSION['date1']=$dates;
		    $_SESSION['date2']=$dates;
		    $_SESSION['dates1']=$dates; 

		}else{

		    $_SESSION['date1']=$_POST['j1'];
		    $_SESSION['date1'] = new DateTime($_SESSION['date1']);
		    $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
		    
		    $_SESSION['date2']=$_POST['j2'];
		    $_SESSION['date2'] = new DateTime($_SESSION['date2']);
		    $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

		    $_SESSION['dates1']=$_SESSION['date1'];
		    $_SESSION['dates2']=$_SESSION['date2'];   
		}

    	require 'navbulletin.php';
    	$client=$_GET['bclient'];
    	$devise=$_GET['devise'];

    	$soldea=0;
      	$solded=0;
      	$soldes=0;
      	$soldet=0;
      	$solde=0;
      	$zero=0;
      	if (isset($_POST['j1']) or isset($_POST['j2'])) {

        	$prod =$DB->query("SELECT client.nom_client as client, libelles, numero, montant, date_versement, devise, lieuvente FROM bulletin inner join client on client.id=bulletin.nom_client WHERE bulletin.nom_client='{$client}' and DATE_FORMAT(date_versement, \"%Y%m%d\") >='{$_SESSION['date1']}' and DATE_FORMAT(date_versement, \"%Y%m%d\") <='{$_SESSION['date2']}' ORDER BY (date_versement)");

      	}else{

        	$prod =$DB->query("SELECT bulletin.nom_client as client, libelles, numero, montant, date_versement, devise, lieuvente FROM bulletin inner join client on client.id=bulletin.nom_client WHERE bulletin.nom_client='{$client}' and devise='{$devise}' ORDER BY (date_versement)");
      	}?>

    	<table class="payement">
    		<thead>
    			<tr>
    				<th colspan="6" style="font-size: 20px;">Relevé de <?=$panier->nomClient($client);?> Tel: <?=$panier->nomClientad($client)[1];?><a style="margin-left: 10px;"href="printcompte.php?compte=<?=$client;?>&tel=<?=$panier->nomClientad($client)[1];?>&devise=<?=$devise;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></th>

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

    				$solde+=$value->montant;?>

    				<tr>
						<td style="text-align: center;"><?=$key+1;?></td>

						<td style="text-align: center;"><?=(new dateTime($value->date_versement))->format('d/m/Y');?></td><?php 

					if ($value->libelles=='reste à payer') {

						$soldea+=$value->montant;

						if ($devise=='gnf' or $devise=='cfa') {
			                $montantc=number_format(-$value->montant,0,',',' ');

			                $soldec=number_format(-$solde,0,',',' ');
			            }else{

			                $montantc=number_format(-$value->montant,2,',',' ');

			                $soldec=number_format(-$solde,2,',',' ');
			            }?>

						<td>
							<a style="color: red;" href="recherche.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' facture '.$value->numero;?></a>
						</td>
						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=$montantc;?></td>

						<td></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldec;?></td><?php

					}elseif($value->libelles=='Commande Fournisseur'){

						$solded+=$value->montant;

						if ($devise=='gnf' or $devise=='cfa') {
			                $montantc=number_format($value->montant,0,',',' ');

			                $soldec=number_format(-$solde,0,',',' ');
			            }else{

			                $montantc=number_format($value->montant,2,',',' ');

			                $soldec=number_format(-$solde,2,',',' ');
			            }?>

						<td><a style="color: red;" target="_blank" href="printcmd.php?print=<?=$value->numero;?>&client=<?=$value->client;?>&lieuvente=<?=$value->lieuvente;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
						<td></td>						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=$montantc;?></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldec;?></td><?php

					}elseif($value->libelles=='retour produit'){

						$solded+=$value->montant;

						if ($devise=='gnf' or $devise=='cfa') {
			                $montantc=number_format($value->montant,0,',',' ');

			                $soldec=number_format(-$solde,0,',',' ');
			            }else{

			                $montantc=number_format($value->montant,2,',',' ');

			                $soldec=number_format(-$solde,2,',',' ');
			            }?>

						<td><a style="color: red;" href="retourlistclient.php?ajout=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=ucwords(strtolower($value->libelles)).' N°'.$value->numero;?></a></td>
						<td></td>						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=$montantc;?></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldec;?></td><?php

					}elseif($value->libelles!='reste à payer' and $value->montant>=0){

						$solded+=$value->montant;

						if ($devise=='gnf' or $devise=='cfa') {
			                $montantc=number_format($value->montant,0,',',' ');

			                $soldec=number_format(-$solde,0,',',' ');
			            }else{

			                $montantc=number_format($value->montant,2,',',' ');

			                $soldec=number_format(-$solde,2,',',' ');
			            }?>

						<td><a style="color: red;" href="versement.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=strtoupper($value->libelles).' N°'.$value->numero;?></a></td>
						<td></td>						
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=$montantc;?></td>
						<td></td>
						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldec;?></td><?php

					}else{

						$soldes+=$value->montant;

						if ($devise=='gnf' or $devise=='cfa') {
			                $montantc=number_format(-$value->montant,0,',',' ');

			                $soldec=number_format(-$solde,0,',',' ');
			            }else{

			                $montantc=number_format(-$value->montant,2,',',' ');

			                $soldec=number_format(-$solde,2,',',' ');
			            }?>

						<td><a style="color: red;" href="dec.php?recreditc=<?=$value->numero;?>&reclient=<?=$value->client;?>"><?=strtoupper($value->libelles).' N°'.$value->numero;?></a></td>
						<td></td>
						<td></td>	

						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($value->montant);?>"><?=$montantc;?></td>

						<td style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldec;?></td><?php

					}?>
					</tr><?php 
				}?>
			</tbody>

			<tfoot>
				<tr><?php 

					if ($devise=='gnf' or $devise=='cfa') {
		                $soldeaa=number_format(-$soldea,0,',',' ');
		                $soldess=number_format(-$soldes,0,',',' ');
		                $soldee=number_format(-$solde,0,',',' ');
		            }else{

		                $soldeaa=number_format(-$soldea,2,',',' ');
		                $soldess=number_format(-$soldes,2,',',' ');
		                $soldee=number_format(-$solde,2,',',' ');
		            }

		            if ($devise=='gnf' or $devise=='cfa') {
		                $soldedd=number_format(-$solded,0,',',' ');
		            }else{

		                $soldedd=number_format(-$solded,2,',',' ');
		            }?>

					<th colspan="3">Totaux</th>
					<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($soldea);?>"><?=$soldeaa;?></th>

					<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solded);?>"><?=$soldedd;?></th>

					<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($soldes);?>"><?=$soldess;?></th>

					<th style="font-size: 20px; text-align: right; color: white; background-color: <?=$panier->color($solde);?>"><?=$soldee;?></th>
				</tr>
			</tfoot>

    	</table><?php


    }else{?>

    	<div class="alertes">Vous n'avez pas toutes les autorisations réquises</div><?php

    }
	// code...
}