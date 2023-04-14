<?php
include_once ("ClsMsSql.php");
include_once("ClsParam.php"); 

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
  $P =  new ClsParam("C:\inetpub\wwwroot\NominaW\configWeb.txt");
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
  
  
?>

