<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modSolVacaciones.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
			echo $_POST['codEmpleado'];
			echo $_POST['nombre'];
			echo $_POST['apeP'];
			echo $_POST['apeM'];
			echo $_POST['fecNac'];
			echo $_POST['tArea'];
			echo $_POST['tDep'];
			echo $_POST['tCarg'];
			echo $_POST['tBen'];
			echo $_POST['tJor'];
			echo $_POST['fecIni'];
			echo $_POST['fecFin'];
			echo $_POST['cubN'];
			echo $_POST['FechaSol'];
			echo $_POST['firmaG'];
			echo $_POST['firmaRh'];
			echo $_POST['firmaGG'];
			
			$reg = new modSolVacaciones($_POST['codEmpleado'],$_POST['nombre'],$_POST['apeP'],$_POST['apeM'],$_POST['fecNac'],$_POST['tArea'],$_POST['tDep'],$_POST['tCarg'],$_POST['tBen'],$_POST['tJor'],$_POST['fecIni'],$_POST['fecFin'],$_POST['cubN'],$_POST['FechaSol'],$_POST['firmaG'],$_POST['firmaRh'],$_POST['firmaGG']);
			$r = $reg->IngresaVacaciones();
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