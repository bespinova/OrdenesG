<?php

session_start();
 ?>
<head>
  <title>Listado de Ordenes de Servicio Generales</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
   <link href="css/styles.css" rel="stylesheet" />
   <link href="css/styVis.css" rel="stylesheet" type="text/css"/>
</head>
<div class="container">
  <input type="text" class="form-control" id="CodSolicitante" value="<?php echo $_SESSION['codSolicitante']; ?>" hidden>
  <input type="text" class="form-control" id="CodGteMatto" value="<?php echo $_SESSION['codGteMatto']; ?>" hidden>
  <input type="text" class="form-control" id="CodPerfil" value="<?php echo $_SESSION['CodPerfil']; ?>" hidden>

    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-auto p-4">
          <div class="row">
            <div class="col-md-10"><h2><strong>Unidades de Negocio</strong></h2></div>
            <div class="col-md-2">
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-light me-md-2" id="cmdAgregar" data-bs-toggle="modal" data-bs-target="#frmUNegocio" onclick="setOpcion(1)"><i class='bx bxs-plus-circle nav_icons' style='color:#0a6121'></i></a>
            </div>
          </div>
          </div>
            <hr>
                <div class="input-group p-2">
                    <input type="text" class="form-control" id="Buscar" placeholder="Bucar Unidad de Negocio">
                    <button type="button"  id="cmdBuscar"  class="btn btn-outline" onclick="ObtenertUNeg1()">Buscar</button>
                  </div>
                  <div id="txtMostrar"></div>
                  <div class="input-group p-2">
                      <div class="table-responsive" style="height: 300px;overflow: scroll;">
                          <table id="tblUNeg" class="table" style="width: 1200px;">
                              <thead class="table">
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                      </div>
                  </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button class="btn btn-light me-md-2" id="cmdEditar" type="button"
                            onclick="setOpcion(2)">Editar</button>
                  <button class="btn btn-light me-md-2" id="cmdEliminar" type="button"
                          onclick="setOpcion(3)">Eliminar</button>
                </div>
        </div>
    </div>
</div>
        <!-- Modal -->
<div class="modal fade" id="frmUNegocio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong>Formulario Unidad de Negocio</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
      </div>
      <div id="innerHTML"></div>
      <div class="modal-body">
          <input type="text" class="form-control" id="CodUNegocios" placeholder="Código" required>
          <div id="ErrorCodUNegocios" style="color: red"></div><br>
          <input type="text" class="form-control" id="Nombre" placeholder="Nombre" required>
          <div id="ErrorNombre" style="color: red"></div><br>
          <input type="text" class="form-control" id="Obs" placeholder="Observaciones">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" onclick="closeMd()">Cancelar</button>
        <button type="button" class="btn btn-light" style="background: #023444;  color:white;" id="cmdGuardar" onclick="drvOperacion()">Guardar</button>
      </div>
    </div>
  </div>
</div>
            <!--Dialogo para preguntar eliminacion -->
<div class="modal fade" id="PreguntaSiNo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro Seleccionado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="ModPregSiNo">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" style="background: #7D7D7D; color:white;" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-light" style="background: #F5340F; color:white;" onclick="drvOperacion(3)">SI</button>
        </div>
      </div>
    </div>
</div>
<script src="js/CatUNegocios.js" type="text/javascript"></script>
<style>
#cmdBuscar {
  border-color: #313536;
  color:  #313536;
}

#cmdBuscar:hover {
  background-color: #313536;
  color: white;
}
/*azul:#101D31 verde:#0E5530 azulturquesa:#1F4F47*/

#cmdEditar{
  background:#092638;
  color: white;
  border-radius: 10px;
}
#cmdEliminar{
  background:#BA0000;
  color: white;
  border-radius: 10px;
}

/**<i class="material-icons">&#xe2db;</i>*/
</style>