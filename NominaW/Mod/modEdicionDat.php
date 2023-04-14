<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
require("../core.php");

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
//date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

class modEdicionDat
{
  private $curp;
  private $Direccion;
  private $CtaBancarea;
  private $Celular;

	private $codEmpleado;

  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($curp,$Direccion,$CtaBancarea,$Celular,$Motivo)
  {
    $this->curp = $curp;
    $this->Direccion = $Direccion;
    $this->CtaBancarea = $CtaBancarea;
    $this->Celular = $Celular;
	//$this->NombreC = $NombreC;
	$this->Motivo = $Motivo;

    $this->ArrDat = array($this->curp,
                          $this->Direccion,
                          $this->CtaBancarea,
                          $this->Celular,
						  //$this->NombreC,
						  $this->Motivo
            );


    $this->objParam = new ClsParam(PATH);
    $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);
  
    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

    public function EditarSave(){
        print_r($this->curp);
        $strUpd = 'insert into tbl_modPer(Curp,Direccion,CtaBancarea,Celular) values (?,?,?,?)';
     echo $strUpd;
         $this->ArrDat = array(
                    $this->curp,
                    $this->Direccion,
                    $this->CtaBancarea,
                    $this->Celular
                );
        
		 //$this->SENTMAIL($this->curp);
		 $this->EnvioSolCarMod($this->curp);
     print_r($this->ArrDat);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }
	
	public function IngresaSol(){
        print_r($this->curp);
        $strUpd = 'insert into tbl_sol_emp(Curp,Motivo) values (?,?)';
     echo $strUpd;
         $this->ArrDat = array(
                    $this->curp,
                    $this->Motivo
                );
       $codEmpleado = 'PEMG861212MCSRND13';
     print_r($this->ArrDat);
	    $this->EnvioSolCar($this->curp);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }
	
	public function IngresaSolRec(){
        print_r($this->curp);
        $strUpd = 'insert into tbl_sol_emp(Curp,Motivo) values (?,?)';
     echo $strUpd;
         $this->ArrDat = array(
                    $this->curp,
                    $this->Motivo
                );
       $codEmpleado = 'PEMG861212MCSRND13';
     print_r($this->ArrDat);
	    $this->EnvioSolCarta($this->curp);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
    }

