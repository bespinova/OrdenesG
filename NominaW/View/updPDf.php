<?php
    include('conexion.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       // $title = $con->real_escape_string(htmlentities($_POST['Hola']));
        //$description = $con->real_escape_string(htmlentities($_POST['Bienvenido']));
    
        $file_name = $_FILES['file']['name'];
    
        $new_name_file = null;
    
        if ($file_name != '' || $file_name != null) {
            $file_type = $_FILES['file']['type'];
            list($type, $extension) = explode('/', $file_type);
            if ($extension == 'pdf') {
                $dir = 'files/';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $file_tmp_name = $_FILES['file']['tmp_name'];
                //$new_name_file = 'files/' . date('Ymdhis') . '.' . $extension;
                $new_name_file = $dir . file_name($file_name) . '.' . $extension;
                if (copy($file_tmp_name, $new_name_file)) {
                    
                }
            }
        }
    
        $ins = $con->query("INSERT INTO tblUploadFile(url) VALUES ('$new_name_file')");
    
        if ($ins) {
            echo 'success';
        } else {
            echo 'fail';
        }
    } else {
        echo 'fail';
    }   
?>