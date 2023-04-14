<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modprCatRubroTarea.php");
 date_default_timezone_set('America/Mexico_City');
     
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
         $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatRubroTarea($_POST["CodTarea"], $_POST["Descripcion"], $_POST["CodRubro_fk"],0);
          $r = $reg->guardarprCatTareaRubros();
          echo json_encode($r);
          break;
      case 'GET':
          switch($_GET['op'])
           {
                case 1:
                    $reg = new modCatRubroTarea('','','','');
                    $r = $reg->obtenerCatRubroTareaT($_GET['CodRubro']); 
                    echo json_encode($r);
                break;
                case 2:
                    $reg = new modCatRubroTarea('', '', '','');
                    $r = $reg->obtenerprCatRubroTarea1($_GET['CodTarea']); 
                    echo json_encode($r);
                break;
                /*case 3:
                    $reg = new modCatRubros('', '', '');
                    $r = $reg->obtenerprCatRubrosB($_GET['cmpBusc']);
                    echo json_encode($r);
                break;*/
                case 4:
                    $reg = new  modCatRubroTarea('', '', '','');
                    $r = $reg->Obtener_Seg($_GET["CodPantalla"]);
                    echo json_encode($r);
                break;
                case 10:
                    $reg = new modCatRubroTarea('','','','');
                    $r = $reg->obtener_Rubros($_GET['CodGteMtto']);
                    echo json_encode($r);
                break;
                case 11:
                   $reg = new modCatRubroTarea('','','','');
                    $r = $reg->obtener_GteMtto();
                    echo json_encode($r); 
                break;
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatRubroTarea($_PUT["CodTarea"], $_PUT["Descripcion"], $_PUT["CodRubro_fk"],0);
          $r = $reg->UpdateCatRubrosTarea($_PUT["CodRubroAnt"]);
          echo json_encode($r);
          break;
      case'DELETE':
           if(isset($_GET['CodTarea']))
           {
              $reg = new modCatRubroTarea('', '', '','');
              $r = $reg->DeleteprCatRubroTarea($_GET['CodTarea']);
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

