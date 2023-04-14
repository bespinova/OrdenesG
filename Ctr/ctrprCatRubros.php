<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modprCatRubros.php");
 date_default_timezone_set('America/Mexico_City');
 
 //
 //echo  'Informacion: ' . file_get_contents('php://input');
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatRubros($_POST["CodRubro"], $_POST["Descripcion"], $_POST["PerteneceA"]);
          $r = $reg->guardarprCatRubros();
          echo json_encode($r);
          break;
      case 'GET':
          switch($_GET['op'])
           {
                case 1:
                    $reg = new modCatRubros('', '', '');
                    $r = $reg->obtenerprCatRubros();
                    echo json_encode($r);
                break;
                case 2:
                    $reg = new modCatRubros('', '', '');
                    $r = $reg->obtenerprCatRubros1($_GET['CodRubro']);
                    echo json_encode($r);
                break;
                case 3:
                    $reg = new modCatRubros('', '', '');
                    $r = $reg->obtenerprCatRubrosB($_GET['cmpBusc']);
                    echo json_encode($r);
                break;
                case 4:
                    $reg = new  modCatRubros('', '', '');
                    $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
                    echo json_encode($r);
                break;
                case 10:
                    $reg = new modCatRubros('', '', '');
                    $r = $reg->obtener_CatGteM();
                    echo json_encode($r);
                break;
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatRubros($_PUT["CodRubro"], $_PUT["Descripcion"], $_PUT["PerteneceA"]);
          $r = $reg->UpdateCatRubros();
          echo json_encode($r);
          break;
      case'DELETE':
           if(isset($_GET['CodRubro']))
           {
              $reg = new modCatRubros('', '', '');
              $r = $reg->DeleteprCatRubro($_GET['CodRubro']);
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
