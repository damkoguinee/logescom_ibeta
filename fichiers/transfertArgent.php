<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];?>

    <div class="container-fluid">

        <div class="row"><?php
            require 'navbanque.php';?>

            <div class="col-sm-12 col-md-10"><?php
    

                if ($_SESSION['level']>=3) {


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

                        }elseif ($_POST['montant']>$panier->montantCompteBil($_POST['compte'], $_POST['devisenv'])) {?>

                            <div class="alertes">Echec montant decaissé est > au montant disponible en caisse</div><?php

                        }else{

                            $numdec = $DB->querys('SELECT count(id) AS id FROM transfertargent');
                            $numdec=$numdec['id']+1;

                            $montant=$panier->espace($panier->h($_POST['montant']));
                            $devise=$panier->h($_POST['devise']);
                            $devisenv=$panier->h($_POST['devisenv']);
                            $client=$panier->h($_POST['client']);
                            $motif=$panier->h($_POST['motif']);
                            $taux=$panier->espace($panier->h($_POST['taux']));                       
                            $bl=$panier->h($_POST['bordereau']);
                            $cmd=$panier->h($_POST['cmd']);
                            $compte=$panier->h($_POST['compte']);
                            $modep=$panier->h($_POST['modep']);

                            $lieuventeret=$_SESSION['lieuvente']; 
                            $dateop=$panier->h($_POST['dateop']);
                            if (empty($dateop)) {
                                $dateop=date("Y-m-d h:i");
                            }else{
                                $dateop=$dateop;
                            }

                            $numdec="ta".$numdec;      

                            $prodverif = $DB->querys("SELECT id FROM transfertargent where bl='{$bl}' ");

                            if (!empty($prodverif['id'])) {?>

                                <div class="alert alert-warning">Ce numero BL existe dejà!!!</div><?php
                                
                            }else{

                                if(isset($_POST["env"])){
                                    require "uploadtransfert.php";
                                }

                                $DB->insert('INSERT INTO transfertargent (numenv, cmd, idpers, montant, taux, devisenv, devise, bl, libelle, lieuvente, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($numdec, $cmd, $client, $montant, $taux, $devisenv, $devise, $bl, $motif, $lieuventeret, $dateop));
                            
                                $DB->insert('INSERT INTO banque (id_banque, clientbanque,typeent,origine, montant, typep, libelles, numero, devise, lieuvente, numeropaie, banqcheque, date_versement) VALUES(?, ?,?,?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($compte,"","transfert argent","pre-cmd", -$montant, $modep, $cmd, $numdec, $devisenv, $lieuventeret, $bl, ""));
                                unset($_POST);
                                unset($_GET);?>
                                <div class="alert alert-success">transfert enregistré avec succèe!!!</div><?php 
                            }

                        }

                    }else{

                        
                    }

                    if (isset($_GET['ajout']) or isset($_GET['searchclientvers'])) {?>

                        <form class="form my-2" method="POST" action="transfertArgent.php" enctype="multipart/form-data">
                            <fieldset>
                                <label class="form-label">Montant Envoyé*</label>
                                <div class="container-fluid mb-1 px-0">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <input class="form-control" id="numberconvert" type="number"   name="montant" value="0" min="0" required="">
                                        </div>

                                        <div class="col-sm-12 col-md-3">                                        
                                            <select class="form-select" name="devisenv" required="" >
                                                <option value="us">US</option><?php 
                                                foreach ($panier->monnaie as $valuem) {?>
                                                    <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                                                }?>
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-3">
                                            <div class="text-danger fw-bold fs-4" id="convertnumber"></div>
                                        </div>
                                    </div>
                                </div>                          

                                <div class="row mb-1">

                                    <div class="col-sm-12 col-md-3">
                                        <label class="form-label">Devise Réception*</label>
                                        <select class="form-select" name="devise" required="" >
                                            <option value=""></option><?php 
                                            foreach ($panier->monnaie as $valuem) {?>
                                                <option value="<?=$valuem;?>"><?=strtoupper($valuem);?></option><?php 
                                            }?>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <label class="form-label">Taux*</label>
                                        <input oninput="total()" id="devise" class="form-control" type="text"   name="taux" value="1" min="0" required="">
                                    </div>

                                    <div class="col-sm-12 col-md-3 ">
                                        <label class="form-label">Montant à Récevoir*</label>
                                        <div class="text-success fw-bold fs-4" id="showTotal">
                                    </div>
                                </div>

                                <div class="row mb-1">

                                    <div class="col-sm-12 col-md-4">
                                        <label class="form-label">Mode de Paiement*</label>
                                        <select class="form-select" name="modep" required="" >
                                            <option value=""></option><?php 
                                            foreach ($panier->modep as $value) {?>
                                                <option value="<?=$value;?>"><?=$value;?></option><?php 
                                            }?>
                                        </select>
                                    </div>

                                    <div class="col-sm-12 col-md-5">
                                        <label class="form-label">Compte utilisé*</label>
                                        <select class="form-select" name="compte" required="">
                                            <option value=""></option><?php
                                            $type='banque';

                                            foreach($caisse->nomTypeCaisse() as $product){?>

                                                <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                              }
                          
                                              foreach($caisse->listBanque() as $product){?>
                          
                                                <option value="<?=$product->id;?>"><?=strtoupper($product->nomb);?></option><?php
                                              }?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label class="form-label">Envoyé par*</label>
                                            <select class="form-select" type="text" name="client" required>
                                                <option value=""></option><?php 
                                                foreach($panier->personnel() as $product){?>
                                                <option value="<?=$product->id;?>"><?=$panier->nomPersonnel($product->id);?></option><?php
                                                }?>
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-md-4">
                                            <label class="form-label">Commande*</label><?php 
                                            $cmd=$DB->query("SELECT *from editionfournisseur order by(bl)desc");?>
                                            <select class="form-select" type="text" name="cmd" required>
                                                <option value=""></option><?php 
                                                foreach($cmd as $product){?>
                                                <option value="<?=$product->bl;?>"><?=$product->bl;?></option><?php
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-4">
                                            <label class="form-label">N° Bordereau*</label>
                                            <input class="form-control" type="text"   name="bordereau" required="">
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <label class="form-label">Commentaire*</label>
                                            <input class="form-control" type="text"   name="motif" required="">
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-1">
                                    <label class="form-label">Joindre bordereau retrait</label>
                                    <input class="form-control" type="file" name="just[]"multiple id="photo" />
                                    <input class="form-control" type="hidden" value="b" name="env"/>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Date opération</label>
                                    <input class="form-control" type="date" max="<?=$dateJour;?>" name="dateop">
                                </div>
                            </fieldset><?php
                        
                            if (empty($panier->totalsaisie()) AND $panier->licence()!="expiree") {?>

                                <button class="btn btn-primary"  type="submit" name="valid" onclick="return alerteV();">Valider</button><?php

                            }else{?>

                                <div class="alert alert-warning"> Journée cloturée ou la licence est expirée </div><?php

                            }?> 
                        </form><?php
                    }

                    if (!isset($_GET['ajout'])) {?>

                        <table class="table table-hover table-bordered table-striped table-responsive text-center">
            
                          <thead>
                            <tr><th colspan="9">Liste des transferts d'argent <a href="transfertargent.php?ajout" class="btn btn-warning">Envoyez de l'argent</a></th></tr>
            
                            <tr>
                              <th>N°</th>
                              <th>Date</th>
                              <th>N° Bord</th>
                              <th>Commande</th>
                              <th>Montant Envoyé</th>
                              <th>Taux</th>                               
                              <th>Montant Réçu</th>
                              <th>Envoyé par</th>
                              <th></th>
                            </tr>
            
                          </thead>
            
                          <tbody><?php 

                            $products= $DB->query("SELECT *FROM transfertargent ");
                             
                            $montantenv=0;
                            $montantrec=0;
                            foreach ($products as $keyv=> $product ){
                              
                              $montantenv+=$product->montant;
                              $montantrec+=$product->montant*$product->taux;?>
            
                              <tr>
                                <td><?= $keyv+1; ?></td>
                                <td><?=(new DateTime($product->dateop))->format("d/m/Y"); ?></td>
                                <td><?= strtoupper($product->bl); ?></td>
                                <td><?=$product->cmd; ?></td>
                                <td><?= number_format($product->montant,2,',',' ').' '.$product->devisenv; ?></td>
                                <td><?= number_format($product->taux,2,',',' '); ?></td>
                                <td><?= number_format($product->montant*$product->taux,2,',',' ').' '.$product->devise; ?></td>
                                <td><?=strtoupper($panier->nomPersonnel($product->idpers)); ?></td>            
                                <td><?php if ($_SESSION['level']>=6 and empty($prodverif['id'])){?><a class="btn btn-danger" onclick="return alerteV();" href="transfertargent.php?deleteret=<?=$product->numenv;?>">Supprimer</a><?php };?></td>
                                
                              </tr><?php 
                            }?>
            
                          </tbody>
            
                          <tfoot>
                            <tr>
                              <th colspan="4">Totaux</th>
                              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantenv,0,',',' ');?></th>
                              <th></th>
                              <th style="text-align: right; padding-right: 10px;"><?= number_format($montantrec,0,',',' ');?></th>
                            </tr>
                          </tfoot>
            
                        </table><?php 
                      }
                }else{

                    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

                }?>
            </div>
        </div>
    </div><?php
}else{

}

require 'footer.php';?>


    
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
