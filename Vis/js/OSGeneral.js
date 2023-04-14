/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var dato;
var CodGetMattoSlc;
var EstatusDocSlc;
var CodGteMattoSsc;
var CodSolicitante;

var MaqPSlc = new Array();
var MaqPDlt = new Array();




$(document).ready(function(){//cuando este lista la página
    $('#tblOsG tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      CodGetMattoSlc = $(this).find('td:nth-child(10)').html();
      EstatusDocSlc = $(this).find('td:nth-child(8)').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');      
   

      //document.getElementById('cmdEditar').disabled = false;
      //document.getElementById('cmdEliminar').disabled = false;
      //document.getElementById('cmdAtender').disabled = false;
      //document.getElementById('cmdTerminar').disabled = false;
      //document.getElementById('cmdLiberar').disabled = false;
    });

    document.getElementById('FechaIni').value=SetFechaActual(1);
    document.getElementById('FechaFin').value=SetFechaActual(3);
    CodGteMattoSsc = document.getElementById('CodGteMatto').value.trim();
    CodSolicitante = document.getElementById('CodSolicitante').value.trim();

    document.getElementById('CboAsgMtto').disabled =  (CodGteMattoSsc.length > 0) ? true : false;
    document.getElementById('CboFltSol').disabled =  (CodSolicitante.length > 0) ? true : false;
     
    

    ObtenerSeguridad();
    ObtenertOsT();
    llenaCboCUneg();
    llenaCboTpOS();
    //llenaCboCSol();
    //llenaCboArea();
    llenaCboAsigA();
    ////llenaCboAsigA2();

    //document.getElementById('cmdEditar').disabled = true;
    //document.getElementById('cmdEliminar').disabled = true;
    //document.getElementById('cmdAtender').disabled = true;
    //document.getElementById('cmdTerminar').disabled = true;
   // document.getElementById('cmdLiberar').disabled = true;

});



var uneg = [];
var opcion = 0;
var strRsp = "";


function SlcFec()
{
   ObtenertOsT();
}

function SlcEdoDoc()
{
   ObtenertOsT();
}

function SlcPriDoc()
{
   ObtenertOsT();
}

function SlcTpMtto()
{
   ObtenertOsT();
}

function SlcUNeg()
{
   llenaCboCSol2(document.querySelector('#CboFltUNeg').value);
   ObtenertOsT();
}

function SlcAsMto()
{
   ObtenertOsT();
}

function SlcSolt()
{
   ObtenertOsT();
}

function rstFiltros()
{
     document.querySelector('#CboEdoDoc').options[0].selected = true;
     document.querySelector('#CboFltUNeg').options[0].selected = true;
     document.querySelector('#CboPriDoc').options[0].selected = true;
     document.querySelector('#CboAsgMtto').options[0].selected = true;
     document.querySelector('#CboTpMtto').options[0].selected = true;
     //document.querySelector('#CboFltSol').options[0].selected = true;
     document.querySelector('#CboFltSol').innerText = '';

     document.getElementById('FechaIni').value=SetFechaActual(1);
     document.getElementById('FechaFin').value=SetFechaActual(3);
     ObtenertOsT();
}

function SetFechaActual(tipo)
{
  var fecha = new Date(); //Fecha actual
  fecha.setDate(fecha.getDate() - 365);
  var mes = fecha.getMonth()+1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  var hr = fecha.getHours();
  var min = fecha.getMinutes();
  var seg = fecha.getSeconds();

  var dv = "";

    if(dia<10)
      dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
      mes='0'+mes //agrega cero si el menor de 10

  switch (tipo){
      case 1 : dv = ano+"-"+mes+"-"+dia; break;
      case 2 :
          fecha.setDate(fecha.getDate()+365);
          mes = fecha.getMonth()+1; //obteniendo mes
          dia = fecha.getDate(); //obteniendo dia
          ano = fecha.getFullYear();
                 if(dia<10)
                    dia='0'+dia; //agrega cero si el menor de 10
                 if(mes<10)
                    mes='0'+mes
          dv = ano+"-"+mes+"-"+dia+ " "+hr+":"+min+":"+seg; break;
      case 3 :
          fecha.setDate(fecha.getDate()+365);
          mes = fecha.getMonth()+1; //obteniendo mes
          dia = fecha.getDate(); //obteniendo dia
          ano = fecha.getFullYear();
                 if(dia<10)
                    dia='0'+dia; //agrega cero si el menor de 10
                 if(mes<10)
                    mes='0'+mes
          dv =  ano+"-"+mes+"-"+dia;
      break;
  }
  return dv
}

function closeMd(){
    $('#ErrorUNegocio').empty();
    $('#CboUneg').css("border","1px solid #CED4DA");
    $('#ErrorSol').empty();
    $('#CboSol').css("border","1px solid #CED4DA");
    $('#ErrorJmtto').empty();
    $('#CboAsigA').css("border","1px solid #CED4DA");
    $('#ErrorArea').empty();
    $('#CboArea').css("border","1px solid #CED4DA");
    $('#ErrorDesfa').empty();
    $('#DscFallo').css("border","1px solid #CED4DA");
    $('#ErrorCboAsigA2').empty();
    $('#CboAsigA2').css("border","1px solid #CED4DA");
    $('#ErrorlstMaqP').empty();
    $('#lstMaqP').css("border","1px solid #CED4DA");
    $('#ErrorDscAtendido').empty();
    $('#DscAtendido').css("border","1px solid #CED4DA");
    $('#ErrorFechaTermino').empty();
    $('#FechaTermino').css("border","1px solid #CED4DA");
    $('#ErrorDscTermino').empty();
    $('#DscTermino').css("border","1px solid #CED4DA");
    $('#ErrorDscLiberacion').empty();
    $('#DscLiberacion').css("border","1px solid #CED4DA");
   document.getElementById('CboUneg').value = "";
   document.getElementById('CboSol').value = "";
   document.getElementById('CboAsigA').value ="";
   document.getElementById('CboArea').value = "";
   document.getElementById('DscFallo').value = "";
   document.getElementById('CboAsigA2').value ="";
   document.getElementById('lstMaqP').value ="";
   document.getElementById('DscAtendido').value = "";
   document.getElementById('FechaTermino').value = "";
   document.getElementById('DscTermino').value ="";
   document.getElementById('DscLiberacion').value ="";
}

