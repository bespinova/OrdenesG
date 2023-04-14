var dato;
var cant;
$(document).ready(function(){
    $('#tblOsOrd tbody').on('click','tr', function(event){
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    ObtenertOsT();
    llenaCboCUneg();
    llenaCboResponsable();
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op){
    opcion = op;
    CodProyecto: document.getElementById('CodProyecto').disabled = false;
    if (opcion == 1) {
      document.getElementById('cmpInversion').value = "";
    }
    if (opcion == 2){
      if (dato.length > 0) {
          UpdateSolicita();
          $('#frmSolicita').modal('show');
          document.getElementById('txtMostrar').innerHTML = "";
      }else {
        document.getElementById('txtMostrar').innerHTML = "";
        $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
        document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-danger" role="alert">
                                      <strong> Seleccione un elemento para editar </strong>
                                      </div>`;
      }
    }
    if (opcion == 3){
      if (dato.length > 0) {
        $("#ModPregSiNo").html("¿Estás seguro de eliminar el <strong>Proyecto "+dato+"</strong>?")
        $('#PreguntaSiNo').modal('show');
      }else {
        document.getElementById('txtMostrar').innerHTML = "";
        $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
        document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-danger" role="alert">
                                      <strong> Seleccione un elemento para eliminar </strong>
                                      </div>`;
      }
    }
}

function drvOperacion(){
  switch(opcion){
    case 1: ActAcciones();break;
    case 2: UpdateCatPr();
    break;
    case 3:
      DeleteCatPr();
      $('#PreguntaSiNo').modal('hide');
      ObtenertOsT();
    break;
  }
}

function ActAcciones(){
  if (ValidaDatos() == 1){
    $('#ErrorCodProyecto').empty();
    $('#CodProyecto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpObs').empty();
    $('#cmpObs').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    $('#ErrorCboSlcte').empty();
    $('#CboSlcte').css("border","1px solid #CED4DA");
    $('#ErrorCboRespnble').empty();
    $('#CboRespnble').css("border","1px solid #CED4DA");
    $('#ErrorFechaIni').empty();
    $('#FechaIni').css("border","1px solid #CED4DA");
    $('#ErrorcmpDuracion').empty();
    $('#cmpDuracion').css("border","1px solid #CED4DA");
    $('#ErrorFechaTerm').empty();
    $('#FechaTerm').css("border","1px solid #CED4DA");
    $('#ErrorcmpInversion').empty();
    $('#cmpInversion').css("border","1px solid #CED4DA");
    axios({
      method:'POST',
      url:'../Ctr/ctrPrCatProyectos.php',
      data: {
        CodProyecto: document.getElementById('CodProyecto').value,
        Nombre: document.getElementById('Nombre').value,
        cmpObs: document.getElementById('cmpObs').value,
        CboUniNeg: document.getElementById('CboUniNeg').value,
        CboAsigAr: document.getElementById('CboAsigAr').value,
        CboSlcte: document.getElementById('CboSlcte').value,
        CboRespnble: document.getElementById('CboRespnble').value,
        FechaIni: document.getElementById('FechaIni').value,
        cmpDuracion: document.getElementById('cmpDuracion').value,
        FechaTerm: document.getElementById('FechaTerm').value,
        cmpInversion: document.getElementById('cmpInversion').value = cant
      }
    }).then(res=>{
        console.log(res.data);
          ObtenertOsT();
        $('#frmSolicita').modal('hide');
        document.getElementById('CodProyecto').value = "";
       document.getElementById('Nombre').value = "";
        document.getElementById('cmpObs').value = "";
        document.getElementById('CboUniNeg').value = "";
        document.getElementById('CboAsigAr').value = "";
        document.getElementById('CboSlcte').value = "";
        document.getElementById('CboRespnble').value = "";
        document.getElementById('FechaIni').value = "";
        document.getElementById('cmpDuracion').value = "";
        document.getElementById('FechaTerm').value = "";
        document.getElementById('cmpInversion').value = "";
    }).catch (error=>{
        console.error(error);
    });
  }else{
    $('#ErrorCodProyecto').empty();
    $('#CodProyecto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpObs').empty();
    $('#cmpObs').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    $('#ErrorCboSlcte').empty();
    $('#CboSlcte').css("border","1px solid #CED4DA");
    $('#ErrorCboRespnble').empty();
    $('#CboRespnble').css("border","1px solid #CED4DA");
    $('#ErrorFechaIni').empty();
    $('#FechaIni').css("border","1px solid #CED4DA");
    $('#ErrorcmpDuracion').empty();
    $('#cmpDuracion').css("border","1px solid #CED4DA");
    $('#ErrorFechaTerm').empty();
    $('#FechaTerm').css("border","1px solid #CED4DA");
    $('#ErrorcmpInversion').empty();
    $('#cmpInversion').css("border","1px solid #CED4DA");
    if (document.getElementById('CodProyecto').value.length == 0){
      document.getElementById('ErrorCodProyecto').innerHTML = "";
      $('#CodProyecto').css("border","2px solid red");
      document.getElementById('ErrorCodProyecto').innerHTML += `${strRsp}`;
    }
    if (document.getElementById('Nombre').value.length == 0){
      document.getElementById('ErrorNombre').innerHTML = "";
      $('#Nombre').css("border","2px solid red");
      document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('cmpObs').value.length == 0){
      document.getElementById('ErrorcmpObs').innerHTML = "";
      $('#cmpObs').css("border","2px solid red");
      document.getElementById('ErrorcmpObs').innerHTML += `${strRsp3}`;
    }
    if (document.getElementById('CboUniNeg').value.length == 0){
      document.getElementById('ErrorCboUniNeg').innerHTML = "";
      $('#CboUniNeg').css("border","2px solid red");
      document.getElementById('ErrorCboUniNeg').innerHTML += `${strRsp4}`;
    }
    if (document.getElementById('CboAsigAr').value.length == 0){
      document.getElementById('ErrorCboAsigAr').innerHTML = "";
      $('#CboAsigAr').css("border","2px solid red");
      document.getElementById('ErrorCboAsigAr').innerHTML += `${strRsp5}`;
    }
    if (document.getElementById('CboSlcte').value.length == 0){
      document.getElementById('ErrorCboSlcte').innerHTML = "";
      $('#CboSlcte').css("border","2px solid red");
      document.getElementById('ErrorCboSlcte').innerHTML += `${strRsp6}`;
    }
    if (document.getElementById('CboRespnble').value.length == 0){
      document.getElementById('ErrorCboRespnble').innerHTML = "";
      $('#CboRespnble').css("border","2px solid red");
      document.getElementById('ErrorCboRespnble').innerHTML += `${strRsp7}`;
    }
    if (document.getElementById('FechaIni').value.length == 0){
      document.getElementById('ErrorFechaIni').innerHTML = "";
      $('#FechaIni').css("border","2px solid red");
      document.getElementById('ErrorFechaIni').innerHTML += `${strRsp8}`;
    }
    if (document.getElementById('cmpDuracion').value.length == 0){
      document.getElementById('ErrorcmpDuracion').innerHTML = "";
      $('#cmpDuracion').css("border","2px solid red");
      document.getElementById('ErrorcmpDuracion').innerHTML += `${strRsp9}`;
    }
    if (document.getElementById('FechaTerm').value.length == 0){
      document.getElementById('ErrorFechaTerm').innerHTML = "";
      $('#FechaTerm').css("border","2px solid red");
      document.getElementById('ErrorFechaTerm').innerHTML += `${strRsp10}`;
    }
    if (document.getElementById('cmpInversion').value.length == 0){
      document.getElementById('ErrorcmpInversion').innerHTML = "";
      $('#cmpInversion').css("border","2px solid red");
      document.getElementById('ErrorcmpInversion').innerHTML += `${strRsp11}`;
    }
  }
}

function DeleteCatPr(){
  axios({
    method:'DELETE',
    url:'../Ctr/ctrPrCatProyectos.php?CodSolcte='+dato,
    responseType:'json'
    }).then(res=>{
      console.log(res.data);
      ObtenertOsT();
    }).catch (error=>{
      console.error(error);
  });
}

function ObtenerSeguridad(){
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?CodPantalla=P004',// verificar que numero de pantalla será
    responseType:'json'
  }).then(res=>{
    this.uneg = res.data;
    document.getElementById('cmdAgregar').disabled = (uneg[0][0].Acceso == 1)?false:true;
    document.getElementById('cmdEditar').disabled  = (uneg[1][0].Acceso == 1)?false:true;
    document.getElementById('cmdEliminar').disabled = (uneg[2][0].Acceso == 1)?false:true;
  }).catch (error=>{
    console.error(error);
  });
}

function sumaFecha(){
  if (parseInt(document.getElementById('cmpDuracion').value)){
    var enteroTruncado = Math.trunc(document.getElementById('cmpDuracion').value);
    document.getElementById('cmpDuracion').value = enteroTruncado;

    var varDuracionMes = document.getElementById('cmpDuracion').value;
    var fechaIni = document.getElementById('FechaIni').value;

    var fechaSplit= fechaIni.split('-');
    var nueva_fecha = new Date(fechaSplit[2], fechaSplit[1], fechaSplit[0]);

    var fechaConMes = parseInt(fechaSplit[1]) + parseInt(varDuracionMes);

    var dia =fechaSplit[2];
    var mes =fechaSplit[1];
    var anio = fechaSplit[0];

    if (fechaConMes > 12) {
      var residuoMenor = parseInt(fechaConMes) % 12;
      var cocienteMenor = parseInt(fechaConMes) / 12;
      var cocienteEntero = Math.trunc(cocienteMenor);

      if (residuoMenor == 0) {
        cocienteMenor =  cocienteEntero - parseInt(1);
        var anioPosterior = parseInt(anio) + parseInt(cocienteMenor);
        document.getElementById('FechaTerm').value=anioPosterior+"-12-"+dia;
      }else {
        var sumaAnio = parseInt(anio) + parseInt(cocienteEntero);
        if (residuoMenor < 10) {
          residuoMenor = '0'+residuoMenor;
        }
        document.getElementById('FechaTerm').value=sumaAnio+"-"+residuoMenor+"-"+dia;
      }
    }
    else {
      var sumar = parseInt(fechaSplit[1]) + parseInt(varDuracionMes);
      document.getElementById('FechaTerm').value= anio+"-"+sumar+"-"+dia;
    }
  }else {
    document.getElementById('cmpDuracion').value = 0;
  }
}

function poneComas(valor){
  if (valor == null) {
    var ctrInv = document.getElementById('cmpInversion').value;
    var sPunto = ctrInv.toString().split(".");
    sPunto[0] = sPunto[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    var sComaConjunta = sPunto.join(".");

    cant = document.getElementById('cmpInversion').value;
    document.getElementById('cmpInversion').value = sComaConjunta;

    return sComaConjunta;
  }else {
    var ctrInv = valor;
    var sPunto = ctrInv.toString().split(".");
    sPunto[0] = sPunto[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    var sComaConjunta = sPunto.join(".");

    cant = document.getElementById('cmpInversion').value;
    document.getElementById('cmpInversion').value = sComaConjunta;

    return sComaConjunta;
  }
}

function UpdateSolicita(){
  $('#ErrorCodProyecto').empty();
  $('#CodProyecto').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErrorcmpObs').empty();
  $('#cmpObs').css("border","1px solid #CED4DA");
  $('#ErrorCboUniNeg').empty();
  $('#CboUniNeg').css("border","1px solid #CED4DA");
  $('#ErrorCboAsigAr').empty();
  $('#CboAsigAr').css("border","1px solid #CED4DA");
  $('#ErrorCboSlcte').empty();
  $('#CboSlcte').css("border","1px solid #CED4DA");
  $('#ErrorCboRespnble').empty();
  $('#CboRespnble').css("border","1px solid #CED4DA");
  $('#ErrorFechaIni').empty();
  $('#FechaIni').css("border","1px solid #CED4DA");
  $('#ErrorcmpDuracion').empty();
  $('#cmpDuracion').css("border","1px solid #CED4DA");
  $('#ErrorFechaTerm').empty();
  $('#FechaTerm').css("border","1px solid #CED4DA");
  $('#ErrorcmpInversion').empty();
  $('#cmpInversion').css("border","1px solid #CED4DA");
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?varCod='+dato,
    responseType:'json'
  }).then(res=>{
    this.osOrd = res.data;
    document.getElementById('CodProyecto').value = this.osOrd[0][0].CodProyecto;
    document.getElementById('Nombre').value  = this.osOrd[0][0].Nombre;
    document.getElementById('cmpObs').value  = this.osOrd[0][0].Observacion;
    document.getElementById('CboUniNeg').value  = this.osOrd[0][0].CodUNegocio;
    //document.getElementById('CboAsigAr').value  = this.osOrd[0][0].CodArea;
    var cboArea = this.osOrd[0][0].CodArea;
    //document.getElementById('CboSlcte').value  = this.osOrd[0][0].CodSolicitante;
    var cboSolcte = this.osOrd[0][0].CodSolicitante;
    document.getElementById('CboRespnble').value  = this.osOrd[0][0].CodResponsable;
    document.getElementById('FechaIni').value  = this.osOrd[0][0].FechaInicio.date.substring(0,10);
    document.getElementById('cmpDuracion').value  = this.osOrd[0][0].MesesDuracion;
    document.getElementById('FechaTerm').value  = this.osOrd[0][0].FechaEntrega.date.substring(0,10);
    document.getElementById('cmpInversion').value  = this.osOrd[0][0].Presupuesto;
    llenaCboArea(document.getElementById('CboUniNeg').value,cboArea);
    llenaCboSolicitante(document.getElementById('CboUniNeg').value,cboSolcte);
    cant = this.osOrd[0][0].Presupuesto;
    document.getElementById('CodProyecto').disabled =true;
  }).catch (error=>{
      console.error(error);
  });
}

function UpdateCatPr(){
  if (ValidaDatos() == 1) {
    $('#ErrorCodProyecto').empty();
    $('#CodProyecto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpObs').empty();
    $('#cmpObs').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    $('#ErrorCboSlcte').empty();
    $('#CboSlcte').css("border","1px solid #CED4DA");
    $('#ErrorCboRespnble').empty();
    $('#CboRespnble').css("border","1px solid #CED4DA");
    $('#ErrorFechaIni').empty();
    $('#FechaIni').css("border","1px solid #CED4DA");
    $('#ErrorcmpDuracion').empty();
    $('#cmpDuracion').css("border","1px solid #CED4DA");
    $('#ErrorFechaTerm').empty();
    $('#FechaTerm').css("border","1px solid #CED4DA");
    $('#ErrorcmpInversion').empty();
    $('#cmpInversion').css("border","1px solid #CED4DA");
    axios({
      method:'PUT',
      url:'../Ctr/ctrPrCatProyectos.php',
      data: {
        CodProyecto: document.getElementById('CodProyecto').value,
        Nombre: document.getElementById('Nombre').value,
        cmpObs: document.getElementById('cmpObs').value,
        CboUniNeg: document.getElementById('CboUniNeg').value,
        CboAsigAr: document.getElementById('CboAsigAr').value,
        CboSlcte: document.getElementById('CboSlcte').value,
        CboRespnble: document.getElementById('CboRespnble').value,
        //FechaAlta: document.getElementById('').value,
        FechaIni: document.getElementById('FechaIni').value,
        cmpDuracion: document.getElementById('cmpDuracion').value,
        FechaTerm: document.getElementById('FechaTerm').value,
        //PorcentTerminado: document.getElementById('').value,
        cmpInversion: document.getElementById('cmpInversion').value = cant
      }
    }).then(res=>{
      console.log(res.data);
      ObtenertOsT();
      $('#frmSolicita').modal('hide');
      document.getElementById('CodProyecto').value = "";
      document.getElementById('Nombre').value = "";
       document.getElementById('cmpObs').value = "";
       document.getElementById('CboUniNeg').value = "";
       document.getElementById('CboAsigAr').value = "";
       document.getElementById('CboSlcte').value = "";
       document.getElementById('CboRespnble').value = "";
       document.getElementById('FechaIni').value = "";
       document.getElementById('cmpDuracion').value = "";
       document.getElementById('FechaTerm').value = "";
       document.getElementById('cmpInversion').value = "";
    }).catch (error=>{
      console.error(error);
    });
  }else {
    $('#ErrorCodProyecto').empty();
    $('#CodProyecto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpObs').empty();
    $('#cmpObs').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    $('#ErrorCboSlcte').empty();
    $('#CboSlcte').css("border","1px solid #CED4DA");
    $('#ErrorCboRespnble').empty();
    $('#CboRespnble').css("border","1px solid #CED4DA");
    $('#ErrorFechaIni').empty();
    $('#FechaIni').css("border","1px solid #CED4DA");
    $('#ErrorcmpDuracion').empty();
    $('#cmpDuracion').css("border","1px solid #CED4DA");
    $('#ErrorFechaTerm').empty();
    $('#FechaTerm').css("border","1px solid #CED4DA");
    $('#ErrorcmpInversion').empty();
    $('#cmpInversion').css("border","1px solid #CED4DA");
    if (document.getElementById('CodProyecto').value.length == 0){
      document.getElementById('ErrorCodProyecto').innerHTML = "";
      $('#CodProyecto').css("border","2px solid red");
      document.getElementById('ErrorCodProyecto').innerHTML += `${strRsp}`;
    }
    if (document.getElementById('Nombre').value.length == 0){
      document.getElementById('ErrorNombre').innerHTML = "";
      $('#Nombre').css("border","2px solid red");
      document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('cmpObs').value.length == 0){
      document.getElementById('ErrorcmpObs').innerHTML = "";
      $('#cmpObs').css("border","2px solid red");
      document.getElementById('ErrorcmpObs').innerHTML += `${strRsp3}`;
    }
    if (document.getElementById('CboUniNeg').value.length == 0){
      document.getElementById('ErrorCboUniNeg').innerHTML = "";
      $('#CboUniNeg').css("border","2px solid red");
      document.getElementById('ErrorCboUniNeg').innerHTML += `${strRsp4}`;
    }
    if (document.getElementById('CboAsigAr').value.length == 0){
      document.getElementById('ErrorCboAsigAr').innerHTML = "";
      $('#CboAsigAr').css("border","2px solid red");
      document.getElementById('ErrorCboAsigAr').innerHTML += `${strRsp5}`;
    }
    if (document.getElementById('CboSlcte').value.length == 0){
      document.getElementById('ErrorCboSlcte').innerHTML = "";
      $('#CboSlcte').css("border","2px solid red");
      document.getElementById('ErrorCboSlcte').innerHTML += `${strRsp6}`;
    }
    if (document.getElementById('CboRespnble').value.length == 0){
      document.getElementById('ErrorCboRespnble').innerHTML = "";
      $('#CboRespnble').css("border","2px solid red");
      document.getElementById('ErrorCboRespnble').innerHTML += `${strRsp7}`;
    }
    if (document.getElementById('FechaIni').value.length == 0){
      document.getElementById('ErrorFechaIni').innerHTML = "";
      $('#FechaIni').css("border","2px solid red");
      document.getElementById('ErrorFechaIni').innerHTML += `${strRsp8}`;
    }
    if (document.getElementById('cmpDuracion').value.length == 0){
      document.getElementById('ErrorcmpDuracion').innerHTML = "";
      $('#cmpDuracion').css("border","2px solid red");
      document.getElementById('ErrorcmpDuracion').innerHTML += `${strRsp9}`;
    }
    if (document.getElementById('FechaTerm').value.length == 0){
      document.getElementById('ErrorFechaTerm').innerHTML = "";
      $('#FechaTerm').css("border","2px solid red");
      document.getElementById('ErrorFechaTerm').innerHTML += `${strRsp10}`;
    }
    if (document.getElementById('cmpInversion').value.length == 0){
      document.getElementById('ErrorcmpInversion').innerHTML = "";
      $('#cmpInversion').css("border","2px solid red");
      document.getElementById('ErrorcmpInversion').innerHTML += `${strRsp11}`;
    }
  }
}

function closeMd(){
  $('#ErrorCodProyecto').empty();
  $('#CodProyecto').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErrorcmpObs').empty();
  $('#cmpObs').css("border","1px solid #CED4DA");
  $('#ErrorCboUniNeg').empty();
  $('#CboUniNeg').css("border","1px solid #CED4DA");
  $('#ErrorCboAsigAr').empty();
  $('#CboAsigAr').css("border","1px solid #CED4DA");
  $('#ErrorCboSlcte').empty();
  $('#CboSlcte').css("border","1px solid #CED4DA");
  $('#ErrorCboRespnble').empty();
  $('#CboRespnble').css("border","1px solid #CED4DA");
  $('#ErrorFechaIni').empty();
  $('#FechaIni').css("border","1px solid #CED4DA");
  $('#ErrorcmpDuracion').empty();
  $('#cmpDuracion').css("border","1px solid #CED4DA");
  $('#ErrorFechaTerm').empty();
  $('#FechaTerm').css("border","1px solid #CED4DA");
  $('#ErrorcmpInversion').empty();
  $('#cmpInversion').css("border","1px solid #CED4DA");
  document.getElementById('CodProyecto').value = "";
 document.getElementById('Nombre').value = "";
  document.getElementById('cmpObs').value = "";
  document.getElementById('CboUniNeg').value = "";
  document.getElementById('CboAsigAr').value = "";
  document.getElementById('CboSlcte').value = "";
  document.getElementById('CboRespnble').value = "";
  document.getElementById('FechaIni').value = "";
  document.getElementById('cmpDuracion').value = "";
  document.getElementById('FechaTerm').value = "";
  document.getElementById('cmpInversion').value = "";
  ObtenertOsT()
}

function ObtenertOsT(){
  dato = "";
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php',
    responseType:'json'
  }).then(res=>{
    console.log(res.data);
    this.osOrd = res.data;
    llenarTabla();
  }).catch (error=>{
    console.error(error);
  });
}

