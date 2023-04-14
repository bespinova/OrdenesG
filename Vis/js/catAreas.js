var dato;
// TODO: AGREGAR NOMBRE EN LA TABLA DE UNIDAD DE NEGOCIO Y LIMPIAR CONTROL DE COMBO
// TODO: LISTO 10/09/21
$(document).ready(function(){//cuando este lista la página
    $('#tblOsOrd tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    ObtenertOsT();
    llenaCboCUneg();
});

function setOpcion(op)
{
    opcion = op;
    CodArea: document.getElementById('CodArea').disabled = false;
    Nombre: document.getElementById('Nombre').disabled = false;

    if (opcion == 2){
      if (dato.length > 0) {
        UpdateSolicita();
        $('#frmSolicita').modal('show');
        document.getElementById('txtMostrar').innerHTML = "";
      }
    else {
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
        $("#ModPregSiNo").html("¿Estás seguro de eliminar el <strong>Área "+dato+"</strong>?")
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
  switch(opcion)
  {
      case 1: ActAcciones();
       break;
      case 2: updateCatArea();
       break;
      case 3:
            DeletCatArea();  // Elimina el registro
            $('#PreguntaSiNo').modal('hide');
            ObtenertOsT();
       break;
  }
}


function ActAcciones(){
  if (ValidaDatos() == 1) {
    $('#ErrorArea').empty();
    $('#CodArea').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorUNegocio').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    axios({
    method:'POST',
    url:'../Ctr/ctrCatAreas.php',
    data: {
        CodArea: document.getElementById('CodArea').value,
        Nombre: document.getElementById('Nombre').value,
        catUnNegogio: document.getElementById('CboUniNeg').value
    }
    }).then(res=>{
        console.log(res.data);
          ObtenertOsT();
        $('#frmSolicita').modal('hide');
        document.getElementById('CodArea').value = '';
        document.getElementById('Nombre').value = '';
        document.getElementById('CboUniNeg').value = '';
    }).catch (error=>{
        console.error(error);
    });
  }else{
    $('#ErrorArea').empty();
    $('#CodArea').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorUNegocio').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    if (document.getElementById('CodArea').value.length == 0){
        document.getElementById('ErrorArea').innerHTML = "";
        $('#CodArea').css("border","2px solid red");
        document.getElementById('ErrorArea').innerHTML += `${strRsp1}`;
    }
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('CboUniNeg').value.length == 0){
        document.getElementById('ErrorUNegocio').innerHTML = "";
        $('#CboUniNeg').css("border","2px solid red");
        document.getElementById('ErrorUNegocio').innerHTML += `${strRsp3}`;
    }
  }
}

function DeletCatArea()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatAreas.php?CodArea='+dato,
        responseType:'json'
        }).then(res=>{
        }).catch (error=>{
          console.error(error);
    });
}

function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatAreas.php?CodPantalla=P002',
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

function UpdateSolicita()
{
  $('#ErrorArea').empty();
  $('#CodArea').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErrorUNegocio').empty();
  $('#CboUniNeg').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatAreas.php?varCodArea='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodArea').value = this.uneg[0][0].CodArea;
            document.getElementById('Nombre').value = this.uneg[0][0].Nombre;
            document.getElementById('CboUniNeg').value = this.uneg[0][0].CodUNegocio;
            document.getElementById('CodArea').disabled =true;
        }).catch (error=>{
            console.error(error);
    });
}

function updateCatArea()
{
  if (ValidaDatos() == 1) {
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorUNegocio').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatAreas.php',
        data: {
          CodArea: document.getElementById('CodArea').value,
          Nombre: document.getElementById('Nombre').value,
          catUnNegogio: document.getElementById('CboUniNeg').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenertOsT();
         $('#frmSolicita').modal('hide');
         document.getElementById('CodArea').value = "";
         document.getElementById('Nombre').value = "";
         document.getElementById('CboUniNeg').value ="";
    }).catch (error=>{
        console.error(error);
    });
  }else {
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorUNegocio').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('CboUniNeg').value.length == 0){
        document.getElementById('ErrorUNegocio').innerHTML = "";
        $('#CboUniNeg').css("border","2px solid red");
        document.getElementById('ErrorUNegocio').innerHTML += `${strRsp3}`;
    }
  }
}


