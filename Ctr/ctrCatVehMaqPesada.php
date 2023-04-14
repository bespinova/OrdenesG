<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modCatVehMaqPesada.php");
 date_default_timezone_set('America/Mexico_City');
 
 //
 //echo  'Informacion: ' . file_get_contents('php://input');
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatVehMaqPesada($_POST["CodUnidad"], $_POST["Descripcion"], $_POST["TipoVeh"],
                                        $_POST["Disponible"],$_POST["Estatus"],$_POST["Observaciones"]);
          $r = $reg->guardarCatVehMaqPesada();
          echo json_encode($r);
          break;
      case 'GET':
          switch($_GET['op'])
           {
                case 1:
                    $reg = new modCatVehMaqPesada ('', '', '','','','');
                    $r = $reg->obtenerVehMaqPesada();
                    echo json_encode($r);
                break;
                case 2:
                    $reg = new modCatVehMaqPesada('', '', '','','','');
                    $r = $reg->obtenerprCatVehMaqPesada1($_GET['CodUnidad']);
                    echo json_encode($r);
                break;
                case 3:
                    $reg = new modCatVehMaqPesada('', '', '','','','');
                    $r = $reg->obtenerprCatVehMaqPesadaB($_GET['cmpBusc']);
                    echo json_encode($r);
                break;
                case 4:
                    $reg = new  modCatVehMaqPesada('', '', '','','','');
                    $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
                    echo json_encode($r);
                break;
                case 10:
                    $reg = new modCatVehMaqPesada('', '', '','','','');
                    $r = $reg->obtener_CatTipoVeh();
                    echo json_encode($r);
                break;
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatVehMaqPesada($_PUT["CodUnidad"], $_PUT["Descripcion"], $_PUT["TipoVeh"],
                                   $_PUT["Disponible"],$_PUT["Estatus"],$_PUT["Observaciones"]);
          $r = $reg->UpdateVehMaqPesada();
          echo json_encode($r);
          break;
      case'DELETE':
           if(isset($_GET['CodUnidad']))
           {
              $reg = new modCatVehMaqPesada('', '', '','','','');
              $r = $reg->DeleteVehMaqPesada($_GET['CodUnidad']);
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
