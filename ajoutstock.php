<?php
require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

  $pseudo=$_SESSION['pseudo'];
  $products = $DB->querys('SELECT statut, level FROM login WHERE pseudo= :PSEUDO',array('PSEUDO'=>$pseudo));

  if ($products['level']>=3) {

    if(isset($_GET["delete"])){

      $numero=$_GET["delete"];

      $DB->delete("DELETE FROM stock WHERE id = ?", array($numero));

      $DB->delete("DROP TABLE `".$_GET['stock']."`");
    }?>

    <div class="container-fluid mt-3">
      <div class="row"><?php 

        require 'navstock.php';?>

        <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php

          if(isset($_GET["ajout"])){?>

            <form class="form" method="POST" action="ajoutstock.php">

              <fieldset><legend>Ajouter un Stock</legend>

                <div class="mb-1">
                  <label class="form-label">Nom*</label>
                  <input class="form-control" type="text" name="nom" maxlength="150" required=""/>
                </div>

                <div class="mb-1">
                  <label class="form-label">Type*</label>
                  <select name="type" class="form-select" required>
                    <option value="vente">Lieu de vente</option>
                    <option value="stock">Stock</option>
                  </select>
                </div>

                <div class="mb-1">
                  <label class="form-label">Responsable*</label>
                  <select class="form-select" type="text" name="resp" required="">
                    <option></option><?php 
                    foreach ($panier->personnel() as $value) {?>

                      <option value="<?=$value->id;?>"><?=ucwords($value->nom);?></option><?php 
                    }?>
                  </select>
                </div>

                <div class="mb-1">

                  <label class="form-label">Emplacement*</label>
                  <select class="form-select" type="text" name="position" required="">
                    <option></option><?php 
                    foreach ($panier->position as $value) {?>

                      <option value="<?=$value;?>"><?=ucwords($value);?></option><?php 
                    }?>
                  </select>
                </div>

                <div class="mb-1">
                  <label class="form-label">Surface (m²)</label>
                  <input class="form-control" type="text" name="surface"/> 
                </div>

                <div class="mb-1">

                  <label class="form-label">Nbre de Pièces</label>
                  <select class="form-select" type="text" name="nbrep"><?php
                    $i=1;
                    while ( $i<= 5) {?>

                      <option value="<?=$i;?>"><?=$i;?></option><?php

                      $i=$i;

                      $i++;
                    }?>
                  </select>
                </div>

                <div class="mb-1">

                  <label class="form-label">Adresse*</label>
                  <input class="form-control" type="text" name="adresse" required=""/>
                </div>

                <button class="btn btn-primary" type="submit" name="valid" onclick="return alerteV();">Valider</button>

              </fieldset>
            </form><?php
          } 


          if (isset($_POST['valid'])) {
            
            if($_POST['nom']!="" and $_POST['resp']!="" and $_POST['position']!=""){

              $nom=$panier->h($_POST['nom']);
              $type=$panier->h($_POST['type']);
              $resp=$panier->h($_POST['resp']);
              $position=$panier->h($_POST['position']);
              $surface=$panier->h($_POST['surface']);
              $nbrep=$panier->h($_POST['nbrep']);
              $adresse=$panier->h($_POST['adresse']);

              $nb=$DB->querys('SELECT nomstock from stock where (nomstock=:nom)', array('nom'=>$nom));

              if(!empty($nb)){?>
                <div class="alert alert-warning">Ce nom existe déja</div><?php

              }else{
                $searchString = " ";
                $replaceString = "";
                $originalString = $nom; 
                 
                $motsansespace= str_replace($searchString, $replaceString, $originalString); 
                $bdd=$motsansespace;

                $DB->insert('INSERT INTO stock(nomstock, type, nombdd, coderesp, position, surface, nbrepiece, adresse) values(?, ?, ?, ?, ?, ?, ?, ?)', array($nom, $type, $bdd, $resp, $position, $surface, $nbrep, $adresse));

                $DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `codeb` varchar(100) DEFAULT NULL,
                  `idprod` int(10) NOT NULL,
                  `prix_achat` double DEFAULT '0',
                  `prix_revient` double DEFAULT '0',
                  `prix_vente` double DEFAULT '0',
                  `type` varchar(20) DEFAULT NULL,
                  `quantite` float DEFAULT '0',
                  `qtiteintd` int(11) DEFAULT '0',
                  `qtiteintp` int(11) DEFAULT '0',
                  `nbrevente` float DEFAULT '0',
                  `dateperemtion` date DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");

                foreach ($panier->listeProduit() as $value) {              

                  $DB->insert("INSERT INTO `".$bdd."` (codeb, idprod, prix_achat, prix_revient, prix_vente, type, qtiteintd, qtiteintp) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", array($value->codeb, $value->id, 0, 0, $value->pventel, $value->type, $value->qtiteint, $value->qtiteintp));

                }?>  

                <div class="alert alert-success">Stock ajouté avec succèe!!!</div><?php
              }

            }else{?>  

              <div class="alert alert-danger">Remplissez les champs vides</div><?php
            }
          }

          if (!isset($_GET['ajout'])) {

            $prodm=$DB->query("SELECT stock.id as id, nomstock, nombdd, nom, position, surface, nbrepiece, adresse from stock inner join login on login.id=coderesp where stock.lieuvente='{$_SESSION['lieuvente']}'  order by(nomstock)");?>
              
            <table class="table table-hover table-bordered table-striped table-responsive text-center">
              <thead>

                <tr>
                  
                  <th colspan="5">Liste des Stocks et des Magasins </th>
                  <th colspan="4">
                    <a class="btn btn-info" href="stockgeneral1.php?stockgeneral=<?='stock general';?>&nomstock=<?=0;?>&recherche=<?=0;?>">Voir Stock Général</a><?php if ($_SESSION['type']=="admin") {?>

                    <a href="ajoutstock.php?ajout" class="btn btn-info">Ajouter un Stock</a><?php }?>
                  </th>
                </tr>

                <tr>
                  <th>N°</th>
                  <th>Nom</th>
                  <th>Responsable</th>
                  <th>Position</th>
                  <th>Surafce</th>
                  <th>N.Pièces</th>
                  <th>Adresse</th>
                  <th></th>
                  <th></th>
                </tr>

              </thead>

              <tbody><?php

                if (empty($prodm)) {
                  # code...
                }else{
                  $cumultranche=0;
                  foreach ($prodm as $key=> $formation) {?>

                  <tr>
                    <td><?=$key+1;?></td>

                    <td style="text-align: left"><?=ucwords(strtolower($formation->nomstock));?></td>

                    <td style="text-align: left"><?=ucwords($formation->nom);?></td>

                    <td style="text-align: left"><?=ucwords($formation->position);?></td>

                    <td><?=$formation->surface;?> m²</td>

                    <td><?=$formation->nbrepiece;?></td>

                    <td><?=ucwords($formation->adresse);?></td>

                    <td>
                      <a class="btn btn-info" href="stockgeneral.php?nomstock=<?=$formation->id;?>">Consulter</a>
                    </td>

                    <td colspan="1">

                      <?php if ($products['statut']=='adminnnn') {?>
                        
                        <a class="btn btn-danger" href="ajoutstock.php?stock=<?=$formation->nombdd;?>&delete=<?=$formation->id;?>" onclick="return alerteS();">Supprimer</a><?php 
                      }?>
                    </td>

                  </tr><?php
                }

              }?>          
            </tbody>

                
          </table><?php
        }?>

      </div>
    </div>
  </div><?php

  require_once('footer.php');


}else{?>

  <div class="alertes">VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES</div><?php
}

}else{

}?>

<script type="text/javascript">
    function alerteS(){
        return(confirm('Valider la suppression'));
    }

    function alerteV(){
        return(confirm('Confirmer la validation'));
    }

</script>
</body>

</html>
