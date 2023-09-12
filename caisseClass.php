<?php 

class caisse {
    private $DB;
    public function __construct($DB){
        $this->DB=$DB;
    }

    public function nomBoutique(){// permet de recuperer la liste des caisses
		$type="vente";

        if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

            $prod=$this->DB->query("SELECT *FROM stock where type='{$type}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        }else{
            $prod=$this->DB->query("SELECT *FROM stock where type='{$type}' order by(id)");
        }

        return $prod;

    }

    public function caisseList(){// Permet de recuperer un evenement
			

        if ($_SESSION['magasin']!='general') {

            $prod=$this->DB->query("SELECT *FROM nombanque where lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        }else{
            $prod=$this->DB->query("SELECT *FROM nombanque order by(id)");
        }

        return $prod;

    }

    public function caisseById($id){

        $prod=$this->DB->querys("SELECT *FROM nombanque where id='{$id}' ");

        return $prod;

    }
    
    public function nomTypeCaisse(){// permet de recuperer la liste des caisses
		$type="caisse";

        if ($_SESSION['magasin']!='general') {

            $prod=$this->DB->query("SELECT *FROM nombanque where type='{$type}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        }else{
            $prod=$this->DB->query("SELECT *FROM nombanque where type='{$type}' order by(id)");
        }

        return $prod;

    }

    public function listBanque(){// Permet de recuperer la liste des banques
		$type="banque";
        $prod=$this->DB->query("SELECT *FROM nombanque where type='{$type}' order by(id)");       

        return $prod;

    }

    public function nomTypeBanque(){// Permet de recuperer la liste des banques
		$type="banque";

        if ($_SESSION['magasin']!='general') {

            $prod=$this->DB->query("SELECT *FROM nombanque where type='{$type}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        }else{
            $prod=$this->DB->query("SELECT *FROM nombanque where type='{$type}' order by(id)");
        }

        return $prod;

    }

    public function soldeGeneralByDeviseByDays($date, $devise, $lieuvente){

        if ($_SESSION['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}' ");
            
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}'  ");

        }

        return $prod['montant'];

    }

    public function soldeGeneralByDevise($devise, $lieuvente){

        if ($_SESSION['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$devise}'");
            
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");

        }

        return $prod['montant'];

    }

    public function montantCaisseGNF($banque, $devise){

        if ($_SESSION['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}'");
            
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");

        }

        return $prod['montant'];

    }

    public function montantChequeCaisse($banque, $devise){

        $cheque='cheque';

        if ($_SESSION['magasin']!='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}'");
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' ");

        }

        return $prod['montant'];

    }


    public function montantSoldeBanqueGNF($banque, $devise){

        if (isset($_POST['magasin']) and $_POST['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}'");
            
        }elseif (isset($_POST['magasin']) and $_POST['magasin']!='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' ");

        }

        return $prod;

    }


    public function montantCaisseGNFJour($date, $banque, $devise){

        if ($_SESSION['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}' ");
            
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}' ");

        }

        return $prod['montant'];

    }

    public function montantChequeCaisseJour($date, $banque, $devise){

        $cheque='cheque';

        if ($_SESSION['magasin']=='general') {

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}'");
        }else{

            $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where id_banque='{$banque}' and devise='{$devise}' and typep='{$cheque}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_versement, \"%Y%m%d\")='{$date}' ");

        }

        return $prod['montant'];

    }

    public function releveCaisses($date1, $date2, $type){
        $zero=0;
        if ($type=="general") {
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM banque where  DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM banque where DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' and lieuvente='{$_SESSION['lieuvente']}' ORDER BY(date_versement)");
            }
        }else{
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM banque where DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and origine='{$type}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM banque where DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and origine='{$type}' and montant!='{$zero}' and lieuvente='{$_SESSION['lieuvente']}' ORDER BY(date_versement)");
            }
        }

        return $prod;

    }

    public function nomProduit($nom){
        $nom_produit= $this->DB->querys("SELECT *FROM productslist where id='{$nom}'");

        return $nom_produit;
    }

    public function nomClient($nom){
        $client= $this->DB->querys("SELECT *FROM client where id='{$nom}'");

        return $client;
    }

    public function montantFactureClient($client, $etat){
        $montant = $this->DB->querys("SELECT sum(Total-remise-montantpaye) as montant, sum(montantpaye) as montantpaye FROM payement where num_client='{$client}' and etat='{$etat}' ");

        return $montant;
    }

    public function montantFactureClientFournisseur($client, $devise, $etat){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM achat_fournisseur where id_client='{$client}' and devise='{$devise}' and etat_achatf='{$etat}' ");

        return $montant;
    }

    public function nomPersonnel($nom){
        $client= $this->DB->querys("SELECT *FROM personnel where identifiant='{$nom}'");

        return $client;
    }

    public function soldeClient($client, $devise){
        $prodcompte = $this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' ");

        return(-$prodcompte['montant']);
    }

    public function soldeCaisse($id,$devise,$type){
        $montant=$this->DB->querys("SELECT montant FROM banque inner join nombanque on nombanque.id=id_banque where banque.id='{$id}' and devise='{$devise}' and type='{$type}' ");

        return $montant;
    }

    public function infosClientBanque($client,$origine,$devise,$numero){
        $zero=0;

        if ($origine=='vente' or $origine=='depot') {
            $nomClient=$this->nomClient($client)['nom_client'];
            $soldeClient=0;
        }elseif ($origine=='bon' or $origine=='remboursbon' or $origine=='salaire') {
            $nomClient=$this->nomPersonnel($client)['nom'];
            $soldeClient=0;
        }else{
            $nomClient="";
            $soldeClient=0;
        }

        return array($nomClient, $soldeClient);

    }

    public function findDeviseByCmd($cmd){
        $values= $this->DB->querys("SELECT *FROM devisevente where numcmd='{$cmd}'");
        return $values;
    }
}