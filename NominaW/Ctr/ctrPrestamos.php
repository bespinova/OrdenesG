<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modSolicitudPrestamo.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
      
		print_r("Fecha:".$_POST['fecSol']."\nCodEmpleado:".$_POST['codEmpleado']."\nCodArea:".$_POST['codArea']);
		print_r("\nSubArea:".$_POST['codSa']."\nPuesto:".$_POST['codP']."\nMotivo:".$_POST['mot']);
		print_r("\nCantidad:".$_POST['cantidad1']);
		print_r("\nEstatus:".$_POST['Estatus']);
        
          //$reg = new modSolicitud($_POST['codEmpleado'],$_POST["fecSol"],$_POST["cantidad1"]);
		  //print_r ("Fecha:".$_POST['fecSol']."\ncodigo:".$_POST['codEmpleado']."\nCantidad:".$_POST['cantidad1']);
        $reg = new modSolicitudPrestamo($_POST['fecSol'],$_POST['codEmpleado'],$_POST['codArea'],$_POST['codSa'],$_POST['codP'],$_POST['sueldo'],$_POST['cantidad1'],$_POST['mot'],$_POST['Estatus']);

          $r = $reg->SavePres();
          echo json_encode($r);
        
          break;
      case 'GET':
			//print_r("Entramos aca perros!!!");	
            $lg = new modSolicitudPrestamo();
            $dv = $lg->muestraPresSol('?','?','?','?','?','?','?','?','?');
            echo json_encode($dv);
          break;
      case 'PUT':
         
          break;
      case'DELETE':
           
      break;
          
  }
?>