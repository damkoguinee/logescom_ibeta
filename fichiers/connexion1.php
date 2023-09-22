<?php
require '_header.php';
$_SESSION['pseudo'] = $_POST['pseudo'];
$_etat = 'connecté'; 
$bdd="paiemode"; 

$DB->insert("CREATE TABLE IF NOT EXISTS `".$bdd."`(
`id` int(11) NOT NULL AUTO_INCREMENT,
`money` VARCHAR(50) DEFAULT 'guinee',
`code` VARCHAR(50) DEFAULT 'gnf',
`etat` VARCHAR(50) DEFAULT 'ok',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");
$code="gnf";
$prodcredit= $DB->querys("SELECT *FROM paiemode where code='{$code}' ");
if (empty($prodcredit['id'])) {
	$DB->insert("INSERT INTO paiemode (money, code)VALUES(?, ?)", array("guinee", $code));
}

$codeus="us";
$prodcredit= $DB->querys("SELECT *FROM paiemode where code='{$codeus}' ");
if (empty($prodcredit['id'])) {
	$DB->insert("INSERT INTO paiemode (money, code)VALUES(?, ?)", array("dollar", $codeus));
}

$codeaed="aed";
$prodcredit= $DB->querys("SELECT *FROM paiemode where code='{$codeaed}' ");
if (empty($prodcredit['id'])) {
	$DB->insert("INSERT INTO paiemode (money, code)VALUES(?, ?)", array("dirham", $codeaed));
}

$codeeu="eu";
$prodcredit= $DB->querys("SELECT *FROM paiemode where code='{$codeeu}' ");
if (empty($prodcredit['id'])) {
	$DB->insert("INSERT INTO paiemode (money, code)VALUES(?, ?)", array("euro", $codeeu));
}


	
$connexion = $DB->querys('SELECT * FROM login WHERE pseudo =:Pseudo', 
	array('Pseudo'=>$_POST['pseudo']));

$personnel = $DB->querys('SELECT * FROM personnel WHERE pseudo =:Pseudo', 
	array('Pseudo'=>$_POST['pseudo']));

$client = $DB->querys('SELECT * FROM client WHERE telephone =?', 
	array($connexion['telephone']));

$etab=$DB->querys('SELECT *from adresse');

$_SESSION['etab']=$etab['nom_mag'];
$_SESSION['init']=$etab['initial'];

$password=password_verify($_POST['mdp'], $connexion['mdp']);

$_SESSION['type']=$connexion['type'];

$_SESSION['lieuvente']=$connexion['lieuvente'];
$_SESSION['lieuventevers']=$connexion['lieuvente'];
$_SESSION['idpseudo']=$connexion['id'];
$_SESSION['idcpseudo']=$client['id'];
$_SESSION['statut']=$connexion['statut'];
$_SESSION['level']=$connexion['level'];

$caisse = $DB->querys('SELECT * FROM nombanque WHERE lieuvente =? and type=?', 
	array($_SESSION['lieuvente'], 'caisse'));

$_SESSION['caisse']=$caisse['id'];


if (empty($connexion)){
	header('Location:form_connexion.php');
}else{

	if (!$password){
		header('Location:form_connexion.php');

	}else{

		if ($_SESSION['type']=='client' or $_SESSION['type']=='clientf') {

			header('Location: accueilclient.php?client');

		}else{

			if ($_SESSION['level']>6) {
				header('Location: boutique.php');
			}else{

				header('Location: choix.php');
			}

		}

		
	}
}?>