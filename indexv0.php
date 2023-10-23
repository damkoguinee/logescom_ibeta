<?php
require '_header.php';?>
  
<!DOCTYPE html>
<html>


<head>
<title>Logescom-ms</title>
    <meta charset="utf-8">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/8df11ad090.js" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8"> -->
</head>

<script>
    function suivant(enCours, suivant, limite){
        if (enCours.value.length >= limite)
        document.term[suivant].focus();
    }
</script>

<body style="background-color: #b0b09a;" onload="return focus();"><?php

    $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

    if (isset($_SESSION['pseudo'])){?>    

        <div class="container-fluid">
            <div class="row">
                <div class="col-3  border border-5 border-primary"> <?php
                    if (isset($_GET['vente']) or isset($_GET['logo'])) {
                        unset($_SESSION['scanner']); // Pour pouvoir à la vente normale
                    }?>

                    <div class="container-fluid  my-2">
                        <div class="row">
                            <div class="col-sm-3 col-md-4 m-0 p-0"><a class="btn btn-success" href="choix.php">ACCUEIL</a></div>
                            <div class="col-sm-7 col-md-8 m-0 p-0">
                                <form class="form" method="GET" action="index.php" >
                                    <input class="form-control" type = "search" name = "terme"  placeholder="rechercher un produit" onchange="document.getElementById('suite').submit()">
                                </form>
                            </div>
                            <!-- <div class="col-sm-2 col-md-2 m-0 px-0">
                                <a class="btn btn-primary" href="index.php?scanner">Scanner</a>
                            </div> -->
                        </div>
                    </div>
                    
                    <div class="row" ><?php

                        if (isset($_GET['terme'])) {

                            if (isset($_GET["terme"])){

                                $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                                $terme = $_GET['terme'];
                                $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                                $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
                            }

                            if (isset($terme)){
                                $type="en_gros";

                                $terme = strtolower($terme);
                                $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id WHERE (designation LIKE ? OR Marque LIKE ?) and productslist.type LIKE ?",array("%".$terme."%", "%".$terme."%", $type));
                            }else{

                                $message = "Vous devez entrer votre requete dans la barre de recherche";

                            }

                            foreach ( $products as $product ){

                                $qtites=0;
                                foreach ($panier->listeStock() as $valueS) {

                                    $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

                                    $qtites+=$prodstock['qtite'];

                                    
                                }

                                $etatliv='nonlivre';

                                $prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

                                $restealivrer=$qtites-$prodcmd['qtite'];

                                $qtitetab=$product->quantite;?>

                                <div class="col pb-2 mt-2">
                                            
                                    <a style="text-decoration: none" href="index.php?desig=<?= $product->Marque;?>&idc=<?= $product->id;?>&pv=<?= $product->prix_vente;?>">
                                        <div class="card m-auto border-10 border-primary" style="width: 8rem; height: 190px;">

                                            <div class="card-bod m-auto text-center fw-bold fs-7"><?= ucwords(strtolower($product->Marque)); ?></div>

                                            <img src="img/<?= $product->id; ?>.jpg" class="card-img-top m-auto" alt=" " style="width: 5rem; height: 5rem">

                                            <div class="card-bod m-auto">
                                                <h5 class="text-center"><?= $qtitetab.' / '.$restealivrer; ?></h5>
                                                <h5 class="card-title text-center text-danger"><?= number_format($product->prix_vente,0,',',' '); ?></h5>
                                            </div>
                                        </div> 
                                    </a>

                                </div> <?php
                            }


                        }elseif (isset($_GET['logo'])) {
                            $type="en_gros";
                            $products = $DB->query("SELECT * FROM `".$nomtab."` inner join productslist on idprod=productslist.id  WHERE  codecat='{$_GET['logo']}' and productslist.type='{$type}' ORDER BY (`".$nomtab."`.nbrevente) DESC" );

                            foreach ( $products as $product ){

                                $qtites=0;
                                foreach ($panier->listeStock() as $valueS) {

                                    $prodstock = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$product->id}' ");

                                    $qtites+=$prodstock['qtite'];

                                    
                                }

                                $etatliv='nonlivre';

                                $prodcmd=$DB->querys("SELECT sum(qtiteliv) as qtite FROM commande where id_produit='{$product->id}' and etatlivcmd='{$etatliv}' ");

                                $restealivrer=$qtites-$prodcmd['qtite'];

                                $qtitetab=$product->quantite; ?>

                                <div class="col pb-2 mt-2">
                                            
                                    <a style="text-decoration: none" href="index.php?desig=<?= $product->Marque;?>&idc=<?= $product->id;?>&pv=<?= $product->prix_vente;?>">
                                        <div class="card m-auto border-10 border-primary" style="width: 8rem; height: 190px;">

                                            <div class="card-bod m-auto text-center fw-bold fs-7"><?= ucwords(strtolower($product->Marque)); ?></div>

                                            <img src="img/<?= $product->id; ?>.jpg" class="card-img-top m-auto" alt=" " style="width: 5rem; height: 5rem">

                                            <div class="card-bod m-auto">
                                                <h5 class="text-center"><?= $qtitetab.' / '.$restealivrer; ?></h5>

                                                <h5 class="card-title text-center text-danger"><?= number_format($product->prix_vente,0,',',' '); ?></h5>
                                            </div>
                                        </div> 
                                    </a>

                                </div> <?php
                            }
                            
                    
                        }else{

                            $products = $DB->query('SELECT * FROM categorie ORDER BY (nom)');
                            

                            foreach ( $products as $product ){?>
                                <div class="col pb-2 mt-2">
                                            
                                    <a style="text-decoration: none" href="index.php?logo=<?= $product->id; ?>">
                                        <div class="card m-auto border-10 border-primary" style="width: 8rem; height: 120px;">

                                            <div class="card-bod m-auto text-center fw-bold fs-7"><?= ucfirst(strtolower($product->nom)); ?></div>

                                            <img src="img/logo/<?= $product->id; ?>.jpg" class="card-img-top m-auto" alt=" " style="width: 5rem; height: 5rem">
                                        </div> 
                                    </a>

                                </div><?php
                            }

                        }?>
                    </div>
                </div>

                <div class="col-9">

                    <?php require 'panier.php'; ?>              
                    
                </div>

            </div>
        </div><?php  
        
    }else{

        header("Location: form_connexion.php");

    }?>
    
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
                    url: 'recherche_utilisateur.php',
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

<script type="text/javascript">
  function alerteS(){
    return(confirm('Valider la suppression'));
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

