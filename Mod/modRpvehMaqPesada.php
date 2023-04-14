<?php
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");
include_once("../core.php");
session_start();

class modRpvehMaqPesada{
    private $Estatus;

    private $ArrDat;    
    var $conDb;
    var $objParam;

    public function getEstatus(){
        return $this->Estatus;
    }

    public function setEstatus($Estatus){
        $this->Estatus = $Estatus;
    }
    
    public function __construct($Estatus){
        $this->Estatus = $Estatus;
            
        $this->ArrDat = array(
            $this->Estatus
            );
        $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
        if ($this->conDb->Conextar() == 0){
            return "Error al conectarse en la base de datos";
        }
    }

    public function __toString() { }
    public function obtenerRpvehMaqPesada($disponible){
        $conDb = new ClsMsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
        if ($conDb->Conextar() > 0) {
            $Mat[0][0] = "@stdDis"; $Mat[0][1] = $disponible; $Mat[0][2] ="SQLVARCHAR"; 
            $nmProc = "RpVhMaqPes";
            $rsp = $conDb->loadProc($nmProc,$Mat);
            if (is_countable($rsp) && count($rsp) > 0){ 
                return $rsp;
            }
            else {
                return  $rsp;
            }
        }
    }
}