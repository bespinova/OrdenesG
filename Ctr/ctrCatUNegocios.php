<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modCatUNegocios.php");
 date_default_timezone_set('America/Mexico_City');

 //
 //echo  'Informacion: ' . file_get_contents('php://input');
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatUNegocios($_POST["CodUNegocio"], $_POST["Nombre"], $_POST["Obs"]);
          $r = $reg->guardarCatUNegocios();
          echo json_encode($r);
          break;
      case 'GET':
           if( isset($_GET['cmpBusc']) && !isset($_GET['unReg']) )
           {
               $reg = new modCatUNegocios($_GET['cmpBusc'], '', '');
               $r = $reg->obtenerCatUNegociosB($_GET['cmpBusc']);
               echo json_encode($r);
           }
           else if(isset($_GET['cmpBusc']) && isset($_GET['unReg']))
           {
               $reg = new modCatUNegocios($_GET['cmpBusc'], '', '');
               $r = $reg->obtenerCatUNegocios1($_GET['cmpBusc']);
               echo json_encode($r);
           }
           else if(isset($_GET['CodPantalla'])){
                $reg = new modCatUNegocios('', '', '');
                $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
                echo json_encode($r);
           }
           else
           {
               $reg = new modCatUNegocios('', '', '');
               $r = $reg->obtenerCatUNegocios();
               echo json_encode($r);
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatUNegocios($_PUT["CodUNegocio"],$_PUT["Nombre"], $_PUT["Obs"]);
          $r = $reg->UpdateCatUNegocios();
          echo json_encode($r);
          break;
      case'DELETE':
           if(isset($_GET['CodUNegocio']))
           {
              $reg = new modCatUNegocios($_GET['CodUNegocio'], '', '');
              $r = $reg->DeleteCatUNegocios($_GET['CodUNegocio']);
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
