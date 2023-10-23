<?php require 'headerv2.php';?>
<div class="container-fluid">

  <div class="row"><?php
    require 'navstock.php';?>

    <div class="col-sm-12 col-md-10"><?php

    if (isset($_SESSION['pseudo'])) {
      $pseudo=$_SESSION['pseudo'];
  

      if ($products['level']>=3) {

      if (isset($_GET['deletevers'])) {

        $numero=$_GET['deletevers'];
        $depart=$_GET['depart'];
        $recep=$_GET['recep'];
        $nomtabdep=$panier->nomStock($depart)[1];
        $nomtabrecep=$panier->nomStock($recep)[1];
        $qtitesup=$_GET['qtite'];
        $dateop=$_GET['dateop'];

        $qtiteinit=$DB->querys("SELECT quantite FROM `".$nomtabdep."` WHERE idprod=?", array($numero));

        $qtiteaug=$qtiteinit['quantite']+$qtitesup;

        $DB->insert("UPDATE `".$nomtabdep."` SET quantite = ? WHERE idprod= ?", array($qtiteaug, $numero));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($numero, 'annul trans', 'entree', $qtitesup, $depart));

        $qtiteinit=$DB->querys("SELECT quantite FROM `".$nomtabrecep."` WHERE idprod=?", array($numero));

        $qtiteaug=$qtiteinit['quantite']-$qtitesup;

        $DB->insert("UPDATE `".$nomtabrecep."` SET quantite = ? WHERE idprod= ?", array($qtiteaug, $numero));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, dateop) VALUES(?, ?, ?, ?, ?, now())', array($numero, 'annul trans', 'sortie', -$qtitesup, $recep));


        $DB->delete('DELETE FROM transferprod WHERE idprod = ? and stockdep=? and stockrecep=? and dateop=?', array($numero, $depart, $recep, $dateop));?>

          <div class="alert alert-success">Le transfert a été bien annulé</div><?php
      }

      if (!isset($_POST['clientliv'])) {

        if (!isset($_POST['j1'])) {

          $_SESSION['date']=date("Ymd");  
          $dates = $_SESSION['date'];
          $dates = new DateTime( $dates );
          $dates = $dates->format('Ymd'); 
          $_SESSION['date']=$dates;
          $_SESSION['date1']=$dates;
          $_SESSION['date2']=$dates;
          $_SESSION['dates1']=$dates; 

        }else{

          $_SESSION['date01']=$_POST['j1'];
          $_SESSION['date1'] = new DateTime($_SESSION['date01']);
          $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
          
          $_SESSION['date02']=$_POST['j2'];
          $_SESSION['date2'] = new DateTime($_SESSION['date02']);
          $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

          $_SESSION['dates1']=(new DateTime($_SESSION['date01']))->format('d/m/Y');
          $_SESSION['dates2']=(new DateTime($_SESSION['date02']))->format('d/m/Y');  
        }
    

        if (isset($_POST['j2'])) {

          $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

        }else{

          $datenormale=(new DateTime($dates))->format('d/m/Y');
        }
      }

      if (isset($_POST['clientliv'])) {
        $_SESSION['clientliv']=$_POST['clientliv'];
        $datenormale='';
      }?>
 

      <table class="table table-hover table-bordered table-striped table-responsive text-center">
        <thead>
          <tr>
            <th colspan="8" >
              <div class="row">
                <div class="col-sm-12 col-md-4">                
                  <form class="form" method="POST" action="transfertprod.php" id="suitec" name="termc">

                  
                    <div class="row">
                      <div class="col-sm-12 col-md-6"><?php
                        if (isset($_POST['j1'])) {?>

                          <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                        }else{?>

                          <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php

                        }?>
                      </div>
                      <div class="col-sm-12 col-md-6"><?php
                        if (isset($_POST['j2'])) {?>

                          <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()" value="<?=$_POST['j2'];?>"><?php

                        }else{?>

                          <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php

                        }?>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-sm-12 col-md-4">
                  <form method="POST" action="transfertprod.php">

                    <select class="form-select" name="clientliv" onchange="this.form.submit()"><?php

                      if (isset($_POST['clientliv'])) {?>

                        <option value="<?=$_POST['clientliv'];?>"><?=ucwords($panier->nomStock($_POST['clientliv'])[0]);?></option><?php

                      }else{?>
                        <option></option><?php
                      }

                      foreach($panier->listeStock() as $product){?>

                        <option value="<?=$product->id;?>"><?=ucwords($product->nomstock);?></option><?php
                      }?>
                    </select>
                  </form>
                </div>
                <div class="col-sm-12 col-md-4">
                  <?="Liste des transferts " .$datenormale ?>
                </div>
              </div>
            </tr>

          <tr>
            <th>N°</th>
            <th>Date</th>
            <th>Désignation</th>
            <th>Départ</th>
            <th>Qtité Trans</th>
            <th>Arrivée</th>
            <th>Personnel</th>
            <th></th>
          </tr>

      </thead>

      <tbody><?php
       
        $cumulmontant=0;
        if (isset($_POST['j1'])) {

          $products= $DB->query("SELECT *FROM transferprod WHERE DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' order by(dateop) LIMIT 50");

        }elseif (isset($_POST['clientliv'])) {

          $products= $DB->query("SELECT *FROM transferprod WHERE stockdep='{$_POST['clientliv']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<='{$_SESSION['date2']}' order by(dateop) LIMIT 50");

        }else{
          $datencours=date('Y');

          $products= $DB->query("SELECT *FROM transferprod order by(dateop)");
        }

    
      $qtitetot=0;
      foreach ($products as $keyd=> $product ){

        $qtitetot+=$product->quantitemouv;?>

        <tr>
          <td class="text-center"><?= $keyd+1; ?></td>
          <td class="text-center"><?= $panier->formatDate($product->dateop); ?></td>
          <td><?=$panier->nomProduit($product->idprod); ?></td>
          <td><?=$panier->nomStock($product->stockdep)[0]; ?></td>
          <td class="text-center"><?=$product->quantitemouv; ?></td>
          <td><?=$panier->nomStock($product->stockrecep)[0]; ?></td>
          <td><?=$panier->nomPersonnel($product->exect); ?></td>

          <td><a class="btn btn-danger" onclick="return alerteS();" href="transfertprod.php?deletevers=<?=$product->idprod;?>&dateop=<?=$product->dateop;?>&qtite=<?=$product->quantitemouv;?>&depart=<?=$product->stockdep;?>&recep=<?=$product->stockrecep;?>">Annuler</a></td>
        </tr><?php 
      }?>

          

    </tbody>

    <tfoot>
      <tr>
        <th colspan="4">Totaux</th>
        <th style="text-align: center;"><?=$qtitetot;?></th>
      </tr>
    </tfoot>

  </table><?php
      

    }else{

      echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

    }

  }else{

  }?>

<?php require 'footer.php';?>
    
</body>

</html>

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
