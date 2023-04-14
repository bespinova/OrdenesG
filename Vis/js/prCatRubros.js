var dato;
$(document).ready(function(){//cuando este lista la página
    $('#tblUNeg tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    llenaCboAsigA();
    ObtenerRubroT();
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op)
{
    opcion = op;
     document.getElementById('CodRubro').disabled = false;
     document.getElementById('Descripcion').disabled = false;
     document.getElementById('CboPerteneceA').disabled = false;

    if (opcion == 2)
    {
        if (dato.length > 0 )
        {
            UpdateRubro1();
            $('#frmCatRubros').modal('show');
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
        if (dato.length > 0 )  {
            //Aka me quedo
              //document.getElementById('modbodyDel').innerHTML='Estas seguro de eliminar el Rubro '+dato;
              $("#ModPregSiNo").html("¿Estas seguro de eliminar el <strong>Rubro "+dato+"</strong>?")
              $('#PreguntaSiNo').modal('show');
            //drvOperacion();
        }
        else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-danger" role="alert">
                                  <strong> Seleccione un elemento para eliminar</strong>
                                  </div>`;
        }
    }
}




function drvOperacion()
{
    switch(opcion)
    {
        case 1: SaveRubro(); break;
        case 2: UpdateRubro2();
         break;
        case 3: DeleteRubro();  // Elimina el registro
                $('#PreguntaSiNo').modal('hide');
                ObtenerRubroT();  //llena la tabla de nuevo
         break;
    }
	document.getElementById('CodRubro').value = "";
	document.getElementById('Descripcion').value = "";
	document.querySelector('#CboPerteneceA').options[0].selected = true;
}


function llenaCboAsigA(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubros.php?op=10',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboPerteneceA').innerHTML += `<option selected></option>`;


        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboPerteneceA').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}


function ObtenerRubroT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubros.php?op=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}


function ObtenertRubroB(){
    t1 = document.getElementById('Buscar').value;
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubros.php?op=3&cmpBusc='+t1,
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
                                        <strong>s!Alerta¡</strong>${res.data}
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


function SaveRubro()
{
    if (ValidaDatos() == 1){
        $('#ErrorCodRubro').empty();
        $('#CodRubro').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboPerteneceA').empty();
        $('#CboPerteneceA').css("border","1px solid #CED4DA");
        axios({
        method:'POST',
        url:'../Ctr/ctrprCatRubros.php',
        data: {
            "CodRubro": document.getElementById('CodRubro').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "PerteneceA": document.getElementById('CboPerteneceA').value
        }
        }).then(res=>{
            console.log(res.data);
            ObtenerRubroT();
             $('#frmCatRubros').modal('hide');
        }).catch (error=>{
            console.error(error);
        });
    }
    else{
        $('#ErrorCodRubro').empty();
        $('#CodRubro').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboPerteneceA').empty();
        $('#CboPerteneceA').css("border","1px solid #CED4DA");
        if (document.getElementById('CodRubro').value.length == 0){
            document.getElementById('ErrorCodRubro').innerHTML = "";
            $('#CodRubro').css("border","2px solid red");
            document.getElementById('ErrorCodRubro').innerHTML += `${strRsp}`;
          }
          if (document.getElementById('Descripcion').value.length == 0){
            document.getElementById('ErrorDescripcion').innerHTML = "";
            $('#Descripcion').css("border","2px solid red");
            document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
          }
          if (document.getElementById('CboPerteneceA').value.length == 0){
            document.getElementById('ErrorCboPerteneceA').innerHTML = "";
            $('#CboPerteneceA').css("border","2px solid red");
            document.getElementById('ErrorCboPerteneceA').innerHTML += `${strRsp3}`;
          }
    }
}

function DeleteRubro()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrprCatRubros.php?CodRubro='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
            //llenarTabla();
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateRubro1()
{
    $('#ErrorCodRubro').empty();
    $('#CodRubro').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboPerteneceA').empty();
    $('#CboPerteneceA').css("border","1px solid #CED4DA");
     axios({
            method:'GET',
            url:'../Ctr/ctrprCatRubros.php?op=2&CodRubro='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodRubro').value = this.uneg[0][0].CodRubro;
            document.getElementById('Descripcion').value = this.uneg[0][0].Descripcion;
            document.getElementById('CboPerteneceA').value = this.uneg[0][0].PerteneceA;
            document.getElementById('CodRubro').disabled = true;
        }).catch (error=>{
            console.error(error);
    });
}


function UpdateRubro2()
{
    if (ValidaDatos() == 1) {
        $('#ErrorCodRubro').empty();
        $('#CodRubro').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboPerteneceA').empty();
        $('#CboPerteneceA').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrprCatRubros.php',
        data: {
            "CodRubro": document.getElementById('CodRubro').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "PerteneceA": document.getElementById('CboPerteneceA').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenerRubroT();
             $('#frmCatRubros').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
} else{
    $('#ErrorCodRubro').empty();
    $('#CodRubro').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboPerteneceA').empty();
    $('#CboPerteneceA').css("border","1px solid #CED4DA");
    if (document.getElementById('CodRubro').value.length == 0){
        document.getElementById('ErrorCodRubro').innerHTML = "";
        $('#CodRubro').css("border","2px solid red");
        document.getElementById('ErrorCodRubro').innerHTML += `${strRsp}`;
      }
      if (document.getElementById('Descripcion').value.length == 0){
        document.getElementById('ErrorDescripcion').innerHTML = "";
        $('#Descripcion').css("border","2px solid red");
        document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
      }
      if (document.getElementById('CboPerteneceA').value.length == 0){
        document.getElementById('ErrorCboPerteneceA').innerHTML = "";
        $('#CboPerteneceA').css("border","2px solid red");
        document.getElementById('ErrorCboPerteneceA').innerHTML += `${strRsp3}`;
      }
}
}


function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatUNegocios.php?op=4&CodPantalla=P001',
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
    $('#ErrorCodRubro').empty();
    $('#CodRubro').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboPerteneceA').empty();
    $('#CboPerteneceA').css("border","1px solid #CED4DA");
   document.getElementById('CodRubro').value = "";
   document.getElementById('Descripcion').value = "";
   document.querySelector('#CboPerteneceA').options[0].selected = true;
   document.getElementById('CodRubro').disabled = false;
  // ObtenerRubroT();
}

function llenarTabla()
{
    $("#tblUNeg tr").remove();
    document.querySelector('#tblUNeg thead').innerHTML +=
        `<tr>
            <th style="width: 100px;">Codigo</th>
            <th>Nombre</th>
            <th>Pertenece A</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblUNeg tbody').innerHTML +=
        `<tr>
                <td style="width: 100px;">${uneg[i][0].CodRubro}</td>
                <td>${uneg[i][0].Descripcion}</td>
                <td>${uneg[i][0].Nombre}</td>
         </tr>`;
    }
}


function ValidaDatos()
{
    var dv = 1;
    strRsp = "";
    strRsp2 = "";
    strRsp3 = "";

    if (document.getElementById('CodRubro').value.length == 0){
         strRsp += 'Capture el código del rubro.';
         dv = 0;
    }

    if (document.getElementById('Descripcion').value.length == 0){
        strRsp2 += 'Capture la descripcion del rubro.';
        dv = 0;
    }

    if (document.getElementById('CboPerteneceA').value.length == 0){
        strRsp3 += 'Capture a quien pertenece.';
        dv = 0;
    }

   return dv;
}
