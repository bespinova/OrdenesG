var dato;
var codProyecto;
var CodTarea;
var slccon;
var CodContenido;
var imagenes;
var rutaImagen;
var globalVariable;
var cmpImagen;
//var slider = [];
//var textoComentario = [];
//var textoObservacion = [];
var arrayData = [];
var posicionActual =0;
//var posicionActual;
//var intervalo;



$(document).ready(function(){
  $('#frmSolicita').modal({backdrop: 'static', keyboard: false})
funcMain();
});

function funcMain() {
  dato = "";
  axios({
    method: 'GET',
    url: '../Ctr/ctrPrCatProyectos.php?varCmbPr=1',
    responseType: 'json'
  }).then(res => {
    console.log(res.data);
    this.uneg = res.data;
    document.getElementById('CboProyct').innerHTML += `<option value="" selected disabled hidden>Seleccione una opción</option>`;
    for (let i = 0; i < uneg.length; i++) {
      document.getElementById('CboProyct').innerHTML +=
        `<option value="${uneg[i][0].CodProyecto}">${uneg[i][0].Nombre}</option>`;
    }
  }).catch(error => {
    console.log(error);
  });
}

// TODO: Funcion que muestra la tabla de tareas
function cargaProyct() {
  cargaProyctRubros();
     slccon = document.getElementById('CboProyct').value;
  axios({
    method: 'GET',
    url: '../Ctr/ctrPrCatProyectos.php?varDataGral='+slccon,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    for (let i = 0; i < uneg.length; i++) {
      document.getElementById('nameProyct').value = uneg[i][0].Nombre;
      document.getElementById('codProyct').value = uneg[i][0].CodProyecto;
      document.getElementById('fechaInicio').value = uneg[i][0].FechaInicio.date.substring(0, 10);
      document.getElementById('fechaFinal').value = uneg[i][0].FechaEntrega.date.substring(0, 10);
      document.getElementById('MDuracion').value = uneg[i][0].MesesDuracion;
      document.getElementById('CPresupuesto').value = uneg[i][0].Presupuesto;
      var porcentaje = uneg[i][0].PorTerminado;
      moverProgress(porcentaje);
    }
  }).catch(error => {
    console.log(error);
  });
}

function cargaProyctRubros() {
  slccon = document.getElementById('CboProyct').value;
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevision.php?varCod=1&varPrcy=' + slccon,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    console.log(res.data);
    if (isObject(res.data)) {
      llenaTablaRubros();
      activaCell(1);
    }else {
      document.getElementById('tblRubros').innerHTML = '';
      document.getElementById('tblRubros').innerHTML +=
      `<thead  class="table-dark">
          <tr>
              <th class="header" scope="col">Cod. Rubro</th>     <!-- se agrego el header-->
              <th class="header" scope="col">Descripción</th>
          </tr>
      </thead>`
      document.getElementById('tblRubros').innerHTML +=
        `<tr>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
         </tr>`;
    }
  }).catch(error => {
    console.log(error);
  });
}

function cargaProyctRevision(data){
  codProyecto = data;
  dato = "";
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevision.php?varCod=2&varPrcyRvsn='+data,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    if (isObject(res.data)) {
      llenaTablaRevisiones();
      activaCell(2);
    }else {
      document.getElementById('tblRevision').innerHTML = '';
      document.getElementById('tblRevision').innerHTML +=
      `<thead  class="table-dark">
          <tr>
              <th scope="col">Código</th>
              <th scope="col">Descripción</th>
              <th scope="col">Avance</th>
          </tr>
      </thead>`
      document.getElementById('tblRevision').innerHTML +=
        `<tr>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
         </tr>`;
    }
  }).catch(error => {
    console.log(error);
  });
}

function agregaRevision(data){
  dato = "";
  var campoObservacion = document.getElementById('cmpObservacion').value;
  if (campoObservacion=='') {
    document.getElementById('innerHTML').innerHTML ='';
    $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
    document.getElementById('innerHTML').innerHTML +=`
                <div class="alert alert-danger" role="alert">
                <strong> Ingrese un texto válido en el campo de observación </strong>
                </div>`;

  }else {
    axios({
      method: 'POST',
      url: '../Ctr/ctrRevision.php',
      data: {
        codContenido: data,
        cmpObservacion: campoObservacion,
      }
    }).then(res => {
      this.uneg = res.data;
      closeMd();
      $('#frmSolicita').modal('hide');
    }).catch(error => {
      console.log(error);
    });
  }
}

