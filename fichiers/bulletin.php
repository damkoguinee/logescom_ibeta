<?php
require 'header.php';
if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];

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

    $_SESSION['date1']=$_POST['j1'];
    $_SESSION['date1'] = new DateTime($_SESSION['date1']);
    $_SESSION['date1'] = $_SESSION['date1']->format('Ymd');
    
    $_SESSION['date2']=$_POST['j2'];
    $_SESSION['date2'] = new DateTime($_SESSION['date2']);
    $_SESSION['date2'] = $_SESSION['date2']->format('Ymd');

    $_SESSION['dates1']=$_SESSION['date1'];
    $_SESSION['dates2']=$_SESSION['date2'];   
  }

  if ($products['level']>=3) {

    require 'navbulletin.php';

    if (isset($_GET['client']) or isset($_GET['clientsearch'])) {
      
      require 'compteclient.php';

    }elseif (isset($_GET['fournisseurs']) or isset($_GET['fournisseursearch'])) {
      
      require 'comptefournisseur.php';

    }elseif (isset($_GET['transitaire']) or isset($_GET['autressearch'])) {
      
      require 'comptetransitaire.php';

    }elseif (isset($_GET['frais']) or isset($_GET['fraissearch'])) {
      
      require 'comptefrais.php';

    }elseif (isset($_GET['autres']) or isset($_GET['autressearch'])) {
      
      require 'compteautres.php';

    }elseif (isset($_GET['personnel']) or isset($_GET['personnelsearch'])) {
      
      require 'comptepersonnel.php';

    }
  

  }else{

    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

  }

}else{

}?>
    
</body>

</html>


<script type="text/javascript">
  window.onload = function() { 
        for(var i = 0, l = document.getElementsByTagName('input').length; i < l; i++) { 
            if(document.getElementsByTagName('input').item(i).type == 'text') { 
                document.getElementsByTagName('input').item(i).setAttribute('autocomplete', 'off'); 
            }; 
        }; 
    };
</script>


