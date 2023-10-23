<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

    $bdd='inventaire';   

    $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
        `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_inv` varchar(50) DEFAULT NULL,
  `id_prod_inv` int(10) DEFAULT NULL,
  `qtite_init` float DEFAULT NULL,
  `qtite_inv` float DEFAULT NULL,
  `balance_inv` float DEFAULT NULL,
  `stock_inv` varchar(150) DEFAULT NULL,
  `idpers_inv` varchar(150) DEFAULT NULL,
  `coment_inv` varchar(150) DEFAULT NULL,
  `etat_inv` varchar(15) NOT NULL DEFAULT 'nok',
  `dateop` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");

    $bdd='inventaireliste';   

    $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
        `id` int(11) NOT NULL AUTO_INCREMENT,
    `lieuvente_inv` int(11) DEFAULT NULL,
    `coment_inv` varchar(150) DEFAULT NULL,
    `date_inv` date DEFAULT NULL,
    `dateop` datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");

    //require 'navdec.php'; 
  

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


        if (isset($_GET['deleteret'])) {

            $DB->delete("DELETE from inventaireliste where id='{$_GET['deleteret']}'");?>

            <div class="alert alert-success">Suppression reussie!!</div><?php 
        }


        if (isset($_POST["valid"])) {

            if (empty($_POST["coment"]) or empty($_POST["date_inv"])) {?>

                <div class="alert alert-warning">Les Champs sont vides</div><?php

            }else{
                $coment=$panier->h($_POST['coment']); 
                $dateop=$_POST['date_inv'];

                $DB->insert('INSERT INTO inventaireliste (coment_inv, lieuvente_inv, date_inv) VALUES(?, ?, ?)', array($coment, $_SESSION['lieuvente'], $dateop));?>

                <div class="alert alert-success">Inventaire enregistrée avec succèe!!!</div><?php 
            }

        }

        
        if (!isset($_POST['valid'])) {
            if (isset($_GET['ajout'])) {?>
                <form class="form my-2" method="POST">

                    <div class="row mb-1">

                        <div class="col-sm-12 col-md-4">
                            <label class="form-label">Commenatiare*</label>
                            <input class="form-control" type="text"  name="coment" required="">
                        </div>
                    </div>

                    <div class="row mb-1">
                        <label class="form-label">Date inventaire*</label>
                        <input class="form-control" type="date" name="date_inv" required>                
                    </div>
                    
                    <button class="btn btn-primary"  type="submit" name="valid" onclick="return alerteV();">Valider</button>
                </form><?php
            }
        }?>

        <div style="overflow: auto">

            <table class="table table-hover table-bordered table-striped table-responsive text-center align-middle">
            <thead class="sticky-top bg-secondary text-center">
                <tr>
                    <th colspan="6">
                        <div class="d-flex justify-content-between">
                            Liste des inventaires
                            <a class="btn btn-warning" href="?ajout">Enregistrer un inventaire</a>
                        </div>
                    </th>
                </tr>

                <tr>
                <th>N°</th>
                <th>Date</th>
                <th>Commentaire</th> 
                <th colspan="3">Actions</th>
                </tr>

            </thead>

            <tbody><?php

                $products= $DB->query("SELECT *FROM inventaireliste  WHERE lieuvente_inv='{$_SESSION['lieuvente']}' order by id desc ");        
                foreach ($products as $keyv=> $product ){
                    
                    $prodverif= $DB->querys("SELECT *FROM inventaire  WHERE num_inv='{$product->id}' ");?>

                <tr>
                    <td><?= $keyv+1; ?></td>
                    <td><?=(new DateTime($product->date_inv))->format("d/m/Y"); ?></td>
                    <td><?= strtoupper($product->coment_inv); ?></td>
                    <td><a onclick="return alerteV();" class="btn btn-success" href="inventaire.php?op_inv=<?=$product->id;?>&inventaire_form">Opération</a></td>

                    <td><a class="btn btn-warning" onclick="return alerteV();" href="?update=<?=$product->id;?>">Modifier</a></td>

                    <td><?php if ($_SESSION['level']>=6 and empty($prodverif['id'])){?><a class="btn btn-danger" onclick="return alerteS();" href="?deleteret=<?=$product->id;?>">Annuler</a><?php };?></td>
                    
                </tr><?php 
                }?>

            </tbody>

            </table>
        </div><?php 

      

    }else{

      echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

    }

  }else{

  }
  
  require 'footer.php';?>
    
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
