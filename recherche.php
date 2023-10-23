<?php require 'headerv2.php';?>
<div class="container-fluid">
  <div class="row"><?php

    if (isset($_GET['reclient'])) {
      $_SESSION['reclient']=$_GET['reclient'];
    }


    require 'enteterechercher.php';?>

    <div class="col-sm-12 col-md-10"><?php

      if (isset($_POST['rechercher']) or isset($_GET['recreditc']) or !empty($_SESSION['num_cmdp'])) {  

        if (isset($_POST['rechercher'])){

          $Num_cmd=$_POST['rechercher'];
        }

        if (isset($_GET['recreditc'])){

          $Num_cmd=$_GET['recreditc'];
        }

        if (!empty($_SESSION['num_cmdp'])) {
          $Num_cmd=$_SESSION['num_cmdp'];
          $_SESSION['rechercher']=$Num_cmd;
          unset($_SESSION['num_cmdp']);
        }


        $_SESSION['rechercher']=$Num_cmd;


        $payement=$DB->querys('SELECT num_cmd, montantpaye, remise, reste, etat, num_client, nomclient, DATE_FORMAT(date_cmd, \'%d/%m/%Y \à %H:%i:%s\')AS DateTemps, vendeur, DATE_FORMAT(datealerte, \'%d/%m/%Y\') as datealerte FROM payement WHERE num_cmd= ?', array($Num_cmd));

        $adress = $DB->querys('SELECT * FROM adresse ');

        $frais=$DB->querys('SELECT numcmd, montant, motif  FROM fraisup WHERE numcmd= ?', array($Num_cmd));

        if ($payement['num_client']==0) {
          $_SESSION['nameclient']=$payement['nomclient'];
          $_SESSION['reclient']=$payement['nomclient'];
        }else{

          $_SESSION['nameclient']=$payement['num_client'];
          $_SESSION['reclient']=$payement['num_client'];

        }

        $idc=$payement['num_client'];
          //require 'headerticketclient.php';?>

        <table class="table table-bordered table-striped table-hover align-middle">

          <tr>
            <td><strong><?php echo "Facture N°: " .$Num_cmd; ?> de <?=$panier->nomClient($_SESSION['nameclient']);?></strong></td>
          </tr>

          <tr>
            <td><?php echo "Date:  " .$payement['DateTemps']; ?></td>
          </tr><?php 
          if ($payement['etat']=='credit' and !empty($payement['datealerte'])) {?>

            <tr>
              <td style="color: red;"><?= "A régler avant le:  " .$payement['datealerte']; ?></td>
            </tr><?php 
          }?>

          <tr>
            <td><?php echo "Vendeur:  " .$panier->nomPersonnel($payement['vendeur']); ?></td>  
          </tr>

        </table>

        <table class="table table-bordered table-striped table-hover align-middle">

          <tbody class="text-center ">

            <tr>            
              <th style="width: 44%; text-align: center;">Désignation</th>
              <th style="width: 8%; padding-right: 5px; text-align: center;">Qtité</th>
              <th style="width: 8%; padding-right: 5px; text-align: center;">Livré</th>
              <th style="width: 17%; text-align: center;">Prix Unitaire</th>
              <th style="width: 23%; padding-right: 10px; text-align: center;">Prix Total</th>
            </tr>

          </tbody>

          <tbody><?php

            $total=0;

             $products=$DB->query('SELECT quantity, commande.prix_vente as prix_vente, designation, qtiteliv, type FROM commande inner join productslist on productslist.id=commande.id_produit WHERE num_cmd= ?', array($Num_cmd));

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
                $pv=$configuration->formatNombre($product->prix_vente);
                $pvtotal=$configuration->formatNombre($product->prix_vente*$product->quantity);
              }?>

              <tr>

                <td style="width: 44%;text-align:left"><?=ucwords(strtolower($product->designation)); ?></td>

                <td class="text-center" style="width: 8%;"><?= $product->quantity; ?></td>

                <td class="text-center" style="width: 8%;"><?= $product->qtiteliv.'/'.$product->quantity; ?></td>

                <td style="width: 17%; text-align:right"><?=$pv; ?></td>

                <td style="width: 23%; text-align:right; padding-right: 10px;"><?= $pvtotal; ?></td><?php

                $price=($product->prix_vente*$product->quantity);

                $total += $price;?>

              </tr><?php
            }

            if (!empty($frais['motif'])) {

              $nbreligne=sizeof($products)+1;?>

              <tr>              
                <td style="width: 44%;text-align:left"><?=ucwords($frais['motif']); ?></td>
                <td style="width: 8%;">-</td>
                <td style="width: 8%;">-</td>

                <td style="width: 17%; text-align:right"><?=$configuration->formatNombre($frais['montant']); ?></td>

                <td style="width: 23%; text-align:right; padding-right: 10px;"><?= $configuration->formatNombre($frais['montant']); ?></td>
              </tr><?php
            }

            $total=$total+$frais['montant'];

            $montantverse=$payement['montantpaye'];

            $Remise=$payement['remise'];

             $reste=$payement['reste'];

            $ttc = $total-$Remise;

            $tot_Rest = $total-$montantverse;

            if ($nbreligne==1) {

              // $top=(205/($nbreligne));
              $top=30;
            }else{

              // $top=(205-($nbreligne*10));
              $top=30;

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
              <td style="text-align:right; padding-right: 5px;"><?php echo $configuration->formatNombre($total) ?></td>
            </tr>

            <tr>
              <td style="text-align: right;" class="no-border">Montant Remise</td>               
              <td style="text-align:right; padding-right: 5px;"><?php echo $configuration->formatNombre($Remise) ?></td>        
            </tr>

            <tr>
              <td style="text-align: right; margin-bottom: 5px" class="no-border">Net à Payer </td>
              <td style="text-align:right; padding-right: 5px;"><?php echo $configuration->formatNombre($ttc) ?></td>
            </tr>

          </tbody>

          <tbody>

            <tr><?php

              if ($tot_Rest<=0) {?>
              
                <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".$configuration->formatNombre($montantverse);?></td>

                <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Rendu au Client: ".$configuration->formatNombre(-$reste);?> GNF</td><?php

              }else{?>

                <td colspan="3" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px; border-right: 0px;"><?="Montant Total Payé: ".$configuration->formatNombre($montantverse);?> GNF</td>

                <td colspan="2" style="padding-right: 15px; padding-top: 8px; text-align: center; font-size:16px;"><?="Reste à Payer: ".$configuration->formatNombre($tot_Rest-$Remise);?> GNF</td><?php

              }?>
            </tr>

            <tr>
              <th colspan="5" style="border:0px; border-left: 1px; border-right: 1px;"></th>
            </tr>

            <tr>
              <td colspan="5" style="font-size: 16px; text-align: center;"><?php

                $name=$_SESSION['nameclient'];?>Solde de vos Comptes:

                <label style="padding-right: 30px;">GNF: <?=$configuration->formatNombre($caisse->soldeClientNp($name, "gnf")); ?></label><label style="background-color: white; color:white;">espa</label>

                <label style="margin-right: 10px;">€: <?=$configuration->formatNombre($caisse->soldeClientNp($name, "eu")); ?></label><label style="background-color: white; color:white;">espa</label>

                <label style="margin-right: 10px;">$: <?=$configuration->formatNombre($caisse->soldeClientNp($name, "us")); ?></label><label style="background-color: white; color:white;">espa</label>

                <!-- <label style="margin-right: 10px;">CFA: <?=$configuration->formatNombre($caisse->soldeClientNp($name, "cfa")); ?></label> -->
              </td>
            </tr>

            <tr>
              <td colspan="5" style="font-size:14px;"><?php

              if ($adress['nom_mag']=='ETS BBS (Beauty Boutique Sow)') {

                if($totqtite!=0){

                  echo "Carton(s) Acheté(s):".$totqtite." --- Livré(s): ".$totqtiteliv;
                }?><?php

                if($totqtitep!=0){

                  echo " Paquet(s) Acheté(s):".$totqtitep." --- Livré(s): ".$totqtitelivp;
                }?><?php

                if($totqtited!=0){

                  echo " Détail(s) Acheté(s):".$totqtited." --- Livré(s): ".$totqtitelivd;
                }
              }?>
                
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered table-striped table-hover align-middle">

          <thead>

            <tr>
              <td colspan="3" style="text-align:center; padding-top:3px;">Vos modes de paiements</td>
            </tr>

            <tr>
              <td style="text-align:center;">Espèces</td>
              <td style="text-align:center;">Chèque</td>
              <td style="text-align:center;">Versment Bancaire</td>
            </tr>
          </thead>

          <tbody>

            <tr>
              <td style="text-align: center;">
                <?php
                    if (!empty($panier->modep($Num_cmd, 'gnf')[0])) {?>

                      GNF: <?=$configuration->formatNombre($panier->modep($Num_cmd, 'gnf')[0]);?> <label style="background-color: white; color:white;">espa</label><?php 
                    }
                    if (!empty($panier->modep($Num_cmd, 'eu')[0])) {?>

                      €: <?=$configuration->formatNombre($panier->modep($Num_cmd, 'eu')[0]).'*'.$panier->modep($Num_cmd, 'eu', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                    }

                    if (!empty($panier->modep($Num_cmd, 'us')[0])) {?>
                      $: <?=$configuration->formatNombre($panier->modep($Num_cmd, 'us')[0]).'*'.$panier->modep($Num_cmd, 'us', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                    }

                    if (!empty($panier->modep($Num_cmd, 'cfa')[0])) {?>
                    CFA: <?=$configuration->formatNombre($panier->modep($Num_cmd, 'cfa')[0]).'*'.$panier->modep($Num_cmd, 'cfa', 1)[1];?><label style="background-color: white; color:white;">espa</label><?php 
                    }?>
              </td>

              <td><?php 

                if (!empty($panier->modep($Num_cmd, 'cheque')[0])) {?>
                  <?=$configuration->formatNombre($panier->modep($Num_cmd, 'cheque')[0]);?><?php 
                }?>
              </td>

              <td><?php

                if (!empty($panier->modep($Num_cmd, 'virement')[0])) {?>
                  <?=$configuration->formatNombre($panier->modep($Num_cmd, 'virement')[0]);?><?php 
                }?>
              </td>
            </tr>
            
          </tbody>
        </table><?php 
      }?>
    </div>
  </div>
</div>

<script>
function suivant(enCours, suivant, limite){
  if (enCours.value.length >= limite)
  document.term[suivant].focus();
}

function focus(){
document.getElementById('reccode').focus();
}

function alerteS(){
  return(confirm('Confirmer la suppression?'));
}

function alerteM(){
  return(confirm('Confirmer la modification'));
}

function alerteF(){
  return(confirm('Confirmer la femeture de la caisse'));
}
</script>

