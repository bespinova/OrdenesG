<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();

class modAreas
{
  private $codArea;
  private $Nombre;
  private $codUNegocio;


  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($codArea,$Nombre,$codUNegocio)
  {
    $this->codArea = $codArea;
    $this->Nombre = $Nombre;
    $this->codUNegocio = $codUNegocio;

    $this->ArrDat = array($this->codArea,
                          $this->Nombre,
                          $this->codUNegocio
            );



    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
    //$this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }
  public function obtenerCatArea(){
    $strSlc = "SELECT CodArea,CTA.Nombre AS NombreArea ,CUN.Nombre AS NombreUnidadNegocio FROM CatAreas AS CTA"
                . " INNER JOIN CatUnidadNegocios AS CUN"
                . " ON CTA.CodUNegocio = CUN.CodUNegocio";
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
  public function obtenerOsG_CatArea()
   {
      $strUneg = "Select CodArea,Nombre from CatAreas order by CodArea";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);

      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;//'n
   }
   public function guardaCatArea()
   {
      $strIns = "INSERT INTO CatAreas(CodArea,Nombre,CodUNegocio) VALUES(?,?,?)";

      /*$strIns = "Insert into CatAreas (CodArea,Nombre,"
              . "CodUNegocio) Values(?,?,?)";*/

      if($this->conDb->AddRegistro($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se agrego el registro ...";
   }
   public function obtenerCodArea($varCodArea){
     $strSlc = "SELECT CodArea,Nombre,CodUNegocio FROM CatAreas WHERE CodArea = '".$varCodArea."' ";

     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   public function UpdateCatAreas()
   {
       $strUpd = 'UPDATE CatAreas SET Nombre = (?),CodUNegocio = (?)'
               . 'WHERE CodArea = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->codUNegocio,
                          $this->codArea
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

// TODO: SE MODIFICO LA CONSULTA PARA QUE BUSQUE EN EL CAMPO DE AREAS
   public function buscarRegArea($cmpBusc)
   {
      $strSlc = "SELECT CodArea,CTA.Nombre AS NombreArea ,CUN.Nombre AS NombreUnidadNegocio FROM CatAreas AS CTA"
                    . " INNER JOIN CatUnidadNegocios AS CUN"
                    . " ON CTA.CodUNegocio = CUN.CodUNegocio"
                    . " WHERE CodArea LIKE '%".$cmpBusc."%' OR"
                    . " CTA.Nombre LIKE '%".$cmpBusc."%' OR"
                    . " CUN.Nombre LIKE '%".$cmpBusc."%' ";
      $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return 'Ningún elemento coincide';
   }

   public function DeletCatArea($codArea)
   {
       $strDlt = "DELETE FROM CatAreas WHERE CodArea = '".$codArea."'";

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
