<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modLogin.php");
//echo phpinfo();
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
            $_POST = json_decode(file_get_contents('php://input'),true);
            $reg = new modLogin($_POST["usuario"]);
            $r = $reg->getLogin($_POST["usuario"]);
            echo json_encode($r);
          break;
      case 'GET':
           if($_GET['opc'] == 1){
              //echo "aca estas";
              $lg = new modLogin($_GET['curp']);
              $dv = $lg->buscarEmpleado($_GET['curp']);
              echo json_encode($dv);
            }
            else {
              $reg = new modLogin('','','','','','');
              $r = $reg->cerrarSesion();
              echo "aca no perro";
              echo json_encode($r);
              break;
            }
          break;

      case'DELETE':
          break;

  }
?>
