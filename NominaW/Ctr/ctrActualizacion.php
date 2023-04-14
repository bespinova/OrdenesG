<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modActualizar.php");
 date_default_timezone_set('America/Mexico_City');

//echo "hola";
//echo $_GET["opc"];
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          if($_GET["opc"]==1){
		  echo $_POST["CodEmpleado"];
            //echo $_POST["CodEmpleado"].$_POST["FechaSol"].$_POST["firmaG"].$_POST["FechaA"];
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudG();
            echo json_encode($r);
          }else if($_GET["opc"]==2){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudRh();
            echo json_encode($r);
          }else if($_GET["opc"]==3){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],$_POST["dias"]);
            $r = $reg->UpdateSolicitudGg();
            echo json_encode($r);
          }else if($_GET["opc"]==4){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],$_POST["FechaA"]);
            $r = $reg->UpdateSolicitudGuar();
            echo json_encode($r);
          }else if($_GET["opc"]==1 && $_GET["firmaG"]==4){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudGNet();
            echo json_encode($r);
          }else if($_GET["opc"]==2 && $_GET["firmaG"]==4){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudRhNet();
            echo json_encode($r);
          }else if($_GET["opc"]==3 && $_GET["firmaG"]==4){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudGGNet();
            echo json_encode($r);
          }else if($_GET["opc"]==4 && $_GET["firmaG"]==4){
            $reg = new modActualizar($_POST["CodEmpleado"],$_POST["FechaSol"],$_POST["firmaG"],'');
            $r = $reg->UpdateSolicitudGuarNet();
            echo json_encode($r);
          }
          break;
     case 'GET':
          echo "que onda compa";
          break;
      case 'PUT':
            /*echo 'Estas acá';
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modActualizar($_PUT["CodEmpleado"],$_PUT["FechaSol"],$_PUT["firmaG"],$_PUT["FechaA"]);
          $r = $reg->UpdateSolicitudG();
          echo json_encode($r);*/
          break;
      case'DELETE':
          
      break;

  }

?>