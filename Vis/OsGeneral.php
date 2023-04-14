<?php
    session_start();
?>
<html>
    <head>
        <title>Listado de Ordenes de Servicio Generales</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no ">
         <link href="css/styles.css" rel="stylesheet" />
         <link href="css/styVis.css" rel="stylesheet" type="text/css"/>
         <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body >
        <div class="container">
            <div class="row vh-100 justify-content-center align-items-center">
                <div class="col-auto p-5">
                <div class="col-md-10"><h2><strong>Ordenes de Servicio Generales</strong></h2></div>
                    <hr>
                      <div class="row">
                        <div style=" display: flex; justify-content: right;"> 
                             <a type="button" id="cmdFiltros" onclick="rstFiltros()"><i class="material-icons" style="font-size: 33px; color:#2D2D2D">filter_alt_off</i></a>
                             <br>
                            </div>
                        <div class="form-group col-md-3">
                           <strong><label for="FechaIni">Fecha Inicial</label></strong>
                           <input type="date" class="form-control form-control-sm" id="FechaIni" placeholder="Fecha" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" onchange="SlcFec()">
                           <strong><label for="FechaFin">Fecha Final</label> </strong>
                           <input type="date" class="form-control form-control-sm" id="FechaFin" placeholder="Fecha" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" onchange="SlcFec()" >
                         </div>
                         <div class="form-group col-md-3">
                             <strong><label for="CboEdoDoc">Estatus Doc</label> </strong>
                             <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboEdoDoc" onchange="SlcEdoDoc()">
                                 <option selected >Todos</option>
                                 <option Value="1" >Creado</option>
                                 <option Value="2" >Atendido</option>
                                 <option Value="3" >Terminado</option>
                                 <option Value="4" >Aceptado</option>
                                 <option Value="5" >Rechazado</option>
                             </select>
                             <strong><label for="CboFltUNeg">U. de Negocio</label></strong>
                             <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboFltUNeg" onchange="SlcUNeg()">
                             </select>
                         </div>
                         <div class="form-group col-md-3">
                             <strong><label for="CboPriDoc">Prioridad</label> </strong>
                             <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboPriDoc" onchange="SlcPriDoc()" >
                                 <option selected>Todos</option>
                                 <option Value="100" >Nomal</option>
                                 <option Value="200" >Media</option>
                                 <option Value="300" >Urgente</option>
                             </select>
                             <strong><label for="CboAsgMtto">Asignado A.</label></strong>
                             <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboAsgMtto" onchange="SlcAsMto()">
                             </select>
                         </div>
                         <div class="form-group col-md-3">
                            <strong><label for="CboTpMtto">Tipo de Matto.</label></strong>
                            <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboTpMtto" onchange="SlcTpMtto()">
                                 <option selected >Todos</option>
                                 <option Value="Correctivo" >Correctivo</option>
                                 <option Value="Preventivo" >Preventivo</option>
                             </select>
                            <strong><label for="CboFltSol">Solicitante</label></strong>
                            <Select  class="form-select form-select-sm" aria-label="Default select example" id="CboFltSol" onchange="SlcSolt()">
                             </select>
                         </div>
                      </div>
                    <hr>
                    <div class="input-group p-2 justify-content-md-end"> 
                      <a class="btn btn-light me-md-2" id="cmdAgregar" data-bs-toggle="modal" data-bs-target="#frmOsG" onclick="setOpcion(1)"><i class='bx bxs-plus-circle nav_icons' style='color:#0a6121'></i></a>
                      <br>
                      </div>
                      <div id="txtMostrar"></div>
                    <div  class="input-group p-2">
                              <div  class="table-responsive" style="height: 300px;overflow: scroll;">
                                 <table id="tblOsG" class="table table-sm" style="width: 1200px;">
                                     <thead class="table-dark">
                                     </thead>
                                     <tbody>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                          <button class="btn btn-light me-md-2" id="cmdEditar" type="button"
                                  onclick="setOpcion(2)">Editar</button>
                          <button class="btn btn btn-light me-md-2" id="cmdEliminar" type="button"
                                  onclick="setOpcion(3)">Eliminar</button>
                        </div>
                        <div class="d-grid gap-2 d-md-flex ">
                            <button class="btn btn-outline btn-sm" style="background:#3cb371;" id="cmdAtender" type="button"
                                  onclick="setOpcion(4)"><img src="assets/atencion1.png" alt="" width="20" height="20"> Atender</button>
                            <button class="btn btn-outline btn-sm" style="background:#ffd700;" id="cmdTerminar" type="button"
                                onclick="setOpcion(5)"><img src="assets/terminar.png" alt="" width="20" height="20"> Terminar</button>                            
                            <button class="btn btn-outline btn-sm" style="background:#73c2fb;" id="cmdLiberar" type="button"
                                onclick="setOpcion(6)"><img src="assets/liberar.png" alt="" width="20" height="20"> Liberar OS</button>
                            <a class="btn btn-danger btn-sm" style="background-color:#ff4f4f; color:black;" id="cmdLiberar" type="button"
                                    disabled="true"><img src="assets/rechazar.png" alt="" width="20" height="20"> Rechazado</a>
                           <button class="btn btn-outline btn-sm" style="background:#212529; color:white;" id="cmdVerOs" type="button"
                                onclick="setOpcion(7)"><img src="assets/visualizar1.png" alt="" width="20" height="20"> Ver Os</button>
                            <input type="text" class="form-control" id="CodSolicitante" value="<?php echo $_SESSION['codSolicitante']; ?>" hidden>
                            <input type="text" class="form-control" id="CodGteMatto" value="<?php echo $_SESSION['codGteMatto']; ?>" hidden>
                            <input type="text" class="form-control" id="CodPerfil" value="<?php echo $_SESSION['CodPerfil']; ?>" hidden >
                        </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
            <div class="modal fade" id="frmOsG" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar OS General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
                  </div>
                  <div class="modal-body">                      
                     <strong><label for="CboTipoOS">Tipo Orden de Servicio</label></strong>
                     <Select class="form-select" aria-label="Default select example" id="CboTipoOS" onChange="" ></select>
                     <hr>     
                     <div class="row">
                         <div class="form-group col-md-6">
                            <strong><label for="FechaExp">Fecha Expedicion</label> </strong>
                            <input type="date" class="form-control" id="FechaExp" placeholder="Fecha" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" >
                         </div>
                         <div class="form-group col-md-6">
                            <strong><label for="CboTipoMatto">Tipo de Matto.</label></strong>
                            <Select  class="form-select" aria-label="Default select example" id="CboTipoMatto" >
                                 <option Value="Correctivo" >Correctivo</option>
                                 <option Value="Preventivo" >Preventivo</option>
                             </select>
                         </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6">
                              <strong><label for="CboUneg">Unidad de Negocio</label></strong>
                             <Select  class="form-select" aria-label="Default select example" id="CboUneg" onChange="SlcUneg(this.value);" ></select>
                             <div id="ErrorUNegocio" style="color: red"></div>
                          </div>
                          <div class="form-group col-md-6">
                            <strong><label for="CboSol">Solicitante</label></strong>
                             <Select  class="form-select" aria-label="Default select example" id="CboSol" onChange="llenaCboArea(this.value);" ></select>
                             <div id="ErrorSol" style="color: red"></div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6">
                              <strong><label for="CboArea">Área</label></strong>
                             <Select  class="form-select" aria-label="Default select example" id="CboArea" ></select>
                             <div id="ErrorArea" style="color: red"></div>
                          </div>
                          <div class="form-group col-md-6">
                             <strong><label for="CboAsigA">Asinada A</label></strong>
                             <Select  class="form-select" aria-label="Default select example" id="CboAsigA" ></select>
                             <div id="ErrorJmtto" style="color: red"></div>
                          </div>
                      </div>
                      <strong><label for="CboPrioridad">Prioridad</label></strong>
                      <Select  class="form-select" aria-label="Default select example" id="CboPrioridad" >
                           <option Value="100" >Nomal</option>
                           <option Value="200" >Media</option>
                           <option Value="300" >Urgente</option>
                       </select>
                       <strong><label for="DscFallo">Descripcion del Fallo</label> </strong>
                      <textarea class="form-control" id="DscFallo" rows="3"></textarea>
                      <div id="ErrorDesfa" style="color: red"></div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" onclick="closeMd()" >Cancelar</button>
                      <button type="button" class="btn btn-light" style="background: #023444;  color:white;" id="cmdGuardar" onclick="drvOperacion()">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          <!-- Modal para Atender una OS -->
            <div class="modal fade" id="frmATOsG" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atender OS General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
                  </div>
                  <div class="modal-body">
                     <strong><label for="TipoOS">Tipo Orden de Servicio</label></strong>
                     <input type="text" class="form-control" id="TipoOS" readonly>
                     <hr>  
                     <div class="row">
                         <div class="form-group col-md-6">
                            <strong><label for="No.OS">No. OS</label> </strong>
                            <input type="text" class="form-control" id="NoOS" readonly>
                         </div>
                         <div class="form-group col-md-6">
                            <strong><label for="FecExp">Fecha Exp.</label></strong>
                            <input type="text" class="form-control" id="FecExp" readonly>
                         </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6">
                              <strong><label for="Uneg">Unidad de Negocio</label></strong>
                             <input type="text" class="form-control" id="Uneg" readonly>
                          </div>
                          <div class="form-group col-md-6">
                            <strong><label for="Area">Area</label></strong>
                             <input type="text" class="form-control" id="Area" readonly>
                          </div>
                      </div>
                      <div class="row">
                          <div class="form-group col-md-6">
                              <strong><label for="Sol">Creada Por</label></strong>
                             <input type="text" class="form-control" id="Sol" readonly>
                          </div>
                      </div>
                      <strong><label for="DFallo">Descripcion del Fallo</label> </strong>
                      <textarea class="form-control" id="DFallo" rows="3" readonly></textarea>
                       <div class="row">
                          <div class="form-group col-md-6">
                            <strong><label for="FechaProm">Fecha Prometida</label> </strong>
                            <input type="date" class="form-control" id="FechaProm" placeholder="Fecha" >
                            <strong><label for="FechaAsigVh" id="lblFechaAsigVh">Fecha Asigna Maq</label> </strong>
                            <input type="date" class="form-control" id="FechaAsigVh" placeholder="Fecha" >
                          </div>
                          <div class="form-group col-md-6">
                            <strong><label for="CboAsigA2" id="CboAsigA22">Asinada A</label></strong>
                             <Select  class="form-select" aria-label="Default select example" id="CboAsigA2" name='CboAsigA2' ></select>
                             <div id="ErrorCboAsigA2" style="color: red"></div>
                             <strong><label for="lstMaqP" id="lstMaqP1">Asignar Maquinaria</label></strong>
                             <Select  class="form-select" Size="4" aria-label="Default select example" id="lstMaqP" name='lstMaqP'></select>
                             <div id="ErrorlstMaqP" style="color: red"></div>
                              <center style="margin-top:5px;">
                                <a type="button" class="btn btn-success btn-sm" id="btnAdd" name='btnAdd' onclick="AbreDlgCatUniMaqP()"><i class="material-icons" style="font-size: 10px;">add</i></a>
                                <a type="button" class="btn btn-danger btn-sm" id="btnDel" name='btnDel' onclick="QuitaUnidad()"><i class="material-icons" style="font-size: 10px;">remove</i></a>
                              </center>
                          </div>
                             <strong><label for="DscAtendido">Descripcion del Atencion</label> </strong>
                              <textarea class="form-control" id="DscAtendido" rows="3" ></textarea>
                              <div id="ErrorDscAtendido" style="color: red"></div>
                      </div><br>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" onclick="closeMd()">Cancelar</button>
                      <button type="button" class="btn btn-light" style="background: #023444;  color:white;" id="cmdGuardar" onclick="drvOperacion()">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal para Terminar una OS -->
            <div class="modal fade" id="frmTerOsG" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terminar OS General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
                  </div>
                  <div class="modal-body">
                      <!-- Acordion para ver el detalle de OS -->
                      <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                  Ver Datos de Creacion de la OS
                                </button>
                              </h2>
                              <div id="flush-collapseOne" class="accordion-collapse collapse shows" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <strong><label for="TipoOSTer">Tipo Orden de Servicio</label></strong>
                                            <input type="text" class="form-control" id="TipoOSTer" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                           <strong><label for="NoOSEd">No. OS</label> </strong>
                                           <input type="text" class="form-control" id="NoOSEd" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                           <strong><label for="FecExpEd">Fecha Exp.</label></strong>
                                           <input type="text" class="form-control" id="FecExpEd" readonly>
                                        </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-md-6">
                                             <strong><label for="UnegEd">Unidad de Negocio</label></strong>
                                            <input type="text" class="form-control" id="UnegEd" readonly>
                                         </div>
                                         <div class="form-group col-md-6">
                                           <strong><label for="AreaEd">Area</label></strong>
                                            <input type="text" class="form-control" id="AreaEd" readonly>
                                         </div>
                                     </div>
                                     <div class="row">
                                         <div class="form-group col-md-6">
                                             <strong><label for="SolEd">Creada Por</label></strong>
                                            <input type="text" class="form-control" id="SolEd" readonly>
                                         </div>
                                     </div>
                                     <strong><label for="DFalloEd">Descripcion del Fallo</label> </strong>
                                     <textarea class="form-control" id="DFalloEd" rows="3" readonly></textarea>

                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                  Ver Datos de Atension de la OS
                                </button>
                              </h2>
                              <div id="flush-collapseTwo" class="accordion-collapse collapse shows" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                          <strong><label for="FechaPromEd">Fecha Prometida</label> </strong>
                                            <input type="text" class="form-control" id="FechaPromEd" readonly>
                                          <strong><label for="FechaAsigVhA" id="lblFechaAsigVhA">Fecha Asigna Maq</label> </strong>
                                             <input type="text" class="form-control" id="FechaAsigVhA" readonly >
                                        </div>
                                        <div class="form-group col-md-6">
                                          <strong><label for="AtendidaPor">Atendida por</label></strong>
                                          <input type="text" class="form-control" id="AtendidaPor" readonly>
                                          <Select  class="form-select" Size="4" aria-label="Default select example" id="lstMaqPAp" name='lstMaqPAp' readonly></select>
                                        </div>
                                           <strong><label for="DscAtendidoEd">Descripcion de la Atencion</label> </strong>
                                            <textarea class="form-control" id="DscAtendidoEd" rows="3" readonly></textarea>
                                    </div>
                                </div>
                              </div>
                            </div>
                      </div>
                       <!-- Terminan los acordiones -->
                       <div class="row">
                          <div class="form-group col-md-6">
                            <strong><label for="FechaTermino">Fecha Termino</label> </strong>
                            <input type="date" class="form-control" id="FechaTermino" placeholder="Fecha" >
                            <div id="ErrorFechaTermino" style="color: red"></div>
                          </div>
                          <strong><label for="DscTermino">Observacion del Trabajo Terminado </label> </strong>
                           <textarea class="form-control" id="DscTermino" rows="3" ></textarea>
                           <div id="ErrorDscTermino" style="color: red"></div>
                       </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" onclick="closeMd()" >Cancelar</button>
                      <button type="button" class="btn btn-light" style="background: #023444; color:white;" id="cmdGuardar" onclick="drvOperacion()">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Aceptar una OS -->
         <div class="modal fade" id="frmAcepOsG" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Aceptar OS General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeMd()"></button>
                  </div>
                  <div class="modal-body">
                      <!-- Acordion para ver el detalle de OS -->
                      <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                  Ver Datos de la OS
                                </button>
                              </h2>
                              <div id="flush-collapseOne" class="accordion-collapse collapse shows" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                        <div class="card">
                                            <h5 class="card-header" id="h5">Orden de Servicio</h5>
                                            <div class="card-body" id ="CuerpoCardT">
                                              <h5 class="card-title">Tienes que seleccionar una OS</h5>
                                              <p class="card-text"></p>
                                            </div>
                                        </div>
                                </div>
                              </div>
                            </div>

                       <!-- Terminan los acordiones -->
                       <br>
                       <div class="row">
                           <div class="form-group col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="TAceptado" checked>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                      Trabajo de la OS Aceptado
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="TnoAceptado" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                      Trabajo de la OS Rechazado
                                    </label>
                                  </div>
                           </div>
                          <strong><label for="DscLiberacion">Observacion del Trabajo Terminado </label> </strong>
                           <textarea class="form-control" id="DscLiberacion" rows="3" ></textarea>
                           <div id="ErrorDscLiberacion" style="color: red"></div>
                       </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" onclick="closeMd()" >Cancelar</button>
                    <button type="button" class="btn btn-light" style="background: #023444;  color:white;" id="cmdGuardarAOS" onclick="drvOperacion()">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
         </div>
            <!-- Fin de Aceptar OS -->
            <!-- Ver os -->
            <div class="modal fade" id="frmVerOsG" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ver OS General</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                  </div>
                  <div class="modal-body">
                      <div class="card">
                        <h5 class="card-header" id="h5t">Featured</h5>
                        <div class="card-body" id ="CuerpoCard">
                          <h5 class="card-title">Tienes que seleccionar una OS</h5>
                          <p class="card-text"></p>
                        </div>
                      </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                  </div>
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
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NO</button>
                  <button type="button" class="btn btn-danger" onclick="DeleteOSG()">SI</button>
                </div>
              </div>
            </div>
        </div>
         <!--Carga cat de unidades -->
        <div class="modal fade" id="LoadCatMaqP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Catalogo de unidades (Maquinaria Pesada)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                  </div>
                  <div class="modal-body">
                          <table id="tblCmp"  class="table table-hover" style="height: 350px;overflow: scroll;">
                               <thead>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-light" style="background: #EDEEF2;" data-bs-dismiss="modal" id="cmdCerrarAOS">Cancelar</button>
                    <button type="button" class="btn btn-light" style="background: #023444;  color:white;" id="cmdGuardarAOS" onclick="SeleccionaUnidades()">Seleccionar</button> 
                  </div>
                </div>
              </div>
            </div>
         </div>
    </body>
    <script src="js/OSGeneral.js" type="text/javascript"></script>
    <style>
      .btn .icon {
    width: 30px;
    bottom: 0;
    background: rgba(0, 0, 0, 0.1);
}
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
    #cmdTerminar{
      border-radius: 10px;
    }
    #cmdAtender{
      border-radius: 10px;
    }
    #cmdLiberar{
      border-radius: 10px;
    }
    #cmdVerOs{
      border-radius: 10px;
    }
    </style>
</html>
