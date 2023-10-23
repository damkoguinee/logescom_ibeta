<?php require '_header.php';

for ($i=1; $i < 37; $i++) { 

    $montant=0;
    $bl="cmd-".$i;
    $nature="commande produits";
    $devise="us";
    $client="2";
    $motif=$nature;
    $taux=1;

    $compte=1;
    $modep="especes";
    $numcheque='';
    $banquecheque='';

    $lieuventeret=1; 
    $dateop=array();
    if (empty($dateop)) {
        $dateop=date("Y-m-d h:i");
    }else{
        $dateop=$dateop;
    }

    $numdec='commande'.$i;        

    $prodverif = $DB->querys("SELECT id FROM editionfournisseur where bl='{$bl}' ");

    if (!empty($prodverif['id'])) {?>

        <div class="alert alert-warning">Ce numero BL existe dejà!!!</div><?php

    }else{

        if(isset($_POST["env"])){
            require "uploadf.php";
        }

        $DB->insert('INSERT INTO editionfournisseur (numedit, id_client, montant, bl, nature, libelle, devise, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $montant, $bl, $nature, $motif, $devise, $lieuventeret, $dateop));

        $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($client, $montant, $motif, $numdec, $devise, 1, $lieuventeret, $dateop));

        $DB->insert('INSERT INTO banquecmd (numdec, idf, cmd, montant, devise, taux, payement, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $bl, $montant, $devise, 1, $modep, $lieuventeret, $dateop));

        $DB->insert('INSERT INTO banque (id_banque, montant, typep, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, $modep, "Retrait (".$bl.')', $numdec, $devise, $lieuventeret, $numcheque, $banquecheque));
            

        unset($_POST);
        unset($_GET);
        unset($_SESSION['searchclientvers']);
        ?>

        <div class="alert alert-success">Commande enregistrée avec succèe!!!</div><?php 
    }
}