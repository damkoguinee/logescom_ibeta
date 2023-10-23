<?php
require '_header.php';
$type="en_gros";

if (isset($_GET['user'])) {
	$user=(string) trim($_GET['user']);
    $req = $DB->query("SELECT * FROM stock1 inner join productslist on idprod=productslist.id  WHERE  designation LIKE ? and productslist.type LIKE ? LIMIT 20 ",array("%".$user."%", $type));

	if (isset($_GET['products_vente'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="index.php?desig=<?= $value->Marque;?>&idc=<?= $value->id;?>&pv=<?= $value->prix_vente;?>"><div><?=$value->Marque;?></div></a><?php
		}
	}elseif (isset($_GET['products_vente_cash'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="indexcash.php?desig=<?= $value->Marque;?>&idc=<?= $value->id;?>&pv=<?= $value->prix_vente;?>"><div><?=$value->Marque;?></div></a><?php
		}
	}
}