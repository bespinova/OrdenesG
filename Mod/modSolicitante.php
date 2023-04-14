<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();

class modSolicitante
{
  private $CodSolicitante;
  private $Nombre;
  private $Email;
  private $codUNegocio;
  private $codArea;

  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($CodSolicitante,$Nombre,$Email,$codUNegocio,$codArea)
  {
    $this->CodSolicitante = $CodSolicitante;
    $this->Nombre = $Nombre;
    $this->Email = $Email;
    $this->codUNegocio = $codUNegocio;
    $this->codArea = $codArea;

    $this->ArrDat = array($this->CodSolicitante,
                          $this->Nombre,
                          $this->codUNegocio,
                          $this->codArea,
                          $this->Email
            );


    //$this->objParam = new ClsParam(PATH);
    //$this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);
    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);


    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }
  public function obtenerCatSolicita(){
    //$strSlc = "SELECT CodSolicitante,Nombre,CodUNegocio,CodArea,Email from CatSolicitantes";
    $strSlc = "SELECT CodSolicitante,SCTE.Nombre as NombreSolicitante,UNEG.Nombre as NombreUnidadNegocio,AREA.Nombre as NombreArea,Email"
                                    . " FROM CatSolicitantes AS SCTE"
                                    . " LEFT JOIN CatUnidadNegocios AS UNEG"
                                    . " ON SCTE.CodUNegocio = UNEG.CodUNegocio"
                                    . " LEFT JOIN CatAreas AS AREA"
                                    . " ON SCTE.CodArea = AREA.CodArea";
    //SELECT CodSolicitante,SCTE.Nombre as NombreSolicitante,UNEG.Nombre as NombreUnidadNegocio,AREA.Nombre as NombreArea,Email
		$rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else
        return 'no hay registros que mostrar ....';
  }
  public function obtenerOsG_CatUNeg()
  {
      $strUneg = "Select CodUNegocio,Nombre from CatUnidadNegocios order by CodUNegocio";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;//'n
  }
  public function obtenerOsG_CatArea($varData)
   {
      $strUneg = "SELECT CodArea,Nombre FROM CatAreas WHERE CodUNegocio = '".$varData."' ORDER BY CodArea";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;//'n
   }
   public function guardaCatSolicitante()
   {
      $strIns = "Insert into CatSolicitantes(CodSolicitante,Nombre,CodUNegocio," //insert into  values('S007','DANTE SIBOLDI','U001','G009')
              . "CodArea,Email) Values(?,?,?,?,?)";

      if($this->conDb->AddRegistro ($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se agrego el registro ...";
   }
   public function obtenerCodSolicita($varCod){
     $strSlc = "Select * from CatSolicitantes where CodSolicitante = '".$varCod."' ";

     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   public function UpdateCatSolicita()
   {
       $strUpd = 'UPDATE CatSolicitantes SET Nombre = (?),CodUNegocio = (?),CodArea =(?), Email =(?)'
               . 'WHERE CodSolicitante = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->codUNegocio,
                          $this->codArea,
                          $this->Email,
                          $this->CodSolicitante,
                   );
      if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
         return "Registro Actualizado";
      else
          return "No se agrego el registro ...";
   }

// TODO: SE AGREGO CONSULTA PARA LA BUSQUEDA, SE ACTULIZARON LOS CAMPOS
   public function buscarRegSlcte($cmpBusc)
   {
      $strSlc="SELECT CodSolicitante,SCTE.Nombre as NombreSolicitante,UNEG.Nombre as NombreUnidadNegocio,AREA.Nombre as NombreArea,Email"
        									. " FROM CatSolicitantes AS SCTE"
                                            . " INNER JOIN CatUnidadNegocios AS UNEG"
                                            . " ON SCTE.CodUNegocio = UNEG.CodUNegocio"
        									. " INNER JOIN CatAreas AS AREA"
                                            . " ON SCTE.CodArea = AREA.CodArea"
                                            . " WHERE CodSolicitante LIKE '%" .$cmpBusc. "%' OR"
                                            . " SCTE.Nombre LIKE '%" .$cmpBusc. "%' OR"
                                            . " UNEG.Nombre LIKE '%" .$cmpBusc. "%' OR"
                                            . " AREA.Nombre LIKE '%" .$cmpBusc. "%' OR"
                                            . " Email LIKE '%" .$cmpBusc. "%' ";
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

   public function DeleteCatSolcte($codSolcte)
   {
       $strDlt = "DELETE FROM CatSolicitantes WHERE CodSolicitante = '".$codSolcte."'";

       $rsp = $this->conDb->QueryDml( $strDlt);
       //print $rsp;
       if (count($rsp) > 0){
           return 'Registro eliminado';
       }
      else
          return 'no hay registros que eliminar.';
   }
}

?>
