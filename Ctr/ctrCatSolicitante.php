<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modSolicitante.php");
 date_default_timezone_set('America/Mexico_City');


 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modSolicitante($_POST["CodSolicitante"],$_POST["Nombre"],$_POST['Email'],$_POST["catUNegocio"],
                                  $_POST["codArea"]);
          $r = $reg->guardaCatSolicitante();
          echo json_encode($r);
          break;
     case 'GET':
          if (isset($_GET['op']) && isset($_GET['codUne'])) {
            $reg = new modSolicitante('','','','','');
            $r = $reg->obtenerOsG_CatUNeg();
            echo json_encode($r);
            break;
          }
          elseif (isset($_GET['op']) && isset($_GET['varData'])) {
            $reg = new modSolicitante('', '', '','','');
            $r = $reg->obtenerOsG_CatArea($_GET['varData']);
            echo json_encode($r);
            break;
          }
          elseif(isset($_GET['varCod'])){
            $reg = new modSolicitante($_GET['varCod'], '', '','','');
            $r = $reg->obtenerCodSolicita($_GET['varCod']);
            echo json_encode($r);
            break;
          }elseif (isset($_GET['cmpBusc'])) {
            $reg = new modSolicitante($_GET['cmpBusc'],'', '','','');
            $r = $reg->buscarRegSlcte($_GET['cmpBusc']);
            echo json_encode($r);
          }
          elseif (isset($_GET['CodPantalla'])) {
            $reg = new modSolicitante('', '', '','','');
            $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
            echo json_encode($r);
          }
          else {
            $reg = new modSolicitante('','','','','');
            $r = $reg->obtenerCatSolicita();
            echo json_encode($r);
            break;
          }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modSolicitante($_PUT["CodSolicitante"],$_PUT["Nombre"],$_PUT["Email"],$_PUT["catUNegocio"],$_PUT["codArea"]);
          $r = $reg->UpdateCatSolicita();
          echo json_encode($r);
          break;
      case'DELETE':
          if(isset($_GET['CodSolcte']))
          {
             $reg = new modSolicitante($_GET['CodSolcte'], '', '','','');
             $r = $reg->DeleteCatSolcte($_GET['CodSolcte']);
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
