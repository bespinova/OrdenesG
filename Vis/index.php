<?php
include_once("../ClsParam.php");
include_once("../ClsMsSql.php");
include_once("../core.php");

session_start();

if (!isset($_SESSION['id_app'])) {
    header("Location: ../Vis/login.html");
}else {
  $objParam = new ClsParam($_SESSION['path']);
  $conDb = new ClsMsSql($_SESSION['Servidor'],$_SESSION['Usuario'],$_SESSION['Datos'],$_SESSION['Passw']);
  if ($conDb->Conextar() == 0) {
    return "Error al conectarse en la base de datos";
  }
}
?>
<!DOCTYPE html>
  <html lang="es">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
    
      <title>Página de Inicio</title>
      <!--Favicon-->
      <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
      <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Core theme CSS (includes Bootstrap)-->
      <link href="css/styles.css" rel="stylesheet"/>
      <link rel="stylesheet" href="css/navbar.css"/>

    </head>
    <body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div  class="dropdown">
			<a  class="dropdown-toggle" data-bs-toggle="dropdown"></a>
			<ul class="dropdown-menu "><li>
			<a href="#" class="nav_link-option" onclick="cerrarSesion();"><i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar Sesión</span> </a></li></ul>
        </div>
    </header>
    <div class="l-navbar" id="nav-bar">
      <nav class="nav">
        <div> <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">GRUPO CAMACHO</span> </a>
          <div class="nav_list">
            <li>
              <a href="#" class="nav_link submenu" title="Catálogos"><i class='bx bx-list-ul'></i><span class="nav_name">Catálogos</span></a>
              <ul class="collapse submenu">
                <div>
                <a class="nav-link " onclick="SlcMenu(1);" title="Unidad de Negocioss"><i class='bx bx-chevron-right'></i><span class="nav_name">Unidad de Negocio</span></a>
                <div class="tooltip ">
                  <p>Right</p>
                </div>
                </div>
                <a class="nav-link" onclick="scCatalogos(2);" title="Áreas"><i class='bx bx-chevron-right'></i><span>Áreas</span></a>
                <a class="nav-link" onclick="scCatalogos(4);" title="Gerente de Mantenimiento"><i class='bx bx-chevron-right'></i><span>Gerente de Mantenimiento</span></a>
                <a class="nav-link" onclick="scCatalogos(1);" title="Solicitantes"><i class='bx bx-chevron-right'></i><span>Solicitantes</span></a>
                <a class="nav-link" onclick="scCatalogos(3);" title="Empleados"><i class='bx bx-chevron-right'></i><span>Empleados</span></a>
                <a class="nav-link" onclick="scCatalogos(11);" title="Uni. Maquinaria Pesada"><i class='bx bx-chevron-right'></i><span>Uni. Maquinaria Pesada</span></a>
                <a class="nav-link" onclick="scCatalogos(5);" title="Usuarios"><i class='bx bx-chevron-right'></i><span>Usuarios</span></a>
              </ul>
            </li>
            <li><a href="#" class="nav_link" title="OS General" onclick="SlcMenu(2)"><i class='bx bx-book-content'></i><span class="nav_name">OS General</span></a></li>
            <li>
              <a href="#" class="nav_link submenu" title="Proyectos de Inversión"><i class='bx bx-home-alt'></i><span class="nav_name">Proyectos de Inversión</span></a>
              <ul class="collapse submenu">
                <a class="nav-link" onclick="scCatalogos(6);" title="Proyectos"><i class='bx bx-chevron-right'></i><span>Proyectos</span></a>
                <a class="nav-link" onclick="scCatalogos(7);" title="Rubros"><i class='bx bx-chevron-right'></i><span>Rubros</span></a>
                <a class="nav-link" onclick="scCatalogos(8);" title="Asignar Tarea"><i class='bx bx-chevron-right'></i><span>Asignar Tarea</span></a>
                <a class="nav-link" onclick="scCatalogos(9);" title="Armar Proyecto"><i class='bx bx-chevron-right'></i><span>Armar Proyecto</span></a>
                <a class="nav-link" onclick="scCatalogos(10);" title="Revisión de Proyectos"><i class='bx bx-chevron-right'></i><span>Revisión de Proyectos</span></a>
              </ul>
            </li>
            <li>
              <a href="#" class="nav_link submenu" title="Reportes"><i class='bx bxs-report'></i><span class="nav_name">Reportes</span></a>
              <ul class="collapse submenu">
                <a class="nav-link" onclick="scCatalogos(12);" title="Maquinaria Pesada"><i class='bx bx-chevron-right'></i><span>Maquinaria Pesada</span></a>
				<a class="nav-link" onclick="scCatalogos(13;" title="Solicitud de Proyecto"><i class='bx bx-chevron-right'></i><span>Solicitud de Proyecto</span></a>
                
              </ul>
            </li>
          </div>
        </div> 
      </nav>
    </div>
    <!--Container Main start-->
    <div class="height-100 bg-light" id="winTrabajo">
      <h1>Grupo Camacho</h1>
    </div>
      <script src="../js/jquery.min.js" type="text/javascript"></script>

      <!-- Core theme JS-->
      <script src="js/login.js" type="text/javascript"></script>
      <script src="js/scripts.js"></script>
      <script src="js/eventos.js" type="text/javascript"></script>
      <script src="js/scCatalogos.js" type="text/javascript"></script>

      <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" type="text/css"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" type="text/css"></script>
    </body>
  </html>
