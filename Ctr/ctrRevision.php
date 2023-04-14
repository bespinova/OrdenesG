<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modRevision.php");
date_default_timezone_set('America/Mexico_City');

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $fechaActual = date('Y-m-d');
          $CodAuditor = 0;
          $reg = new modRevision('',$_POST["codContenido"],$fechaActual,$_POST['cmpObservacion'],$CodAuditor);
          $r = $reg->guardaRevision();
          echo json_encode($r);
  break;
  case 'GET':
    switch ($_GET['varCod']) {
      case '1':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraRubrosConProyc($_GET['varPrcy']);
          echo json_encode($r);
        break;
        case '2':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraRvsnPryct($_GET['varPrcyRvsn']);
          echo json_encode($r);
        break;
        case '3':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraCodContenido($_GET['codProyct'],$_GET['CodTarea']);
          echo json_encode($r);
        break;
        case '4':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraRevisionesContenido($_GET['varContenido']);
          echo json_encode($r);
        break;
        case '5':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraTareaDetalle($_GET['varTarea']);
          echo json_encode($r);
        break;
        case '6':
          $reg = new modRevision('','','','','');
          $r = $reg->muestraRevsnEImgn($_GET['varRvsn'],$_GET['varPrcy']);
          echo json_encode($r);
        break;
      default:

        break;
    }

    break;
  case 'PUT':

    break;

  case 'DELETE':

    break;

  default:
    echo json_encode("No hay ningún método de petición");
    break;
}
?>
