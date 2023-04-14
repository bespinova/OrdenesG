<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
include_once("../core.php");

session_start();
//print_r($_SESSION['curp']);
print_r($_SESSION['Autoriza'],$_SESSION['curp']);
if (!isset($_SESSION['id_app'])) {
    header("Location: ../View/login.php");
}else {
  $objParam = new ClsParam($_SESSION['path']);
  $conDb = new ClsMsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
  if ($conDb->Conextar() == 0) {
    return "Error al conectarse en la base de datos";
  }
}

$nombreO = $_SESSION['IdDepto'];

//echo $nombreO;
/*if (isset($_POST['subir'])) {
  //$nombre = $_FILES['archivo']['name'];
  $nombre = "1443397.pdf";
  $tipo = $_FILES['archivo']['type'];
  $tamanio = $_FILES['archivo']['size'];
  $ruta = $_FILES['archivo']['tmp_name'];
  $destino = "archivos/" . $nombre;
  //mkdir("archivos/".$nombre, 0700);
  if ($nombre != "") {

    if(copy($ruta,$destino)){
      echo 'Exito al subir';
    }else{
      echo 'Error';
    }
  } 
}*/

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>NominaWeb</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="index.css">
  <link href="./css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="stylo.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Espacio para axios y js -->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script type="text/javascript" src="prue.js"></script>
  <!--<script type="text/javascript" src="const.js"></script>-->
  <script src="main.js"></script>
  <script type="text/javascript" src="edits.js"></script>
  <!-- Termina espacio -->
  <script type="text/javascript">
      function showContent() {
          element = document.getElementById("content");
          check = document.getElementById("check");
          if (check.checked) {
              element.style.display='block';
          }
          else {
              element.style.display='none';
          }
      }
  </script>
</head>

<body background="fondob.jpg" >



<div class="">
    <div class="">
  
<header class="topbar">  
  <nav class="navbar navbar-expand-md" style="background-color: transparent; width: 100%;">
  <!-- Brand -->
  
  <img src="<?php echo $_SESSION['nameImgPer'];?>" class="img-circle" alt="Responsive image" id="imgFre" style = "width:50px;"  /> 
  <a class="navbar-brand" href="#" style="color: red; font-family: fantasy;">Grupo Avimarca</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"  >
    <span class="navbar-toggler-icon "></span><img src="../Image/avim.png" style="width: 60px; height: 60px; margin-right: 25px" />
  </button>

  <!-- Navbar links -->
  
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" href="#th">Consultas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" href="#lc">Solicitudes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" href="#de">Vacaciones</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" href="#gd">Documentos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" id="modAut" data-toggle="modal" data-target="#Aut">Autorizaciones</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" id="modAutG" data-toggle="modal" data-target="#AutG">Aut. Guardias</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" id="modGridPres" data-toggle="modal" data-target="#gridPres">Prestamos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" style="font-family: fantasy;" onclick="exit()">Cerrar Sesion</a>
      </li>
    </ul> 
  </div>