function opcBusqueda(){
  varBsq = document.getElementById('IdBuscar').value;
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?cmpBusc='+varBsq,
    responseType:'json'
  }).then(res=>{
    if (isObject(res.data)) {
      this.osOrd = res.data;
      llenarTabla();
    }else {
      document.getElementById('txtMostrar').innerHTML = "";
      $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
      document.getElementById('txtMostrar').innerHTML += `
                                  <div class="alert alert-warning" role="alert">
                                  <strong>!Alerta¡</strong>${res.data}
                                  </div>`;
    }
  }).catch (error=>{
    console.error(error);
  });
}

function isObject(val){
  if (val === null){
    return false;
  }
  return ( (typeof val === 'function') || (typeof val === 'object'));
}

function llenarTabla(){
  $("#tblOsOrd tr").remove();
  document.querySelector('#tblOsOrd thead').innerHTML +=
  `<tr>
    <th>Proyecto</th>
    <th style="width: 132px;">Nombre</th>
    <th style="width: 132px;">Unidad Negocio</th>
    <th style="width: 132px;">Area</th>
    <th style="width: 120px;">Solicitante</th>
    <th style="width: 120px;">Responsable</th>
    <th>Fecha de Inicio</th>
    <th>Duracion</th>
    <th>Fecha de Entrega</th>
    <th>Avance</th>
    <th style="width: 140px;">Presupuesto</th>
  </tr>`;
  for(let i=0; i <osOrd.length; i++){
    document.querySelector('#tblOsOrd tbody').innerHTML +=
    `<tr>
      <td>${osOrd[i][0].CodProyecto}</td>
      <td style="width: 132px;">${osOrd[i][0].Nombre}</td>
      <td style="width: 132px;">${osOrd[i][0].NombreUNegocio}</td>
      <td style="width: 132px;">${osOrd[i][0].NombreArea}</td>
      <td style="width: 120px;">${osOrd[i][0].NombreSolicitante}</td>
      <td style="width: 120px;">${osOrd[i][0].NombreResponsable}</td>
      <td >${osOrd[i][0].FechaInicio.date.substring(0,10)}</td>
      <td>${osOrd[i][0].MesesDuracion}(meses)</td>
      <td>${osOrd[i][0].FechaEntrega.date.substring(0,10)}</td>
      <td>${osOrd[i][0].PorTerminado}</td>
      <td style="width: 140px;">$ ${poneComas(osOrd[i][0].Presupuesto)}</td>
    </tr>`;
  }
}

