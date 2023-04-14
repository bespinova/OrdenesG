<?php
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");

//echo phpinfo();
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

class modVistsPrestamo {
    
    private $ArrDat;

    var $conDb;
    var $objParam;
	
    public function __construct()
        {
           
            //FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicita,Motivo
            /*
               Ver si se puede conservar la conexion por session, o pasar la cnexion desde la pagina inicial
             *              */
            $this->objParam =  new ClsParam("C:\\NominaW\\configWeb.txt");
            $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw); 
            //echo $this->objParam->Servidor."<br>".$this->objParam->Usuario."<br>".$this->objParam->Datos."<br>".$this->objParam->Passw."<br>";
            
            if ($this->conDb->Conextar() > 0){              
              return "Error al conectarse en la base de datos";   
            }
        }
    
    public function __toString() {
        
    }

    /////////////////////////////GRID AUTORIZACIÓN PRESTAMOS///////////////////////////
	public function muestraPresSol()
    {
        $strUpd = "select P.CodEmpleado, convert(varchar,P.FechaExpedicion , 101) as Fecha_Solicitud, (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre,
        P.CodArea, A.Nombre as DescA, P.CodSubArea, Sa.Descripcion as DescSa, P.Sueldo, P.CantidadSolicitada,P.Motivo,E.CodPuesto
        from PresSolPrestamo P
        join CatAreas A on P.CodArea = A.CodArea
        join CatSubAreas Sa on P.CodSubArea = Sa.CodSubArea
        join CatEmpleados E on P.CodEmpleado = E.CodEmpleado
        Where P.Estatus = 0";

        $rsp = $this->conDb->loadQueryARR_Asoc($strUpd); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
        else 
           return 'no hay registros que mostrar ....';
    }


    public function actSolPres($cod){
        $struc = "select folio,foliosiguiente from Documentos where CodDocumento = 'SPRE'";

        $inf = $this->conDb->loadQueryARR_Asoc($struc);
        $folioA;
        $folioN;
        $folioAux;
        foreach($inf as $key => $val){
            //print_r($val[0]["Nombre"]);
            $folioA =$val[0]["folio"];
            $folioN =$val[0]["foliosiguiente"];
            $folioAux =$val[0]["folio"];
       }
       alert($folioA);
       print_r($folioN);
       print_r($folioAux);

       $uos = "update PresSolPrestamo set FolSolPrestamo = (?) where CodEmpleado = (?)";

       $this->ArrDat = array(
                $this->folioA,
                $this->cod
        ); 

        if($this->conDb->UpdateRegistro($uos, $this->ArrDat))             
            
          return "Registro Actualizado"; 
        else
           return "No se agrego el registro ...";
    }


    public function ActualizarPres(){
        print_r($this->CodEmpleado);
        $strUpd = 'UPDATE PresSolPrestamo SET CantidadAutorizada = (?), Descuento = (?), Autorizado = (?), FechaAutorizacion = GETDATE(),'
        . 'Estatus = (?), FechaCaptura = GETDATE() WHERE CodEmpleado = (?)';
       // echo $strUpd;
        $this->ArrDat = array(
                    $this->CantidadAutorizada,
                    $this->Descuento,
                    $this->Autorizado,
                    $this->Estatus,
                    $this->CodEmpleado
                );
        
       // print_r($this->ArrDat);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }

}

