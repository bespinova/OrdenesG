<?php
    session_start();
    header("Content-Type: application/json");
    header('Access-Control-Allow-Origin: *');
    include_once("../Mod/modPdf.php"); 
    date_default_timezone_set('America/Mexico_City');
 
    $nombre_temporal = $_FILES['archivo']['tmp_name'];
    echo $nombre_temporal;
    $nombre = $_SESSION['curp'];

    $destino = "C:/inetpub/wwwroot/NominaW/archivos/" . $nombre."/";
    $ruta = $_FILES['archivo']['tmp_name'];
    $archivo = $destino.$_FILES["archivo"]["name"];

    

    if(!file_exists($destino)){
        mkdir($destino);
    }
    echo "Entro acá 1   ".$nombre_temporal;
    if ($nombre != "") {
        echo $directorio;
        if (copy($ruta, $archivo)) {
            
            $_POST = json_decode(file_get_contents('php://input'),true);
            print_r($_POST);
            echo "Entro acá";
            $reg = new modPdf("hola","beivnesao");
            $r = $reg->upDoc();
            echo json_encode($r);

        } else {
            echo "Error";
        }
    }
?>