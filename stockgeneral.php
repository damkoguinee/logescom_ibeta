<?php require 'headerv2.php';?>

<div class="container-fluid"><?php

  require 'headerstock.php';?> 

  <div class="row">

    <?php require 'navstock.php';?> 

    <div class="col-sm-12 col-md-10" style="overflow: auto;"> <?php 

      if (isset($_POST['design'])) {
        $_SESSION['design']=$_POST['design'];

      }elseif(!empty($_SESSION['design'])){

        $_SESSION['design']=$_SESSION['design'];

      }else{
        $_SESSION['design']='';
      }

      if (isset($_POST['designinp'])) {
        $_SESSION['designinp']=$_POST['designinp'];

      }elseif(!empty($_SESSION['designinp'])){

        $_SESSION['designinp']=$_SESSION['designinp'];

      }else{
        $_SESSION['designinp']='';
      }

      if (isset($_GET['nomstock'])) {
        unset($_SESSION['design']);
        unset($_SESSION['designinp']);

      }

      if (isset($_GET['nomstock']) and $_GET['nomstock']!=0) {

        $_SESSION['nomtab']=$panier->nomStock($_SESSION['idnomstock'])[1];

      }

      if (isset($_POST['id'])) {
        $pa=$panier->espace($_POST['pa']);
        $pr=$panier->espace($_POST['pr']);
        $pv=$panier->espace($_POST['pv']);
        $perime=$_POST['perime'];
        if (empty($perime)) {
          $DB->insert("UPDATE `".$_SESSION['nomtab']."` SET prix_achat=?, prix_revient=?, prix_vente= ?, quantite= ? WHERE id = ?", array($pa,  $pr, $pv, $_POST['qtite'], $_POST['id']));
        }else{
           $DB->insert("UPDATE `".$_SESSION['nomtab']."` SET prix_achat=?, prix_revient=?, prix_vente= ?, quantite= ?, dateperemtion=? WHERE id = ?", array($pa,  $pr, $pv, $_POST['qtite'], $perime, $_POST['id']));
        }


       
      }

      if ((isset($_GET['nomstock']) and $_GET['nomstock']==0) or isset($_GET['recherchgen']) or isset($_GET['voirdetprod'])) {?>      

        <table class="table table-hover table-bordered table-striped table-responsive text-center">

          <form class="form" action="stockgeneral.php" method="POST">

            <thead>

              <tr>
                <th colspan="2">

                  <input class="form-control" type="text" name="recherchgen" placeholder="rechercher un produit" />

                  <div class="bg-danger" id="result-search"></div>

                  <?="Stock Général du " .date('d/m/Y'); ?><a href="printstock.php?stock=<?=$_SESSION['idnomstock'];?>" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a> 
                </th>
              </tr>

              <tr>
                <th>Désignation</th>
                <th>
                  <table style="width:100%">
                    <thead><?php 
                      $colspan=sizeof($panier->listeStock())+2;?>
                      <tr><th colspan="<?= $colspan;?>">Quantite</th></tr>

                      <tr><?php 

                        foreach ($panier->listeStock() as $valueS) {?>
                          <th width="80" style="font-size: 15px;"><?=ucwords($valueS->nomstock);?></th><?php 
                        }?>

                        <th width="80" style="font-size: 15px;">Qtité dispo</th>

                        <th width="80" style="font-size: 15px;">Qtité non Livré</th>
                      </tr>
                    </thead>
                  </table>
                </th>
              </tr>

            </thead>
          </form>

          <tbody>

            <?php
            $tot_achat=0;
            $tot_revient=0;
            $tot_vente=0;
            $quantite=0;

            $totqtiteliv=0;
            if (isset($_GET['recherchgen'])) {

              foreach ($panier->listeProduit() as $value) {?>

                <tr>

                  <td style="text-align: left;"><?= ucwords(strtolower($value->designation)); ?></td>

                  <td style="text-align: center;">
                    <table style="width:100%">
                      <tbody>
                        <tr><?php 

                          $totqtite=0;

                          $totstock=0;

                          
                          foreach ($panier->listeStock() as $valueS) {

                            $products = $DB->querys("SELECT quantite FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where productslist.id='{$value->id}' ORDER BY (designation)");

                            $quantite+=$products['quantite'];

                            $totqtite+=$products['quantite'];

                            $prodcmd=$DB->querys("SELECT sum(quantity-qtiteliv) as qtitenl from commande where id_produit='{$value->id}'");

                            $nonlivre=$prodcmd['qtitenl'];

                            ?>

                            <td width="80"><?=$products['quantite'];?></td><?php
                          }
                          $totqtiteliv+=$prodcmd['qtitenl'];?>
                          <td width="80"><?=$totqtite;?></td>

                          <td width="80"><?=$nonlivre;?></td>

                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr><?php
              }
            }?>

          </tbody><?php

          if (!isset($_GET['recherchgen'])) {
            /*?>

            <tfoot>

              <tr>
                <th colspan="1">TOTAL</th>
                <th style="text-align: center;">
                  <table style="width:100%;">
                    <tfoot>
                      <tr><?php

                        $qtites=0; 

                        foreach ($panier->listeStock() as $valueS) {

                          $products = $DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."`");

                          $qtites=$products['qtite'];?>

                          <th width="80"><?= number_format($qtites,0,',',' ') ; ?></th><?php
                        }?>
                        <th width="80"><?= number_format($quantite,0,',',' ') ; ?></th>

                        <th width="80"><?= number_format($totqtiteliv,0,',',' ') ; ?></th>
                      </tr>
                    </tfoot>
                  </table>                
                </th>

              </tr>

            </tfoot><?php 
            */
          }?>

        </table><?php

        
         
      }else{?>

      <table class="table table-hover table-bordered table-striped table-responsive text-center">

        <form class="form" action="stockgeneral.php" method="POST">

          <thead>

            <tr>
              <th colspan="3"><select class="form-select" type="text" name="design" onchange="this.form.submit()" ><?php 
                if (!empty($_SESSION['design'])) {?>
                  <option value="<?=$_SESSION['design'];?>"><?=$panier->nomCategorie($_SESSION['design'])?></option><?php
                }else{?>
                  <option></option><?php
                }

                foreach($panier->recherchestock() as $value){?>
                    <option value="<?=$value->id;?>"><?=$value->nom;?></option><?php
                }?></select>
              </th>

              <th colspan="2"><input class="form-control" type="text" name="designinp" onchange="this.form.submit()" >
              </th>

              <th colspan="4" height="30"><?="Stock du " .date('d/m/Y'); ?><a href="printstock.php?stock=<?=$_SESSION['idnomstock'];?>&type=<?="Carton";?>&carton" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>

                <a href="printstock.php?stock=<?=$_SESSION['idnomstock'];?>&type=<?="Paquet";?>&paquet" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>

                <a href="printstock.php?stock=<?=$_SESSION['idnomstock'];?>&type=<?="Détail";?>&detail" target="_blank" ><img  style=" margin-left: 20px; height: 20px; width: 20px;" src="css/img/pdf.jpg"></a>

                <a style="margin-left: 10px;"href="csv.php?stock=<?=$_SESSION['nomtab'];?>&type=<?="Carton";?>&carton" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/excel.jpg"></a> 
              </th>
            </tr>

            <tr>
              <th></th>
              <th>Désignation</th>
              <th>Qtité</th>
              <th>P.Revient</th>
              <th>P.Vente</th>
              <th>Péremption</th>       
              <th>Tot-Rev</th>        
              <th>Tot-Vente</th>
            </tr>

          </thead>
        </form>

        <tbody>

          <?php
          $tot_achat=0;
          $tot_revient=0;
          $tot_vente=0;
          $quantite=0;

          if (empty($_POST['designinp'])) {

            if (!empty($_SESSION['design'])) {

              $productst = $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id  FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where codecat='{$_SESSION['design']}' ORDER BY (designation)");
            }else{

              $productst = $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where quantite!=0 ORDER BY (designation)");
            }
          }else{

            if (!empty($_SESSION['designinp'])) {

              $productst = $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion,  `".$_SESSION['nomtab']."`.id as id  FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where designation LIKE ? or Marque LIKE ? ORDER BY (designation)", array("%".$_SESSION['designinp']."%", "%".$_SESSION['designinp']."%"));
            }else{

              $productst = $DB->query("SELECT designation, prix_achat, prix_revient, prix_vente, quantite, dateperemtion, `".$_SESSION['nomtab']."`.id as id FROM `".$_SESSION['nomtab']."` inner join productslist on idprod=productslist.id where quantite!=0 ORDER BY (designation) ");
            }
          }

          foreach ($productst as $key=> $product):

            if (empty($product->dateperemtion)) {
              $dateperemption=$product->dateperemtion;
            }else{

              $dateperemption=$product->dateperemtion;
            }

            $tot_achat+=$product->prix_achat*$product->quantite;
            $tot_revient+=$product->prix_revient*$product->quantite;
            $tot_vente+=$product->prix_vente*$product->quantite;
            $quantite+=$product->quantite;?>

            <tr>

              <form action="stockgeneral.php" method="POST">

                <th><?=$key+1;?></th>

                <td style="text-align: left;"><?= ucwords(strtolower($product->designation)); ?><input type="hidden" name="desig" value="<?= strtolower($product->designation); ?>" onchange="this.form.submit()" > <input type="hidden" name="id" value="<?= $product->id; ?>"></td>

                <td style="text-align: center;"><?= $product->quantite; ?><input type="hidden" name="qtite" value="<?= $product->quantite; ?>" onchange="this.form.submit()" style="width:90%;"></td>

                  <?php if ($products['statut']!="vendeur") {?><input class="form-control" type="hidden" name="pa" value="<?= number_format($product->prix_achat,0,',',' '); ?>" onchange="this.form.submit()"><?php }?>
                </td>

                <td><?php if ($products['statut']!="vendeur") {?><input class="form-control" type="text" name="pr" value="<?= number_format($product->prix_revient,0,',',' '); ?>" onchange="this.form.submit()"><?php }?></td>

                <td><?php if ($products['statut']!="vendeur") {?><input class="form-control" type="text" name="pv" value="<?= number_format($product->prix_vente,0,',',' '); ?>" onchange="this.form.submit()"><?php }?></td>

                <td><input class="form-control" type="date" name="perime" value="<?=$dateperemption;?>" onchange="this.form.submit()"></td>

                <td style="text-align: right; padding-right: 10px;"><?php if ($products['statut']!="vendeur") {?><?= number_format($product->prix_revient*$product->quantite,0,',',' ') ; ?> <?php }?></td>            

                <td style="text-align: right; padding-right: 10px;"><?php if ($products['statut']!="vendeur") {?><?= number_format($product->prix_vente*$product->quantite,0,',',' ') ; ?> <?php }?></td>

              </form>
            </tr>
              
          <?php endforeach ?>

        </tbody>

        <tfoot>

          <tr>
            <th colspan="2">TOTAL</th>
            <th style="padding-right: 10px;"><?= number_format($quantite,0,',',' ') ; ?> </th>
            <th colspan="3"></th>

             <th style="text-align: right; padding-right: 10px;"><?php if ($products['statut']!="vendeur") {?><?= number_format($tot_revient,0,',',' ') ; ?> <?php }?></th>

            <th style="text-align: right; padding-right: 10px;"><?php if ($products['statut']!="vendeur") {?><?= number_format($tot_vente,0,',',' ') ; ?> <?php }?></th>

          </tr>

        </tfoot>

      </table><?php
    }?>
  </div>
</div> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'rechercheproduit.php?stockgeneral',
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
      return(confirm('Attention, vous êtes sur le point de supprimer un produit!!! Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

    function focus(){
        document.getElementById('pointeur').focus();
    }

</script> 