function setOpcion(op)
{
    opcion = op;  //alert(op);
    if (opcion == 1)
        {
          //document.querySelector('#CboUneg').innerText = '';
          document.querySelector('#CboUneg').options[0].selected = true;
          document.querySelector('#CboSol').innerText = '';
          document.querySelector('#CboArea').innerText = '';
          //document.querySelector('#CboSol').options[0].selected = true;
          //document.querySelector('#CboArea').options[0].selected = true;

          if (CodGteMattoSsc.length > 0) {
            document.getElementById("CboAsigA").value = CodGteMattoSsc;
            document.getElementById('CboAsigA').disabled = true;
          }else {
            document.querySelector('#CboAsigA').options[0].selected = true;
            document.getElementById('CboAsigA').disabled = false;
          }

          document.querySelector('#CboTipoMatto').options[0].selected = true;
          document.querySelector('#CboPrioridad').options[0].selected = true;
          document.getElementById('DscFallo').value = '';
          document.getElementById('FechaExp').value=SetFechaActual(3);
          //nombre_formulario.nombre_select.options[index].selected = true/false
           document.getElementById('cmdGuardar').value = '';
           //llenaCboAsigA2();          
        }
    else if(dato.length > 0)
    {
       if (opcion == 2){
          //Editar
          switch(EstatusDocSlc){
              case 'Aceptado':
              case 'Rechazado':
                  BsqOsGEdit(3);
                  $('#frmAcepOsG').modal('show');
              break;
              case 'Terminado':
                  BsqOsGEdit(2);
                 $('#frmTerOsG').modal('show');
              break;
              case 'Atendido':
                 document.querySelector('#CboAsigA2').innerText = '';
                 BsqOsGEdit(1);
                 $('#frmATOsG').modal('show');
              break;
              case 'Creado':
                document.getElementById('txtMostrar').innerHTML = "";
                $("#txtMostrar").slideDown(50).delay(5000).slideUp(500);
                document.getElementById('txtMostrar').innerHTML += `
                                              <div class="alert alert-danger" role="alert">
                                              Edición no implementada para el estatus <strong>Creado</strong> de la OS. Se recomienda <strong>eliminar la OS y volverla a crear</strong>
                                              </div>`;
              break;
          }
       }
       if (opcion == 3){
           if(EstatusDocSlc == 'Creado'){
            $("#ModPregSiNo").html("¿Estás seguro de eliminar la <strong>Ord. de Servicio "+dato+" </strong>?")
            $('#PreguntaSiNo').modal('show');
//               DeleteOSG();
           }
           else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                             No se puede eliminar la OS que su estatus sea diferente de <strong>Creado</strong>.
                                          </div>`;
            }
       }
       if (opcion == 4){
           if(EstatusDocSlc == 'Creado'){
               BsqOsG(); 
               document.getElementById('FechaProm').value=SetFechaActual(3);
               document.getElementById('FechaAsigVh').value=SetFechaActual(3);               
               document.querySelector('#CboAsigA2').innerText = '';
               document.getElementById('DscAtendido').value = '';
               document.getElementById('lstMaqP').innerHTML = '';
               MaqPSlc.length = 0;
               $('#frmATOsG').modal('show');
           }
           else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                         <div class="alert alert-danger" role="alert">
                                             El OS tiene un estatus diferente a <strong>Creado</strong>.
                                          </div>`;
            }
       }
       if(opcion == 5){
           if(EstatusDocSlc == 'Atendido'){
               document.getElementById('lstMaqPAp').innerHTML = '';
               MaqPSlc.length = 0;
               BsqOsG2();
               document.getElementById('FechaTermino').value=SetFechaActual(3);
               document.getElementById('DscTermino').value = '';               
               $('#frmTerOsG').modal('show'); 
           }
           else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                               El OS tiene un estatus diferente a <strong>Atendido</strong>.
                                          </div>`;
            }

       }
       if(opcion == 6){
           if((EstatusDocSlc == 'Terminado')|| (EstatusDocSlc == 'Rechazado')){
              BsqOsG3(2);
              document.getElementById('TAceptado').checked = true;
              document.getElementById('DscLiberacion').value = '';
              $('#frmAcepOsG').modal('show');
           }
           else{
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                          El OS tiene un estatus diferente a <strong>Terminado</strong>.
                                          </div>`;
            }
       }
       if(opcion == 7){
          document.getElementById('h5t').innerHTML = 'Consultando las OS: '+dato;
          BsqOsG3(1);
          $('#frmVerOsG').modal('show');
       }
      /*if(opcion == 8){
          CargaCatUnidades();
          
         $('#LoadCatMaqP').modal('show'); 
      } */
       
   }
   else{
    document.getElementById('txtMostrar').innerHTML = "";
    $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
    document.getElementById('txtMostrar').innerHTML += `
                            <div class="alert alert-danger" role="alert">
                             <strong> Seleccione al menos una Orden de Servicio en el listado</strong>
                             </div>`;
    }
}

function AbreDlgCatUniMaqP()
{
    CargaCatUnidades();          
    $('#LoadCatMaqP').modal('show'); 
}



function drvOperacion()
{ 
    switch(opcion)
    {
        case 1:
               SaveOS();
            break;
        case 2:
             switch(EstatusDocSlc){
                case 'Aceptado':
                case 'Rechazado':
                    UpdAceptarOSG();
                    $('#frmAcepOsG').modal('show');
                break;
                case 'Terminado':
                    UpdTerminarOSG();
                break;
            case 'Atendido':
                UpdAtenderOSG();
            break;
            }
         break;
        case 3: DeleteUNeg();  // Elimina el registro
                ObtenertUNegT();  //llena la tabla de nuevo
         break;
        case 4: 
            UpdAtenderOSG();
        break;
        case 5:
            UpdTerminarOSG();
        break;
        case 6:
            UpdAceptarOSG();
        break;
    }

    //document.getElementById('cmdEditar').disabled = true;
    //document.getElementById('cmdEliminar').disabled = true;
    //document.getElementById('cmdAtender').disabled = true;
    //document.getElementById('cmdTerminar').disabled = true;
    //document.getElementById('cmdLiberar').disabled = true;
}