function llenaCboCUneg(){
  dato = "";
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?op=1&codUNe=1',
    responseType:'json'
  }).then(res=>{
    this.osOrd = res.data;
    document.querySelector('#CboUniNeg').innerHTML += `<option selected></option>`;
    for(let i=0; i <osOrd.length; i++){
      document.querySelector('#CboUniNeg').innerHTML +=
      `<option value="${osOrd[i][0].CodUNegocio}">${osOrd[i][0].Nombre}</option>`;
    }
  }).catch (error=>{
      console.error(error);
  });
}

function llenaCboArea(varData,opcion){
  dato = "";
  axios({
      method:'GET',
      url:'../Ctr/ctrPrCatProyectos.php?op=2&codArea=2&vardata='+varData,
      responseType:'json'
  }).then(res=>{
    this.osOrd = res.data;
    if (opcion == 0) {
      document.querySelector('#CboAsigAr').innerHTML = '';
      document.querySelector('#CboAsigAr').innerHTML += `<option selected></option>`;
      for(let i=0; i < osOrd.length; i++)
            document.querySelector('#CboAsigAr').innerHTML +=
              `<option value="${osOrd[i][0].CodArea}">${osOrd[i][0].Nombre}</option>`;
    }else {
      document.querySelector('#CboAsigAr').innerHTML = '';
      document.querySelector('#CboAsigAr').innerHTML += `<option selected></option>`;
      for(let i=0; i < osOrd.length; i++){
        document.querySelector('#CboAsigAr').innerHTML +=
          `<option value="${osOrd[i][0].CodArea}">${osOrd[i][0].Nombre}</option>`;
          document.getElementById('CboAsigAr').value = opcion;
      }
    }


  }).catch (error=>{
      console.error(error);
  });
}

