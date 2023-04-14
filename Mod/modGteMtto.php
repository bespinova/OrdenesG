<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();
class modGteMtto
{
  private $codGteMtto;
  private $Nombre;
  private $email;


  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($codGteMtto,$Nombre,$email)
  {
    $this->codGteMtto = $codGteMtto;
    $this->Nombre = $Nombre;
    $this->email = $email;

    $this->ArrDat = array($this->codGteMtto,
                          $this->Nombre,
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
  public function obtenerCatGteMtto(){
    $strSlc = "SELECT CodGteMtto,Nombre,Email FROM CatGteMatto";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else
        return 'No hay registros que mostrar';
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

   public function guardaCatGte()
   {
      $strIns = "INSERT INTO CatGteMatto (CodGteMtto,Nombre,Email) Values(?,?,?)";

      if($this->conDb->AddRegistro($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se agrego el registro";
   }
   public function obtenerCodGte($varCodGte){
     $strSlc = "SELECT CodGteMtto,Nombre,Email FROM CatGteMatto WHERE CodGteMtto = '".$varCodGte."' ";
     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   public function UpdateCatGto()
   {
       $strUpd = 'UPDATE CatGteMatto SET Nombre = (?),Email = (?) WHERE CodGteMtto = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->email,
                          $this->codGteMtto
                   );
      if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
         return "Registro Actualizado";
      else
          return "No se agrego el registro";
   }
   public function buscarRegGte($cmpBusc)
   {
      $strSlc = "SELECT * FROM CatGteMatto where CodGteMtto like '%" .$cmpBusc. "%' OR "
              . " Nombre like '%".$cmpBusc."%' OR "
              . " Email like '%".$cmpBusc."%'";
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
                    " where A.CodPerfil = '" .$_SESSION['CodPerfil']." '";

       $rsp = $this->conDb->loadQueryARR_Asoc($strSeg);

       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return  $rsp;
   }

   public function DeletCatGte($codGte)
   {
       $strDlt = "DELETE FROM CatGteMatto WHERE CodGteMtto = '".$codGte."'";
       $rsp = $this->conDb->QueryDml($strDlt);
       if (count($rsp) > 0){
           return 'Registro eliminado';
       }
      else
          return 'no hay registros que eliminar.';
   }
}

?>