function ObtenerSeguridad()
{
   axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=30&CodPantalla=P100&CodPerfil='+document.getElementById('CodPerfil').value,
        responseType:'json'
    }).then(res=>{
        this.uneg = res.data;
        //console.log(this.uneg);
        document.getElementById('cmdAgregar').disabled = (uneg[0][0].Acceso == 1)?false:true;
        document.getElementById('cmdEditar').disabled  = (uneg[1][0].Acceso == 1)?false:true;
        document.getElementById('cmdEliminar').disabled = (uneg[2][0].Acceso == 1)?false:true;
        document.getElementById('cmdAtender').disabled = (uneg[3][0].Acceso == 1)?false:true;
        document.getElementById('cmdTerminar').disabled = (uneg[4][0].Acceso == 1)?false:true;
        document.getElementById('cmdLiberar').disabled = (uneg[5][0].Acceso == 1)?false:true;
        document.getElementById('cmdVerOs').disabled = (uneg[6][0].Acceso == 1)?false:true;
    }).catch (error=>{
        console.error(error);
    });
}


function ObtenertOsT(){
    Fi = document.getElementById('FechaIni').value;
    Ff = document.getElementById('FechaFin').value;
    Ed = document.getElementById('CboEdoDoc').value; 
    Pr = document.getElementById('CboPriDoc').value;
    Tm = document.getElementById('CboTpMtto').value;
    Un = document.getElementById('CboFltUNeg').value;
    Gm = (CodGteMattoSsc.length > 0)? CodGteMattoSsc : document.getElementById('CboAsgMtto').value;
    Sl = (CodSolicitante.length > 0)? CodSolicitante : document.getElementById('CboFltSol').value;
    dato = "";
   /* alert('../Ctr/ctrOSGeneral.php?op=0&Fini='+Fi+'&Ffin='+Ff+'&EdoDoc='+Ed+'&Prd='+Pr+'&Tmtto='+Tm+
                '&Uneg='+Un+'&Gmtto='+Gm+'&Solt='+Sl);
    */
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=0&Fini='+Fi+'&Ffin='+Ff+'&EdoDoc='+Ed+'&Prd='+Pr+'&Tmtto='+Tm+
                '&Uneg='+Un+'&Gmtto='+Gm+'&Solt='+Sl,
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}

//llena combo Unidad de negocios
function llenaCboCUneg(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=1',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboUneg').innerHTML += `<option selected></option>`;
        document.querySelector('#CboFltUNeg').innerHTML += `<option selected>Todos</option>`;
        for(let i=0; i < uneg.length; i++){
            document.querySelector('#CboUneg').innerHTML +=
               `<option value="${uneg[i][0].CodUNegocio}">${uneg[i][0].Nombre}</option>`;
            document.querySelector('#CboFltUNeg').innerHTML +=
               `<option value="${uneg[i][0].CodUNegocio}">${uneg[i][0].Nombre}</option>`;
         }

    }).catch (error=>{
        console.error(error);
    });
}

//LLena combo de solicitantes
function llenaCboCSol(CodUneg){
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=6&tbl=CatSolicitantes&fil='+CodUneg,
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        document.querySelector('#CboSol').innerText = '';
        //Lleno al cambo
        document.querySelector('#CboSol').innerHTML += `<option selected></option>`;

        for(let i=0; i < uneg.length; i++){
            document.querySelector('#CboSol').innerHTML +=
               `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
        }


    }).catch (error=>{
        console.error(error);
    });
}

function llenaCboCSol2(CodUneg){
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=6&tbl=CatSolicitantes&fil='+CodUneg,
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        document.querySelector('#CboFltSol').innerText = '';
        //Lleno al cambo
        document.querySelector('#CboFltSol').innerHTML += `<option selected>Todos</option>`;

        for(let i=0; i < uneg.length; i++){
            document.querySelector('#CboFltSol').innerHTML +=
               `<option value="${uneg[i][0].CodSolicitante}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}


//Llena combo Areas
function llenaCboArea(CodUneg){
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=6&tbl=CatAreas&fil='+CodUneg,
        responseType:'json'
    }).then(res=>{
       // console.log(res.data);
        this.uneg = res.data;
        document.querySelector('#CboArea').innerText = '';
        //Lleno al cambo
        document.querySelector('#CboArea').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++)
             document.querySelector('#CboArea').innerHTML +=
               `<option value="${uneg[i][0].CodArea}">${uneg[i][0].Nombre}</option>`;
    }).catch (error=>{
        console.error(error);
    });
}

function llenaCboUnidades(){    
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=8',
        responseType:'json'
    }).then(res=>{
       // console.log(res.data);
        this.uneg = res.data;
        document.querySelector('#CboAsigA2').innerText = '';
        //Lleno al cambo
        document.querySelector('#CboAsigA2').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++)
             document.querySelector('#CboAsigA2').innerHTML +=
               `<option value="${uneg[i][0].CodUnidad}">${uneg[i][0].Descripcion}</option>`;
    }).catch (error=>{
        console.error(error);
    });
}

//Llena combo Areas
function llenaCboAsigA(){
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=4',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboAsigA').innerHTML += `<option selected></option>`;
        document.querySelector('#CboAsgMtto').innerHTML += `<option selected>Todos</option>`;

        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboAsigA').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
          document.querySelector('#CboAsgMtto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
        }


    }).catch (error=>{
        console.error(error);
    });
}

function llenaCboTpOS()
{
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=7',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboTipoOS').innerHTML +=
               `<option value="${uneg[i][0].CodTipoOS}">${uneg[i][0].Descripcion}</option>`;        
        }


    }).catch (error=>{
        console.error(error);
    });
}






