<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  if ($_SESSION['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php
        require 'navpers.php'; ?>
        <div class="col-sm-12 col-md-10"><?php
          if (isset($_GET['deleteret'])) {

            $DB->delete("DELETE from decdepense where numdec='{$_GET['deleteret']}'");

            $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");

            $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

            <div class="alert alert-success">Suppression reussi!!</div><?php 
          }

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

            $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
          }
          

          if (isset($_POST['categorie'])) {
            $_SESSION['categoriedep']=$_POST['categorie'];
          }

          if (isset($_POST['magasin'])) {
            $_SESSION['magasindep']=$_POST['magasin'];
          }
          if (isset($_GET['ajoutdep']) or isset($_POST['categins']) or isset($_GET["categ"])) {?>

            <form class="form bg-light p-1" method="POST" action="decpersonnel.php">              
              <input class="form-control" type="hidden" name="categorie" value="4"/>
              <div class="row mb-1">
                <div class="col-sm-12 col-md-6">
                  <label class="form-label">Destinataire*</label> 
                  <select class="form-select" type="text" name="client">
                    <option></option><?php
                    foreach($panier->personnel() as $product){?>
                      <option value="<?=$product->id;?>"><?=$product->nom;?></option><?php
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-6">
                  <label for="periode" class="form-label">Période*</label>
                  <input class="form-control" type="date" name="periode" required="">
                </div>
              </div>
              <div class="row mb-1">
                <label class="form-label">Salaire Net Payé*</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="numberconvert" type="number"   name="montant" min="0" required="">
                </div>
                <div class="col-sm-12 col-md-4 bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="convertnumber"></div>
              </div>
              <div class="row mb-1">
                <label class="form-label">Avance sur Salaire</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="avnumberconvert" type="number"   name="avmontant" value="0" min="0">
                </div>
                <div class="col-sm-12 col-md-4 bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="avconvertnumber"></div>
              </div>
              <div class="row mb-1">
                <label class="form-label">Prime</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="prnumberconvert" type="number"   name="prmontant" min="0" value="0">
                </div>
                <div class="col-sm-12 col-md-4 bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="prconvertnumber"></div>
              </div>
              <div class="row mb-1">
                <label class="form-label">Prime</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="cotnumberconvert" type="number"   name="cotmontant" value="0" min="0">
                </div>
                <div class="col-sm-12 col-md-4 bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="cotconvertnumber"></div>
              </div>
              <div class="row mb-1">
                <div class="col-sm-12 col-md-3">
                  <label class="form-label">Compte à Prélever</label>
                  <select class="form-select"  name="compte" required="">
                    <option></option><?php
                    $type='Banque';

                    foreach($caisse->nomTypeCaisse() as $product){?>
                      <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-3">
                  <label for="devise" class="form-label">Devise*</label>
                  <select class="form-select" name="devise" required=""><?php 
                    foreach ($panier->monnaie as $valuem) {?>
                      <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-3">
                  <label for="modep" class="form-label">Mode de Payement*</label>
                  <select class="form-select" name="mode_payement" required="" ><?php 
                    foreach ($panier->modep as $value) {?>
                      <option value="<?=$value;?>"><?=$value;?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-3">
                  <input class="form-control" type="hidden" name="coment" value="paiement personnel" >
                  <label class="form-label">Date Op</label>
                  <input class="form-control" type="date" name="datedep">
                </div>
              </div>

              <button class="btn btn-primary" type="submit" name="valid" onclick="return alerteV();">Valider</button>
            </form><?php           
          }
          if (isset($_POST['valid'])){         

            if ($_POST['montant']<0){?>

              <div class="alert alert-warning">FORMAT INCORRECT</div><?php

            }elseif ($_POST['montant']>$panier->montantCompteBilEspeces($_POST['compte'], $_POST['devise'])) {?>

              <div class="alert alert-warning">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }else{                         

              if (!empty($_POST['client']) and !empty($_POST['categorie']) and !empty($_POST['compte'])) {

                $numdec = $DB->querys('SELECT max(id) AS id FROM decdepense ');
                $numdec=$numdec['id']+1;

                $categorie=$_POST['categorie'];
                $personnel=$panier->h($_POST['client']);
                $periode=$panier->h($_POST['periode']);
                $montant=$panier->h($_POST['montant']);
                $montantav=$panier->h($_POST['avmontant']);
                $montantpr=$panier->h($_POST['prmontant']);
                $montantcot=$panier->h($_POST['cotmontant']);
                $devise=$panier->h($_POST['devise']);
                $motif=$panier->h($_POST['coment']);
                $payement=$_POST['mode_payement'];
                $compte=$panier->h($_POST['compte']);
                $dateop=$panier->h($_POST['datedep']);
                $lieuventeret=$panier->lieuVenteCaisse($compte)[0];  
                if (empty($dateop)) {
                  $dateop=date("Y-m-d H:i");
                }else{
                    $dateop=$dateop;
                } 
                $DB->insert('INSERT INTO decdepense (numdec, client, periodep, categorie, montant, montantav, montantpr, montantcot, devisedep, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',array('retd'.$numdec, $personnel, $periode, $categorie, $montant, $montantav, $montantpr, $montantcot, $devise, $payement, $motif, $compte, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO banque (id_banque,clientbanque, montant, libelles, numero, devise, lieuvente,typeent,origine, date_versement) VALUES(?, ?,?,?,?, ?, ?, ?, ?, ?)', array($compte,"pers".$personnel, -$montant, $motif, 'retd'.$numdec, $devise, $lieuventeret,"salaire","personnel", $dateop)); ?>
                <div class="alert alert-success">Retrait enregistré avec succèe!!</div><?php
              } else{?>
                <div class="alert alert-warning">Saisissez tous les champs vides</div><?php
              }
            }
          }

          if (!isset($_GET['ajoutdep'])) {?>

            <table class="table table-bordered table-hover table-striped">
              <thead class="sticky-top text-center bg-light">
                <tr><th colspan="12"><?="Liste des salaires payés " .$datenormale ?> <a class="btn btn-warning" href="decpersonnel.php?ajoutdep">Enregistrer un salaire</a></th></tr>

                <tr>
                  <form method="POST" class="form">
                    <th colspan="11" >
                      <div class="row">
                        <div class="col-6"><?php
                          if (isset($_POST['j1'])) {?>

                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_SESSION['date01'];?>"><?php

                          }else{?>

                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php

                          }?>
                        </div>
                        <div class="col-6"><?php
                          if (isset($_POST['j2']) ) {?>

                            <input class="form-control" type = "date" name = "j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()"><?php

                          }else{?>

                            <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php

                          }?>
                        </div>
                      </div>
                    </th>
                  </form>                 
                </tr>

                <tr>
                  <th>N°</th>
                  <th></th>
                  <th>Mois</th>
                  <th>Bénéficiaire</th>                  
                  <th>Salaire Net</th>
                  <th>Avnace sur Salaire</th>
                  <th>Prime</th>
                  <th>Cotisation Sociale</th>
                  <th>Mode de Paie</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>

              </thead>

              <tbody><?php 
              $categorie=4;

                if (isset($_POST['j1'])) {    

                  $products= $DB->query("SELECT *FROM decdepense WHERE DATE_FORMAT(date_payement, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")<='{$_SESSION['date2']}' and categorie='{$categorie}' order by(id) desc");

                }else{

                  $products= $DB->query("SELECT *FROM decdepense WHERE categorie='{$categorie}' order by(id) desc");              
                }

                $montantgnf=0;
                $montantgnfav=0;
                $montantgnfpr=0;
                $montantgnfcot=0;

                foreach ($products as $keyv=> $product ){

                  $montantgnf+=$product->montant;
                  $montantgnfav+=$product->montantav;
                  $montantgnfpr+=$product->montantpr;
                  $montantgnfcot+=$product->montantcot;

                  $moispaye=(new dateTime($product->periodep))->format("m");?>

                  <tr>
                    <td class="text-center"><?= $keyv+1; ?></td>

                    <td class="text-center"><a href="printfichedepaye.php?numdec=<?=$product->id;?>&idc=<?=$product->client;?>&mois=<?=$moispaye;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a></td>

                    <td class="text-center"><?=$panier->obtenirLibelleMois($moispaye);?></td>

                    <td class="text-center"><?=$panier->nomPersonnel($product->client);?></td>

                    <td class="text-end"><?= number_format($product->montant,0,',',' '); ?></td>

                    <td class="text-end"><?= number_format($product->montantav,0,',',' '); ?></td>

                    <td class="text-end"><?= number_format($product->montantpr,0,',',' '); ?></td>

                    <td class="text-end"><?= number_format($product->montantcot,0,',',' '); ?></td>

                    <td><?=$product->payement; ?></td>

                    <td style="text-align:center;"><?=(new DateTime($product->date_payement))->format("d/m/Y"); ?></td>                   
                    <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-danger" onclick="return alerteS();" href="decpersonnel.php?deleteret=<?=$product->numdec;?>">Annuler</a><?php };?></td>
                        
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                <tr>
                  <th colspan="4">Totaux</th>
                  <th class="text-end"><?= number_format($montantgnf,0,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantgnfav,0,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantgnfpr,0,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantgnfcot,0,',',' ');?></th>
                </tr>
              </tfoot>

            </table><?php
          }

        }else{
          echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
        }

}else{


}?>   
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



<script>
  $(document).ready(function(){
      $('#numberconvert').keyup(function(){
          $('#convertnumber').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'convertnumber.php?convertdec',
                  data: 'user=' + encodeURIComponent(utilisateur),
                  success: function(data){
                      if(data != ""){
                        $('#convertnumber').append(data);
                      }else{
                        document.getElementById('convertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                      }
                  }
              })
          }
    
      });
  });
</script>

<script>
  $(document).ready(function(){
      $('#avnumberconvert').keyup(function(){
          $('#avconvertnumber').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'convertnumber.php?convertdec',
                  data: 'user=' + encodeURIComponent(utilisateur),
                  success: function(data){
                      if(data != ""){
                        $('#avconvertnumber').append(data);
                      }else{
                        document.getElementById('avconvertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                      }
                  }
              })
          }
    
      });
  });
</script>

<script>
  $(document).ready(function(){
      $('#prnumberconvert').keyup(function(){
          $('#prconvertnumber').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'convertnumber.php?convertdec',
                  data: 'user=' + encodeURIComponent(utilisateur),
                  success: function(data){
                      if(data != ""){
                        $('#prconvertnumber').append(data);
                      }else{
                        document.getElementById('prconvertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                      }
                  }
              })
          }
    
      });
  });
</script>

<script>
  $(document).ready(function(){
      $('#cotnumberconvert').keyup(function(){
          $('#cotconvertnumber').html("");

          var utilisateur = $(this).val();

          if (utilisateur!='') {
              $.ajax({
                  type: 'GET',
                  url: 'convertnumber.php?convertdec',
                  data: 'user=' + encodeURIComponent(utilisateur),
                  success: function(data){
                      if(data != ""){
                        $('#cotconvertnumber').append(data);
                      }else{
                        document.getElementById('cotconvertnumber').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
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

  function alerteV(){
      return(confirm('Confirmer la validation'));
  }

  function focus(){
      document.getElementById('pointeur').focus();
  }

</script>

