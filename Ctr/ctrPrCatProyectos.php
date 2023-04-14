<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modCatPrProyectos.php");
 date_default_timezone_set('America/Mexico_City');

// TODO: agregar dos parametros más a la hora de agregar el registro
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $fechaActual = date('Y-m-d');
          $porcentajeInicial = 0.0;
          $enMarcha = 1;
          $status = 'A';
          $reg = new modCatPrProyectos($_POST['CodProyecto'],$_POST['Nombre'],$_POST['cmpObs'],$_POST['CboUniNeg'],
                                      $_POST['CboAsigAr'],$_POST['CboSlcte'],$_POST['CboRespnble'],$fechaActual,$_POST['FechaIni'],
                                      $_POST['cmpDuracion'],$_POST['FechaTerm'],
                                      $porcentajeInicial,$_POST['cmpInversion'],$enMarcha,$status);
          $r = $reg->guardaPrCatProyectos();

          echo json_encode($r);
          break;
     case 'GET':
          if (isset($_GET['op']) && isset($_GET['codUNe'])){
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerOsG_CatUNeg();
            echo json_encode($r);
          }
          elseif (isset($_GET['op']) && isset($_GET['codArea']) && isset($_GET['vardata'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerOsG_CatArea($_GET['vardata']);
            echo json_encode($r);
          }
          elseif(isset($_GET['op']) && isset($_GET['varSolcte']) && isset($_GET['vardato'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerCboSolicita($_GET['vardato']);
            echo json_encode($r);
          }
          elseif (isset($_GET['op']) && isset($_GET['rspnsble'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerCboRspnble();
            echo json_encode($r);
          }
          elseif (isset($_GET['varCod'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtPrCatProyecto($_GET['varCod']);
            echo json_encode($r);
          }
          elseif (isset($_GET['cmpBusc'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->buscarRegCatPr($_GET['cmpBusc']);
            echo json_encode($r);
          }
          elseif (isset($_GET['CodPantalla'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->Obterner_Seg($_GET["CodPantalla"]);
            echo json_encode($r);
          }
          // TODO: Se agrego un nuevo if que manda a llenar el combo de proyectos
          elseif(isset($_GET['varCmbPr'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerAllPr();
            echo json_encode($r);
          }
          // TODO:  se agrego if para que mande a llenar los datos en el panel con el id del proyecto
          elseif (isset($_GET['varDataGral'])) {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerContPry($_GET['varDataGral']);
            echo json_encode($r);
          }
          else {
            $reg = new modCatPrProyectos('','','','','','','','','','','','','','','');
            $r = $reg->obtenerPrCatProyecto();
            echo json_encode($r);
          }
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);
          $reg = new modCatPrProyectos($_PUT['CodProyecto'],$_PUT['Nombre'],$_PUT['cmpObs'],$_PUT['CboUniNeg'],
                                      $_PUT['CboAsigAr'],$_PUT['CboSlcte'],$_PUT['CboRespnble'],'',$_PUT['FechaIni'],
                                      $_PUT['cmpDuracion'],$_PUT['FechaTerm'],'',
                                      $_PUT['cmpInversion'],'','');
          $r = $reg->UpdateCatProyecto();

          echo json_encode($r);
          break;
      case'DELETE':
          if(isset($_GET['CodSolcte']))
          {
             $reg = new modCatPrProyectos($_GET['CodSolcte'], '', '','','','','','','','','','','','','');
             $r = $reg->DeleteCatPr($_GET['CodSolcte']);
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
