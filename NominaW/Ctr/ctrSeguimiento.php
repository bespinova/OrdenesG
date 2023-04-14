<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modSeguimiento.php");
//echo phpinfo();
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
            
          break;
      case 'GET':
           if($_GET['opc'] == 1){
              echo $_GET['curp'];
              $lg = new modSeguimiento($_GET['curp']);
              $dv = $lg->buscarSolVacEstatus($_GET['curp']);
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