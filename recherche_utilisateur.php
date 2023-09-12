<?php
require '_header.php';

if (isset($_GET['user'])) {
	$user=(string) trim($_GET['user']);
	if (isset($_GET['personnel']) or isset($_GET['persretrait']) or isset($_GET['persremboursement'])) {
		$personnel="personnel";
		
		$req=$DB->query('SELECT identifiant as id, nom as nom_client FROM login where nom LIKE ? and type LIKE ? and lieuvente LIKE? LIMIT 10',array("%".$user."%", $personnel, $_SESSION['lieuvente']));

	}else{

		if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and positionc LIKE? LIMIT 10',array("%".$user."%", $_SESSION['lieuvente']));

		}else{

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? LIMIT 10',array("%".$user."%"));

		}
	}

	if (isset($_GET['decclient'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="dec.php?searchclient=<?=$value->id;?>&ajout"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientdec'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="dec.php?searchversclient=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientcheq'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="cheque.php?searchclient=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientliv'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="livraisonachat.php?searchversclient=<?=$value->id;?>&livre"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientnonliv'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="livraisonachat.php?searchnlclient=<?=$value->id;?>&nonlivre"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['versclient'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="versement.php?searchclientvers=<?=$value->id;?>&ajout"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientvers'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="versement.php?searchversclient=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientfact'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="facturations.php?clientsearch=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientproformat'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="proformatliste.php?clientsearch=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['compteclient'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="bulletin.php?clientsearch=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientsearch'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="client.php?clientsearch=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientgestionsearch'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="clientgestionlist.php?clientsearch=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['fournisseursearch'])) {

		$type='fournisseur';

		if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and typeclient LIKE ? and positionc LIKE? LIMIT 10',array("%".$user."%", $type, $_SESSION['lieuvente']));

		}else{

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and typeclient LIKE ? LIMIT 10',array("%".$user."%", $type));

		}

		

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="client.php?clientsearch=<?=$value->id;?>&fournisseur"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['autressearch'])) {

		$type='fournisseur';

		if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and positionc LIKE? LIMIT 10',array("%".$user."%", $_SESSION['lieuvente']));

		}else{

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? LIMIT 10',array("%".$user."%"));

		}

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="client.php?clientsearch=<?=$value->id;?>&autres"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['clientrest'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="restriction.php?clientsearch=<?=$value->id;?>&client"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['comptefournisseur'])) {
		$type='fournisseur';

		if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and typeclient LIKE ? and positionc LIKE? LIMIT 10',array("%".$user."%", $type, $_SESSION['lieuvente']));

		}else{

			$req=$DB->query('SELECT *FROM client where nom_client LIKE ? and typeclient LIKE ? LIMIT 10',array("%".$user."%", $type));

		}

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="bulletin.php?fournisseursearch=<?=$value->id;?>&fournisseur"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['modifvente'])) {
		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="modifventeprod.php?clientvip=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif(isset($_GET['indexcash'])){
		foreach ($req as $key => $value) {?>
	
			<a style="font-weight: bold; color: white;" href="indexcash.php?clientvip=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
		
	}elseif(isset($_GET['clientCom'])){
		foreach ($req as $key => $value) {?>
	
			<a style="font-weight: bold; color: white;" href="index.php?clientCom=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
		
	}elseif(isset($_GET['clientComUpdate'])){
		foreach ($req as $key => $value) {?>
	
			<a style="font-weight: bold; color: white;" href="modifventeprod.php?clientCom=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
		
	}elseif(isset($_GET['clientComcash'])){
		foreach ($req as $key => $value) {?>
	
			<a style="font-weight: bold; color: white;" href="indexcash.php?clientCom=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
		
	}elseif(isset($_GET['venteCommission'])){
		foreach ($req as $key => $value) {?>
	
			<a style="font-weight: bold; color: white;" href="ventecommission.php?clientCom=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
		
	}elseif (isset($_GET['personnel'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="decpersonnel.php?searchclientvers=<?=$value->id;?>&ajoutdep"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['persretrait'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="persretrait.php?searchclientvers=<?=$value->id;?>&ajoutdep"><div><?=$value->nom_client;?></div></a><?php
		}
	}elseif (isset($_GET['persremboursement'])) {

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="persremboursement.php?searchclientvers=<?=$value->id;?>&ajoutdep"><div><?=$value->nom_client;?></div></a><?php
		}
	}else{

		foreach ($req as $key => $value) {?>

			<a style="font-weight: bold; color: white;" href="index.php?clientvip=<?=$value->id;?>"><div><?=$value->nom_client;?></div></a><?php
		}
	}
}

//echo "string";