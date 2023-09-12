<?php
require_once "lib/html2pdf.php";
ob_start(); ?>

<?php require '_header.php';?>

<style type="text/css">

body{
  margin: 0px;
  width: 100%;
  height:68%;
  padding:0px;}
  
  table {
    width: 100%;
    color: #717375;
    font-family: helvetica;
    line-height: 10mm;
    border-collapse: collapse;
  }
  
  .border th {
    border: 1px solid black;
    padding:5px;
    padding-top: 10px;
    font-weight: bold;
    font-size: 13px;
    height: 15px;
    color: black;
    background: white;
    text-align: center; }
  .border td {
    line-height: 15mm;
    padding:3px;
    border: 1px solid black;    
    font-size: 12px;
    color: black;
    background: white;
    text-align: left;}
  .footer{
    font-size: 18px;
    font-style: italic;
  }

</style>

<page backtop="10mm" backleft="5mm" backright="5mm" backbottom="10mm" footer="page;"><?php
    
    $adress = $DB->querys('SELECT * FROM adresse ');?>

    <div class="ticket">

    <table style="width: 100%; margin:auto; text-align: center;color: black; background: white;" >

        <tr>
        <th style="font-weight: bold; font-size: 12px; padding: 5px"><?php echo $adress['nom_mag']; ?></th>
        </tr>

        <tr><td style="font-size: 12px;"><?=$adress['type_mag']; ?></td></tr>

        <tr><td><?=($adress['adresse']); ?></td></tr><br />
    </table>
    </div><?php

    $_SESSION['banquerel']=$_GET['banque'];
    
    $zero=0;

    if (isset($_GET['devise'])) {
        $_SESSION['deviseselect']=$_GET['devise'];
        $products= $DB->query("SELECT *FROM banque WHERE id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' and devise='{$_SESSION['deviseselect']}' order by(date_versement) desc");
    }else{
        $products= $DB->query("SELECT *FROM banque WHERE id_banque='{$_SESSION['banquerel']}' and montant!='{$zero}' order by(date_versement) desc");
        $_SESSION['deviseselect']='gnf';
    }
    $montantdebits=0;
    $montantcredits=0;

    foreach ($products as $keyd=> $product ){

        if ($product->montant<0) {
        $montantdebits+=$product->montant;
        }else{
        $montantcredits+=$product->montant;
        } 
    }?>

  <table style="margin:auto; margin-top: 20px;" class="border">

    <thead>
        <tr>
            <th height="30" colspan="5">
                Relevé Bancaire <?=ucwords($panier->nomBanquefecth($_SESSION['banquerel']));?> Solde Compte <?=strtoupper($_SESSION['deviseselect']);?>: <?=number_format($montantcredits+$montantdebits,2,',',' ');?>                
            </th>
        </tr>

        <tr>
            <th>N°</th>
            <th>Date</th>
            <th>Commentaires</th>
            <th>Débiter</th>
            <th>Créditer</th>
        </tr>
    </thead>
    <tbody><?php

        $montantdebit=0;
        $montantcredit=0;      

        foreach ($products as $keyd=> $product ){?>

            <tr>
                <td style="text-align: center;"><?= $keyd+1; ?></td>
                <td><?=(new DateTime($product->date_versement))->format("d/m/Y"); ?></td>
                <td style='width:400px;'><?= ucwords(strtolower($product->libelles)); ?></td><?php 

                if ($product->montant<0) {
                    $montantdebit+=$product->montant;?>
                    <td style="text-align:right;"><?=number_format(-1*$product->montant,0,',',' ');?></td>
                    <td></td><?php
                }else{
                    $montantcredit+=$product->montant;?>
                    <td></td>
                    <td style="text-align:right;"><?=number_format($product->montant,0,',',' ');?></td><?php
                }?>            
            </tr><?php 
        }?> 
      
    </tbody>

    <tfoot>
        <tr>
          <th colspan="3">Totaux</th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format(-1*$montantdebit,0,',',' ');?></th>
          <th style="text-align: right; padding-right: 10px;"><?= number_format($montantcredit,0,',',' ');?></th>
          
        </tr>
    </tfoot>

  </table>    

</page>
<?php
  $content = ob_get_clean();
  try {
    $pdf = new HTML2PDF("p","A4","fr", true, "UTF-8" , 0);
    $pdf->pdf->SetAuthor('Amadou');
    $pdf->pdf->SetTitle(date("d/m/y"));
    $pdf->pdf->SetSubject('Création d\'un Portfolio');
    $pdf->pdf->SetKeywords('HTML2PDF, Synthese, PHP');
    $pdf->pdf->IncludeJS("print(true);");
    $pdf->writeHTML($content);
    $pdf->Output('COMPTE EDITE'.date("d/m/y").date("H:i:s").'.pdf');
    // $pdf->Output('Devis.pdf', 'D');    
  } catch (HTML2PDF_exception $e) {
    die($e);
  }
?>