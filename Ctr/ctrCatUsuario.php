<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modUsuario.php");
 date_default_timezone_set('America/Mexico_City');

 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modUsuario($_POST["Usuario"],$_POST["Nombre"],$_POST["contrasenia"],$_POST['cboPerfil'],$_POST['cboSolcte'],$_POST['cboGte']);
          $r = $reg->guardaCatUsuario();
          echo json_encode($r);
          break;
      case 'GET':
          if (isset($_GET['op']) && isset($_GET['varPerf'])) {
            $reg = new modUsuario('','','','','','');
            $r = $reg->obtenerPerfilCbo();
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['op']) && isset($_GET['varSolcte']))  {
            $reg = new modUsuario('','','','','','');
            $r = $reg->obtenerSolcteCbo();
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['opc']) && isset($_GET['varGte'])) {
            $reg = new modUsuario('','','','','','');
            $r = $reg->obtenerGteCbo();
            echo json_encode($r);
            break;
          }
          elseif(isset($_GET['varUser'])) {
            $reg = new modUsuario($_GET['varUser'], '', '','','','');
            $r = $reg->obtenerUsrData($_GET['varUser']);
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['cmpBusc'])) {
            $reg = new modUsuario($_GET['cmpBusc'],'','','','','');
            $r = $reg->buscarRegUsr($_GET['cmpBusc']);
            echo json_encode($r);
          }
          elseif (isset($_GET['CodPantalla'])) {
            $reg = new modUsuario('', '', '','','','');
            $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
            echo json_encode($r);
          }
          else {
            $reg = new modUsuario('','','','','','');
            $r = $reg->obtenerCatUsuarios();
            echo json_encode($r);
            break;
          }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modUsuario($_PUT["Usuario"], $_PUT["Nombre"],'',$_PUT["cboPerfil"],$_PUT['cboSolcte'],$_PUT['cboGte']);
          $r = $reg->updateCatUsr();
          echo json_encode($r);
          break;
      case'DELETE':
          if(isset($_GET['CodUsr']))
          {
             $reg = new modUsuario($_GET['CodUsr'], '', '','','','');
             $r = $reg->DeleteCatUsr($_GET['CodUsr']);
             echo json_encode($r);
          }
          else
          {
              $msg = "No hay parametro en la llamada del metodo de eliminacion";
              echo json_encode($msg);
          }
      break;
  }


?>