function llenaCboEmpledos(v_sel = ""){
    //alert(v_sel);
   axios({
        method:'GET',
        url:'../Ctr/ctrOSGeneral.php?op=6&tbl=CatEmpleados&fil='+CodGetMattoSlc,
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboAsigA2').innerHTML += `<option selected></option>`;
        sele = "";
        tiene_sele = false;
        for(let i=0; i < uneg.length; i++)
        {
            if(!tiene_sele)
            {
                if(v_sel != "")
                {
                    if(uneg[i][0].CodEmpleado == v_sel)
                    {
                        sele = " SELECTED ";
                        tiene_sele = true;
                    }
                }
                else
                    tiene_sele = true;
            }
            else
                sele = "";

             document.querySelector('#CboAsigA2').innerHTML +=
               "<option value='"+uneg[i][0].CodEmpleado+"' "+sele+">"+uneg[i][0].Nombre+"</option>";
        }

    }).catch (error=>{
        console.error(error);
    });
}


function SlcUneg(unegSlc)
{
    llenaCboCSol(unegSlc);
    llenaCboArea(unegSlc);

}



function SaveOS()
{
    if (ValidaDatosNuevo() == 1){
        $('#ErrorUNegocio').empty();
        $('#CboUneg').css("border","1px solid #CED4DA");
        $('#ErrorSol').empty();
        $('#CboSol').css("border","1px solid #CED4DA");
        $('#ErrorJmtto').empty();
        $('#CboAsigA').css("border","1px solid #CED4DA");
        $('#ErrorArea').empty();
        $('#CboArea').css("border","1px solid #CED4DA");
        $('#ErrorDesfa').empty();
        $('#DscFallo').css("border","1px solid #CED4DA");
        axios({
        method:'POST',
        url:'../Ctr/ctrOSGeneral.php',
        data: {
            "FechaExpedicion":document.getElementById('FechaExp').value,
            "TipoMatto":document.getElementById('CboTipoMatto').value,
            "CodSolicitante":document.getElementById('CboSol').value,
            "CodUNegocio":document.getElementById('CboUneg').value,
            "CodArea":document.getElementById('CboArea').value,
            "CodGteMatto":document.getElementById('CboAsigA').value,
            "Estatus":"A",
            "EstatusDoc":"1",
            "CvePrioridad":document.getElementById('CboPrioridad').value,
            "DscFallo":document.getElementById('DscFallo').value,
            "CodTipoOS":document.getElementById('CboTipoOS').value
            //CodUNegocio: document.getElementById('FechaExp').value,
            //Nombre: document.getElementById('Nombre').value,
            //Obs: document.getElementById('Obs').value
        }
        }).then(res=>{
            //console.log(res.data);
            ObtenertOsT();
             $('#frmOsG').modal('hide');
        }).catch (error=>{
            console.error(error);
        });
    }
    else{
        $('#ErrorUNegocio').empty();
        $('#CboUneg').css("border","1px solid #CED4DA");
        $('#ErrorSol').empty();
        $('#CboSol').css("border","1px solid #CED4DA");
        $('#ErrorJmtto').empty();
        $('#CboAsigA').css("border","1px solid #CED4DA");
        $('#ErrorArea').empty();
        $('#CboArea').css("border","1px solid #CED4DA");
        $('#ErrorDesfa').empty();
        $('#DscFallo').css("border","1px solid #CED4DA");
        if (document.getElementById('CboUneg').value.length == 0){
            document.getElementById('ErrorUNegocio').innerHTML = "";
            $('#CboUneg').css("border","2px solid red");
            document.getElementById('ErrorUNegocio').innerHTML += `${strRsp1}`;
        }
        if (document.getElementById('CboSol').value.length == 0){
            document.getElementById('ErrorSol').innerHTML = "";
            $('#CboSol').css("border","2px solid red");
            document.getElementById('ErrorSol').innerHTML += `${strRsp2}`;
        }
        if (document.getElementById('CboAsigA').value.length == 0){
            document.getElementById('ErrorJmtto').innerHTML = "";
            $('#CboAsigA').css("border","2px solid red");
            document.getElementById('ErrorJmtto').innerHTML += `${strRsp4}`;
        }
        if (document.getElementById('CboArea').value.length == 0){
            document.getElementById('ErrorArea').innerHTML = "";
            $('#CboArea').css("border","2px solid red");
            document.getElementById('ErrorArea').innerHTML += `${strRsp3}`;
        }
        if (document.getElementById('DscFallo').value.length == 0){
            document.getElementById('ErrorDesfa').innerHTML = "";
            $('#DscFallo').css("border","2px solid red");
            document.getElementById('ErrorDesfa').innerHTML += `${strRsp5}`;
        }
    }
        
}


function DeleteOSG()
{
   axios({
        method:'DELETE',
        url:'../Ctr/ctrOSGeneral.php?NoOs='+dato,
        responseType:'json'
        }).then(res=>{
            //console.log(res.data);
            $('#PreguntaSiNo').modal('hide');
            ObtenertOsT();
        }).catch (error=>{
            console.error(error);
    });
}