</nav>
</header>

  <span class="ancla" id="top"></span>
  <a href="#top" class="subir btn"></a>

  <section id="grupo-busqueda" class="contenedor contenido "style="width: 100%;">

    <input id="expandir-todo" type="checkbox" class="esconde ctrl expandir">

    <section class="instrucciones"  >
      <h3 class="tituloT">Instrucciones</h3>
      <input id="curpSesion" value="<?php echo$_SESSION['curp']; ?>"" hidden= "true">
      <input id="CodAuts" value="<?php echo$_SESSION['Autoriza']; ?>"" hidden="true" >
      <input id="VacTotal" value="<?php echo$_SESSION['VacTotal']; ?>"" hidden= "true" >
      <input id="VacTomadas" value="<?php echo$_SESSION['VacTomadas']; ?>"" hidden= "true">
	  <input id="" value="<?php echo$_SESSION['nameImg']; ?>" hidden = "true">
	  <input id="" value="<?php echo$_SESSION['nameImgPer']; ?>" hidden = "true">
     <!-- div class="" id="curpSesion" value="$_SESSION['curp'];"></div>-->
	 
      <p>
        Para ver todas las opciones, haz clic en el icono <span class="icono fa fa-plus-circle"></span> para expandir. 
      </p>    
      
      <div class="grupo-buscador">
        <input tabindex="0" class="buscador" type="text">
        <span class="icon fa fa-search"></span>
      </div>
    </section>
      
    <section class="seccion">

      <h3 id="th" style="color: rgb(0,0,0);">Consultas <b></b></h3>

      <article class="subseccion formatos">

        <h4 title="clic para ver el resto de archivos" tabindex="1">Catalogo</h4>
        
        <!--<button class="btn btn-primary">Datos Generales</button>
        
        <button class="btn btn-primary">Contacto de Emergencia</button>

        <button class="btn btn-primary">Vacaciones</button>

        <button class="btn btn-primary">Deducciones</button>-->

        <div class="container">
          <div class="row">
            <div class="col">
              <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" onclick="muestraDatos()">
                Datos Generales
              </button>
            </div>
            <div class="col">
              <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" onclick="muestraDatos()">
                Contacto de Emergencia
              </button>
            </div>
            <div class="col">
              <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" onclick="muestraDatos()">
                Vacaciones
              </button>
            </div>
            <div class="col">
              <button class="btn btn-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" onclick="muestraDatos()">
                Deducciones
              </button>
            </div>
          </div>
        </div>

        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            
            <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <form id="DatosPersonal">

                <div class= "container">
                  <div class="row vh-100 justify-content-center align-items-center">
                    
                    <div class="table-responsive">
                    <table class="table">
                      <tr width: 100px;>
                        <th width: 100px;> <label class="text-dark">Nombre: <input class="form-control" type="text" name="nombre" id="nombre" disabled=""> </th>
                        <th width: 100px;> <label class="text-dark">Puesto: <input class="form-control" type="text" name="puesto" id="codp" disabled=""> </th> 
                      </tr>
                      <tr width: 100px;>
                        <th> <label class="text-dark">Celular: <input class="form-control" type="text" name="celular" id="cel" disabled=""> </th>
                        <th> <label class="text-dark">E-Mail: <input class="form-control" type="text" name="correo" id="cor" disabled=""> </th>
                      </tr>
                      <tr width: 100px;>
                        <th> <label class="text-dark">IMSS: <input class="form-control" type="text" name="imms" id = "imss"  disabled=""> </th>
                        <th> <label class="text-dark">Cta. Bancaria: <input class="form-control" type="text" name="cuenta" id="ctb" disabled=""> </th>
                      </tr>
                      <tr width: 100px;>
                        <th> <label class="text-dark">RFC: <input class="form-control" type="text" name="rfc" id= "rfcv" disabled=""> </th>
                        <th> <label class="text-dark">Direccion: <input class="form-control" type="text" name="direccion" id="dir" disabled=""> </th>
                      </tr>
                      <tr width: 100px;>
                        <th> <label class="text-dark">Prestamo: <input class="form-control" type="text" name="prestamos" id="prestamos" disabled=""> </th>
                        <th> <label class="text-dark">Seguro: <input class="form-control" type="text" name="seguro" disabled=""> </th>
                      </tr>
                    </table>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalMod" onclick="llenarModificacion()">
						  Modificación
						</button>
                    </div>
                  </div>
                
                </div>
					
                </form>

                <strong>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">

                <form>
                  <div class= "container">
                    <div class="row vh-100 justify-content-center align-items-center">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th width: 100px;> <label class="text-dark">Nombre Completo: <input class="form-control" type="text" name="nombreC" id="nomc"> </th>
                            <th width: 100px;> <label class="text-dark">Dirección: <input class="form-control" type="text" name="dir" id="dirEm"> </th> 
                          </tr>
                          <tr>
                            <th width: 100px;><label class="text-dark">Celular: <input class="form-contol" type="text" name="cel" id="celEm" ></th>
                            <th width: 100px;><label class="text-dark">Telefono: <input class="form-contol" type="text" name="tel" id="telEm"></th>
                          </tr>
						  <tr>
							<th><button type="button" class="btn btn-success" onClick="datosEme()">Guardar</button></th>
						  </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </form>

                <strong>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">

                <form>
                  <div class= "container-sm">
                      <div class="row vh-100 justify-content-center align-items-center">
                        <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <th width: 100px;> <label class="text-dark">Tomadas: <input class="form-control" type="text" name="vac" id="vac" disabled=""> </th>
                              <th width: 100px;> <label class="text-dark">Restantes: <input class="form-control" type="text" name="vacR" id="vacR" disabled=""> </th> 

                              <th width: 100px;> <label class="text-dark">Autorizadas: <input class="form-control" type="text" name="vacA" id="vacA" disabled=""> </th> 
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                </form>

                <strong>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">

                <form>
                  <div class= "container">
                    <div class="d-flex bd-highlight">
                      <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th width: 100px;> <label class="text-dark">Puesto: <input class="form-control" type="text" name="puesto" id="puesto" disabled=""> </th>
                            <th width: 100px;> <label class="text-dark">Sueldo Diario: <input class="form-control" type="text" name="suelD" id="suelD" disabled=""> </th> 
                          </tr>

                          <tr>
                            <th width: 100px;> <label class="text-dark">Sueldo Neto: <input class="form-control" type="text" name="suelN" id="suelN" disabled=""> </th> 
                            <th width: 100px;> <label class="text-dark">Área: <input class="form-control" type="text" name="area" id="area" disabled=""> </th> 
                          </tr>

                          <tr style="height = 10px;">
                            <th width: 100px; style="height = 10px;"> <label class="text-dark">Sub Área: <input class="form-control" type="text" name="subA" id="subA" disabled=""> </th> 
                            <th width: 100px;> <label class="text-dark">Tipo de Nomina: <input class="form-control" type="text" name="tnom" id="tnom" disabled=""> </th> 
                          </tr>

                        </table>
                      </div>
                    </div>
                  </div>
                </form>

                <strong>
              </div>
            </div>
          </div>

        </div>
    </section>    

    <section class="seccion">

      <h3 id="lc" style="color: rgb(0,0,0);">Solicitudes<b></b></h3>
      <input type="text" name="cCurp" id="cCurp" disabled="" value="GOPC960320HCSRNR10" hidden = "true"/>

      <article class="subseccion formatos">

        <h4 title="clic para ver el resto de archivos" tabindex="3">Prestamos</h4>

        <ul class="lista formatos">
          <li><button id="btn_pres" type="button" class="btn btn-dark" data-toggle="modal" data-target="#pres"
            style="margin-top: -15px;" onClick=llenadoPres(); >Prestamos</button><br><br></li>
        </ul>

      </article>
      <article class="subseccion procedimientos">

        <h4 title="clic para ver el resto de archivos" tabindex="4">Seguros</h4>

        <ul class="lista procedimientos">
          <li><button id="btn_seg" type="button" class="btn btn-dark" data-toggle="modal" data-target="#segu"
            style="margin-top: -15px;" onClick=llenadoSeg(); >Seguros</button><br><br></li></li>
        </ul>

      </article>
      
    </section>    
    <section class="seccion">

      <h3 id="de" style="color: rgb(0,0,0);">Vacaciones<b></b></h3>

      <article class="subseccion formatos">

        <h4 title="clic para ver el resto de archivos" tabindex="5">Solicitudes</h4>

        <ul class="lista formatos">
          <li><button type="button" class="btn btn-info" id="btnVac" data-toggle="modal" data-target="#solVac"
            style="margin-top: -15px;" onClick=llenar(); >Solicitar Vacaciones</button><br><br>
            
            <!--<a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1Wy_b5u7QMTGBvvA0DLEzdpbJ4-D4NZJa">
              FORMATO ANALISIS DE IMPACTO AL NEGOCIO
            </a>-->  
          </li>
          <li><button type="button" class="btn btn-info" id="btnGuardia" data-toggle="modal" data-target="#solGua"
            style="margin-top: -15px;" onClick=llenado();>Solicitar Días de Guardia</button><br><br>
          </li>
		  <li><button type="button" class="btn btn-info" id="btnStado" data-toggle="modal" data-target="#solEstado"
            style="margin-top: -15px;" onClick="muestraDatos()">Status de Solicitudes</button>
          </li>
        </ul>

      </article>
      
    </section>    
    <section class="seccion">

      <h3 id="gd" style="color: rgb(0,0,0);">Gestión Documental <b></b></h3>

      <article class="subseccion formatos">

        <h4 title="clic para ver el resto de archivos" tabindex="6">Documentación</h4>

        <form method="" id="form_subir" enctype=multipart/form-data>
            <div class="form-1-2">
                <label for="">Archivo a subir:</label>
                <input type="file" name="archivo" required>
            </div>
            <div class="barra">
                <div class="barra_azul" id="barra_estado">
                    <span></span>
                </div>
            </div>
            <div class="acciones">
                <input type="submit" class="btn" value="subir" name="subir">
                <input type="button" class="cancel" id="cancelar" value="cancelar">
                <!--<input type="button" class="btn" value="info" name="info" data-target="#infoArch">-->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#infoArch">
                  INFORMACIÓN
                </button>
            </div>
        </form>

        
        <!--<form>
          <table class = "table">
            
            <tr>
              <th>
                <label class="text-dark">Acta de Nacimiento:
              </th>
              <th>
                
                  <input type="file"id="Acta"/>
                  <progress id="img-upload-bar" value="0" max="100" style="width: 100%"></progress>
                  <button type="button" class="btn btn-success" onclick="sbAc()">Cargar</button>
                  <button type="button" class="btn btn-dark" >Ver</button>
                
              </th>
            </tr>
              
            <tr>
              <th>
                <label class="text-dark">Curp:
              </th>
              <th>
                <input type="file" class="btn btn-secondary" />
                <button type="button" class="btn btn-success" >Cargar</button>
                <button type="button" class="btn btn-dark" >Ver</button>
              </th>
            </tr>

            <tr>
              <th>
                <label class="text-dark">Comprobante de Domicilio:
              </th>
              <th>
                <input type="file" class="btn btn-secondary" />
                <button type="button" class="btn btn-success" >Cargar</button>
                <button type="button" class="btn btn-dark" >Ver</button>
              </th>
            </tr>

            <tr>
              <th>
                <label class="text-dark">INE:
              </th>
              <th>
                <input type="file" class="btn btn-secondary" />
                <button type="button" class="btn btn-success" >Cargar</button>
                <button type="button" class="btn btn-dark" >Ver</button>
              </th>
            </tr>

          </table>
        </form>
    -->
        <!--<ul class="lista formatos">
          <li><b>Acta de Nacimiento</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1u47u7wLPq2gSvrt5_qXWZda2ryszM7oU">
              Cargar/Adjuntar
            </a></li>
          <li><b>INE</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1sEGOhxffpYofWP6uo0O1WRci0rWK_oMR">
              Cargar/Adjuntar
            </a></li>

          <li><b>CURP</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1sEGOhxffpYofWP6uo0O1WRci0rWK_oMR">
              Cargar/Adjuntar
            </a></li>

          <li><b>Comprobante de Domicilio</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1sEGOhxffpYofWP6uo0O1WRci0rWK_oMR">
              Cargar/Adjuntar
            </a></li>
        </ul>-->

      </article>
      <!--
      <article class="subseccion procedimientos">

        <h4 title="clic para ver el resto de archivos" tabindex="7">Reglamentos</h4>

        <ul class="lista procedimientos">
          <li><b>Código de Ética</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1adhUrQvUKwppnOMYkttPVePR__-K5a2K">
              Ver/Descargar
            </a></li>
          <li><b>Reglamento</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1XtI5_0ib5EISpdR0uY7El3WD_84BPKw7">
              Ver/Descargar
            </a></li>
          <li><b>Contrato</b>
            <a title="clic para abrir en otra ventana" target="_blank" href="https://drive.google.com/open?id=1abhZxyFPiVPwq1jLxk2xhxa7eEqgsY17">
              Ver/Descargar
            </a></li>
          
        </ul>

      </article>-->
      
    </section>    
    
    <section class="seccion">

    <h3 id="mc" style="color: rgb(0,0,0);">Visor de documentos <b></b></h3>

    <article class="subseccion formatos">

    <h4 title="clic para ver el resto de archivos" tabindex="14">Empleados</h4>

    <ul class="lista formatos">
    
    <?php
    $ruta = "C:\inetpub\wwwroot\NominaW\archivos";
    obtener_estructura_directorios($ruta);

    ?>

  </article>

