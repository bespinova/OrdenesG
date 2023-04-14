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
  <div class="row vh-100 justify-content-center align-items-center">
      <div class="col-auto p-5">
      <div class="row">
      <div class="col-md-11"><h2><strong>Unidades de Maquinaria Pesada</strong></h2></div>
        <div class="col-md-1 text-center">
            <a class="btn btn-light me-md-2" id="cmdAgregar" data-bs-toggle="modal" data-bs-target="#frmCatVehMaqPesada" onclick="setOpcion(1)"><i class='bx bxs-plus-circle nav_icons' style='color:#0a6121'></i></a>
      </div>
      </div>
          <hr>
              <div class="input-group p-2">
                  <input type="text" class="form-control" id="Buscar" placeholder="Bucar Unidad">
                  <button type="button"  id="cmdBuscar" class="btn btn-outline" onclick="ObtenertUnidadB()">Buscar</button>
                </div>
                <div id="txtMostrar"></div>
                <div class="input-group p-2">
                    <div class="table-responsive" style="height: 300px;">
                        <table id="tblUNeg" class="table table-sm" style="width: 1200px;">
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
  <div class="modal fade" id="frmCatVehMaqPesada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><strong>Formulario Unidad de Maquinaria Pesada</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
        </div>
        <div id="innerHTML"></div>
        <div class="modal-body">
            <input type="text" class="form-control" id="CodUnidad" placeholder="Codigo">
            <div id="ErrorCodUnidad" style="color: red"></div><br>
            <input type="text" class="form-control" id="Descripcion" placeholder="Descripcion">
            <div id="ErrorDescripcion" style="color: red"></div><br>
              <strong><label for="CboTipoUni">Tipo Unidad</label></strong>
            <Select  class="form-select" aria-label="Default select example" id="CboTipoUni" name='CboTipoUni' ></select>
            <div id="ErrorCboTipoUni" style="color: red"></div>
            <br>
            <label><strong>Estatus</strong></label>
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="Estatus" checked>
              <label class="form-check-label" for="Estatus" id="textoestatus">Trabajando</label>
            </div>
            <br>
              <input type="text" class="form-control" id="Observacion" placeholder="Observacion">
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
            <button type="button" class="btn btn-light" style="background: #F5340F; color:white;" onclick="drvOperacion()">SI</button>
          </div>
        </div>
      </div>
  </div>
</div>
<script>
  $('#Estatus').click(function(){
    if ($('#Estatus').is(':checked')) {
      $('#textoestatus').html('Trabajando');
    } else {
      $('#textoestatus').html('Disponible');
    }
  });
</script>
<script src="js/CatVehMaqPesada.js" type="text/javascript"></script>
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
<!--    </body>
</html>
