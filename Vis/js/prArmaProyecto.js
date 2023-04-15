var dato;
var Rubro;
var Proyecto;
$(document).ready(function(){//cuando este lista la página
    $('#tblUNeg tbody').on('click','tr', function(event){
     //$(this).toggleClass("selected");
      dato = $(this).find('td:first').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
      CargoRubros();
    });

    //ObtenerSeguridad();
    //llenaCboAsigA();
    lleCboUNeg();
    ObtenerProyectosT();
});

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
  return dv;
}





function setOpcion(op)
{
    opcion = op;

    switch(opcion){
        case 1:
            if (dato.length > 0 )
             {
                 lleCboGteMtto();
                 LlenarRubroList2();
                 document.querySelector('#CboRubro').innerText = '';
                 $('#frmAddRubro').modal('show');
             }
             else
                alert ("Tienes que seleccionar un ");
        break;
        case 2:
             if (dato.length > 0 )
             {
                 lleCboGteMtto();
                 LlenarRubroList2();
                 document.querySelector('#CboRubro').innerText = '';
                 $('#frmAddRubro').modal('show');
             }
             else
                alert ("Tienes que seleccionar un ");
        break;
    }

    /*
    if (opcion == 2)
    {
        if (dato.length > 0 )
        {
            llenaCboRubros2();
            UpdateRubroTarea1();
            $('#frmCatTareaRubro').modal('show');
        }
        else
          alert ("Tienes que seleccionar un registro");
     }

    if (opcion == 3)
    {
        if (dato.length > 0 )  {
            $("#ModPregSiNo").html("<strong>Estas seguro de eliminar la tarea "+dato+" Seleccionado</strong>")
            $('#PreguntaSiNo').modal('show');
        }
        else
          alert ("Tienes que seleccionar un registro");
    }
    */
}


function AddRubro()
{
     var RubSlc = document.querySelector('#CboRubro').value;

      axios({
            method:'POST',
            url:'../Ctr/ctrprArmaProyecto.php',
            data: {
                "Op":"1",
                "CodProyecto":dato,
                "CodRubro":RubSlc
            }
            }).then(res=>{
                console.log(res.data);
                document.querySelector('#CboGteMtto').innerHTML += `<option selected></option>`;
                LlenarRubroList2();
                document.querySelector('#CboRubro').innerText = '';
                CargoRubros();
            }).catch (error=>{
                console.error(error);
            });
}

function DelRubro()
{
    var RubSlcD = document.querySelector('#CboRubroPry').value;
     axios({
            method:'POST',
            url:'../Ctr/ctrprArmaProyecto.php',
            data: {
                "Op":"2",
                "CodProyecto":dato,
                "CodRubro":RubSlcD
            }
            }).then(res=>{
                console.log(res.data);
                document.querySelector('#CboGteMtto').innerHTML += `<option selected></option>`;
                LlenarRubroList2();
                document.querySelector('#CboRubro').innerText = '';
                CargoRubros();
            }).catch (error=>{
                console.error(error);
            });

}




function CargoRubros()
{
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=2&codProyecto='+dato,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.rubros = res.data;
        llenarTabla2();
    }).catch (error=>{
        console.error(error);
    });
}


function LlenarRubroList2()
{
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=3&codProyecto='+dato,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.rubrosPr = res.data;
        //document.querySelector('#CboRubroPry').innerHTML += `<option selected></option>`;
        document.querySelector('#CboRubroPry').innerText = '';
        for(let i=0; i < rubrosPr.length; i++){
          document.querySelector('#CboRubroPry').innerHTML +=
               `<option value="${rubrosPr[i][0].CodRubro}">${rubrosPr[i][0].Descripcion}</option>`;
        }

    }).catch (error=>{
        console.error(error);
    });
}

function LlenarRubroList1()
{
   var GteSlc = document.querySelector('#CboGteMtto').value;
   axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=4&codProyecto='+dato+'&codGte='+GteSlc,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.rubrosGt = res.data;
        document.querySelector('#CboRubro').innerText = '';
        for(let i=0; i < rubrosGt.length; i++){
          document.querySelector('#CboRubro').innerHTML +=
               `<option value="${rubrosGt[i][0].CodRubro}">${rubrosGt[i][0].Descripcion}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}

function ObtenerProyectosT()
{
    dato = "";
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=1',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();
    }).catch (error=>{
        console.error(error);
    });
}

function ObtenertProyectoB()
{
  var uneg =  document.querySelector('#CboUneg').value;
  var filt =  document.querySelector('#Buscar').value;
   axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=6&Uneg='+uneg+'&Busq='+filt,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.uneg = res.data;
        llenarTabla();

        $("#tblRubro tr").remove();
        document.querySelector('#tblRubro thead').innerHTML +=
        `<tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Valor en Proyecto</th>
            <th>Estatus</th>
            <th>Tareas</th>
        </tr>`;

        document.querySelector('#tblRubro tbody').innerHTML ='';
    }).catch (error=>{
        console.error(error);
    });
}

function lleCboGteMtto()
{
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=12',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboGteMtto').innerText = '';
        document.querySelector('#CboGteMtto').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboGteMtto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}



function lleCboUNeg()
{
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=13',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboUneg').innerText = '';
        document.querySelector('#CboUneg').innerHTML += `<option selected></option>`;
        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboUneg').innerHTML +=
               `<option value="${uneg[i][0].CodUNegocio}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}




function VerTareas(Rb,Pr,Dsc)
{
  Rubro = Rb;
  Proyecto = Pr;
   document.querySelector('#Titulo').innerHTML = "Tareas del Rubro " + Dsc;
   axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=5&codProyecto='+Pr+'&codRubro='+Rb,
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        this.Tareas = res.data;
        llenarTabla3();
        $('#frmVerTareas').modal('show');
    }).catch (error=>{
        console.error(error);
    });
}