</section>  

    <section class="seccion">

        <h3 id="mc" style="color: rgb(0,0,0);">REGLAMENTOS <b></b></h3>

      <article class="subseccion formatos">

      <h4 title="clic para ver el resto de archivos" tabindex="14">Formatos</h4>

      <ul class="lista formatos">
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mSanciones">Sanciones</button>
        </li>
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mEtica">Código de Ética</button>
        </li>
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mConFis">Confidencialidad Fisicas</button>
        </li>
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mConM">Confidencialidad Morales</button>
        </li>
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mConIn">Conflicto de Intereses</button>
        </li>
      </ul>

    </article>
      
    </section>    
	
    <hr>

	<section class="seccion">

        <h3 id="mc" style="color: rgb(0,0,0);">Requerimientos <b></b></h3>

      <article class="subseccion formatos">

      <h4 title="clic para ver el resto de archivos" tabindex="14">Formatos a Solicitar</h4>

      <ul class="lista formatos">
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mSolicitud1" onclick="rellenouno()">Carta de Recomendación</button>
        </li>
        <li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mSolicitud" onclick="relleno()">Constancia de trabajo</button>
        </li>
		<li>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mOrganigrama">Organigrama</button>
        </li>
      </ul>

    </article>
      
    </section> 

  </section>
</div>

<!-- ================================= MODALES PARA DOCUMENTOS -->
<div class="modal fade" id="mSanciones" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cátalogo de Sanciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <iframe src="pdf_files/csan.pdf" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mEtica" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Código de Ética y Conducta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <iframe src="pdf_files/cetica.pdf" width="100%" height="500px"></iframe>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="mConFis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Covenio de Confidencialidad Personas Físicas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <iframe src="pdf_files/confin.pdf" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mConM" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Convenio de Confidencialidad Personas Morales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <iframe src="pdf_files/conmor.pdf" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mConIn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Conflicto de Intereses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <iframe src="pdf_files/confin.pdf" width="100%" height="500px"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Modal de modificación datos personales -->
<div class="modal fade" id="exampleModalMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Solicitud de modificaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="input-group input-group-sm mb-3">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-sizing-sm">Dirección</span>
		  </div>
		  <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="dirmod">
		</div>
		<div class="input-group input-group-sm mb-3">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-sizing-sm">Cta. Bancaria</span>
		  </div>
		  <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="ctamod">
		</div>
		<!--<div class="input-group input-group-sm mb-3">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-sizing-sm">E-Mail</span>
		  </div>
		  <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="emamod">
		</div>-->
		<div class="input-group input-group-sm mb-3">
		  <div class="input-group-prepend">
			<span class="input-group-text" id="inputGroup-sizing-sm">Celular</span>
		  </div>
		  <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id="celmod">
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="solicitudMod()">Enviar Solicitud</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="datospersonales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos Personales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: left;">
        <span>Nombre Completo: </span>
        <label id="nombre"></label><br>
        <span>Puesto: </span><br>
        <span>Celular: </span><br>
        <span>E-Mail: </span><br>
        <span>IMSS: </span><br>
        <span>Cuenta Bancaria: </span><br>
        <span>RFC: </span><br>
        <span>Dirección: </span><br>
        <span>Prestamos: </span><br>
        <span>Seguros: </span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Guardar</button>-->
      </div>
    </div>
  </div>
