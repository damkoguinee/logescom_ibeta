<?php require 'headerv2.php';?>

<div class="container-fluid">

    <div class="row"><?php
        require 'navfournisseur.php';?>

        <div class="col-sm-12 col-md-10"><?php 
      
            if (isset($_POST['validap'])) {
                $nomtab1=$panier->nomStock($_POST['departap'])[1];

                $idstock1=$panier->nomStock($_POST['departap'])[2];

                $lieuvente=$panier->nomStock($_POST['departap'])[3];

                $idprod=$panier->h($_POST['idprod']);
                $qtite=$panier->h($panier->espace($_POST['qtite']));
                $cmd=$panier->h($_POST['cmd']); 
                $idc=$panier->h($_POST['idc']); 
                if (empty($_POST['pr'])) {
                    $pra=0;
                }else{
    
                    $pra=$panier->h($_POST['pr']);
                }
        
                $pv=$panier->h($_POST['pv']);

                $depart = $DB->querys("SELECT quantite as qtite, prix_revient as pr FROM `".$nomtab1."` WHERE idprod=?", array($idprod));

                $qtited=$depart['qtite']+$qtite;

                $qtitestock=$depart['qtite'];

                if ($qtitestock<0) {

                    $qtitestock=0;
                }

                $previentstock=$depart['pr'];


                if (empty($previentstock)) {

                    $qtitestock=0;
                }

                $pr=($qtite*$pra+$qtitestock*$depart['pr'])/($qtite+$qtitestock);

                $prodinit= $DB->querys("SELECT livre FROM gestionreception WHERE id='{$idc}'");
                $livre=$prodinit['livre']+$qtite;

                $DB->insert("UPDATE gestionreception SET livre='{$livre}' WHERE id='{$idc}' ");

                $DB->insert("UPDATE `".$nomtab1."` SET quantite= ?, prix_revient=? WHERE idprod = ?", array($qtited, $pr, $idprod));

                $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, coment, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($idprod, 'recepf', 'entree', $qtite, $idstock1, $cmd, $_SESSION['idpseudo'])); ?>

                <div class="alert alert-success">Produit Receptionné avec sucèe!!!</div> <?php
            }?>

            <div class="row">
                <div class="col-sm-12 col-md-12" style="overflow: auto;">
                <table class="table table-hover table-bordered table-striped table-responsive text-center">

              <form class="form" method="GET" action="gestionreception.php" id="suite" name="term">

                <thead><?php 

                  if (isset($_GET['bl'])) {
                    $_SESSION['bl']=$_GET['bl'];
                    $_SESSION['idclient']=$_GET['idclient'];
                    $_SESSION['datef']=$_GET['datef'];
                  }?>

                  <tr><th colspan="9">Reception des Produits</th></tr>

                  <tr>

                    <th colspan="10">
                      <input class="form-control" type = "search" name = "terme" placeholder="rechercher un produit" onchange="this.form.submit()"/>
                    </th>
                  </tr>
        

                  <tr>
                    <th>N°</th>
                    <th>Date</th>
                    <th>Cmd</th>
                    <th>Désignation</th>
                    <th>P revient GNF</th>
                    <th>Recep/Arrivée</th>
                    <th>Qtité Recep</th>
                    <!-- <th>Prix Vente</th> -->
                    <th>Magasin Reception</th>
                    <th></th>  
                  </tr>

                </thead>
              </form>

                <tbody>

                <?php
                $tot_achat=0;
                $tot_revient=0;
                $tot_vente=0;
                $qtiteR=0;
                $qtiteS=0;

                if (!isset($_GET['termeliste'])) {

                    if (isset($_GET['terme'])) {

                    if (isset($_GET["terme"])){

                        $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                        $terme = $_GET['terme'];
                        $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                        $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                        $_SESSION['terme']=$terme;
                    }

                    if (isset($terme)){

                        $terme = strtolower($terme);
                        $products = $DB->query("SELECT gestionreception.id as idc, idprod, designation, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestionreception inner join productslist on productslist.id=idprod WHERE codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(designation)",array($terme, "%".$terme."%", "%".$terme."%"));
                    }else{

                        $message = "Vous devez entrer votre requete dans la barre de recherche";

                    }

                    if (empty($products)) {?>

                        <div class="alertes">Produit indisponible<a href="ajout.php">Ajouter le produit</a></div><?php

                    }

                    }else{

                    if (!empty($_SESSION['terme'])) {
                        
                        $products = $DB->query("SELECT gestionreception.id as idc, idprod, designation, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestionreception inner join productslist on productslist.id=idprod WHERE codeb LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(designation)",array($_SESSION['terme'], "%".$_SESSION['terme']."%", "%".$_SESSION['terme']."%"));

                    }else{

                        $products = $DB->query("SELECT gestionreception.id as idc, idprod, designation, qtite, pv, taux, tauxgnf, cmd, client, dateop, livre FROM gestionreception inner join productslist on productslist.id=idprod order by(designation) LIMIT 50");
                    }
                    }
                }else{

                    $products = $DB->query("SELECT gestionreception.id as idc, idprod, designation, client, qtite, pv, taux, tauxgnf, cmd, dateop, livre FROM gestionreception inner join productslist on productslist.id=idprod WHERE id= ? order by(designation)",array($_GET['termeliste']));
                }

                if (!empty($products)) {

                    foreach ($products as $key=> $product){
                    $reste=($product->qtite-$product->livre);
                    if ($reste==0) {
                        $bg='success';
                    }elseif($product->livre!=0){
                        $bg='warning';
                    } else {
                        $bg='danger';
                    }
                    
                    $color='';?>

                    <tr>
                        <td class="bg-<?=$bg;?>"><?=$key+1;?></td> 
                        <td class="bg-<?=$bg;?>"><?=(new DateTime($product->dateop))->format("d/m/Y");?></td>

                        <form class="form bg-<?=$bg;?>" action="gestionreception.php" method="POST">
                        <td class="bg-<?=$bg;?>"><?=$product->cmd; ?>
                        <td class="bg-<?=$bg;?>"><?= ucwords(strtolower($product->designation)); ?>
                            <input class="form-control" type="hidden" name="idprod" value="<?=$product->idprod; ?>"/>
                            <input class="form-control" type="hidden" name="cmd" value="<?=$product->cmd; ?>"/>
                            <input class="form-control" type="hidden" name="fourni" value="<?=$product->client; ?>"/>
                            <input class="form-control" type="hidden" name="pr" value="<?=$product->pv*$product->tauxgnf; ?>"/>
                            <input class="form-control" type="hidden" name="idc" value="<?=$product->idc; ?>"/>
                        </td>
                        <td class="bg-<?=$bg;?>"><?=number_format($product->pv*$product->tauxgnf,0,',',' '); ?></td>
                        <td class="bg-<?=$bg;?>"><?= $product->livre; ?> / <?= $product->qtite; ?></td><?php 
                        if ($reste!=0) {?>
                            <td class="bg-<?=$bg;?>"><input type="number"  name="qtite" min="0" max="<?=$reste;?>" required class="form-control"></td>
                            <!-- <td class="bg-<?=$bg;?>"><input type="number"  name="pv" min="<?=$product->pv*$product->tauxgnf;?>"  required class="form-control"></td> -->
                            <input type="hidden" name="pv">
                            <td class="bg-<?=$bg;?>">
                                <select class="form-select" name="departap" required="">
                                    <option value="<?=$panier->nomStock($_SESSION['lieuvente'])[2];?>"><?=$panier->nomStock($_SESSION['lieuvente'])[0];?></option><?php 

                                    if ($_SESSION['level']>=6) {

                                    foreach($panier->listeStock() as $value){?>

                                        <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php

                                    }
                                    }?>
                                </select>
                            </td>
                            <td class="bg-<?=$bg;?>"><button class="btn btn-primary" type="submit" name="validap" onclick="return alerteT();">Receptionner</button></td><?php
                        } else {?>
                            <td class="bg-<?=$bg;?>">clos</td>
                            <td class="bg-<?=$bg;?>">clos</td>
                            <td class="bg-<?=$bg;?>">clos</td><?php
                        }?>
                    </form>
                    </tr><?php
                }
                }?>
            </tbody>

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