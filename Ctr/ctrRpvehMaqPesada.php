<?php
 header("Content-Type: application/json");
 header('Access-Control-Allow-Origin: *');
 include_once("../mod/modRpvehMaqPesada.php"); 
 date_default_timezone_set('America/Mexico_City');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($_GET['op']) {
            case 0:
                $reg = new modRpvehMaqPesada('');
                $r= $reg->obtenerRpvehMaqPesada($_GET["disponible"]);
                echo json_encode($r);
                break;
        
        }
    break;
 }