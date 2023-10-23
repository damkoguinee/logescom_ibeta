<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  $bdd='editionfournisseur';   

  $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `numedit` varchar(150),
    `id_client` int(10) DEFAULT NULL,
    `libelle` varchar(150),
    `bl` varchar(150),
    `nature` varchar(150),
    `montant` double DEFAULT NULL,
    `devise` varchar(10),
    `lieuvente` int(2) DEFAULT NULL,
    `dateop` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");

  $pseudo=$_SESSION['pseudo'];?>

  <div class="container-fluid">

    <div class="row"><?php
      require 'navfournisseur.php';?>

      <div class="col-sm-12 col-md-10"><?php
  

        if ($_SESSION['level']>=3) {

          if (!isset($_POST['magasin'])) {

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
          }

          if (isset($_POST['j2'])) {

            $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];

          }else{

            $datenormale=(new DateTime($_SESSION['date']))->format('d/m/Y');
          }

          if (isset($_POST['clientliv'])) {
            $_SESSION['clientliv']=$_POST['clientliv'];
          }


          if (isset($_GET['deleteret'])) {
            $DB->delete("DELETE from editionfournisseur where numedit='{$_GET['deleteret']}'");
            $DB->delete("DELETE from bulletin where numero='{$_GET['deleteret']}'");
            $DB->delete("DELETE from banquecmd where numdec='{$_GET['deleteret']}'");
            $DB->delete("DELETE from banque where numero='{$_GET['deleteret']}'");?>

            <div class="alert alert-success">Suppression reussie!!</div><?php 
          }


          if (isset($_POST["valid"])) {

            if (empty($_POST["client"])) {?>

              <div class="alert alert-warning">Les Champs sont vides</div><?php

            }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>

              <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }else{

              $numdec = $DB->querys('SELECT count(id) AS id FROM editionfournisseur');
              $numdec=$numdec['id']+1;

              $montant=$panier->h($_POST['montant']);
              $bl="cmd".$numdec;
              $nature=$panier->h($_POST['nature']);
              $devise=$panier->h($_POST['devise']);
              $client=$panier->h($_POST['client']);
              $motif=$panier->h($_POST['motif']);
              $taux=1;

              $compte=$panier->h($_POST['compte']);
              $modep=$panier->h($_POST['modep']);
              $numcheque='';
              $banquecheque='';
              $devise=$panier->h($_POST['devise']);
              $taux=1;

              $lieuventeret=$_SESSION['lieuvente']; 
              $dateop=$panier->h($_POST['dateop']);
              if (empty($dateop)) {
                $dateop=date("Y-m-d h:i");
              }else{
                $dateop=$dateop;
              }

              $numdec='commande'.$numdec;        

              $prodverif = $DB->querys("SELECT id FROM editionfournisseur where bl='{$bl}' ");

              if (!empty($prodverif['id'])) {?>

                <div class="alert alert-warning">Ce numero BL existe dejà!!!</div><?php
                
              }else{

                if(isset($_POST["env"])){
                  require "uploadf.php";
                }

                $DB->insert('INSERT INTO editionfournisseur (numedit, id_client, montant, bl, nature, libelle, devise, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $montant, $bl, $nature, $motif, $devise, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($client, $montant, $motif, $numdec, $devise, 1, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO banquecmd (numdec, idf, cmd, montant, devise, taux, payement, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $bl, $montant, $devise, 1, $modep, $lieuventeret, $dateop));
              
                $DB->insert('INSERT INTO banque (id_banque, montant, typep, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, -$montant, $modep, "Retrait (".$bl.')', $numdec, $devise, $lieuventeret, $numcheque, $banquecheque));
                    
                
                unset($_POST);
                unset($_GET);
                unset($_SESSION['searchclientvers']);
                ?>

                <div class="alert alert-success">Commande enregistrée avec succèe!!!</div><?php 
              }

            }

          }else{

            
          }

          if (isset($_GET['searchclientvers']) ) {

              $_SESSION['searchclientvers']=$_GET['searchclientvers'];
          }

          if (isset($_GET['ajout']) or isset($_GET['searchclientvers'])) {?>

            <form class="form my-2" method="POST" action="editionfacturefournisseur.php" enctype="multipart/form-data">

              <fieldset>

                <div class="mb-1">

                  <label class="form-label">Acheteur*</label>
                  <select class="form-select" type="text" name="client"><?php 

                    if (!empty($_SESSION['searchclientvers'])) {?>

                        <option value="<?=$_SESSION['searchclientvers'];?>"><?=$panier->nomClient($_SESSION['searchclientvers']);?></option><?php
                    }else{?>
                        <option></option><?php 
                    }

                    $type1='fournisseur';
                    $type2='clientf';

                    foreach($panier->clientF($type1, $type2) as $product){?>
                      <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                    }?>
                  </select>
                </div>

                <!-- <div class="mb-1">

                  <label class="form-label">N°Commande*</label>
                  <input class="form-control" type="text"   name="bl" required="">
                </div> -->

                <!-- <div class="mb-1">

                  <label class="form-label">Nature*</label>
                  <input class="form-control" type="text" value="achat"  name="nature" required="" placeholder="nom des produits">
                </div> -->
                <input class="form-control" type="hidden" value="achat"  name="nature" required="" placeholder="nom des produits">
                <div class="mb-1">
                  <label class="form-label">Libellé de la Facture*</label>
                  <input class="form-control" type="text"   name="motif" required="">

                </div>

                <label class="form-label">Montant*</label>

                <div class="container-fluid mb-1">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <input class="form-control" id="numberconvert" type="number"   name="montant" value="0" min="0" required="">
                    </div>

                    <div class="col-sm-12 col-md-6">

                      <div class="text-danger fw-bold fs-4" id="convertnumber"></div>
                    </div>
                  </div>
                </div>

                <div class="row mb-1">

                  <div class="col-sm-12 col-md-3">
                    <label class="form-label">Devise*</label>
                    <select class="form-select" name="devise" required="" ><?php 
                      foreach ($panier->monnaie as $valuem) {?>
                          <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                      }?>
                    </select>
                  </div>

                  <div class="col-sm-12 col-md-4">
                    <label class="form-label">Mode de Paiement*</label>
                    <select class="form-select" name="modep" required="" ><?php 
                      foreach ($panier->modep as $value) {?>
                        <option value="<?=$value;?>"><?=$value;?></option><?php 
                      }?>
                    </select>
                  </div>

                  <div class="col-sm-12 col-md-5">
                    <label class="form-label">Compte de Retrait*</label>
                    <select class="form-select" name="compte" required=""><?php
                      $type='banque';

                      foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }

                      foreach($panier->nomBanqueVire() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }?>
                    </select>
                  </div>
                </div>

                <div class="mb-1">
                  <label class="form-label">Joindre bordereau retrait</label>
                  <input class="form-control" type="file" name="just[]"multiple id="photo" />
                  <input class="form-control" type="hidden" value="b" name="env"/>
                </div>
                <div class="mb-1">
                  <label class="form-label">Date de la Facture</label>
                  <input class="form-control" type="date" name="dateop">
                </div>
              </fieldset><?php
            
              if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                <button class="btn btn-primary"  type="submit" name="valid" onclick="return alerteV();">Valider</button><?php

              }else{?>

                <div class="alert alert-warning"> Journée cloturée ou la licence est expirée </div><?php

              }?> 
            </form><?php
          }



          if (isset($_GET['update'])) {

            $prod = $DB->querys("SELECT *FROM editionfournisseur where numedit='{$_GET['update']}' ");

            $datefacture=(new dateTime($prod['dateop']))->format("Y-m-d");?>

            <form class="form my-2 " method="POST" action="editionfacturefournisseur.php" enctype="multipart/form-data">

              <div class="mb-1">
                <label class="form-label">Acheteur*</label>
                <select class="form-select" type="text" name="client">
                  <option value="<?=$prod['id_client'];?>"><?=$panier->nomClient($prod['id_client']);?></option><?php

                  $type1='fournisseur';
                  $type2='clientf';

                  foreach($panier->clientF($type1, $type2) as $product){?>
                    <option value="<?=$product->id;?>"><?=$product->nom_client;?></option><?php
                  }?>
                </select>
                <input class="form-control" type="hidden"   name="bl" value="<?=$prod['bl'];?>" required="">
                <input class="form-control" type="hidden"   name="blinit" value="<?=$prod['bl'];?>">
                <input class="form-control" type="hidden"   name="numedit" value="<?=$prod['numedit'];?>">
              </div>
              <input class="form-control" type="hidden"   name="nature" value="<?=$prod['nature'];?>" >
              

              <div class="mb-1">
                <label class="mb-1">Libellé de la Facture*</label>
                <input class="form-control" type="text" value="<?=$prod['libelle'];?>"  name="motif" required="">
              </div>

              <label class="form-label">Montant*</label>

                <div class="container-fluid">

                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <input class="form-control" id="numberconvert" type="number"   name="montant" value="<?=$prod['montant'];?>" min="0" required="" style="font-size: 25px; width: 50%;">
                    </div>
                  
                    <div class="col-sm-12 col-md-6">

                      <div class="text-danger fw-bold fs-4" id="convertnumber"></div>
                    </div>
                  </div>

                </div>

                <div class="row mb-1">

                  <div class="col-sm-12 col-md-3">
                    <label class="form-label">Devise*</label>
                    <select class="form-select" name="devise" required="" >
                      <option value="<?=$prod['devise'];?>"><?=$prod['devise'];?></option><?php 
                      foreach ($panier->monnaie as $valuem) {?>
                          <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                      }?>
                    </select>
                  </div>

                  <div class="col-sm-12 col-md-4">
                    <label class="form-label">Mode de Paiement*</label>
                    <select class="form-select" name="modep" required="" >
                      <option value=""></option><?php 
                      foreach ($panier->modep1 as $value) {?>
                        <option value="<?=$value;?>"><?=$value;?></option><?php 
                      }?>
                    </select>
                  </div>

                  <div class="col-sm-12 col-md-5">
                    <label class="form-label">Compte de Retrait*</label>
                    <select class="form-select" name="compte" required=""><?php
                      $type='banque';

                      foreach($panier->nomBanqueCaisseFiltre() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }

                      foreach($panier->nomBanqueVire() as $product){?>

                        <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                      }?>
                    </select>
                  </div>
                </div>


                <div class="mb-1">
                  <label class="form-label">Joindre bordereau retrait</label>
                  <input class="form-control" type="file" name="just[]"multiple id="photo" />
                  <input class="form-control" type="hidden" value="b" name="env"/>
                </div>

                <div class="mb-1">
                  <label class="form-label">Date de la Facture</label>
                  <input class="form-control" type="date" name="dateop" value="<?=$datefacture;?>" >
                </div><?php
              
                if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                  <button class="btn btn-primary" type="submit" name="validup" onclick="return alerteV();">Modifier</button><?php

                }else{?>
                  <div class="alert alert-danger"> Journée cloturée ou la licence est expirée </div><?php
                }?>
              </fieldset> 
            </form> <?php
          }


          if (isset($_POST["validup"])) {

            if (empty($_POST["client"])) {?>

              <div class="alert alert-warning">Les Champs sont vides</div><?php

            }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devise'])) {?>

              <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

            }else{

              $numdec=$panier->h($_POST['numedit']);
              $blinit=$panier->h($_POST['blinit']);
              $montant=$panier->h($_POST['montant']);
              $bl=$panier->h($_POST['bl']);
              $nature=$panier->h($_POST['nature']);
              $devise=$panier->h($_POST['devise']);
              $client=$panier->h($_POST['client']);
              $motif=$panier->h($_POST['motif']);
              $compte=$panier->h($_POST['compte']);
              $modep=$panier->h($_POST['modep']);
              $numcheque='';
              $banquecheque='';
              $devise=$panier->h($_POST['devise']);
              $taux=1;

              $lieuventeret=$_SESSION['lieuvente']; 
              $dateop=$panier->h($_POST['dateop']);
              if (empty($dateop)) {
                $dateop=date("Y-m-d h:i");
              }else{
                $dateop=$dateop;
              }

              

              if ($bl==$blinit) {

                $DB->delete("DELETE from editionfournisseur where numedit='{$numdec}'");

                $DB->delete("DELETE from bulletin where numero='{$numdec}'");

                $DB->insert("UPDATE stockmouv SET coment= ? WHERE coment = ?", array($bl, $blinit)); 
                $DB->delete("DELETE from banque where numero='{$numdec}'");
                $DB->delete("DELETE from banquecmd where numdec='{$numdec}'");
              }    

              $prodverif = $DB->querys("SELECT id FROM editionfournisseur where bl='{$bl}' ");

              if (!empty($prodverif['id'])) {?>

                <div class="alert alert-warning">Ce numero BL existe dejà!!!</div><?php
                
              }else{ 

                $DB->delete("DELETE from editionfournisseur where numedit='{$numdec}'");

                $DB->delete("DELETE from bulletin where numero='{$numdec}'");

                $DB->insert("UPDATE stockmouv SET coment= ? WHERE coment = ?", array($bl, $blinit));         

                if(isset($_POST["env"])){
                  require "uploadf.php";
                }

                $DB->insert('INSERT INTO editionfournisseur (numedit, id_client, montant, bl, nature, libelle, devise, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $montant, $bl, $nature, $motif, $devise, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO bulletin (nom_client, montant, libelles, numero, devise, caissebul, lieuvente, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?)', array($client, $montant, $motif, $numdec, $devise, 1, $lieuventeret, $dateop));

                $DB->insert('INSERT INTO banquecmd (numdec, idf, cmd, montant, devise, payement, lieuvente, taux, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $client, $bl, $montant, $devise, $modep, $lieuventeret, 1, $dateop));
                
                $DB->insert('INSERT INTO banque (id_banque, montant, typep, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte, $montant, $modep, "Retrait (".$bl.')', $numdec, $devise, $lieuventeret, $numcheque, $banquecheque)); 
                
                unset($_POST);
                unset($_GET);
                unset($_SESSION['searchclientvers']);
                ?>

                <div class="alert alert-warning">Commande modifiée avec succèe!!!</div><?php 
              }

            }

          }else{

            
          }


          if (!isset($_GET['ajout'])) {?>

            <table class="table table-hover table-bordered table-striped table-responsive text-center">

              <thead class="sticky-top bg-light">
                <!-- <tr><th colspan="15">Liste des commandes <a href="editionfacturefournisseur.php?ajout" class="btn btn-warning">Passer une commande</a></th></tr> -->

                <tr>
                  <th colspan="15">
                    <div class="d-flex justify-content-around">
                      Liste des commandes <a href="editionfacturefournisseur.php?ajout" class="btn btn-warning">Passer une commande</a>
                      <form class="d-flex" method="get">
                        <input type="text" name="search" onchange="this.form.submit()" class="form-control">
                        <button class="btn btn-primary" type="submit">Rechercher</button>

                      </form>
                    </div>
                  </th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Date</th>
                  <th>N°Cmd</th>
                  <th>Désignation</th>
                  <th>Acheteur</th> 
                  <th>Montant Cmd $</th>
                  <th>Montant Payé $</th>
                  <th>Reste</th>
                  <th colspan="4">Actions</th>
                </tr>

              </thead>

              <tbody><?php 

                // if ($_SESSION['level']>6) {
                //   $products= $DB->query("SELECT *FROM editionfournisseur  order by(id) DESC");
                // }else{
                //   $products= $DB->query("SELECT *FROM editionfournisseur  WHERE lieuvente='{$_SESSION['lieuvente']}' ");
                // } 
                
                if (isset($_GET['search'])) {
                  $terme = htmlspecialchars($_GET["search"]);
                  $products= $DB->query("SELECT *FROM editionfournisseur inner join client on id_client=client.id  WHERE (nom_client LIKE ? OR telephone LIKE ? OR bl LIKE ? ) and  lieuvente LIKE ? order by(editionfournisseur.id) DESC ", array("%".$terme."%", "%".$terme."%", "%".$terme."%", $_SESSION['lieuvente']));
                }else{ 

                  if ($_SESSION['level']>6) {
                    $products= $DB->query("SELECT *FROM editionfournisseur  order by(id) DESC");
                  }else{
                    $products= $DB->query("SELECT *FROM editionfournisseur  WHERE lieuvente='{$_SESSION['lieuvente']}' order by(id) DESC ");
                  } 
                }  


                $totmontantus=0;
                $totpayecmd=0;
                foreach ($products as $keyv=> $product ){
                  $prodverif= $DB->querys("SELECT *FROM stockmouv  WHERE coment='{$product->bl}' ");
                  $montantus=$commande->orderAmountSupplier($product->bl)['montantus'];
                  $montantpayeus=$commande->paieCmdSupplier($product->bl)['montantus'];
                  $totmontantus+=$montantus;
                  $totpayecmd+=$montantpayeus;
                  $reste=$montantus-$montantpayeus;?>

                  <tr>
                    <td><?= $keyv+1; ?></td>
                    <td><?=(new DateTime($product->dateop))->format("d/m/Y"); ?></td>
                    <td><?= strtoupper($product->bl); ?></td>
                    <td><?=$product->libelle; ?></td>
                    <td><?=strtoupper($panier->nomClient($product->id_client)); ?></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($montantus,0,',',' '); ?></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($montantpayeus,0,',',' '); ?></td>
                    <td style="text-align: right; padding-right: 10px;"><?= number_format($reste,0,',',' '); ?></td>
                    <td><?php if ($_SESSION['level']>=1){?><a class="btn btn-primary" href="gestionselection.php?reception=<?=$product->numedit;?>&bl=<?=$product->bl;?>&idclient=<?=$product->id_client;?>&datef=<?=$product->dateop;?>">Gestion</a><?php };?></td>
                    <td><?php if ($_SESSION['level']>=1){?><a class="btn btn-success" href="gestionreception.php?reception=<?=$product->numedit;?>&bl=<?=$product->bl;?>&idclient=<?=$product->id_client;?>&datef=<?=$product->dateop;?>">Reception</a><?php };?></td>
                    <td><?php if ($_SESSION['level']>=6 ){?><a class="btn btn-warning" onclick="return alerteV();" href="editionfacturefournisseur.php?update=<?=$product->numedit;?>">Modifier</a><?php };?></td>

                    <td><?php if ($_SESSION['level']>=6 and empty($prodverif['id'])){?><a class="btn btn-danger" onclick="return alerteV();" href="editionfacturefournisseur.php?deleteret=<?=$product->numedit;?>">Supprimer</a><?php };?></td>
                    
                  </tr><?php 
                }?>

              </tbody>

              <tfoot>
                <tr>
                  <th colspan="5">Totaux</th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($totmontantus,0,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($totpayecmd,0,',',' ');?></th>
                  <th style="text-align: right; padding-right: 10px;"><?= number_format($totmontantus-$totpayecmd,0,',',' ');?></th>
                </tr>
              </tfoot>

            </table><?php 
          }?>
        </div>
      </div>
    </div><?php 

      

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

  }

}else{

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
                      url: 'recherche_utilisateur.php?editionfacture',
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
                    url: 'convertnumber.php?convertvers',
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


    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>
