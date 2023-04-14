<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();


class modUsuario
{
  private $Usuario;
  private $Nombre;
  private $password;
  private $codPerfil;
  private $codSolicitante;
  private $codGteMatto;

  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($Usuario,$Nombre,$password,$codPerfil,$codSolicitante,$codGteMatto)
  {
    $this->Usuario = $Usuario;
    $this->Nombre = $Nombre;
    $this->password = $password;
    $this->codPerfil = $codPerfil;
    $this->codSolicitante = $codSolicitante;
    $this->codGteMatto = $codGteMatto;

    $this->ArrDat = array($this->Usuario,
                          $this->Nombre,
                          $this->password,
                          $this->codPerfil,
                          $this->codSolicitante,
                          $this->codGteMatto
            );


        $this->objParam = new ClsParam($_SESSION['path']);
        $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }


  public function obtenerCatUsuarios(){
    $strSlc = "SELECT Usuario,SGU.Nombre AS NombreUsuario,Password,CodPerfil,CTS.Nombre AS NombreSolicitante,CTG.Nombre AS NombreGte"
                      . " FROM SgUsuarios AS SGU"
                      . " LEFT JOIN CatSolicitantes AS CTS"
                      . " ON SGU.CodSolicitante = CTS.CodSolicitante"
                      . " LEFT JOIN CatGteMatto AS CTG"
                      . " ON SGU.CodGteMatto = CTG.CodGteMtto";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
         return $rsp;
     }
    else
        return 'no hay registros que mostrar ....';
  }
  public function obtenerPerfilCbo()
  {
      $strUneg = "SELECT CodPerfil,Descripcion FROM SgPerfiles order by CodPerfil";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
  }
  public function obtenerSolcteCbo()
   {
      $strUneg = "SELECT CodSolicitante,Nombre from CatSolicitantes order by CodSolicitante";
      $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return  $rsp;
   }

   public function obtenerGteCbo()
    {
       $strUneg = "SELECT CodGteMtto,Nombre from CatGteMatto order by CodGteMtto";
       $rsp = $this->conDb->loadQueryARR_Asoc($strUneg);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return  $rsp;
    }
   public function guardaCatUsuario()
   {
      $strIns = "INSERT INTO SgUsuarios(Usuario,Nombre,Password,CodPerfil,CodSolicitante,"
              . "CodGteMatto) Values(?,?,?,?,?,?)";

      if($this->conDb->AddRegistro($strIns, $this->ArrDat))
         return "Registro Agregado";
      else
          return "No se pudo agregar el registro";
   }

   public function obtenerUsrData($varCodArea){
     $strSlc = "SELECT Usuario,Nombre,CodPerfil,CodSolicitante,CodGteMatto FROM SgUsuarios WHERE Usuario = '".$varCodArea."' ";
     $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
      if (count($rsp) > 0){
          return $rsp;
      }
     else
         return 'No hay registros que mostrar.';
   }

   // TODO: SE MODIFICO CONSULTA PARA QUE BUSQUE EN CodSolicitante Y CatGteMatto
   public function buscarRegUsr($cmpBusc)
   {
      $strSlc = "SELECT Usuario,SGU.Nombre AS NombreUsuario,CodPerfil,CTS.Nombre AS NombreSolicitante,CTG.Nombre AS NombreGte"
                    . " FROM SgUsuarios AS SGU"
                    . " LEFT JOIN CatSolicitantes AS CTS"
                    . " ON SGU.CodSolicitante = CTS.CodSolicitante"
                    . " LEFT JOIN CatGteMatto AS CTG"
                    . " ON SGU.CodGteMatto = CTG.CodGteMtto"
                    . " WHERE Usuario LIKE '%".$cmpBusc."%' OR"
                    . " SGU.Nombre LIKE '%".$cmpBusc."%' OR"
                    . " CodPerfil LIKE '%".$cmpBusc."%' OR"
                    . " CTS.Nombre LIKE '%".$cmpBusc."%' OR"
                    . " CTG.Nombre LIKE '%".$cmpBusc."%'";
      $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return 'Ningún elemento coincide';
   }


   public function updateCatUsr()
   {
       $strUpd = 'UPDATE SgUsuarios SET Nombre = (?),CodPerfil = (?),CodSolicitante =(?), CodGteMatto=(?)'
               . 'WHERE Usuario = (?)';
      $this->ArrDat = array(
                          $this->Nombre,
                          $this->codPerfil,
                          $this->codSolicitante,
                          $this->codGteMatto,
                          $this->Usuario
                   );
      if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
         return "Registro Actualizado";
      else
          return "Error al actualizar";
   }

   public function buscarRegSlcte($cmpBusc)
   {
      $strSlc = "Select * from CatSolicitantes where CodSolicitante like '%" .$cmpBusc. "%' or "
              . " Nombre like '%".$cmpBusc."%' OR "
              . " CodUNegocio like '%".$cmpBusc."%' OR "
              . " CodArea like '%" .$cmpBusc. "%'";
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
                    " where A.CodPerfil = '" .$_SESSION['CodPerfil']." '";

       $rsp = $this->conDb->loadQueryARR_Asoc($strSeg);

       if (count($rsp) > 0){
           return $rsp;
       }
      else
          return  $rsp;
   }

   public function DeleteCatUsr($idUser)
   {
       $strDlt = "DELETE FROM SgUsuarios WHERE Usuario = '".$idUser."'";
       $rsp = $this->conDb->QueryDml( $strDlt);
       if (count($rsp) > 0){
           return 'Registro eliminado';
       }
      else
          return 'no hay registros que eliminar.';
   }
}

?>
