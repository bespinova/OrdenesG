<div class="container">
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-auto bg-light p-5">
            <strong>Usuarios</strong>
            <hr>
                <div class="input-group p-2">
                    <input type="text" class="form-control" id="IdBuscar" placeholder="Buscar Usuario">
                    <button type="button"  id="cmdBuscar"  class="btn btn-primary" onclick="busquedUsr();">Buscar</button>
                 </div>
                 <div id="txtMostrar"></div>
                 <div class="input-group p-2">
                      <div class="table-responsive" style="height: 300px;">
                         <table id="tblOsOrd" class="table table-sm" style="width: 1200px;">
                             <thead class="table-dark">
                                 <tr>
                                     <th class="header" scope="col">Usuario</th>
                                     <th class="header" scope="col">Nombre</th>
                                     <th  class="header" scope="col">Perfil</th>
                                     <th  class="header" scope="col">Solicitante</th>
                                     <th  class="header" scope="col">Gerente</th>
                                 </tr>
                             </thead>
                             <tbody>

                             </tbody>
                         </table>
                     </div>
                 </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                  <button class="btn btn-primary me-md-2" id="cmdAgregar" type="button"
                          data-bs-toggle="modal" data-bs-target="#frmSolicita" onclick="setOpcion(1)">Agregar</button>
                  <button class="btn btn-primary" id="cmdEditar" type="button"
                          data-bs-toggle="modal" data-bs-target="#frmSolicita" onclick="setOpcion(2)">Editar</button>
                  <button class="btn btn-primary" id="cmdEliminar" type="button"
                          onclick="setOpcion(3)">Eliminar</button>
                </div>
        </div>
    </div>
</div>


<!-- Modal -->
    <div class="modal fade" id="frmSolicita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Formulario de Usuarios:</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
          </div>
            <div id="innerHTML"></div>
            <div class="modal-body">
                <input type="text" class="form-control" id="idUser" placeholder="Usuario" required> <br>
                <div class="col-md-12"><input type="text" class="form-control" id="Nombre" placeholder="Nombre completo" required></div><br>
                <div class="col-md-12"><input type="password" class="form-control" id="idPassword" placeholder="Contraseña" required></div><br>
                <div class="col-md-12"><input type="password" class="form-control" id="idPassword2" placeholder="Confirma contraseña" onchange="validaPass();" required></div><br>

                 <div class="input-group p-2">
                  <div class="form-group col-md-12">
                     <strong><label for="CboAsigA">Perfil:</label></strong>
                     <Select  class="form-select" aria-label="Default select example" id="CboPerfil" onchange="obtValue();" ></select>
                  </div>
                </div>

                <!--<div class="form-check">
                  <input type="checkbox" class="form-check-input" id="chkSolicita" onchange="mostrarCombos();" >
                  <label class="form-check-label" for="exampleCheck1">¿Es Solicitante?</label>
                </div> -->

                <div class="input-group p-2" id="elementSolicita">
                 <div class="form-group col-md-12">
                    <strong><label for="CboAsigA">Solicitante:</label></strong>
                    <Select  class="form-select" aria-label="Default select example" id="CboSolicitante"></select>
                 </div>
               </div>
               <!-- combo y check -->
               <!--<div class="form-check">
                 <input type="checkbox" class="form-check-input" id="chkGte" onchange="mostrarCombos();">
                 <label class="form-check-label" for="exampleCheck1">¿Es Geretente?</label>
               </div> -->

               <div class="input-group p-2" id="elementGte">
                <div class="form-group col-md-12">
                   <strong><label for="CboAsigA">Gerente:</label></strong>
                   <Select  class="form-select" aria-label="Default select example" id="CboGte"></select>
                </div>
              </div>
              <!-- combo y check -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="cmdGuardar" onclick="drvOperacion();">Guardar</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="closeMd()">Cancelar</button>
                </div>
            </div>
        </div>
      </div>

<script src="js/CatUsuarios.js" type="text/javascript"></script>
