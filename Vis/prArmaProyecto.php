<?php

session_start();
 ?>


<!-- ELEMENTO DE DEBUG -->
        <div class="container">
            <div class="row vh-100 justify-content-center align-items-center">
                <div class="col-auto bg-light p-5">
                    <strong>Definir Proyecto</strong>
                    <hr>
                        <div class="input-group p-2">
                            <strong><label for="CboUneg">U.Negocio&nbsp;&nbsp;&nbsp;</label></strong>
                            <Select  class="form-select" aria-label="Default select example" id="CboUneg" name='CboUneg'></select>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" class="form-control" id="Buscar" placeholder="Bucar Proyecto"> &nbsp;&nbsp;&nbsp;
                            <button type="button"  id="cmdBuscar" class="btn btn-primary" onclick="ObtenertProyectoB()">Buscar</button>
                        </div>
                         <div class="input-group p-2">
                              <div class="table-responsive">
                                 <table id="tblUNeg" class="table table-sm">
                                      <thead class="table-dark">
                                         <tr>
                                             <th class="header" scope="col">Codigo</th>
                                             <th class="header" scope="col">Nombre</th>
                                             <th class="header" scope="col">Observacion</th>
                                             <th class="header" scope="col">U. Negocio</th>
                                         </tr>
                                     </thead>
                                     <tbody>

                                     </tbody>
                                 </table>
                             </div>
                         </div>
                       <div id="txtMostrar"></div>
                       <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                          <button class="btn btn-primary me-md-2" id="cmdAgregar" type="button"
                                      onclick="setOpcion(1)">Agregar o Quitar Rubro</button>
                           <!-- comment <button class="btn btn-primary" id="cmdEditar" type="button"
                                      onclick="setOpcion(2)">Editar</button>
                          <button class="btn btn-primary" id="cmdEliminar" type="button"
                            onclick="setOpcion(3)">Eliminar</button>
                            -->
                       </div>
                       <strong>Rubros asignados al Proyecto</strong>
                       <div class="input-group p-2" style="width:80%">
                              <div class="table-responsive-sm">
                                 <table id="tblRubro" class="table table-sm">
                                      <thead class="table-dark">
                                         <tr>
                                             <th class="header" scope="col">Codigo</th>
                                             <th class="header" scope="col">Nombre</th>
                                             <th class="header" scope="col">Valor en Proyecto</th>
                                             <th class="header" scope="col">Estatus</th>
                                             <th class="header" scope="col">Tareas</th>
                                         </tr>
                                     </thead>
                                     <tbody>

                                     </tbody>
                                 </table>
                             </div>                            
                      </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
            <div class="modal fade" id="frmAddRubro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registro de Rubro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                  </div>
                  <div id="innerHTML"></div>
                  <div class="modal-body">
                       <div class="input-group flex-nowrap flex-nowrap ">                           
                            <div class="row">
                                 <strong><label for="CboGteMtto">Pertenece A</label></strong>
                                 <Select  class="form-select" aria-label="Default select example" id="CboGteMtto" name='CboGteMtto' onchange="LlenarRubroList1()" ></select>
                                     <strong><label for="CboRubro">Seleccionar Rubro</label> </strong>
                                     <select class="form-select" size="4" aria-label="size 10 select example" id="CboRubro" >
                                    </select>
                                    <div> <center>  <br>
                                       <button type="button" class="btn btn-success" id="cmdAgregar" onclick="AddRubro()">&#8595;&#8595;</button>                                    
                                       <button type="button" class="btn btn-danger" id="cmdQuitar"  onclick="DelRubro()">&#8593;&#8593;</button> </cente>
                                   </div>                                
                                    <strong><label for="CboRubro">Rubros en el Proyecto</label> </strong>
                                    <select class="form-select" size="4" aria-label="size 10 select example" id="CboRubroPry">                                        
                                    </select> 
                             </div>
                         </div>
                  </div>
                  <div class="modal-footer">                      
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                  </div>
                </div>
              </div>
            </div>

        
        
         <!-- Modal ver Tareas -->
            <div class="modal fade" id="frmVerTareas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><strong><label id="Titulo">Ver Tareas</label></strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                  </div>                 
                  <div class="modal-body">
                       <div class="input-group flex-nowrap flex-nowrap ">                           
                            <div class="row">
                                <div class="input-group p-2" >
                                        <div class="table-responsive-sm">
                                           <table id="tblTareas" class="table table-sm">
                                                <thead class="table-dark">
                                                   <tr>
                                                       <th class="header" scope="col">Codigo</th>
                                                       <th class="header" scope="col">Nombre</th>
                                                       <th class="header" scope="col">Valor en Rubro</th>
                                                       <th class="header" scope="col">Valor Avance</th>                                                      
                                                   </tr>
                                               </thead>
                                               <tbody>

                                               </tbody>
                                           </table>
                                       </div>                            
                                </div>
                             </div>
                         </div>
                  </div>
                  <div class="modal-footer">                      
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                  </div>
                </div>
              </div>
            </div>


        <!--Dialogo para preguntar eliminacion -->
        <div class="modal fade" id="PreguntaSiNo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro Seleccionado</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ModPregSiNo">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                  <button type="button" class="btn btn-danger" onclick="drvOperacion()">SI</button>
                </div>
              </div>
            </div>
        </div>






       
        <script src="js/prArmaProyecto.js" type="text/javascript"></script>        
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/styVis.css" rel="stylesheet" type="text/css"/>
