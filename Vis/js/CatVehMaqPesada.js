var dato;
var cmpDisponible;
$(document).ready(function(){//cuando este lista la página
    $('#tblUNeg tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    llenaCboTipoVeh();
    ObtenerVehMaqPesadaT();
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op)
{
    opcion = op;
     document.getElementById('CodUnidad').disabled = false;
     document.getElementById('Descripcion').disabled = false;
     document.getElementById('CboTipoUni').disabled = false;
     document.getElementById('Estatus').disabled = false;
     document.getElementById('Descripcion').disabled = false;
     

    if (opcion == 2)
    {
        if (dato.length > 0 )
        {
            UpdateVehMaqPesada1();
            $('#frmCatVehMaqPesada').modal('show');
            document.getElementById('txtMostrar').innerHTML = "";
        }
        else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                          <strong> Seleccione un elemento para editar </strong>
                                          </div>`;
        }

     }

    if (opcion == 3)
    {
        if (dato.length > 0 ) {
            //Aka me quedo
              //document.getElementById('modbodyDel').innerHTML='Estas seguro de eliminar el Rubro '+dato;
              $("#ModPregSiNo").html("¿Estás seguro de eliminar la <strong>Unidad "+dato+"</strong>?")
              $('#PreguntaSiNo').modal('show');
            //drvOperacion();
        }
        else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                          <strong> Seleccione un elemento para eliminar </strong>
                                          </div>`;
        }
    }
}




function drvOperacion()
{
    switch(opcion)
    {
        case 1: SaveVehMaqPesada(); break;
        case 2: UpdateVehMaqPesada2();
         break;
        case 3: DeleteRubro();  // Elimina el registro
                $('#PreguntaSiNo').modal('hide');
                ObtenerVehMaqPesadaT();  //llena la tabla de nuevo
         break;
    }
}


function llenaCboTipoVeh(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatVehMaqPesada.php?op=10',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboTipoUni').innerHTML += `<option selected></option>`;


        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboTipoUni').innerHTML +=
               `<option value="${uneg[i][0].TipoVeh}">${uneg[i][0].TipoVeh}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}


function ObtenerVehMaqPesadaT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatVehMaqPesada.php?op=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}


function ObtenertUnidadB(){
    t1 = document.getElementById('Buscar').value;
    axios({
        method:'GET',
        url:'../Ctr/ctrCatVehMaqPesada.php?op=3&cmpBusc='+t1,
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


/*FUNCION PARA VALIDACION DE BUSQUEDA*/
function isObject(val)
 {
    if (val === null)
    {
        return false;
    }
      return ( (typeof val === 'function') || (typeof val === 'object'));
}


function SaveVehMaqPesada()
{ 
    if (ValidaDatos() == 1){
        $('#ErrorCodUnidad').empty();
        $('#CodUnidad').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboTipoUni').empty();
        $('#CboTipoUni').css("border","1px solid #CED4DA");
        axios({
        method:'POST',
        url:'../Ctr/ctrCatVehMaqPesada.php',
        data: {
            "CodUnidad": document.getElementById('CodUnidad').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "TipoVeh": document.getElementById('CboTipoUni').value,
            "Disponible": "1",
            "Estatus": ( $('#Estatus').prop('checked') == true )?1:0,
            "Observaciones": document.getElementById('Observacion').value
        }
        }).then(res=>{
            console.log(res.data);
            ObtenerVehMaqPesadaT();
             $('#frmCatVehMaqPesada').modal('hide');
        }).catch (error=>{
            console.error(error);
        });
    }
    else{
        $('#ErrorCodUnidad').empty();
        $('#CodUnidad').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboTipoUni').empty();
        $('#CboTipoUni').css("border","1px solid #CED4DA");
        if (document.getElementById('CodUnidad').value.length == 0){
            document.getElementById('ErrorCodUnidad').innerHTML = "";
            $('#CodUnidad').css("border","2px solid red");
            document.getElementById('ErrorCodUnidad').innerHTML += `${strRsp1}`;
        }
        if (document.getElementById('Descripcion').value.length == 0){
            document.getElementById('ErrorDescripcion').innerHTML = "";
            $('#Descripcion').css("border","2px solid red");
            document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
        }
        if (document.getElementById('CboTipoUni').value.length == 0){
            document.getElementById('ErrorCboTipoUni').innerHTML = "";
            $('#CboTipoUni').css("border","2px solid red");
            document.getElementById('ErrorCboTipoUni').innerHTML += `${strRsp3}`;
        }
    }
}

function DeleteRubro()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatVehMaqPesada.php?CodUnidad='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
            //llenarTabla();
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateVehMaqPesada1()
{
    $('#ErrorCodUnidad').empty();
    $('#CodUnidad').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboTipoUni').empty();
    $('#CboTipoUni').css("border","1px solid #CED4DA");
     axios({
            method:'GET',
            url:'../Ctr/ctrCatVehMaqPesada.php?op=2&CodUnidad='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodUnidad').value = this.uneg[0][0].CodUnidad;
            document.getElementById('Descripcion').value = this.uneg[0][0].Descripcion;
            document.getElementById('CboTipoUni').value = this.uneg[0][0].TipoVeh;
            cmpDisponible = this.uneg[0][0].Disponible;
            $('#Estatus').prop('checked',(this.uneg[0][0].Estatus == 1)? true : false);
            document.getElementById('Observacion').value = this.uneg[0][0].Observaciones;
            document.getElementById('CodUnidad').disabled = true;
        }).catch (error=>{
            console.error(error);
    });
}


function UpdateVehMaqPesada2()
{
    if(ValidaDatos()==1){
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboTipoUni').empty();
        $('#CboTipoUni').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatVehMaqPesada.php',
        data: {            
            "CodUnidad": document.getElementById('CodUnidad').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "TipoVeh": document.getElementById('CboTipoUni').value,
            "Disponible": cmpDisponible,
            "Estatus": ( $('#Estatus').prop('checked') == true )?1:0,
            "Observaciones": document.getElementById('Observacion').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenerVehMaqPesadaT();
             $('#frmCatVehMaqPesada').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
}else{
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboTipoUni').empty();
    $('#CboTipoUni').css("border","1px solid #CED4DA");
    if (document.getElementById('Descripcion').value.length == 0){
        document.getElementById('ErrorDescripcion').innerHTML = "";
        $('#Descripcion').css("border","2px solid red");
        document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
    }
    if (document.getElementById('CboTipoUni').value.length == 0){
        document.getElementById('ErrorCboTipoUni').innerHTML = "";
        $('#CboTipoUni').css("border","2px solid red");
        document.getElementById('ErrorCboTipoUni').innerHTML += `${strRsp3}`;
    }
}
}

// Pendiente
function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatVehMaqPesada.php?op=4&CodPantalla=P010',
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



function closeMd()
{
    $('#ErrorCodUnidad').empty();
    $('#CodUnidad').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboTipoUni').empty();
    $('#CboTipoUni').css("border","1px solid #CED4DA");
   document.getElementById('CodUnidad').value = "";
   document.getElementById('Descripcion').value = "";
   document.querySelector('#CboTipoUni').options[0].selected = true;
   //document.querySelector('#Estatus').cheked = true;
   $('#Estatus').prop('checked', true);
   document.getElementById('Observacion').value = "";

   document.getElementById('CodUnidad').disabled = false;
   ObtenerVehMaqPesadaT();
}


function llenarTabla()
{
    $("#tblUNeg tr").remove();
    document.querySelector('#tblUNeg thead').innerHTML +=
        `<tr>
            <th style="width: 150px;">Código</th>
            <th >Descripción</th>
            <th style="width: 200px;">Tipo de Unidad</th>
            <th style="width: 100px;">Disponible</th>
            <th style="width: 120px;">Estatus</th>
            <th>Observaciones</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblUNeg tbody').innerHTML +=
        `<tr>
            <td style="width: 150px;">${uneg[i][0].CodUnidad}</td>
            <td >${uneg[i][0].Descripcion}</td>
            <td style="width: 200px;">${uneg[i][0].TipoVeh}</td>
            <td style="width: 100px;">${uneg[i][0].Disponible}</td>
            <td style="width: 120px;">${uneg[i][0].Estatus}</td>
            <td>${uneg[i][0].Observaciones}</td>
         </tr>`;
    }
}


function ValidaDatos()
{
    var dv = 1;
    strRsp1 = "";
    strRsp2 = "";
    strRsp3 = "";
    if (document.getElementById('CodUnidad').value.length == 0){
         strRsp1 += 'Capture el código del vehículo. <br>';
         dv = 0;
    }
    if (document.getElementById('Descripcion').value.length == 0){
        strRsp2 += 'Capture la descripcion del vehículo.<br>';
        dv = 0;
    }
    if (document.getElementById('CboTipoUni').value.length == 0){
        strRsp3 += 'Seleccione un tipo de vehículo.<br>';
        dv = 0;
    }
   return dv;
}