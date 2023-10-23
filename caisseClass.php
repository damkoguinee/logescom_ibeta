<?php 

class caisse {
    private $DB;
    public function __construct($DB){
        $this->DB=$DB;
    }

    public function nomBoutique(){// permet de recuperer la liste des caisses
		$type="vente";

        $prod=$this->DB->query("SELECT *FROM stock where type='{$type}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");

        return $prod;

    }

    public function nomBoutiqueByResponsable(){// permet de recuperer la liste des caisses
		$type="vente";

        if ($_SESSION['level']<=6 or $_SESSION['statut']=='vendeur') {

            $prod=$this->DB->query("SELECT *FROM stock where type='{$type}' and lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        }else{
            $prod=$this->DB->query("SELECT *FROM stock where type='{$type}' order by(id)");
        }

        return $prod;

    }

    public function nomBoutiqueByLieu(){// permet de recuperer la liste des caisses
		$type="vente";
        $prod=$this->DB->query("SELECT *FROM stock where lieuvente='{$_SESSION['lieuvente']}' order by(id)");
        return $prod;
    }

    public function nomCategorie($idcat){
        $nomCategorie = $this->DB->querys("SELECT nom FROM categorie where id='{$idcat}'");

        return $nomCategorie;
    }
    public function compteAll(){
        $compte = $this->DB->query("SELECT * FROM compte ");

        return $compte;
    }


    public function compteById($id){
        $compte = $this->DB->querys("SELECT * FROM compte where id='{$id}'");

        return $compte;
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

    public function listClient($type1, $type2){
        if (isset($_GET['clientsearch'])) {

            $client= $this->DB->query("SELECT *FROM client WHERE (typeclient = '{$type1}' OR typeclient = '{$type2}') and id = '{$_GET['clientsearch']}'  order by nom_client ");
        }else{
            $client= $this->DB->query("SELECT *FROM client WHERE (typeclient = '{$type1}' OR typeclient = '{$type2}') and positionc = '{$_SESSION['lieuvente']}'  order by nom_client ");
        }
        return $client;
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

    public function montantFactureClientGeneral($client){
        $zero=0;
        $prodf = $this->DB->querys("SELECT sum(Total-remise) as montant, sum(solde_facture+montantpaye) as soldeFacture FROM payement where num_client='{$client}' ");

        $prodcmd=$this->DB->querys("SELECT sum(prix_vente*quantity) as montant FROM commande where id_client='{$client}' and quantity<'{$zero}' ");

        $retour=-$prodcmd['montant'];
        $totalFacture=$prodf["montant"]+$retour;
        $totalFacturePaye=$prodf["soldeFacture"]+$retour;
        $totalNonPaye =  $totalFacture - $totalFacturePaye;

        return array($totalFacture, $totalFacturePaye, $totalNonPaye);
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

    public function achatClientFournisseurById($id){
        $achat = $this->DB->querys("SELECT *FROM achat_fournisseur where id='{$id}' ");

        return $achat;
    }

    public function totalAchatClientFournisseur($client, $devise){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM achat_fournisseur where id_client='{$client}' and devise='{$devise}' ");

        return $montant;
    }

    public function montantFactureClientFournisseur($client, $devise, $etat){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM achat_fournisseur where id_client='{$client}' and devise='{$devise}' and etat_achatf='{$etat}' ");

        return $montant;
    }

    public function montantVenteCommission($client){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM ventecommission where idclient='{$client}' ");

        return $montant;
    }

    public function montantDepot($client, $devise){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM versement where nom_client='{$client}' and devisevers = '{$devise}' ");
        return $montant;
    }

    public function montantRetrait($client, $devise){
        $montant = $this->DB->querys("SELECT sum(montant) as montant FROM decaissement where client='{$client}' and devisedec = '{$devise}' ");
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

        if ($origine=='vente' or $origine=='depot' or $origine=='retrait') {
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

    public function nbreVenteProduitById($idprod, $type_vente, $etatliv){
        $prod= $this->DB->querys("SELECT SUM(quantity) as qtite FROM commande inner join payement on commande.num_cmd=payement.num_cmd where id_produit='{$idprod}' and type_vente = '{$type_vente}' and lieuvente = '{$_SESSION['lieuvente']}' and etatlivcmd = '{$etatliv}' ");
        return $prod;
    }

    public function listeStockLieuvente(){
        $products = $this->DB->query("SELECT *FROM stock where lieuvente = '{$_SESSION['lieuvente']}' order by(nomstock)");

        return $products;
    }

    public function qtiteLieuventeProduit($idproduit) {
        $qtite=0;
        foreach ($this->listeStockLieuvente() as $valueS) {
            $prodstock = $this->DB->querys("SELECT sum(quantite) as qtite FROM `".$valueS->nombdd."` where idprod='{$idproduit}' ");
            $qtite+=$prodstock['qtite'];
        }

        return $qtite;
    }

    public function infoProduitStock($nombdd, $idproduit){
        $products = $this->DB->querys("SELECT *FROM `".$nombdd."` where idprod='{$idproduit}' ");
        return $products;
    }

    public function nbreVenteProduit($idproduit){
        $products = $this->DB->querys("SELECT COUNT(id) as nbre FROM commande where id_produit='{$idproduit}' ");
        return $products;
    }

    public function stockInitial($idproduit){
        $products = $this->DB->querys("SELECT MIN(id) as min, quantitemouv as qtite FROM stockmouv where idstock ='{$idproduit}' ");
        return $products;
    }

    public function stockEntrees($idproduit, $lieuvente){
        $products = $this->DB->querys("SELECT sum(quantitemouv) as qtite FROM stockmouv where idstock ='{$idproduit}' and lieuvente_mouv ='{$lieuvente}' and quantitemouv > 0 ");
        return $products;
    }

    public function stockSorties($idproduit, $lieuvente){
        $products = $this->DB->querys("SELECT sum(quantitemouv) as qtite FROM stockmouv where idstock ='{$idproduit}' and lieuvente_mouv ='{$lieuvente}' and quantitemouv < 0 ");
        return $products;
    }

    public function montantStockByCategorie($idcat){
        $montant=0;
        foreach ($this->listeStockLieuvente() as $valueS) {
            $prodstock = $this->DB->querys("SELECT sum(prix_revient) as pr FROM `".$valueS->nombdd."` inner join productslist on idprod=productslist.id where codecat ='{$idcat}' ");
            $montant+=$prodstock['pr'];
        }

        return $montant;
    }

    public function balanceClient($idc, $devise){
        $depot = $this->montantDepot($idc,$devise)['montant'];
        $retrait = $this->montantRetrait($idc,$devise)['montant'];
        $facture_payer = $this->montantFactureClientGeneral($idc)[1];
        $achat_payer = $this->montantFactureClientFournisseur($idc, $devise, "paye")["montant"];
        if ($devise!="gnf") {
            $facture_payer = 0;
        }
        $balance = ($depot - $retrait - $facture_payer) + $achat_payer;

        return $balance;
    }

    public function soldeClientNp($idc, $devise){
        $facture_nonpayer = $this->montantFactureClientGeneral($idc)[2];
        $achat_nonpayer = $this->montantFactureClientFournisseur($idc, $devise, "non paye")["montant"];
        $balance = $this->balanceClient($idc, $devise);

        if ($devise!="gnf") {
            $facture_nonpayer = 0;
        }

        $solde = $facture_nonpayer - $achat_nonpayer - $balance;

        return $solde;
    }
    
}