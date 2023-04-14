<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();

class modPdf{
    private $url;
    private $curp;
    private $ArrDat;

    var $conDb;
    var $objParam;

    function __construct($url,$curp)
    {
        $this->url = $url;
        $this->curp = $curp;

        $this->ArrDat = array(
            $this->url,
            $this->curp
        );

        $this->objParam = new ClsParam(PATH);
        $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);
    
        if ($this->conDb->Conextar() > 0){
        return "Error al conectarse en la base de datos";
        }

    }

    public function upDoc(){
        
        $strUpd = 'insert into tbl_resguardo (url,curp) values (?,?)';
        print_r($strUpd);
        //print_r("\nCodArea:".$this->CodArea);

        $this->ArrDat = array(
            $this->url,
            $this->curp
        );

        if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))
        
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }

}

?>