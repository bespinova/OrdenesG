<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modAutorizacion.php");
//echo phpinfo();
  switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
            /*$_POST = json_decode(file_get_contents('php://input'),true);
            $reg = new modLogin($_POST["usuario"]);
            $r = $reg->getLogin($_POST["usuario"]);
            echo json_encode($r);*/
          break;
      case 'GET':
          if($_GET['opcs']==1 && $_GET['opc']==1){
            $lg = new modAutorizacion($_GET['fecha']);
            $dv = $lg->BuscaVacG();
            echo json_encode($dv);
           }else if($_GET['opcs']==2 && $_GET['opc']==1){
            $lg = new modAutorizacion($_GET['fecha']);
            $dv = $lg->BuscaVacRh($_GET['fecha']);
            echo json_encode($dv);
           }else if($_GET['opcs']==3 && $_GET['opc']==1){
            $lg = new modAutorizacion($_GET['fecha'],$_GET['opcs']);
            $dv = $lg->BuscaVacGg($_GET['fecha']);
            echo json_encode($dv);
           }
           else if($_GET['opc'] == 2 && $_GET['opcs']==1){
                $lg = new modAutorizacion($_GET['fecha']);
                $dv = $lg->BuscaPerG($_GET['fecha']);
                echo json_encode($dv);  
            }else if($_GET['opc'] == 2 && $_GET['opcs']==2){
              $lg = new modAutorizacion($_GET['fecha']);
              $dv = $lg->BuscaPerRh($_GET['fecha']);
              echo json_encode($dv);
            }else if($_GET['opc'] == 2 && $_GET['opcs']==3){
              $lg = new modAutorizacion($_GET['fecha']);
              $dv = $lg->BuscaPerGg($_GET['fecha']);
              echo json_encode($dv);
            }else if($_GET['opc'] == 3 && $_GET['opcs']==1){
                $lg = new modAutorizacion($_GET['fecha']);
                $dv = $lg->BuscaConsultaG($_GET['fecha']);
                echo json_encode($dv);  
            }else if($_GET['opc'] == 3 && $_GET['opcs']==2){
              $lg = new modAutorizacion($_GET['fecha']);
              $dv = $lg->BuscaConsultaRh($_GET['fecha']);
              echo json_encode($dv);
            }else if($_GET['opc'] == 3 && $_GET['opcs']==3){
              $lg = new modAutorizacion($_GET['fecha']);
              $dv = $lg->BuscaConsultaGg($_GET['fecha']);
              echo json_encode($dv);
            }else if($_GET['opc'] == 1 && $_GET['opcs']==4){
              $lg = new modAutorizacion($_GET['opc']);
              $dv = $lg->BuscaGuarG($_GET['opc']);
              echo json_encode($dv);
            }else if($_GET['opcs'] == 5) {
				//print_r($_GET['opc']);
				$lg = new modAutorizacion($_GET['opc']);
				$dv = $lg->buscarSolVacEstatus($_GET['opc']);
				echo json_encode($dv);
			}else if($_GET['opcs'] == 6) {
				//print_r($_GET['opc']);
				$lg = new modAutorizacion($_GET['opc']);
				$dv = $lg->buscarSolGuarEstatus($_GET['opc']);
				echo json_encode($dv);
			}
            
            /*elseif($_GET['opc']==4 && $_GET['opcs']==1){
              $_PUT = json_decode(file_get_contents('php://input'),true);
              $reg = new modAutorizacion($_PUT["CodEmpleado"],$_PUT["FechaSol"]);
              $r = $reg->ActSolicitud();
              echo json_encode($r);

                /*$lg = new modAutorizacion($_GET['CodEmpleado'],$_GET['FechaSol']);
                $dv = $lg->ActSolicitud($_GET['CodEmpleado'],$_GET['FechaSol']);
                echo json_encode($dv);  */
            //}
            /*else {
              $reg = new modLogin('','','','','','');
              $r = $reg->cerrarSesion();
              echo "aca no perro";
              echo json_encode($r);
              break;
            }*/
          break;

      case'DELETE':
          break;
      
      case 'PUT':
        $_PUT = json_decode(file_get_contents('php://input'),true);
        echo $_PUT;
        $reg = new modAutorizacion($_PUT["CodEmpleado"],$_PUT["FechaSol"],$_PUT["firmaG"],$_PUT["FechaA"]);
        $r = $reg->UpdateCatSolicitudes();
        echo json_encode($r);
        break;

  }
?>
