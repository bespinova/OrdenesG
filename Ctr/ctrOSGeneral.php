<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modOSGeneral.php"); 
 date_default_timezone_set('America/Mexico_City');
 
 //
 //echo  'Informacion: ' . file_get_contents('php://input');
 switch ($_SERVER['REQUEST_METHOD'])
  {
      case 'POST':
          $_POST = json_decode(file_get_contents('php://input'),true);
          $reg = new modOSGeneral($_POST["FechaExpedicion"], $_POST["TipoMatto"], $_POST["CodSolicitante"],$_POST["CodUNegocio"],$_POST["CodArea"],
                                  $_POST["CodGteMatto"],$_POST["Estatus"],$_POST["EstatusDoc"],
                                  $_POST["CvePrioridad"],$_POST["DscFallo"],$_POST["CodTipoOS"]);
          $r = $reg->guardarOsGeneral();
          echo json_encode($r);
          break;
      case 'GET':
          //$_GET = json_decode(file_get_contents('php://input'),true);          print_r($_GET);
          switch($_GET['op'])
           {
              case 0: //obetenemos las os
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOSGeneralT($_GET["Fini"],$_GET["Ffin"],$_GET["EdoDoc"],
                                                 $_GET["Prd"],$_GET["Tmtto"],$_GET["Uneg"],$_GET["Gmtto"],$_GET["Solt"]);
                    echo json_encode($r);
              break;
              case 1: //get el catalogo de Uneg para el combo de
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOsG_CatUNeg();
                    echo json_encode($r);
              break;
              case 2: //get el catalogo de Solicitantes para el combo
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOsG_CatSol();
                    echo json_encode($r);
              break;
              case 3: //get el catalogo de Areas para el combo
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOsG_CatArea();
                    echo json_encode($r);
              break;
              case 4: //get el catalogo de Areas para el combo
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOsG_CatGteM();
                    echo json_encode($r);
              break;
              case 5: 
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->obtenerOsG($_GET["Os"],$_GET["estdoc"]);
                    echo json_encode($r);
              break;
              case 6: 
                    $reg = new modOSGeneral('', '', '','','','','','','','','');
                    $r = $reg->LlenaCboRel($_GET["tbl"],$_GET["fil"]);
                    echo json_encode($r);
              break;
              case 7:
                   $reg = new modOSGeneral('', '', '','','','','','','','','');
                   $r = $reg->obtenerOsG_CatTipoOS();
                    echo json_encode($r);
              break;
              case 8:
                  $reg = new modOSGeneral('', '', '','','','','','','','','');
                  $r = $reg->LlenaCboUnidades();
                  echo json_encode($r);
              break;
              case 30:
                 $reg = new modOSGeneral('', '', '','','','','','','','','');
                 $r = $reg->Obterner_Seg($_GET["CodPantalla"],$_GET["CodPerfil"]);
                 echo json_encode($r);
              break; 
              case 31:
                  $reg = new modOSGeneral('', '', '','','','','','','','','');
                  $r = $reg->CargaCatUniMaqPesada();
                  echo json_encode($r);
              break;
           }           
          break;
      case 'PUT':
          $_PUT = json_decode(file_get_contents('php://input'),true);          //print_r($_PUT);
           switch($_PUT['Op'])
           {
               case 200:
                  $reg = new modOSGeneral('', '', '','','','','','','','',''); 
                   $r = $reg->AtenderOS($_PUT["FechaAtencion"],$_PUT["FechaPrometida"],$_PUT["CodEmpleado"],
                                        $_PUT["DscAtendido"],$_PUT["EstatusDoc"],$_PUT["NoOS"],$_PUT["CodUnidad"],
                                        $_PUT["RegOsUnMaqP"],$_PUT["FechaAsigMaqP"],$_PUT["RegVhFree"]);
                                     //print_r($_PUT); 
                   echo json_encode($r);
               break;
               case 300:
                   $reg = new modOSGeneral('', '', '','','','','','','','','');
                   $r = $reg->TerminarOS($_PUT["FecTerminoCap"],$_PUT["FechaTermino"],$_PUT["DscTermino"],
                                         $_PUT["EstatusDoc"],$_PUT["NoOS"],$_PUT["UnMaqP"]);
                   echo json_encode($r);
               break;
               case 400:
                  $reg = new modOSGeneral('', '', '','','','','','','','','');
                   $r = $reg->AceptarOS($_PUT["FecLiberacion"],$_PUT["DscLiberacion"],
                                         $_PUT["EstatusDoc"],$_PUT["NoOS"]);
                   echo json_encode($r); 
               break;
           }
          break;
      case'DELETE':
              $reg = new modOSGeneral('', '', '','','','','','','','','');
              $r = $reg->DeleteOS($_GET['NoOs']);
              echo json_encode($r); 
      break;
          
  }
 
 
?>