function agregaRevisionImg(data){  
  axios({
    method: 'POST',
    url: '../Ctr/ctrRevisionImagenes.php?varData=1',
    data: {
      CodRevision: data,
      rutaImagen: rutaImagen,
      Comentario: cmpImagen,
    }
  }).then(res => {
    this.uneg = res.data;
    if (res.data != 1) {
      borraArchivoImg(rutaImagen);
    }
    closeMd();
    $('#frmSolicita').modal('hide');
  }).catch(error => {
    console.log(error);
    borraArchivoImg(rutaImagen);
  });
}

function borraArchivoImg(rutaImagen){
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevisionImagenes.php?varData=2&ruta='+rutaImagen,
    responseType:'json'
  }).then(res => {
    this.uneg = res.data;
  }).catch(error =>{
    console.log(error);
  });
  }



function cmbRevisiones(data){
  dato = "";
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevision.php?varCod=4&varContenido='+data,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    if (isObject(res.data)) {
      document.getElementById('cboRevision').innerHTML = "";
      document.getElementById('cboRevision').innerHTML += `<option value="" selected disabled hidden>Seleccione una opción</option>`;
      for (let i = 0; i < uneg.length; i++) {
        document.getElementById('cboRevision').innerHTML +=
          `<option value="${uneg[i][0].CodRevision}">${uneg[i][0].Observaciones}</option>`;
        }
    }else {
      document.getElementById('cboRevision').innerHTML = "";
      document.getElementById('cboRevision').innerHTML += `<option value="" selected disabled hidden>No hay registros</option>`;
    }
  }).catch(error => {
    console.log(error);
  });
}

function obtenerCodContenido(cadena){
  if (cadena ==1) {
      CodTarea = document.getElementById('CodTarea').value;
      var urls = '../Ctr/ctrRevision.php?varCod=3&codProyct='+slccon+'&CodTarea='+CodTarea;
  }else {
      var urls = '../Ctr/ctrRevision.php?varCod=3&codProyct='+slccon+'&CodTarea='+cadena;
  }
  axios({
    method: 'GET',
    url: urls,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    if (cadena==1) {
      CodContenido = uneg[0][0].CodContenido;
      // TODO: agregar metodo para agregar la revision por metodo post
      agregaRevision(CodContenido);
    }else {
      CodContenido = uneg[0][0].CodContenido;
      // TODO: Llenar Combo de revisiones
      cmbRevisiones(CodContenido);
    }
  }).catch(error => {
    console.log(error);
  });
}

function llenaTablaRubros() {
  document.getElementById('tblRubros').innerHTML = '';
  document.getElementById('tblRubros').innerHTML +=
  `<thead  class="table-dark">
      <tr>
          <th scope="col">Cod. Rubro</th>
          <th scope="col">Descripción</th>
      </tr>
  </thead>`

  for (let i = 0; i < uneg.length; i++) {
    document.getElementById('tblRubros').innerHTML +=
      `<tr>
              <td>${uneg[i][0].CodRubro}</td>
              <td>${uneg[i][0].Descripcion}</td>
       </tr>`;
  }
}

function llenaTablaRevisiones(){
  document.getElementById('tblRevision').innerHTML = '';
  document.getElementById('tblRevision').innerHTML +=
  `<thead  class="table-dark">
      <tr>
      <th scope="col">Código</th>
      <th scope="col">Descripción</th>
      <th scope="col">Avance</th>
      </tr>
  </thead>`

  for (let i = 0; i < uneg.length; i++) {
    document.getElementById('tblRevision').innerHTML +=
      `<tr>
              <td>${uneg[i][0].CodTarea}</td>
              <td>${uneg[i][0].Descripcion}</td>
              <td>${uneg[i][0].ValorEnRubro}</td>
       </tr>`;
  }
}

