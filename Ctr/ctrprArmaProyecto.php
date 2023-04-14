<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modprArmaProyecto.php");
 date_default_timezone_set('America/Mexico_City');

 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          switch($_POST['Op'])
          {
              case 1: //Add rubro y tareas al proyecto
                   $reg = new modprArmaProyecto($_POST['CodProyecto'],$_POST['CodRubro'],'','','');
                   $r = $reg->AddRubroProtecto();
                    echo json_encode($r);
              break;
              case 2: // Elimino rubro y tareas al prouecto
                  $reg = new modprArmaProyecto($_POST['CodProyecto'],$_POST['CodRubro'],'','','');
                  $r = $reg->DelRubroProtecto();
                  echo json_encode($r);
              break;
          }          
          break;
      case 'GET':
          switch($_GET['op'])
           {
                case 1:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_CatProyectosT();
                    echo json_encode($r);
                break;
                case 2:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_RubrosPrSlc($_GET['codProyecto']);
                    echo json_encode($r);
                break;
                case 3:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_RubrosAsigProy($_GET['codProyecto']);
                    echo json_encode($r);
                break;
                case 4:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->Obtener_RubroGte($_GET['codProyecto'],$_GET['codGte']);
                    echo json_encode($r);
                break;
                case 5:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->Obtener_TareaRubSlc($_GET['codProyecto'],$_GET['codRubro']);
                    echo json_encode($r);
                break;
                case 6:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_CatProyectosB($_GET['Uneg'],$_GET['Busq']);
                    echo json_encode($r);
                break;
                case 12:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_CatGteM();
                    echo json_encode($r);
                break;
                case 13:
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->obtener_Uneg();
                    echo json_encode($r);
                break;
                case 20:
                    $reg = new modprArmaProyecto('','','','',''); 
                    $r = $reg->Obtener_RubroSlc($_GET['codProyecto'],$_GET['codRubro']);
                    if(empty($r) == 1)
                        echo 'NR';
                    else
                        echo json_encode($r);
                break;
               
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);    
           switch($_PUT['Op'])
           {
                case 221:
                   $reg = new modprArmaProyecto('','','','','');
                   $r = $reg->Update_RubroSlc($_PUT["CodProyecto"],$_PUT["CodRubro"],$_PUT["FechaInicial"],
                                        $_PUT["FechaFinal"],$_PUT["CosPresupuestado"]);
                                     //print_r($_PUT); 
                   echo json_encode($r); 
                break;
                case 222:                   
                    $Tr = json_decode($_PUT['Registros'],true);
                    $reg = new modprArmaProyecto('','','','','');
                    $r = $reg->Update_Tareas($_PUT["CodProyecto"],$_PUT["CodRubro"], $Tr);
                    echo json_encode($r); 
                break;
           }
          break;
      case'DELETE':
           /*if(isset($_GET['CodRubro']))
           {
              $reg = new modCatRubros('', '', '');
              $r = $reg->DeleteprCatRubro($_GET['CodRubro']);
              echo json_encode($r);
           }
           else
           {
               $msg = "No hay parametro en la llamada del metodo de eliminacion";
               echo json_encode($msg);
           }*/
      break;

  }
?>