//Funcion para atender uns OS General .
function UpdAtenderOSG()
{ 
    ArVeh  = JSON.stringify(MaqPSlc); 
    ArVehD = JSON.stringify(MaqPDlt);
    
    if (ValidaAtender() == 1){
        $('#ErrorCboAsigA2').empty();
        $('#CboAsigA2').css("border","1px solid #CED4DA");
        $('#ErrorlstMaqP').empty();
        $('#lstMaqP').css("border","1px solid #CED4DA");
        $('#ErrorDscAtendido').empty();
        $('#DscAtendido').css("border","1px solid #CED4DA");
            axios({
            method:'PUT',
            url:'../Ctr/ctrOSGeneral.php',
            data: {
                "Op":"200",
                "FechaAtencion":SetFechaActual(2),
                "FechaPrometida":document.getElementById('FechaProm').value,
                "CodEmpleado":document.getElementById('CboAsigA2').value,
                "DscAtendido":document.getElementById('DscAtendido').value,
                "EstatusDoc":2,
                "NoOS":dato,
                "CodUnidad":document.getElementById('CboAsigA2').value,
                "RegOsUnMaqP":ArVeh,
                "FechaAsigMaqP":document.getElementById('FechaAsigVh').value,
                "RegVhFree":ArVehD
            }
            }).then(res=>{
                console.log(res.data);
                ObtenertOsT();
                 $('#frmATOsG').modal('hide');
            }).catch (error=>{
                console.error(error);
            });
    }
    else{
        $('#ErrorCboAsigA2').empty();
        $('#CboAsigA2').css("border","1px solid #CED4DA");
        $('#ErrorlstMaqP').empty();
        $('#lstMaqP').css("border","1px solid #CED4DA");
        $('#ErrorDscAtendido').empty();
        $('#DscAtendido').css("border","1px solid #CED4DA");
        if (document.getElementById('CboAsigA2').value.length == 0){
            document.getElementById('ErrorCboAsigA2').innerHTML = "";
            $('#CboAsigA2').css("border","2px solid red");
            document.getElementById('ErrorCboAsigA2').innerHTML += `${strRsp6}`;
        }
        if (document.getElementById('lstMaqP').value.length == 0){
            document.getElementById('ErrorlstMaqP').innerHTML = "";
            $('#lstMaqP').css("border","2px solid red");
            document.getElementById('ErrorlstMaqP').innerHTML += `${strRsp7}`;
        }
        if (document.getElementById('DscAtendido').value.length == 0){
            document.getElementById('ErrorDscAtendido').innerHTML = "";
            $('#DscAtendido').css("border","2px solid red");
            document.getElementById('ErrorDscAtendido').innerHTML += `${strRsp8}`;
        }
    }
  
}


function UpdTerminarOSG()
{
    ArVeh = JSON.stringify(MaqPSlc); 
    
    if (ValidaDatosTerOS() == 1){
        $('#ErrorFechaTermino').empty();
        $('#FechaTermino').css("border","1px solid #CED4DA");
        $('#ErrorDscTermino').empty();
        $('#DscTermino').css("border","1px solid #CED4DA");
            axios({
            method:'PUT',
            url:'../Ctr/ctrOSGeneral.php',
            data: {
                "Op":"300",
                "FecTerminoCap":SetFechaActual(2),
                "FechaTermino":document.getElementById('FechaTermino').value,
                "DscTermino":document.getElementById('DscTermino').value,
                "EstatusDoc":3,
                "NoOS":dato,
                "UnMaqP":ArVeh
            }
            }).then(res=>{
                //console.log(res.data);
                ObtenertOsT();
                 $('#frmTerOsG').modal('hide');
            }).catch (error=>{
                console.error(error);
            });
    }
    else{
        $('#ErrorFechaTermino').empty();
        $('#FechaTermino').css("border","1px solid #CED4DA");
        $('#ErrorDscTermino').empty();
        $('#DscTermino').css("border","1px solid #CED4DA");
        if (document.getElementById('FechaTermino').value.length == 0){
            document.getElementById('ErrorFechaTermino').innerHTML = "";
            $('#FechaTermino').css("border","2px solid red");
            document.getElementById('ErrorFechaTermino').innerHTML += `${strRsp9}`;
        }
        if (document.getElementById('DscTermino').value.length == 0){
            document.getElementById('ErrorDscTermino').innerHTML = "";
            $('#DscTermino').css("border","2px solid red");
            document.getElementById('ErrorDscTermino').innerHTML += `${strRsp0}`;
        }
    }
}

//Aceptar eo trabajo de una OS
function UpdAceptarOSG()
{
    var stDoc = (document.getElementById('TAceptado').checked == true)? 4 : 5;

    if (ValidaDatosAcp() == 1){
        $('#ErrorDscLiberacion').empty();
        $('#DscLiberacion').css("border","1px solid #CED4DA");
            axios({
            method:'PUT',
            url:'../Ctr/ctrOSGeneral.php',
            data: {
                "Op":"400",
                "FecLiberacion":SetFechaActual(2),
                "DscLiberacion":document.getElementById('DscLiberacion').value,
                "EstatusDoc":stDoc,
                "NoOS":dato
            }
            }).then(res=>{
                //console.log(res.data);
                ObtenertOsT();
                 $('#frmAcepOsG').modal('hide');
            }).catch (error=>{
                console.error(error);
            });
    }
    else{
        $('#ErrorDscLiberacion').empty();
        $('#DscLiberacion').css("border","1px solid #CED4DA");
        if (document.getElementById('DscLiberacion').value.length == 0){
            document.getElementById('ErrorDscLiberacion').innerHTML = "";
            $('#DscLiberacion').css("border","2px solid red");
            document.getElementById('ErrorDscLiberacion').innerHTML += `${strRsp}`;
        }
    }
}

//Buscar una os cuando el estatus es creada para cambiar a atendida
 function BsqOsG()
 {
      axios({
            method:'GET',
            url:'../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=1',
            responseType:'json'
        }).then(res=>{
            //console.log(res.data);
            this.uneg = res.data;
            document.getElementById('NoOS').value = this.uneg[0][0].Folio;
            document.getElementById('FecExp').value = uneg[0][0].FechaExpedicion.date.substring(0,10);
            document.getElementById('Uneg').value = this.uneg[0][0].UNeg;
            document.getElementById('Area').value = this.uneg[0][0].Area;
            document.getElementById('Sol').value = this.uneg[0][0].Sol;
            document.getElementById('DFallo').value   = this.uneg[0][0].DscFallo;
            document.getElementById('TipoOS').value   = this.uneg[0][0].DscTipoOS;
           if(EstatusDocSlc == 'Creado'){
               switch(this.uneg[0][0].CodTipoOS){
                   case 'OS100': llenaCboEmpledos(); 
                   document.getElementById('CboAsigA2').style.display = 'block';
                   document.getElementById('CboAsigA22').style.display = 'block';
                   document.getElementById('lstMaqP').style.display = 'none'; 
                   document.getElementById('lstMaqP1').style.display = 'none';
                   document.getElementById('btnAdd').style.display = 'none';
                   document.getElementById('btnDel').style.display = 'none';
                   document.getElementById('lblFechaAsigVh').style.display = 'none';
                   document.getElementById('FechaAsigVh').style.display = 'none';                   
                     break;
                   case 'OS200': llenaCboUnidades();                    
                   document.getElementById('CboAsigA2').style.display = 'none';
                   document.getElementById('CboAsigA22').style.display = 'none';
                   document.getElementById('lstMaqP').style.display = 'block';
                   document.getElementById('lstMaqP1').style.display = 'block';
                   document.getElementById('btnAdd').style.display = 'inline';
                   document.getElementById('btnDel').style.display = 'inline';
                   document.getElementById('lblFechaAsigVh').style.display = 'inline';
                   document.getElementById('FechaAsigVh').style.display = 'inline';
                     break; 
                   default: llenaCboEmpledos(); break;
               }
           }
               
        }).catch (error=>{
            console.error(error);
      });
 }

