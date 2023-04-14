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
  private $curp;

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

  public function getLogin($usuario){
    $strSlc = "SELECT TOP 1 curp, CodEmpleado, Nombre, Autoriza,VacTotal,VacTomadas,IdDepto, nameImg, nameImgPer FROM CatEmpleados WHERE curp=  '".$usuario."'";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
          ini_set('session.cookie.lifetime',time() + (60*60*24));
          $_SESSION['id_app'] = $rsp;
          $_SESSION['curp'] = $rsp[0][0]['curp'];
          $_SESSION['CodEmpleado'] = $rsp[0][0]['CodEmpleado'];
          $_SESSION['Autoriza'] = $rsp[0][0]['Autoriza'];
          $_SESSION['VacTotal'] = $rsp[0][0]['VacTotal'];
          $_SESSION['VacTomadas'] = $rsp[0][0]['VacTomadas'];
		  $_SESSION['IdDepto'] = $rsp[0][0]['IdDepto'];
		  $_SESSION['nameImg'] = $rsp[0][0]['nameImg'];
		  $_SESSION['nameImgPer'] = $rsp[0][0]['nameImgPer'];
		  //$_SESSION['ImgFrente'] = $rsp[0][0]['ImgFrente'];
         //$_SESSION['nombre'] = $rsp[0][0]['nombre'];
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

  public  function buscarEmpleado($usuario){
   // print_r($usuario);
    $stdSql = "Select E.codEmpleado,E.ApellidoPaterno, E.ApellidoMaterno,E.Nombre,E.CodPuesto,E.RFC,E.CtaBancarea,E.Direccion,
    E.Telefono,E.DescInfonovit,E.CodArea,E.CodSubArea,E.DescFonacot,E.Celular,E.NombreEm,E.DireccionEm,
    E.TelefonoEm,E.CelularEm,E.Curp, A.Nombre as DescArea, Sa.Descripcion as DescSa, P.Descripcion as Pdesc,0 as Prestamo,
    P.SalarioDiario, P.Sueldo, P.CodTipoNomina, E.Autoriza, E.VacTomadas, E.VacTotal, (E.VacTotal-E.VacTomadas) as Restantes,P.Sueldo,
	E.IdDepto
    from CatEmpleados E
    join CatAreas A on E.CodArea = A.CodArea
    join CatSubAreas Sa on E.CodSubArea = Sa.CodSubArea
    join CatPuestos P on E.CodPuesto = P.CodPuesto
    where curp = '".$usuario."'";
    //print_r($stdSql);
    $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
    
    //print_r($rsp);
     if (count($rsp) > 0){
       
         return $rsp;
     }
    else
        return 'CURP no encontrado ....';
 }

}
?>
