<?php $adress = $DB->querys("SELECT * FROM adresse where lieuvente='{$_SESSION['lieuvente']}'");

  $total = 0;
  $total_tva = 0; ?>

  <div class="ticket">

    <table style="margin:auto; text-align: center;color: black; background: white;" >

      <tr>
        <th style="font-weight: bold;color:#185c8d; font-size: 22px; padding: 5px"><?php 

        if ($adress['initial']=='ibe') {?>
          <img src="css/img/logo.jpg" width="100" height="80"><?=$adress['nom_mag'];?><?php

        }else{?>
          <img src="css/img/logo.jpg" width="0" height="0"><?php echo $adress['nom_mag'];
        }?></th>
      </tr>

      <tr><td style="font-size: 14px;"><?=ucwords(strtolower($adress['type_mag'])); ?></td></tr>

      <tr><td style="font-size: 14px;"><?=ucwords(strtolower($adress['adresse'])); ?><br/> <br/></td></tr>

    </table>