function EditConfigRubro(Rb, Pr, Dsc)
{
   Rubro = Rb;
  Proyecto = Pr;
  axios({
    method:'GET',
    url:'../Ctr/ctrprArmaProyecto.php?op=20&codProyecto='+Proyecto+'&codRubro='+Rubro,
    responseType:'json'
  }).then(res=>{
    this.Tareas = res.data;
    var Fec1 = (Tareas[0][0].FechaInicial.date.substring(0,4)== '1900')?SetFechaActual(3):Tareas[0][0].FechaInicial.date.substring(0,10);
    var Fec2 =  (Tareas[0][0].FechaFinal.date.substring(0,4)== '1900')?SetFechaActual(3):Tareas[0][0].FechaFinal.date.substring(0,10);
    document.getElementById('FechaIni').value = Fec1;
    document.getElementById('FechaFin').value = Fec2;
    document.getElementById('CantPres').value = Tareas[0][0].CosPresupuestado;
    document.getElementById('CantReal').value = Tareas[0][0].CosReal;
    document.getElementById('CantPres').disabled = (parseFloat(Tareas[0][0].CosPresupuestado) > 0) ? true : false;

    $('#frmConfigRubro').modal('show');
  }).catch (error=>{
    console.error(error);
  });
}


function UpdateConfigRubro()
{
  axios({
    method:'PUT',
    url:'../Ctr/ctrprArmaProyecto.php',
    data: {
      "Op":"221",
      "CodProyecto":Proyecto,
      "CodRubro":Rubro,
      "FechaInicial":document.getElementById('FechaIni').value,
      "FechaFinal":document.getElementById('FechaFin').value,
      "CosPresupuestado":document.getElementById('CantPres').value
    }
  }).then(res=>{
    $('#frmConfigRubro').modal('hide');
  }).catch (error=>{
    console.error(error);//// TODO: MODIFICAR ACA EL ERROE
  });
}
}


function llenarTabla()
{
    $("#tblUNeg tr").remove();
    document.querySelector('#tblUNeg thead').innerHTML +=
        `<tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Observacion</th>
            <th>U. Negocio</th>
        </tr>`;

    for(let i=0; i < uneg.length; i++){
        document.querySelector('#tblUNeg tbody').innerHTML +=
        `<tr>
                <td>${uneg[i][0].CodProyecto}</td>
                <td>${uneg[i][0].Nombre}</td>
                <td>${uneg[i][0].Observacion}</td>
                <td>${uneg[i][0].Uneg}</td>
         </tr>`;
    }
}

function llenarTabla2()
{
    $("#tblRubro tr").remove();
    document.querySelector('#tblRubro thead').innerHTML +=
        `<tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Valor en Proyecto</th>
            <th>Estatus</th>
            <th colspan=2 > </th>
        </tr>`;

    for(let i=0; i < rubros.length; i++){
        document.querySelector('#tblRubro tbody').innerHTML +=
        `<tr>
                <td>${rubros[i][0].CodRubro}</td>
                <td>${rubros[i][0].Descripcion}</td>
                <td>${rubros[i][0].ValorEnProyecto}</td>
                <td>${rubros[i][0].Estatus}</td>
                <td><button class="btn btn-outline-primary btn-sm" id="cmdConfigRubro" type="button"
                      onclick="EditConfigRubro('${rubros[i][0].CodRubro}','${dato}','${rubros[i][0].Descripcion}')">Config. Rubro</button></td>
                      <td><button class="btn btn-outline-success btn-sm" id="cmdVerTareas" type="button"
                                      onclick="VerTareas('${rubros[i][0].CodRubro}','${dato}','${rubros[i][0].Descripcion}')">Conf. Tareas</button></td>
                </tr>`;
    }
}


