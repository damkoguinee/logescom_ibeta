<?php
require 'headerv2.php';?>

<div class="container-fluid mt-3">
  <div class="row"><?php 

    require 'navpers.php';?>

    <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

      $colspan=sizeof($panier->monnaie);?>
      <table class="table table-hover table-bordered table-striped table-responsive text-center">


        <thead>

          <tr>

            <form class="form" method="GET"  action="bulletin.php?personnel">
              <th colspan="3">
                <input class="form-control" id="search-user" type="text" name="personnelsearch" placeholder="rechercher un client" />
                <div class="bg-danger" id="result-search"></div><?php 
                if (isset($_GET['personnelsearch'])) {
                  $_SESSION['reclient']=$_GET['personnelsearch'];
                }?>                
              </th>            
              <th colspan="<?=$colspan;?>" height="30">Compte Personnels
                <a class="btn btn-light fs-4" href="printcomptecategorie.php?comptepersonnel" target="_blank"><i class="fa-solid fa-file-pdf" style="color: #801443;"></i></a>
                <a class="btn btn-light fs-4" href="csv.php?comptepersonnel" target="_blank"><i class="fa-solid fa-file-excel" style="color: #27511f;"></i></a>
              </th>
            </form>
          </tr>

          <tr>
            <th>N°</th>
            <th>Nom</th><?php 
            foreach ($panier->monnaie as $valuem) {?>
              <th>Solde Compte <?=strtoupper($valuem);?></th><?php 
            }?>
          </tr>

        </thead>

        <tbody><?php 
          $cumulmontantgnf=0;
          $cumulmontanteu=0;
          $cumulmontantus=0;
          $cumulmontantcfa=0;

          $type1='personnel';

          $prodclient = $DB->query("SELECT *FROM login where type='{$type1}' and lieuvente='{$_SESSION['lieuvente']}'");         
          


          foreach ($prodclient as $key => $value){
            $idpers='pers'.$value->id;
            $id=$value->identifiant;?>

            <tr>

              <td><?=$key+1; ?></td>

              <td style="text-align:left;"><?= $value->nom; ?></td> <?php

              foreach ($panier->monnaie as $valuem) { 
                $type='personnel';       

                $products= $DB->querys("SELECT sum(montant) as montant, devise, nom_client FROM bulletin where nom_client='{$id}' and devise='{$valuem}' and type='{$type}' ");

                if ($products['devise']=='gnf') {
                  $cumulmontantgnf+=$products['montant'];
                  $devise='gnf';
                }

                if ($products['devise']=='eu') {
                  $cumulmontanteu+=$products['montant'];
                  $devise='eu';
                }

                if ($products['devise']=='us') {
                  $cumulmontantus+=$products['montant'];
                  $devise='us';
                }

                if ($products['devise']=='cfa') {
                  $cumulmontantcfa+=$products['montant'];
                  $devise='cfa';
                }

                if ($products['devise']!='gnf' and $products['devise']!='eu' and $products['devise']!='us' and $products['devise']!='cfa') {
                  $devise='gnf';
                }

                if ($products['montant']>0) {
                  $color='danger';
                  $montant=$products['montant'];
                }else{

                  $color='success';
                  $montant=-$products['montant'];

                }?>

                <td class="bg-<?=$color;?>"><a class="btn btn-<?=$color;?> text-white" href="bilanpersonnel.php?id=<?=$id;?>&bclient=<?=$products['nom_client'];?>&devise=<?=$devise;?>"><?= number_format($montant,0,',',' '); ?></a></td><?php 
              }?>


            </tr><?php

          }?>

        </tbody><?php 

        if ($cumulmontantgnf>0) {

          $cmontantgnf=$cumulmontantgnf;
        }else{
          $cmontantgnf=-$cumulmontantgnf;

        }

        if ($cumulmontanteu>0) {
          
          $cmontanteu=$cumulmontanteu;
        }else{
          $cmontanteu=-$cumulmontanteu;

        }

        if ($cumulmontantus>0) {
          
          $cmontantus=$cumulmontantus;
        }else{
          $cmontantus=-$cumulmontantus;

        }

        if ($cumulmontantcfa>0) {
          
          $cmontantcfa=$cumulmontantcfa;
        }else{
          $cmontantcfa=-$cumulmontantcfa;

        }?>

        <tfoot>
            <tr>
              <th colspan="2">Solde</th>

              <th class="bg-<?=$panier->colorb($cumulmontantgnf);?>"><?= number_format($cmontantgnf,0,',',' ');?></th>

              <th class="bg-<?=$panier->colorb($cumulmontanteu);?>"><?= number_format($cmontanteu,0,',',' ');?></th>

              <th class="bg-<?=$panier->colorb($cumulmontantus);?>"><?= number_format($cmontantus,0,',',' ');?></th>

              <th class="bg-<?=$panier->colorb($cumulmontantgnf);?>"><?= number_format($cmontantcfa,0,',',' ');?></th>            
            </tr>
        </tfoot>

      </table>
    </div>
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
                    url: 'recherche_utilisateur.php?compteclient',
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

