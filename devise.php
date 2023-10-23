<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {
  $pseudo=$_SESSION['pseudo'];
  if (!isset($_POST['taux'])) {
    if (isset($_GET['vente'])) {
      $_SESSION['motifdev']='vente devise';
    }else{
      $_SESSION['motifdev']='achat devise';
    }
  }
  

  if ($products['level']>=3) {?>
    <div class="container-fluid">
      <div class="row"><?php 
        require 'navdevise.php';?>
        <div class="col-sm-12 col-md-10"><?php
          if (isset($_GET['deletevers'])) {

            $numero=$_GET['deletevers'];
            $DB->delete('DELETE FROM devisevente WHERE numcmd = ?', array($numero));

            $DB->delete('DELETE FROM bulletin WHERE numero = ?', array($numero));

            $DB->delete('DELETE FROM banque WHERE numero = ?', array($numero));?>

            <div class="alert amert-success">L'opération à bien été annulée</div><?php
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

          if (isset($_POST["validevise"])) {
            if (empty($_POST["client"]) OR empty($_POST["montant"]) or empty($_POST['devise']) OR empty($_POST["motif"])) {?>
              <div class="alert alert-warning">Les Champs sont vides</div><?php
            }else{
              $montant=$panier->espace($panier->h($_POST['montant']));
              $devise=$panier->h($_POST['devise']);
              $client=$panier->h($_POST['client']);
              $motif=$panier->h($_POST['motif']);
              $payement=$_POST['mode_payement'];
              $compte=$panier->h($_POST['compte']);
              $compte_op=$panier->h($_POST['compte_op']);
              $compte_op_nom=$panier->h($caisse->compteById($_POST['compte_op'])['nom_compte']);
              $taux=$panier->espace($panier->h($_POST['taux']));
              $convert=$montant*$taux;
              $maximum = $DB->querys('SELECT max(id) AS max_id FROM devisevente');
              $max=$maximum['max_id']+1;
              $dateop=$_POST['datedep'];
              if (empty($dateop)) {
                $dateop=date("Y-m-d h:i");
              }else{
                $dateop=$dateop;
              }  
              if ($motif=='achat devise') {
  
                if (($convert)>$panier->montantCompteBil($compte, 'gnf')) {?>
  
                  <div class="alert alert-warning">Echec Montant à décaisser est insuffisant</div><?php
  
                }else{
  
                  $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, compte_op, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array('devisea'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente'], $compte_op, $_SESSION['lieuvente'], $dateop));                      
  
                  $DB->insert('INSERT INTO banque (id_banque,typeent,origine, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,'echange',$compte_op_nom, $montant, $client, 'devisea'.$max, $devise, $_SESSION['lieuvente'], $dateop));
  
                  $DB->insert('INSERT INTO banque (id_banque,typeent,origine, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,'echange',$compte_op_nom, -$convert, $client, 'devisea'.$max, 'gnf', $_SESSION['lieuvente'], $dateop));?>
                  <div class="alert alert-success">Opération éffectuée avec succèe!!!</div><?php
                }
  
              }else{
  
                if (($montant)>$panier->montantCompteBil($compte, $devise)) {?>
  
                  <div class="alert alert-warning">Echec Montant à décaisser est insuffisant</div><?php
  
                }else{
  
                  $DB->insert('INSERT INTO devisevente (numcmd, client, montant, devise, taux, motif, typep, compte, lieuvente, compte_op, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array('devisev'.$max, $client, $montant, $devise, $taux, $motif, $payement, $compte, $_SESSION['lieuvente'], $compte_op, $_SESSION['lieuvente'], $dateop));                      
  
                  $DB->insert('INSERT INTO banque (id_banque,typeent,origine, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,'echange',$compte_op_nom, -$montant, $client, 'devisev'.$max, $devise, $_SESSION['lieuvente'], $dateop));
  
                  $DB->insert('INSERT INTO banque (id_banque,typeent,origine, montant, libelles, numero, devise, lieuvente, date_versement) VALUES(?,?,?, ?, ?, ?, ?, ?, ?)', array($compte,'echange',$compte_op_nom, $convert, $client, 'devisev'.$max, 'gnf', $_SESSION['lieuvente'], $dateop));?>
                  <div class="alert alert-success">Opération éffectuée avec succèe!!!</div><?php
                }
  
              }
            }
          }
          if (isset($_GET['ajoutdev']) or isset($_POST['taux'])) {?>
            <form class="form" id="naissance" method="POST">
              <legend class="text-warning"><?=ucwords($_SESSION['motifdev']);?></legend><?php 
              if (isset($_POST['taux'])) {
                $montant=$panier->espace($_POST['montant']);
                $taux=$panier->espace($_POST['taux']);
                $converti=$montant*$taux;?>

                
                <label class="form-label">Montant Devise*</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" type="text" name="montant" value="<?=$panier->formatNombre($montant);?>" onchange="this.form.submit()" required=""><input class="form-control" type="hidden" name="motif" value="<?=$_SESSION['motifdev'];?>">
                </div>
                <div class="col-sm-12 col-md-6 bg-success text-white fw-bold py-2 fs-6" id="convertnumber"></div>

                <label class="form-label">Devise</label>
                <select class="form-select" type="number" name="devise" onchange="this.form.submit()" value="<?=$panier->formatNombre($_POST['devise']);?>" required="">
                  <option value="<?=$_POST['devise'];?>"><?=strtoupper($_POST['devise']);?></option><?php 
                  foreach ($panier->monnaie as $valuem) {?>
                      <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                  }?>
                </select> 
                <div class="row mb-1">
                  <label class="form-label">Taux*</label>
                  <div class="row">
                    <div class="col-6"><input class="form-control" type="number" name="taux" value="<?=$taux;?>" onchange="this.form.submit()" required=""></div>
                    <div class="col-6"><label class="form-label bg-success fw-bold text-white p-1">Montant Converti : <?=$panier->formatNombre($converti);?></label></div>
                  </div>
                </div><?php 
              }else{?>
                
                <label class="form-label">Montant Devise*</label>
                <div class="col-sm-12 col-md-6">
                  <input class="form-control" type="number" name="montant" min="0" required="" placeholder="entrer le montant en devise"><input class="form-control" type="hidden" name="motif" value="<?=$_SESSION['motifdev'];?>">
                </div>
                <div class="col-sm-12 col-md-6 bg-success text-white fw-bold py-2 fs-6" id="convertnumber"></div>
                  

                <label class="form-label">Devise*</label>
                <select class="form-select" type="number" name="devise" required="">
                  <option value=""></option><?php 
                  foreach ($configuration->paieMode() as $valuem) {?>
                      <option value="<?=$valuem->code;?>"><?=strtoupper($valuem->code);?></option><?php 
                  }?>
                </select> 
                <label class="form-label">Taux</label><input class="form-control" type="number" name="taux" min="0" onchange="this.form.submit()" required=""><?php

              }?>
              <div class="row mb-1">
                <div class="col-4">
                  <label for="compte" class="form-label">Compte Op*</label>
                  <select class="form-select" name="compte_op" required="" >
                    <option value=""></option><?php 
                    foreach ($caisse->compteAll() as $valuec) {?>
                      <option value="<?=$valuec->id;?>"><?=ucfirst($valuec->nom_compte);?></option><?php 
                    }?>
                  </select>
                </div>
                <div class="col-4">
                  <label class="form-label">Type de Paiement*</label>
                  <select class="form-select" name="mode_payement" required="" >
                    <option value=""></option><?php 
                    foreach ($panier->modep as $value) {?>
                        <option value="<?=$value;?>"><?=$value;?></option><?php 
                    }?>
                  </select>
                </div>
                
                <div class="col-4">
                  <label class="form-label">Compte utilisé*</label><select class="form-select"  name="compte" required="">
                  <option></option><?php
                    $type='Banque';

                    foreach($caisse->nomTypeCaisse() as $product){?>

                      <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                    }?>
                  </select>
                </div>
              </div> 
              <div class="row mb-1">
                <div class="col-sm-12 col-md-4"><label class="form-label">Date Opération</label><input class="form-control" type="date" name="datedep"></div>
                <div class="col-sm-12 col-md-8"><label class="form-label">Commentaires</label><input class="form-control" type="text" name="client" required=""></div>
              </div>
              <button class="btn btn-primary" type="submit" name="validevise" id="form" onclick="return alerteV();">Valider</button>        
            </form> <?php
          }
          if (!isset($_GET['ajoutdev'])) {

            if (!empty($_SESSION['motifdev']) and $_SESSION['motifdev']=='vente devise') {?> 
              <table class="table table-bordered table-striped table-hover table-responsive text-center align-middle">
                <thead>
                <tr>
                  <th colspan="11" >
                    <div class="row">
                      <div class="col-sm-12 col-md-6">
                        <form class="form row" method="POST" action="devise.php?vente" id="suitec" name="termc">
                          <div class="col-6"><?php
                            if (isset($_POST['j1'])) {?>
                              <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php
                            }else{?>
                              <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php
                            }?>
                          </div>
                          <div class="col-6"><?php
                            if (isset($_POST['j2'])) {?>
                              <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php
                            }else{?>
                              <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php
                            }?>
                          </div>
                        </form>
                      </div>
                      <div class="col-sm-12 col-md-6"><?="Liste des ventes Devise ".$datenormale;?> <a class="btn btn-warning" href="devise.php?ajoutdev&achat">Effectuer un Achat</a></div>
                    </div>
                  </th>
                </tr>
                <tr>
                  <th>N°</th>
                  <th>Date Op</th>
                  <th>Client</th>              
                  <th>Montant €</th>
                  <th>Montant $</th>
                  <th>Montant AED</th>
                  <th>Taux</th>     
                  <th>Montant GNF</th>
                  <th>T. P</th>              
                  <th>Justif</th>
                  <th></th>
                </tr>
              </thead>
              <tbody><?php 
                $cumulmontant=0;
                $cumulmontantgnf=0;
                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                if (isset($_POST['j1'])) {
                  $products= $DB->query('SELECT *FROM devisevente WHERE lieuvente=? and DATE_FORMAT(dateop, \'%Y%m%d\')>=? and DATE_FORMAT(dateop, \'%Y%m%d\')<=? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], $_SESSION['date1'], $_SESSION['date2'], 'vente devise'));
                }else{
                  $products= $DB->query('SELECT *FROM devisevente  WHERE lieuvente=? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], 'vente devise'));
                }                
                $soldegnf=0;
                $soldeeu=0;
                $soldeus=0;
                $soldecfa=0;
                foreach ($products as $key=> $product ){

                  $cumulmontant+=$product->montant;
                  $cumulmontantgnf+=$product->montant*$product->taux; ?>

                  <tr>
                    <td><?= $key+1; ?></td>

                    <td><?=(new DateTime($product->dateop))->format("d/m/Y à H:i");?></td>

                    <td><?= ucwords(strtolower($product->client)); ?></td><?php

                    if ($product->devise=='eu') {

                      $montanteu+=$product->montant;?>

                      <td class="text-end"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td>
                      <td></td><?php

                    }elseif ($product->devise=='us') {

                      $montantus+=$product->montant;?>

                      <td></td>

                      <td class="text-end"><?= number_format($product->montant,2,',',' '); ?></td>

                      <td></td><?php

                    }elseif ($product->devise=='aed') {

                      $montantcfa+=$product->montant;?>
                      
                      <td></td>

                      <td></td>

                      <td class="text-end"><?= number_format($product->montant,2,',',' '); ?></td><?php

                    }?> 

                    <td class="text-end"><?=number_format($product->taux,2,',',' ');?></td>

                    <td class="text-end"><?=number_format($product->montant*$product->taux,2,',',' ');?></td>  

                    <td><?= $product->typep; ?></td>

                     <td style="text-align: center">

                        <a href="printdevise.php?numdec=<?=$product->id;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                      </td>

                    <td><a onclick="return alerteS();" class="btn btn-danger" href="devise.php?deletevers=<?=$product->numcmd;?>">Annuler</a></td>
                  </tr><?php 
                }?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3">Totaux</th>
                  <th class="text-end"><?= number_format($montanteu,2,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantus,2,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantcfa,2,',',' ');?></th>
                  <th></th>
                  <th class="text-end"><?= number_format($cumulmontantgnf,2,',',' ');?></th>
                </tr>
              </tfoot>

            </table>
          </div>
        </div><?php

        }else{?>
          <table class="table table-bordered table-striped table-hover table-responsive text-center align-middle my-1">
            <thead class="sticky-top bg-light">
              <tr>
                <th colspan="11" >
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <form class="form row" method="POST" action="devise.php?achat" id="suitec" name="termc">
                        <div class="col-6"><?php
                          if (isset($_POST['j1'])) {?>
                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php
                          }else{?>
                            <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php
                          }?>
                        </div>
                        <div class="col-6"><?php
                          if (isset($_POST['j2'])) {?>
                            <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php
                          }else{?>
                            <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php
                          }?>
                        </div>
                      </form>
                    </div>
                    <div class="col-sm-12 col-md-6"><?="Liste des Achat Devise ".$datenormale;?> <a class="btn btn-warning" href="devise.php?ajoutdev&achat">Effectuer un Achat</a></div>
                  </div>
                </tr>
                <tr>
                  <th>N°</th>
                  <th>Date Op</th>
                  <th>Client</th>              
                  <th>Montant €</th>
                  <th>Montant $</th>
                  <th>Montant AED</th>
                  <th>Taux</th>     
                  <th>Montant GNF</th>
                  <th>T. P</th>              
                  <th>Justif</th>
                  <th></th>
                </tr>
              </thead>
              <tbody><?php 
                $cumulmontant=0;
                $cumulmontantgnf=0;
                $montantgnf=0;
                $montanteu=0;
                $montantus=0;
                $montantcfa=0;
                if (isset($_POST['j1'])) {
                  $products= $DB->query('SELECT *FROM devisevente WHERE lieuvente=? and DATE_FORMAT(dateop, \'%Y%m%d\')>=? and DATE_FORMAT(dateop, \'%Y%m%d\')<=? and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], $_SESSION['date1'], $_SESSION['date2'], 'achat devise'));
                }else{
                  $products= $DB->query('SELECT *FROM devisevente  WHERE lieuvente=?  and motif=? order by(dateop) LIMIT 50', array($_SESSION['lieuvente'], 'achat devise'));
                }
                
                $soldegnf=0;
                $soldeeu=0;
                $soldeus=0;
                $soldecfa=0;
                foreach ($products as $key=> $product ){

                  $cumulmontant+=$product->montant;
                  $cumulmontantgnf+=$product->montant*$product->taux; ?>

                  <tr>
                    <td><?= $key+1; ?></td>
                    <td><?=(new DateTime($product->dateop))->format("d/m/Y");?></td>
                    <td><?= ucwords(strtolower($product->client)); ?></td><?php
                    if ($product->devise=='eu') {
                      $montanteu+=$product->montant;?>
                      <td class="text-end"><?= number_format($product->montant,2,',',' '); ?></td>
                      <td></td>
                      <td></td><?php
                    }elseif ($product->devise=='us') {
                      $montantus+=$product->montant;?>
                      <td></td>
                      <td class="text-end"><?= number_format($product->montant,2,',',' ');?></td>
                      <td></td><?php
                    }elseif ($product->devise=='aed') {
                      $montantcfa+=$product->montant;?>                      
                      <td></td>
                      <td></td>
                      <td class="text-end"><?= number_format($product->montant,2,',',' '); ?></td><?php
                    }?>
                    <td class="text-end"><?=number_format($product->taux,2,',',' ');?></td>
                    <td class="text-end"><?=number_format($product->montant*$product->taux,2,',',' ');?></td>
                    <td><?= $product->typep; ?></td>
                    <td style="text-align: center">
                      <a href="printdevise.php?numdec=<?=$product->id;?>" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>
                    </td>
                    <td><a onclick="return alerteS();" class="btn btn-danger" href="devise.php?deletevers=<?=$product->numcmd;?>">Annuler</a></td>
                  </tr><?php 
                }?>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3">Totaux</th>
                  <th class="text-end"><?= number_format($montanteu,2,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantus,2,',',' ');?></th>
                  <th class="text-end"><?= number_format($montantcfa,2,',',' ');?></th>
                  <th></th>
                  <th class="text-end"><?= number_format($cumulmontantgnf,2,',',' ');?></th>
                </tr>
              </tfoot>
            </table><?php

      }
    }

      

    }else{

      echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

    }

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
