var dato;
$(document).ready(function(){//cuando este lista la página
    $('#tblOsOrd tbody').on('click','tr', function(event){
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    ObtenertUsr();
    llenaCboPerfil();
    //llenaCboSolicitante();
    //llenaCboGte(0);

    var  elementSolicita = document.getElementById("elementSolicita");
    var elementGte = document.getElementById("elementGte");
    var checkSol = document.getElementById("chkSolicita");
    var checkGte = document.getElementById("chkGte");

      elementSolicita.style.display='none';
      elementGte.style.display='none';
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op)
{
    opcion = op;
     document.getElementById('idUser').disabled = false;
     document.getElementById('Nombre').disabled = false;
     document.getElementById('CboPerfil').disabled = false;
     document.getElementById('idPassword').style.display = 'block';
     document.getElementById('idPassword2').style.display = 'block';
    if (opcion == 2){
      if (dato.length > 0) {
        updateCatUsr1();
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
        $("#ModPregSiNo").html("¿Estás seguro de eliminar al <strong>Usuario "+dato+"</strong>?")
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


function closeMd()
{
  $('#ErroridUser').empty();
  $('#idUser').css("border","1px solid #CED4DA");
  $('#ErroridPassword2').empty();
  $('#idPassword2').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErroridPassword').empty();
  $('#idPassword').css("border","1px solid #CED4DA");
  $('#ErrorCboPerfil').empty();
  $('#CboPerfil').css("border","1px solid #CED4DA");
  $('#ErrorCboSolicitante').empty();
  $('#CboSolicitante').css("border","1px solid #CED4DA");
  $('#ErrorCboGte').empty();
  $('#CboGte').css("border","1px solid #CED4DA");
   document.getElementById('idUser').disabled = false;
   document.getElementById('idUser').value = "";
   document.getElementById('Nombre').value = "";
   document.getElementById('CboPerfil').value = "";
   document.getElementById('CboSolicitante').value = "";
   document.getElementById('CboGte').value = "";
   document.getElementById('idPassword').value = "";
   document.getElementById('idPassword2').value = "";
   elementSolicita.style.display='none';
   elementGte.style.display='none';
   ObtenertUsr();
}


function drvOperacion()
{
    switch(opcion)
    {
        case 1: ActAcciones(); break;
        case 2: updateCatUsr();
         break;
        case 3:
              DeleteCatUsr();
              $('#PreguntaSiNo').modal('hide');
              ObtenertUsr();
         break;
    }
    document.getElementById('idUser').value = "",
    document.getElementById('Nombre').value ="",
    document.getElementById('idPassword').value ="",
    document.getElementById('idPassword2').value = "";
    document.getElementById('CboPerfil').value = "";
    document.getElementById('CboSolicitante').value = "";
    document.getElementById('CboGte').value = "";
}

function busquedUsr(){
  varBsq = document.getElementById('IdBuscar').value;
  axios({
      method:'GET',
      url:'../Ctr/ctrCatUsuario.php?cmpBusc='+varBsq,
      responseType:'json'
  }).then(res=>{
      console.log(res.data);
        if(isObject(res.data)){
          this.uneg = res.data;
          llenarTabla();
        }else {
          document.getElementById('txtMostrar').innerHTML = "";
          $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
          document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-warning" role="alert">
                                      <strong> ! Alerta ¡ </strong>${res.data}
                                      </div>`;
        }
  }).catch (error=>{
      console.error(error);
  });
}

function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatUsuario.php?CodPantalla=P006',
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

function isObject(val)
 {
    if (val === null)
    {
        return false;
    }
      return ( (typeof val === 'function') || (typeof val === 'object'));
  }

// TODO: validacion para valores nullos en la tabla
function ObtenertUsr(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatUsuario.php',
        responseType:'json'
    }).then(res=>{
      console.log(res.data);
      if (isObject(res.data)) {
        this.uneg = res.data;
        llenarTabla();
      }else {
        document.getElementById('tblOsOrd').innerHTML = '';
        document.getElementById('tblOsOrd').innerHTML +=
        `<thead  class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Perfil</th>
                <th>Solicitante</th>
                <th>Gerente</th>
            </tr>
        </thead>`
        document.getElementById('tblOsOrd').innerHTML +=
          `<tr>
                  <td>NO HAY REGISTROS</td>
                  <td>NO HAY REGISTROS</td>
                  <td>NO HAY REGISTROS</td>
                  <td>NO HAY REGISTROS</td>
                  <td>NO HAY REGISTROS</td>
           </tr>`;
      }
    }).catch (error=>{
        console.error(error);
    });
}

function DeleteCatUsr()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatUsuario.php?CodUsr='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
        }).catch (error=>{
            console.error(error);
    });
}

function updateCatUsr1()
{
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErrorCboPerfil').empty();
  $('#CboPerfil').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatUsuario.php?varUser='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('idUser').value = this.uneg[0][0].Usuario;
            document.getElementById('Nombre').value = this.uneg[0][0].Nombre;
            document.getElementById('CboPerfil').value = this.uneg[0][0].CodPerfil;
            document.getElementById('CboSolicitante').value = this.uneg[0][0].CodSolicitante;
            document.getElementById('CboGte').value = this.uneg[0][0].CodGteMatto;
            document.getElementById('idUser').disabled =true;
            document.getElementById('idPassword').style.display = 'none';
            document.getElementById('idPassword2').style.display = 'none';
			
			muestraPerfil(this.uneg[0][0].CodPerfil,this.uneg[0][0].CodSolicitante,this.uneg[0][0].CodGteMatto);
        }).catch (error=>{
            console.error(error);
    });
}

function muestraPerfil(perfil,CodSolicitante,CodGteMtto){
  var x = perfil;
  switch (x) {
    case 'Admin':
      elementGte.style.display='none';
      elementSolicita.style.display='none';
    break;
    case 'Sist':
      elementGte.style.display='none';
      elementSolicita.style.display='none';
    break;
    case 'Capturista':
      llenaCboGte(CodGteMtto);
      document.getElementById('elementGte').value = "";
      elementGte.style.display='block';
      elementSolicita.style.display='none';
    break;
    case 'GteMatto':
      llenaCboGte(CodGteMtto);
      document.getElementById("elementGte").value = "";
      elementGte.style.display='block';
      elementSolicita.style.display='none';
    break;
    case 'JefeArea':
      llenaCboSolicitante(CodSolicitante);
      document.getElementById('elementSolicita').value = "";
      elementSolicita.style.display='block';
      elementGte.style.display='none';
    break;
    default:
      console.log("No hay ningún valor seleccionado en el combo");
    }
}

function llenarTabla()
{
    $("#tblOsOrd tr").remove();
    document.querySelector('#tblOsOrd thead').innerHTML +=
        `<tr>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Perfil</th>
            <th>Solicitante</th>
            <th>Gerente</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblOsOrd tbody').innerHTML +=
        `<tr>
                <td>${uneg[i][0].Usuario}</td>
                <td>${uneg[i][0].NombreUsuario}</td>
                <td>${uneg[i][0].CodPerfil}</td>
                <td>${(uneg[i][0].NombreSolicitante == null)? '' :uneg[i][0].NombreSolicitante}</td>
                <td>${(uneg[i][0].NombreGte == null)? '' : uneg[i][0].NombreGte}</td>
         </tr>`;
    }
}

function llenaCboPerfil(){
  dato = "";
  axios({
      method:'GET',
      url:'../Ctr/ctrCatUsuario.php?op=1&varPerf=1',
      responseType:'json'
  }).then(res=>{
    console.log(res.data);
      this.uneg = res.data;
      document.querySelector('#CboPerfil').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++)
           document.querySelector('#CboPerfil').innerHTML +=
             `<option value="${uneg[i][0].CodPerfil}">${uneg[i][0].Descripcion}</option>`;
  }).catch (error=>{
      console.error(error);
  });
}

function llenaCboSolicitante(valor){
  var ruta;
  var arrayItems = [];
  ruta = '../Ctr/ctrCatUsuario.php?op=1&varSolcte=2';
  dato = "";
  axios({
      method:'GET',
      url: ruta,
      responseType:'json'
  }).then(res=>{
    this.uneg = res.data;
    if (valor == 0) {
      document.querySelector('#CboSolicitante').innerHTML = '';
      document.querySelector('#CboSolicitante').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++){
        document.querySelector('#CboSolicitante').innerHTML +=
          `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
      }
    }else {
      document.querySelector('#CboSolicitante').innerHTML = '';
      document.querySelector('#CboSolicitante').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++){
        document.querySelector('#CboSolicitante').innerHTML +=
          `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
          arrayItems.push(uneg[i][0].CodSolicitante);
    }
    for (n in arrayItems) {
        var sctItem = arrayItems[n].trim();
        var prmVari = valor.trim();
        if (sctItem == prmVari) {
          document.getElementById('CboSolicitante').value = sctItem;
        }
    }
  }
  }).catch (error=>{
      console.error(error);
  });
}
/*
function llenaCboSolicitante(){
  dato = "";
  axios({
      method:'GET',
      url:'../Ctr/ctrCatUsuario.php?op=1&varSolcte=2',
      responseType:'json'
  }).then(res=>{
    console.log(res.data);
      this.uneg = res.data;
      document.querySelector('#CboSolicitante').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++)
           document.querySelector('#CboSolicitante').innerHTML +=
             `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;

  }).catch (error=>{
      console.error(error);
  });
}*/
/*
function llenaCboGte(valor){
  dato = "";
  axios({
      method:'GET',
      url:'../Ctr/ctrCatUsuario.php?opc=1&varGte=3',
      responseType:'json'
  }).then(res=>{
      console.log(res.data);
      this.uneg = res.data;
      document.querySelector('#CboGte').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++)
           document.querySelector('#CboGte').innerHTML +=
             `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;

  }).catch (error=>{
      console.error(error);
  });
}*/

function llenaCboGte(valor){
  dato = "";
  var arrayItems = [];
  axios({
      method:'GET',
      url:'../Ctr/ctrCatUsuario.php?opc=1&varGte=3',
      responseType:'json'
  }).then(res=>{
    this.uneg = res.data;
    if (valor == 0) {
      document.querySelector('#CboGte').innerHTML = '';
      document.querySelector('#CboGte').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++){
        document.querySelector('#CboGte').innerHTML +=
          `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
      }
    }else{
      document.querySelector('#CboGte').innerHTML = '';
      document.querySelector('#CboGte').innerHTML += `<option selected></option>`;
      for(let i=0; i < uneg.length; i++){
        document.querySelector('#CboGte').innerHTML +=
          `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
          arrayItems.push(uneg[i][0].CodGteMtto);
    }
    for (n in arrayItems) {
        var sctItem = arrayItems[n].trim();
        var prmVari = valor.trim();
        if (sctItem == prmVari) {
          document.getElementById('CboGte').value = sctItem;
        }
      }
    }
  }).catch (error=>{
      console.error(error);
  });
}


function ActAcciones(){
if (ValidaDatos(1) == 1) {
  $('#ErroridPassword2').empty();
  $('#idPassword2').css("border","1px solid #CED4DA");
  $('#ErroridUser').empty();
  $('#idUser').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErroridPassword').empty();
  $('#idPassword').css("border","1px solid #CED4DA");
  $('#ErrorCboPerfil').empty();
  $('#CboPerfil').css("border","1px solid #CED4DA");
  $('#ErrorCboSolicitante').empty();
  $('#CboSolicitante').css("border","1px solid #CED4DA");
  $('#ErrorCboGte').empty();
  $('#CboGte').css("border","1px solid #CED4DA");
  axios({
  method:'POST',
  url:'../Ctr/ctrCatUsuario.php',
  data: {
      Usuario: document.getElementById('idUser').value,
      Nombre: document.getElementById('Nombre').value,
      contrasenia: document.getElementById("idPassword").value,
      cboPerfil : document.getElementById('CboPerfil').value,
      cboSolcte: document.getElementById('CboSolicitante').value,
      cboGte: document.getElementById('CboGte').value
  }
  }).then(res=>{
        ObtenertUsr();
       $('#frmSolicita').modal('hide');
  }).catch (error=>{
      console.error(error);
  });
}  else{
    $('#ErroridPassword2').empty();
    $('#idPassword2').css("border","1px solid #CED4DA");
    $('#ErroridUser').empty();
    $('#idUser').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErroridPassword').empty();
    $('#idPassword').css("border","1px solid #CED4DA");
    $('#ErrorCboPerfil').empty();
    $('#CboPerfil').css("border","1px solid #CED4DA");
    $('#ErrorCboSolicitante').empty();
    $('#CboSolicitante').css("border","1px solid #CED4DA");
    $('#ErrorCboGte').empty();
    $('#CboGte').css("border","1px solid #CED4DA");
    if (document.getElementById('idUser').value.length == 0){
      document.getElementById('ErroridUser').innerHTML = "";
      $('#idUser').css("border","2px solid red");
      document.getElementById('ErroridUser').innerHTML += `${strRsp1}`;
  }
  if (document.getElementById('Nombre').value.length == 0){
      document.getElementById('ErrorNombre').innerHTML = "";
      $('#Nombre').css("border","2px solid red");
      document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
  }
  if (document.getElementById('idPassword').value.length == 0){
      document.getElementById('ErroridPassword').innerHTML = "";
      $('#idPassword').css("border","2px solid red");
      document.getElementById('ErroridPassword').innerHTML += `${strRsp3}`;
  }
    if (document.getElementById('idPassword2').value.length == 0){
      document.getElementById('ErroridPassword2').innerHTML = "";
      $('#idPassword2').css("border","2px solid red");
      document.getElementById('ErroridPassword2').innerHTML += `${strRsp4}`;
  }
  if (document.getElementById('CboPerfil').value.length == 0){
    document.getElementById('ErrorCboPerfil').innerHTML = "";
    $('#CboPerfil').css("border","2px solid red");
    document.getElementById('ErrorCboPerfil').innerHTML += `${strRsp5}`;
  }
  if (document.getElementById('CboSolicitante').value.length == 0){
    document.getElementById('ErrorCboSolicitante').innerHTML = "";
    $('#CboSolicitante').css("border","2px solid red");
    document.getElementById('ErrorCboSolicitante').innerHTML += `${strRsp6}`;
  }
  if (document.getElementById('CboGte').value.length == 0){
    document.getElementById('ErrorCboGte').innerHTML = "";
    $('#CboGte').css("border","2px solid red");
    document.getElementById('ErrorCboGte').innerHTML += `${strRsp7}`;
  }
}
}

function updateCatUsr()
{
  if(ValidaDatos(2)==1){
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboPerfil').empty();
    $('#CboPerfil').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatUsuario.php',
        data: {
          Usuario: document.getElementById('idUser').value,
          Nombre: document.getElementById('Nombre').value,
          cboPerfil: document.getElementById('CboPerfil').value,
          cboSolcte: document.getElementById('CboSolicitante').value,
          cboGte: document.getElementById('CboGte').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenertUsr();
         $('#frmSolicita').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
  }else{
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboPerfil').empty();
    $('#CboPerfil').css("border","1px solid #CED4DA");
    $('#CboGte').css("border","1px solid #CED4DA");
  if (document.getElementById('Nombre').value.length == 0){
      document.getElementById('ErrorNombre').innerHTML = "";
      $('#Nombre').css("border","2px solid red");
      document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
  }
  if (document.getElementById('CboPerfil').value.length == 0){
    document.getElementById('ErrorCboPerfil').innerHTML = "";
    $('#CboPerfil').css("border","2px solid red");
    document.getElementById('ErrorCboPerfil').innerHTML += `${strRsp5}`;
  }
  }
}

function ValidaDatos(x)
{
  var dv = 1;
  strRsp1 = "";
  strRsp2 = "";
  strRsp3 = "";
  strRsp4 = "";
  strRsp5 = "";
  strRsp6 = "";
  strRsp7 = "";
  var  elementSolicita = document.getElementById("elementSolicita");
  var elementGte = document.getElementById("elementGte");

	if(x==1){
		 if (document.getElementById('idUser').value.length == 0){
       strRsp1 += 'Capture el código del usuario.';
       dv = 0;
  }

  if (document.getElementById('Nombre').value.length == 0){
      strRsp2 += 'Capture el nombre del usuario.';
      dv = 0;
  }
  if (document.getElementById('idPassword').value.length ==0 ) {
    strRsp3 += 'Capture la contraseña del usuario';
    dv = 0;
  }
  if (document.getElementById('idPassword2').value.length ==0 ) {
    strRsp4 += 'Se necesita confirmar la contraseña';
    dv = 0;
  }
  if (document.getElementById('CboPerfil').value.length ==0 ) {
    strRsp5 += 'Seleccione un perfil válido.';
    dv = 0;
  }
  if ((elementSolicita.style.display == 'block')  && (document.getElementById('CboSolicitante').value.length ==0)) {
    strRsp6 += 'Seleccione un solicitante válido.';
    dv = 0;
  }
  if ((elementGte.style.display == 'block') && (document.getElementById('CboGte').value.length ==0) ) {
    strRsp7 += 'Seleccione un gerente válido.';
    dv = 0;
  }


 return dv;
	
	}else{
	  if (document.getElementById('Nombre').value.length == 0){
          strRsp += 'Tienes que capturar un Nombre válido <br>';
          dv = 0;
      }
      if (document.getElementById('CboPerfil').value.length ==0 ) {
        strRsp += 'Seleccione un perfil válido <br>';
        dv = 0;
      }
     return dv;
	
	}
}


function validaPass(){
  var password = document.getElementById('idPassword').value;
  var confirmaPassword = document.getElementById('idPassword2').value;

  if (password !== confirmaPassword) {
    document.getElementById('idPassword').value = "";
    document.getElementById('idPassword2').value = "";
    $("#innerHTML").slideDown(50).delay(4000).slideUp(500);
    document.getElementById('innerHTML').innerHTML += `
                                <div class="alert alert-danger" role="alert">
                                <strong> Error! </strong> Las contraseñas ingresadas no coinciden.
                                </div>`;
  }

}

function obtValue(){

  var x =  document.getElementById('CboPerfil').value;
  var  elementSolicita = document.getElementById("elementSolicita");
  var elementGte = document.getElementById("elementGte");
  llenaCboSolicitante(0);
  llenaCboGte(0);

  switch (x) {
    case 'Admin':
      elementGte.style.display='none';
      elementSolicita.style.display='none';
    break;
    case 'Sist':
      elementGte.style.display='none';
      elementSolicita.style.display='none';
    break;
    case 'Capturista':
      document.getElementById('elementGte').value = "";
      elementGte.style.display='block';
      elementSolicita.style.display='none';

    break;
    case 'GteMatto':
      document.getElementById("elementGte").value = "";
      elementGte.style.display='block';
      elementSolicita.style.display='none';
    break;
    case 'JefeArea':
      document.getElementById('elementSolicita').value = "";
      elementSolicita.style.display='block';
      elementGte.style.display='none';
    break;
    default:
      console.log("No hay ningún valor seleccionado en el combo");
    }
}
