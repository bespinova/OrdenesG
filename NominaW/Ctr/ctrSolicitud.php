<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../Mod/modSolicitud.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //echo  'Informacion: ' . file_get_contents('php://input');
 
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
        $_POST = json_decode(file_get_contents('php://input'),true);
        //print_r ($_POST);
       
        if($_POST['opc'] == 0){
          
          //echo 'Resultado: '.$_POST;
          $reg = new modSolicitud($_POST['codEmpleado'],$_POST["nombre"], $_POST["apeP"], $_POST["apeM"], 
                $_POST["fecNac"],$_POST["tArea"],$_POST["tDep"],$_POST["tCarg"],$_POST["tBen"],$_POST["tJor"],
                $_POST["fecIni"],$_POST["fecFin"],$_POST["cubN"],$_POST["FechaSol"]);
          echo 'Estas en el controlador   ---sa-as-sa';
          echo $r;
          $r = $reg->guardarSol();
          echo json_encode($r);
        }
        
        if($_POST['opc']==1){
            //$_POST = json_decode(file_get_contents('php://input'),true);
            //echo ($_POST['SoliFec']);

            $reg = new modSolicitud($_POST['codEmpleado'],$_POST["fecSol"],$_POST["fecGuard"]);
            //echo 'Hola '+ $reg;
            echo  $_POST['codEmpleado']."-".$_POST['fecSol']."-".$_POST['fecGuard'];
            //echo 'Estas en el controlador de la guardia';
            //echo $r;
            $r = $reg->SaveSolGuar();
            echo json_encode($r);
        }

        if($_POST['opc'] == 2){
          //$reg = new modSolicitud($_POST['codEmpleado'],$_POST["fecSol"],$_POST["cantidad1"]);
		  print_r ("Fecha:".$_POST['fecSol']."\ncodigo:".$_POST['codEmpleado']."\nCantidad:".$_POST['cantidad1']);
         // $reg = new modSolicitud($_POST['fecSol'],$_POST['codEmpleado'],$_POST['codArea'],$_POST['codSa'],$_POST['codP'],$_POST['sueldo'],$_POST['cantidad1'],$_POST['mot']);

          //$r = $reg->SavePres();
          //echo json_encode($r);
        }

        if($_POST['btnAuto'] == 1){
          $reg = new modSolicitud($_POST['btnAuto'],$_POST['CodEmpleado'],$_POST['Marca'],$_POST['Modelo'],$_POST['Anio'],$_POST['NumPuertas'],
                                  $_POST['Placas'],$_POST['Factura'],$_POST['TarCirculacion'],$_POST['NumSerie'],$_POST['NumMotor']);

          $r = $reg->SaveSegA();
          echo json_encode($r);
        }
         
        if($_POST['btnVida'] == 2){
          $reg = new modSolicitud($_POST['btnVida'],$_POST['CodEmpleado'],$_POST['Fuma'],$_POST['Toma'],$_POST['MontoS'],$_POST['MontoD']);
          
          //echo  $_POST['CodEmpleado']."-".$_POST['Ifuma']."-".$_POST['Itoma']."-".$_POST['MontoS']."-".$_POST['MontoD'];

          $r = $reg->SaveSegV();
          echo json_encode($r);
        }

        if($_POST['opc'] == 4){
          $reg = new modSolicitud($_POST['Cod'],$_POST['Acta']);
          
         // echo $_POST['Cod']."-".$_POST['Acta'];
          echo 'Que onda perro';
          //print_r($_POST['Cod']."-".$_POST['Acta']);
          $r = $reg->SaveUp();
          echo json_decode($r);
        }
          //metodo para hacer la actualización de la solicitud de prestamo
        if($_POST['pres'] == 6){
          echo 'Entraste a la opción 6';
          $reg = new modSolicitud($_POST['CodEmpleado'],$_POST['CantidadAutorizada'],$_POST['Descuento'],$_POST['Autorizado'],$_POST['Estatus']);
          $r = $reg->updSolPres();
          echo json_encode($r);
        }
          break;
      case 'GET':
           
          if($_GET['opc'] ==1){
            $lg = new modSolicitud();
            $dv = $lg->muestraPres();
            echo json_encode($dv);
          }
          break;
      case 'PUT':
         
          break;
      case'DELETE':
           
      break;
          
  }
?>