</div>

<!-- Modal Vacaciones-->
<!--
<div class="modal fade" id="solVac" tabindex="-1" role="dialog" aria-labelledby="solVac" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitud de Vacaciones y Permisos</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <table>
        <tr>
          <td colspan="2"><strong class="text-dark" style="font-family: Baskerville;">Fecha de Solicitud</strong> <input type="date" name="FechaSol" id="FechaSol" value = "<?php echo date("Y-m-d");?>"></td>
        </tr>

        <tr>
          <td><strong class="text-dark" style="font-family: Baskerville;">Información Personal</strong></td>
        </tr>
        <tr>
          <td><label class="text-dark" style="font-family: Baskerville;">Num. Empleado:</label>
            <input type="text" name="codEmpleado" id="codEmpleado" disabled="true" ></td>
        </tr>

        <tr>
          <td><input type="text" name="nombreSol" id="nombreSol" placeholder="Nombres">
            <input type="text" name="apeP" id="apeP" placeholder="Apellido Paterno">
            <input type="text" name="apeM" id="apeM" placeholder="Apellido Materno">
            <br><br>
            <label class="text-dark" style="font-family: Baskerville;">Fecha de Nacimiento:  </label><input type="date" name="fecN" id="fecNac">
            <br><br>

            <input type="text" name="tArea" id="tArea" placeholder="Área">
            <input type="text" name="tDep" id="tDep" placeholder="Departamento">
            <input type="text" name="tCarg" id="tCarg" placeholder="Cargo">

            <br><br>
            <label class="text-dark" style="font-family: Baskerville;">Tipo de Beneficio:   </label>
            <select name="tBen" id="tBen">
              <option>  </option>
              <option value="Vacaciones">Vacaciones</option>
              <option value="Permiso">Permiso</option>
              <option value="Consulta">Consulta</option>
            </select>
			
			<div name="tBen">
				<button type="button" class="btn btn-success" value="Vacaciones" id="btnVac" name="tBen" onclick = "vacT()">Vacaciones</button>
				<button type="button" class="btn btn-danger" value="Consulta" id ="btnCon" name="tBen" >Consulta</button>
				<button type="button" class="btn btn-info" value="Permiso" id="btnPer" name="tBen" >Permiso</button>
			</div>
            <label class="text-dark" style="font-family: Baskerville;">Jornada:   </label>
            <select name="tJor" id="tJor">
              <option>  </option>
              <option value="manana">Mañana</option>
              <option value="tarde">Tarde</option>
              <option value="completa">Completa</option>
            </select>
			
            <br><br> 
			<div id="divJornada" style="display:none;">
				<button type="button" class="btn btn-primary" id="btnComJ" name="btnComJ" onclick="com()">Completa</button>
				<button type="button" class="btn btn-light" id="btnMedJ" name="btnMedJ" onclick="med()">Media</button>
				
				<div id="divFechas" style="display:none;">
					<label class="text-dark" style="font-family: Baskerville;"> Fechas:</label>
					<br><br>
					<label class="text-dark">Inicio</label><input type="date" name="fecIni" id="fecIni">
					<label class="text-dark">Fin</label><input type="date" name="fecFin" id="fecFin">
					<br><br>
					<label class="text-dark" id="tituloTime">Seleccionar una opción</label>
					
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="flexRadioDefault" id="medTa" value="8-12">
					  <label class="form-check-label text-dark" for="flexRadioDefault1" id="medMa1">
						8:00 am - 12:00 pm
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input" type="radio" name="flexRadioDefault" id="medTa" value = "12-5">
					  <label class="form-check-label text-dark" for="flexRadioDefault2" id="medTa1">
						12:00 pm - 5:00 pm
					  </label>
					</div>
					
				</div>
			</div>
			
            <input type="text" value="dias()">
            
            <label class="text-dark" style="font-family: Baskerville;">Nombre de quien cubre:</label>
            <input type="text" name="cubN" id="cubN">

            <br><br>

          </td>
        </tr>

        
      </table>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="selVacaciones()">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>
-->
<div class="modal fade" id="solVac" tabindex="-1" role="dialog" aria-labelledby="solVac" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitud de Vacaciones y Permisos</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <table>
        <tr>
          <td colspan="2"><strong class="text-dark" style="font-family: Baskerville;">Fecha de Solicitud</strong> <input type="date" name="FechaSol" id="FechaSol" value = "<?php echo date("Y-m-d");?>"></td>
        </tr>

        <tr>
          <td><strong class="text-dark" style="font-family: Baskerville;">Información Personal</strong></td>
        </tr>
        <tr>
          <td><label class="text-dark" style="font-family: Baskerville;">Num. Empleado:</label>
            <input type="text" name="codEmpleado" id="codEmpleado" disabled="true" ></td>
        </tr>

        <tr>
          <td><input type="text" name="nombreSol" id="nombreSol" placeholder="Nombres">
            <input type="text" name="apeP" id="apeP" placeholder="Apellido Paterno">
            <input type="text" name="apeM" id="apeM" placeholder="Apellido Materno">
            <br><br>
            <label class="text-dark" style="font-family: Baskerville;">Fecha de Nacimiento:  </label><input type="date" name="fecN" id="fecNac">
            <br><br>

            <input type="text" name="tArea" id="tArea" placeholder="Área">
            <input type="text" name="tDep" id="tDep" placeholder="Departamento">
            <input type="text" name="tCarg" id="tCarg" placeholder="Cargo">

            <br><br>
            <label class="text-dark" style="font-family: Baskerville;">Tipo de Beneficio:   </label>
            <select name="tBen" id="tBen">
              <option>  </option>
              <option value="Vacaciones">Vacaciones</option>
              <option value="Permiso">Permiso</option>
              <option value="Consulta">Consulta</option>
            </select>

            <label class="text-dark" style="font-family: Baskerville;">Jornada:   </label>
            <select name="tJor" id="tJor">
              <option>  </option>
              <option value="8-12">Mañana</option>
              <option value="12-5">Tarde</option>
              <option value="completa">Completa</option>
            </select>

            <br><br>

            <label class="text-dark" style="font-family: Baskerville;"> Fechas:</label>
            <br><br>
            <label class="text-dark">Inicio</label><input type="date" name="fecIni" id="fecIni">
            <label class="text-dark">Fin</label><input type="date" name="fecFin" id="fecFin">
            <!--<input type="text" value="dias()"> -->
            <br><br>
            <label class="text-dark" style="font-family: Baskerville;">Nombre de quien cubre:</label>
            <input type="text" name="cubN" id="cubN">

            <br><br>

          </td>
        </tr>


      </table>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="selVacaciones()">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>



