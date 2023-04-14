<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();


class modRevision{
  private $CodRevision;
  private $CodContenido;
  private $FechaRevision;
  private $Observaciones;
  private $CodAuditor;

  private $ArrDat;
  var $conDb;
  var $objParam;


  function __construct($CodRevision,$CodContenido,$FechaRevision,$Observaciones,$CodAuditor)
  {
    $this->CodRevision = $CodRevision;
    $this->CodContenido = $CodContenido;
    $this->FechaRevision = $FechaRevision;
    $this->Observaciones = $Observaciones;
    $this->CodAuditor = $CodAuditor;


    $this->ArrDat = array($this->CodRevision,
                          $this->CodContenido,
                          $this->FechaRevision,
                          $this->Observaciones,
                          $this->CodAuditor
                          );

    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

  public function guardaRevision()
  {
     $strIns = "INSERT INTO PrRevision(CodContenido,FechaRevision,Observaciones,CodAuditor)"
                . " VALUES (?,?,?,?)";

    $this->ArrDat = array(
                          $this->CodContenido,
                          $this->FechaRevision,
                          $this->Observaciones,
                          $this->CodAuditor
                        );
     if($this->conDb->AddRegistro($strIns, $this->ArrDat))
        return "Registro Agregado";
     else
         return "No se agrego el registro ...";
  }


  public function muestraRubrosConProyc($varPryc){
    $strSlc = "SELECT DISTINCT PRCR.CodRubro,Descripcion from PrCatRubros as PRCR"
    . " INNER JOIN PrContenidoProyecto as PRCP ON PRCP.CodRubro = PRCR.CodRubro"
    . " WHERE seRealiza = 1 AND PRCP.CodProyecto = '".$varPryc."' ";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }
  }

  public function muestraRvsnPryct($varPrcyRvsn){
    $strSlc = "SELECT CodTarea,Descripcion,ValorEnRubro"
              . " FROM PrCatTareaRubro WHERE CodRubro_fk = '".$varPrcyRvsn."' ";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }
  }

  public function muestraCodContenido($varPryc,$codTarea){
    $strSlc = "SELECT CodContenido FROM PrContenidoProyecto WHERE CodProyecto = '".$varPryc."' "
              . " AND CodTarea = '".$codTarea."' ";

    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }
  }

  public function muestraRevisionesContenido($varContenido){
    $strSlc = "SELECT CodRevision,CodContenido,FechaRevision,Observaciones,CodAuditor FROM "
              . " PrRevision WHERE CodContenido =  '".$varContenido."' ";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }
  }

  public function muestraTareaDetalle($varTarea){
    $strSlc = "SELECT CodTarea,Descripcion,CodRubro_fk,ValorEnRubro FROM "
              . " PrCatTareaRubro WHERE CodTarea =  '".$varTarea."' ";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else{
      return 'No hay registros que mostrar.';
    }
  }

  public function muestraRevsnEImgn($varTarea,$varPrcy){
    $strSlecc = "SELECT PRVSN.CodRevision,PRVSN.CodContenido,FechaRevision,Observaciones,RutaImg,Comentario,FechaSubida "
			. " FROM PrRevision AS PRVSN "
			. " LEFT JOIN PrRevsionImg AS PRVSNIMG "
			. " ON PRVSN.CodRevision = PRVSNIMG.CodRevision "
			. " JOIN PrContenidoProyecto AS PRCPR "
			. " ON PRVSN.CodContenido = PRCPR.CodContenido "
			. " WHERE PRVSN.CodContenido = "
			. " (SELECT CodContenido FROM PrContenidoProyecto WHERE CodTarea = '".$varTarea."' AND CodProyecto = '".$varPrcy."' )";

      $rsp = $this->conDb->loadQueryARR_Asoc($strSlecc);
      if (count($rsp) > 0 ) {
        return $rsp;
      }else {
        return -1;
      }
  }
}
 ?>
