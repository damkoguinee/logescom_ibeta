<?php require 'headerv2.php';?>

<div class="container-fluid">

  <div class="row"><?php
    require 'navstock.php';?>

    <div class="col-sm-12 col-md-10">

      <script>
        function suivant(enCours, suivant, limite){
          if (enCours.value.length >= limite)
          document.term[suivant].focus();
        }
      </script><?php

      if (isset($_GET['deletevers'])) {

        $id=$_GET['deletevers'];

        $numero=$_GET['idprod'];
        $depart=$_GET['depart'];
        $nomtabdep=$panier->nomStock($depart)[1];
        $qtitesup=$_GET['qtite'];
        $dateop=$_GET['dateop'];
        $bl=$_SESSION['bl'];

        $qtiteiniti=$DB->querys("SELECT quantite, prix_revient as pr FROM `".$nomtabdep."` WHERE idprod=?", array($numero));

        $prodcmd=$DB->querys("SELECT quantite, previent as pr FROM achat WHERE id_produitfac=? and numfact=?", array($numero, $bl));

        $qtiteinit=$qtiteiniti['quantite'];
        $pri=$qtiteiniti['pr'];

        $qtiteaug=$qtiteiniti['quantite']-$qtitesup;

        $prmoyen=$panier->espace(number_format(((($qtiteinit*$pri)-($prodcmd['quantite']*$prodcmd['pr']))/(($qtiteinit-$prodcmd['quantite']))),0,',','')); 

        $DB->insert("UPDATE `".$nomtabdep."` SET quantite = ?, prix_revient=? WHERE idprod= ?", array($qtiteaug, $prmoyen, $numero));

        $DB->delete('DELETE FROM stockmouv WHERE id = ?', array($id));

        // $DB->delete('DELETE FROM achat WHERE id_produitfac=? and numfact=?', array($numero, $bl));?>

        <div class="alert alert-success">L'approvisionnement a été bien annulé</div><?php
      }
      if (isset($_POST['qtiteap'])) {

        $nomtab1=$panier->nomStock($_POST['departap'])[1];

        $idstock1=$panier->nomStock($_POST['departap'])[2];

        $lieuvente=$panier->nomStock($_POST['departap'])[3];

        $id=$panier->h($_POST['idap']);

        $designation=$panier->nomProduit($id);
        $bl=$_SESSION['bl'];

        if (empty($_POST['pa'])) {
          $pra=0;
        }else{

          $pra=$panier->h($_POST['pa']);
        }

        $pv=$panier->h($_POST['pv']);

        // $code=$panier->h($_POST['code']);

        // $datep=$panier->h($_POST['datep']);

        $desig=$panier->h($_POST['desig']);
        $bl=$_SESSION['bl'];
        $qtite=$panier->h($_POST['qtiteap']);
        $depart = $DB->querys("SELECT quantite as qtite, prix_revient as pr FROM `".$nomtab1."` WHERE idprod=?", array($id));

        $qtited=$depart['qtite']+$qtite;
        $qtitestock=$depart['qtite'];

        if ($qtitestock<0) {

          $qtitestock=0;
        }

        $previentstock=$depart['pr'];


        if (empty($previentstock)) {

            $qtitestock=0;
        }

        $pr=($qtite*$pra+$qtitestock*$depart['pr'])/($qtite+$qtitestock);

        

        $DB->insert("UPDATE `".$nomtab1."` SET quantite= ?, prix_revient=?, prix_vente=? WHERE idprod = ?", array($qtited, $pr, $pv, $id));

        $DB->insert("UPDATE productslist SET designation= ? WHERE id = ?", array($desig, $id));

        $DB->insert('INSERT INTO stockmouv (idstock, numeromouv, libelle, quantitemouv, idnomstock, coment, idpers, dateop) VALUES(?, ?, ?, ?, ?, ?, ?, now())', array($id, 'recepf', 'entree', $qtite, $idstock1, $bl, $_SESSION['idpseudo']));

        // $DB->insert('INSERT INTO achat (id_produitfac, numcmd, numfact, fournisseur, designation, quantite, taux, pachat, previent, pvente, etat, idstockliv, datefact, datecmd) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())', array($id, $bl, $bl, $_SESSION['idclient'], $designation, $qtite, 1, $pra, $pr, 0, 'livre', $lieuvente, $_SESSION['datef'])); ?>

        <div class="alert alert-success">Produit approvisionné avec sucèe!!!</div> <?php

      }?>
      <div class="row my-2">
        <div class="col-sm-12 col-md-12" style="overflow: auto;">
          <table class="table table-hover table-bordered table-striped table-responsive text-center">

            <form class="form" method="GET" action="editionreceptionf.php" id="suite" name="term">

              <thead><?php 
                $_SESSION['bl']="sans facture";
                $_SESSION['datef']=date("Y-m-d");?>

                <tr><th colspan="7">Approvisionnement sans facture</th></tr>
                <tr>

                  <th colspan="7">
                    <input class="form-control" type = "search" name = "terme" placeholder="rechercher un produit" onchange="document.getElementById('suite').submit()"/>
                  </th>
                </tr>
                <tr>
                  <th>N°</th>
                  <th>Reference</th>
                  <th>Qtité</th>
                  <th>P Revient</th>
                  <th>P Vente</th>
                  <th>Boutique</th>
                  <th></th>  
                </tr>

              </thead>
            </form>

            <tbody>

              <?php
              $tot_achat=0;
              $tot_revient=0;
              $tot_vente=0;
              $qtiteR=0;
              $qtiteS=0;

                  if (isset($_GET["terme"])){

                    $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
                    $terme = $_GET['terme'];
                    $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
                    $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

                    $_SESSION['terme']=$terme;
                  }

                  if (!empty($_SESSION['terme'])){

                    $terme = strtolower($_SESSION['terme']);
                    $products = $DB->query("SELECT productslist.id as id, Marque, type FROM productslist INNER JOIN categorie on categorie.id=codecat WHERE nom LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(Marque)",array("%".$terme."%", "%".$terme."%", "%".$terme."%"));
                  }else{

                    $products = $DB->query("SELECT productslist.id as id, Marque, type FROM productslist INNER JOIN categorie on categorie.id=codecat WHERE nom LIKE ? OR designation LIKE ? OR Marque LIKE ? order by(Marque)",array("%".$terme."%", "%".$terme."%", "%".$terme."%"));

                  }

                  

                if (!empty($products)) {

                  foreach ($products as $key=> $product){

                    $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

                    $pv=$DB->querys("SELECT prix_vente as pv, prix_revient, quantite, codeb, dateperemtion  FROM `".$nomtab."` WHERE idprod=? ", array($product->id));
                    $pventel=$pv['pv'];
                    $qtite=$pv['quantite'];
                    $pachat=$pv['prix_revient'];
                    $datep=$pv['dateperemtion'];
                    if (empty($datep)) {
                      $date=date("Y")+10;
                      $datep=$date."-01-01";
                    }
                    $code=$pv['codeb'];

                    if ($product->type=='paquet') {
                      $color='green';
                    }elseif ($product->type=='detail') {
                      $color='blue';
                    }else{
                      $color='';
                    }?>

                    <tr>
                      <td><?=$key+1;?></td>  

                      <form class="form" action="editionreceptionf.php" method="POST">

                        <td style="color:<?=$color;?>"><input class="form-control" type="text" name="desig" value="<?= ucwords(strtolower($product->Marque)); ?>" required="" /></td> <?php 
                        if ($_SESSION['level']>6) {?>

                          <td><input class="form-control text-center" type="number" name="qtiteap" min="-5" placeholder="<?=$qtite;?>" required=""/><input class="form-control text-center" type="hidden" name="idap" value="<?=$product->id;?>"> <input class="form-control text-center" type="hidden" name="bl" value="<?=$_SESSION['bl'];?>"></td><?php 
                        }else{?>

                          <td><input class="form-control text-center" type="number" name="qtiteap" min="0" placeholder="<?=$qtite;?>" required=""/><input class="form-control text-center" type="hidden" name="idap" value="<?=$product->id;?>"></td><?php

                        }?>

                        <td><input class="form-control text-center" type="text" name="pa" min="0" value="<?=$pachat;?>" /></td>

                        <td><input class="form-control text-center" type="text" name="pv" value="<?=$pventel;?>" min="0" /></td>

                        <!-- <td><input class="form-control text-center" type="date" name="datep" value="<?=$datep;?>" min="0" /></td>

                        <td><input class="form-control text-center" type="text" name="code" value="<?=$code;?>" min="0" /></td> -->

                      <td>
                        <select class="form-select" name="departap" required=""><?php 

                          if ($_SESSION['level']>=6) {

                            foreach($panier->listeStock() as $value){?>

                              <option value="<?=$value->id;?>"><?=ucwords(strtolower($value->nomstock));?></option><?php

                            }
                          }?>
                        </select>
                      </td>

                      <td><button class="btn btn-primary" type="submit" name="validap" onclick="return alerteT();">Approvisionner</button></td>
                    </form>
                  </tr><?php
                }
              }?>
            </tbody>

          </table>
        </div>

        <div class="col-sm-12 col-md-10" style="overflow: auto;">
          <table class="table table-hover table-bordered table-striped table-responsive text-center">

            <thead>

              <tr><th colspan="7">Liste des produits approvionnés sans facture</th></tr>

              <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Reference</th>
                <th>Qtité</th>
                <th>Exécuter par</th>
                <th>Boutique</th>
                <th></th>
              </tr>

            </thead>

            <tbody><?php
        
              $cumulmontant=0;
              $zero=0;

              $products= $DB->query("SELECT *FROM stockmouv WHERE coment='{$_SESSION['bl']}' order by(id) desc ");


              $qtitetot=0;
              foreach ($products as $keyd=> $product ){

                $qtitetot+=$product->quantitemouv;?>

                <tr>
                  <td style="text-align: center;"><?= $keyd+1; ?></td>
                  <td style="text-align: center;"><?= $panier->formatDate($product->dateop); ?></td>
                  <td class="text-start"><?=$panier->nomProduit($product->idstock); ?></td>
                  <td style="text-align: center;"><?=$product->quantitemouv; ?></td>
                  <td style="text-align: center;"><?=$panier->nomPersonnel($product->idpers); ?></td>
                  <td><?=$panier->nomStock($product->idnomstock)[0]; ?></td>

                  <td><a class="btn btn-danger" onclick="return alerteS();" href="editionreceptionf.php?deletevers=<?=$product->id;?>&idprod=<?=$product->idstock;?>&dateop=<?=$product->dateop;?>&qtite=<?=$product->quantitemouv;?>&depart=<?=$product->idnomstock;?>">Annuler</a></td>
                </tr><?php 
              }?>       

            </tbody>

            <tfoot>
              <tr>
                <th colspan="3">Totaux</th>
                <th style="text-align: center;"><?=$qtitetot;?></th>
              </tr>
            </tfoot>

          </table>  
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'footer.php';?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?edition',
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


<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function alerteT(){
        return(confirm('Confirmer l\'opération'));
    }

    function focus(){
    document.getElementById('reccode').focus();
  }

    window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };

</script>  