function llenarTabla3()
{
    $("#tblTareas tr").remove();
    document.querySelector('#tblTareas thead').innerHTML +=
        `<tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Valor en Rubro</th>
            <th>Valor Avance</th>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
        </tr>`;
 //falta modiciar la consuta y losc ampos correcotrs
    for(let i=0; i < Tareas.length; i++){
      var Fec1 = (Tareas[i][0].FecInicialTra.date.substring(0,4)== '1900')?'':Tareas[i][0].FecInicialTra.date.substring(0,10);
      var Fec2 =  (Tareas[i][0].FecFinalTra.date.substring(0,4)== '1900')?'':Tareas[i][0].FecFinalTra.date.substring(0,10);

      document.getElementById('FechaIni').value = Fec1;
      document.getElementById('FechaFin').value = Fec2;

      var F1 = '<input type="date" class="form-control" id="FechaIniTra" placeholder="Fecha" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "'+Fec1+ '">';
      var F2 = '<input type="date" class="form-control" id="FechaFinTra" placeholder="Fecha" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value = "'+Fec2+ '">';

      document.querySelector('#tblTareas tbody').innerHTML +=
        `<tr>
                <td>${Tareas[i][0].CodTarea}</td>
                <td>${Tareas[i][0].Descripcion}</td>
                <td>${Tareas[i][0].ValorEnRubro}</td>
                <td>${Tareas[i][0].ValorAvance}</td>
                <td>${F1}</td>
                <td>${F2}</td>
         </tr>`;
    }
}







function UpdateConfigTareas()
{
  var Tras1 = new Array();
  $('#tblTareas tr').each(function(){
    let txt1 =  $(this).find('Td').eq(0).text();
    if(txt1.length > 0){
      Tras = new Object();
        Tras.Codigo = txt1;
        Tras.Nombre = $(this).find('Td').eq(1).text();
        Tras.ValRubro = $(this).find('Td').eq(2).text();
        Tras.ValAvance = $(this).find('Td').eq(3).text();
        Tras.FechaInicial = $(this).find('#FechaIniTra').html('FechaIniTra').val();
        Tras.FechaFinal = $(this).find('#FechaFinTra').html('FechaFinTra').val();
        Tras1.push(Tras);
      }
    });

    var strJS = JSON.stringify({ ...Tras1 });
    axios({
      method:'PUT',
      url:'../Ctr/ctrprArmaProyecto.php',
      data: {
        "Op":"222",
        "CodProyecto":Proyecto,
        "CodRubro":Rubro,
        "Registros":strJS
      }
    }).then(res=>{

      $('#frmVerTareas').modal('hide');
      //           alert(res.data);

    }).catch (error=>{
      console.error(error);
    });

/* var arr = [ 'x', 'y', 'z' ];
var json = { ...Tras };
console.log(json);*/

}

/*
function UpdateConfigTareas()
{
try{

  var resume_table = document.getElementById("tblTareas");
  //console.log(resume_table);
  console.log(document.getElementById("tblTareas").rows);
  console.log(document.getElementById("tblTareas").rows.length);
  console.log(document.getElementById("tblTareas").rows[1].cells);
  console.log(document.getElementById("tblTareas").rows[1].cells.length);
  console.log(document.getElementById("tblTareas").rows[1].cells[2]);
  for(var i = 0; i < document.getElementById("tblTareas").rows.length; i++ )
  {
  str1 = '';
  for(var j = 0; j < document.getElementById("tblTareas").rows[i].cells.length; j++)
  {
  str1 += document.getElementById("tblTareas").rows[i].cells[j].innerHTML + '\n';
      if(j == 4)
        console.log(document.getElementById("tblTareas").rows[i].cells[j]); //.FechaIniTra.date.substring(0,10));

        if (j == 5)
          console.log(document.getElementById("tblTareas").rows[i].cells[j].FechaFinTra.date.substring(0,10));
        }
        alert (str1);
      }
      //let obtenerDato = resume_table.getElementsByTagName("tbody");
      //console.log(obtenerDato);
      //console.log(obtenerDato[5].innerHTML);
      /*for (var i = 0;  cell = resume_table[i]; i++) {
      alert("Valor Celda: " + cell[i].innerText);
    }
  }
  catch(error)
  {
  alert('catch Error processing document ' + console.error(error));
}
}
*/
/*
$(document).ready(function(){//cuando este lista la página

    //ObtenerSeguridad();
    llenaCboProyecto();
    llenaCboGteMtto();
});


function CargaRubros()
{
    if(document.getElementById("CboSlcProyecto").value.length > 0){
       //Cargar los rubros
    }
    else
        alert("Tienes que seleccionar un proyecto");
}


function llenaCboProyecto(){
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=1',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboSlcProyecto').innerHTML += `<option selected></option>`;


        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboSlcProyecto').innerHTML +=
               `<option value="${uneg[i][0].CodProyecto}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}



function llenaCboGteMtto(){
    axios({
        method:'GET',
        url:'../Ctr/ctrprArmaProyecto.php?op=2',
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        //Lleno al cambo
        document.querySelector('#CboSlcGteMtto').innerHTML += `<option selected></option>`;


        for(let i=0; i < uneg.length; i++){
          document.querySelector('#CboSlcGteMtto').innerHTML +=
               `<option value="${uneg[i][0].CodGteMtto}">${uneg[i][0].Nombre}</option>`;
        }
    }).catch (error=>{
        console.error(error);
    });
}
*/
