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
		if($_POST['opc'] == 1){
			echo $_POST['curp'];
			echo $_POST['NombreC'];
			echo $_POST['Motivo'];
			echo $_POST['opc'];
			
			$reg = new modEdicionDat($_POST['curp'],'?','?','?',$_POST['Motivo']);
			$r = $reg->IngresaSol();
			echo json_encode($r);
		}else{
			print_r ($_POST['curp'],$_POST['Direccion']);
			echo $_POST['curp'];
			echo $_POST['Direccion'];
			echo $_POST['CtaBancarea'];
			echo $_POST['Celular'];
			$reg = new modEdicionDat($_POST['curp'],$_POST['Direccion'],$_POST['CtaBancarea'],$_POST['Celular']);
			$r = $reg->EditarSave();
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