//funcionalidad aplicativa PMD
function moverProgress(porcentaje) {
  if (porcentaje > 100) {
    porcentaje = 100;
  }
  if (porcentaje < 0) {
    porcentaje = 0;
  }
  if (porcentaje == 0) {
    porcentaje = 0;
  }
  var elem = document.getElementById("idProgress");
  var width = -1;
  var id = setInterval(frame, 10);

  function frame() {
    if (width >= porcentaje) {
      clearInterval(id);
    } else {
      width++;
      elem.style.width = width + '%';
      document.getElementById("label").innerHTML = width * 1 + '%';
    }
  }
}

function isObject(val)
 {
    if (val === null)
    {
        return false;
    }
      return ( (typeof val === 'function') || (typeof val === 'object'));
  }

// TODO: Funcion que activa las celdas al dar click sobre ellas
  function activaCell(opc){
    if (opc === 1) {
      $("#tblRubros tbody").click(function(){
         dato = $(this).find('td:first').html();
         $('td',this).addClass('selected');
         $(this).siblings().find('td').removeClass('selected');
         cargaProyctRevision(dato);
      });
    }else {
      $("#tblRevision tbody").click(function(){
         dato = $(this).find('td:first').html();
         $('td',this).addClass('selected');
         $(this).siblings().find('td').removeClass('selected');

         globalVariable = document.getElementById('CboProyct').value;

       });
    }
  }
  function drvOperacion()
  {
      switch(opcion)
      {
          case 1:
                obtenerCodContenido(1);
           break;
          case 2:
              var selContenido = document.getElementById('cboRevision').value;
              cmpImagen = document.getElementById('cmpDescImagn').value;
              var imagenSelecco = document.getElementById('imgRevision').value;
              if(selContenido != 0){
                if (imagenSelecco != ''  || imagenSelecco.length != 0 ) {
                  if (cmpImagen != '' || cmpImagen.length != 0 ) {
                      agregaRevisionImg(selContenido);
                  }else {
                    document.getElementById('innerHTML').innerHTML = '';
                    $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
                    document.getElementById('innerHTML').innerHTML +=`
                                <div class="alert alert-danger" role="alert">
                                <strong> Escriba una descripción a la imagen </strong>
                                </div>`;
                  }
                }else {
                  document.getElementById('innerHTML').innerHTML = '';
                  $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
                  document.getElementById('innerHTML').innerHTML +=`
                              <div class="alert alert-danger" role="alert">
                              <strong>Seleccione una imágen válida </strong>
                              </div>`;
                }
              }else {
                document.getElementById('innerHTML').innerHTML = '';
                $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
                document.getElementById('innerHTML').innerHTML +=`
                            <div class="alert alert-danger" role="alert">
                            <strong> Seleccione una revisión válida</strong>
                            </div>`;
              }
           break;
          case 3:
            document.getElementById('innerHTML').innerHTML = '';
            $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
            document.getElementById('innerHTML').innerHTML +=`
                        <div class="alert alert-danger" role="alert">
                        <strong> Seleccione una revisión válida</strong>
                        </div>`;
           break;
      }
  }

  function closeMd()
  {
      document.getElementById('CodTarea').disabled = false;
      document.getElementById('CodTarea').value = "";
      document.getElementById('cmpObservacion').value = "";
      cargaProyct();
      dato = "";
       $("#tblRevision tbody").siblings().find('td').removeClass('selected');
  }

  function setOpcion(op)
  {
      opcion = op;
      if (opcion == 1) {
        if (dato.length > 0) {
          document.getElementById('CodTarea').value = dato;
          document.getElementById('CodTarea').disabled = true;
          document.getElementById('cmpObservacion').disabled = false;
          document.getElementById('FrameRevision').style.display = 'none';
          document.getElementById('FrameImagen').style.display = 'none';
          document.getElementById('preview').style.display='none';
		  document.getElementById('cmpDescImagn').style.display='none'; 
          $('#frmSolicita').modal('show');
        }else {
          document.getElementById('txtMostrar').innerHTML = "";
          $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
          document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-danger" role="alert">
                                        <strong> Seleccione un proyecto </strong>
                                        </div>`;
          $('#frmSolicita').modal('hide');
        }
      }
      if (opcion == 2){
        //Agregar imagenes a las revisiones
          if (dato.length > 0) {
            document.getElementById('CodTarea').value = dato;
            document.getElementById('CodTarea').disabled = true;
            document.getElementById('FrameRevision').style.display = 'block';
            document.getElementById('FrameImagen').style.display = 'block';
            $('#frmSolicita').modal('show');
            document.getElementById('imgRevision').value ='';
            document.getElementById('cmpDescImagn').value = '';
			document.getElementById('cmpDescImagn').style.display='block';            
            document.getElementById("preview").innerHTML = '';
            obtenerCodContenido(dato);
            obtenerRevisiones(dato);
          }else {
            document.getElementById('txtMostrar').innerHTML = "";
            $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
            document.getElementById('txtMostrar').innerHTML += `
                                          <div class="alert alert-danger" role="alert">
                                          <strong> Seleccione una revisión </strong>
                                          </div>`;
            $('#frmSolicita').modal('hide');
          }
        }
      if (opcion == 3){
        if (dato.length > 0) {
            if (document.getElementById('preview').style.display =='none') {
              document.getElementById('preview').style.display='block';
            }
            document.getElementById('FrameRevision').style.display = 'block';

          document.getElementById('FrameImagen').style.display = 'block';

			obtenerRevisionEImagen(dato); 
          //$('#frmRevision').modal('show');

          document.getElementById('cmpObserva').disabled = true;
          document.getElementById('cmpComentario').disabled = true;

          obtenerRevisionEImagen(dato);
        }else {
          document.getElementById('txtMostrar').innerHTML = "";
          $("#txtMostrar").slideDown(50).delay(4000).slideUp(500);
          document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-danger" role="alert">
                                        <strong> Seleccione una revisión</strong>
                                        </div>`;
          $('#frmSolicita').modal('hide');
        }

      }
  }

