<?php require 'headerv2.php';

if (isset($_SESSION['pseudo'])) {

    $pseudo=$_SESSION['pseudo'];?>
    <div class="container-fluid">
        <div class="row"><?php
            require 'navventedirect.php';?>
            <div class="col col-sm-12 col-md-10" style="overflow: auto;"><?php
                if ($_SESSION['level']>=3) {
                
                    if (!isset($_POST['j1'])) {

                        $_SESSION['date']=date("Ymd");  
                        $dates = $_SESSION['date'];
                        $dates = new DateTime( $dates );
                        $dates = $dates->format('Ymd'); 
                        $_SESSION['date']=$dates;
                        $_SESSION['date1']=$dates;
                        $_SESSION['date2']=$dates;
                        $_SESSION['dates1']=$dates; 
                  
                        $_SESSION['lieuvented']=$_SESSION['lieuvente'];
                  
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
                  
                  
                    if (isset($_POST['j2'])) {
                
                    $datenormale='entre le '.$_SESSION['dates1'].' et le '.$_SESSION['dates2'];
                
                    }else{
                
                    $datenormale=(new DateTime($dates))->format('d/m/Y');
                    }?>

                    <table class="table table-bordered table-hover table-striped ">

                        <thead class="sticky-top bg-light text-center">
                            <tr>
                                <th class="legende" colspan="10" height="30"><?="Ventes directs " .$datenormale ?>
                                <!-- <a class="" href="csv.php?vente" target="_blank"><img  style="height: 20px; width: 20px;" src="css/img/excel.jpg"></a> -->
                                </th>
                            </tr>
                            <tr>
                            <th colspan="9">
                                <div class="d-flex justify-content-between">                   
                                <form class="form d-flex justify-content-between" method="POST"><?php

                                    if (isset($_POST['j1'])) {?>

                                    <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()" value="<?=$_POST['j1'];?>"><?php

                                    }else{?>

                                    <input class="form-control" type = "date" name = "j1" onchange="this.form.submit()"><?php

                                    }

                                    if (isset($_POST['j2'])) {?>

                                    <input class="form-control" type = "date" name = "j2" value="<?=$_POST['j2'];?>" onchange="this.form.submit()"><?php

                                    }else{?>

                                    <input class="form-control" type = "date" name = "j2" onchange="this.form.submit()"><?php

                                    }?>
                                </form>
                                <!-- <form class="form" method="POST">
                                    <input class="form-control" id="search-user" type="text" name="clientsearch" placeholder="rechercher un client" />
                                    <div class="bg-danger" id="result-search"></div>
                                </form>  -->
                                </div>
                            </th>                 
                            </tr>

                            <tr>
                                <th>N°</th>
                                <th>Date</th>
                                <th>Nom</th>
                                <th>Référence</th>
                                <th>Qtité</th>
                                <th>P.Revient</th>
                                <th>P.Vente</th>
                                <th>P.Total</th>          
                                <th>Bénéfice</th>
                            </tr>
                        </thead>

                        <tbody><?php 
                            $typevente="vente cash";
                            $products =$DB->query("SELECT commande.num_cmd as num_cmd, Marque as designation, quantity, commande.prix_vente as prix_vente,commande.prix_revient as prix_revient, commande.prix_achat as pa, etat, typeclient, nom_client as clientvip, DATE_FORMAT(date_cmd,  \"%d/%m/%Y\")AS DateTemps FROM productslist inner join commande on commande.id_produit=productslist.id inner join payement on payement.num_cmd=commande.num_cmd left join client on client.id=id_client WHERE  type_vente='{$typevente}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >= '{$_SESSION['date1']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$_SESSION['date2']}' order by(payement.id) desc ");

                            $cumulmontantotc=0;
                            $cumulrevient=0;
                            $cumulpa=0;
                            foreach ($products as $key=> $product ){
                                $client=$product->clientvip;
                                $cumulmontantotc+=$product->prix_vente*$product->quantity;
                                $cumulrevient+=$product->prix_revient*$product->quantity;
                                $cumulpa+=$product->pa*$product->quantity; ?>
                                <tr>
                                    <td><?=$key+1;?> <a class="btn btn-info" href="recherche.php?recreditc=<?=$product->num_cmd;?>"><i class="fa-solid fa-file-pdf"></i> <?= $product->num_cmd; ?></a></td>
                                    <td><?= $product->DateTemps; ?></td>
                                    <td><?= $client; ?></td>
                                    <td><?= $product->designation; ?></td>
                                    <td class="text-center"><?= $product->quantity; ?></td>
                                    <td class="text-end"  ><?=$configuration->formatNombre($product->prix_revient); ?></td>
                                    <td class="text-end"  ><?=$configuration->formatNombre($product->prix_vente); ?></td>                                    
                                    <td class="text-end"  ><?=$configuration->formatNombre($product->prix_vente*$product->quantity); ?></td>                                    
                                    <td class="text-end"  ><?=$configuration->formatNombre($product->prix_vente*$product->quantity-$product->prix_revient*$product->quantity); ?></td>
                                </tr><?php 

                            }?>

                        </tbody>

                        <tfoot>
                            <tr>
                            <th colspan="5"></th>
                            <th class="text-end"><?=$configuration->formatNombre($cumulrevient);?></th>

                            <th class="text-end"><?=$configuration->formatNombre($cumulpa);?></th>

                            <th class="text-end"><?=$configuration->formatNombre($cumulmontantotc);?></th>
                            
                            <th class="text-end"><?=$configuration->formatNombre($cumulmontantotc-$cumulrevient);?></th>
                            </tr>
                        </tfoot>

                    </table><?php
                
                }else{

                    echo "VOUS N'AVEZ PAS LES AUTORISATIONS REQUISES";

                }?> 
            </div>
        </div>
    </div><?php 

}

require 'footer.php';?> 
    
</body>

</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><?php 


