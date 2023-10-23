<?php require 'headerv2.php';

    $DB->insert(" CREATE TABLE IF NOT EXISTS `validpaie_cash` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `id_produit` int(50) DEFAULT NULL,
        `codebvc` varchar(50) DEFAULT NULL,
        `quantite` float NOT NULL,
        `pvente` double DEFAULT NULL,
        `pseudov` varchar(50) DEFAULT NULL,
        `datecmd` datetime DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ");

    $DB->insert(" CREATE TABLE IF NOT EXISTS `validvente_cash` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `remise` double DEFAULT '0',
        `montantpgnf` double DEFAULT '0',
        `montantpeu` double DEFAULT '0',
        `montantpus` double DEFAULT '0',
        `montantpcfa` double DEFAULT '0',
        `virement` double DEFAULT '0',
        `cheque` double DEFAULT '0',
        `numcheque` varchar(50) DEFAULT NULL,
        `banqcheque` varchar(50) DEFAULT NULL,
        `pseudop` varchar(50) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8; ");

    $nomtab=$panier->nomStock($_SESSION['lieuvente'])[1];

    if (isset($_SESSION['pseudo'])){?>    

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12 col-md-12">

                    <?php require 'paniercash.php'; ?>              
                    
                </div>

            </div>
        </div><?php  
        
    }else{

        header("Location: form_connexion.php");

    }?>
    
</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $('#products').keyup(function(){
            $('#result-products').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_products.php?products_vente_cash',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-products').append(data);
                        }else{
                          document.getElementById('result-products').innerHTML = "<div style='font-size: 20px; text-align: center; margin-top: 10px'>Aucun utilisateur</div>"
                        }
                    }
                })
            }
      
        });
    });

    $(document).ready(function(){
        $('#search-user').keyup(function(){
            $('#result-search').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?indexcash',
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

    $(document).ready(function(){
        $('#search-userCom').keyup(function(){
            $('#result-searchCom').html("");

            var utilisateur = $(this).val();

            if (utilisateur!='') {
                $.ajax({
                    type: 'GET',
                    url: 'recherche_utilisateur.php?clientComcash',
                    data: 'user=' + encodeURIComponent(utilisateur),
                    success: function(data){
                        if(data != ""){
                          $('#result-searchCom').append(data);
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

