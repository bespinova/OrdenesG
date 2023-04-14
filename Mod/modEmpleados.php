<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();
class modEmpleados
{
  private $CodEmpleado;
  private $Nombre;
  private $claveGteMtto;
  private $email;


  private $ArrDat;
  var $conDb;
  var $objParam;

  function __construct($CodEmpleado,$Nombre,$claveGteMtto,$email)
  {
    $this->CodEmpleado = $CodEmpleado;
    $this->Nombre = $Nombre;
    $this->claveGteMtto = $claveGteMtto;
    $this->email = $email;

    $this->ArrDat = array($this->CodEmpleado,
                          $this->Nombre,
                          $this->claveGteMtto,
                          $this->email
                          );

    //$this->objParam = new ClsParam(PATH);
    //$this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);
    $this->objParam = new ClsParam($_SESSION['path']);
    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

  public function obtenerCatEmpleado(){
    $strSlc = "SELECT CodEmpleado,CTE.Nombre AS NombreEmpleado,CTGM.Nombre AS NombreGte,CTE.Email"
    			     . " FROM CatEmpleados AS CTE"
               . " INNER JOIN CatGteMatto AS CTGM"
               . " ON CTGM.CodGteMtto = CTE.ClaveGteMtto";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else
        return 'No hay registros que mostrar.';
  }
  public function obtenerClvGte()
  {
      $strUneg = "SELECT CodGteMtto,Nombre FROM CatGteMatto ORDER BY CodGteMtto";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
  }
   public function guardaCatEmpl()
   {
      $strIns = "INSERT INTO CatEmpleados(CodEmpleado,Nombre,claveGteMtto,Email) VALUES(?,?,?,?)";
      if($this->conDb->AddRegistro($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se agrego el registro ...";
   }
   public function obtenerCodEmpleado($varCodArea){
     $strSlc = "SELECT CodEmpleado,Nombre,claveGteMtto,Email FROM CatEmpleados WHERE CodEmpleado = '".$varCodArea."' ";

     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   public function UpdateCatEmpl()
   {
       $strUpd = 'UPDATE CatEmpleados SET Nombre = (?),claveGteMtto = (?), Email = (?)'
               . 'WHERE CodEmpleado = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->claveGteMtto,
                          $this->email,
                          $this->CodEmpleado
                   );
      if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
         return "Registro Actualizado";
      else
          return "No se agrego el registro ...";
   }
   // TODO: SE MODIFICO LA CONSULTA PARA QUE BUSQUE EN EL CAMPO DE EMPLEADOS
   public function buscarRegEmpl($cmpBusc)
   {
      $strSlc = "SELECT CodEmpleado,CTE.Nombre AS NombreEmpleado,CTGM.Nombre AS NombreGte,CTE.Email"
                              . " FROM CatEmpleados AS CTE"
                        . " INNER JOIN CatGteMatto AS CTGM"
                        . " ON CTGM.CodGteMtto = CTE.ClaveGteMtto"
                        . " WHERE CodEmpleado LIKE '%".$cmpBusc."%' OR"
                        . " CTE.Nombre LIKE '%".$cmpBusc."%' OR"
                        . " CTGM.Nombre LIKE '%".$cmpBusc."%' OR"
                        . " CTE.Email LIKE '%".$cmpBusc."%'";
      $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return 'Ningún elemento coincide';
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

   public function DeletCatEmpl($codArea)
   {
       $strDlt = "DELETE FROM CatEmpleados WHERE CodEmpleado = '".$codArea."'";

       $rsp = $this->conDb->QueryDml( $strDlt);
       if (count($rsp) > 0){
           return 'Registro eliminado';
       }
      else
          return 'no hay registros que eliminar.';
   }
}
?>
