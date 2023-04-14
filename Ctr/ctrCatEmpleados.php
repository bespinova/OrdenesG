<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modEmpleados.php");
date_default_timezone_set('America/Mexico_City');

switch ($_SERVER['REQUEST_METHOD'])
 {
    case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
        $reg = new modEmpleados($_POST["CodEmpleado"],$_POST["Nombre"],$_POST["claveGteMtto"],$_POST['Email']);
        $r = $reg->guardaCatEmpl();
        echo json_encode($r);
        break;
    case 'GET':
        if (isset($_GET['op']) && isset($_GET['varUne'])) {
          $reg = new modEmpleados('','','','');
          $r = $reg->obtenerClvGte();
          echo json_encode($r);
          break;
        }
        elseif(isset($_GET['varCodArea'])) {
          $reg = new modEmpleados($_GET['varCodArea'], '', '','');
          $r = $reg->obtenerCodEmpleado($_GET['varCodArea']);
          echo json_encode($r);
          break;
        }
        elseif (isset($_GET['cmpBusc'])) {
          $reg = new modEmpleados($_GET['cmpBusc'],'','','');
          $r = $reg->buscarRegEmpl($_GET['cmpBusc']);
          echo json_encode($r);
        }
        elseif (isset($_GET['CodPantalla'])) {
            $reg = new modEmpleados('', '', '','');
            $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
            echo json_encode($r);
        }
        else {
          $reg = new modEmpleados('','','','');
          $r = $reg->obtenerCatEmpleado();
          echo json_encode($r);
          break;
        }
        break;
    case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'),true);
        $reg = new modEmpleados($_PUT["CodEmpleado"],$_PUT["Nombre"],$_PUT["claveGteMtto"],$_PUT['Email']);
        $r = $reg->UpdateCatEmpl();
        echo json_encode($r);
        break;
    case'DELETE':
        if(isset($_GET['CodArea']))
        {
           $reg = new modEmpleados($_GET['CodArea'], '', '','');
           $r = $reg->DeletCatEmpl($_GET['CodArea']);
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
