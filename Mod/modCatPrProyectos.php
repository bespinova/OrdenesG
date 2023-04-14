<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();

class modCatPrProyectos
{
  private $CodProyecto;
  private $Nombre;
  private $Observacion;
  private $CodUNegocio;
  private $CodArea;
  private $CodSolicitante;
  private $CodResponsable;
  private $FechaAlta;
  private $FechaInicio;
  private $MesesDuracion;
  private $FechaEntrega;
  private $PorTerminado;
  private $Presupuesto;
  private $enMarcha;
  private $status;


  private $ArrDat;
  var $conDb;
  var $objParam;

  function __construct($CodProyecto,$Nombre,$Observacion,$CodUNegocio,$CodArea,$CodSolicitante,$CodResponsable,$FechaAlta,$FechaInicio,$MesesDuracion,$FechaEntrega,$PorTerminado,$Presupuesto,$enMarcha,$status)
  //function __construct($CodProyecto,$Nombre,$Observacion,$CodUNegocio,$CodArea,$CodSolicitante,$CodResponsable,$FechaAlta,$FechaInicio,$MesesDuracion,$FechaEntrega,$Presupuesto)
  {
    $this->CodProyecto = $CodProyecto;
    $this->Nombre = $Nombre;
    $this->Observacion = $Observacion;
    $this->CodUNegocio = $CodUNegocio;
    $this->CodArea = $CodArea;
    $this->CodSolicitante = $CodSolicitante;
    $this->CodResponsable = $CodResponsable;
    $this->FechaAlta = $FechaAlta;
    $this->FechaInicio = $FechaInicio;
    $this->MesesDuracion = $MesesDuracion;
    $this->FechaEntrega = $FechaEntrega;
    $this->PorTerminado = $PorTerminado;
    $this->Presupuesto = $Presupuesto;
    $this->enMarcha = $enMarcha;
    $this->status = $status;



    $this->ArrDat = array($this->CodProyecto,
                  $this->Nombre,
                  $this->Observacion,
                  $this->CodUNegocio,
                  $this->CodArea,
                  $this->CodSolicitante,
                  $this->CodResponsable,
                  $this->FechaAlta,
                  $this->FechaInicio,
                  $this->MesesDuracion,
                  $this->FechaEntrega,
                  $this->PorTerminado,
                  $this->Presupuesto,
                  $this->enMarcha,
                  $this->status
            );

    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);


    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }
  public function obtenerPrCatProyecto(){
    $strSlc = "select cun.Nombre as NombreUNegocio, ca.Nombre as NombreArea, cs.Nombre as NombreSolicitante, cr.Nombre as NombreResponsable, CPR.CodProyecto as CodProyecto,
                    CPR.Nombre as Nombre,CPR.FechaAlta as FechaAlta,CPR.FechaInicio as FechaInicio,CPR.MesesDuracion as MesesDuracion,CPR.FechaEntrega as FechaEntrega,
                    CPR.PorTerminado as PorTerminado,CPR.Presupuesto as Presupuesto from PrCatProyectos CPR 
                    inner join CatUnidadNegocios CUN on cpr.CodUNegocio=cun.CodUNegocio
                    inner join CatAreas CA on cpr.CodArea=ca.CodArea
                    inner join CatSolicitantes CS on cpr.CodSolicitante=cs.CodSolicitante
                    inner join CatResponsables CR on cpr.CodResponsable=cr.CodResponsable";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else
        return $rsp;
  }
  public function obtenerOsG_CatUNeg()
  {
      $strUneg = "SELECT CodUNegocio,Nombre FROM CatUnidadNegocios ORDER BY CodUNegocio";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
  }
  public function obtenerOsG_CatArea($varData)
   {
      $strUneg = "SELECT CodArea,Nombre FROM CatAreas WHERE CodUNegocio = '".$varData."' ORDER BY CodArea";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
   }
   public function obtenerCboSolicita($vardato)
    {
       //$strUneg = "SELECT CodSolicitante,Nombre from CatSolicitantes order by CodSolicitante";
       $strUneg = "SELECT CodSolicitante,Nombre from CatSolicitantes WHERE CodUNegocio = '".$vardato."' order by CodSolicitante";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return  $rsp;
    }
    public function obtenerCboRspnble(){
      $strUneg = "SELECT CodResponsable,Nombre from CatResponsables order by CodResponsable";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
    }

    public function guardaPrCatProyectos()
   {
      $strIns = "insert INTO PrCatProyectos(CodProyecto,Nombre,Observacion,CodUNegocio,CodArea,CodSolicitante,CodResponsable,FechaAlta,FechaInicio,MesesDuracion,FechaEntrega,PorTerminado,Presupuesto,EnMarcha,Estatus) Values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se agrego el registro";
   }

   public function obtPrCatProyecto($varCodArea){
     $strSlc = "SELECT * FROM PrCatProyectos WHERE CodProyecto = '".$varCodArea."' ";
     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   public function UpdateCatProyecto()
   {
       $strUpd = 'UPDATE PrCatProyectos SET Nombre = (?),Observacion = (?),CodUNegocio =(?), CodArea =(?),CodSolicitante = (?),CodResponsable=(?),FechaInicio =(?),MesesDuracion=(?),FechaEntrega=(?),Presupuesto=(?) WHERE CodProyecto = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->Observacion,
                          $this->CodUNegocio,
                          $this->CodArea,
                          $this->CodSolicitante,
                          $this->CodResponsable,
                          //$this->FechaAlta,
                          $this->FechaInicio,
                          $this->MesesDuracion,
                          $this->FechaEntrega,
                          //$this->PorTerminado,
                          $this->Presupuesto,
                          $this->CodProyecto
                   );

      if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
         return "Registro Actualizado";
      else
          return "No se agrego el registro";
   }

   public function buscarRegCatPr($cmpBusc)
   {
      $strSlc = "
      select cun.Nombre as NombreUNegocio, ca.Nombre as NombreArea, cs.Nombre as NombreSolicitante, cr.Nombre as NombreResponsable, CPR.CodProyecto as CodProyecto,
                CPR.Nombre as Nombre,CPR.FechaAlta as FechaAlta,CPR.FechaInicio as FechaInicio,CPR.MesesDuracion as MesesDuracion,CPR.FechaEntrega as FechaEntrega,
                CPR.PorTerminado as PorTerminado,CPR.Presupuesto as Presupuesto from PrCatProyectos CPR 
                inner join CatUnidadNegocios CUN on cpr.CodUNegocio=cun.CodUNegocio
                inner join CatAreas CA on cpr.CodArea=ca.CodArea
                inner join CatSolicitantes CS on cpr.CodSolicitante=cs.CodSolicitante
                inner join CatResponsables CR on cpr.CodResponsable=cr.CodResponsable where CPR.CodProyecto LIKE '%" .$cmpBusc . "%' OR "
              			. " CPR.Nombre LIKE '%" .$cmpBusc.  "%' "
              			. " OR cun.Nombre LIKE '%".$cmpBusc."%' "
              			. " OR ca.Nombre LIKE '%".$cmpBusc."%' "
              			. " OR cs.Nombre LIKE '%".$cmpBusc."%' "
              			. " OR cr.Nombre LIKE '%".$cmpBusc."%' "
              			. " OR CPR.MesesDuracion LIKE '%".$cmpBusc."%' "
              			. " OR CPR.Presupuesto LIKE '%".$cmpBusc."%' ";
                          


      $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return 'no hay registros que mostrar ....';
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

   public function DeleteCatPr($codSolcte)
   {
       $strDlt = "DELETE PrCatProyectos WHERE CodProyecto = '".$codSolcte."'";

       $rsp = $this->conDb->QueryDml( $strDlt);
       if (count($rsp) > 0){
           return 'Registro eliminado';
       }
      else
          return 'no hay registros que eliminar.';
   }
   // TODO SE AGREGA FUNCION PARA LLENAR EL COMBO DE PROYECTOS
   public function obtenerAllPr()
    {
       $strUneg = "SELECT CodProyecto,Nombre FROM PrCatProyectos ORDER BY CodProyecto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
       if (count($rsp) > 0){
           return $rsp;
       }
      else{
            return  $rsp;
      }
    }

    public function obtenerContPry($varDataGral){
      $strUneg ="SELECT CodProyecto,Nombre,FechaInicio,FechaEntrega,MesesDuracion,Presupuesto,PorTerminado FROM PrCatProyectos WHERE CodProyecto = '".$varDataGral."'";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
      else{
         return  $rsp;
      }
    }
}
?>
