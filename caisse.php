<?php require 'headerv2.php';?>
<div class="container-fluid mt-3">
    <div class="row"><?php 

        //require 'navcaisse.php';?>

        <div class="col-sl-12 col-md-12"><?php 
            if (!isset($_POST['type'])) {

                if (!isset($_POST['j1'])) {

                    $_SESSION['date']=date("Ymd");  
                    $dates = $_SESSION['date'];
                    $dates = new DateTime( $dates );
                    $dates = $dates->format('Ymd'); 
                    $_SESSION['date']=$dates;
                    $_SESSION['date1']=$dates;
                    $_SESSION['date2']=$dates;
                    $_SESSION['dates1']=$dates;
                    $_SESSION['date01']=date("Y-m-d"); 
                    $_SESSION['date02']=date("Y-m-d");
                    $_SESSION['typeCaisse']='general'; 
                }else{

                    $_SESSION['date01']=$_POST['j1'];
                    $_SESSION['date1'] = new DateTime($_SESSION['date01']);
                    $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
                    
                    $_SESSION['date02']=$_POST['j2'];
                    $_SESSION['date2'] = new DateTime($_SESSION['date02']);
                    $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

                    $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
                    $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y'); 
                    $_SESSION['typeCaisse']='general'; 
                }
            }
            if (isset($_POST['type'])) {
                $_SESSION['typeCaisse']=$_POST['type'];
            }
            
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

            $datenow=date("Ymd"); 
            $soldegenjours=$caisse->soldeGeneralByDeviseByDays($datenow,"gnf",$_SESSION['lieuvente'])+$caisse->soldeGeneralByDeviseByDays($datenow,"us",$_SESSION['lieuvente'])*$_SESSION['tauxus']+$caisse->soldeGeneralByDeviseByDays($datenow,"aed",$_SESSION['lieuvente'])*$_SESSION['tauxaed']+$caisse->soldeGeneralByDeviseByDays($datenow,"eu",$_SESSION['lieuvente'])*$_SESSION['tauxeu'];
            
            if (!isset($_GET['displayNone'])) {
                $display="none";
            }else{
                $display="";
            }?>
            <div class="row" >
                <div class="col-sm-12 col-md-12" style="overflow: auto; height:300px;">
                    <table class="table table-hover table-bordered table-striped table-responsive fw-bold">
                        <thead>
                            <tr>
                                <th class="text-center bg-secondary text-white" colspan="2">
                                    <div class="row">
                                        <div class="col-6 fs-7">SOLDE GENERAL GNF</div>

                                        <div class="col-6 fs-7text-start "><?=$panier->formatNombre($soldegen);?></div>
                                    </div>
                                </th>

                                <th class="text-center bg-success text-white" colspan="2" rowspan="2">
                                    <div class="row">
                                        <div class="col-7 fs-7">SOLDE CAISSE DU JOUR GNF <?=date("d/m/Y");?></div>

                                        <div class="col-5 fs-7text-start "><?=$panier->formatNombre($soldegenjours);?></div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center bg-secondary text-white fw-bold">Les Caisses</th>
                                <th class="text-center bg-secondary text-white fw-bold">Les Banques</th>
                            </tr>
                        </thead>
                        <tbody><?php 
                            
                            $cumulBanque=0;
                            $cumulgnf=0;
                            $cumulus=0;
                            $cumulaed=0;
                            $cumuleu=0;
                            $cumulgnfJours=0;
                            $cumulusJours=0;
                            $cumulaedJours=0;
                            $cumuleuJours=0;
                            
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
                                                    <td class="bg-secondary text-white fw-bold">Solde Espèces <?=ucfirst($value->nomb);?></td><?php 
                                                    foreach ($modePaie as $key => $valuemode) {
                                                        if ($valuemode->code=='gnf') {
                                                            $cumulgnf+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='us') {
                                                            $cumulus+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='aed') {
                                                            $cumulaed+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='eu') {
                                                            $cumuleu+=$montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$caisse->montantChequeCaisse($value->id,$valuemode->code);
                                                        }

                                                        $montantEspecesCaisse=$caisse->montantCaisseGNF($value->id, $valuemode->code)-$caisse->montantChequeCaisse($value->id,$valuemode->code);?>

                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($montantEspecesCaisse);?></td><?php 
                                                    }?>

                                                </tr>
                                                
                                                <tr>
                                                    <td class="bg-secondary text-white fw-bold">Solde Chèque <?=ucfirst($value->nomb);?></td><?php 
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
                                                <td class="bg-secondary text-white fw-bold">Totaux Espèces</td><?php 

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
                                                <td class="bg-secondary text-white fw-bold">Valuer Devise en GNF</td><?php 

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
                                                <td class="bg-secondary text-white fw-bold">Cumul Devise en GNF</td>
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
                                                    <td class="bg-success text-white fw-bold">Solde Espèces <?=ucfirst($value->nomb);?></td><?php 
                                                    foreach ($modePaie as $key => $valuemode) {
                                                        if ($valuemode->code=='gnf') {
                                                            $cumulgnfJours+=$montantEspecesCaisse=$caisse->montantCaisseGNFJour($datenow,$value->id, $valuemode->code)-$caisse->montantChequeCaisseJour($datenow,$value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='us') {
                                                            $cumulusJours+=$montantEspecesCaisse=$caisse->montantCaisseGNFJour($datenow,$value->id, $valuemode->code)-$caisse->montantChequeCaisseJour($datenow,$value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='aed') {
                                                            $cumulaedJours+=$montantEspecesCaisse=$caisse->montantCaisseGNFJour($datenow,$value->id, $valuemode->code)-$caisse->montantChequeCaisseJour($datenow,$value->id,$valuemode->code);
                                                        }elseif ($valuemode->code=='eu') {
                                                            $cumuleuJours+=$montantEspecesCaisse=$caisse->montantCaisseGNFJour($datenow,$value->id, $valuemode->code)-$caisse->montantChequeCaisseJour($datenow,$value->id,$valuemode->code);
                                                        }

                                                        $montantEspecesCaisseJours=$caisse->montantCaisseGNFJour($datenow,$value->id, $valuemode->code)-$caisse->montantChequeCaisseJour($datenow,$value->id,$valuemode->code);?>

                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($montantEspecesCaisseJours);?></td><?php 
                                                    }?>

                                                </tr>
                                                
                                                <tr>
                                                    <td class="bg-success text-white fw-bold">Solde Chèque <?=ucfirst($value->nomb);?></td><?php 
                                                    $montantChequeCaisseJours=$caisse->montantChequeCaisseJour($datenow,$value->id,'gnf');?>
                                                    <td class="text-end fw-bold"><?=$panier->formatNombre($montantChequeCaisseJours);?></td>
                                                </tr><?php 
                                            }?>
                                            <tr>
                                                <td class="bg-success text-white fw-bold">Totaux Espèces</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='gnf') {?>
                                                        <td rowspan="3" class="text-end fw-bold pt-4"><?=$panier->formatNombre($cumulgnfJours);?></td><?php
                                                    }elseif ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulusJours);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaedJours);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleuJours);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-success text-white fw-bold">Valeur Devise en GNF</td><?php 

                                                foreach ($modePaie as $key => $valuemode) {
                                                    if ($valuemode->code=='us') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulusJours*$_SESSION["tauxus"]);?></td><?php
                                                    }elseif ($valuemode->code=='aed') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumulaedJours*$_SESSION["tauxaed"]);?></td><?php
                                                    }elseif ($valuemode->code=='eu') {?>
                                                        <td class="text-end fw-bold"><?=$panier->formatNombre($cumuleuJours*$_SESSION["tauxeu"]);?></td><?php
                                                    }
                                                }?>
                                            </tr>

                                            <tr>
                                                <td class="bg-success text-white fw-bold">Cumul Devise en GNF</td>
                                                <td colspan="2" class="text-center fw-bold"><?=$panier->formatNombre($cumulusJours*$_SESSION["tauxus"]+$cumulaedJours*$_SESSION["tauxaed"]+$cumuleuJours*$_SESSION["tauxeu"]);?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <table class="table table-hover table-bordered table-striped table-responsive fw-bold fs-6">
                                        <thead>
                                            <tr>
                                                <th class="text-center text-center bg-secondary text-white fs-6" colspan="2"><?php 
                                                    if (isset($_GET['displayNone'])) {?>
                                                        <a href="?affichez" class="btn btn-warning fs-8 p-0 m-0">MASQUEZ TAUX DE CHANGE</a><?php
                                                    }else{?>
                                                        <a href="?displayNone" class="btn btn-warning fs-8 p-0 m-0">AFFICHEZ TAUX DE CHANGE</a><?php
                                                    }?>                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody style="display: <?=$display;?>">
                                            <form class="form" method="post">
                                                <tr>
                                                    <td>USD</td>
                                                    <td><input type="text" name="tauxus" value="<?=$panier->formatNombre($_SESSION['tauxus']);?>" onchange="this.form.submit()" class="form-control text-center p-0 m-0"></td>
                                                </tr>
                                                <tr>
                                                    <td>AED</td>
                                                    <td><input type="text" name="tauxaed" value="<?=$panier->formatNombre($_SESSION['tauxaed']);?>" onchange="this.form.submit()" class="form-control text-center p-0 m-0"></td>
                                                </tr>
                                                <tr>
                                                    <td>EURO</td>
                                                    <td><input type="text" name="tauxeu" value="<?=$panier->formatNombre($_SESSION['tauxeu']);?>" onchange="this.form.submit()" class="form-control text-center p-0 m-0"></td>
                                                </tr>
                                                <tr>
                                                    <td>FRAIS %</td>
                                                    <td><input type="text" name="tauxfrais" value="<?=$panier->formatNombre($_SESSION['tauxfrais']);?>" onchange="this.form.submit()" class="form-control text-center p-0 m-0"></td>
                                                </tr>
                                            </form>
                                        </tbody>

                                    </table>
                                </td>
                                    
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div><?php 
            $releveCaisse=$caisse->releveCaisses($_SESSION['date1'], $_SESSION['date2'],$_SESSION['typeCaisse']);
            $filtreCaisse=0;
            foreach ($releveCaisse as  $valuef) {
                $typeCaisse=$caisse->caisseById($valuef->id_banque)['type'];
                if ($typeCaisse=="caisse" and $valuef->devise=="gnf") {
                    $filtreCaisse+=$valuef->montant;
                }
            }?>
            <div class="row p-0 m-0">
                <form method="POST" class="form col-sm-12 col-md-4 ">
                    <div class="row p-0 m-0">
                        <div class="col-sm-12 col-md-6">
                            <input id="cursor" type="date" name="j1" value="<?=$_SESSION['date01'];?>" onchange="this.form.submit()" class="form-control">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="date" name="j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()" class="form-control">
                        </div>
                    </div>
                </form>
                <form method="POST" class="form col-sm-12 col-md-4 ">
                    <select name="type" onchange="this.form.submit()" class="form-select"><?php 
                        if (isset($_POST['type'])) {?>                        
                            <option value="<?=$_SESSION['typeCaisse'];?>"><?=$_SESSION['typeCaisse'];?></option><?php 
                        }else{?>                        
                            <option value="">Selectionnez</option><?php 
                        }?>
                        <option value="general">Affichez tout</option>
                        <option value="vente cash">Ventes cash</option><?php 
                        foreach ($caisse->compteAll() as $key => $valuec) {?>
                            <option value="<?=$valuec->nom_compte;?>"><?=$valuec->nom_compte;?></option><?php 
                        }?>
                    </select>
                                
                </form>
                <a class="btn btn-info text-white fw-bold col-sm-12 col-md-4" href=""><?=$configuration->formatNombre($filtreCaisse);?></a>                
            </div>
                            
            <div class="row p-0 m-0" style="height: 400px;overflow:auto; ">
            
                <table class="table table-hover table-bordered table-striped table-responsive my-2 text-center">
                    <thead class="sticky-top bg-light">
                        <tr>
                            <th >Date</th>
                            <th>Nom</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th>Commentaires</th>
                            <th>Autrement reçu</th>
                            <th>Type2</th>
                            <th>Solde Caisse GNF</th>
                        </tr>
                    </thead>
                    
                    <tbody><?php
                        $solde=0;
                        foreach ($releveCaisse as $key => $value) {
                            $client=$caisse->infosClientBanque($value->clientbanque, $value->typeent,'',$value->numero)[0];
                            if ($value->origine=='vente cash' or $value->origine=='vente credit' or $value->origine=='personnel' or $value->typeent=='depense') {
                                $autrement="";
                                $type2="";
                            }else{
                                $autrement="";
                                $type2="";
                                $soldeA=0;
                            }
                            $typeCaisse=$caisse->caisseById($value->id_banque)['type'];
                            $nomBanque=$caisse->caisseById($value->id_banque)['nomb'];
                            $solde+=$caisse->soldeCaisse($value->id,'gnf','caisse')['montant'];
                            //$solde=$caisse->infosClientBanque($value->clientbanque, $value->typeent,'gnf',$value->numero)[1];
                            if ($value->origine=='echange') {
                                if ($value->devise=="gnf") {
                                    $devise=$caisse->findDeviseByCmd($value->numero);
                                    $autrement=$devise['montant'];
                                    $type2=$devise['devise'];?>
                                    <tr>
                                        <td><?=(new dateTime($value->date_versement))->format("d/m/Y");?></td>
                                        <td><?=$client;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($value->montant);?></td>
                                        <td class=""><?=$value->origine;?></td>
                                        <td class=""><?=$value->libelles;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($autrement);?></td>
                                        <td class=""><?=$type2;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($solde);?></td>
                                    </tr><?php 
                                }
                            }else{
                                if ($value->devise!="gnf" or $typeCaisse!="caisse") {
                                    $autrement=$value->montant;
                                    if ($typeCaisse=="banque") {
                                        $type2=$nomBanque;
                                    }else{
                                        $type2=$value->devise;
                                    }?>
                                    <tr>
                                        <td><?=(new dateTime($value->date_versement))->format("d/m/Y");?></td>
                                        <td><?=$client;?></td>
                                        <td class="text-end"></td>
                                        <td class=""><?=$value->origine;?></td>
                                        <td class=""><?=$value->libelles;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($autrement);?></td>
                                        <td class=""><?=$type2;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($solde);?></td>
                                    </tr><?php 
                                }else{?>
                                    <tr>
                                        <td><?=(new dateTime($value->date_versement))->format("d/m/Y");?></td>
                                        <td><?=$client;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($value->montant);?></td>
                                        <td class=""><?=$value->origine;?></td>
                                        <td class=""><?=$value->libelles;?></td>
                                        <td class=""><?=$autrement;?></td>
                                        <td class=""><?=$type2;?></td>
                                        <td class="text-end"><?=$configuration->formatNombre($solde);?></td>
                                    </tr><?php 
                                }
                            }
                        }?>
                    </tbody>
                </table>
                
            </div>
        </div>
        
        <div class="row" style="position: fixed; top:92%;">
            <div class="col" ><a style="width: 100%; " class="btn btn-info text-center fw-bold" href="ventedirect.php">Banque</a></div> 
            <div class="col" ><a style="width: 100%; " class="btn btn-success text-center fw-bold" href="ventedirect.php">Vente Direct</a></div> 
            <div class="col" ><a style="width: 100%; " class="btn btn-primary text-center fw-bold" href="versement.php">Dépôt</a></div>
            <div class="col"><a style="width: 100%; " class="btn btn-info text-center fw-bold" href="dec.php">Retrait</a></div>
            <div class="col"><a style="width: 100%; " class="btn btn-warning text-center fw-bold" href="devise.php">Echange</a></div>
            <div class="col"><a style="width: 100%; " class="btn btn-primary text-center fw-bold" href="ventecommission.php?commission">Commissions</a></div>
            
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
        document.getElementById('cursor').focus();
    }

</script>