function llenaCboSolicitante(valor,opcion){
  dato = "";
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?op=3&varSolcte=2&vardato='+valor,
    responseType:'json'
  }).then(res=>{
    this.uneg = res.data;
    if (opcion==0) {
      document.querySelector('#CboSlcte').innerHTML = '';
      document.querySelector('#CboSlcte').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++)
        document.querySelector('#CboSlcte').innerHTML +=
        `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
    }else {
      document.querySelector('#CboSlcte').innerHTML = '';
      document.querySelector('#CboSlcte').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++){
        document.querySelector('#CboSlcte').innerHTML +=
        `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
        document.getElementById('CboSlcte').value = opcion;
      }
    }
  }).catch (error=>{
    console.error(error);
  });
}

function cmbUnidadN(){
  llenaCboArea(document.getElementById('CboUniNeg').value,0);
  llenaCboSolicitante(document.getElementById('CboUniNeg').value,0);
  //ObtenertOsT2();
}

function llenaCboResponsable(){
  dato = "";
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php?op=4&rspnsble=3',
    responseType:'json'
  }).then(res=>{
    console.log(res.data);
    this.uneg = res.data;
    document.querySelector('#CboRespnble').innerHTML += `<option selected></option>`;
    for(let i=0; i < uneg.length; i++)
      document.querySelector('#CboRespnble').innerHTML +=
      `<option value="${uneg[i][0].CodResponsable}">${uneg[i][0].Nombre}</option>`;
  }).catch (error=>{
    console.error(error);
  });
}

