<?php require 'headerv2.php';?>
<div class="container-fluid mt-3">
    <div class="row"><?php 

        require 'navventecredit.php';?>

        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
        
        if (isset($_POST['updateMontant'])) {
            $numcmd=$panier->h($panier->espace($_POST['numcmd']));
            $client=$panier->h($panier->espace($_POST['client']));
			$new_qtite=$panier->h($panier->espace($_POST['qtite']));
			$pvente=$panier->h($panier->espace($_POST['pvente']));
			$idcmd=$panier->h($panier->espace($_POST['idcmd']));
			$idprod=$panier->h($panier->espace($_POST['idprod']));
			$compte=$panier->h($panier->espace($_POST['compte']));

            $quantity_init=$panier->h($panier->espace($_POST['qtite_init']));

            $paiement_init=$DB->querys("SELECT *FROM payement WHERE num_cmd='{$numcmd}' ");

            $montant_facture=$paiement_init['Total'];
            $montant_reste_facture=$paiement_init['reste'];
            $montant_paye=$paiement_init['montantpaye'];
            $qtite=$quantity_init-$new_qtite;
            $new_vente_prod=$pvente*$qtite;

            $new_montant_facture=$montant_facture-$new_vente_prod;
            $new_montant_reste_facture=$montant_reste_facture-$new_vente_prod;
            $new_montant_paye=$montant_paye-$new_vente_prod;

            $nomStock=$panier->nomStock($_SESSION['lieuvente'])[1];
            $idStock=$panier->nomStock($_SESSION['lieuvente'])[2];
            // $etat_fact="retour fact";

            // $DB->insert("UPDATE payement SET Total='{$new_montant_facture}', etat='{$etat_fact}' where num_cmd='{$numcmd}'");

            $DB->insert("UPDATE payement SET Total='{$new_montant_facture}', reste='{$new_montant_reste_facture}' where num_cmd='{$numcmd}'");

            // $DB->insert("UPDATE modep SET montant='{$new_montant_facture}' where numpaiep='{$numcmd}'");

            $numero_banque="vente".$numcmd;
            $devise="gnf";
            // $DB->insert("UPDATE banque SET montant='{$new_montant_paye}' where numero='{$numero_banque}' and devise='{$devise}' ");

            // $DB->insert("INSERT INTO banque (clientbanque, id_banque, numero, typeent, origine, libelles, montant, lieuvente, date_versement)VALUES (?, ?, ?, ?, ?, ?, ?, ?, now()) ",array($client, $compte, $numero_banque, "vente", "vente cash","retour vente cash ".$numcmd, -$new_vente_prod, $_SESSION['lieuvente']));

            $stock_init=$DB->querys("SELECT *FROM `".$nomStock."` WHERE idprod='{$idprod}' ");
            
            $pr=$stock_init['prix_revient'];
            $pa=$stock_init['prix_achat'];

            // if ($new_qtite==0) {
            //     $DB->delete("DELETE FROM commande WHERE id='{$idcmd}' ");
            // }else{
                //     $DB->insert("UPDATE commande SET quantity='{$new_qtite}', qtiteliv='{$new_qtite}' where id='{$idcmd}' ");
                // }
                
            $prodlivraison=$DB->querys("SELECT id, qtiteliv FROM commande WHERE id_produit='{$idprod}' and num_cmd='{$numcmd}' ");

            if (empty($prodlivraison['qtiteliv'])) {
                $DB->insert("INSERT INTO commande (id_produit, prix_vente, prix_achat, prix_revient, quantity, qtiteliv, etatlivcmd, num_cmd, id_client) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ", array($idprod, $pvente, $pa, $pr, -$qtite, 0, "nonlivre", $numcmd, $client));

            }else{
                $qtiteliv_rest=$prodlivraison['qtiteliv']-$qtite;
                $DB->insert("INSERT INTO commande (id_produit, prix_vente, prix_achat, prix_revient, quantity, qtiteliv, etatlivcmd, num_cmd, id_client) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ", array($idprod, $pvente, $pa, $pr, -$qtite, -$qtiteliv_rest, "nonlivre", $numcmd, $client));

                $DB->insert("INSERT INTO livraison (idcmd, id_produitliv, quantiteliv, numcmdliv, id_clientliv, livreur, idstockliv) VALUES (?, ?, ?, ?, ?, ?, ?) ", array($idcmd, $idprod, -$qtiteliv_rest, $numcmd, $client, $_SESSION['idpseudo'], $idStock));
                $numero_mouv="liv".$numcmd;            
    
                $DB->insert("INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, idpers) VALUES(?, ?, ?, ?, ?, ?) ", array($idprod, $numero_mouv, 'entree', $qtiteliv_rest, $idStock, $_SESSION['idpseudo']));
                
                $new_qtite=$stock_init['quantite']+$qtite;
                $DB->insert("UPDATE `".$nomStock."` SET quantite='{$new_qtite}' where idprod='{$idprod}'");
            }
            $montant_bull=-($pvente*$qtite);
            $DB->insert('INSERT INTO bulletin (nom_client,origine_bull, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now() )', array($client, "retour produit", $montant_bull, "retour produit", $numcmd, "gnf", 1, $_SESSION['lieuvente']));
            ?>

            <div class="alert alert-success">Retour éffectué avec succèe !!!</div><?php
        }?>

        <div class="row">            
            <form class="form row" action="" method="POST">
                <label class="form-label bg-warning" for="numcmd">Entrer le N° Facture</label>
                <div class="col-sm-6 col-md-4 my-2"><?php
                    if (isset($_POST['numcmd'])) {
                        $_SESSION['numcmd_retour']=$_POST['numcmd'];?>
                        <input type="text" name="numcmd" value="<?=$_POST['numcmd'];?>"  onchange="this.form.submit()" class="form-control"><?php
                    }else{
                        $_SESSION['numcmd_retour']=""?>
                        <input type="text" name="numcmd"  onchange="this.form.submit()" class="form-control"><?php
                    }?>
                </div>
                <div class="col-sm-6 col-md-4 my-2">
                    <button class="btn btn-success" type="submit" name="ajoutCom" onclick="return alerteV();">Valider</button>
                </div>
            </form><?php           
            if (!empty($_SESSION['numcmd_retour'])) {
                $zero=0;                
                $products=$DB->query("SELECT commande.id as id, productslist.id as idprod, num_cmd, id_client, prix_vente, sum(quantity) as quantity, Marque FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd='{$_SESSION['numcmd_retour']}' GROUP BY (idprod) ");?>
    
                <table class="table table-hover table-bordered table-striped table-responsive text-center my-2">
    
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>N° Cmd</th>
                            <th>Client</th>
                            <th>Référence</th>
                            <th>Qtité</th>
                            <th>P.Vente</th>
                            <th>Action</th>
                        </tr>
                    </thead>
    
                    <tbody><?php
                        foreach ($products as $key=> $value ){?>
                            <form class="form" method="POST" action="?">
                                <tr>
                                    <td><?=$key+1;?></td>                        
                                    <td><?=$value->num_cmd;?></td>                       
                                    <td class="text-start"><?=ucwords(strtolower($panier->nomClient($value->id_client)));?></td>
                                    <td class="text-start"><?=ucwords(strtolower($value->Marque));?></td>
                                    <td><input class="form-control text-center" type="number" value="<?=$value->quantity;?>" name="qtite" max="<?=$value->quantity;?>" min="0"></td>
                                    <td><?=$configuration->formatNombre($value->prix_vente);?>                         
                                        <input class="form-control" type="hidden" value="<?=$value->id_client;?>" name="client">
                                        <input class="form-control" type="hidden" value="<?=$value->num_cmd;?>" name="numcmd">
                                        <input class="form-control" type="hidden" value="<?=$value->quantity;?>" name="qtite_init">
                                        <input class="form-control" type="hidden" value="<?=$value->id;?>" name="idcmd">
                                        <input class="form-control" type="hidden" value="<?=$value->idprod;?>" name="idprod">
                                        <input class="form-control" type="hidden" value="<?=$value->prix_vente;?>" name="pvente">
                                    </td>
                                    <input type="hidden" name="compte">
                                    <!-- <td>
                                        <select class="form-select"  name="compte" required=""><?php
                                            $type='banque';
                                            foreach($caisse->nomTypeCaisse() as $product){?>

                                            <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                            }

                                            foreach($caisse->listBanque() as $product){?>

                                            <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                            }?>
                                        </select>
                                    </td> -->
                                    
                                    <td><button class="btn btn-success" type="submit" name="updateMontant" onclick="return alerteV();">Valider</button></td>
                                </tr>
                            </form><?php 
                        }?>
    
                    </tbody>
    
                </table><?php
            }?>
        </div>
        <div class="col-sm-12 col-md-8"><?php 
            if (isset($_POST['numcmd'])) {
                $numcmd=$panier->h($_POST['numcmd']);
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

        </div>   

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
