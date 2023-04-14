<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modCatVehMaqPesada 
{
    private $CodUnidad;
    private $Descripcion;
    private $TipoVeh;
    private $Disponible;
    private $Estatus;
    private $Observaciones;
    
    private $ArrDat;

    var $conDb;
    var $objParam;
    
    
    public function getCodUnidad() {
        return $this->CodUnidad;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    public function getTipoVeh() {
        return $this->TipoVeh;
    }

    public function getDisponible() {
        return $this->Disponible;
    }

    public function getEstatus() {
        return $this->Estatus;
    }

    public function getObservaciones() {
        return $this->Observaciones;
    }

    public function setCodUnidad($CodUnidad) {
        $this->CodUnidad = $CodUnidad;
    }

    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;
    }

    public function setTipoVeh($TipoVeh) {
        $this->TipoVeh = $TipoVeh;
    }

    public function setDisponible($Disponible) {
        $this->Disponible = $Disponible;
    }

    public function setEstatus($Estatus) {
        $this->Estatus = $Estatus;
    }

    public function setObservaciones($Observaciones) {
        $this->Observaciones = $Observaciones;
    }

    
    public function __construct($CodUnidad,$Descripcion, $TipoVeh, $Disponible,
                                $Estatus,$Observaciones)
        {
            $this->CodUnidad = $CodUnidad;
            $this->Descripcion = $Descripcion;
            $this->TipoVeh = $TipoVeh;
            $this->Disponible = $Disponible;
            $this->Estatus = $Estatus;
            $this->Observaciones = $Observaciones;
            

            $this->ArrDat = array($this->CodUnidad,
                                  $this->Descripcion,
                                  $this->TipoVeh,
                                  $this->Disponible,
                                  $this->Estatus,
                                  $this->Observaciones
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

    public function guardarCatVehMaqPesada()
    {
       $strIns = "Insert into CatUnidadesVh (CodUnidad,Descripcion,TipoVeh,"
               . "Disponible,Estatus,Observaciones) Values(?,?,?,?,?,?)";

       if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
          return "Registro Agregado";
       else
           return "No se agrego el registro ...";
    }


    public function obtenerVehMaqPesada()
    {
       $strSlc = "select CodUnidad,Descripcion,TipoVeh,
                    case Disponible
                      when 1 then 'SI'
                      when 0 then 'NO'
                    end as Disponible,
                    case Estatus
                      when 1 then 'Trabajando'
                      when 0 then 'Disponible'
                    end as Estatus,Observaciones
                 from CatUnidadesVh";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);

        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return  $rsp;//'no hay registros que mostrar ....';
    }

    public function obtenerprCatVehMaqPesada1($CodUnidad)
    {
        $strSlc = "select  * from CatUnidadesVh where CodUnidad = '".$CodUnidad."'";
      
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }


    public function obtenerprCatVehMaqPesadaB($cmpBusc)
    {
       $strSlc = "select CodUnidad,Descripcion,TipoVeh,
                    case Disponible
                        when 1 then 'SI'
                        when 0 then 'NO'
                    end as Disponible,
                    case Estatus
                        when 1 then 'Trabajando'
                        when 0 then 'Disponible'
                    end as Estatus,Observaciones from CatUnidadesVh where Descripcion like '%".$cmpBusc."%'
                                  or TipoVeh like '%".$cmpBusc."%' 
                                  or Observaciones like '%".$cmpBusc."%'";
       $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       //print_r($rsp);
        if (count($rsp) > 0){
            return $rsp;
        }
       else
           return 'no hay registros que mostrar ....';
    }

    



    public function DeleteVehMaqPesada($CodUnidad)
    {
        $strDlt = "delete from CatUnidadesVh where CodUnidad = '".$CodUnidad."'";

        $rsp = $this->conDb->QueryDml( $strDlt);
        //print $rsp;
        if (count($rsp) > 0){
            return 'Registro eliminado';
        }
       else
           return 'no hay registros que eliminar ....';
    }

    public function UpdateVehMaqPesada()
    {
       $strUpd = 'Update CatUnidadesVh set Descripcion = (?), TipoVeh = (?), Disponible = (?), '
                 .'Estatus = (?),Observaciones = (?)'
                . ' where CodUnidad = (?)';
       $this->ArrDat = array(
                             $this->Descripcion,
                             $this->TipoVeh,
                             $this->Disponible,
                             $this->Estatus,
                             $this->Observaciones,
                             $this->CodUnidad
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
    
    
    public function obtener_CatTipoVeh()
    {
       $strUneg = "Select TipoVeh from CatTipoVh order by TipoVeh";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg); 
     
        if (count($rsp) > 0){ 
            return $rsp;
        }   
       else 
           return  $rsp;
    }


}
