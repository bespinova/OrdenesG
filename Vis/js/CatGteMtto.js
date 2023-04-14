 var dato;
$(document).ready(function(){//cuando este lista la página
    $('#tblOsOrd tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    });
    ObtenerSeguridad()
    ObtenertOsT();
});

function setOpcion(op)
{
    opcion = op;

    CodGteMtto: document.getElementById('CodGteMtto').disabled = false;
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
        $("#ModPregSiNo").html("¿Estás seguro de eliminar al <strong>Gerente "+dato+"</strong>?")
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

function drvOperacion()
{
    switch(opcion)
    {
        case 1: ActAcciones(); break;
        case 2: updateCatGto();
         break;
        case 3:
              DeletCatArea();
              $('#PreguntaSiNo').modal('hide');
              ObtenertOsT();
         break;
    }
}

function ActAcciones(){
if (ValidaDatos() == 1) {
    $('#ErrorCodGteMtto').empty();
    $('#CodGteMtto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
  axios({
  method:'POST',
  url:'../Ctr/ctrCatGteMtto.php',
  data: {
      codGteMtto: document.getElementById('CodGteMtto').value,
      Nombre: document.getElementById('Nombre').value,
      Email: document.getElementById('cmpEmail').value
  }
  }).then(res=>{
      console.log(res.data);
        ObtenertOsT();
       $('#frmSolicita').modal('hide');
  }).catch (error=>{
      console.error(error);
  });
}  else{
    $('#ErrorCodGteMtto').empty();
    $('#CodGteMtto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    if (document.getElementById('CodGteMtto').value.length == 0){
        document.getElementById('ErrorCodGteMtto').innerHTML = "";
        $('#CodGteMtto').css("border","2px solid red");
        document.getElementById('ErrorCodGteMtto').innerHTML += `${strRsp1}`;
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
}
}

function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrCatGteMtto.php?CodPantalla=P003',
        responseType:'json'
    }).then(res=>{
        this.uneg = res.data;
        //console.log("Checar - > " +res.data);
        document.getElementById('cmdAgregar').disabled = (uneg[0][0].Acceso == 1)?false:true;
        document.getElementById('cmdEditar').disabled  = (uneg[1][0].Acceso == 1)?false:true;
        document.getElementById('cmdEliminar').disabled = (uneg[2][0].Acceso == 1)?false:true;
    }).catch (error=>{
        console.error(error);
    });
}

function DeletCatArea()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrCatGteMtto.php?CodGte='+dato,
        responseType:'json'
        }).then(res=>{
            //console.log(res.data);
            //ObtenertOsT();
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateSolicita()
{
    $('#ErrorCodGteMtto').empty();
    $('#CodGteMtto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
    axios({
            method:'GET',
            url:'../Ctr/ctrCatGteMtto.php?varCodGte='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            document.getElementById('CodGteMtto').value = this.uneg[0][0].CodGteMtto;
            document.getElementById('Nombre').value = this.uneg[0][0].Nombre;
            document.getElementById('cmpEmail').value = this.uneg[0][0].Email;
            document.getElementById('CodGteMtto').disabled =true;
        }).catch (error=>{
            console.error(error);
    });
}

function updateCatGto()
{
	if (ValidaDatos()== 1){
        $('#ErrorNombre').empty();
        $('#Nombre').css("border","1px solid #CED4DA");
        $('#ErrorcmpEmail').empty();
        $('#cmpEmail').css("border","1px solid #CED4DA");					 
    axios({
        method:'PUT',
        url:'../Ctr/ctrCatGteMtto.php',
        data: {
          CodGteMtto: document.getElementById('CodGteMtto').value,
          Nombre: document.getElementById('Nombre').value,
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
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
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
  }		
}

function closeMd()
{
    $('#ErrorCodGteMtto').empty();
    $('#CodGteMtto').css("border","1px solid #CED4DA");
    $('#ErrorNombre').empty();
    $('#Nombre').css("border","1px solid #CED4DA");
    $('#ErrorcmpEmail').empty();
    $('#cmpEmail').css("border","1px solid #CED4DA");
   document.getElementById('CodGteMtto').disabled = false;
   document.getElementById('CodGteMtto').value = "";
   document.getElementById('Nombre').value = "";
   document.getElementById('cmpEmail').value = "";
   ObtenertOsT()
}
// TODO: se agrego validacion para tabla vacia
function ObtenertOsT(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrCatGteMtto.php',
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
                <th>Código</th>
                <th>Nombre</th>
                <th>Email</th
              </tr>
          </thead>`
          document.getElementById('tblOsOrd').innerHTML +=
            `<tr>
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
            <th>Cod. Gerente de Mtto</th>
            <th>Nombre</th>
            <th>Email</th>
        </tr>`;
    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblOsOrd tbody').innerHTML +=
        `<tr>
                <td>${uneg[i][0].CodGteMtto}</td>
                <td>${uneg[i][0].Nombre}</td>
                <td>${uneg[i][0].Email}</td>
         </tr>`;
    }
}
function busquedArea(){
  varBsq = document.getElementById('IdBuscar').value;
  axios({
      method:'GET',
      url:'../Ctr/ctrCatGteMtto.php?cmpBusc='+varBsq,
      responseType:'json'
  }).then(res=>{
      console.log();
        if(isObject(res.data)){
          this.uneg = res.data;
          llenarTabla();
        }else {
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
    strRsp3 = "";

    if (document.getElementById('CodGteMtto').value.length == 0){
         strRsp1 += 'Capture el código del gerente.';
         dv = 0;
    }

    if (document.getElementById('Nombre').value.length == 0){
        strRsp2 += 'Capture el nombre del gerente.';
        dv = 0;
    }
    if (document.getElementById('cmpEmail').value.length == 0){
        strRsp3 += 'Capture el email del gerente.';
        dv = 0;
    }
   return dv;
}