<!-- Modal Guardias-->
<div class="modal fade" id="solGua" tabindex="-1" role="dialog" aria-labelledby="solGua" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitud de Guardias</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <table>
        <tr>
          <input type="text" name="opc" id="opc" hidden = "true">
          <td colspan="2"><strong class="text-dark" style="font-family: Baskerville;">Fecha de Solicitud</strong> <input type="date" name="fecSol" id="fecSol" value="<?php echo date("Y-m-d");?>"></td>
        </tr>

        <tr>
          <td><strong class="text-dark" style="font-family: Baskerville;">Información Personal</strong></td>
        </tr>
        <tr>
          <td><label class="text-dark" style="font-family: Baskerville;">Cod. Empleado:</label>
            <input type="text" name="EmpCod" id="EmpCod" disabled="true"></td>
        </tr>

        <tr>
          <td><input type="text" name="nombreSoli" id="nombreSoli" placeholder="Nombres">
            <input type="text" name="apeP_" id="apeP_" placeholder="Apellido Paterno">
            <input type="text" name="apeM_" id="apeM_" placeholder="Apellido Materno">
            <br><br>
            
            <input type="text" name="tArea_" id="tArea_" placeholder="Área">
            <input type="text" name="tDep_" id="tDep_" placeholder="Departamento">
            <input type="text" name="tCarg_" id="tCarg_" placeholder="Cargo">

            <br><br>

            <label class="text-dark" style="font-family: Baskerville;"> Fecha de Guardia:</label>
            <input type="date" name="fecGuard" id="fecGuard">
            <br><br>
          </td>
        </tr>

        
      </table>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="SolGuar()">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Status Solicitudes-->
<div class="modal fade" id="solEstado" tabindex="-1" role="dialog" aria-labelledby="solGua" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Status de Solicitudes</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  
	<div>	
		<input type="text" id="CodEmEs" value="">
		<button type="button" class="btn btn-outline-warning" id="btnEsVac" value="1" onClick="solpruebas()">Vacaciones</button>
		<button type="button" class="btn btn-outline-info" id="btnEsGuar" value="2" onClick="solpruebasGuardias()" >Guardias</button>
	</div>
	
	<div class="input-group p-2">
        
        <div class="table-responsive"> <!-- sm md lg xl -->
          <table id="tblStatus" class="table table-sm">
            <thead  class="table-dark">
              <tr>
                <th class="header" scope="col">Fecha Solicitud</th>
                <th class="header" scope="col">Beneficio</th>
                <th class="header" scope="col">Gerente</th>
                <th class="header" scope="col">RH</th>
                <th class="header" scope="col">Gerente General</th>
              </tr>
            </thead>
            <tbody  class="text-dark">
              
            </tbody>
          </table>
        </div>
    </div>
	
	<div class="input-group p-2">
        
        <div class="table-responsive"> <!-- sm md lg xl -->
          <table id="tblStatusG" class="table table-sm" >
            <thead  class="table-dark">
              <tr>
                <th class="header" scope="col">Fecha Solicitud</th>
                <th class="header" scope="col">Beneficio</th>
                <th class="header" scope="col">Gerente</th>
              </tr>
            </thead>
            <tbody  class="text-dark">
              
            </tbody>
          </table>
        </div>
    </div>
	
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
    </div>

    </div>
  </div>
</div>

<!-- Modal Prestamos-->
<div class="modal fade" id="pres" tabindex="-1" role="dialog" aria-labelledby="pres" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitud de Prestamo</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <table>
        <tr>
          <input type="text" name = "opcp" id="opcp" value= "2" hidden="true"/>
          <td colspan="2"><strong class="text-dark" style="font-family: Baskerville;">Fecha de Solicitud</strong> <input type="date" name="fecSolP" id="fecSolP" value="<?php echo date("Y-m-d");?>"></td>
        </tr>

        <tr>
          <td><strong class="text-dark" style="font-family: Baskerville;">Información Personal</strong></td>
        </tr>
        <tr>
          <td><label class="text-dark" style="font-family: Baskerville;">Cod. Empleado:</label>
            <input type="text" name="EmpCod_" id="EmpCod_" disabled="true"></td>
        </tr>

        <tr>
          <td>
            <input type="text" name="nombreSo" id="nombreSo" placeholder="Nombres">
            <input type="text" name="apP_" id="apP_" placeholder="Apellido Paterno">
            <input type="text" name="apM_" id="apM_" placeholder="Apellido Materno">
            <br><br>
            
            <input type="text" name="tAre" id="tAre" placeholder="Área">
            <input type="text" name="tAreD" id="tAreD" placeholder="Área">
            <input type="text" name="tDe" id="tDe" placeholder="Departamento">
            <input type="text" name="tDeD" id="tDeD" placeholder="Departamento">
            <input type="text" name="tCa_" id="tCa_" placeholder="Cargo">
            <input type="text" name="tCa_D" id="tCa_D" placeholder="Cargo">
            <input type="text" name="tSuel_" id="tSuel_" placeholder="Sueldo">

            <input type="text" name="tmov_" id="tmov_" placeholder="Motivo del prestamo">
            <br><br>

            <label class="text-dark" style="font-family: Baskerville;"> Monto Solicitado: $</label>
            <input type="number" name="monto" id="monto">

            <br><br>
            <!--<label class="text-dark" style="font-family: Baskerville;"> Monto Aprobado: $</label>
            <input type="number" name="montoA" id="montoA" disabled = "true";>

            <label class="text-dark" style="font-family: Baskerville;"> Descuento: $</label>
            <input type="number" name="montoDesc" id="montoDesc" disabled = "true";>-->
            <br><br>
          </td>
        </tr>

        
      </table>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guarPres()">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Seguros-->
