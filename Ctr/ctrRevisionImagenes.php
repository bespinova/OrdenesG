<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
include_once("../mod/modRevisionImagenes.php");
date_default_timezone_set('America/Mexico_City');

$rutaImagen = "";

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
          switch ($_GET['varData']) {
            case '0':
                $arr = $_FILES;
                $rutaImagen = subirImagen($arr);
                echo json_encode($rutaImagen);
              break;
            case '1':
                  $_POST = json_decode(file_get_contents('php://input'),true);
                  $fechaActual = date('Y-m-d');
                  $reg = new modRevisionImagenes('',$_POST["CodRevision"],$fechaActual,$_POST['rutaImagen'],$_POST['Comentario']);
                  $r = $reg->guardaRevisionImg();
                  echo json_encode($r);
                break;
            default:
                echo "No hay valor de GET";
              break;
          }
  break;
  case 'GET':
      switch ($_GET['varData']) {
        case '1':
            $reg = new modRevisionImagenes('','','','','');
            $r = $reg->muestraRevisionImg($_GET['contenido']);
            echo json_encode($r);
        break;
        case '2':
            $imagen = EliminarImagen($_GET['ruta']);
            echo json_encode($imagen);
          break;

        default:

        break;
  }

    break;
  case 'PUT':

    break;

  case 'DELETE':

    break;

  default:
    echo json_encode("No hay ningún método de petición");
    break;
}

// TODO:  función que aún no se usa pero se deja para futuras aclaraciones
function obtenerImagen($arrImg){
  $result =  array();

  foreach ($arrImg as $name => $file) {
    if (is_array($file['name'])) {
      foreach ($file as $attrib => $list) {
        foreach ($list as $index => $value) {
          $result[$name][$attrib][$index]=$value;
        }
      }
    }else {
      $result[$name][] = $file;
    }
  }
  return $result;
}


// TODO: obtiene la ruta y sube los archivos a la carpeta
function subirImagen($subirImg){
  foreach ($subirImg as $key => $value) {
      if ($value["error"] == UPLOAD_ERR_OK) {
        $nombre_temporal = $value["tmp_name"];
        $nombre_real = $value["name"];

        $time = time();
        $fechaActual = date('Ymd');

        $cambia_nombre =  "rev_tareas_" . $fechaActual."_".$time;

        $extension = explode(".", $nombre_real);
        $ultimaPosicion = end($extension);

        if (is_uploaded_file($nombre_temporal)) {
          if (move_uploaded_file($nombre_temporal, "../archivos/$cambia_nombre".".".$ultimaPosicion)) {
              move_uploaded_file($nombre_temporal,"../archivos/$cambia_nombre".".".$ultimaPosicion);
              return "../archivos/$cambia_nombre".".".$ultimaPosicion;
          }else {
            return "Hubo un error al procesar la imágen";
          }
        }else {
          return "Hubo un error al procesar la imágen";
        }
      }else {
        return "Hubo un error al procesar la imágen";
      }
  }
}

function EliminarImagen($variableImg){
  if(is_file($variableImg)){
    return unlink($variableImg); //elimino el fichero
  }else {
    return "Error";
  }
}


?>
