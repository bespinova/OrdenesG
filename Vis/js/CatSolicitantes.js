var dato;
// TODO: AGREGAR FILTRADO PARA AREAS, LIMPIOAR COMBO PARA AGREGAR Y NOMBRE EN LAS TABLAS
// TODO: LISTO FILTRADO DE AREA CON COMBO BOX, LIMPIEZA 10/09/21 15:OO HRS
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
    //llenaCboArea();
});

function setOpcion(op)
{
    opcion = op;

    CodSolicitante: document.getElementById('CodSolicitante').disabled = false;
    Nombre: document.getElementById('Nombre').disabled = false;
    Email : document.getElementById('cmpEmail').disabled = false;

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
        $("#ModPregSiNo").html("¿Estás seguro de eliminar al <strong>Solicitante "+dato+"</strong>?")
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
        case 2: UpdateCatSol();
         break;
        case 3:
              DeleteCatSolici();
              $('#PreguntaSiNo').modal('hide');
              ObtenertOsT();
         break;
    }
}

function ActAcciones(){
if (ValidaDatos() == 1) {
    $('#ErrorCodSolicitante').empty();
    $('#CodSolicitante').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
  axios({
  method:'POST',
  url:'../Ctr/ctrCatSolicitante.php',
  data: {
      CodSolicitante: document.getElementById('CodSolicitante').value,
      Nombre: document.getElementById('Nombre').value,
      Email: document.getElementById('cmpEmail').value,
      catUNegocio: document.getElementById('CboUniNeg').value,
      codArea: document.getElementById('CboAsigAr').value
  }
  }).then(res=>{
      console.log(res.data);
        ObtenertOsT();
       $('#frmSolicita').modal('hide');
  }).catch (error=>{
      console.error(error);
  });
}else{
    $('#ErrorCodSolicitante').empty();
    $('#CodSolicitante').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    if (document.getElementById('CodSolicitante').value.length == 0){
        document.getElementById('ErrorCodSolicitante').innerHTML = "";
        $('#CodSolicitante').css("border","2px solid red");
        document.getElementById('ErrorCodSolicitante').innerHTML += `${strRsp1}`;
    }
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('cmpEmail').value.length == 0){
        document.getElementById('ErrorcmpEmail').innerHTML = "";
        $('#cmpEmail').css("border","2px solid red");
        document.getElementById('ErrorcmpEmail').innerHTML += `${strRsp3}`;
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
}
}

function DeleteCatSolici()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatSolicitante.php?CodSolcte='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
        }).catch (error=>{
            console.error(error);
    });
}