function ObtenertOsT2(){
  dato = "";
  axios({
    method:'GET',
    url:'../Ctr/ctrPrCatProyectos.php',
    responseType:'json'
  }).then(res=>{
    console.log(res.data);
    this.osOrd = res.data;
    llenarTabla2();
  }).catch (error=>{
    console.error(error);
  });
}

function llenarTabla2(){
  $("#tblOsOrd tr").remove();
  document.querySelector('#tblOsOrd thead').innerHTML +=
    `<tr>
      <th>Proyecto</th>
      <th>Nombre</th>
      <th>Unidad Negocio</th>
      <th>Area</th>
      <th>Solicitante</th>
      <th>Responsable</th>
      <th>Fecha de Inicio</th>
      <th>Duracion</th>
      <th>Fecha de Entrega</th>
      <th>Avance</th>
      <th>Presupuesto</th>
    </tr>`;
    for(let i=0; i <osOrd.length; i++){
      document.querySelector('#tblOsOrd tbody').innerHTML +=
      `<tr>
        <td>${osOrd[i][0].CodProyecto}</td>
        <td>${osOrd[i][0].Nombre}</td>

        <td>${osOrd[i][0].NombreUNegocio}</td>
        <td>${osOrd[i][0].NombreArea}</td>
        <td>${osOrd[i][0].NombreSolicitante}</td>
        <td>${osOrd[i][0].NombreResponsable}</td>

        <td >${osOrd[i][0].FechaInicio.date.substring(0,10)}</td>
        <td>${osOrd[i][0].MesesDuracion}(meses)</td>
        <td>${osOrd[i][0].FechaEntrega.date.substring(0,10)}</td>
        <td>${osOrd[i][0].PorTerminado}</td>
        <td>$ ${osOrd[i][0].Presupuesto}</td>
      </tr>`;
  }
}

