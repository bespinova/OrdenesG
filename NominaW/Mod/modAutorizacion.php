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

  public function getLogin($usuario){
    $strSlc = "SELECT TOP 1 curp, CodEmpleado, Nombre, Autoriza FROM CatEmpleados WHERE curp=  '".$usuario."'";
    $rsp = $this->conDb->loadQueryARR_Asoc($strSlc);
     if (count($rsp) > 0){
          ini_set('session.cookie.lifetime',time() + (60*60*24));
          $_SESSION['id_app'] = $rsp;
          $_SESSION['curp'] = $rsp[0][0]['curp'];
          $_SESSION['CodEmpleado'] = $rsp[0][0]['CodEmpleado'];
          $_SESSION['Autoriza'] = $rsp[0][0]['Autoriza'];
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

  public  function BuscaVacG(){
   // print_r($usuario);
   $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep, convert(varchar, fecIni, 101) as fecIni,convert(varchar, fecFin, 101) as fecFin, convert(varchar, FechaSol, 101) as Solicitud 
   from catSolicitudes where tBen = 'Vacaciones' and firmaG ='0'";
   
   //echo $stdSql; 
   $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
   
   //print_r($rsp);
   if (count($rsp) > 0){
     
       return $rsp;
   }
   else
       return 'No tiene solicitudes de vacaciones ....';    
 }

 public  function BuscaGuarG($usuario){
  // print_r($usuario);
  $stdSql = "Select G.codEmpleado, (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre,
            A.Nombre as tDep,
			convert(varchar, G.fecGuard, 101) as fecIni,
            convert(varchar, G.fecSol, 101) as Solicitud ,G.autG
            from CatSolGuardias G 
            join CatEmpleados E on E.CodEmpleado = G.codEmpleado
            join CatAreas A on A.CodArea = E.CodArea
            where G.autG = 0";
   //"select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
  //from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'vacaciones' and firmaG !='1'";
  
  //print_r($stdSql); 
  $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
  
  //print_r($rsp);
  if (count($rsp) > 0){
    
      return $rsp;
  }
  else
      return 'No tiene solicitudes de Guardias ....';    
}

//checar estado de solicitudes de permisos, vacaciones y consultas
 public  function buscarSolVacEstatus($usuario){
  // print_r($usuario);
  $stdSql = "select convert(varchar, FechaSol, 101) as FechaSol, tBen, 
				firmaG = CASE
							WHEN firmaG = 0
							THEN 'En proceso'
							WHEN firmaG = 1
							THEN 'Aprobada'
							WHEN firmaG = 2
							THEN 'Rechazada'
							END
				,firmaRh = CASE
							WHEN firmaRh = 0
							THEN 'En proceso'
							WHEN firmaRh = 1
							THEN 'Aprobada'
							WHEN firmaRh = 2
							THEN 'Rechazada'
							END
				,firmaGG = CASE
							  WHEN firmaGG = 0
							  THEN 'En proceso'
							  WHEN firmaGG = 1
							  THEN 'Aprobada'
							  WHEN firmaGG = 2
							  THEN 'Rechazada'
							  END
 
					from catsolicitudes 
					where codEmpleado = '".$usuario."'";



/*  "select convert(varchar, FechaSol, 101) as FechaSol, tBen, firmaG, firmaRh, firmaGG 
					from catsolicitudes 
					where codEmpleado = '".$usuario."'";
*/
  //print_r($stdSql); 
  $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
  
  //print_r($rsp);
  if (count($rsp) > 0){
    
      return $rsp;
  }
  else
      return 'No tiene ninguna solicitud Pendientes ....';    
}

//checar estado de solicitudes de guardia
 public  function buscarSolGuarEstatus($usuario){
  // print_r($usuario);
  $stdSql = "select convert(varchar, fecSol, 101) as fecSol, convert(varchar, fecGuard, 101) as fecGuard, 
		autG = CASE
				WHEN autG = 0
				THEN 'En proceso'
				WHEN autG = 1
				THEN 'Aprobada'
				WHEN autG = 4
				THEN 'Rechazada'
		END 
					from catsolguardias 
					where codEmpleado = '".$usuario."'";
  
  
 /* "select convert(varchar, FechaSol, 101) as FechaSol, tBen, firmaG, firmaRh, firmaGG 
					from catsolicitudes 
					where codEmpleado = '".$usuario."'";
*/
  //print_r($stdSql); 
  $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
  
  //print_r($rsp);
  if (count($rsp) > 0){
    
      return $rsp;
  }
  else
      return 'No tiene ninguna solicitud Pendientes ....';    
}

 public  function BuscaVacRh($usuario){
    $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
    from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'vacaciones' and firmaG ='1' and firmaRh='0'";
    
   // print_r($stdSql);
    $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
    
    //print_r($rsp);
    if (count($rsp) > 0){
      
        return $rsp;
    }
    else
        return 'No tiene solicitudes de vacaciones ....';
 }

 public  function BuscaVacGg($usuario){
      $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
      from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'vacaciones' and firmaRh ='1' and firmaG ='1' and firmaGG='0'";
      
      print_r($stdSql);
      $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
      
      //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
      else
          return 'No tiene solicitudes de vacaciones ....';
 }
 public  function BuscaPerG($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'Permiso' and firmaG ='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene Solicitudes de Permiso';
  }

  public  function BuscaPerRh($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'Permiso' and firmaG ='1' and firmaRh='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene Solicitudes de Permiso';
  }

  public  function BuscaPerGg($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'Permiso' and firmaRh ='1' and firmaG ='1' and firmaGG='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene Solicitudes de Permiso';
  }

  public  function BuscaConsultaG($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'consulta' and firmaG ='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene solicitudes para Consultas';
  }

  public  function BuscaConsultaRh($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'consulta' and firmaG ='1' and firmaRh='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene solicitudes para Consultas';
  }

  public  function BuscaConsultaGg($usuario){
    // print_r($usuario);
     $stdSql = "select codEmpleado, (nombre + ' ' + apeP + ' ' + apeM) as Nombre, tDep,fecIni, fecFin, FechaSol as Solicitud 
     from catSolicitudes where FechaSol = '".$usuario."' and tBen = 'consulta' and firmaRh !='0' and firmaG !='0' and firmaGG='0'";
     
     //print_r($stdSql);
     $rsp = $this->conDb->loadQueryARR_Asoc($stdSql);
     
     //print_r($rsp);
      if (count($rsp) > 0){
        
          return $rsp;
      }
     else
         return 'No tiene solicitudes para Consultas';
  }

  public  function UpdateCatSolicitudes(){
    $strUpd = 'UPDATE catSolicitudes SET firmaG = (?),fechaG = (?)'
    . 'WHERE codEmpleado = (?), FechaSol = (?)';
    $this->ArrDat = array(
                  $this->CodEmpleado,
                  $this->FechaSol,
                  $this->firmaG,
                  $this->FechaA,
            );
    if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
    return "Registro Actualizado";
    else
    return "No se agrego el registro ...";
  }
  

}
?>
