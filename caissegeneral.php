<?php require 'headerv2.php';?>
<div class="container-fluid mt-3">
    <div class="row"><?php 

        require 'navcaisse.php';?>

        <!-- <div class="col-sm-12 col-md-10" style="overflow: auto;"><?php

            $bdd='caissecloture';   

            $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_banque` int(2) NOT NULL,
                `devise` varchar(50),
                `montantsaisie` double DEFAULT '0',
                `montantreel` double DEFAULT '0',
                `difference` double DEFAULT '0',
                `idpers` int(2),
                `dateop` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            )");

            if (isset($_GET['delete'])) {

                $DB->delete("DELETE from caissecloture where id='{$_GET['delete']}'");

                $DB->delete("DELETE from banque where numero='{$_GET['delete']}'");?>

                <div class="alert alert-success">Suppression effectuée !!</div><?php 
            }

            if (isset($_POST['validgnf'])) {
                $banque=$panier->h($_POST['banque']);
                $devise="gnf";
                $montantsaisie=$panier->h($panier->espace($_POST['montantsaisie']));
                $montantreel=$panier->h($panier->espace($_POST['montantreel']));
                if (empty($montantreel)) {
                    $montantreel=0;
                }
                $difference=$montantsaisie-$montantreel;
                if ($panier->lieuVenteCaisse($banque)[1]=='banque') {
                    $lieuvente=$_SESSION['lieuvente'];
                }else{
                    $lieuvente=$panier->lieuVenteCaisse($banque)[0];
                }

                $numdec = $DB->querys('SELECT max(id) AS id FROM caissecloture ');
                $numdec=$numdec['id']+1;

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($banque, $difference, "cloture caisse", $numdec, $devise, $lieuvente, "", ""));

                $DB->insert("INSERT INTO caissecloture (id_banque, devise, montantsaisie, montantreel, difference, idpers, dateop)VALUES(?, ?, ?, ?, ?, ?, now())", array($banque, $devise, $montantsaisie, $montantreel, $difference, $_SESSION['idpseudo']));?>

                <div class="alert alert-success">Opération effectuée avec succèe !!!</div><?php
            }

            if (isset($_POST['validcheque'])) {
                $banque=$panier->h($_POST['banque']);
                $devise="gnf";
                $montantsaisie=$panier->h($panier->espace($_POST['montantsaisie']));
                $montantreel=$panier->h($panier->espace($_POST['montantreel']));
                if (empty($montantreel)) {
                    $montantreel=0;
                }
                
                $difference=$montantsaisie-$montantreel;
                if ($panier->lieuVenteCaisse($banque)[1]=='banque') {
                    $lieuvente=$_SESSION['lieuvente'];
                }else{
                    $lieuvente=$panier->lieuVenteCaisse($banque)[0];
                }

                $numdec = $DB->querys('SELECT max(id) AS id FROM caissecloture ');
                $numdec=$numdec['id']+1;

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, typeP, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($banque, $difference, "cloture caisse", $numdec, $devise, "cheque", $lieuvente, "", ""));

                $DB->insert("INSERT INTO caissecloture (id_banque, devise, montantsaisie, montantreel, difference, idpers, dateop)VALUES(?, ?, ?, ?, ?, ?, now())", array($banque, $devise, $montantsaisie, $montantreel, $difference, $_SESSION['idpseudo']));?>

                <div class="alert alert-success">Opération effectuée avec succèe !!!</div><?php
            }
            
            if (isset($_POST['valideu'])) {
                $banque=$panier->h($_POST['banque']);
                $devise="eu";
                $montantsaisie=$panier->h($panier->espace($_POST['montantsaisie']));
                $montantreel=$panier->h($panier->espace($_POST['montantreel']));
                if (empty($montantreel)) {
                    $montantreel=0;
                }
                $difference=$montantsaisie-$montantreel;
                
                if ($panier->lieuVenteCaisse($banque)[1]=='banque') {
                    $lieuvente=$_SESSION['lieuvente'];
                }else{
                    $lieuvente=$panier->lieuVenteCaisse($banque)[0];
                }

                $numdec = $DB->querys('SELECT max(id) AS id FROM caissecloture ');
                $numdec=$numdec['id']+1;

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($banque, $difference, "cloture caisse", $numdec, $devise, $lieuvente, "", ""));

                $DB->insert("INSERT INTO caissecloture (id_banque, devise, montantsaisie, montantreel, difference, idpers, dateop)VALUES(?, ?, ?, ?, ?, ?, now())", array($banque, $devise, $montantsaisie, $montantreel, $difference, $_SESSION['idpseudo']));?>

                <div class="alert alert-success">Opération effectuée avec succèe !!!</div><?php
            }
            
            if (isset($_POST['validus'])) {
                $banque=$panier->h($_POST['banque']);
                $devise="us";
                $montantsaisie=$panier->h($panier->espace($_POST['montantsaisie']));
                $montantreel=$panier->h($panier->espace($_POST['montantreel']));
                if (empty($montantreel)) {
                    $montantreel=0;
                }
                $difference=$montantsaisie-$montantreel;
                if ($panier->lieuVenteCaisse($banque)[1]=='banque') {
                    $lieuvente=$_SESSION['lieuvente'];
                }else{
                    $lieuvente=$panier->lieuVenteCaisse($banque)[0];
                }

                $numdec = $DB->querys('SELECT max(id) AS id FROM caissecloture ');
                $numdec=$numdec['id']+1;

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($banque, $difference, "cloture caisse", $numdec, $devise, $lieuvente, "", ""));

                $DB->insert("INSERT INTO caissecloture (id_banque, devise, montantsaisie, montantreel, difference, idpers, dateop)VALUES(?, ?, ?, ?, ?, ?, now())", array($banque, $devise, $montantsaisie, $montantreel, $difference, $_SESSION['idpseudo']));?>

                <div class="alert alert-success">Opération effectuée avec succèe !!!</div><?php
            }
            
            if (isset($_POST['validcfa'])) {
                $banque=$panier->h($_POST['banque']);
                $devise="cfa";
                $montantsaisie=$panier->h($panier->espace($_POST['montantsaisie']));
                $montantreel=$panier->h($panier->espace($_POST['montantreel']));
                if (empty($montantreel)) {
                    $montantreel=0;
                }
                $difference=$montantsaisie-$montantreel;
                if ($panier->lieuVenteCaisse($banque)[1]=='banque') {
                    $lieuvente=$_SESSION['lieuvente'];
                }else{
                    $lieuvente=$panier->lieuVenteCaisse($banque)[0];
                }

                $numdec = $DB->querys('SELECT max(id) AS id FROM caissecloture ');
                $numdec=$numdec['id']+1;

                $DB->insert('INSERT INTO banque (id_banque, montant, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, now())', array($banque, $difference, "cloture caisse", $numdec, $devise, $lieuvente, "", ""));

                $DB->insert("INSERT INTO caissecloture (id_banque, devise, montantsaisie, montantreel, difference, idpers, dateop)VALUES(?, ?, ?, ?, ?, ?, now())", array($banque, $devise, $montantsaisie, $montantreel, $difference, $_SESSION['idpseudo']));?>

                <div class="alert alert-success">Opération effectuée avec succèe !!!</div><?php
            }?>

        
            <table class="table table-hover table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Devise</th><?php 
                        foreach ($panier->nomBanque() as $value) {?>
                            <th colspan="2" class="text-center"><?=$value->nomb;?></th><?php
                        }?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Montant GNF</td><?php 
                        foreach ($panier->nomBanque() as $banque) {
                            $montantgnf=$panier->montantCompteBil($banque->id, "gnf")-$panier->montantCompteBilCheque($banque->id, "gnf");?>
                            <form class="form" action="caisse.php" method="POST">
                                <td class="text-end"> 
                                    <input class="form-control" type="text" name="montantsaisie" value="<?=number_format($montantgnf,0,',',' ');?>" />
                                    <input type="hidden" name="banque" value="<?=$banque->id;?>">
                                    <input type="hidden" name="montantreel" value="<?=$montantgnf;?>">
                                </td>
                                <td><button class="btn btn-primary" name="validgnf">Valider</button></td>
                                
                            </form><?php 
                        }?>
                    </tr>

                    <tr>
                        <td>Montant EU</td><?php 
                        foreach ($panier->nomBanque() as $banque) {?>
                            <form class="form" action="caisse.php" method="POST">
                                <td class="text-end"> 
                                    <input class="form-control" type="text" name="montantsaisie" value="<?=number_format($panier->montantCompteBil($banque->id, "eu"),2,',',' ');?>" />
                                    <input type="hidden" name="banque" value="<?=$banque->id;?>">
                                    <input type="hidden" name="montantreel" value="<?=$panier->montantCompteBil($banque->id, "eu");?>">
                                </td>
                                <td><button class="btn btn-primary" name="valideu">Valider</button></td>
                                
                            </form><?php 
                        }?>
                    </tr>

                    <tr>
                        <td>Montant US</td><?php 
                        foreach ($panier->nomBanque() as $banque) {?>
                            <form class="form" action="caisse.php" method="POST">
                                <td class="text-end"> 
                                    <input class="form-control" type="text" name="montantsaisie" value="<?=number_format($panier->montantCompteBil($banque->id, "us"),2,',',' ');?>" />
                                    <input type="hidden" name="banque" value="<?=$banque->id;?>">
                                    <input type="hidden" name="montantreel" value="<?=$panier->montantCompteBil($banque->id, "us");?>">
                                </td>
                                <td><button class="btn btn-primary" name="validus">Valider</button></td>
                                
                            </form><?php 
                        }?>
                    </tr>

                    <tr>
                        <td>Montant CFA</td><?php 
                        foreach ($panier->nomBanque() as $banque) {?>
                            <form class="form" action="caisse.php" method="POST">
                                <td class="text-end"> 
                                    <input class="form-control" type="text" name="montantsaisie" value="<?=number_format($panier->montantCompteBil($banque->id, "cfa"),2,',',' ');?>" />
                                    <input type="hidden" name="banque" value="<?=$banque->id;?>">
                                    <input type="hidden" name="montantreel" value="<?=$panier->montantCompteBil($banque->id, "cfa");?>">
                                </td>
                                <td><button class="btn btn-primary" name="validcfa">Valider</button></td>
                                
                            </form><?php 
                        }?>
                    </tr>

                    <tr>
                        <td>Chèque GNF</td><?php 
                        foreach ($panier->nomBanqueCaisseFiltre() as $banque) {?>
                            <form class="form" action="caisse.php" method="POST">
                                <td class="text-end"> 
                                    <input class="form-control" type="text" name="montantsaisie" value="<?=number_format($panier->montantCompteBilCheque($banque->id, "gnf"),0,',',' ');?>" />
                                    <input type="hidden" name="banque" value="<?=$banque->id;?>">
                                    <input type="hidden" name="montantreel" value="<?=$panier->montantCompteBilCheque($banque->id, "gnf");?>">
                                </td>
                                <td><button class="btn btn-primary" name="validcheque">Valider</button></td>
                                
                            </form><?php 
                        }?>
                    </tr>


                </tbody>
            </table><?php 
            foreach ($panier->monnaie as $valued) {
                if (!empty($panier->listeCloture($valued))) {?>
                    <table class="table table-hover table-bordered table-striped table-responsive my-4">
                        <thead>
                            <tr>
                                <th colspan="9" scope="col" class="text-center bg-info"><label>Liste des clotures <?=strtoupper($valued);?></label></th>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center">N°</th>
                                <th scope="col" class="text-center">Date</th>
                                <th scope="col" class="text-center">Caisse/Banque</th>
                                <th scope="col" class="text-center">Montant Théorique</th>
                                <th scope="col" class="text-center">Montant Réel</th>
                                <th scope="col" class="text-center">Difference</th>
                                <th scope="col" class="text-center">Devise</th>
                                <th scope="col" class="text-center">Saisie par</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody><?php
                            $totdiff=0; 
                            $totreel=0; 
                            $totsaisie=0; 
                            foreach ($panier->listeCloture($valued) as $key => $value) {
                                $totdiff+=$value->difference;
                                $totreel+=$value->montantreel;
                                $totsaisie+=$value->montantsaisie;
                                ?>
                                <tr>
                                    <th scope="row"><?=$key+1;?></th>
                                    <td class="text-center"><?=(new dateTime($value->dateop))->format("d/m/Y");?></td>
                                    <td class="text-center"><?=$panier->nomBanquefecth($value->id_banque);?></td>
                                    <td class="text-end"><?=number_format($value->montantreel,2,',',' ');?></td>
                                    <td class="text-end"><?=number_format($value->montantsaisie,2,',',' ');?></td>
                                    <td class="text-end"><?=number_format($value->difference,2,',',' ');?></td>
                                    <td class="text-center"><?=strtoupper($value->devise);?></td>
                                    <td class="text-center "><?=$panier->nomPersonnel($value->idpers);?></td>
                                    <td><a class="btn btn-danger m-auto" onclick="return alerteS()" href="caisse.php?delete=<?=$value->id;?>">Supprimer</a></td>
                                </tr><?php 
                            }?>               
                    
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Totaux</th>
                                <th class="text-end"><?=number_format($totreel,2,',',' ');?></th>
                                <th class="text-end"><?=number_format($totsaisie,2,',',' ');?></th>
                                <th class="text-end"><?=number_format($totdiff,2,',',' ');?></th>
                            </tr>
                        </tfoot>
                    </table><?php 
                }
            }?>

        </div> -->

        <div class="col-sl-12 col-md-10"><?php 
            if (isset($_POST['tauxeu'])) {
                $_SESSION['tauxeu']=$configuration->espace($_POST['tauxeu']);
                $_SESSION['tauxus']=$configuration->espace($_POST['tauxus']);
                $_SESSION['tauxaed']=$configuration->espace($_POST['tauxaed']);
                $_SESSION['tauxfrais']=$configuration->espace($_POST['tauxfrais']);
            }
            if (empty($_SESSION['tauxeu'])) {
                $_SESSION['tauxeu']=1;
            }
        
            if (empty($_SESSION['tauxus'])) {
                $_SESSION['tauxus']=1;
            }
        
            if (empty($_SESSION['tauxaed'])) {
                $_SESSION['tauxaed']=1;
            }
            if (empty($_SESSION['tauxfrais'])) {
                $_SESSION['tauxfrais']=8;
            }
            $modePaie=$configuration->paieMode();
            
            $soldegen=$caisse->soldeGeneralByDevise("gnf",$_SESSION['lieuvente'])+$caisse->soldeGeneralByDevise("us",$_SESSION['lieuvente'])*$_SESSION['tauxus']+$caisse->soldeGeneralByDevise("aed",$_SESSION['lieuvente'])*$_SESSION['tauxaed']+$caisse->soldeGeneralByDevise("eu",$_SESSION['lieuvente'])*$_SESSION['tauxeu'];
            
            if (!isset($_GET['displayNone'])) {
                $display="none";
            }else{
                $display="";
            }?>
            <div class="row">
                <div class="col-4">
                    <table class="table table-hover table-bordered table-striped table-responsive fw-bold">
                        <thead>
                            <tr>
                                <th class="text-center text-center bg-secondary text-white" colspan="2"><?php 
                                    if (isset($_GET['displayNone'])) {?>
                                        <a href="?affichez" class="btn btn-warning my-2">MASQUEZ TAUX DE CHANGE</a><?php
                                    }else{?>
                                        <a href="?displayNone" class="btn btn-warning my-2">AFFICHEZ TAUX DE CHANGE</a><?php
                                    }?>                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody style="display: <?=$display;?>">
                            <form class="form" method="post">
                                <tr>
                                    <td>USD</td>
                                    <td><input type="text" name="tauxus" value="<?=$panier->formatNombre($_SESSION['tauxus']);?>" onchange="this.form.submit()" class="form-control text-end"></td>
                                </tr>
                                <tr>
                                    <td>AED</td>
                                    <td><input type="text" name="tauxaed" value="<?=$panier->formatNombre($_SESSION['tauxaed']);?>" onchange="this.form.submit()" class="form-control text-end"></td>
                                </tr>
                                <tr>
                                    <td>EURO</td>
                                    <td><input type="text" name="tauxeu" value="<?=$panier->formatNombre($_SESSION['tauxeu']);?>" onchange="this.form.submit()" class="form-control text-end"></td>
                                </tr>
                                <tr>
                                    <td>FRAIS %</td>
                                    <td><input type="text" name="tauxfrais" value="<?=$panier->formatNombre($_SESSION['tauxfrais']);?>" onchange="this.form.submit()" class="form-control text-end"></td>
                                </tr>
                            </form>
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="row" >
                <div class="col-sm-12 col-md-12">
                    <table class="table table-hover table-bordered table-striped table-responsive my-2 fw-bold">
                        <thead>
                            <tr>
                                <th class="text-center bg-secondary text-white" colspan="2">
                                    <div class="row">
                                        <div class="col-6 fs-5 ">SOLDE GENERAL GNF</div>

                                        <div class="col-6 fs-5 text-start "><?=$panier->formatNombre($soldegen);?></div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center bg-secondary text-white fw-bold fs-5">Les Caisses</th>
                                <th class="text-center bg-secondary text-white fw-bold fs-5">Les Banques</th>
                            </tr>
                        </thead>
                        <tbody><?php 
                            
                            $cumulBanque=0;
                            $cumulgnf=0;
                            $cumulus=0;
                            $cumulaed=0;
                            $cumuleu=0;
                            
                            ?>
                            <tr>
                                <td>
                                    <table class="table table-hover table-bordered table-striped table-responsive my-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center bg-secondary text-white fw-bold">Caisses</th><?php 
                                                    
                                                foreach ($modePaie as $key => $valuemode) {?>
                                                    <th class="text-center bg-secondary text-white fw-bold"><?=strtoupper($valuemode->code);?></th><?php 
                                                }?>
                                            </tr>

                                        </thead>
                                        <tbody><?php 
                                            $values=$caisse->nomTypeCaisse();
                                            foreach ($values as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td class="bg-secondary text-white fw-bold">SOLDE ESPECE <?=strtoupper($value->nomb);?></td><?php 
                                                    foreach ($modePaie as $key => $valuemode) {
                                                        if ($valuemode->code=='gnf') {
                                                            $cumulgnf+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='us') {
                                                            $cumulus+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='aed') {
                                                            $cumulaed+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='eu') {
                                                            $cumuleu+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }

                                                        $montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);?>

                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($montantEspecesCaisse);?></td><?php 
                                                    }?>

                                                </tr>
                                                
                                                <tr>
                                                    <td class="bg-secondary text-white fw-bold">SOLDE CHEQUE <?=strtoupper($value->nomb);?></td><?php 
                                                    $montantChequeCaisse=$caisse->montantChequeCaisse($value->id,'gnf');?>
                                                    <td class="text-end fw-bold"><?=$panier->formatNombre($montantChequeCaisse);?></td>
                                                </tr><?php 
                                            }?>
                                            <!-- <tr>
                                                <td class="bg-secondary text-white fw-bold">SOLDE TOTAL BANQUE</td><?php 
                                                $banque=$caisse->nomTypeBanque();
                                                foreach ($banque as $key => $value) {
                                                    $cumulBanque+=$caisse->montantSoldeBanqueGNF($value->id, 'gnf')['montant'];
                                                }?>
                                                <td class="text-end fw-bold"><?=$panier->formatNombre($cumulBanque);?></td>
                                            </tr> -->
                                            <tr>
                                                <td class="bg-secondary text-white fw-bold">TOTAL ESPECES</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='gnf') {?>
                                                        <td rowspan="3" class="text-end fw-bold pt-4"><?=$panier->formatNombre($cumulgnf);?></td><?php
                                                    }elseif ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulus);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaed);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleu);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-secondary text-white fw-bold">VALEUR DEVISE EN GNF</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulus*$_SESSION["tauxus"]);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaed*$_SESSION["tauxaed"]);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleu*$_SESSION["tauxeu"]);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-secondary text-white fw-bold">CUMUL DEVISE EN GNF</td>
                                                <td colspan="2" class="text-center fw-bold"><?=$panier->formatNombre($cumulus*$_SESSION["tauxus"]+$cumulaed*$_SESSION["tauxaed"]+$cumuleu*$_SESSION["tauxeu"]);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <table class="table table-hover table-bordered table-striped table-responsive my-2">
                                        <tbody><?php 
                                            $cumulBanque=0;
                                            foreach ($banque as $key => $value) {
                                                $montantBanque=$caisse->montantSoldeBanqueGNF($value->id, 'gnf')['montant'];
                                                
                                                $cumulBanque+=$montantBanque;?>
                                                <tr>
                                                    <td class="bg-secondary text-white fw-bold">SOLDE <?=strtoupper($value->nomb);?></td>
                                                    <td class="text-end fw-bold"><?=$panier->formatNombre($montantBanque);?></td>
                                                </tr><?php 
                                            }?>

                                            <tr>
                                                <td class="bg-secondary text-white fw-bold">SOLDE TOTAL BANQUE</td><?php 
                                                $banque=$caisse->nomTypeBanque();
                                                foreach ($banque as $key => $value) {
                                                
                                                }?>
                                                <td class="text-end fw-bold"><?=$panier->formatNombre($cumulBanque);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                    
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 col-md-12">
                    <table class="table table-hover table-bordered table-striped table-responsive my-2 fw-bold"><?php
                        $datenow=date("Ymd"); 
                        $soldegenjours=$caisse->soldeGeneralByDeviseByDays($datenow,"gnf",$_SESSION['lieuvente'])+$caisse->soldeGeneralByDeviseByDays($datenow,"us",$_SESSION['lieuvente'])*$_SESSION['tauxus']+$caisse->soldeGeneralByDeviseByDays($datenow,"aed",$_SESSION['lieuvente'])*$_SESSION['tauxaed']+$caisse->soldeGeneralByDeviseByDays($datenow,"eu",$_SESSION['lieuvente'])*$_SESSION['tauxeu'];?>
                        <thead>
                            <tr>
                                <th class="text-center bg-success text-white" colspan="2">
                                    <div class="row">
                                        <div class="col-6 fs-5 ">SOLDE CAISSE DU JOUR GNF</div>

                                        <div class="col-6 fs-5 text-start "><?=$panier->formatNombre($soldegenjours);?></div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center bg-success text-white fw-bold fs-5">Les Caisses</th>
                                <th class="text-center bg-success text-white fw-bold fs-5">Les Banques</th>
                            </tr>
                        </thead>
                        <tbody><?php 
                            
                            $cumulBanque=0;
                            $cumulgnf=0;
                            $cumulus=0;
                            $cumulaed=0;
                            $cumuleu=0;
                            
                            ?>
                            <tr>
                                <td>
                                    <table class="table table-hover table-bordered table-striped table-responsive my-2">
                                        <thead>
                                            <tr>
                                                <th class="text-center bg-success text-white fw-bold">Caisses</th><?php 
                                                    
                                                foreach ($modePaie as $key => $valuemode) {?>
                                                    <th class="text-center bg-success text-white fw-bold"><?=strtoupper($valuemode->code);?></th><?php 
                                                }?>
                                            </tr>

                                        </thead>
                                        <tbody><?php 
                                            $values=$caisse->nomTypeCaisse();
                                            foreach ($values as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td class="bg-success text-white fw-bold">SOLDE ESPECE <?=strtoupper($value->nomb);?></td><?php 
                                                    foreach ($modePaie as $key => $valuemode) {
                                                        if ($valuemode->code=='gnf') {
                                                            $cumulgnf+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='us') {
                                                            $cumulus+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='aed') {
                                                            $cumulaed+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='eu') {
                                                            $cumuleu+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }

                                                        $montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$montantChequeCaisse=$caisse->montantChequeCaisse($value->id,$valuemode->code);?>

                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($montantEspecesCaisse);?></td><?php 
                                                    }?>

                                                </tr>
                                                
                                                <tr>
                                                    <td class="bg-success text-white fw-bold">SOLDE CHEQUE <?=strtoupper($value->nomb);?></td><?php 
                                                    $montantChequeCaisse=$caisse->montantChequeCaisse($value->id,'gnf');?>
                                                    <td class="text-end fw-bold"><?=$panier->formatNombre($montantChequeCaisse);?></td>
                                                </tr><?php 
                                            }?>
                                            <!-- <tr>
                                                <td class="bg-success text-white fw-bold">SOLDE TOTAL BANQUE</td><?php 
                                                $banque=$caisse->nomTypeBanque();
                                                foreach ($banque as $key => $value) {
                                                    $cumulBanque+=$caisse->montantSoldeBanqueGNF($value->id, 'gnf')['montant'];
                                                }?>
                                                <td class="text-end fw-bold"><?=$panier->formatNombre($cumulBanque);?></td>
                                            </tr> -->
                                            <tr>
                                                <td class="bg-success text-white fw-bold">TOTAL ESPECES</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='gnf') {?>
                                                        <td rowspan="3" class="text-end fw-bold pt-4"><?=$panier->formatNombre($cumulgnf);?></td><?php
                                                    }elseif ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulus);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaed);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleu);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-success text-white fw-bold">VALEUR DEVISE EN GNF</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulus*$_SESSION["tauxus"]);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaed*$_SESSION["tauxaed"]);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleu*$_SESSION["tauxeu"]);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-success text-white fw-bold">CUMUL DEVISE EN GNF</td>
                                                <td colspan="2" class="text-center fw-bold"><?=$panier->formatNombre($cumulus*$_SESSION["tauxus"]+$cumulaed*$_SESSION["tauxaed"]+$cumuleu*$_SESSION["tauxeu"]);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <table class="table table-hover table-bordered table-striped table-responsive my-2">
                                        <tbody><?php 
                                            $cumulBanque=0;
                                            foreach ($banque as $key => $value) {
                                                $montantBanque=$caisse->montantSoldeBanqueGNF($value->id, 'gnf')['montant'];
                                                
                                                $cumulBanque+=$montantBanque;?>
                                                <tr>
                                                    <td class="bg-success text-white fw-bold">SOLDE <?=strtoupper($value->nomb);?></td>
                                                    <td class="text-end fw-bold"><?=$panier->formatNombre($montantBanque);?></td>
                                                </tr><?php 
                                            }?>

                                            <tr>
                                                <td class="bg-success text-white fw-bold">SOLDE TOTAL BANQUE</td><?php 
                                                $banque=$caisse->nomTypeBanque();
                                                foreach ($banque as $key => $value) {
                                                
                                                }?>
                                                <td class="text-end fw-bold"><?=$panier->formatNombre($cumulBanque);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                    
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>
    <?php  require "footer.php";?>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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