// TODO: Función que obtiene los valores del campo de observacion
function obtenerRevisiones(data){
  dato = "";
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevision.php?varCod=5&varTarea='+data,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
    document.getElementById('cmpObservacion').value = "";
    document.getElementById('cmpObservacion').value = uneg[0][0].Descripcion;
    document.getElementById('cmpObservacion').disabled = true;    
  }).catch(error => {
    console.log(error);
  });
}

function obtenerRevisionEImagen(data){
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevision.php?varCod=6&varRvsn='+data+'&varPrcy='+globalVariable,
    responseType: 'json'
  }).then(res => {
    this.uneg = res.data;
        arrayData = this.uneg;
        renderizarImagen();
  }).catch(error => {
    console.log(error);
  });
}


function visualizaImagen(e){
var uploadFile = e.files[0];
var size = uploadFile.size / 1024 / 1024;

    if (!(/\.(jpg|png|gif)$/i).test(uploadFile.name)) {
        alert('El archivo a adjuntar no es una imagen');
        document.getElementById('imgRevision').value ='';
    }
    else {
         var img = new Image();
         img.onload = function () {
          //alert("entro al onload");
            if (this.width.toFixed(0) > 1980 && this.height.toFixed(0) > 1980) {
                //alert('Las medidas deben ser: 300 * 300');
                document.getElementById('imgRevision').value ='';
                document.getElementById('innerHTML').innerHTML = "";
                $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
                document.getElementById('innerHTML').innerHTML += `
                                              <div class="alert alert-danger" role="alert">
                                              <strong> El tamaño de la imagen excede para este campo </strong>
                                              </div>`;
            }
            else if (uploadFile.size > 2072576) // tamanio maximo para imagene es de 2Mb
            {
              document.getElementById('innerHTML').innerHTML = "";
              $("#innerHTML").slideDown(50).delay(5000).slideUp(500);
              document.getElementById('innerHTML').innerHTML += `
                                            <div class="alert alert-danger" role="alert">
                                            <strong> El peso de la imagen no puede exceder los 2 MB, el tamaño de la imagen es de: `  + uploadFile.size / 1000000  +  ` MB </strong>
                                            </div>`;
                //alert('El peso de la imagen no puede exceder los 200kb' + uploadFile.size);
                document.getElementById('imgRevision').value ='';
            }
            else {
                imagenes = e.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(e.files[0]);
                reader.onload = function(){
                  let preview =  document.getElementById('preview');
                  preview.innerHTML = '';
                  document.getElementById("preview").innerHTML = ['<img class="img-fluid" src="', reader.result,'" title="', escape(uploadFile.name), ' width=60; height=80;  "/>'].join('');
                  sendImagenAPostPHP(imagenes);
                };
            }
        };
          img.src = URL.createObjectURL(uploadFile);
    }
}


