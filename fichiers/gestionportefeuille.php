<?php 

$_SESSION['devise']="AED";

if (isset($_POST['taux'])) {
  $_SESSION["taux"]=$_POST['taux'];
}else{
  if (empty($_SESSION['taux'])) {
    $_SESSION['taux']='';
  }
}

if (isset($_POST['taux1'])) {
  $_SESSION["taux1"]=$_POST['taux1'];
}else{
  if (empty($_SESSION['taux1'])) {
    $_SESSION['taux1']=1;
  }
}


if (!isset($_GET['displayNone'])) {
    $display="none";
}else{
    $display="";
}

if (isset($_GET['displayNone'])) {?>
    <a href="?affichez" class="btn btn-warning my-2">Masquez la caisse</a><?php
}else{?>
    <a href="?displayNone" class="btn btn-warning my-2">Affichez la caisse</a><?php
}?>

<div class="row" style="display: <?=$display;?>">
    <div class="col-sm-12 col-md-4"><?php 
        if (isset($_GET['idtrans'])) {
        $commande->statutMoneyTransfer($_GET['idtrans'],$_GET['statut']);
        }?>
        <table class="table table-hover table-bordered table-striped text-center my-2">
            <thead>
                <tr>
                    <th colspan="4" class="bg-secondary">                
                        <div class="row">
                            <div class="col">Taux $ -> AED
                                
                                <form method="POST" class="form" ><?php 
                                if (!empty($_SESSION['taux'])) {?>
                                    <input type="text" name="taux" value="<?=$_SESSION['taux'];?>"  class="form-control text-center" onchange="this.form.submit()"><?php 
                                }else{?>
                                    <input type="text" name="taux" value="1" class="form-control text-center" onchange="this.form.submit()"><?php 
                                }?>
                                </form>
                            </div>

                            <div class="col">Taux AED -> GNF
                                
                                <form method="POST" class="form" ><?php 
                                if (!empty($_SESSION['taux1'])) {?>
                                    <input type="text" name="taux1" value="<?=$_SESSION['taux1'];?>"  class="form-control text-center" onchange="this.form.submit()"><?php 
                                }else{?>
                                    <input type="text" name="taux1" value="1" class="form-control text-center" onchange="this.form.submit()"><?php 
                                }?>
                                </form>
                            </div>
                        </div>
                    </th>
                </tr>

                <tr>
                    <th>Fournisseurs</th>
                    <th>USD</th>
                    <th>AED</th>
                </tr>               
            </thead>
            <tbody><?php
                $cmdconf=0; 
                $cmdconfusd=0; 
                foreach ($panier->clientf('fournisseur', 'fournisseur') as $valuef) {?>
                    <tr><?php
                        $prodfusd=$DB->querys("SELECT sum((pv/taux)*qtite) as montant FROM gestionachatfournisseur where fournisseur='{$valuef->id}' and cmd='{$_SESSION['bl']}' "); 

                        $prodf=$DB->querys("SELECT sum((pv)*qtite) as montant FROM gestionachatfournisseur where fournisseur='{$valuef->id}' and cmd='{$_SESSION['bl']}' "); 

                        $cmdusd=$prodfusd['montant'];
                        $cmdconfusd+=$cmdusd;
                        
                        $cmd=$prodf['montant'];
                        $cmdconf+=$cmd;?>
                        <th><?=$valuef->nom_client;?></th>
                        <td><?=number_format($cmdusd,2,',',' ');?></td>
                        <td><?=number_format($cmd,2,',',' ');?></td>
                    </tr><?php 
                }?>
            </tbody>
            <tfoot>
                <tr>
                <th>Totaux</th>
                <th><?=number_format($cmdconfusd,2,',',' ');?></th>
                <th><?=number_format($cmdconf,2,',',' ');?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-sm-12 col-md-3">
        <table class="table table-hover table-bordered table-striped text-center my-2"><?php                
            $portefeuille=$commande->portefeuilleByCmd($_SESSION['bl'], 'ok')['montant'];
            $payer=$commande->paieCmdSupplier($_SESSION['bl'])['montant'];
            $solde=$portefeuille-$payer;?>
            <thead>
                <tr class="bg-secondary">
                    <th>Solde</th>
                    <th><?=number_format($solde,2,',',' ');?></th>
                </tr>
                <tr>
                    <th>Portefeuille</th>
                    <th><?=number_format($portefeuille,2,',',' ');?></th>                    
                </tr>

                <tr>
                    <th>Payer</th>
                    <th><?=number_format($payer,2,',',' ');?></th>                    
                </tr>
            </thead>
        </table>
    </div>
    <div class="col-sm-12 col-md-5">
        <table class="table table-hover table-bordered table-striped text-center my-2" ><?php
            $solde=0;
            $portefeuille=0;
            $payer=0;?>
            <thead>                  
                <tr>
                <th>Date</th>
                <th>Montant Envoyé</th>
                <th>Montant Réçu</th>
                <th>Taux</th>
                <th></th>                  
                </tr>
            </thead>
            <tbody><?php 
                $cumulSend=0;
                $cumulReceveid=0;
                foreach ($commande->moneyTransferByCmd($_SESSION['bl']) as $value) {
                $cumulSend+=$value->montant;
                $cumulReceveid+=$value->montant*$value->taux; ?>
                <tr>
                    <td><?=(new dateTime($value->dateop))->format("d/m/Y") ;?></td>
                    <td class="text-end" ><?=number_format($value->montant,2,',',' ');?></td> 
                    <td ><?=number_format($value->montant*$value->taux,2,',',' ');?></td>
                    <td ><?=number_format($value->taux,2,',',' ');?></td>                    
                    <td><?php 
                    if ($value->statut=="nok") {?>
                        <a href="gestionachatfournisseur.php?idtrans=<?=$value->id;?>&statut=<?="ok";?>" class="btn btn-success" type="button">Confirmer</a><?php 
                    }else{?>
                        <a href="gestionachatfournisseur.php?idtrans=<?=$value->id;?>&statut=<?="nok";?>" class="btn btn-warning" type="button">Annuler</a><?php 
                    }?>
                    </td>              
                </tr><?php 
                }?>
            </tbody>
            <tfoot>
                <tr class="bg-secondary">
                <th>Totaux</th>
                <th class="text-end"><?=number_format($cumulSend,2,',',' ');?></th>
                <th class="text-end"><?=number_format($cumulReceveid,2,',',' ');?></th>
                <th></th>
                </tr>
            </tfoot>

        </table>
    </div>
</div>