<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modAreas.php");
 date_default_timezone_set('America/Mexico_City');

 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modAreas($_POST["CodArea"],$_POST["Nombre"],$_POST["catUnNegogio"]);
          $r = $reg->guardaCatArea();
          echo json_encode($r);
          break;
      case 'GET':
          if (isset($_GET['op']) && isset($_GET['varUne'])) {
            $reg = new modAreas('','','');
            $r = $reg->obtenerOsG_CatUNeg();
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['op']) && isset($_GET['varArea']))  {
            $reg = new modAreas('', '','');
            $r = $reg->obtenerOsG_CatArea();
            echo json_encode($r);
            break;
          }
          elseif(isset($_GET['varCodArea'])) {
            $reg = new modAreas($_GET['varCodArea'], '', '');
            $r = $reg->obtenerCodArea($_GET['varCodArea']);
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['cmpBusc'])) {
            $reg = new modAreas($_GET['cmpBusc'],'','');
            $r = $reg->buscarRegArea($_GET['cmpBusc']);
            echo json_encode($r);
          }
          elseif (isset($_GET['CodPantalla'])) {
              $reg = new modAreas('', '', '');
              $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
              echo json_encode($r);
          }
          else {
            $reg = new modAreas('','','');
            $r = $reg->obtenerCatArea();
            echo json_encode($r);
            break;
          }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modAreas($_PUT["CodArea"], $_PUT["Nombre"],$_PUT["catUnNegogio"]);
          $r = $reg->UpdateCatAreas();
          echo json_encode($r);
          break;
      case'DELETE':
          if(isset($_GET['CodArea']))
          {
             $reg = new modAreas($_GET['CodArea'], '', '');
             $r = $reg->DeletCatArea($_GET['CodArea']);
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
