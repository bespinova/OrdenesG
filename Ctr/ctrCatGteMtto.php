<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modGteMtto.php");
 date_default_timezone_set('America/Mexico_City');

 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);

 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modGteMtto($_POST["codGteMtto"],$_POST["Nombre"],$_POST["Email"]);
          $r = $reg->guardaCatGte();
          echo json_encode($r);
          break;
      case 'GET':
          if(isset($_GET['varCodGte'])) {
            $reg = new modGteMtto($_GET['varCodGte'], '', '');
            $r = $reg->obtenerCodGte($_GET['varCodGte']);
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['cmpBusc'])) {
            $reg = new modGteMtto($_GET['cmpBusc'],'','');
            $r = $reg->buscarRegGte($_GET['cmpBusc']);
            echo json_encode($r);
          }elseif (isset($_GET['CodPantalla'])) {
            $reg = new modGteMtto('', '', '');
            $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
            echo json_encode($r);
          }
          else {
            $reg = new modGteMtto('','','');
            $r = $reg->obtenerCatGteMtto();
            echo json_encode($r);
            break;
          }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modGteMtto($_PUT["CodGteMtto"], $_PUT["Nombre"],$_PUT["Email"]);
          $r = $reg->UpdateCatGto();
          echo json_encode($r);
          break;
      case'DELETE':
          if(isset($_GET['CodGte']))
          {
             $reg = new modGteMtto($_GET['CodGte'], '', '');
             $r = $reg->DeletCatGte($_GET['CodGte']);
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
