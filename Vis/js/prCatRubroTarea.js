var dato;
var CodRubroAnt;
$(document).ready(function(){//cuando este lista la página
    $('#tblUNeg tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected'); 
    });
    ObtenerSeguridad(); 
    llenaCboGMtto();
    llenaCboRubros();
    ObtenerTareasT();
});
  
var uneg = [];
var opcion = 0;
var strRsp = "";

function setOpcion(op)
{
    opcion = op;
     //document.getElementById('CodRubro').disabled = false;
     //document.getElementById('Descripcion').disabled = false;
     //document.getElementById('CboPerteneceA').disabled = false;

    if (opcion == 2)
    {
        if (dato.length > 0 )
        {
            llenaCboRubros2();
            UpdateRubroTarea1();
            $('#frmCatTareaRubro').modal('show');
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
     
    if (opcion == 3)
    {
        if (dato.length > 0 )  {           
            $("#ModPregSiNo").html("¿Estás seguro de eliminar la <strong>tarea "+dato+"</strong>?")
            $('#PreguntaSiNo').modal('show');
        }     
        else {
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
        case 1: SaveTarea(); break;
        case 2: UpdateRubroTarea2();
         break;
        case 3: DeleteRubroTarea();  // Elimina el registro
                $('#PreguntaSiNo').modal('hide');
                ObtenerTareasT();  //llena la tabla de nuevo
         break;
    }
   //document.getElementById('CodRubro').value = "";
   //document.getElementById('Descripcion').value = "";
   //document.querySelector('#CboPerteneceA').options[0].selected = true;   
}


function CargarTodos()
{
    document.querySelector('#CboGteMatto').options[0].selected = true
    document.querySelector('#CboRubroSlc').options[0].selected = true
    llenaCboGMtto();
    llenaCboRubros();
    ObtenerTareasT();
}

function ObtenerTareasT(){
    dato = ""; 
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubroTarea.php?op=1&CodRubro='+document.getElementById('CboRubroSlc').value,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}


function llenaCboRubros(){
    dato = ""; 
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubroTarea.php?op=10&CodGteMtto='+document.getElementById('CboGteMatto').value,
        responseType:'json'
    }).then(res=>{ 
        //console.log(res.data);
        this.uneg = res.data; 
         document.querySelector('#CboRubroSlc').innerText = ''; 
        //Lleno al cambo
        document.querySelector('#CboRubroSlc').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboRubroSlc').innerHTML +=
               `<option value="${uneg[i][0].CodRubro}">${uneg[i][0].Descripcion}</option>`;         
        }
    }).catch (error=>{ 
        console.error(error);
    });
}


function llenaCboRubros2(){  
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubroTarea.php?op=10&CodGteMtto='+document.getElementById('CboCodGteMatto').value,
        responseType:'json'
    }).then(res=>{ 
        //console.log(res.data);
        this.uneg = res.data; 
         document.querySelector('#CboCodRubro').innerText = ''; 
        //Lleno al cambo
        
         document.querySelector('#CboCodRubro').innerHTML += `<option selected></option>`;
         
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboCodRubro').innerHTML +=
               `<option value="${uneg[i][0].CodRubro}">${uneg[i][0].Descripcion}</option>`;         
        }
    }).catch (error=>{ 
        console.error(error);
    });
}


function llenaCboGMtto()
{
     dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubroTarea.php?op=11',
        responseType:'json'
    }).then(res=>{ 
        //console.log(res.data);
        this.uneg = res.data; 
         document.querySelector('#CboGteMatto').innerText = ''; 
         document.querySelector('#CboCodGteMatto').innerText = ''; 
        //Lleno al cambo
        document.querySelector('#CboGteMatto').innerHTML += `<option selected></option>`;
        document.querySelector('#CboCodGteMatto').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboGteMatto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;   
          document.querySelector('#CboCodGteMatto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`; 
        }
    }).catch (error=>{ 
        console.error(error);
    });
}



