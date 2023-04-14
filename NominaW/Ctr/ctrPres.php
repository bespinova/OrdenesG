<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modPres.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
        if($_POST['opc']==1){
            $reg = new modPres($_POST['FechaExpedicion'],$_POST['FechaAutorizacion'],$_POST['CodEmpleado'],$_POST['CodArea'],$_POST['CodSubArea'],$_POST['CodPuesto'],$_POST['Sueldo'],$_POST['MontoSolicitado'],$_POST['Monto'],$_POST['Descuento'],$_POST['DescViaNomina'],$_POST['MontoPagado']);
            $r = $reg->InsertPresN();
            echo json_encode($r);
        }else{
            $reg = new modPres($_POST['FechaExpedicion'],$_POST['FechaAutorizacion'],$_POST['CodEmpleado'],$_POST['CodArea'],$_POST['CodSubArea'],$_POST['CodPuesto'],$_POST['Sueldo'],$_POST['MontoSolicitado'],$_POST['Monto'],$_POST['Descuento'],$_POST['DescViaNomina'],$_POST['MontoPagado']);
            $r = $reg->InsertPres();
            echo json_encode($r);
        }
        
        
          break;
      case 'GET':
           
          break;
      case 'PUT':
         
          break;
      case'DELETE':
           
      break;
          
  }
?>