    public function ActualizarPresN(){
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
	  if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))
      //if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
      return "Registro Actualizado";
      else
      return "No se agrego el registro perro...";
  }

    public function InsertPres(){
    print_r("\nFechaExp:".$this->FechaExpedicion);
    print_r("\nFechaAut:".$this->FechaAutorizacion);
      print_r("\nCodE:".$this->CodEmpleado);
    /*  print_r("\nCodA:".$this->CodArea);
      print_r("\nCodSA:".$this->CodSubArea);
      print_r("\nCodP:".$this->CodPuesto);
      print_r("\nSueldo:".$this->Sueldo); 
      print_r("\nMontoS:".$this->MontoSolicitado);
      print_r("\nMonto:".$this->Monto);
      print_r("\nDescu:".$this->Descuento);
      print_r("\nDesvNom:".$this->DescViaNomina);
      print_r("\nEstatus:".$this->Estatus);
      print_r("\nMontoP:".$this->MontoPagado);*/
      //print_r($this->CodEmpleado);
      
      $strUpd = 'insert into PresPrestamos (FechaExpedicion,FechaAutorizacion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,MontoSolicitado,Monto,Descuento,DescViaNomina,Estatus,Monto) values (?,?,?,?)';
      //print_r("\nCodArea:".$this->CodArea);
      if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))
      return "Registro Actualizado";
      else
      return "No se agrego el registro perro...";
  }

   public function UpdateSolicitudG()
   {
	   $strIns = "Insert into tbl_modPer(Direccion,CtaBancarea,Celular) Values(?,?,?)"; 
     
       if($this->conDb->AddRegistro ($strIns, $this->ArrDat)){
            alert('Hola perro');
            return "Registro Agregado"; 
       }

       else
           return "No se agrego el registro ...";
       /* $strUpd = 'UPDATE catSolicitudes SET firmaG = (?),fechaG = GETDATE()'
        . 'WHERE codEmpleado = (?) and FechaSol = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";*/
   }

   public function UpdateSolicitudRh()
   {
        $strUpd = 'UPDATE catSolicitudes SET firmaRh = (?),fecharh = GETDATE()'
        . 'WHERE codEmpleado = (?) and FechaSol = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
   }

   public function UpdateSolicitudGg()
   {
        $strIns = 'UPDATE CatEmpleados SET VacTomadas = (?)'
        . 'WHERE CodEmpleado = (?)';

        
        $this->ArrDat = array(
               $this->FechaA,
               $this->CodEmpleado,
        );
        
        
        if($this->conDb->UpdateRegistro($strIns, $this->ArrDat)){
          $strUpd = 'UPDATE catSolicitudes SET firmaGg = (?),fechaGG = GETDATE()'
          . 'WHERE codEmpleado = (?) and FechaSol = (?)';
          echo $strUpd;
          $this->ArrDat = array(
                      $this->firmaG,
                      $this->CodEmpleado,
                      $this->FechaSol,
                  );
                  $this->EnvioMail($this->CodEmpleado,$this->firmaG,$this->FechaSol);
          if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
          return "Registro Actualizado";
        }else
        return "No se agrego el registro perro...";
   }

   public function UpdateEmpleado($cod,$tom)
   {
        $strUpd = 'UPDATE catEmpleados SET vactomadas = (?)'
        . 'WHERE codEmpleado = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
   }

   public function UpdateSolicitudGuar()
   {
     $strIns = 'UPDATE CatEmpleados SET VacTotal = (?)'
        . 'WHERE CodEmpleado = (?)';

        
        $this->ArrDat = array(
               $this->FechaA,
               $this->CodEmpleado,
        );
        

        if($this->conDb->UpdateRegistro($strIns, $this->ArrDat)){
          $strUpd = 'UPDATE CatSolGuardias SET autG = (?), fecGuard = GETDATE()'
          . 'WHERE codEmpleado = (?)';
          echo $strUpd;
          $this->ArrDat = array(
                      $this->firmaG,
                      $this->CodEmpleado,
                  );
          
          if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
          return "Registro Actualizado";
          else
          return "No se agrego el registro perro...";
     }

        
   }


   ////////////////////////////////Negaciones////////////////////////////////////////////////////////////////

   public function UpdateSolicitudGuarNet()
   {
        $strUpd = 'UPDATE CatSolGuardias SET autG = (?), fecGuard = GETDATE()'
        . 'WHERE codEmpleado = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
   }

   public function UpdateSolicitudGgNet()
   {
        $strUpd = 'UPDATE catSolicitudes SET firmaGg = (?),fechaGG = GETDATE()'
        . 'WHERE codEmpleado = (?) and FechaSol = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        $this->EnvioMailNet($this->CodEmpleado,$this->firmaG,$this->FechaSol);
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
   }

   public function UpdateSolicitudGNet()
   {
        $strUpd = 'UPDATE catSolicitudes SET firmaG = (?),fechaG = GETDATE()'
        . 'WHERE codEmpleado = (?) and FechaSol = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado x2";
        else
        return "No se agrego el registro perro...";
   }

   public function UpdateSolicitudRhNet()
   {
        $strUpd = 'UPDATE catSolicitudes SET firmaRh = (?),fecharh = GETDATE()'
        . 'WHERE codEmpleado = (?) and FechaSol = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                    $this->FechaSol,
                );
        
        if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
   }



   ////////////////////////////////////////////////EMAIL////////////////////////////////////////////////
     //ENVIO DE CORREO ELECTRONICO
     public function EnvioMail()
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.CodEmpleado = '10452'";

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
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Requerimientos');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de Requerimientos de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud de documentacion de Constancia de trabajo.</h1><br>".
		  "<p>Favor de responder al correo del empleado</p>".
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
	 
	public function EnvioSolCar($adm)
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.Curp = '".$adm."'";
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
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Requerimientos');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de Requerimientos de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud de documentacion de Constancia de trabajo.</h1><br>".
		  "<p>Favor de responder al correo del empleado</p>".
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
	