function SaveTarea()
{
    if (ValidaDatos() == 1){
        $('#ErrorCodTarea').empty();
        $('#CodTarea').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboCodGteMatto').empty();
        $('#CboCodGteMatto').css("border","1px solid #CED4DA");
        $('#ErrorCboCodRubro').empty();
        $('#CboCodRubro').css("border","1px solid #CED4DA");
        axios({
        method:'POST',
        url:'../Ctr/ctrprCatRubroTarea.php',
        data: {
            "CodTarea": document.getElementById('CodTarea').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "CodRubro_fk": document.getElementById('CboCodRubro').value
        }
        }).then(res=>{
            console.log(res.data);
            ObtenerTareasT();
            document.getElementById('CodTarea').value = "";
            document.getElementById('Descripcion').value = "";
            document.querySelector('#CboCodGteMatto').options[0].selected = true;   
            document.querySelector('#CboCodRubro').options[0].selected = true;  

            document.getElementById('CodTarea').disabled = false;
            $('#frmCatTareaRubro').modal('hide');
        }).catch (error=>{
            console.error(error);
        });
    }
    else{
        $('#ErrorCodTarea').empty();
        $('#CodTarea').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboCodGteMatto').empty();
        $('#CboCodGteMatto').css("border","1px solid #CED4DA");
        $('#ErrorCboCodRubro').empty();
        $('#CboCodRubro').css("border","1px solid #CED4DA");
        if (document.getElementById('CodTarea').value.length == 0){
            document.getElementById('ErrorCodTarea').innerHTML = "";
            $('#CodTarea').css("border","2px solid red");
            document.getElementById('ErrorCodTarea').innerHTML += `${strRsp}`;
          }
          if (document.getElementById('Descripcion').value.length == 0){
            document.getElementById('ErrorDescripcion').innerHTML = "";
            $('#Descripcion').css("border","2px solid red");
            document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
          }
          if (document.getElementById('CboCodGteMatto').value.length == 0){
            document.getElementById('ErrorCboCodGteMatto').innerHTML = "";
            $('#CboCodGteMatto').css("border","2px solid red");
            document.getElementById('ErrorCboCodGteMatto').innerHTML += `${strRsp3}`;
          }
          if (document.getElementById('CboCodRubro').value.length == 0){
            document.getElementById('ErrorCboCodRubro').innerHTML = "";
            $('#CboCodRubro').css("border","2px solid red");
            document.getElementById('ErrorCboCodRubro').innerHTML += `${strRsp4}`;
          }
    }
}


function UpdateRubroTarea1()
{ 
     axios({
            method:'GET',
            url:'../Ctr/ctrprCatRubroTarea.php?op=2&CodTarea='+dato,
            responseType:'json'
        }).then(res=>{
            console.log(res.data); 
            this.uneg = res.data;            
            document.getElementById('CodTarea').value = this.uneg[0][0].CodTarea;
            document.getElementById('Descripcion').value = this.uneg[0][0].Descripcion;            
            document.getElementById('CboCodGteMatto').value = this.uneg[0][0].CodGteMtto;            
            //llenaCboRubros2(); 
            CodRubroAnt = this.uneg[0][0].CodRubro_fk;
            document.getElementById('CboCodRubro').value = this.uneg[0][0].CodRubro_fk;
            document.getElementById('CodTarea').disabled = true;
            
        }).catch (error=>{
            console.error(error);
    });
}

