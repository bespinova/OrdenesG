<?php
	header("Content-Type: application/json");
 	header('Access-Control-Allow-Origin: *');
 	include_once("../Mod/modLogin.php"); 

	echo("Bienvenidos");
	echo "string".$_SERVER['REQUEST_METHOD'];

//$lg = new modLogin();

  echo "string".$_SERVER['REQUEST_METHOD'];
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $dv = $lg->buscarLogin($_POST['curp']);
        foreach ($dv[0] as $key => $value) {
          echo 1;
        }
          break;
      case 'GET':
      echo "Entrando al get";
                if($_GET['foto'] == 0)
                {
                   $dv = $lg->buscarEmpleado($_GET['curp']);
                   echo json_encode($dv);
                }
                else {
                  echo "aca esta";
                   $dv = $lg->getFoto($_GET['curp']);
                   echo json_encode($dv);
                }

          break;
      case 'PUT':
          break;
      case 'DELETE':
      break;

  }
?>