<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modVistsPrestamo.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        
          break;
      case 'GET':
			//print_r("Entramos aca perros en la visualización de los prestamos!!!");	
            $lg = new modVistsPrestamo();
            $dv = $lg->muestraPresSol();
            echo json_encode($dv);
          break;
      case 'PUT':
         
          break;
      case'DELETE':
           
      break;
          
  }
?>