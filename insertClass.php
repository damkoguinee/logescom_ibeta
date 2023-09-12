<?php 
class InsertInto{
    public $DB;

    function __construct($DB)
    {
       $this->DB=$DB; 
    }

    public function insertBanque($clientbanque,$banque,$numero,$typeent,$origine,$libelles,$montant,$devise,$typep,$numeropaie,$banqcheque,$lieuvente,$date_versement){
        $this->DB->insert("INSERT INTO banque(id_banque, clientbanque, numero, typeent, origine, libelles, montant, devise, typep, numeropaie, banqcheque, lieuvente, date_versement)Values(?,?,?,?,?,?,?,?,?,?,?,?,?)", array($banque,$clientbanque,$numero,$typeent,$origine,$libelles,$montant,$devise,$typep,$numeropaie,$banqcheque,$lieuvente,$date_versement));

    }

    public function insertBulletin($nom_client,$libelles,$numero,$montant,$devise,$caissebul,$lieuvente,$date_versement){
        $this->DB->insert("INSERT INTO bulletin(nom_client,libelles,numero,montant,devise,caissebul,lieuvente,date_versement)Values(?,?,?,?,?,?,?,?)", array($nom_client,$libelles,$numero,$montant,$devise,$caissebul,$lieuvente,$date_versement));

    }

    public function insertDecaissement($numdec,$montant,$devisedec,$payement,$numcheque,$banquecheque,$cprelever,$coment,$client,$lieuvente,$idpers,$date_payement){
        $this->DB->insert("INSERT INTO decaissement(numdec,montant,devisedec,payement,numcheque,banquecheque,cprelever,coment,client,lieuvente,idpers,date_payement)Values(?,?,?,?,?,?,?,?,?,?,?,?)", array($numdec,$montant,$devisedec,$payement,$numcheque,$banquecheque,$cprelever,$coment,$client,$lieuvente,$idpers,$date_payement));

    }

    public function insertModep($numpaiep,$caisse,$client,$montant,$modep,$taux,$numerocheque,$banquecheque,$etatcheque,$datefact){
        $this->DB->insert("INSERT INTO modep(numpaiep,caisse,client,montant,modep,taux,numerocheque,banquecheque,etatcheque,datefact)Values(?,?,?,?,?,?,?,?,?,?)", array($numpaiep,$caisse,$client,$montant,$modep,$taux,$numerocheque,$banquecheque,$etatcheque,$datefact));

    }

    public function insertPayement($num_cmd,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd,$datealerte){
        if (empty($datealerte)) {
            $this->DB->insert("INSERT INTO payement(num_cmd,Total,fraisup,montantpaye,remise,reste,etat,etatliv,vendeur,num_client,nomclient,caisse,lieuvente,date_cmd)Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($num_cmd,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd));
            
        }else{
            $this->DB->insert("INSERT INTO payement(num_cmd,Total,fraisup,montantpaye,remise,reste,etat,etatliv,vendeur,num_client,nomclient,caisse,lieuvente,date_cmd,datealerte)Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($num_cmd,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd,$datealerte));
        }

    }

    public function insertPayementCash($num_cmd,$typevente,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd,$datealerte){
        if (empty($datealerte)) {
            $this->DB->insert("INSERT INTO payement(num_cmd,type_vente,Total,fraisup,montantpaye,remise,reste,etat,etatliv,vendeur,num_client,nomclient,caisse,lieuvente,date_cmd)Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($num_cmd,$typevente,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd));
            
        }else{
            $this->DB->insert("INSERT INTO payement(num_cmd,Total,fraisup,montantpaye,remise,reste,etat,etatliv,vendeur,num_client,nomclient,caisse,lieuvente,date_cmd,datealerte)Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", array($num_cmd,$Total,$fraisup,$montantpaye,$remise,$reste,$etat,$etatliv,$vendeur,$num_client,$nomclient,$caisse,$lieuvente,$date_cmd,$datealerte));
        }

    }

    public function insertVenteCommission($numc,$numcmd,$montant,$idclient,$idpers,$dateop){
        $this->DB->insert("INSERT INTO ventecommission(numc,numcmd,montant,idclient,idpers,dateop)Values(?,?,?,?,?,?)", array($numc,$numcmd,$montant,$idclient,$idpers,$dateop));

    }

}