<?php require '_header.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Logescom-ms</title>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/8df11ad090.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body><?php 

    if (isset($_SESSION['pseudo'])){

        $pseudo=$_SESSION['pseudo'];
        $bdd='limitecredit';   

        $DB->insert(" CREATE TABLE IF NOT EXISTS `limitecredit` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `montant` double NOT NULL DEFAULT '1000000000000',
            `idclient` int(11) NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ");

        $type1='client';
        $type2='clientf';

        $prodclient= $DB->query("SELECT *FROM client where typeclient='{$type1}' or typeclient='{$type2}' order by(nom_client) ");          
        
        foreach ($prodclient as $key=> $product ){
            $prodcredit= $DB->querys("SELECT *FROM limitecredit where idclient='{$product->id}' ");
            if (empty($prodcredit['id'])) {
                $DB->insert("INSERT INTO limitecredit (idclient, montant)VALUES(?, ?)", array($product->id, 1000000000));
            }
        }

        $personnel = $DB->querysI('SELECT statut, nom, level FROM login WHERE pseudo= :PSEUDO', array('PSEUDO'=>$pseudo));?>
        <div class="container-fluid m-0 p-0">   

            <div class="rowHeader m-0 p-0" style="background-color:#2f2c2c;; display:flex; justify-content:space-between;align-items: center; height:55px; ">
                <div><a class="px-2" href="deconnexion.php"><img src="css/img/deconn.jpg" alt="logout" width="40"style="border-radius:5px;" ></a></div> 
                <div>
                    <form class="form" method="POST" action="recherche.php">
                        <div class="row">
                            <div class="col-8"><input class="form-control"  type ="search" name = "rechercher" placeholder="rechercher un ticket"></div>
                            <div class="col-4"><input class="form-control"  type ="submit" name = "s" value = "Rechercher"></div>
                        </div>
                    </form>
                </div>

                <div class="btn btn-success mx-1"><?="Compte de ".ucwords($personnel['nom']);?> </div> 

            </div>

            <div><?php 

                if (isset($_POST['magasin'])) {

                    $_SESSION['lieuventealerte']=$_POST['magasin'];
                }else{

                    $_SESSION['lieuventealerte']=$_SESSION['lieuvente'];

                }

                $nomtab=$panier->nomStock($_SESSION['lieuventealerte'])[1];

                $idstock=$panier->nomStock($_SESSION['lieuventealerte'])[2];            

                //require 'indicateur.php';?>
                    
            </div><?php

            $adress=$DB->querys('SELECT * FROM adresse ');?>

            <div class="container-fluid">

                <div class="row align-items-center pt-5 pb-5" style="margin: auto; margin-top: 10rem; background-color:#534444;"><?php  

                    if ($_SESSION['level']>6) {?>

                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="ajoutstock.php?lieuvente=<?=1;?>magasin=<?="general";?>">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/stock.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Général</h6>
                                    </div>
                                </div>
                            </a>
                        </div><?php 
                        $boutiques=$caisse->nomBoutique();
                        foreach ($boutiques as $key => $value) {?>
                            <div class="col mt-1">
                                <a style="text-decoration: none;" href="choix.php?lieuvente=<?=$value->lieuvente;?>&magasin=<?=$value->lieuvente;?>">
                                    <div class="card" style="width: 8rem;">
                                        <img src="css/img/achat.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                        <div class="card-bod m-auto">
                                        <h6 class="card-title"><?=strtoupper($value->nomstock);?></h6>
                                        </div>
                                    </div>
                                </a>
                            </div><?php 
                        }?>
                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="editionfacturefournisseur.php?recette.php">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/achatfournisseur.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Achat Four...</h6>
                                    </div>
                                </div>
                            </a>
                        </div><?php
                    }?>
                    
                                  

                </div>
            </div>
        </div><?php
    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>