function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatSolicitante.php?CodPantalla=P004',
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
    $('#ErrorCodSolicitante').empty();
    $('#CodSolicitante').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatSolicitante.php?varCod='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.osOrd = res.data;
            document.getElementById('CodSolicitante').value = this.osOrd[0][0].CodSolicitante;
            document.getElementById('Nombre').value = this.osOrd[0][0].Nombre;
            document.getElementById('cmpEmail').value = this.osOrd[0][0].Email;
            document.getElementById('CboUniNeg').value = this.osOrd[0][0].CodUNegocio;
            document.getElementById('CboAsigAr').value = this.osOrd[0][0].CodArea;
            document.getElementById('CodSolicitante').disabled =true;
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateCatSol()
{
    if(ValidaDatos()==1){
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        $('#ErrorcmpEmail').empty();
        $('#cmpEmail').css("border","1px solid #CED4DA");
        $('#ErrorCboUniNeg').empty();
        $('#CboUniNeg').css("border","1px solid #CED4DA");
        $('#ErrorCboAsigAr').empty();
        $('#CboAsigAr').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatSolicitante.php',
        data: {
          CodSolicitante: document.getElementById('CodSolicitante').value,
          Nombre: document.getElementById('Nombre').value,
          Email: document.getElementById('cmpEmail').value,
          catUNegocio: document.getElementById('CboUniNeg').value,
          codArea: document.getElementById('CboAsigAr').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenertOsT();
         $('#frmSolicita').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
} else{
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('cmpEmail').value.length == 0){
        document.getElementById('ErrorcmpEmail').innerHTML = "";
        $('#cmpEmail').css("border","2px solid red");
        document.getElementById('ErrorcmpEmail').innerHTML += `${strRsp3}`;
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
}
}


function closeMd()
{
    $('#ErrorCodSolicitante').empty();
    $('#CodSolicitante').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    $('#ErrorCboUniNeg').empty();
    $('#CboUniNeg').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigAr').empty();
    $('#CboAsigAr').css("border","1px solid #CED4DA");
    document.getElementById('CodSolicitante').disabled = false;
    document.getElementById('CodSolicitante').value = "";
    document.getElementById('Nombre').value = "";
    document.getElementById('cmpEmail').value = "";
    document.getElementById('CboUniNeg').value = "";
    document.getElementById('CboAsigAr').value = "";
    ObtenertOsT()
}
// TODO: se agrego validacion para cuando no hay registros
function ObtenertOsT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatSolicitante.php',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        if (isObject(res.data)) {
          this.osOrd = res.data;
          llenarTabla();
        }else {
          document.getElementById('tblOsOrd').innerHTML = '';
          document.getElementById('tblOsOrd').innerHTML +=
          `<thead  class="table-dark">
              <tr>
                <th style="width: 150px;">Código</th>
                <th>Nombre</th>
                <th>Área</th>
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

function cmbUnidadN(){
  llenaCboArea(document.getElementById('CboUniNeg').value);
  ObtenertOsT();
}

function opcBusqueda(){
    varBsq = document.getElementById('IdBuscar').value;
    axios({
        method:'GET',
        url:'../Ctr/ctrCatSolicitante.php?cmpBusc='+varBsq,
        responseType:'json'
    }).then(res=>{
      if (isObject(res.data)) {
        this.osOrd = res.data;
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

function isObject(val)
 {
    if (val === null)
    {
        return false;
    }
      return ( (typeof val === 'function') || (typeof val === 'object'));
  }

function llenarTabla()
{
    $("#tblOsOrd tr").remove();
    document.querySelector('#tblOsOrd thead').innerHTML +=
        `<tr>
            <th style="width: 150px;">Código</th>
            <th>Nombre</th>
            <th>Unidad de Negocio</th>
            <th>Área</th>
            <th>Email</th>
        </tr>`;

    for(let i=0; i <osOrd.length; i++){
        document.querySelector('#tblOsOrd tbody').innerHTML +=
        `<tr>
                <td style="width: 150px;">${osOrd[i][0].CodSolicitante}</td>
                <td>${osOrd[i][0].NombreSolicitante}</td>
                <td>${osOrd[i][0].NombreUnidadNegocio === null ? "" : osOrd[i][0].NombreUnidadNegocio     }</td>
                <td>${osOrd[i][0].NombreArea === null ? "" :  osOrd[i][0].NombreArea}</td>
                <td>${osOrd[i][0].Email}</td>
         </tr>`;
    }
}
function llenaCboCUneg(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatSolicitante.php?op=1&codUne=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.osOrd = res.data;
        //Lleno al cambo
        document.querySelector('#CboUniNeg').innerHTML += `<option selected></option>`;
        for(let i=0; i <osOrd.length; i++){
          document.querySelector('#CboUniNeg').innerHTML +=
            `<option value="${osOrd[i][0].CodUNegocio}">${osOrd[i][0].Nombre}</option>`;
        }


    }).catch (error=>{
        console.error(error);
    });
}
function llenaCboArea(valor){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatSolicitante.php?op=3&codArea=2&varData='+valor,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.osOrd = res.data;
        //Lleno al cambo
        document.querySelector('#CboAsigAr').innerHTML = '';
        document.querySelector('#CboAsigAr').innerHTML += `<option selected></option>`;
        for(let i=0; i < osOrd.length; i++)
             document.querySelector('#CboAsigAr').innerHTML +=
               `<option value="${osOrd[i][0].CodArea}">${osOrd[i][0].Nombre}</option>`;

    }).catch (error=>{
        console.error(error);
    });
}

function ValidaDatos()
{
    var dv = 1;
    strRsp1 = "";
    strRsp2 = "";
    strRsp3 = "";
    strRsp4 = "";
    strRsp5 = "";

    if (document.getElementById('CodSolicitante').value.length == 0){
         strRsp1 += 'Capture el código del solicitante.';
         dv = 0;
    }

    if (document.getElementById('Nombre').value.length == 0){
        strRsp2 += 'Capture el nombre del solicitante.';
        dv = 0;
    }
    if (document.getElementById('cmpEmail').value.length == 0){
        strRsp3 += 'Capture el email del solicitante.';
        dv = 0;
    }
    //if (document.getElementById('CboUniNeg').value.length == 0){
        //strRsp4 += 'Seleccione una unidad de negocio válidad';
      //  dv = 0;
    //}
    //if (document.getElementById('CboAsigAr').value.length == 0){
        //strRsp5 += 'Seleccione un área válida.';
      //  dv = 0;
    //}
   return dv;
}
