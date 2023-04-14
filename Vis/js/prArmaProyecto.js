var dato;
var Rubro;
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
            <th>Tareas</th>
        </tr>`;

    for(let i=0; i < rubros.length; i++){
        document.querySelector('#tblRubro tbody').innerHTML +=
        `<tr>
                <td>${rubros[i][0].CodRubro}</td>
                <td>${rubros[i][0].Descripcion}</td>
                <td>${rubros[i][0].ValorEnProyecto}</td>
                <td>${rubros[i][0].Estatus}</td>
                <td><button class="btn btn-outline-success btn-sm" id="cmdVerTareas" type="button"
                                      onclick="VerTareas('${rubros[i][0].CodRubro}','${dato}','${rubros[i][0].Descripcion}')">Ver Tareas</button></td>
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
        </tr>`;
 //falta modiciar la consuta y losc ampos correcotrs
    for(let i=0; i < Tareas.length; i++){
        document.querySelector('#tblTareas tbody').innerHTML +=
        `<tr>
                <td>${Tareas[i][0].CodTarea}</td>
                <td>${Tareas[i][0].Descripcion}</td>
                <td>${Tareas[i][0].ValorEnRubro}</td>
                <td>${Tareas[i][0].ValorAvance}</td>
         </tr>`;
    }
}








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