<div class="modal fade" id="segu" tabindex="-1" role="dialog" aria-labelledby="segu" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitud de Seguros</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <table>
        <tr>
          <input type="text" name = "opcs" id="opcs" value= "3" hidden="true"/>
          <td colspan="2"><strong class="text-dark" style="font-family: Baskerville;">Fecha de Solicitud</strong> <input type="date" name="fecSolS" id="fecSolS" value="<?php echo date("Y-m-d");?>"></td>
        </tr>

        <tr>
          <td><strong class="text-dark" style="font-family: Baskerville;">Información Personal</strong></td>
        </tr>
        <tr>
          <td colspan="2">
            <label class="text-dark" style="font-family: Baskerville;">Cod. Empleado:</label>
            <input type="text" name="EmpCodS_" id="EmpCodS_" disabled="true">
            <br>
            <button type="button" class="btn btn-danger" id="auto" onclick="hola()">Auto</button>
            <button type="button" class="btn btn-success" id="vida" onclick="cVid()">Vida</button>

            <div id="divocultamuestra" style="display:none;">
              
              <input type="text" name="marca" id="marca" placeholder="Marca" style="text-transform:uppercase;">
              
              <input type="text" name="modelo" id="modelo" placeholder="Modelo" style="text-transform:uppercase;">
              
              
              <input type="number" name="anio" id="anio" placeholder="Año" min="1980" max="2030">
              <br>
              <input type="number" name="nump" id="nump" placeholder="Num. Puertas" min="2" max="8">
              <input type="text" name="plac" id="plac" placeholder="Placas" style="text-transform:uppercase;">
              <input type="text" name="nFac" id="nFac" placeholder="Factura" style="text-transform:uppercase;">
              <br>
              <input type="text" name="nTc" id="nTc" placeholder="Tarjeta Circulación" style="text-transform:uppercase;">
              <input type="text" name="nSer" id="nSer" placeholder="Num. Serie">
              <input type="text" name="nMoc" id="nMoc" placeholder="Num. Motor" style="text-transform:uppercase;">
            </div>

            <div id="divvida" style="display:none;">
              
              <input type="text" name="nom" id="nom" placeholder="Nombre Completo">
              
              <input type="number" name="edad" id="edad" min="18" max="80" placeholder="Edad">
              
              <br>
              <label class="form-check-label text-dark" >Marque las verdaderas</label>
              <br>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="fuma" value = "0">
                <label class="form-check-label text-dark" >¿Fuma?</label>
                <br>
                <input type="checkbox" class="form-check-input" id="toma" value = "0">
                <label class="form-check-label text-dark" >¿Toma?</label>
              </div>
              <br>

              <label class="text-dark" style="font-family: Baskerville;"> Monto Solicitado: $</label>
              <input type="number" name="montoS" id="montoS" min="10000" max="80000">

              <br>
              <label class="text-dark" style="font-family: Baskerville;"> Descuento Deseado: $</label>
              <input type="number" name="desSe" id="desSe" min="500" max="10000">
              
            </div>
          </td>
          <td>
            
          </td>
        </tr>
      </table>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="saveSeguro()">Guardar</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="cCancel()">Cancelar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Autorizaciones-->
<div class="modal fade" id="Aut" tabindex="-1" role="dialog" aria-labelledby="Aut" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Autorizaciones</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <!--<div class="panel panel-blue text-dark">Autorizaciones</div>-->
            <label class="text-dark" style="font-family: Baskerville;">Beneficio:
            <select name="TiBen" id="TiBen">
              <option>  </option>
              <option value="1">Vacaciones</option>
              <option value="2">Permisos</option>
              <option value="3">Consultas</option>
              <!--<option value="4">Guardias</option>-->
            </select>

            <label class="text-dark" style="font-family: Baskerville;">Fecha Solicitud:
            <input type="date" id="filFecha" value="<?php echo date("Y-m-d");?>">
            <button type="button" class="btn btn-success" onclick="llenaGrid()">Buscar</button>
            <input onchange="upsAut()" type="tex" id="CodEmpleados" hidden="true">
            <input onchange="upsAut()" type="tex" id="fec_ini" hidden="true">
            <input onchange="upsAut()" type="tex" id="fec_fin" hidden="true">
            <input type="date" id = "fecA"value="<?php echo date("Y-m-d");?>" hidden= "true">
          </div>
        </div>      
      </div>

      

      <div class="input-group p-2">
        
        <div class="table-responsive"> <!-- sm md lg xl -->
          <table id="tblOsOrd_Vac" class="table table-sm">
            <thead  class="table-dark">
              <tr>
                <th class="header" scope="col">Cod. Empleado</th>
                <th class="header" scope="col">Nombre</th>
                <th class="header" scope="col">Departamento</th>
                <th class="header" scope="col">Fecha Sol.</th>
                <th class="header" scope="col">Fecha Inicio</th>
                <th class="header" scope="col">Fecha Fin</th>
                <th class="header" scope="col">Acción</th>
              </tr>
            </thead>
            <tbody class="text-dark">
              
            </tbody>
          </table>
        </div>
      </div>
      

      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary" onclick="">Guardar</button>-->
        <button type="button" class="btn btn-info" data-dismiss="modal" onClick="llenartabla2()">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Confirmación-->
<div class="modal fade" id="Aut2" tabindex="-1" role="dialog" aria-labelledby="Aut2" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Confirmación</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="upsAut()">Confirmar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="upsAutN()">Negar</button>
          </div>
        </div>      
      </div>

    </div>
  </div>
</div>

<!-- Modal Autorizaciones Guardias-->
<div class="modal fade" id="AutG" tabindex="-1" role="dialog" aria-labelledby="AutG" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Autorizaciones de Guardias</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <!--<div class="panel panel-blue text-dark">Autorizaciones</div>-->
            <button type="button" class="btn btn-success" onclick="llenaGridG()">Buscar</button>
            <input type="text" id="cod_guar" hidden = "true">
          </div>
        </div>      
      </div>

      

      <div class="input-group p-2">
        
        <div class="table-responsive"> <!-- sm md lg xl -->
          <table id="tblOsOrd_" class="table table-sm">
            <thead  class="table-dark">
              <tr>
                <th class="header" scope="col">Cod. Empleado</th>
                <th class="header" scope="col">Nombre</th>
                <th class="header" scope="col">Departamento</th>
                <th class="header" scope="col">Fecha Sol.</th>
                <th class="header" scope="col">Fecha Inicio</th>
                <th class="header" scope="col">Acción</th>
              </tr>
            </thead>
            <tbody class="text-dark">
              
            </tbody>
          </table>
        </div>
      </div>
      

      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary" onclick="">Guardar</button>-->
        <button type="button" class="btn btn-info" data-dismiss="modal" >Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Confirmación de Guardias-->
