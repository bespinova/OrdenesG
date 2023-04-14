<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");
session_start();
class modAutorizacion
{

  private $usuario;
  private $nombre;
  private $password;
  private $codPerfil;
  private $codSolicitante;
  private $codGteMatto;
  private $curp;

  private $CodEmpleado;
  private $FechaSol;
  private $firmaG;
  private $FechaA;

  private $ArrDat;
  var $conDb;
  var $objParam;

  function __construct($usuario)
  {
    $this->usuario = $usuario;

    $this->ArrDat = array($this->usuario,
                          $this->curp
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

    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
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

  public  function BuscaSolVac(){
    print_r($usuario);
   $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep, convert(varchar, fecIni, 101) as fecIni,convert(varchar, fecFin, 101) as fecFin, convert(varchar, FechaSol, 101) as Solicitud 
   from catSolicitudes where tBen = 'Vacaciones' and firmaG ='0'";
   
   echo $stdSql; 
   $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
   
   print_r($rsp);
   if (count($rsp) > 0){
     
       return $rsp;
   }
   else
       return 'No tiene solicitudes de vacaciones ....';    
 }

}
?>
