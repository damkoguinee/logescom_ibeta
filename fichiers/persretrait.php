<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  if ($_SESSION['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php 
        require 'navpers.php';?>
        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
          if (isset($_GET['deleteret'])) {
            $retpb=$_GET['deleteret'];
            $retpba=$_GET['deleteret'];

            $DB->delete("DELETE from decpersonnel where numdec='{$_GET['deleteret']}'");

            $DB->delete("DELETE from bulletin where numero='{$retpb}'");

            $DB->delete("DELETE from banque where numero='{$retpba}'");?>

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

          if (isset($_GET['searchclientvers']) ) {

            $_SESSION['searchclientvers']=$_GET['searchclientvers'];
          }else{
            $_SESSION['searchclientvers']=0;
          } 

          if (isset($_GET['ajoutdep']) or isset($_POST['categins']) or isset($_GET["categ"])) {

            if ($panier->compteClient("pers".$_SESSION['searchclientvers'], "gnf")>0) {
              $color='warning';
              $credit=0;
            }else{
              $color="success";
              $credit=-$panier->compteClient("pers".$_SESSION['searchclientvers'], "gnf");
            }?>

            <form class="form bg-light p-1" method="POST" action="persretrait.php" >
              <input class="form-control" type="hidden" name="categorie" value="4"/>
              <div class="mb-1">
                <label class="form-label">Personnel*</label>
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <select class="form-select" type="text" name="client"><?php 
                      if (!empty($_SESSION['searchclientvers'])) {?>
                        <option value="<?=$_SESSION['searchclientvers'];?>"><?=$panier->nomPersonnelId($_SESSION['searchclientvers']);?></option><?php
                      }else{?>
                        <option></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <input class="form-control" id="search-user" type="text" name="clients" placeholder="rechercher un collaborateur" />
                    <div class="bg-danger text-white" id="result-search"></div>
                  </div>
                </div>
                <div class="text-white bg-<?=$color;?>">Solde Compte: <?=number_format($panier->compteClient($_SESSION['searchclientvers'], 'gnf'),0,',',' '); ?></div>
              </div>
              <div class="row my-2">
                <label class="form-label">Montant*</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" id="numberconvert" type="number" name="montant" min="0" required="">
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="bg-success py-1 mx-2 text-center text-white fw-bold fs-4 " id="convertnumber"></div>
                </div>
              </div>
              <div class="row mb-1">
                <div class="col-sm-12 col-md-4">
                  <label class="form-label">Compte à Prélever</label>
                  <select class="form-select"  name="compte" required=""><?php
                    foreach($caisse->nomTypeCaisse() as $product){?>
                      <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-4">
                  <label for="" class="form-label">Devise*</label>
                  <select class="form-select" name="devise" required=""><?php 
                    foreach ($panier->monnaie as $valuem) {?>
                        <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-sm-12 col-md-4">
                  <label for="" class="form-label">Mode de Payement*</label>
                  <select class="form-select" name="mode_payement" required="" ><?php 
                    foreach ($panier->modep as $value) {?>
                      <option value="<?=$value;?>"><?=$value;?></option><?php 
                    }?>
                  </select>
                </div>
              </div> 
              <div class="row my-2">
                <div class="col-sm-12 col-md-4"> 
                  <label class="form-label">Commentaires</label>
                  <input class="form-control" type="text" name="coment">
                </div>
                <div class="col-sm-12 col-md-4">
                  <label class="form-label">Date Op</label><input class="form-control" type="date" name="datedep" max="<?=$panier->datemax(0)[0];?>" >
                </div>
              </div>                        

              <button class="btn btn-primary" id="form"  type="submit" name="valid" onclick="return alerteV();">Valider</button>
            </form><?php 
            
          }
          if (isset($_POST['valid'])){ 
            if ($_POST['montant']<0){?>
              <div class="alert alert-warning">FORMAT INCORRECT</div><?php
            }else{ 
              if (!empty($_POST['client']) and !empty($_POST['categorie']) and !empty($_POST['compte'])) {

                $numdec = $DB->querys('SELECT max(id) AS id FROM decpersonnel ');
                $numdec=$numdec['id']+1;
                $personnel=$panier->h($_POST['client']);
                $montant=$panier->h($_POST['montant']);
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
                $DB->insert('INSERT INTO decpersonnel (numdec, client, montant, devise, payement, coment, cprelever, lieuvente, date_payement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)',array('bonp'.$numdec, $personnel, $montant, $devise, $payement, $motif, $compte, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO banque (id_banque,clientbanque,montant, libelles, numero, devise, lieuvente,typeent,origine, date_versement) VALUES(?,?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,$personnel, -$montant, $motif, 'bonp'.$numdec, $devise, $lieuventeret,"bon","personnel", $dateop));
                
                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, type, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($personnel, -$montant, "bon", 'bonp'.$numdec, $devise, $compte, $lieuventeret,"personnel", $dateop));?>

                <div class="alert alert-success">Bon enregistré avec succèe!!</div><?php

              }else{?>

                <div class="alert alert-warning">Saisissez tous les champs vides</div><?php

              }
            }
          }


          if (!isset($_GET['ajoutdep'])) {?>

            <table class="table table-hover table-bordered table-striped table-responsive text-center">
              <thead>
                <tr><th class="legende" colspan="6"><?="Liste des Bons payés " .$datenormale ?> <a href="persretrait.php?ajoutdep" class="btn btn-info">Enregistrer un Bon</a></th></tr>

                <tr>
                  <form class="form" method="POST" action="persretrait.php" id="suitec" name="termc">

                    <th colspan="6" >
                      <div class="container-fluid">

                        <div class="row">
                          <div class="col-sm-12 col-md-4"><?php 
                              if (isset($_POST['j1'])) {?>
                                  <input class="form-control" class="form-control" type="date" name="j1" value="<?=$_SESSION['date01'];?>" onchange="this.form.submit()" ><?php 
                              }else{?>
                                  <input class="form-control" class="form-control" type="date" name="j1" onchange="this.form.submit()" ><?php
                              }?>
                          </div>
                          <div class="col-sm-12 col-md-4"><?php 
                              if (isset($_POST['j1'])) {?>
                                  <input class="form-control" class="form-control" type="date" name="j2" value="<?=$_SESSION['date02'];?>" onchange="this.form.submit()" ><?php 
                              }else{?>
                                  <input class="form-control" class="form-control" type="date" name="j2" onchange="this.form.submit()" ><?php
                              }?>
                          </div>
                        </div>
                      </div>

                    </th>
                  </form>                 
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Bénéficiaire</th>                  
                  <th>Montant</th>
                  <th>Type de Paie</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>

              </thead>
              <tbody><?php 
                $categorie=4;

                if (isset($_POST['j1'])) {    

                  $products= $DB->query("SELECT *FROM decpersonnel WHERE DATE_FORMAT(date_payement, \"%Y%m%d\")>='{$_SESSION['date1']}' and DATE_FORMAT(date_payement, \"%Y%m%d\")<='{$_SESSION['date2']}' order by(id) desc");

                }else{

                  $products= $DB->query("SELECT *FROM decpersonnel where lieuvente='{$_SESSION['lieuvente']}' order by(id) desc");              
                }

                $montantgnf=0;
                $montantgnfav=0;
                $montantgnfpr=0;
                $montantgnfcot=0;

                foreach ($products as $keyv=> $product ){

                  $montantgnf+=$product->montant;?>

                  <tr>
                    <td style="text-align: center;"><?= $keyv+1; ?></td>

                    <td style="text-align: center"><?=$panier->nomPersonnelId($product->client);?></td>

                    <td style="text-align: right; padding-right: 10px;"><?= number_format($product->montant,0,',',' '); ?></td>

                    <td><?=$product->payement; ?></td>

                    <td style="text-align:center;"><?=(new DateTime($product->date_payement))->format("d/m/Y"); ?></td>                   
                    <td><?php if ($_SESSION['level']>=6){?><a class="btn btn-danger" href="persretrait.php?deleteret=<?=$product->numdec;?>" onclick="return alerteS();">Supprimer</a><?php };?></td>
                        
                  </tr><?php 
                }?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2">Totaux</th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($montantgnf,0,',',' ');?></th>
                </tr>
              </tfoot>

            </table><?php
          }?>
        </div>
      </div>
    </div><?php

  }else{
    echo "VOUS N'AVEZ PAS TOUTES LES AUTORISATIOS REQUISES";
  }

}?>   
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
      $(document).ready(function(){
          $('#search-user').keyup(function(){
              $('#result-search').html("");

              var utilisateur = $(this).val();

              if (utilisateur!='') {
                  $.ajax({
                      type: 'GET',
                      url: 'recherche_utilisateur.php?persretrait',
                      data: 'user=' + encodeURIComponent(utilisateur),
                      success: function(data){
                          if(data != ""){
                            $('#result-search').append(data);
                          }else{
                            document.getElementById('result-search').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                          }
                      }
                  })
              }
        
          });
      });
  </script>



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