function sendImagenAPostPHP(imagenes){
  const formData = new FormData()
  formData.append('image', imagenes);
  axios({
      method: 'POST',
      url: '../Ctr/ctrRevisionImagenes.php?varData=0',
      data: formData,
      headers: {
          'Content-Type': 'multipart/form-data'
      }
  })
      .then(
          res => {
              console.log ('¡Carga exitosa!');
              this.uno = res.data;
              rutaImagen = res.data;
              console.log(res.data);
          }
      )
      .catch(
          err => {
               console.log ('¡Error de carga!')
          }
      )
}
//CODIGO DE PRUEBA PARA LA IMAGEN
/*
function PRUEBA(data){
  dato = "";
  axios({
    method: 'GET',
    url: '../Ctr/ctrRevisionImagenes.php?varData=1&contenid='+data,
    responseType: 'json'
  }).then(res => {
    document.getElementById('preview').innerHTML = '';
    this.uneg = res.data;
    for (let i = 0; i < uneg.length; i++) {
        var path = uneg[i][0].RutaImg;
        document.getElementById('preview').innerHTML +=
        `<img src="${uneg[i][0].RutaImg}" alt="Girl in a jacket" width="180" height="120">
          <br>`
        console.log("La gravedad: " + path);
    }
  }).catch(error => {
    console.log(error);
  });
}*/

function pasarFoto(){
  if(posicionActual >= arrayData.length - 1) {
              posicionActual = 0;
          } else {
              posicionActual++;
          }
          renderizarImagen();          
}

function retrocederFoto() {
       if(posicionActual <= 0) {
           posicionActual = arrayData.length - 1;
       } else {
           posicionActual--;
       }
       renderizarImagen();       
   }

function renderizarImagen() {

      if (arrayData <  0) {
        document.getElementById('txtMostrar').innerHTML = '';
		$("#txtMostrar").slideDown(50).delay(5000).slideUp(500);
		document.getElementById('txtMostrar').innerHTML += `
                                            <div class="alert alert-danger" role="alert">
                                            <strong>No hay revisiones para este rubro</strong>
                                            </div>`;
					
					
					
        $('#frmRevision').modal('hide');
        return -1;
      }
      $('#frmRevision').modal('show');
     document.getElementById("cmpComentario").value = "";
     document.getElementById('cmpObserva').value = "";
     document.getElementById('preview2').style.backgroundImage = "";


          document.getElementById('preview2').style.height = "400px";
          document.getElementById('preview2').style.width = "400px";
          document.getElementById('preview2').style.backgroundRepeat = "no-repeat";
          document.getElementById("preview2").style.backgroundSize = "400px 400px";

          document.getElementById("cmpComentario").value = arrayData[posicionActual][0]['Observaciones'];
          document.getElementById('cmpObserva').value = arrayData[posicionActual][0]['Comentario'];

          document.getElementById('preview2').style.backgroundImage = `url(${arrayData[posicionActual][0]['RutaImg']})`;

          document.getElementById("preview2").onclick = function() {verDetallesFoto(arrayData[posicionActual][0]['RutaImg'])};      
    }
  
    function verDetallesFoto(poscionFoto) {
        //alert(poscionFoto);
        slider[posicionActual];

        //window.open("", "", "width=200,height=100");
        var myWindow = window.open("", "Foto detalles", "width=300,height=200");
        myWindow.document.write(`<h1> ${slider[posicionActual]}   </h1>  `);
        myWindow.document.write();
        myWindow.focus();

        //var myWindow = window.open("", "MsgWindow", "width=200,height=100");
          //myWindow.document.write("<p>This is 'MsgWindow'. I am 200px wide and 100px tall!</p>");


} 