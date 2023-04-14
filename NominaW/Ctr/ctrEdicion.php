<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modEdicion.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
        //print_r ($_POST);
       
        $reg = new modEdicion($_POST['curp'],$_POST['NombreEm'],$_POST['DireccionEm'],$_POST['TelefonoEm'],$_POST['CelularEm']);
        $r = $reg->EditarSave();
        echo json_encode($r);
          break;
      case 'GET':
          break;
      case 'PUT':
         
          break;
      case'DELETE':
           
      break;
          
  }
?>