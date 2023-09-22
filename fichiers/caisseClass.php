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

    public function releveBanqueClient($date1, $date2, $client, $devise){
        $zero=0;
        if (isset($_POST['j1'])) {
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM banque where clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }

        }else{
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM banque where clientbanque='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }
        }

        return $prod;
    }

    public function soldeReleveBanuqe($date1, $date2, $client, $devise){
        $zero=0;
        if (isset($_POST['j1'])) {
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }

        }else{
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }
        }

        return $prod;
    }

    public function cumulReleveBanuqe($date1, $date2, $client, $devise, $type){
        $zero=0;
        if ($type=="debiter") {
            if (isset($_POST['j1'])) {
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant<'{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant<'{$zero}' ORDER BY(date_versement)");
                }

            }else{
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant<'{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant<'{$zero}' ORDER BY(date_versement)");
                }
            }
        }else{
            if (isset($_POST['j1'])) {
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant>='{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant>='{$zero}' ORDER BY(date_versement)");
                }

            }else{
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where  clientbanque='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant>='{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM banque where clientbanque='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant>='{$zero}' ORDER BY(date_versement)");
                }
            }
        }

        return $prod;
    }

    public function rapportClient($date1, $date2, $client, $devise){
        $zero=0;
        if (isset($_POST['j1'])) {
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM bulletin where nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }

        }else{
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->query("SELECT *FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->query("SELECT *FROM bulletin where nom_client='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }
        }

        return $prod;
    }

    public function soldeRapportClient($date1, $date2, $client, $devise){
        $zero=0;
        if (isset($_POST['j1'])) {
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }

        }else{
            if ($_SESSION['magasin']=='general') {
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant!='{$zero}' ORDER BY(date_versement)");
            }else{
                $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant!='{$zero}' ORDER BY(date_versement)");
            }
        }

        return $prod;
    }

    public function cumulRapportClient($date1, $date2, $client, $devise, $type){
        $zero=0;
        if ($type=="debiter") {
            if (isset($_POST['j1'])) {
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant<'{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant<'{$zero}' ORDER BY(date_versement)");
                }

            }else{
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant<'{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant<'{$zero}' ORDER BY(date_versement)");
                }
            }
        }else{
            if (isset($_POST['j1'])) {
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and montant>='{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and DATE_FORMAT(date_versement, \"%Y%m%d\")<='{$date2}' and lieuvente='{$_SESSION['lieuvente']}' and montant>='{$zero}' ORDER BY(date_versement)");
                }

            }else{
                if ($_SESSION['magasin']=='general') {
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where  nom_client='{$client}' and devise='{$devise}' and DATE_FORMAT(date_versement, \"%Y%m%d\")>='{$date1}' and montant>='{$zero}' ORDER BY(date_versement)");
                }else{
                    $prod=$this->DB->querys("SELECT sum(montant) as montant FROM bulletin where nom_client='{$client}' and devise='{$devise}' and lieuvente='{$_SESSION['lieuvente']}' and montant>='{$zero}' ORDER BY(date_versement)");
                }
            }
        }

        return $prod;
    }

    public function commandeByNumc($numc){
        $commande= $this->DB->query("SELECT *FROM commande where num_cmd='{$numc}'");

        return $commande;
    }

    public function commandeRetourByNumc($numc){
        $commande= $this->DB->query("SELECT *FROM commande where num_cmd='{$numc}'");

        return $commande;
    }

    public function achatFournisseurInterneByNumc($numc){
        $commande= $this->DB->query("SELECT *FROM achat where numcmd='{$numc}'");

        return $commande;
    }

    public function nomProduit($nom){
        $nom_produit= $this->DB->querys("SELECT *FROM productslist where id='{$nom}'");

        return $nom_produit;
    }

    public function nomClient($nom){
        $client= $this->DB->querys("SELECT *FROM client where id='{$nom}'");
        return $client;
    }

    public function infosFactureByNumero($numero){
        $infosFacture = $this->DB->querys("SELECT *FROM payement where num_cmd='{$numero}' ");
        return $infosFacture;
    }

    public function retourFactureByNumero($numero){
        $zero=0;
        $prodcmd=$this->DB->querys("SELECT sum(prix_vente*quantity) as montant FROM commande where num_cmd='{$numero}' and quantity<'{$zero}' ");
        return $prodcmd;
    }

    public function montantFactureClient($client, $etat){
        $montant = $this->DB->querys("SELECT sum(Total-remise-montantpaye) as montant, sum(montantpaye) as montantpaye FROM payement where num_client='{$client}' and etat='{$etat}' ");
        return $montant;
    }

    public function montantFactureClientSolde($client, $etat){
        $montant = $this->DB->querys("SELECT sum(Total-remise-montantpaye-solde_facture) as montant, sum(montantpaye) as montantpaye FROM payement where num_client='{$client}' and etat='{$etat}' ");
        return $montant;
    }

    public function nbreFactureClientCredit($client, $etat){
        $montant = $this->DB->querys("SELECT count(id) as nbre FROM payement where num_client='{$client}' and etat='{$etat}' ");
        return $montant;
    }

    public function nbreFactureClientCreditPayer($client, $etat, $solde){
        $montant = $this->DB->querys("SELECT count(id) as nbre FROM payement where num_client='{$client}' and solde_facture > '{$solde}' and etat='{$etat}' ");
        return $montant;
    }

    public function nbreFactureClientCreditNonPayer($client, $etat, $solde){
        $montant = $this->DB->querys("SELECT count(id) as nbre FROM payement where num_client='{$client}' and solde_facture = '{$solde}' and etat='{$etat}' ");
        return $montant;
    }

    public function resteSoldeFactureClient($numcmd){
        $queryReste = $this->DB->querys("SELECT SUM(Total-remise-solde_facture) as reste, solde_facture as solde FROM payement where num_cmd ='{$numcmd}' ");
        return $queryReste;
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

    public function cumulPayement($etat, $client, $date1, $date2){
        if (isset($_POST['j1'])) {
            $products=$this->DB->querys("SELECT sum(prix_vente*quantity-prix_revient*quantity) as benefice FROM payement inner join commande on payement.num_cmd=commande.num_cmd where type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") >='{$date1}' and DATE_FORMAT(date_cmd, \"%Y%m%d\") <= '{$date2}' ");
        }elseif (isset($_GET['clientsearch'])) {

            $products=$this->DB->querys("SELECT sum(prix_vente*quantity-prix_revient*quantity) as benefice FROM payement inner join commande on payement.num_cmd=commande.num_cmd where type_vente='{$etat}' and num_client='{$client}' and lieuvente='{$_SESSION['lieuvente']}' ");                

        }else {
            $products =$this->DB->querys("SELECT sum(prix_vente*quantity-prix_revient*quantity) as benefice FROM payement inner join commande on payement.num_cmd=commande.num_cmd WHERE type_vente='{$etat}' and lieuvente='{$_SESSION['lieuvente']}' "); 
        }

        return $products;
    }
}