//Buscar una os cuando el estatus es Atendido va cambiar a terminado
function BsqOsG2()
 { 
      axios({
            method:'GET',
            url:'../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=2',
            responseType:'json'
        }).then(res=>{
            //console.log(res.data);
            this.uneg = res.data;
            document.getElementById('TipoOSTer').value = this.uneg[0][0].DscTipoOS;
            document.getElementById('NoOSEd').value = this.uneg[0][0].Folio;
            document.getElementById('FecExpEd').value = uneg[0][0].FechaExpedicion.date.substring(0,10);
            document.getElementById('UnegEd').value = this.uneg[0][0].UNeg;
            document.getElementById('AreaEd').value = this.uneg[0][0].Area;
            document.getElementById('SolEd').value = this.uneg[0][0].Sol;
            document.getElementById('DFalloEd').value   = this.uneg[0][0].DscFallo;            
            document.getElementById('FechaPromEd').value = uneg[0][0].FechaPrometida.date.substring(0,10);
            document.getElementById('AtendidaPor').value = (this.uneg[0][0].Emp == null)? this.uneg[0][0].UnidadVh :this.uneg[0][0].Emp;
            document.getElementById('DscAtendidoEd').value   = this.uneg[0][0].DscAtendido;
            document.getElementById('FechaAsigVhA').value = (this.uneg[0][0].FecAsignacion == null) ? '' : uneg[0][0].FecAsignacion.date.substring(0,10);
            
            switch(this.uneg[0][0].CodTipoOS){
                   case 'OS100':
                       document.getElementById('AtendidaPor').style.display = 'block';
                       document.getElementById('lstMaqPAp').style.display = 'none';
                       document.getElementById('lblFechaAsigVhA').style.display = 'none';
                       document.getElementById('FechaAsigVhA').style.display = 'none';
                   break;
                   case 'OS200':
                      document.getElementById('AtendidaPor').style.display = 'none';
                      document.getElementById('lstMaqPAp').style.display = 'block';
                      document.getElementById('lblFechaAsigVhA').style.display = 'block';
                      document.getElementById('FechaAsigVhA').style.display = 'block';  
                      MaqPSlc.length = 0;
                      MaqPSlc = this.uneg[0][0].UnidadVh.split(',');
                      //console.log(ArrAtMaqP);                      
                      $("#MaqPSlc").empty();
                        MaqPSlc.forEach(function (UnidadMaqP){
                         document.querySelector('#lstMaqPAp').innerHTML +=
                                   `<option value="${UnidadMaqP}">${UnidadMaqP}</option>`;  
                        });
                        
                        $('#LoadCatMaqP').modal('hide');
                   break;
            }

        }).catch (error=>{
            console.error(error);
      });
 }



//Buscar una os cuando el estatus es Terminado y cambia a Aceptado(param = 2)
//o buscar ls os para ver en pantallas la os (paran = 1)

function BsqOsG3(verOS)
 { //alert('../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=2');
      axios({
            method:'GET',
            url:'../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=3',
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            var FecProm = (uneg[0][0].FechaPrometida.date.substring(0,4)== '1900')?'':uneg[0][0].FechaPrometida.date.substring(0,10);
            var FecTer =  (uneg[0][0].FechaTermino.date.substring(0,4)== '1900')?'':uneg[0][0].FechaTermino.date.substring(0,10);

            MaqPSlc.length = 0;
            MaqPSlc = this.uneg[0][0].UnidadVh.split(','); 
            var txtVh = "";
            MaqPSlc.forEach(function (UnidadMaqP){
                txtVh += UnidadMaqP + "<br>"; 
               });
             
            var strOS = "<big>Datos de Creacion de la OS</big><br>"+
                     " <strong>Tipo OS:</strong> "+this.uneg[0][0].DscTipoOS+"<br>"+
                     " <strong>Folio:</strong> "+this.uneg[0][0].Folio+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                     " <strong>Estatus Doc:</strong> "+this.uneg[0][0].StatusDoc+ "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                     " <strong>Prioridad:</strong> "+this.uneg[0][0].Prioridad+ "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
                     " <strong>Fecha Exp:</strong> "+this.uneg[0][0].FechaExpedicion.date.substring(0,10)+"<br>"+
                     " <strong>Un. de Negocio:</strong> "+this.uneg[0][0].UNeg+"<br>"+
                     " <strong>Area:</strong> "+this.uneg[0][0].Area+"<br>"+
                     " <strong>Dirigida A:</strong> "+this.uneg[0][0].Gte+"<br>"+
                     " <strong>Solicitante:</strong> "+this.uneg[0][0].Sol+"<br>"+
                     " <strong>Descripcion del Fallo:</strong><pre>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+this.uneg[0][0].DscFallo+"</pre>"+
                     " <hr>"+
                     " <big>Datos la Atencion de la OS</big><br>"+
                     " <strong>Fecha Prometida:</strong> "+FecProm+"<br>"+
                     " <strong>Asinado A:</strong> "+this.uneg[0][0].Emp+"<br>"+                     
                     " <strong>Unidad Asignada:</strong> "+txtVh+
                     " <strong>Descripcion para atender la OS:</strong><pre>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+this.uneg[0][0].DscAtendido+"</pre>"+
                     " <hr>"+
                     " <big>Datos Terminacion de la OS</big><br>"+
                     " <strong>Fecha Termino:</strong> "+FecTer+"<br>"+
                     " <strong>Observacion Terminacion:</strong><pre>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+this.uneg[0][0].DscTermino+"</pre>"+
                     "<hr>"+
                     " <big>Observaciones de la Liberacion de la OS</big><br>"+
                     " <strong>Observacion Liberacion:</strong><pre>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+this.uneg[0][0].DscLiberacion+"</pre>"+
                    "";

            if(verOS === 1){
                document.getElementById('CuerpoCard').innerHTML = '';
                document.getElementById('CuerpoCard').innerHTML = strOS;
            }
            else{
               document.getElementById('CuerpoCardT').innerHTML = '';
               document.getElementById('CuerpoCardT').innerHTML = strOS;
            }

        }).catch (error=>{
            console.error(error);
      });
 }



