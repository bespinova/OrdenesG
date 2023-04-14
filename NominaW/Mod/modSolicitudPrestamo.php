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

class modSolicitudPrestamo {
    private $FechaExpedicion;
    private $CodEmpleado;
	private $CodArea;
	private $CodSubArea;
	private $CodPuesto;
	private $Sueldo;
	private $CantidadSolicitada;
	private $Motivo;
	private $Estatus;
    
    private $ArrDat;

    var $conDb;
    var $objParam;
	
    public function __construct($FechaExpedicion,$CodEmpleado,$CodArea,$CodSubArea,$CodPuesto,$Sueldo,$CantidadSolicitada,$Motivo,$Estatus)
        {
            $this->FechaExpedicion = $FechaExpedicion;
			$this->CodEmpleado = $CodEmpleado;
			$this->CodArea = $CodArea;
			$this->CodSubArea = $CodSubArea;
			$this->CodPuesto = $CodPuesto;
			$this->Sueldo = $Sueldo;
			$this->CantidadSolicitada = $CantidadSolicitada;
			$this->Motivo = $Motivo;
			$this->Estatus = $Estatus;
            $this->ArrDat = array($this->FechaExpedicion,
                                  $this->CodEmpleado,
                                  $this->CodArea,
                                  $this->CodSubArea,
                                  $this->CodPuesto,
                                  $this->Sueldo,
                                  $this->CantidadSolicitada,
                                  $this->Motivo,
								  $this->Estatus
                    );
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
    
    public function SavePres(){
        

        $strIns = "Insert into PresSolPrestamo(FechaExpedicion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,CantidadSolicitada,Motivo,Estatus) Values (?,?,?,?,?,?,?,?,?)";
        
		
        //"insert into CatSolPrestamos(CodEmpleado,FecSolicitud,CantidadSol) values(?,?,?)";
        echo $this->ArrDat;
        echo $strIns;
        if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            //$this->actSolPres($this->CodEmpleado);
            return "Registro Agregado"; 
            }
            else
                return $this->ArrDat;
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
        Where P.Estatus = 1";

        $rsp = $this->conDb->loadQueryARR_Asoc($strUpd); 
       //print_r($rsp);
        if (count($rsp) > 0){ 
            return $rsp;
        }   
        else 
           return 'no hay registros que mostrar ....';
    }

    public function muestraPres()
    {
        $strUpd = "select P.CodEmpleado, P.FechaExpedicion as Fecha_Solicitud, (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre,
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

    public function updSolPres(){
        $trisp = 'UPDATE PresSolPrestamo set CantidadAutorizada = (?), Descuento = (?), Autorizado = (?), FechaAutorizacion = GETDATE(), '
        . 'Estatus = (?), FechaCaptura = GETDATE() WHERE CodEmpleado = (?)';

        //print_r($trisp);
        $this->ArrDat = array(
                    $this->CantidadAutorizada,
                    $this->Descuento,
                    $this->Autorizado,
                    $this->Estatus,
                    $this->CodEmpleado
        ); 

        //print_r($this->ArrDat);
        if($this->conDb->UpdateRegistro($trisp, $this->ArrDat)){
            print_r($this->ArrDat);
            /*$strUpd = "Insert into PresPrestamos (FechaExpedicion, FechaAutorizacion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,
            MontoSolicitado,Monto,Descuento,DescViaNomina,Estatus) values (?,?,?,?,?,?,?,?,?,?,?,?) ";
            echo $strUpd;
        
            if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))*/
            return "Registro Actualizado de la solicitud";
        }else
          return "No se agrego el registro perro...";
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

	//envio de correos electronicos

public function EnvioSolCar($adm)
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.CodEmpleado = '".$adm."'";
	 echo $Info;
     $inf = $this->conDb->loadQueryARR_Asoc($Info);
     //print_r($Info);
     $nombre;
     $fecI;
     $fecF;
     $Gerente;
     $NGerente;
     $CelGe;
     foreach($inf as $key => $val){
          //print_r($val[0]["Nombre"]);
          $nombre =$val[0]["Nombre"];
     }

     echo $nombre;
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'grupoavimarca.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = '587';
      $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
      $mail->Username = 'nominaweb';
        //Password to use for SMTP authentication
      $mail->Password = 'NqtuEf3S17T6GcD';
      $mail->SMTPSecure = 'tls';
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Solicitud de dia de guardia');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de dia de guardia de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud para un dia de guardia.</h1><br>".
		  "<p>Puede ver la solicitud desde la nomina20</p>".
          "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent; 
        }else{
          $mailContent = "<h1>Tu solicitud de Requerimientos NO ha sido autorizada</h1><br>".
          "<h1>Cualquier duda o aclaracion, comuniquese con su Gerente</h1>".
           "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent;
        }

         if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            return 0;
         } 
         else {
            //echo 'Message sent!';
            return 1;
         }
     }
}

