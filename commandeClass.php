<?php 

class commande {
    private $DB;
    public function __construct($DB){
        $this->DB=$DB;
    }
    public function moneyTransferByCmd($cmd){
        $prod=$this->DB->query("SELECT *from transfertargent where cmd='{$cmd}' ");
        return $prod;
    }
    public function statutMoneyTransfer($id, $statut){
        $this->DB->insert("UPDATE transfertargent SET statut='{$statut}' where id='{$id}' ");
    }
    public function portefeuilleByCmd($cmd, $statut){
        $prod=$this->DB->querys("SELECT sum(montant*taux) as montant from transfertargent where cmd='{$cmd}' and statut='{$statut}' ");
        return $prod;
    }
    // fonction pour confirmer les paiements des produits commnadés
    public function supplierPaie($idc, $idprod, $qtite, $pa,  $fournisseur, $cmd, $taux, $tauxgnf){
        $statut="payer";
        $this->DB->insert("INSERT INTO gestionpaiefournisseur (idprod, qtite, pa, client, cmd, taux, tauxgnf, dateop) VALUES (?, ?, ?, ?, ?, ?, ?, now())", array($idprod, $qtite, $pa,  $fournisseur, $cmd, $taux, $tauxgnf));
        $this->DB->insert("UPDATE gestionachatfournisseur SET statut='{$statut}' where id='{$idc}' ");
    } 

    public function updateSupplierPaie($idc, $idprod, $qtite, $pa,  $fournisseur, $cmd){
        $statut="nok";
        $this->DB->delete("DELETE FROM gestionpaiefournisseur where  idprod='{$idprod}' and cmd='{$cmd}' and client='{$fournisseur}' ");
        $this->DB->insert("UPDATE gestionachatfournisseur SET statut='{$statut}' where id='{$idc}' ");
    }
    
    public function orderAmountSupplier($cmd){
        $prod=$this->DB->querys("SELECT sum((pv/tauxgnf)*qtite) as montantgnf, sum((pv/taux)*qtite) as montantus, sum(pv*qtite) as montantaed FROM gestionachatfournisseur where cmd='{$cmd}' "); 
        return $prod;
    }

    public function paieCmdSupplier($cmd){
        $prod=$this->DB->querys("SELECT sum((pa/tauxgnf)*qtite) as montantgnf, sum((pa/taux)*qtite) as montantus, sum(pa*qtite) as montant from gestionpaiefournisseur where cmd='{$cmd}' ");
        return $prod;
    }
    // liste des produits des fournisseurs par type de commande
    public function productListSupplierByCmd($cmd, $fournisseur){
        $prod=$this->DB->query("SELECT *from gestionachatfournisseur inner join productslist on productslist.id=idprod where cmd='{$cmd}' and  fournisseur='{$fournisseur}' ");
        return $prod;
    }
    // commandes en-cours par produit
    public function orderInprogressById($id){
        $etat="clos";	

        $prod= $this->DB->querys("SELECT sum(qtite) as qtite FROM gestionachatfournisseur where idprod='{$id}' and etatrecep!='{$etat}' ");
        
        return $prod;
    }
}