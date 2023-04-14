<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modPrestamo.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
        
        

        if($_POST['opc']==1){
            /*$reg = new modPres($_POST['FechaExpedicion'],$_POST['FechaAutorizacion'],$_POST['CodEmpleado'],$_POST['CodArea'],$_POST['CodSubArea'],$_POST['CodPuesto'],$_POST['Sueldo'],$_POST['MontoSolicitado'],$_POST['Monto'],$_POST['Descuento'],$_POST['DescViaNomina'],$_POST['Estatus'],$_POST['MontoPagado']);
            $r = $reg->InsertPres();
            echo json_encode($r);*/
            //print_r ("Cod:".$_POST['CodEmpleado']."Cantidad:".$_POST['CantidadAutorizada']."Descuento:".$_POST['Descuento']."Autorizado".$_POST['Autorizado']."Fec1:".$_POST['FechaAutorizacion']."Estatus:".$_POST['Estatus']."Fec2:".$_POST['FechaCaptura']);
            $reg = new modPrestamo($_POST['CodEmpleado'],$_POST['CantidadAutorizada'],$_POST['Descuento'],$_POST['Autorizado'],$_POST['FechaAutorizacion'],$_POST['Estatus'],$_POST['FechaCaptura'],'','','','','','','','','');
            $r = $reg->ActualizarPresN();
            echo json_encode($r);
        }else{
            print_r ("Cod:".$_POST['CodEmpleado']."Cantidad:".$_POST['CantidadAutorizada']."Descuento:".$_POST['Descuento']."Autorizado".$_POST['Autorizado']."Fec1:".$_POST['FechaAutorizacion']."Estatus:".$_POST['Estatus']."Fec2:".$_POST['FechaCaptura']);
            $reg = new modPrestamo($_POST['CodEmpleado'],$_POST['CantidadAutorizada'],$_POST['Descuento'],$_POST['Autorizado'],$_POST['FechaAutorizacion'],$_POST['Estatus'],$_POST['FechaCaptura'],'','','','','','','','','');
            $r = $reg->ActualizarPres();
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