<div class="modal fade" id="AutGu" tabindex="-1" role="dialog" aria-labelledby="AutGu" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Confirmación de Guardias</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <button type="button" class="btn btn-success" data-dismiss="modal" onclick="upsAut2()">Confirmar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="upsAutN2()">Negar</button>
          </div>
        </div>      
      </div>

    </div>
  </div>
</div>

<!-- Modal Grid Prestamos-->
<div class="modal fade" id="gridPres" tabindex="-1" role="dialog" aria-labelledby="gridPres" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Solicitudes de Prestamos</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col">
            <!--<div class="panel panel-blue text-dark">Autorizaciones</div>-->
          <!--/////////Espacio para las validaciones///////////////////-->
          <input type="text" id="PresCod" hidden="true">
          <input type="date" id ="fecPres"value="" hidden="true">  
          <input type="text" id="PresA" hidden="true">
          <input type="text" id="PresSA" hidden="true">
          <input type="text" id="PresPues" hidden="true">
          <input type="text" id="PresMnSol" hidden="true">
          <input type="text" id="SuelPres" hidden="true">
            

            <button type="button" class="btn btn-success" onclick="llenarPres()">Listar</button>
            
          </div>
        </div>      
      </div>

      

      <div class="input-group p-2">
        
        <div class="table-responsive"> <!-- sm md lg xl -->
          <table id="tblOsOrdPres" class="table table-sm">
            <thead  class="table-dark">
              <tr>
                <th class="header" scope="col">Cod. Empleado</th>
                <th class="header" scope="col">Fecha Sol.</th>
                <th class="header" scope="col">Nombre</th>
                <th class="header" scope="col">Cod.Área</th>
                <th class="header" scope="col">DescA</th>
                <th class="header" scope="col">Cod. SubÁrea</th>
                <th class="header" scope="col">DescSa</th>
                <th class="header" scope="col">Sueldo</th>
                <th class="header" scope="col">Cantidad Solicitada</th>
                <th class="header" scope="col">Motivo</th>
                <th class="header" scope="col">Acción</th>
              </tr>
            </thead>
            <tbody class="text-dark">
              
            </tbody>
          </table>
        </div>
      </div>
      

      <div class="modal-footer">
        <!--<button type="button" class="btn btn-primary" onclick="">Guardar</button>-->
        <button type="button" class="btn btn-info" data-dismiss="modal" onClick="vaciarGrid()">Cerrar</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Confirmación de Solicitud de Prestamos-->
<div class="modal fade" id="autPres" name="autPres" tabindex="-1" role="dialog" aria-labelledby="autPres" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: rgb(0,0,0); font-family: Baskerville; text-align: center;"><b>Confirmación de Prestamo</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="">
        <input type="date" id="FecSol_" value="<?php echo date("Y-m-d");?>">

        <label class="text-dark">Cantidad Autorizada:
        <input type="number" id="cantAut">

        <label class="text-dark">Descuento:
        <input type="number" id="descuentoAut">
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col">
            <button id="segPres1" type="button" class="btn btn-success" data-dismiss="modal" onclick="updateSolPrestamo()">Confirmar</button>
            <button id="segPres2" type="button" class="btn btn-danger" data-dismiss="modal" onclick="updateSolPrestamoN()">Negar</button>
          </div>
        </div>      
      </div>

    </div>
  </div>
</div>

<!--------------- MODAL DE INFORMACIÓN INFORMACIÓN------------------------>
<div class="modal fade bd-example-modal-lg" id="infoArch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">¿Cómo subir los archivos?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark">
        <lu>
        <li>Los archivos deben de ser extensión ".pdf"</li>
        <br>
        <li>Los archivos no pueden ser mayor a 2mb de peso.</li>
        <br>  
        <li>La nomenclatura para subir los archivos es:
          "curp" + "tipo de documento (acta, comprobante, etc)"</li>
      </lu>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!--------------- MODAL DE SOLICITUD DOCUMENTOS------------------------>
<div class="modal fade" id="mSolicitud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Solitante:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Motivo:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button success" class="btn btn-secondary" data-dismiss="modal" onclick="enviaC()">Enviar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="mSolicitud1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Solitante:</label>
            <input type="text" class="form-control" id="recipient-nameuno">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Motivo:</label>
            <textarea class="form-control" id="message-textuno"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button success" class="btn btn-secondary" data-dismiss="modal" onclick="enviaCarta()">Enviar</button>
      </div>
    </div>
  </div>
</div>

<!--------------- MODAL DEL ORGANIGRAMA------------------------>
<div class="modal fade" id="mOrganigrama" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">ORGANIGRAMA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
	   <input id="idDepto" value="<?php echo$_SESSION['nameImg']; ?>" hidden="true">
	  
	  <img src="<?php echo $_SESSION['nameImg'];?>" class="zoom">
      <!--<div class="modal-footer">
        <button type="button success" class="btn btn-secondary" data-dismiss="modal" onclick="enviar()">Enviar</button>
      </div>-->
	  
	  
    </div>
  </div>
</div>

<script type="text/javascript">
//bloquear controles
//
//termino de bloqueo
//modGridPres
var atu = document.getElementById("CodAuts").value;
if(atu == 3){
  //alert("Si puede autorizar prestamos");
  btnPres = document.getElementById("modGridPres");
  btnPres.disabled = false;
}else{
  //alert("No puede autorizar prestamos");
  btnPres = document.getElementById("modGridPres");
  btnPres.disabled = true;
  btnPres.visibility = "hidden";
}

var dT = document.getElementById('VacTotal').value;
var dR = document.getElementById('VacTomadas').value;
if(dT == dR){
  btn1 = document.getElementById('btnVac');
  btn2 = document.getElementById('btnGuardia');
  btn1.disabled = true;
  btn2.disabled = true;
}else{
  btn1 = document.getElementById('btnVac');
  btn2 = document.getElementById('btnGuardia');
  btn1.disabled = false;
  btn2.disabled = false;
}

var opcA = document.getElementById('CodAuts').value;
if(opcA == 0){
  //alert(opcA);
  //alert("No puedes autorizar");
  a = document.getElementById('modAut');
  a.disabled = true;
  a.style.display = "none";
  a.visibility = "hidden";
}else{
  //alert("Puedes autorizar");
  a = document.getElementById('modAut');
  a.disabled = false;
  a.style.display = "block";
}

