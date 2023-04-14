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


class modPres
{

    private $FechaExpedicion;
    private $FechaAutorizacion;
    private $CodEmpleado;
    private $CodArea;
    private $CodSubArea;
    private $CodPuesto;
    private $Sueldo;
    private $MontoSolicitado;
    private $Monto;
    private $Descuento;
    private $DescViaNomina;
    private $MontoPagado;

    private $ArrDat;
  var $conDb;
  var $objParam;
  function __construct($FechaExpedicion,$FechaAutorizacion,$CodEmpleado,$CodArea,$CodSubArea,$CodPuesto,$Sueldo,$MontoSolicitado,$Monto,$Descuento,$DescViaNomina,$MontoPagado)
  {
    $this->FechaExpedicion = $FechaExpedicion;
    $this->FechaAutorizacion = $FechaAutorizacion;
    $this->CodEmpleado = $CodEmpleado;
    $this->CodArea = $CodArea;
    $this->CodSubArea = $CodSubArea;
    $this->CodPuesto = $CodPuesto;
    $this->Sueldo = $Sueldo;
    $this->MontoSolicitado = $MontoSolicitado;
    $this->Monto = $Monto;
    $this->Descuento = $Descuento;
    $this->DescViaNomina = $DescViaNomina;
    $this->MontoPagado = $MontoPagado;

    $this->ArrDat = array($this->FechaExpedicion,
                          $this->FechaAutorizacion,
                          $this->CodEmpleado,
                          $this->CodArea,
                          $this->CodSubArea,
                          $this->CodPuesto,
                          $this->Sueldo,
                          $this->MontoSolicitado,
                          $this->Monto,
                          $this->Descuento,
                          $this->DescViaNomina,
                          $this->MontoPagado
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

    public function InsertPres(){
    $opc = 1;
    print_r("\nFechaExp:".$this->FechaExpedicion);
    print_r("\nFechaAut:".$this->FechaAutorizacion);
    print_r("\nCodE:".$this->CodEmpleado);
    print_r("\nCodA:".$this->CodArea);
      print_r("\nCodSA:".$this->CodSubArea);
      print_r("\nCodP:".$this->CodPuesto);
      print_r("\nSueldo:".$this->Sueldo); 
      print_r("\nMontoS:".$this->MontoSolicitado);
      print_r("\nMonto:".$this->Monto);
      print_r("\nDescu:".$this->Descuento);
      print_r("\nDesvNom:".$this->DescViaNomina);
     // print_r("\nEstatus:".$this->Estatus);
      print_r("\nMontoP:".$this->MontoPagado);
      //print_r($this->CodEmpleado);
      
      $strUpd = 'insert into PresPrestamos (FechaExpedicion,FechaAutorizacion,CodEmpleado,CodArea,CodSubArea,CodPuesto,Sueldo,MontoSolicitado,Monto,Descuento,DescViaNomina,MontoPagado) values (?,?,?,?,?,?,?,?,?,?,?,?)';
      //print_r("\nCodArea:".$this->CodArea);
      $this->EnvioMail($this->CodEmpleado,1,$this->FechaExpedicion);
      if($this->conDb->AddRegistro ($strUpd, $this->ArrDat))
        
      return "Registro Actualizado";
      else
      return "No se agrego el registro perro...";
  }

  public function InsertPresN(){
    
    $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where CodEmpleado = '".$Usuario."'";
    $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
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
      
      
      $mail->setFrom('sis_ordservicio_gc@grupoavimarca.com', 'Prestamo');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
        $mail->Subject = 'Solicitud de Prestamo';
        $mail->isHTML(true);

          $mailContent = "<h1>Tu solicitud de Prestamo NO ha sido autorizada</h1><br>".
          "<h1>Cualquier duda o aclaracion, comuniquese con su Gerente</h1>".
          //"<h1>Nombre del Gerente: '$NGerente'</h1>".
          //"<h1>Email: '$Gerente'</h1>".
          //"<h1>Celular: '$CelGe'</h1>".
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

   ////////////////////////////////////////////////EMAIL////////////////////////////////////////////////
     //ENVIO DE CORREO ELECTRONICO
     public function EnvioMail($Usuario,$opc,$FechaSol)
     {
     print_r("la opcion es:".$opc);
      //$SlcRecParam = "Select NombreParametro,Valor from ParametrosSys where NombreParametro like 'mail%'";
      //$rsp = $this->conDb->loadQueryARR_AsocPrm($SlcRecParam);
      
      $SlcGetDatGte = "select 'Email' as NombreParametro, Email as Valor from CatEmpleados where CodEmpleado = '".$Usuario."'";
      $rdg = $this->conDb->loadQueryARR_AsocPrm($SlcGetDatGte);
      
      $Info = "Select (E.Nombre +' '+E.ApellidoPaterno+' '+E.ApellidoMaterno) as Nombre, P.Monto, P.Descuento, G.Email, G.Celular, G.Nombre as GNom 
                from CatEmpleados E 
                join PresPrestamos P on E.CodEmpleado = P.codEmpleado 
                join CatGerentes G on E.CodArea = G.CodArea
                where E.CodEmpleado = '".$Usuario."' and P.FechaExpedicion = '".$FechaSol."' ";
      

     $inf = $this->conDb->loadQueryARR_Asoc($Info);
     print_r($Info);
     $nombre;
     $fecI;
     $fecF;
     $Gerente;
     $NGerente;
     $CelGe;
     foreach($inf as $key => $val){
          //print_r($val[0]["Nombre"]);
          $nombre =$val[0]["Nombre"];
          $fecI =$val[0]["Monto"];
          $fecF =$val[0]["Descuento"];
          $NGerente =$val[0]["GNom"];
          $Gerente = $val[0]["Email"];
         // $CelGe = $val[0]["Celular"];
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
      
      
      $mail->setFrom('sis_ordservicio_gc@grupoavimarca.com', 'Prestamo');
        //Set an alternative reply-to address
        //  $mail->addReplyTo('correo@dominio.tld', 'Magic');
        //Set who the message is to be sent to
      $mail->addAddress($rdg['Email'], 'Personal en General');

        //Set the subject line
        $mail->Subject = 'Solicitud de Prestamo';
        $mail->isHTML(true);

        if($opc == 1){
          $mailContent = "<h1>Tu solicitud de Prestamo ha sido autorizada</h1><br>".
          //"<h1>Iniciando el: '$fecI' y terminando el: '$fecF'</h1><br>".
          "<h1>Disfrute su Prestamo.</h1><br>".
          "<p>Correo enviado automaticamente por el sistema de Nomina Web</p>";
          $mail->Body = $mailContent; 
        }else{
          $mailContent = "<h1>Tu solicitud de Prestamo NO ha sido autorizada</h1><br>".
          "<h1>Cualquier duda o aclaracion, comuniquese con su Gerente</h1>".
          //"<h1>Nombre del Gerente: '$NGerente'</h1>".
          //"<h1>Email: '$Gerente'</h1>".
          //"<h1>Celular: '$CelGe'</h1>".
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