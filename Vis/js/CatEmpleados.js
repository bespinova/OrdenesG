var dato;
// TODO: QUITAR Y LIMPIAR TEXTO AL MODAL, LIMPIAR COMBO
// TODO: listo 10/09/21 16:53 HRS
$(document).ready(function(){//cuando este lista la página
    $('#tblOsOrd tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    ObtenertOsT();
    llenaCboGte();
});

function setOpcion(op)
{
    opcion = op;

    CodEmpleado: document.getElementById('CodEmpleado').disabled = false;
    Nombre: document.getElementById('Nombre').disabled = false;

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
        $("#ModPregSiNo").html("¿Estás seguro de eliminar el <strong>Empleado "+dato+"</strong>?")
        $('#PreguntaSiNo').modal('show');
      }else {
        document.getElementById('txtMostrar').innerHTML = "";
        $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
        document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-danger" role="alert">
                                      <strong> Seleccione un elemento para Eliminar </strong>
                                      </div>`;
      }
    }

}
function drvOperacion()
{
    switch(opcion)
    {
        case 1: ActAcciones(); break;
        case 2: updateCatEmpl();
         break;
        case 3:
              DeleteCatEmpl();  // Elimina el registro
              $('#PreguntaSiNo').modal('hide');
              ObtenertOsT();

         break;
    }
}

function ActAcciones(){
if (ValidaDatos() == 1) {
    $('#ErrorCodEmpleado').empty();
    $('#CodEmpleado').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboClvMtto').empty();
    $('#CboClvMtto').css("border","1px solid #CED4DA");
  axios({
  method:'POST',
  url:'../Ctr/ctrCatEmpleados.php',
  data: {
      CodEmpleado: document.getElementById('CodEmpleado').value,
      Nombre: document.getElementById('Nombre').value,
      claveGteMtto: document.getElementById('CboClvMtto').value,
      Email: document.getElementById('cmpEmail').value
  }
  }).then(res=>{
        ObtenertOsT();
       $('#frmSolicita').modal('hide');
  }).catch (error=>{
      console.error(error);
  });
} else{
    $('#ErrorCodEmpleado').empty();
    $('#CodEmpleado').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboClvMtto').empty();
    $('#CboClvMtto').css("border","1px solid #CED4DA");
    if (document.getElementById('CodEmpleado').value.length == 0){
        document.getElementById('ErrorCodEmpleado').innerHTML = "";
        $('#CodEmpleado').css("border","2px solid red");
        document.getElementById('ErrorCodEmpleado').innerHTML += `${strRsp1}`;
    }
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('CboClvMtto').value.length == 0){
        document.getElementById('ErrorCboClvMtto').innerHTML = "";
        $('#CboClvMtto').css("border","2px solid red");
        document.getElementById('ErrorCboClvMtto').innerHTML += `${strRsp4}`;
    }
}
}

function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatEmpleados.php?CodPantalla=P005',
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


function DeleteCatEmpl()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatEmpleados.php?CodArea='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
            //ObtenertOsT();
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateSolicita()
{
    $('#ErrorCodEmpleado').empty();
    $('#CodEmpleado').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboClvMtto').empty();
    $('#CboClvMtto').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatEmpleados.php?varCodArea='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodEmpleado').value = this.uneg[0][0].CodEmpleado;
            document.getElementById('Nombre').value = this.uneg[0][0].Nombre;
            document.getElementById('CboClvMtto').value = this.uneg[0][0].claveGteMtto;
            document.getElementById('cmpEmail').value = this.uneg[0][0].Email;
            document.getElementById('CodEmpleado').disabled =true;
        }).catch (error=>{
            console.error(error);
    });
}

function updateCatEmpl()
{
	if (ValidaDatos() == 1) {
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        $('#ErrorCboClvMtto').empty();
        $('#CboClvMtto').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatEmpleados.php',
        data: {
          CodEmpleado: document.getElementById('CodEmpleado').value,
          Nombre: document.getElementById('Nombre').value,
          claveGteMtto: document.getElementById('CboClvMtto').value,
          Email: document.getElementById('cmpEmail').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenertOsT();
         $('#frmSolicita').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
	}else {
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        $('#ErrorCboClvMtto').empty();
        $('#CboClvMtto').css("border","1px solid #CED4DA");
        if (document.getElementById('Nombre').value.length == 0){
            document.getElementById('ErrorNombre').innerHTML = "";
            $('#Nombre').css("border","2px solid red");
            document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
        }
        if (document.getElementById('CboClvMtto').value.length == 0){
            document.getElementById('ErrorCboClvMtto').innerHTML = "";
            $('#CboClvMtto').css("border","2px solid red");
            document.getElementById('ErrorCboClvMtto').innerHTML += `${strRsp4}`;
        }
  }
}


function closeMd()
{
    $('#ErrorCodEmpleado').empty();
    $('#CodEmpleado').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorCboClvMtto').empty();
    $('#CboClvMtto').css("border","1px solid #CED4DA");
   document.getElementById('CodEmpleado').disabled = false;
   document.getElementById('Nombre').value = "";
   document.getElementById('cmpEmail').value = "";
   document.getElementById('CodEmpleado').value = "";
   document.getElementById('CboClvMtto').value = "";
   ObtenertOsT()

}
// TODO: se agrego validacion para datos vacios
function ObtenertOsT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatEmpleados.php',
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
                <th style="width: 150px;">Código</th>
                <th>Nombre</th>
                <th>Gte. Mtto</th>
                <th>Email</th>
              </tr>
          </thead>`
          document.getElementById('tblOsOrd').innerHTML +=
            `<tr>
                    <td style="width: 150px;">NO HAY REGISTROS</td>
                    <td>NO HAY REGISTROS</td>
                    <td>NO HAY REGISTROS</td>
                    <td>NO HAY REGISTROS</td>
             </tr>`;
        }

    }).catch (error=>{
        console.error(error);
    });
}

