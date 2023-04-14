<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();
class modLogin
{

  private $usuario;
  private $nombre;
  private $password;
  private $codPerfil;
  private $codSolicitante;
  private $codGteMatto;


  private $ArrDat;
  var $conDb;
  var $objParam;

  function __construct($usuario,$nombre,$password,$codPerfil,$codSolicitante,$codGteMatto)
  {
    $this->usuario = $usuario;
    $this->nombre = $nombre;
    $this->codPerfil = $codPerfil;
    $this->codSolicitante = $codSolicitante;
    $this->codGteMatto = $codGteMatto;


    $this->ArrDat = array($this->usuario,
                          $this->nombre,
                          $this->password,
                          $this->codPerfil,
                          $this->codSolicitante,
                          $this->codGteMatto
                          );

    $this->objParam = new ClsParam(PATH);
      $_SESSION['data_conexion'] = $this->objParam;
      $_SESSION['Servidor'] = $this->objParam->Servidor;
      $_SESSION['Passw'] = $this->objParam->Passw;
      $_SESSION['Datos'] = $this->objParam->Datos;
      $_SESSION['Usuario'] = $this->objParam->Usuario;

      $_SESSION['Servidor2'] = $this->objParam->Servidor2;
      $_SESSION['Passw2'] = $this->objParam->Passw2;
      $_SESSION['Datos2'] = $this->objParam->Datos2;
      $_SESSION['Usuario2'] = $this->objParam->Usuario2;

      $_SESSION['Servidor3'] = $this->objParam->Servidor3;
      $_SESSION['Passw3'] = $this->objParam->Passw3;
      $_SESSION['Datos3'] = $this->objParam->Datos3;
      $_SESSION['Usuario3'] = $this->objParam->Usuario3;

      $_SESSION['path'] = $this->objParam->path;

    $this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
	//$this->conDb = new ClsmsSql('192.168.1.65\DTS','sa','GcOSMtto','G4v0514g0');

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

  public function getLogin($usuario,$password){
    $strSlc = "SELECT TOP 1 Usuario,Nombre,Password,CodPerfil,CodSolicitante,CodGteMatto FROM SgUsuarios WHERE Usuario=  '".$usuario."'  AND Password = '".$password."' ";
	//$strSlc = "SELECT TOP 1 Usuario,Nombre,Password,CodPerfil,CodSolicitante,CodGteMatto FROM SgUsuarios WHERE Usuario=  'ROOT'  AND Password = 'REMOLACHAS' ";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
          ini_set('session.cookie.lifetime',time() + (60*60*24));
          $_SESSION['id_app'] = $rsp;
          $_SESSION['codSolicitante'] = $rsp[0][0]['CodSolicitante'];
          $_SESSION['codGteMatto'] = $rsp[0][0]['CodGteMatto'];
          $_SESSION['Nombre'] = $rsp[0][0]['Nombre'];
          $_SESSION['CodPerfil'] = $rsp[0][0]['CodPerfil'];
          return $rsp;
     }
    else
        return 'No hay registros que mostrar.';
  }
  public function cerrarSesion(){
    if(session_unset()){
      return "La sesión se elimino";
    }else {
      return "No se elimino la sesión";
    }
  }

  public function obtieneParametrosServer(){
    return $_SESSION['Servidor']."-".$_SESSION['Datos'];
  }
}
?>