function BsqOsGEdit(procEdit)
 {
     var DirUrl = (procEdit == 1) ?'../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=4' :'../Ctr/ctrOSGeneral.php?op=5&Os='+dato+'&estdoc=3';
     
      axios({
            method:'GET',
            url:DirUrl,
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.uneg = res.data;
            var FecProm = (uneg[0][0].FechaPrometida.date.substring(0,4)== '1900')?'':uneg[0][0].FechaPrometida.date.substring(0,10);
            var FecTer =  (uneg[0][0].FechaTermino.date.substring(0,4)== '1900')?'':uneg[0][0].FechaTermino.date.substring(0,10);
           
           
            switch(procEdit){
                case 1:
                    BsqOsG();
                    document.getElementById('FechaProm').value=FecProm;
                    llenaCboEmpledos(this.uneg[0][0].CodEmpleado);
                    document.getElementById('CboAsigA2').selected = this.uneg[0][0].CodEmpleado;                    
                    document.getElementById('DscAtendido').value = this.uneg[0][0].DscAtendido;
                   
                   
                    switch(this.uneg[0][0].CodTipoOS){
                            case 'OS100': 
                            document.getElementById('AtendidaPor').style.display = 'block';
                            document.getElementById('lstMaqPAp').style.display = 'none';
                            document.getElementById('lblFechaAsigVhA').style.display = 'none';
                            document.getElementById('FechaAsigVhA').style.display = 'none';
                            document.getElementById('CboAsigA22').style.display = 'block';
                            document.getElementById('CboAsigA2').style.display = 'block';
                            document.getElementById('lstMaqP').style.display = 'none';
                            document.getElementById('lstMaqP1').style.display = 'none';
                            document.getElementById('btnAdd').style.display = 'none';
                            document.getElementById('btnDel').style.display = 'none';
                            document.getElementById('lblFechaAsigVh').style.display = 'none';
                            document.getElementById('FechaAsigVh').style.display = 'none';   
                            break;
                            case 'OS200':
                               var FecAsiVh = (uneg[0][0].FecAsignacion.date.substring(0,4)== '1900')?'':uneg[0][0].FecAsignacion.date.substring(0,10);
                               document.getElementById('FechaAsigVh').value = FecAsiVh;
                               document.getElementById('AtendidaPor').style.display = 'none';
                               document.getElementById('lstMaqPAp').style.display = 'block';
                               document.getElementById('lblFechaAsigVhA').style.display = 'block';
                               document.getElementById('FechaAsigVhA').style.display = 'block'; 
                               document.getElementById('CboAsigA22').style.display = 'none';
                               document.getElementById('CboAsigA2').style.display = 'none';
                               document.getElementById('lstMaqP').style.display = 'block';
                               document.getElementById('lstMaqP1').style.display = 'block';
                               document.getElementById('btnAdd').style.display = 'inline';
                               document.getElementById('btnDel').style.display = 'inline';
                               document.getElementById('lblFechaAsigVh').style.display = 'inline';
                               document.getElementById('FechaAsigVh').style.display = 'inline';
                               
                               MaqPSlc.length = 0; 
                               MaqPSlc.length = 0;
                               MaqPSlc = this.uneg[0][0].UnidadVh.split(','); 
                               //console.log(MaqPSlc);                      
                                $("#lstMaqP").empty();
                                 MaqPSlc.forEach(function (UnidadMaqP){
                                  document.querySelector('#lstMaqP').innerHTML +=
                                            `<option value="${UnidadMaqP}">${UnidadMaqP}</option>`;  
                                            console.log("item " + UnidadMaqP);
                                 });
                                // $('#LoadCatMaqP').modal('hide');
                            break;
                     }
                    
                break;
                case 2:
                    BsqOsG2();
                    document.getElementById('FechaTermino').value = FecTer;
                    document.getElementById('DscTermino').value = this.uneg[0][0].DscTermino;
                break;
                case 3:
                  if(this.uneg[0][0].StatusDoc == 'Aceptado'){
                     document.getElementById('TAceptado').checked = true;
                     document.getElementById('TnoAceptado').checked = false;
                  }
                  else{
                      document.getElementById('TAceptado').checked = false;
                      document.getElementById('TnoAceptado').checked = true;
                  }
                  document.getElementById('DscLiberacion').value = this.uneg[0][0].DscLiberacion;
                break;

            }

        }).catch (error=>{
            console.error(error);
      });
 }


