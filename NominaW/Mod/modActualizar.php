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


class modActualizar
{
  private $CodEmpleado;
  private $FechaSol;
  private $firmaG;
  private $FechaA;
  private $cod;
  private $tom;

  private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($CodEmpleado,$FechaSol,$firmaG,$FechaA)
  {
    $this->CodEmpleado = $CodEmpleado;
    $this->FechaSol = $FechaSol;
    $this->firmaG = $firmaG;
    $this->FechaA = $FechaA;

    $this->ArrDat = array($this->CodEmpleado,
                          $this->FechaSol,
                          $this->firmaG,
                          $this->FechaA
            );


    $this->objParam = new ClsParam(PATH);
    $this->conDb = new ClsmsSql($this->objParam->Servidor,$this->objParam->Usuario,$this->objParam->Datos,$this->objParam->Passw);
    //$this->conDb = new ClsmsSql("SDT4\GAVSD4","sa","NominaPrb","G4v0217g0");
  //  $this->objParam = new ClsParam($_SESSION['path']);
    //$this->conDb = new ClsmsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);


    if ($this->conDb->Conextar() > 0){
      return "Error al conectarse en la base de datos";
    }
  }

   public function UpdateSolicitudG()
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
        return "Registro Actualizado";
        else
        return "No se agrego el registro perro...";
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
          $strUpd = 'UPDATE CatSolGuardias SET autG = (?), fecAut = GETDATE()'
          . 'WHERE codEmpleado = (?)';
          echo $strUpd;
          $this->ArrDat = array(
                      $this->firmaG,
                      $this->CodEmpleado,
                  );
          
		  $this->EnvioSolCar($this->codEmpleado);
          if($this->conDb->UpdateRegistro($strUpd, $this->ArrDat))
          return "Registro Actualizado";
          else
          return "No se agrego el registro perro...";
     }

        
   }


   ////////////////////////////////Negaciones////////////////////////////////////////////////////////////////
   
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
        $mail->Subject = 'Aprobacion de dia de guardia.';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Solicitud Aprobada.</h1><br>".
		  "<p></p>".
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

//negacion de solicitud guardia
	public function EnvioSolCarNegativo($adm)
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
        $mail->Subject = 'No se autoriza su dia de guardia solicitado.';
        $mail->isHTML(true);

        if($opc == ''){
          $mailContent = "<h1>Solicitud no autorizada.</h1><br>".
		  "<p></p>".
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
   

   public function UpdateSolicitudGuarNet()
   {
        $strUpd = 'UPDATE CatSolGuardias SET autG = (?), fecAut = GETDATE()'
        . 'WHERE codEmpleado = (?)';
        echo $strUpd;
        $this->ArrDat = array(
                    $this->firmaG,
                    $this->CodEmpleado,
                );
        
		echo $CodEmpleado;
		//print_r"Holaaaaaaaaaaaaaaaa";
		
		print_r ($CodEmpleado);
		$this->EnvioSolCarNegativo($this->CodEmpleado);
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
        return "Registro Actualizado 2";
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
        return "Registro Actualizado333";
        else
        return "No se agrego el registro perro...";
   }



   ////////////////////////////////////////////////EMAIL////////////////////////////////////////////////
     //ENVIO DE CORREO ELECTRONICO
     public function EnvioMail($Usuario,$opc,$FechaSol)
     {
     print_r("la opcion es:".$opc);
      //$SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      //$rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where CodEmpleado = '".$Usuario."'";
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre, S.fecIni, S.fecFin, G.Email, G.Celular, G.Nombre as GNom 
               from CatEmpleados E 
               join catSolicitudes S on E.CodEmpleado = S.codEmpleado 
               join CatGerentes G on E.CodArea = G.CodArea
               where E.CodEmpleado = '".$Usuario."' and FechaSol = '".$FechaSol."' ";

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
          $fecI =$val[0]["fecIni"]->format('d-m-Y');
          $fecF =$val[0]["fecFin"]->format('d-m-Y');
          $NGerente =$val[0]["GNom"];
          $Gerente = $val[0]["Email"];
          $CelGe = $val[0]["Celular"];
     }

     
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
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
        $mail->Subject = 'Solicitud de Vacaciones de: '.$nombre.'';
        $mail->isHTML(true);

        if($opc == 1){
          $mailContent = "<h1>Tu solicitud de Vacaciones ha sido autorizada</h1><br>".
          "<h1>Iniciando el: '$fecI' y terminando el: '$fecF'</h1><br>".
          "<h1>Disfrute sus vacaciones.</h1><br>".
          "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent; 
        }else{
          $mailContent = "<h1>Tu solicitud de Vacaciones NO ha sido autorizada</h1><br>".
          "<h1>Cualquier duda o aclaracion, comuniquese con su Gerente</h1>".
          "<h1>Nombre del Gerente: '$NGerente'</h1>".
          "<h1>Email: '$Gerente'</h1>".
          "<h1>Celular: '$CelGe'</h1>".
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
	 
	 //envio de mensaje de negación de día de guardia
	public function EnvioSolCarN($adm)
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
          print_r($val[0]["Nombre"]);
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
          $mailContent = "<h1>Su solicitud ha sido rechazada.</h1><br>".
		  "<p>Cualquier inconformidad comunicarse con su jefe inmediato.</p>".
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

?>