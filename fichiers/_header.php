<?php	
	require 'db.class.php';
	require 'configurationClass.php';
	require 'panier.class.php';
	require 'commandeClass.php';
	require 'caisseClass.php';
	require 'insertClass.php';
	$DB = new DB();
	$configuration = new configuration($DB);
	$panier = new panier($DB);
	$commande = new commande($DB);
	$caisse =new caisse($DB);
	$insert =new InsertInto($DB);
?>