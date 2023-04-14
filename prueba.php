<?php
//include_once ("ClsMsSql.php");
//include_once("ClsParam.php"); 

phpinfo();
//include_once ("Ctr/ctrLogin.php");
  echo "probando2\n";
   
  /*$cp = new ClsMsSql('sdt1\\gavsd','sa','QcPruebas','G4v0217g0');
  $cp->Conextar();
  $str = "Select * from SegUsuarios";
  $v1 = $cp->loadQueryARR_Asoc($str);
  print_r($v1);
  
  $Emp = new ctrLogin();
  $x = $Emp->buscarEmpleado('01234');
  print($x); 
  */
  /*
  $P =  new ClsParam("C:\\MisDatos\\_X\\phpPry\\NomWeb\\configWeb.txt");
  $conDb = new ClsmsSql($P->Servidor,$P->Usuario,$P->Datos,$P->Passw); 
  
     
       if ($conDb->Conextar() == 0){	
         echo "\nError al conectarse en la base de datos"; 
         return;
       }
  //print_r($conDb);
  
  $curp = '01234';     
  $stdSql = "Select ImgFrente from CatEmpleados where Curp = '".$curp."'";
       
       $rsp = $conDb->loadQueryARR_Asoc($stdSql); 
       //print_r($rsp);
       $rsp[0][0]['ImgFrente'] =  base64_encode($rsp[0][0]['ImgFrente']);
        if (count($rsp) > 0){ 
            echo json_encode($rsp); 
        }   
       else 
           return '\nCURP no encontrado ....';
  
  */
?>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>OS Grupo Camacho</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
          <!-- Core theme CSS (includes Bootstrap)-->
        
        <link href="Vis/css/styles.css" rel="stylesheet" type="text/css"/>
        <link href="css/styVis.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/navbar.css">

    </head>
    <body>
    
        
        <div class="card">
            <h5 class="card-header">Featured</h5>
            <div class="card-body">
              <h5 class="card-title">Special title treatment</h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
        
       
         <!-- Bootstrap core JS-->
        <!-- script src="" "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script -->
        <script src="bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
  
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/eventos.js" type="text/javascript"></script>
        <script src="js/scCatalogos.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    </body>
</html>

