<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modEdicionDat.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
			echo $_POST['curp'];
			echo $_POST['NombreC'];
			echo $_POST['Motivo'];
			echo $_POST['opc'];
			
			$reg = new modEdicionDat($_POST['curp'],'?','?','?',$_POST['Motivo']);
			$r = $reg->IngresaSolRec();
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