//LElena combos de Asignada a
function llenarTabla()
{
    $("#tblOsG tr").remove();
    document.querySelector('#tblOsG thead').innerHTML +=
        `<tr>
            <th style="width: 60px;">Folio</th>
            <th style="width: 110px;">Fecha Exp</th>
            <th style="width: 110px;">Tipo Matto</th>
            <th>Unidad Negocio</th>
            <th style="width: 170px;">Area Solita</th>
            <th>Solicitante</th>
            <th>Jefe Area</th>
            <th style="width: 120px;">Estatus Doc</th>
            <th style="width: 80px;">Prioridad</th>
            <th style="width: 120px;">CodGteMatto</th>
        </tr>`;

    document.querySelector('#tblOsG tbody').innerHTML = '';
        for(let i=0; i < uneg.length; i++){
            Color = "rgb( 244, 246, 247 )"
        if(uneg[i][0].StatusDoc == 'Atendido')
            Color = "rgb(60, 179, 113 )";
        else if (uneg[i][0].StatusDoc == 'Terminado')
            Color = "rgb(255, 215, 0)";
        else if (uneg[i][0].StatusDoc == 'Aceptado')
            Color = "rgb(115, 194, 251)";
        else if (uneg[i][0].StatusDoc == 'Rechazado')
            Color = "rgb(255, 79, 79)";

        document.querySelector('#tblOsG tbody').innerHTML +=
        `<tr style="background-color:${Color}; color:${Text}">
            <td style="width: 60px;">${uneg[i][0].Folio}</td>
            <td style="width: 110px;">${uneg[i][0].FechaExpedicion.date.substring(0,10)}</td>
            <td style="width: 110px;">${uneg[i][0].TipoMatto}</td>
            <td>${uneg[i][0].UNegocio}</td>
            <td style="width: 170px;">${uneg[i][0].Area}</td>
            <td>${uneg[i][0].Solicitante}</td>
            <td>${uneg[i][0].GerenteM}</td>
            <td style="width: 120px;">${uneg[i][0].StatusDoc}</td>
            <td style="width: 80px;">${uneg[i][0].Prioridad}</td>
            <td style="width: 120px;">${uneg[i][0].CodGteMatto}</td>
         </tr>`;
    }
}


/*
 * Carga el catalogo de unidades para maquinaria pesada
 */
function CargaCatUnidades()
{
   axios({
            method:'GET',
            url:'../Ctr/ctrOSGeneral.php?op=31',
            responseType:'json'
        }).then(res=>{
            console.log(res.data);
            this.UnP = res.data;
            $("#tblCmp tr").remove();
            document.querySelector('#tblCmp thead').innerHTML +=
                `<tr>
                    <th style="width: 35px;">Slc</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>`;
            document.querySelector('#tblCmp tbody').innerHTML = '';
            for(let i=0; i < UnP.length; i++){
                if(MaqPSlc.indexOf(UnP[i][0].CodUnidad+"|"+UnP[i][0].Descripcion) < 0) 
                {
                   document.querySelector('#tblCmp tbody').innerHTML +=
                  `<tr>
                        <td style="width: 35px;"><input class="form-check-input" type="checkbox" name="Rslc"${i} id="Rslc"${i} onchange="Check(this,'${UnP[i][0].CodUnidad}|${UnP[i][0].Descripcion}')" value="" aria-label="..."></td>
                        <td>${UnP[i][0].CodUnidad}</td>
                        <td>${UnP[i][0].Descripcion}</td>
                        <td>${UnP[i][0].TipoVeh}</td>
                   </tr>`; 
                }
            }
            
        }).catch (error=>{
            console.error(error);
      }); 
}


 function Check(value,codunidad) 
 {
    if(value.checked==true)
        MaqPSlc.push(codunidad);
    else
    {
        idx = MaqPSlc.indexOf(codunidad);
        MaqPSlc.splice(idx,1);
       // console.log(idx);
    }
    //console.log(MaqPSlc);
 }

function SeleccionaUnidades()
{
   $("#lstMaqP").empty();
    MaqPSlc.forEach(function (UnidadMaqP){
     document.querySelector('#lstMaqP').innerHTML +=
               `<option value="${UnidadMaqP}">${UnidadMaqP}</option>`;  
    });
    $('#LoadCatMaqP').modal('hide');
}

function QuitaUnidad(){
    idx = MaqPSlc.indexOf(document.getElementById('lstMaqP').value);
    if (opcion != 2)
    {
       MaqPSlc.splice(idx,1);
       SeleccionaUnidades(); 
    }
    else
    {
       // alert ('Guardar en el arreglo ' + MaqPSlc[idx]);
       MaqPDlt.push(MaqPSlc[idx]);
       MaqPSlc.splice(idx,1);
       SeleccionaUnidades(); 
    }
    
}


function ValidaDatosNuevo()
{
    var dv = 1;
    strRsp1 = "";
    strRsp2 = "";
    strRsp3 = "";
    strRsp4 = "";
    strRsp5 = "";
    if (document.getElementById('CboUneg').value.length == 0){
        strRsp1 += 'Seleccione una unidad de negocio';
        dv = 0;
    }
    if (document.getElementById('CboSol').value.length == 0){
        strRsp2 += 'Seleccione un solicitante';
        dv = 0;
    }
    if (document.getElementById('CboArea').value.length == 0){
        strRsp3 += 'Seleccione un Área';
        dv = 0;
    }
    if (document.getElementById('CboAsigA').value.length == 0){
        strRsp4 += 'Seleccione un jefe de Mtto';
        dv = 0;
    }
    if (document.getElementById('DscFallo').value.length == 0){
        strRsp5 += 'Capture la descripción del fallo';
        dv = 0;
    }
    return dv;
}

function ValidaAtender()
{
    var dv = 1;
    strRsp6 = ""; //alert(document.getElementById('TipoOS').value);
    strRsp7 = "";
    strRsp8 = "";
    if(document.getElementById('TipoOS').value == 'MANTENIMIENTO'){
        if (document.getElementById('CboAsigA2').value.length == 0){
                strRsp6 += 'Asigne la OS a un empleado';
                dv = 0;
        }  
    }else{
        if (MaqPSlc.length == 0 ){
                strRsp7 += 'Asigne mínimo una unidad de maquinaria pesada';
                dv = 0; 
        }
    }
    if (document.getElementById('DscAtendido').value.length == 0){
            strRsp8 += 'Capture una descripción';
            dv = 0;
    }
    return dv;
}

function ValidaDatosTerOS()
{
    var dv = 1;
    strRsp9 = "";
    strRsp0 = "";
    if (document.getElementById('FechaTermino').value.length == 0){
        strRsp9 += 'Seleccione una fecha de término';
        dv = 0;
    }
    if (document.getElementById('DscTermino').value.length == 0){
        strRsp0 += 'Capture un comentario para la terminación de OS';
        dv = 0;
    }
    return dv; 
}

function ValidaDatosAcp()
{
    var dv = 1;
    strRsp = "";
    if (document.getElementById('DscLiberacion').value.length == 0){
        strRsp += 'Capture una comentario para liberar la OS';
        dv = 0;
    }
    return dv; 
}