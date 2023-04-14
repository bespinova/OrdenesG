<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modCatRubros {
    private $CodRubro;
    private $Descripcion;
    private $PerteneceA;


    private $ArrDat;

    var $conDb;
    var $objParam;

    public function getCodRubro() {
        return $this->CodRubro;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function getPerteneceA() {
        return $this->PerteneceA;
    }

    public function setCodRubro($CodRubro) {
        $this->CodRubro = $CodRubro;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    public function setPerteneceA($PerteneceA) {
        $this->PerteneceA = $PerteneceA;
    }

    
    public function __construct($CodRubro,$Descripcion, $PerteneceA)
        {
            $this->CodRubro = $CodRubro;
            $this->Descripcion = $Descripcion;
            $this->PerteneceA = $PerteneceA;

            $this->ArrDat = array($this->CodRubro,
                                  $this->Descripcion,
                                  $this->PerteneceA
                    );

            $this->objParam = new ClsParam($_SESSION['path']);
            $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
            //$this->conDb = new ClsmsSql("sigma6\locsql","sa","GcOSMtto","Remolachas1");


            if ($this->conDb->Conextar() > 0){
              return "Error al conectarse en la base de datos";
            }
        }

    public function __toString() {

    }

    public function guardarprCatRubros()
    {
       $strIns = "Insert into PrCatRubros (CodRubro,Descripcion,"
               . "PerteneceA) Values(?,?,?)";

       if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
          return "Registro Agregado";
       else
           return "No se agrego el registro ...";
    }


    public function obtenerprCatRubros()
    {
       $strSlc = "SELECT  Cr.CodRubro,Cr.Descripcion,Gm.Nombre 
                  FROM PrCatRubros Cr Join CatGteMatto Gm on Cr.PerteneceA = Gm.CodGteMtto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;//'no hay registros que mostrar ....';
    }

    public function obtenerprCatRubros1($CodRubro)
    {
        $strSlc = "SELECT  Cr.CodRubro,Cr.Descripcion,Gm.Nombre,Cr.PerteneceA
                  FROM PrCatRubros Cr Join CatGteMatto Gm on Cr.PerteneceA = Gm.CodGteMtto 
                  WHERE CodRubro = '".$CodRubro."'";
      
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }


    public function obtenerprCatRubrosB($cmpBusc)
    {
       $strSlc = "SELECT  Cr.CodRubro,Cr.Descripcion,Gm.Nombre
                FROM PrCatRubros Cr Join CatGteMatto Gm on Cr.PerteneceA = Gm.CodGteMtto 
                WHERE CodRubro like '%".$cmpBusc."%' OR Descripcion like '%".$cmpBusc."%' OR Nombre like '%".$cmpBusc."%'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }

    



    public function DeleteprCatRubro($CodRubro)
    {
        $strDlt = "delete from prCatRubros where CodRubro = '".$CodRubro."'";

        $rsp = $this->conDb->QueryDml( $strDlt);
        //print $rsp;
        if (count($rsp) > 0){
            return 'Registro eliminado';
        }
       else
           return 'no hay registros que eliminar ....';
    }

    public function UpdateCatRubros()
    {
       $strUpd = 'Update prCatRubros set Descripcion = (?), PerteneceA = (?) '
                . ' where CodRubro = (?)';
       $this->ArrDat = array(
                             $this->Descripcion,
                             $this->PerteneceA,
                             $this->CodRubro
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
    
    
    public function obtener_CatGteM()
    {
       $strUneg = "Select CodGteMtto,Nombre from CatGteMatto order by CodGteMtto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }


}
