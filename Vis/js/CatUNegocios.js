var dato;
$(document).ready(function(){//cuando este lista la página
    $('#tblUNeg tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad();
    ObtenertUNegT();
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op)
{
    opcion = op;
     document.getElementById('CodUNegocios').disabled = false;
     document.getElementById('Nombre').disabled = false;
     document.getElementById('Obs').disabled = false;

    if (opcion == 2)
    if(dato.length > 0){
        UpdateUNeg1();
        $('#frmUNegocio').modal('show');
        document.getElementById('txtMostrar').innerHTML = "";
    }else {
        document.getElementById('txtMostrar').innerHTML = "";
        $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
        document.getElementById('txtMostrar').innerHTML += `
                                      <div class="alert alert-danger" role="alert">
                                      <strong> Seleccione un elemento para editar </strong>
                                      </div>`;
      }
    if (opcion == 3)
    if(dato.length >0){
        $("#ModPregSiNo").html("¿Estás seguro de eliminar la <strong>Unidad "+dato+"</strong>?")
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

function drvOperacion()
{
    switch(opcion)
    {
        case 1: SaveUNeg(); break;
        case 2: UpdateUNeg2();
         break;
        case 3: DeleteUNeg();  // Elimina el registro
                $('#PreguntaSiNo').modal('hide');
                ObtenertUNegT(); //llena la tabla de nuevo
         break;
    }
}



function ObtenertUNegT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatUNegocios.php',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}

function ObtenertUNeg1(){
    t1 = document.getElementById('Buscar').value;
    axios({
        method:'GET',
        url:'../Ctr/ctrCatUNegocios.php?cmpBusc='+t1,
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


function SaveUNeg()
{
    if (ValidaDatos() == 1){
        $('#ErrorCodUNegocios').empty();
        $('#CodUNegocios').css("border","1px solid #CED4DA");
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        axios({
        method:'POST',
        url:'../Ctr/ctrCatUNegocios.php',
        data: {
            CodUNegocio: document.getElementById('CodUNegocios').value,
            Nombre: document.getElementById('Nombre').value,
            Obs: document.getElementById('Obs').value
        }
        }).then(res=>{
            console.log(res.data);
            ObtenertUNegT();
             $('#frmUNegocio').modal('hide');
        }).catch (error=>{
            console.error(error);
        });
    }
    else{
        $('#ErrorCodUNegocios').empty();
        $('#CodUNegocios').css("border","1px solid #CED4DA");
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        if (document.getElementById('CodUNegocios').value.length == 0){
            document.getElementById('ErrorCodUNegocios').innerHTML = "";
            $('#CodUNegocios').css("border","2px solid red");
            document.getElementById('ErrorCodUNegocios').innerHTML += `${strRsp}`;
        }
        if (document.getElementById('Nombre').value.length == 0){
            document.getElementById('ErrorNombre').innerHTML = "";
            $('#Nombre').css("border","2px solid red");
            document.getElementById('ErrorNombre').innerHTML += `${strRsp1}`;
        } 
    }
}

function DeleteUNeg()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatUNegocios.php?CodUNegocio='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
            //llenarTabla();
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateUNeg1()
{
    $('#ErrorCodUNegocios').empty();
    $('#CodUNegocios').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatUNegocios.php?cmpBusc='+dato+'&unReg=1',
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodUNegocios').value = this.uneg[0][0].CodUNegocio;
            document.getElementById('Nombre').value = this.uneg[0][0].Nombre;
            document.getElementById('Obs').value = this.uneg[0][0].Obs;
            document.getElementById('CodUNegocios').disabled = true;
        }).catch (error=>{
            console.error(error);
    });
}


function UpdateUNeg2()
{
    if (ValidaDatos() == 1) {
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatUNegocios.php',
        data: {
            CodUNegocio: document.getElementById('CodUNegocios').value,
            Nombre: document.getElementById('Nombre').value,
            Obs: document.getElementById('Obs').value
        }
    }).then(res=>{
        console.log(res.data);
        ObtenertUNegT();
         $('#frmUNegocio').modal('hide');
    }).catch (error=>{
        console.error(error);
    });
}else{
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    if (document.getElementById('Nombre').value.length == 0){
        document.getElementById('ErrorNombre').innerHTML = "";
        $('#Nombre').css("border","2px solid red");
        document.getElementById('ErrorNombre').innerHTML += `${strRsp1}`;
    } 
}
}


function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatUNegocios.php?CodPantalla=P001&CodPerfil='+document.getElementById('CodPerfil').value,
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
    $('#ErrorCodUNegocios').empty();
    $('#CodUNegocios').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
   ObtenertUNegT();
   document.getElementById('CodUNegocios').value = "";
   document.getElementById('Nombre').value = "";
   document.getElementById('Obs').value = "";
   document.getElementById('CodUNegocios').disabled = false;
}

function llenarTabla()
{
    $("#tblUNeg tr").remove();
    document.querySelector('#tblUNeg thead').innerHTML +=
        `<tr>
            <th style="width: 100px;">Codigo</th>
            <th>Nombre</th>
            <th style="width: 400px;">Obs</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblUNeg tbody').innerHTML +=
        `<tr>
                <td style="width: 100px;">${uneg[i][0].CodUNegocio}</td>
                <td>${uneg[i][0].Nombre}</td>
                <td style="width: 400px;">${uneg[i][0].Obs}</td>
         </tr>`;
    }
}


function ValidaDatos()
{
    var dv = 1;
    strRsp = "";
    strRsp1 = "";

    if (document.getElementById('CodUNegocios').value.length == 0){
         strRsp += 'Capture el código de la unidad.';
         dv = 0;
    }

    if (document.getElementById('Nombre').value.length == 0){
        strRsp1 += 'Capture el nombre de la unidad.';
        dv = 0;
    }

   return dv;
}
