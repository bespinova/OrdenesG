<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modAutVacaciones.php");
//echo phpinfo();
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
            break;
      case 'GET':
			$lg = new modAutVacaciones();
			$dv = $lg->BuscaSolVac();
			echo json_encode($dv);
          
            break;

      case'DELETE':
          break;
      
      case 'PUT':
  
        break;

  }
?>