function UpdateRubroTarea2()
{
    if (ValidaDatos() == 1) {
        $('#ErrorCodTarea').empty();
        $('#CodTarea').css("border","1px solid #CED4DA");
        $('#ErrorDescripcion').empty();
        $('#Descripcion').css("border","1px solid #CED4DA");
        $('#ErrorCboCodGteMatto').empty();
        $('#CboCodGteMatto').css("border","1px solid #CED4DA");
        $('#ErrorCboCodRubro').empty();
        $('#CboCodRubro').css("border","1px solid #CED4DA");
    axios({
        method:'PUT',
        url:'../Ctr/ctrprCatRubroTarea.php',
        data: {
            "CodTarea": document.getElementById('CodTarea').value,
            "Descripcion": document.getElementById('Descripcion').value,
            "CodRubro_fk": document.getElementById('CboCodRubro').value,
            "CodRubroAnt": CodRubroAnt
        }
    }).then(res=>{
        console.log(res.data);
        ObtenerTareasT();
        $('#frmCatTareaRubro').modal('hide');
        closeMd();
    }).catch (error=>{
        console.error(error);
    });
}else{
    $('#ErrorCodTarea').empty();
    $('#CodTarea').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboCodGteMatto').empty();
    $('#CboCodGteMatto').css("border","1px solid #CED4DA");
    $('#ErrorCboCodRubro').empty();
    $('#CboCodRubro').css("border","1px solid #CED4DA");
    if (document.getElementById('CodTarea').value.length == 0){
        document.getElementById('ErrorCodTarea').innerHTML = "";
        $('#CodTarea').css("border","2px solid red");
        document.getElementById('ErrorCodTarea').innerHTML += `${strRsp}`;
      }
      if (document.getElementById('Descripcion').value.length == 0){
        document.getElementById('ErrorDescripcion').innerHTML = "";
        $('#Descripcion').css("border","2px solid red");
        document.getElementById('ErrorDescripcion').innerHTML += `${strRsp2}`;
      }
      if (document.getElementById('CboCodGteMatto').value.length == 0){
        document.getElementById('ErrorCboCodGteMatto').innerHTML = "";
        $('#CboCodGteMatto').css("border","2px solid red");
        document.getElementById('ErrorCboCodGteMatto').innerHTML += `${strRsp3}`;
      }
      if (document.getElementById('CboCodRubro').value.length == 0){
        document.getElementById('ErrorCboCodRubro').innerHTML = "";
        $('#CboCodRubro').css("border","2px solid red");
        document.getElementById('ErrorCboCodRubro').innerHTML += `${strRsp4}`;
      }
}
}


function DeleteRubroTarea()
{
    axios({
        method:'DELETE',
        url:'../Ctr/ctrprCatRubroTarea.php?CodTarea='+dato,
        responseType:'json'
        }).then(res=>{
            console.log(res.data);
            //llenarTabla();
        }).catch (error=>{
            console.error(error);
    });
}



function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrprCatRubroTarea.php?op=4&CodPantalla=P009',
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



function ValidaDatos(){
    var dv = 1;
    strRsp = "";
    strRsp2 = "";
    strRsp3 = "";
    strRsp4 = "";
    if (document.getElementById('CodTarea').value.length == 0){
         strRsp += 'Capture el código del registro.';
         dv = 0;
    }
    if (document.getElementById('Descripcion').value.length == 0){
        strRsp2 += 'Capture el descripción del registro.';
        dv = 0;
    }
    if (document.getElementById('CboCodGteMatto').value.length == 0){
        strRsp3 += 'Seleccione un Gte de Matto.';
        dv = 0;
    }
    if (document.getElementById('CboCodRubro').value.length == 0){
        strRsp4 += 'Seleccione un Rubro.';
        dv = 0;
    }
   return dv;
}





function llenarTabla()
{
    $("#tblUNeg tr").remove();
    document.querySelector('#tblUNeg thead').innerHTML +=
        `<tr>
            <th style="width: 100px;">Codigo</th>
            <th>Descripcion</th>
            <th>Rubro</th>
            <th>Valor en Rubro</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblUNeg tbody').innerHTML +=
        `<tr>
                <td style="width: 100px;">${uneg[i][0].CodTarea}</td>
                <td>${uneg[i][0].Descripcion}</td>
                <td>${uneg[i][0].Rubro}</td>
                <td>${uneg[i][0].ValorEnRubro}</td>
         </tr>`;
    }
}



function closeMd()
{
    $('#ErrorCodTarea').empty();
    $('#CodTarea').css("border","1px solid #CED4DA");
    $('#ErrorDescripcion').empty();
    $('#Descripcion').css("border","1px solid #CED4DA");
    $('#ErrorCboCodGteMatto').empty();
    $('#CboCodGteMatto').css("border","1px solid #CED4DA");
    $('#ErrorCboCodRubro').empty();
    $('#CboCodRubro').css("border","1px solid #CED4DA");
   ObtenerTareasT();
   document.getElementById('CodTarea').value = "";
   document.getElementById('Descripcion').value = "";
   document.querySelector('#CboCodGteMatto').options[0].selected = true;   
   document.querySelector('#CboCodRubro').options[0].selected = true;  
  
   document.getElementById('CodTarea').disabled = false;
}
