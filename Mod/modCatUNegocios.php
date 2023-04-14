<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modCatUNegocios {
    private $CodUNegocio;
    private $Nombre;
    private $Obs;


    private $ArrDat;

    var $conDb;
    var $objParam;

    public function getCodUNegocio() {
        return $this->CodUNegocio;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function getObs() {
        return $this->Obs;
    }

    public function setCodUNegocio($CodUNegocio) {
        $this->CodUNegocio = $CodUNegocio;
    }

    public function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    public function setObs($Obs) {
        $this->Obs = $Obs;
    }


        public function __construct($CodUNegocio,$Nombre, $Obs)
        {
            $this->CodUNegocio = $CodUNegocio;
            $this->Nombre = $Nombre;
            $this->Obs = $Obs;

            $this->ArrDat = array($this->CodUNegocio,
                                  $this->Nombre,
                                  $this->Obs
                    );

            $this->objParam = new ClsParam($_SESSION['path']);
            $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
            //$this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);


            if ($this->conDb->Conextar() > 0){
              return "Error al conectarse en la base de datos";
            }
        }

    public function __toString() {

    }

    public function guardarCatUNegocios()
    {
       $strIns = "Insert into CatUnidadNegocios (CodUNegocio,Nombre,"
               . "Obs) Values(?,?,?)";

       if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
          return "Registro Agregado";
       else
           return "No se agrego el registro ...";
    }


    public function obtenerCatUNegocios()
    {
       $strSlc = "SELECT  * FROM CatUnidadNegocios";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;//'no hay registros que mostrar ....';
    }


    public function obtenerCatUNegociosB($cmpBusc)
    {
       $strSlc = "Select * from CatUnidadNegocios where CodUNegocio like '%".$cmpBusc."%' or "
               . " nombre like '%".$cmpBusc."%'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }

    public function obtenerCatUNegocios1($cmpBusc)
    {
       $strSlc = "Select * from CatUnidadNegocios where CodUNegocio = '".$cmpBusc."' ";

       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }




    public function DeleteCatUNegocios($coduneg)
    {
        $strDlt = "delete from CatUnidadNegocios where CodUNegocio = '".$coduneg."'";

        $rsp = $this->conDb->QueryDml( $strDlt);
        //print $rsp;
        if (count($rsp) > 0){
            return 'Registro eliminado';
        }
       else
           return 'no hay registros que eliminar ....';
    }

    public function UpdateCatUNegocios()
    {
        $strUpd = 'Update CatUnidadNegocios set Nombre = (?), Obs = (?) '
                . ' where CodUNegocio = (?)';
       $this->ArrDat = array(
                             $this->Nombre,
                             $this->Obs,
                             $this->CodUNegocio
                    );

       if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
          return "Registro Actualizado";
       else
           return "No se agrego el registro ...";
    }

    public function Obterner_Seg($CodPantalla)
    {
        $strSeg = "select A.CodPerfil,P.CodPantalla,A.CodProceso,P.Descripcion,A.Acceso
                     from SgAccesos A join  SgProcesos P on A.CodProceso = P.CodProceso
                                                         and P.CodPantalla = '".$CodPantalla."' ".
                     " where A.CodPerfil = '".$_SESSION['CodPerfil'] ."'";

        $rsp = $this->conDb->loadQueryARR_Asoc($strSeg);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;
    }


}
