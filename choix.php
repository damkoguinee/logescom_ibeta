<?php require '_header.php';?>

<!DOCTYPE html>
<html>
<head>
    <title>Logescom-ms</title>
    <meta charset="utf-8">
    <link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://kit.fontawesome.com/8df11ad090.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" charset="utf-8">
</head>
<body><?php 

    if (isset($_SESSION['pseudo'])){
        if (isset($_GET['magasin'])) {
            $_SESSION['lieuvente']=$_GET['lieuvente'];
            $_SESSION['magasin']=$_GET['magasin'];
        }

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
                </div><?php 
                if ($_SESSION['level']>6) {?>
                    <a class="btn btn-warning" href="boutique.php">Boutiques</a><?php 
                }?>

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

                <div class="row align-items-center pt-5 pb-5" style="margin: auto; margin-top: 10rem; background-color:#534444;">
                    
                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="indexcash.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/achat.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Ventes Direct</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="index.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/achat.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Ventes Crédits</h6>
                                </div>
                            </div>
                        </a>
                    </div> 
                    
                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="caisse.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/caisse.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Gestion Caisse</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="facturations.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/factures.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Factures Crédits</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="livraisonachat.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/livraison.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Livraison</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="client_general.php?client">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/client.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Clients</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="achat_fournisseur.php?recette.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/achatfournisseur.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Achats Interne</h6>
                                </div>
                            </div>
                        </a>
                    </div><?php  

                    if ($_SESSION['level']>=6) {?>
                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="stockgeneral.php?nomstock=<?=$_SESSION['lieuvente'];?>">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/stock.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Gestion Stock</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="dec.php?client">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/retrait.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Sorties</h6>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="banque.php?client">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/transfert.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Transf des fonds</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="personnel.php?enseig">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/personnel.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Personnels</h6>
                                    </div>
                                </div>
                            </a>
                        </div><?php 
                    }?>
                    
                    <!-- <div class="col mt-1">
                        <a style="text-decoration: none;" href="comptasemaine.php">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/compta.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Comptabilite</h6>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <div class="col mt-1">
                        <a style="text-decoration: none;" href="versement.php?client">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/versement.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Entrées</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- <div class="col mt-1">
                        <a style="text-decoration: none;" href="bulletin.php?comptep">
                            <div class="card" style="width: 8rem;">
                                <img src="css/img/compte.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                <div class="card-bod m-auto">
                                <h6 class="card-title">Compte</h6>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <?php 

                    if ($_SESSION['level']>6) {?>
                        <div class="col mt-1">
                            <a style="text-decoration: none;" href="restriction.php?client">
                                <div class="card" style="width: 8rem;">
                                    <img src="css/img/restriction.jpg" class="card-img-top m-auto" alt="..." style="width: 5rem; height: 5rem">
                                    <div class="card-bod m-auto">
                                    <h6 class="card-title">Restriction</h6>
                                    </div>
                                </div>
                            </a>
                        </div><?php 
                    }?>                

                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-md-6">            
                    <table class="table table-hover table-bordered table-striped table-responsive text-center my-4">
                        <thead>
                            <tr>
                                <th colspan="6" scope="col" class="text-center bg-danger text-white"><label>Liste des créanciers à relancer / Aucune Opération depuis 30 jours</label> <a class="btn btn-light" href="printcreancier.php" target="_blank"><i class="fa-solid fa-file-pdf fs-4" style="color: #932f34;"></a></th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center">N°</th>
                                <th scope="col" class="text-center">Prénom & Nom</th>
                                <th scope="col" class="text-center">Téléphone</th>
                                <th scope="col" class="text-center">Solde</th>
                                <th scope="col" class="text-center">Dernière Op</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $soldeCumul=0;
                            $type1='client';
                            $type2='clientf';
                            if ($_SESSION['level']>6) {
                                $prodclient = $DB->query("SELECT *FROM client where (typeclient='{$type1}' or typeclient='{$type2}') order by(nom_client) ");
                            }else{
                                $prodclient = $DB->query("SELECT *FROM client where positionc='{$_SESSION['lieuvente']}' and (typeclient='{$type1}' or typeclient='{$type2}') order by(nom_client) ");
                            }
                            $i=1;
                            foreach ($prodclient as $key => $value) {
                                $prodmax= $DB->querys("SELECT max(date_versement) as datev FROM bulletin where nom_client='{$value->id}' ");

                                $now = date('Y-m-d');
                                $datederniervers = $prodmax['datev'];

                                $now = new DateTime( $now );
                                $now = $now->format('Ymd');       

                                $datederniervers = new DateTime($datederniervers);
                                $datederniervers = $datederniervers->format('Ymd');

                                $jourd=(new dateTime($now))->format("d");
                                $moisd=(new dateTime($now))->format("m");
                                $anneed=(new dateTime($now))->format("Y");

                                $datealertemin = date("Ymd", mktime(0, 0, 0, $moisd, $jourd-$panier->delaialerte,   $anneed));

                                $datealerte = date("Ymd", mktime(0, 0, 0, $moisd, $jourd-30,   $anneed));

                                $delai=$panier->delai;

                                $delaialerte=$panier->delaialerte;
                                if ($panier->compteClient($value->id, 'gnf')<0) {
                                    if ($datealerte>=$datederniervers) {
                                        $soldeCumul+=(-$panier->compteClient($value->id, 'gnf')); ?>
                                        <tr>
                                            <td><?=$i;?></td>
                                            <td class="text-start"><?=ucwords(strtolower($value->nom_client));?></td>
                                            <td><?=$value->telephone;?></td>
                                            <td class="text-end"><?=number_format(-$panier->compteClient($value->id, 'gnf'),0,',',' ');?></td>
                                            <td><?=(new dateTime($datederniervers))->format("d/m/Y");?></td>
                                            <td>
                                                <a class="btn btn-success m-auto" href="clientgestion.php?suiviclient=<?=$value->id;?>&nomclient=<?=$value->nom_client;?>">Consulter</a>
                                            </td>
                                        </tr><?php
                                        $i++;
                                    }
                                }
                            }?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Cumul Créances</th>
                                <th class="text-end"><?=number_format($soldeCumul,0,',',' ');?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div><?php
                if ($_SESSION['level']>6) {?>
                    
                        <div class="col-sm-12 col-md-6 py-4 px-5"  style="overflow: auto;"><?="<img src='./statventegenerale.php' />"; ?></div>
                    <?php 
                }?>
            </div>
        </div><?php
    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>