function closeMd()
{
  $('#ErrorArea').empty();
  $('#CodArea').css("border","1px solid #CED4DA");
  $('#ErrorNombre').empty();
  $('#Nombre').css("border","1px solid #CED4DA");
  $('#ErrorUNegocio').empty();
  $('#CboUniNeg').css("border","1px solid #CED4DA");
   document.getElementById('CodArea').value = "";
   document.getElementById('Nombre').value = "";
   document.getElementById('CboUniNeg').value ="";
   ObtenertOsT();
}
// TODO: se agrego validacion para cuando no hay registros
function ObtenertOsT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatAreas.php',
        responseType:'json'
    }).then(res=>{
        this.uneg = res.data;
        console.log(res.data);
        if (isObject(res.data)) {
          llenarTabla();
        }else {
          document.getElementById('tblOsOrd').innerHTML = '';
          document.getElementById('tblOsOrd').innerHTML +=
          `<thead  class="table-dark">
              <tr>
                <th style="width: 80px;">Código</th>
                <th>Nombre</th>
                <th>Unidad de Negocio</th>
              </tr>
          </thead>`
          document.getElementById('tblOsOrd').innerHTML +=
            `<tr>
                    <td style="width: 80px;">NO HAY REGISTROS</td>
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
            <th>Cod. Área</th>
            <th>Nombre</th>
            <th>Unidad de Negocio</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){

        document.querySelector('#tblOsOrd tbody').innerHTML +=
        `<tr>
                <td>${uneg[i][0].CodArea}</td>
                <td>${uneg[i][0].NombreArea}</td>
                <td>${uneg[i][0].NombreUnidadNegocio}</td>
         </tr>`;
    }
}
function llenaCboCUneg(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatAreas.php?op=1&varUne=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboUniNeg').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++)
             document.querySelector('#CboUniNeg').innerHTML +=
               `<option value="${uneg[i][0].CodUNegocio}">${uneg[i][0].Nombre}</option>`;

    }).catch (error=>{
        console.error(error);
    });
}
function llenaCboArea(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatAreas.php?op=3&varArea=2',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboAsigAr').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++)
             document.querySelector('#CboAsigAr').innerHTML +=
               `<option value="${uneg[i][0].CodArea}">${uneg[i][0].Nombre}</option>`;

    }).catch (error=>{
        console.error(error);
    });
}

function busquedArea(){
  varBsq = document.getElementById('IdBuscar').value;
  axios({
      method:'GET',
      url:'../Ctr/ctrCatAreas.php?cmpBusc='+varBsq,
      responseType:'json'
  }).then(res=>{
        if(isObject(res.data)){
          this.uneg = res.data;
          llenarTabla();
        }else {
          document.getElementById('txtMostrar').innerHTML = "";
          $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
          document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-warning " role="alert">
                                      <strong> ! Alerta ¡ </strong>${res.data}
                                      </div>`;
        }
  }).catch (error=>{
      console.error(error);
  });
}

/*FUNCION PARA VALIDACION DE BUSQUEDA*/
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
  strRsp3 = "";

  if (document.getElementById('CodArea').value.length == 0){
       strRsp1 += 'Capture el código del Área.';
       dv = 0;
  }
  if (document.getElementById('Nombre').value.length == 0){
      strRsp2 += 'Capture el nombre del Área.';
      dv = 0;
  }
  if (document.getElementById('CboUniNeg').value.length == 0) {
    strRsp3 += 'Seleccione una unidad de negocio válida.';
    dv = 0;
  }
 return dv;
}