function ValidaDatos(){
  var dv = 1;
  strRsp = "";
  strRsp2 = "";
  strRsp3 = "";
  strRsp4 = "";
  strRsp5 = "";
  strRsp6 = "";
  strRsp7 = "";
  strRsp8 = "";
  strRsp9 = "";
  strRsp10 = "";
  strRsp11 = "";
  if (document.getElementById('CodProyecto').value.length == 0){
        strRsp += 'Capture el código del proyecto.';
        dv = 0;
  }
  if (document.getElementById('Nombre').value.length == 0){
      strRsp2 += 'Capture el nombre del proyecto.';
      dv = 0;
  }
  if (document.getElementById('cmpObs').value.length == 0){
      strRsp3 += 'Capture la observacion del proyecto.';
      dv = 0;
  }
  if (document.getElementById('CboUniNeg').value.length == 0){
      strRsp4 += 'Seleccione una unidad de negocio válida.';
      dv = 0;
  }
  if (document.getElementById('CboAsigAr').value.length == 0){
      strRsp5 += 'Seleccione un área válida.';
      dv = 0;
  }
  if (document.getElementById('CboSlcte').value.length == 0){
      strRsp6 += 'Seleccione un solicitante válido.';
      dv = 0;
  }
  if (document.getElementById('CboRespnble').value.length == 0){
      strRsp7 += 'Seleccione un responsable válido.';
      dv = 0;
  }
  if (document.getElementById('FechaIni').value.length == 0){
      strRsp8 += 'Seleccione una fecha de inicio.';
      dv = 0;
  }
  if (document.getElementById('cmpDuracion').value.length == 0){
      strRsp9 += 'Capture la duración del proyecto.';
      dv = 0;
  }
  if (document.getElementById('FechaTerm').value.length == 0){
      strRsp10 += 'Seleccione una fecha de término.';
      dv = 0;
  }
  if (document.getElementById('cmpInversion').value.length == 0){
      strRsp11 += 'Capture el presupuesto del proyecto.';
      dv = 0;
  }
  return dv;
}