<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modLogin.php");
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
            $_POST = json_decode(file_get_contents('php://input'),true);
            $reg = new modLogin('',$_POST["usuario"], $_POST["password"],'','','');
            $r = $reg->getLogin($_POST["usuario"],$_POST["password"]);
            echo json_encode($r);
          break;
      case 'GET':
            if (isset($_GET['var'])) {
              $reg = new modLogin('','','','','','');
              $r = $reg->obtieneParametrosServer();
              echo json_encode($r);
              break;
            }else {
              $reg = new modLogin('','','','','','');
              $r = $reg->cerrarSesion();
              echo json_encode($r);
              break;
            }


          break;

      case'DELETE':
          break;

  }
?>
