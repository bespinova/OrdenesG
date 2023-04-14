<?php
  /**
* This example shows making an SMTP connection with authentication.
*/
//Import the PHPMailer class into the global namespace
include_once("../ClsParam.php"); 
include_once("../ClsMsSql.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

//Create a new PHPMailer instance
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$mail = new PHPMailer();
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages

//   $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//Set the hostname of the mail server
$mail->Host = 'grupoavimarca.com';
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = 'rchgar';
//Password to use for SMTP authentication
$mail->Password = 'remolachas';
$mail->SMTPSecure = 'tls';

//Set who the message is to be sent from
$mail->setFrom('rchgar@grupoavimarca.com', 'The Penetrator');
//Set an alternative reply-to address
//  $mail->addReplyTo('correo@dominio.tld', 'Magic');
//Set who the message is to be sent to
$mail->addAddress('rchgar@hotmail.com', 'Rodolfo');

//Set the subject line
$mail->Subject = 'Prueba de correo SMTP';
$mail->isHTML(true);
$mailContent = "<h1>Send HTML Email using SMTP in PHP</h1>
    <p>This is a test email I’m sending using SMTP mail server with PHPMailer.</p>";
$mail->Body = $mailContent;

//  $mail->Body = "Esta es una prueba de correo"; // Mensaje a enviar
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//Replace the plain text body with one created manually
//$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
echo 'Message sent!';
}
  

 $objParam =  new ClsParam("C:\\MisDatos\\_X\\phpPry\\OsGc\\configWeb.txt");
            $conDb = new ClsmsSql($objParam->Servidor,$objParam->Usuario,$objParam->Datos,$objParam->Passw); 
            //print $objParam->Servidor."<br>".$objParam->Usuario."<br>".$objParam->Datos."<br>".$objParam->Passw."<br>";
            
            if ($conDb->Conextar() == 0){              
              return "Error al conectarse en la base de datos";   
            }
            
//Inserta registro y recupero el registro agregado.
 $strIns = "Insert into tblPrb  (Campo1) values (?)";
 $ArrDat = array(
                'algo 1'
         );
 if($conDb->AddRegistro2($strIns, $ArrDat,'tblPrb')){
 
 }
               



?>