function llenarTabla()
{
    $("#tblOsOrd tr").remove();
    document.querySelector('#tblOsOrd thead').innerHTML +=
        `<tr>
            <th style="width: 150px;">Cod. Empleado</th>
            <th>Nombre</th>
            <th>Gte Mantto</th>
            <th>Email</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblOsOrd tbody').innerHTML +=
        `<tr>
                <td style="width: 150px;">${uneg[i][0].CodEmpleado}</td>
                <td>${uneg[i][0].NombreEmpleado}</td>
                <td>${uneg[i][0].NombreGte}</td>
                <td>${uneg[i][0].Email}</td>
         </tr>`;
    }
}

function llenaCboGte(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatEmpleados.php?op=1&varUne=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        document.querySelector('#CboClvMtto').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++)
             document.querySelector('#CboClvMtto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
    }).catch (error=>{
        console.error(error);
    });
}
function busquedEmpl(){
  varBsq = document.getElementById('IdBuscar').value;
  axios({
      method:'GET',
      url:'../Ctr/ctrCatEmpleados.php?cmpBusc='+varBsq,
      responseType:'json'
  }).then(res=>{
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

function isObject(val)
 {
    if (val === null)
    {
        return false;
    }
      return ( (typeof val === 'function') || (typeof val === 'object'));
  }

function ValidaDatos()
{
    var dv = 1;
    strRsp1 = "";
    strRsp2 = "";
    strRsp4 = "";

    if (document.getElementById('CodEmpleado').value.length == 0){
         strRsp1 += 'Capture código del empleado.';
         dv = 0;
    }

    if (document.getElementById('Nombre').value.length == 0){
        strRsp2 += 'Capture el nombre del empleado.';
        dv = 0;
    }
    if (document.getElementById('CboClvMtto').value.length == 0){
        strRsp4 += 'Seleccione un gerente de mantenimiento válido.';
        dv = 0;
    }
    /*if (document.getElementById('cmpEmail').value.length === 0) {
      strRsp += 'El campo <strong>Email</strong> esta vacío, por favor verifique <br>';
      dv = 0;
    }*/
   return dv;
}
