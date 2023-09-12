<?php require 'headerv2.php';?>
<div class="container-fluid mt-3">
    <div class="row"><?php 

        require 'navcaisse.php';?>

        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

        if (isset($_POST['delete'])) {
            $idclient=$panier->h($_POST['client']);
            $numc=$panier->h($_POST['numc']);
            $numcmd=$panier->h($_POST['numcmd']);
            $montant=$panier->h($panier->espace($_POST['montant']));
            $DB->delete("DELETE FROM bulletin where libelles='{$numc}'");
            $DB->delete("DELETE FROM ventecommission where numcmd='{$numcmd}'");
           ?>

            <div class="alert alert-success">Opération supprimé avec succèe !!!</div><?php
        }
        
        if (isset($_POST['updateMontant'])) {
            $idclient=$panier->h($_POST['client']);
            $numc=$panier->h($_POST['numc']);
            $numcmd=$panier->h($_POST['numcmd']);
            $montant=$panier->h($panier->espace($_POST['montant']));
            $DB->insert("UPDATE bulletin SET montant='{$montant}' where libelles='{$numc}'");
            $DB->insert("UPDATE ventecommission SET montant='{$montant}' where numcmd='{$numcmd}'");
           ?>

            <div class="alert alert-success">Opération Modifiée avec succèe !!!</div><?php
        }
        
        if (isset($_POST['ajoutCom']) and !empty($_POST['montant'])) {
			$montantCom=$panier->h($panier->espace($_POST['montant']));
			$clientCom=$panier->h($_POST['client']);
			$numcmd=$panier->h($_POST['numcmdAjout']);
			$prodc=$DB->querys("SELECT max(id) as id FROM ventecommission");
			$numcount=$prodc['id']+1;
			$numc="commission".$numcount;			

			
            $DB->insert("INSERT INTO ventecommission(numc, numcmd, idclient, montant, idpers, dateop)VALUES(?, ?, ?, ?, ?, now())", array($numc, $numcmd, $clientCom, $montantCom, $_SESSION['idpseudo']));

            $DB->insert('INSERT INTO bulletin (nom_client, montant, devise, libelles, numero, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($clientCom, $montantCom, 'gnf', $numc, $numcmd, $_SESSION['lieuvente'], $_SESSION['lieuvente']));

			
		}?>

        <div class="row"><?php
            if (!isset($_POST['ajoutCom'])) {?>
            
                <div class="col-sm-12 col-md-4"><?php 
                    if (isset($_GET['ajoutCom']) or isset($_POST['numcmdAjout'])) {?>

                        <form class="form" action="" method="POST">
                            <div class="my-2">
                                <label class="form-label" for="numcmd">N° Facture</label><?php
                                if (isset($_POST['numcmdAjout'])) {
                                    $numcmd=$panier->h($_POST['numcmdAjout']);
                                    $payement=$DB->querys("SELECT *FROM payement where num_cmd='{$numcmd}' ");
                                    $verifCom=$DB->querys("SELECT *FROM ventecommission where numcmd='{$numcmd}' ");
                                    ?>
                                    <input type="text" name="numcmdAjout" value="<?=$numcmd;?>"  onchange="this.form.submit()" class="form-control">
                                    <input type="hidden" name="client" value="<?=$payement['num_client'];?>">
                                    <?php
                                }else{?>
                                    <input type="text" name="numcmdAjout"  onchange="this.form.submit()" class="form-control"><?php
                                }?>
                            </div>
            
                            <?php 
                            if (empty($verifCom['id'])) {?>
                                <div class="my-2">
                                    <label class="form-label" for="numcmd">Montant de la Commission</label>
                                    <input type="text" name="montant"  class="form-control">
                                </div>
                                <button class="btn btn-success" type="submit" name="ajoutCom" onclick="return alerteV();">Ajouter</button></td><?php
                            }else{?>
                                <div class="btn btn-warning">Une Commission de <?=number_format($verifCom['montant'],0,',',' ');?> existe pour cette facture</div></td><?php

                            }?> 
                        </form><?php
                    }?>

                </div>
                <div class="col-sm-12 col-md-8"><?php 
                    if (isset($_POST['numcmdAjout'])) {
                        $numcmd=$panier->h($_POST['numcmdAjout']);
                        $payement=$DB->querys("SELECT *FROM payement where num_cmd='{$numcmd}' ");
                        $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($numcmd));

                        ?>

                        <table class="table table-hover table-bordered table-striped table-responsive text-center my-2">

                            <tbody>

                                <tr>            
                                    <th>Désignation</th>
                                    <th>Qtité</th>
                                    <th>Livré</th>
                                    <th>Prix Unitaire</th>
                                    <th>Prix Total</th>
                                </tr>

                            </tbody>

                            <tbody><?php

                                $total=0;

                                $products=$DB->query('SELECT quantity, commande.prix_vente as prix_vente, designation, qtiteliv, type FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ?', array($numcmd));

                                $nbreligne=sizeof($products);
                                $totqtite=0;
                                $totqtiteliv=0;

                                $totqtitep=0;
                                $totqtitelivp=0;
                                $totqtited=0;
                                $totqtitelivd=0;
                                foreach ($products as $product){

                                    if ($product->type=='en_gros') {
                                    $totqtite+=$product->quantity;

                                    $totqtiteliv+=$product->qtiteliv;
                                    }elseif ($product->type=='detail') {
                                    $totqtited+=$product->quantity;

                                    $totqtitelivd+=$product->qtiteliv;
                                    }else{

                                    $totqtitep+=$product->quantity;

                                    $totqtitelivp+=$product->qtiteliv;
                                    }

                                    if (empty($product->prix_vente)) {
                                    $pv='Offert';
                                    $pvtotal='Offert';
                                    }else{
                                    $pv=number_format($product->prix_vente,0,',',' ');
                                    $pvtotal=number_format($product->prix_vente*$product->quantity,0,',',' ');
                                    }?>

                                    <tr>

                                    <td><?=ucwords(strtolower($product->designation)); ?></td>

                                    <td><?= $product->quantity; ?></td>

                                    <td><?= $product->qtiteliv.'/'.$product->quantity; ?></td>

                                    <td><?=$pv; ?></td>

                                    <td><?= $pvtotal; ?></td><?php

                                    $price=($product->prix_vente*$product->quantity);

                                    $total += $price;?>

                                    </tr><?php
                                }

                                if (!empty($frais['motif'])) {

                                    $nbreligne=sizeof($products)+1;?>

                                    <tr>              
                                    <td><?=ucwords($frais['motif']); ?></td>
                                    <td>-</td>
                                    <td>-</td>

                                    <td><?=number_format($frais['montant'],0,',',' '); ?></td>

                                    <td><?= number_format($frais['montant'],0,',',' '); ?></td>
                                    </tr><?php
                                }

                                $total=$total+$frais['montant'];

                                $montantverse=$payement['montantpaye'];

                                $Remise=$payement['remise'];

                                $reste=$payement['reste'];

                                $ttc = $total-$Remise;

                                $tot_Rest = $total-$montantverse;

                                if ($nbreligne==1) {

                                    $top=(20/($nbreligne));
                                }else{

                                    $top=(20-($nbreligne*10));
                                }
                                ?>

                                <tr>

                                    <td colspan="3" style="border:1px; border-bottom: 0px; padding-top: <?=$top.'px';?>;" class="space"></td>
                                    <td colspan="2" style="border:1px; padding-top:<?=$top.'px';?>;" class="space"></td>
                                </tr>

                                <tr>
                                    <td colspan="3" rowspan="4" style="padding: 2px; text-align: left; font-size:10px;">
                                    </td>
                                </tr>

                                <tr>
                                    <td style="text-align: right; border-left: 1px;" class="no-border">Montant Total </td>
                                    <td style="text-align:right; padding-right: 5px;"><?php echo number_format($total,0,',',' ') ?></td>
                                </tr>

                                <tr>
                                    <td style="text-align: right;" class="no-border">Montant Remise</td>               
                                    <td style="text-align:right; padding-right: 5px;"><?php echo number_format($Remise,0,',',' ') ?></td>        
                                </tr>

                                <tr>
                                    <td style="text-align: right; margin-bottom: 5px" class="no-border">Net à Payer </td>
                                    <td style="text-align:right; padding-right: 5px;"><?php echo number_format($ttc,0,',',' ') ?></td>
                                </tr>

                            </tbody>

                            <tbody>

                                <tr><?php

                                    if ($tot_Rest<=0) {?>
                                    
                                    <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?></td>

                                    <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Rendu au Client: ".number_format(-$reste,0,',',' ');?> GNF</td><?php

                                    }else{?>

                                    <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".number_format($montantverse,0,',',' ');?> GNF</td>

                                    <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Reste à Payer: ".number_format($tot_Rest-$Remise,0,',',' ');?> GNF</td><?php

                                    }?>
                                </tr>

                                <tr>
                                    <th colspan="5" style="border:0px; border-left: 1px; border-right: 1px;"></th>
                                </tr>

                                <tr>
                                    <td colspan="5" style="font-size: 16px; text-align: center;">
                                        <table>
                                            <tbody><?php
                                                $datefacture=(new dateTime($payement['date_cmd']))->format("Ymd");
                                                $datenow=date("Ymd");
                                                $name=$payement['num_client'];
                                                if ($datefacture!=$datenow) {?>
                                                <tr><td class="btn btn-info">FACTURE DE <?=$caisse->nomClient($name)['nom_client'];?></td></tr>
                                                <tr>
                                                    <td style="border:0px solid White; text-align:left; padding:5px; font-size:16px; ">Solde à la date de la facture (<?=(new dateTime($payement['date_cmd']))->format("d/m/Y");?>)</td> 
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgenDate($name, $datefacture, 'gnf'));?>">GNF: <?=number_format(($panier->soldeclientgenDate($name, $datefacture, 'gnf')),0,',',' ');?></td><?php 
                                                    if (!empty($panier->soldeclientgenDate($name, $datefacture, 'eu'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgenDate($name, $datefacture, 'eu'));?>">€: <?=number_format(($panier->soldeclientgenDate($name, $datefacture, 'eu')),0,',',' ');?></td><?php 
                                                    }
                                                    
                                                    if (!empty($panier->soldeclientgenDate($name, $datefacture, 'us'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgenDate($name, $datefacture, 'us'));?>">$: <?=number_format(($panier->soldeclientgenDate($name, $datefacture, 'us')),0,',',' ');?></td><?php 
                                                    }
                                                    
                                                    if (!empty($panier->soldeclientgenDate($name, $datefacture, 'cfa'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgenDate($name, $datefacture, 'cfa'));?>">CFA: <?=number_format(($panier->soldeclientgenDate($name, $datefacture, 'cfa')),0,',',' ');?></td><?php 
                                                    }?>
                                                </tr><?php 
                                                }?>  
                                                <tr>
                                                <td style="border:0px solid White; text-align:left; padding:5px; font-size:16px;">Solde de vos comptes à la date du <?=date("d/m/Y");?></td> 
                                                <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgen($name, 'gnf'));?>">GNF: <?=number_format(($panier->soldeclientgen($name, 'gnf')),0,',',' ');?></td><?php 
                                                if (!empty($panier->soldeclientgen($name, 'eu'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgen($name, 'eu'));?>">€: <?=number_format(($panier->soldeclientgen($name, 'eu')),0,',',' ');?></td><?php 
                                                }
                                                
                                                if (!empty($panier->soldeclientgen($name, 'us'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgen($name, 'us'));?>">$: <?=number_format(($panier->soldeclientgen($name, 'us')),0,',',' ');?></td><?php 
                                                }
                                                
                                                if (!empty($panier->soldeclientgen($name, 'cfa'))) {?>
                                                    <td style="border:0px solid White;padding:5px;font-size:16px; color:<?=$panier->colorPaiement($panier->soldeclientgen($name, 'cfa'));?>">CFA: <?=number_format(($panier->soldeclientgen($name, 'cfa')),0,',',' ');?></td><?php 
                                                }?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table><?php
                    }?>

                </div><?php 
            }?>
        </div>
        
        

        
       
        <table class="table table-hover table-bordered table-striped table-responsive align-middle text-center my-2">

            <thead class="sticky-top bg-light">

            <tr>
                <th colspan="4">
                <input  class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                <div class="bg-danger " id="result-search"></div>
                </th>

                <th class="legende" colspan="6" height="30"><?php 
                if (isset($_GET['clientsearch'])) {
                    $_SESSION['reclient']=$_GET['clientsearch'];
                }?>

                <?= "Liste des Commissions " ?> <a class="btn btn-warning" href="?ajoutCom">Ajouter une Commission</a>
                </th>
            </tr>

            <tr>
                <th>N°</th>
                <th>Date Op</th>
                <th>N° Cmd</th>
                <th>Client</th>
                <th>Montant Facture</th>
                <th>Montant Com</th>
                <th>Solde Client</th>
                <th colspan="2">Action</th>
            </tr>

            </thead>

            <tbody><?php
                if (isset($_GET['clientCom'])) {
                    $_SESSION['clientCom']=$_GET['clientCom'];
                }
                if (isset($_GET['commission'])) {
                    $_SESSION['clientCom']="";
                }
                if (empty($_SESSION['clientCom'])) {
                    $prod= $DB->query("SELECT *FROM ventecommission inner join payement on num_cmd=numcmd ");                    
                }else{
                    $prod= $DB->query("SELECT *FROM ventecommission inner join payement on num_cmd=numcmd where idclient='{$_SESSION['clientCom']}' ");
                }
                foreach ($prod as $key=> $value ){?>
                    <form class="form" method="POST">

                        <tr>
                            <td><?=$key+1;?></td>                        
                            <td><?=(new dateTime($value->dateop))->format("d/m/Y");?></td> 
                            <td><?=$value->numcmd;?></td>                       
                            <td class="text-start"><?=ucwords(strtolower($panier->nomClient($value->idclient)));?></td>
                            <td><?=number_format($value->Total-$value->remise,0,',',' '); ?></td>
                            <td>                            
                                <input class="form-control text-center" type="text" value="<?=$configuration->formatNombre($value->montant);?>" name="montant">
                                <input class="form-control" type="hidden" value="<?=$value->idclient;?>" name="client">
                                <input class="form-control" type="hidden" value="<?=$value->numcmd;?>" name="numcmd">
                                <input class="form-control" type="hidden" value="<?=$value->numc;?>" name="numc">
                            </td>
                            <td><?=number_format(-$panier->compteClient($value->idclient, 'gnf'),0,',',' '); ?></td>
                            
                            <td><button class="btn btn-success" type="submit" name="updateMontant" onclick="return alerteV();">Valider</button></td>
                            <td><button class="btn btn-danger" type="submit" name="delete" onclick="return alerteS();">Supprimer</button></td>
                        </tr>
                    </form><?php 
                }?>

            </tbody>

        </table>

    </div>
</div>
    <?php  require "footer.php";?>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?venteCommission',
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

    $(document).ready(function(){
        $('#search-userCom').keyup(function(){
            $('#result-searchCom').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientCom',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-searchCom').append(data);
                        }else{
                          document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script>