if(opcA == 1){
  b = document.getElementById('modAutG');
  b.disabled = false;
  b.style.display = "block";
}else{
  b = document.getElementById('modAutG');
  b.disabled = true;
  b.style.display = "none";
  b.visibility = "hidden";
}

var checkbox = document.getElementById('fuma');
checkbox.addEventListener( 'change', function() {
    if(this.checked) {
       alert('checkbox Fuma sesta seleccionado');
       checkbox.value = "1";
    }else{
      checkbox.value = "0";
    }
});

var checkbox2 = document.getElementById('toma');
checkbox2.addEventListener( 'change', function() {
    if(this.checked) {
       alert('checkbox Toma sesta seleccionado');
       checkbox2.value = "1";
    }else{
      checkbox2.value = "0";
    }
});

//funciones para las jornadas 
function vacT(){
	//alert("funcionan las vacaciones");
	var x = document.getElementById("divJornada");
    var btnVaca = document.getElementById('btnVac');
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById('btnPer').disabled=true;
        document.getElementById('btnCon').disabled=true;
    } else {
        x.style.display = "none";
        document.getElementById('btnPer').disabled=false;
		document.getElementById('btnCon').disabled=false;
        //document.getElementById('auto').value = 0;
    }
  }

function com(){
	//alert("funciona1");
    var x = document.getElementById("divFechas");
    var Completa = document.getElementById('btnComJ');
	var manana = document.getElementById('medMa');
	var tade = document.getElementById('medTa');
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById('fecIni').disabled=false;
		document.getElementById('fecFin').disabled=false;
		document.getElementById('fecFin').style.visibility = 'visibility';
		document.getElementById('medMa').style.visibility = 'hidden';
		document.getElementById('medMa1').style.visibility = 'hidden';
		document.getElementById('medTa').style.visibility = 'hidden';
		document.getElementById('medTa1').style.visibility = 'hidden';
		document.getElementById('tituloTime').style.visibility = 'hidden';
		//manana.style.display = "none";
		//tade.style.display = "none";
        document.getElementById('btnMedJ').disabled=true;
    } else {
        x.style.display = "none";
        document.getElementById('fecIni').disabled=true;
		document.getElementById('fecFin').disabled=true;
        document.getElementById('btnMedJ').disabled=false;
    }
  }

function med(){
	var x = document.getElementById("divFechas");
	var media = document.getElementById('btnMedJ');
	if(x.style.display == "none"){
		x.style.display = "block";
		document.getElementById('btnComJ').disabled = true;
		document.getElementById('fecFin').style.visibility = 'hidden';
	}else{
		x.style.display = "none";
		document.getElementById('btnComJ').disabled = false;
		document.getElementById('fecFin').style.visibility = 'visible';
	}
	
    //alert("funciona2");
	/*var x = document.getElementById("divFechas");
    var media = document.getElementById('btnMedJ');
    if (x.style.display === "none") {
        x.style.display = "block";
		document.getElementById('btnComJ').disabled=true;
        document.getElementById('fecIni').disabled=false;
		document.getElementById('fecFin').style.visibility = 'hidden';
        document.getElementById('medMa').style.visibility = 'visible';
		document.getElementById('medMa1').style.visibility = 'visible';
		document.getElementById('medTa').style.visibility = 'visible';
		document.getElementById('medTa1').style.visibility = 'visible';
		document.getElementById('tituloTime').style.visibility = 'visible';
    } else {
        x.style.display = "none";
        document.getElementById('fecIni').disabled=true;
		document.getElementById('fecFin').disabled=true;
		document.getElementById('btnComJ').disabled=false;
        document.getElementById('auto').value = 0;
    }*/
  }

//funciones para los seguros 

  function hola(){
    var x = document.getElementById("divocultamuestra");
    var btnAuto = document.getElementById('auto');
    //  document.getElementById('vida').disabled=false;
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById('vida').disabled=true;
        document.getElementById('auto').value = 1;
        document.getElementById('vida').value = 0;
    } else {
        x.style.display = "none";
        document.getElementById('vida').disabled=false;
        document.getElementById('auto').value = 0;
    }
  }

  function cVid(){
    var x = document.getElementById("divvida");
    if (x.style.display === "none") {
        x.style.display = "block";
        document.getElementById('auto').disabled=true;
        document.getElementById('vida').value = 2;
        document.getElementById('auto').value = 0;
    } else {
        x.style.display = "none";
        document.getElementById('auto').disabled=false;
        document.getElementById('vida').value = 0;
    }
  }

  function cCancel(){
    var x = document.getElementById("divvida");
    var y = document.getElementById("divocultamuestra");

    x.style.display = "none";
    y.style.display = "none";
    document.getElementById('auto').disabled=false;
    document.getElementById('vida').disabled=false;
  }
  
  function enviar(){
	  alert('Solicitud Enviada');
  }
  
  $(document).ready(function(){
    $('.zoom').hover(function() {
        $(this).addClass('transition');
    }, function() {
        $(this).removeClass('transition');
    });
});


</script>

<?php

function obtener_estructura_directorios($ruta){
  // Se comprueba que realmente sea la ruta de un directorio
  if (is_dir($ruta)){
      // Abre un gestor de directorios para la ruta indicada
      $gestor = opendir($ruta);
      echo "<ul>";

      // Recorre todos los elementos del directorio
      while (($archivo = readdir($gestor)) !== false)  {
              
          $ruta_completa = $ruta . "/" . $archivo;

          // Se muestran todos los archivos y carpetas excepto "." y ".."
          if ($archivo != "." && $archivo != "..") {
              // Si es un directorio se recorre recursivamente
              if (is_dir($ruta_completa)) {
                  echo "<li style='color:black;'>" . $archivo . "</li>";
                  obtener_estructura_directorios($ruta_completa);
              } else {
                  echo "<th class='text-dark' style='color:green'>" . $archivo . "</th>";
              }
          }
      }
      
      // Cierra el gestor de directorios
      closedir($gestor);
      echo "</ul>";
  } else {
      echo "No hay documentos cargados<br/>";
  }
}

?>

<!-- Espacio para axios y js -->
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script type="text/javascript" src="prue.js"></script>
  <script type="text/javascript" src="js/aut.js"></script>
  <script type="text/javascript" src="js/const.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

</body>
</html>