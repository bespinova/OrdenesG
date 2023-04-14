<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modPrueba.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
         $_POST = json_decode(file_get_contents('php://input'),true);
          //echo 'Resultado: '.$_POST;
          $reg = new modPrueba(0,$_POST["Descripcion"], $_POST["Cantidad1"], $_POST["Cantidad2"], $_POST["Fecha"]);

          $r = $reg->guardarPrueba();
          echo json_encode($r);
          break;
      case 'GET':
           if(isset($_GET['CodReg']))
           {
               $reg = new modPrueba($_GET['CodReg'], '', 0, 0, '');
               $r = $reg->obtenerPrueba($_GET['CodReg']);
               echo json_encode($r);
           }
           else
           {
               $reg = new modPrueba(0, '', 0, 0, '');
               $r = $reg->obtenerPruebas();
               echo json_encode($r);
           }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          //echo 'Informacion: ' . file_get_contents('php://input');
          $reg = new modPrueba($_PUT["CodReg"],$_PUT["Descripcion"], $_PUT["Cantidad1"], $_PUT["Cantidad2"], $_PUT["Fecha"]);
          
          //echo "CodReg: ".$_GET['CodReg'];
          //echo "Datos a actualizar: ".json_encode($reg);
          $r = $reg->UpdatePrueba();
          echo json_encode($r);
          break;
      case'DELETE':
           if(isset($_GET['CodReg']))
           {
              $reg = new modPrueba($_GET['CodReg'], '', 0, 0, '');
              $r = $reg->DeletePrueba($_GET['CodReg']);

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
