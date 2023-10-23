<?php
require 'headerv2.php';
if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];?>

  <div class="container-fluid">

    <div class="row"><?php
      require 'navbanque.php';?>

      <div class="col-sm-12 col-md-10"><?php

        if (isset($_GET['deleteret'])) {

          $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");

          $DB->delete("DELETE from transferfond where numero='{$_GET['deleteret']}'");?>

          <div class="alert alert-success">Transfert des fonds annulés avec succèe!!</div><?php 
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

          $datenormale=(new DateTime($dates))->format('d/m/Y');
        }

        if (isset($_POST['clientliv'])) {
          $_SESSION['clientliv']=$_POST['clientliv'];
        }

        if ($_SESSION['level']>=3) {

          if (isset($_POST['valid'])) {

            $montant=$_POST['montant'];
            $compteret=$_POST['compteret'];
            $comptedep=$_POST['comptedep'];
            $compte_op=$panier->h($_POST['compte_op']);
            $compte_op_nom=$panier->h($caisse->compteById($_POST['compte_op'])['nom_compte']);
            $devise=$_POST['devise'];
            $coment=$_POST['coment'];
            $dateop=$_POST['dateop'];
            if (empty($dateop)) {
              $dateop=date("Y-m-d H:i");
            }else{
                $dateop=$dateop;
            }

            $lieuventeret=$panier->lieuVenteCaisse($compteret)[0];

            $lieuventedep=$panier->lieuVenteCaisse($comptedep)[0];

            if($compteret=='autresret') {
              $lieuventeret=$panier->lieuVenteCaisse($comptedep)[0];
            } 

            $numdec = $DB->querys('SELECT max(id) AS id FROM banque ');
            $numdec=$numdec['id']+1;

            if ($compteret!='autresret') {

              $DB->insert('INSERT INTO banque (id_banque, clientbanque, origine, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['compteret'],"","transfert", $compte_op_nom, -$montant, $devise, 'transfert des fonds', $numdec, $lieuventeret, $dateop));
            }

            if ($compteret!='autresdep') {

              $DB->insert('INSERT INTO banque (id_banque, clientbanque, origine, typeent, montant, devise, libelles, numero, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($_POST['comptedep'],"","transfert", $compte_op_nom, $montant, $devise, 'transfert des fonds', $numdec, $lieuventedep, $dateop));
            }

            $DB->insert('INSERT INTO transferfond (numero, caissedep, montant, caisseret, devise, exect, compte_op, lieuvente, coment, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $_POST['comptedep'], $montant, $_POST['compteret'], $devise, $_SESSION['idpseudo'], $compte_op, $lieuventeret, $coment, $dateop));
            unset($_GET);
            unset($_POST); 
          }

          if (isset($_GET['ajout']) or isset($_GET['searchclient']) ) {?>

            <form class="form mt-2" method="POST" action="banque.php">

              <fieldset><legend>Enregistrer un transfert des fonds  <a class="btn btn-warning" href="banque.php">Retour à la liste des transferts</a></legend>


                <div class="mb-2 d-flex">
                  <div class="">
                    <label for="compte" class="form-label">Compte Op*</label>
                    <select class="form-select" name="compte_op" required="" >
                      <option value=""></option><?php 
                      foreach ($caisse->compteAll() as $valuec) {?>
                        <option value="<?=$valuec->id;?>"><?=ucfirst($valuec->nom_compte);?></option><?php 
                      }?>
                    </select>
                  </div>
                  <div class="row mx-2">
                    <label class="form-label" for="montant">Montant*</label>
                    <div class="col-sm-12 col-md-6">
                      <input class="form-control" id="numberconvert" type="number"   name="montant" min="0" required="">
                    </div>

                    <div class="col-sm-12 col-md-6 bg-success text-white fw-bold py-2 fs-6" id="convertnumber"></div>
                  </div>
                </div>

                  <div class="mb-1"><label class="form-label">Compte de Retraît*</label>
                     <select class="form-select"  name="compteret" required="">
                      <option></option><?php
                      $type='Banque';

                      foreach($caisse->nomTypeCaisse() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }
  
                      foreach($caisse->listBanque() as $product){?>
  
                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }?>
                      <option value="autresret">Autres</option>
                    </select>
                  </div>

                  <div class="mb-1"><label class="form-label">Compte de Dépôt*</label>
                     <select class="form-select"  name="comptedep" required="">
                      <option></option><?php
                      $type='Banque';

                      foreach($caisse->nomTypeCaisse() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }
  
                      foreach($caisse->listBanque() as $product){?>
  
                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }?>

                      <option value="autresdep">Autres</option>
                    </select>
                  </div>

                  <div class="mb-1"><label class="form-label">Devise*</label>
                    <select class="form-select" name="devise" required="" >
                      <option value=""></option><?php 
                      foreach ($panier->monnaie as $valuem) {?>
                          <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                      }?>
                    </select>
                  </div>

                  <div class="mb-1"><label class="form-label">Commentaires*</label><input class="form-control" type="text" name="coment" required=""></li>

                  <div class="mb-1"><label class="form-label">Date</label><input class="form-control" type="date" name="dateop"></li>
                </ol>
              </fieldset>

              <fieldset><?php

                if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                  <button class="btn btn-primary" type="submit" name="valid" onclick="return alerteV();">Valider</button><?php

                }else{?>

                  <div class="alert alert-danger"> CAISSE CLOTUREE OU LA LICENCE EST EXPIREE </div><?php

                }?> 
              </fieldset>       
            </form> <?php
          }  

          if (!isset($_GET['ajout'])) {?> 

            <table class="table table-hover table-bordered table-striped table-responsive text-center">


              <thead>
                <tr><th colspan="9"><?="Liste des Transferts des fonts " .$datenormale ?> <a class="btn btn-warning" href="banque.php?ajout">Effectuer un transfert des fonds</a></th></tr>
                <tr>
                  
                  <th colspan="9">
                    <div class="row">
                      <div class="col-sm-12 col-md-8">
                        <form class="form" method="POST" action="banque.php">
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

                                <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                              }else{?>

                                <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php

                              }?>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-sm-12 col-md-4">
                        <form class="form" method="POST" action="banque.php">

                          <select class="form-select" name="clientliv" onchange="this.form.submit()" style="width: 300px;"><?php

                            if (isset($_POST['clientliv'])) {?>

                              <option value="<?=$_POST['clientliv'];?>"><?=ucwords($panier->nomBanquefecth($_POST['clientliv']));?></option><?php

                            }else{?>
                              <option></option><?php
                            }

                            foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                            }

                            foreach($panier->nomBanqueVire() as $product){?>

                              <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                            }?>
                          </select>
                        </form>
                      </div>
                    </div>
                  </th>
                </tr>
                
                <tr>
                  <th>N°</th>
                  <th>Date</th>
                  <th>Commenataires</th>
                  <th>Désignation</th>
                  <th>Montant GNF</th>
                  <th>Montant $</th>
                  <th>Montant €</th>
                  <th>Montant CFA</th>
                  <th></th>              
                </tr>

              </thead>

              <tbody><?php 
                $typeent='transfert';

                if (isset($_POST['j1'])) {            

                  $products= $DB->query("SELECT * FROM transferfond WHERE  lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(dateop, \"%Y%m%d\")>= '{$_SESSION['date1']}' and DATE_FORMAT(dateop, \"%Y%m%d\")<= '{$_SESSION['date2']}' order by(dateop) LIMIT 50");

                }elseif (isset($_POST['clientliv'])) {
                  $banque=$_POST['clientliv'];
                  $products= $DB->query("SELECT *FROM transferfond WHERE lieuvente='{$_SESSION['lieuvente']}' and caissedep='{$banque}' order by(dateop) LIMIT 50");

                }else{
                  $annee=date('Y');

                  if ($_SESSION['level']>6) {
                    $products= $DB->query("SELECT *FROM transferfond  WHERE  YEAR(dateop) = '{$annee}' order by(dateop) LIMIT 50");
                  }else{
                    $products= $DB->query("SELECT *FROM transferfond  WHERE lieuvente='{$_SESSION['lieuvente']}' order by(dateop) desc ");
                  }
                  
                }

                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                $virement=0;
                $cheque=0;
                foreach ($products as $keyv=> $product ){

                  if ($product->caissedep=='autresdep') {
                    $caissedep='autres';
                  }else{
                    $caissedep=$panier->nomBanquefecth($product->caissedep);
                  }

                  if ($product->caisseret=='autresret') {
                    $caisseret='autres';
                  }else{
                    $caisseret=$panier->nomBanquefecth($product->caisseret);
                  } ?>

                  <tr>
                    <td><?= $keyv+1; ?></td>
                    <td><?=$panier->formatDate($product->dateop); ?></td>
                    <td><?=$product->coment;?></td>
                    <td>Transfert des fonds <?=$caisseret;?> --> <?=$caissedep;?></td><?php

                    if ($product->devise=='gnf') {

                        $montantgnf+=$product->montant;?>

                        <td class="text-end"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td>
                        <td></td><?php

                      }elseif ($product->devise=='us') {
                        $montantus+=$product->montant;?>

                        <td></td>
                        <td class="text-end"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td>
                        <td></td><?php
                      }elseif ($product->devise=='eu') {
                        $montanteu+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td class="text-end"><?= number_format($product->montant,0,',',' '); ?></td>
                        <td></td><?php
                      }elseif ($product->devise=='cfa') {
                        $montantcfa+=$product->montant;?>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-end"><?= number_format($product->montant,0,',',' '); ?></td><?php

                      }?>

                      <td><a class="btn btn-danger" onclick="return alerteS();" href="banque.php?deleteret=<?=$product->numero;?>">Annuler</a></td>
                      
                    </tr><?php 
                }?>

              </tbody>

            </table> <?php
          }

        }else{

          echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

        }?>
      </div>
    </div>
  </div><?php

}else{

}?>

<?php require 'footer.php';?>
    
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
                    url: 'convertnumber.php?convert',
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
