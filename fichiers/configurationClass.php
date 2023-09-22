<?php 

class configuration {
    private $DB;
    public function __construct($DB){
        $this->DB=$DB;
    }

    public function espace($value){
        return str_replace(' ', '', $value);
    }

    public function formatNombre($value){
        if ($value==0) {
            return 0;
        }else{
            return number_format($value,0,',',' ');
        }
    }

    public function h(string $value):string{
        return htmlentities($value);
    }

    public function formatDate($value){
        return((new DateTime($value))->format("d/m/Y à H:i"));
    }

    public function paieMode(){
        $etat="ok";
        $values=$this->DB->query("SELECT *FROM paiemode where etat='{$etat}' ORDER BY(id) ");
        return $values;
    }
    
    
}