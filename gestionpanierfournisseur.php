<?php require 'headerv2.php';?>

<div class="container-fluid">

  <div class="row">
    <div class="col-sm-12 col-md-12"><?php 
        if (isset($_POST['confirmPaie'])) {
            $idprod=$panier->h($_POST['idprod']);
            $qtite=$panier->h($panier->espace($_POST['qtite']));
            $pa=$panier->h($panier->espace($_POST['pa']));
            $cmd=$panier->h($_POST['cmd']); 
            $fournisseur=$panier->h($_POST['fournisseur']); 
            $idc=$panier->h($_POST['idc']);
            $taux=$panier->h($_POST['taux']);
            $tauxgnf=$panier->h($_POST['tauxgnf']);
            $commande->supplierPaie($idc, $idprod, $qtite, $pa,  $fournisseur, $cmd, $taux, $tauxgnf);?>
            <div class="alert alert-success">Paiement effectué avec sucèe!!!</div> <?php
        }
        if (isset($_POST['deletePaie'])) {
            $idprod=$panier->h($_POST['idprod']);
            $qtite=$panier->h($panier->espace($_POST['qtite']));
            $pa=$panier->h($panier->espace($_POST['pa']));
            $cmd=$panier->h($_POST['cmd']); 
            $fournisseur=$panier->h($_POST['fournisseur']); 
            $idc=$panier->h($_POST['idc']);
            $taux=$panier->h($_POST['taux']);
            $tauxgnf=$panier->h($_POST['tauxgnf']);
            $commande->updateSupplierPaie($idc, $idprod, $qtite, $pa,  $fournisseur, $cmd);?>
            <div class="alert alert-success">Paiement annulé avec sucèe!!!</div><?php            
        }
      
        if (isset($_GET['bl'])) {
            $_SESSION['bl']=$_GET['bl'];
        }      
        $cols=sizeof($panier->listeStock());
        $colf=sizeof($panier->clientf('fournisseur', 'fournisseur'));
        $col=$cols+$colf;?>

        <div class="row">
            <div class="col-sm-12 col-md-12" style="overflow: auto;"><?php 
                require 'gestionportefeuille.php';?>
                <table class="table table-hover table-bordered table-striped table-responsive text-center">
                    <thead>
                        <tr>
                            <th colspan="12">
                            <div class="row">
                                <div class="col-sm-5 col-md-3">
                                <form class="form" method="GET" action="gestionpanierfournisseur.php" id="suite" name="term">
                                    <select name="categorie" id="" class="form-select" onchange="this.form.submit()">
                                    <option value="">Recherchez par fournisseur</option><?php
                                    foreach ($panier->clientf('fournisseur', 'fournisseur') as $valuer) {?>
                                        <option value="<?=$valuer->id;?>"><?=$valuer->nom_client;?></option><?php
                                    }?>
                                    <option value="general">liste générale</option>
                                    </select>
                                </form>
                                </div>
                                
                                <div class="col-sm-1 col-md-1"><?php 
                                if (isset($_GET['categorie'])) {?>
                                    <a class="btn btn-warning" target="_blank" href="boncommandefour.php?cmd=<?=$_SESSION['bl'];?>&client=<?=$_GET['categorie'];?>"><i class="fa-regular fa-file-pdf fs-2"></i></a><?php 
                                }?>
                                </div>
                                <div class="col-sm-6 col-md-8">                       
                                <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionselection.php?bl=<?=$_SESSION['bl'];?>&recette">Pré-Selection</a>
                                <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionchoixfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Selection</a>
                                <a class="btn btn-success fw-bold mx-1 text-white" href="?bl=<?=$_SESSION['bl'];?>&recette">Panier  <?=strtoupper($_SESSION['bl']);?> </a>
                                <a class="btn btn-warning fw-bold mx-1 text-white" href="gestionachatfournisseur.php?bl=<?=$_SESSION['bl'];?>&recette">Livraison</a>
                                <a class="btn btn-warning fw-bold mx-1 text-white" href="gestiontransport.php?bl=<?=$_SESSION['bl'];?>&recette">Voir Livraison</a>
                                </div>
                            </div>
                        
                            </th>
                        </tr>     

                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Fournisseur</th>
                            <th>Référence</th>
                            <th>Prix AED</th>
                            <th>~Prix $</th>
                            <th>Prix GNF</th>
                            <th>Qtité cmd</th>
                            <th>Montant Total</th>
                            <th></th>  
                        </tr>

                    </thead>

                    <tbody>

                    <?php
                    $tot_achat=0;
                    $tot_revient=0;
                    $tot_vente=0;
                    $qtiteR=0;
                    $qtiteS=0; 
                    if (isset($_GET["categorie"]) and $_GET["categorie"]=="general"){
                        $_SESSION['selectionChoixPanier']='';
                    }elseif (isset($_GET["categorie"])){
                        $_SESSION['selectionChoixPanier']=$_GET["categorie"];
                    }else{
                        if (!empty($_SESSION['selectionChoixPanier'])) {
                        $_SESSION['selectionChoixPanier']=$_SESSION['selectionChoixPanier'];
                        }else{
                        $_SESSION['selectionChoixPanier']='';
                        }

                    }

                    if (empty($_SESSION['selectionChoixPanier'])) {

                        if (isset($_GET["categorie"]) and $_GET["categorie"]!="general"){

                            $_GET["terme"] = htmlspecialchars($_GET["categorie"]); //pour sécuriser le formulaire contre les failles html
                            $terme = $_GET['terme'];
                            $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                            $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                            $_SESSION['selectionChoixPanier']=$terme;

                            $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre, statut FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE fournisseur='{$terme}' and cmd='{$_SESSION['bl']}' ");

                        }else{
                            $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre, statut FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE cmd='{$_SESSION['bl']}' ");
                        
                        }
                    }else{

                        if (!empty($_SESSION['selectionChoixPanier'])) {
                            $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre, statut FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE fournisseur='{$_SESSION['selectionChoixPanier']}' and cmd='{$_SESSION['bl']}' ");

                        }else{

                            $products = $DB->query("SELECT gestionachatfournisseur.id as idc, idprod, designation, Marque, qtite, cmd, fournisseur, taux, tauxgnf, devise, dateop, pv, livre, statut FROM gestionachatfournisseur inner join productslist on productslist.id=idprod WHERE cmd='{$_SESSION['bl']}' ");
                        }
                    }
                    $cumulaed=0;
                    $cumuldollard=0;
                    $cumulgnf=0;
                    $cumulqtite=0;
                    $cumullivre=0;

                    if (!empty($products)) {
                
                        foreach ($products as $key=> $product){
                            $reste=($product->qtite-$product->livre);
                            $color='';
                            $aed=$product->pv;
                            $dollard=$product->pv/$product->taux;
                            $gnf=$product->pv*$product->tauxgnf;

                            $aedunit=$product->pv*$product->qtite;
                            $dollardunit=($product->pv/$product->taux)*$product->qtite;
                            $gnfunit=$product->pv*$product->tauxgnf*$product->qtite;
                            $qtite=$product->qtite;
                            $livre=$product->livre;
                            
                            $cumulaed+=$aedunit;
                            $cumuldollard+=$dollardunit;
                            $cumulgnf+=$gnfunit;
                            $cumulqtite+=$qtite;
                            $cumullivre+=$livre;?>

                            <tr>
                                <td><?=$key+1;?></td> 
                                <td><?=(new DateTime($product->dateop))->format("d/m/Y");?></td>

                                <form class="form" action="gestionpanierfournisseur.php" method="POST">
                                    <td><?=$panier->nomClient($product->fournisseur); ?></td>
                                    <td style="color:<?=$color;?>"><?= ucwords(strtolower($product->Marque)); ?>
                                        <input class="form-control" type="hidden" name="idprod" value="<?=$product->idprod; ?>"/>
                                        <input class="form-control" type="hidden" name="cmd" value="<?=$product->cmd; ?>"/>
                                        <input class="form-control" type="hidden" name="fournisseur" value="<?=$product->fournisseur; ?>"/>
                                        <input class="form-control" type="hidden" name="pa" value="<?=$aed; ?>"/>
                                        <input class="form-control" type="hidden" name="qtite" value="<?=$product->qtite; ?>"/>
                                        <input class="form-control" type="hidden" name="idc" value="<?=$product->idc; ?>"/>
                                        <input class="form-control" type="hidden" name="taux" value="<?=$product->taux; ?>"/>
                                        <input class="form-control" type="hidden" name="tauxgnf" value="<?=$product->tauxgnf; ?>"/>
                                    </td>
                                    <td><?=number_format($aed,0,',',' '); ?></td>
                                    <td><?=number_format($dollard,2,',',' '); ?></td>
                                    <td><?=number_format($gnf,0,',',' '); ?></td>
                                    <td><?= $product->qtite; ?></td>
                                    <td><?=number_format($aed*$product->qtite,0,',',' '); ?></td>
                                    <td><?php 
                                        if ($product->statut!="payer") {?>
                                            <button type="submit" class="btn btn-success" name="confirmPaie">Payer</button><?php 
                                        }else{?>
                                            <button type="submit" class="btn btn-danger" name="deletePaie" onclick="return alerteS();">Annuler</button><?php
                                        }?>
                                    </td>                   
                                
                                </form>
                            </tr><?php
                        }
                    }?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7">Totaux</th>
                        <th><?=number_format($cumulqtite,0,',',' '); ?></th>
                        <th><?=number_format($cumulaed,0,',',' '); ?></th>
                    </tr>
                </tfoot>

            </table>    
        </div>
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
                    url: 'rechercheproduit.php?edition',
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


<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteT(){
        return(confirm('Confirmer le transfert des produits'));
    }

    function focus(){
    document.getElementById('reccode').focus();
  }

    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>  