<?php $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$lieuvente}' ");

  $total = 0;
  $total_tva = 0; ?>



  <table style="margin:auto; width: 100%;  text-align: center;color: black; background: white; line-height: 5mm;" >

    <tr>
      <th style="font-weight: bold;color:#185c8d; font-size: 22px; padding: 5px; padding-left: 0px;"><?php 

      if ($adress['initial']=='ibe') {?>
        <img src="css/img/logo.jpg" width="100" height="80"><?=$adress['nom_mag'];?><?php

      }else{?>
        <img src="css/img/logo.jpg" width="0" height="0"><?php echo $adress['nom_mag'];
      }?></th>
    </tr>

    <tr>
      <td style="font-size: 14px;"><?=$adress['type_mag']; ?></td>
    </tr>

    <tr>
      <td style="font-size: 14px;"><?=$adress['adresse']; ?></td>
    </tr>
  </table>

  <div style="margin-left: 500px; margin-top: 15px;"><?php

    if ($idc!=0) {?>

      <div><?=$panier->adClient($_SESSION['reclient'])[0]; ?></div>
      <div><?='Téléphone: '.$panier->adClient($_SESSION['reclient'])[1]; ?></div>
      <div><?='Adresse: '.$panier->adClient($_SESSION['reclient'])[2]; ?></div><?php

    }else{?>

      <div><?=ucwords(strtolower($_SESSION['reclient'])); ?></div><?php

    }?>
  </div>