public function EnvioSolCarta($adm)
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.Curp = '".$adm."'";
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
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Requerimientos');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de Requerimientos de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud de documentacion de Carta de Recomendacion.</h1><br>".
		  "<p>Favor de responder al correo del empleado</p>".
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
	 	
	 
	 public function EnvioSolCarMod($adm)
     { 
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.Curp = '".$adm."'";
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
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Solicitud de modificacion');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de modificacion de informacion de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud de corrección de datos, favor de ingresar a Nomina20.</h1><br>".
		  "<p>La información a modificar se encuentra ahí.</p>".
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
	 
	 
	 
	 //ENVIO DE CORREO ELECTRONICO PARA MODIFICICACIÓN DATOS PERSONALES EN NOMINA20
     public function SENTMAIL($user)
     {
		 echo $user;
     //print_r("la opcion es:".$opc);
      //$SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      //$rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where Curp = 'PEMG861212MCSRND13'";
	  
	  echo $SlcGetDatGte;
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "select (e.Nombre +' '+e.ApellidoPaterno+' '+e.ApellidoMaterno) as nombre,
				mp.Direccion, mp.CtaBancarea, mp.Celular 
				from CatEmpleados e join tbl_modPer mp on e.Curp = mp.Curp
				where mp.Curp = '".$user."'";
	  
	  /*"Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre
               from CatEmpleados E 
               where E.CodEmpleado = '10452'";
*/
     $inf = $this->conDb->loadQueryARR_Asoc($Info);
     //print_r($Info);
     $nombre;
     $direccion;
     $ctabancarea;
     $celular;
	 
     foreach($inf as $key => $val){
          //print_r($val[0]["Nombre"]);
          $nombre =$val[0]["Nombre"];
		  $direccion =$val[0]["Direccion"];
		  $ctabancarea =$val[0]["CtaBancarea"];
		  $celular =$val[0]["Celular"];
     }

    // print_r("--->".$fecI);
      //$SlcPrioridad = "Select 'DscPrioridad' as NombreParametro, Descripcion as Valor  from CatPrioridad where CvePrioridad = '".$CvePrioridad."'";
      //$rPri = $this->conDb->loadQueryARR_AsocPrm($SlcPrioridad);
      
      //$os1 = $this->obtenerOsG($OsGen,3);     
      //echo "<br>UnidadNeg: ".$os1[0][0]["UNeg"];
     
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
      
      
      $mail->setFrom('nominaweb@grupoavimarca.com', 'Solicitud de modificacion');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
		echo $nombre;
        $mail->Subject = 'Solicitud de modificacion de datos personales de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Tiene una solicitud de actualizacion de datos personales.</h1><br>".
		  "<p>Datos a corregir</p>".
		  "<p>Direccion: '.$direccion.''</p>".
		  "<p>Cta. Bancaria: '.$ctabancarea.''</p>".
		  "<p>Celular: '.$celular.''</p>".
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

     public function EnvioMailNet($Usuario)
     {
      //$SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      //$rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where CodEmpleado = '".$Usuario."'";
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      //$SlcPrioridad = "Select 'DscPrioridad' as NombreParametro, Descripcion as Valor  from CatPrioridad where CvePrioridad = '".$CvePrioridad."'";
      //$rPri = $this->conDb->loadQueryARR_AsocPrm($SlcPrioridad);
      
      //$os1 = $this->obtenerOsG($OsGen,3);     
      //echo "<br>UnidadNeg: ".$os1[0][0]["UNeg"];
     
      $mail = new PHPMailer();
      $mail->isSMTP();
      $mail->Host = 'grupoavimarca.com';
        //Set the SMTP port number - likely to be 25, 465 or 587
      $mail->Port = '587';
        //Whether to use SMTP authentication
      $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
      $mail->Username = 'sis_ordservicio_gc';
        //Password to use for SMTP authentication
      $mail->Password = 'sTD+05Gc1430&G4v';
      $mail->SMTPSecure = 'tls';
      
      
      $mail->setFrom('sis_ordservicio_gc@grupoavimarca.com', 'Vacaciones');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Gerente de Mtto');

        //Set the subject line
        $mail->Subject = 'Solicitud de Vacaciones de: '.$Usuario.'';
        $mail->isHTML(true);
        $mailContent = "<h1>Tu solicitud de Vacaciones NO ha sido autorizada</h1><br>".
          "<p>Cualquier duda o aclaracion, comuniquese con su Gerente</p>".
           "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
        $mail->Body = $mailContent;
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

?>