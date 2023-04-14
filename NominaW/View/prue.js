var usuario = [];
//const urlA = '../Ctr/ctrPrueba.php';
const urlAA = '../Ctr/ctrSolicitud.php';
var urlB   = '../Ctr/ctrLogin.php';
var urlC   = '../Ctr/ctrLogin.php';
var urlI   = '../View/index.php';
var datUser = [];
var datPer = [];
var curp = 0;
var urlER = '';

//var curpG = document.getElementById('curp').value;

function ingRegistro(){
	let usuario = {
		Descripcion: document.getElementById('Descripcion').value,
		Cantidad1: document.getElementById('Cantidad1').value, 
		Cantidad2: document.getElementById('Cantidad2').value,
		Fecha: document.getElementById('Fecha').value,
	};

	console.log('Usuario a guardar', usuario)

	axios({
		method: 'POST',
		url: urlA,
		responseType : 'json',
		params: usuario
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		console.error(error);
	});	
}


function selLogin(){
	/*let curp = {
		curp : document.getElementById('curp').value
	};
	console.log(curp);
	*/

	let datUser = {
		Nombre: "aca va un nombre",
		CodEmpleado: "aca va un cod",
		CodPuesto: "aca va un codP",
		/*Descripcion: document.getElementById('Descripcion').value,
		Cantidad1: document.getElementById('Cantidad1').value, 
		Cantidad2: document.getElementById('Cantidad2').value,
		Fecha: document.getElementById('Fecha').value,*/
	};

	curp = document.getElementById('curp').value;
	//alert(curp);
	urlB = urlB + '?curp='+ curp;
	urlC = urlB;
	console.log(urlB);
	//alert(curp);
	axios({
		method: 'GET',
		url: urlB,
		responseType : 'json',
		params: urlB
	}).then(res=>{
		console.log("<--->",res.data);
		datUser = res.data;
		datPer = datUser;
		//cperfil();
		//viewProfile();
		//console.log(datUser);
		//getDatos(datUser);
		//getDatosPer(datUser);
		//console.log("A punto de redireccionar");
		//console.log("-->",curpG);
		//muestraDatos(curp);
		//Acción para el redireccionamiento de la página web
		redPag();
	}).catch(error=>{
		console.error(error);
	});
}

function viewProfile(){
	curp = document.getElementById('cCurp').value;
	//alert(curp);
	urlTemp = '../Ctr/ctrLogin.php'+'curp?'+curp;
	urlTemp = urlTemp + '?foto=' + 1;
	urlC = urlB;
	console.log(urlB);
	axios({
		method: 'GET',
		url: urlB,
		responseType : 'json',
		params: urlB
	}).then(res=>{
		console.log(res.data);
		document.getElementById('imgFre').value = res.data[0][0].imgFrente;
		//datUser = res.data;
		//datPer = datUser;
	}).catch(error=>{
		console.error(error);
	});
}

function selVac(){
	var id;
	
	let data = {
		codEmpleado: document.getElementById('codEmpleado').value,
		nombre: document.getElementById('nombreSol').value, 
		apeP: document.getElementById('apeP').value,
		apeM: document.getElementById('apeM').value,
		fecNac: document.getElementById('fecNac').value,
		tArea: document.getElementById('tArea').value,
		tDep: document.getElementById('tDep').value,
		tCarg: document.getElementById('tCarg').value,
		tBen: document.getElementByName('tBen').value,
		tJor: document.getElementById('medTa').value,
		fecIni: document.getElementById('fecIni').value,
		fecFin: document.getElementById('fecFin').value,
		cubN: document.getElementById('cubN').value,
		FechaSol: document.getElementById('FechaSol').value
	};
	console.log(data);
	
	/*axios({
		method: 'POST',
		url: '../Ctr/ctrSolicitud.php',
		//responseType : 'json',
		//data: usuarios

		data: {
			codEmpleado: document.getElementById('codEmpleado').value,
			nombre: document.getElementById('nombreSol').value, 
			apeP: document.getElementById('apeP').value,
			apeM: document.getElementById('apeM').value,
			fecNac: document.getElementById('fecNac').value,
			tArea: document.getElementById('tArea').value,
			tDep: document.getElementById('tDep').value,
			tCarg: document.getElementById('tCarg').value,
			tBen: document.getElementById('tBen').value,
			tJor: document.getElementById('tJor').value,
			fecIni: document.getElementById('fecIni').value,
			fecFin: document.getElementById('fecFin').value,
			cubN: document.getElementById('cubN').value,
			FechaSol: document.getElementById('FechaSol').value
		}
	}).then(res=>{
		console.log(res.data);
		limp();
		console.log("Lo logramos");
	}).catch(error=>{
		console.log(document.getElementById('FechaSol').value);
		limp();
		alert("Solicitud Enviada");
		console.log("Entra aca!!");
		console.error(error);
	});*/
}

function calcular(){
	var fecIni = new Date(document.getElementById('fecIni').value);
	var fecFin = new Date(document.getElementById('fecFin').value);
	var diasdif= fecFin.getTime()-fecIni.getTime();
	var contdias = Math.round(diasdif/(1000*60*60*24));
	//alert("Numero de días: " + contdias);
}

function SolGuar(){

	let usuario = {
		opc: document.getElementById('opc').value,
		codEmpleado: document.getElementById('EmpCod').value,
		fecSol: document.getElementById('fecSol').value, 
		fecGuard: document.getElementById('fecGuard').value
	};

	console.log('Usuario a guardar', usuario)
	axios({
		method: 'POST',
		url: '../Ctr/ctrSolicitud.php',
		//responseType : 'json',
		data: {
			"opc": document.getElementById('opc').value,
			"codEmpleado": document.getElementById('EmpCod').value,
			"fecSol": document.getElementById('fecSol').value, 
			"fecGuard": document.getElementById('fecGuard').value
		}
	}).then(res=>{
		console.log(res.data);
		limpGuardias();
		
	}).catch(error=>{
		limpGuardias();
		alert("Solicitud Enviada");
		console.log("Entra aca!!");
		
	});
}

function guarPres(){
	let usuario = {
		opc: document.getElementById('opcp').value,
		fecSol: document.getElementById('fecSolP').value,
		codEmpleado: document.getElementById('EmpCod_').value,
		codArea : document.getElementById('tAre').value,
		codSa: document.getElementById('tDe').value,
		codP: document.getElementById('tCa_').value,
		sueldo: document.getElementById('tSuel_').value,
		cantidad1: document.getElementById('monto').value,
		mot: document.getElementById('tmov_').value
	};

	console.log('Solicitud a Guardar --->:  ', usuario)
	axios({
		method: 'POST',
		//url: '../Ctr/ctrSolicitud.php',
		url: '../Ctr/ctrPrestamos.php',
		//responseType : 'json',
		data: {
			opc: document.getElementById('opcp').value,
			fecSol: document.getElementById('fecSolP').value,
			codEmpleado: document.getElementById('EmpCod_').value,
			codArea : document.getElementById('tAre').value,
			codSa: document.getElementById('tDe').value,
			codP: document.getElementById('tCa_').value,
			sueldo: document.getElementById('tSuel_').value,
			cantidad1: document.getElementById('monto').value,
			mot: document.getElementById('tmov_').value,
			Estatus:"0"
		}
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		
		console.log("Entra aca!!");
		
	});
}

function SolGuar(){

	let usuario = {
		opc: document.getElementById('opc').value,
		codEmpleado: document.getElementById('EmpCod').value,
		fecSol: document.getElementById('fecSol').value, 
		fecGuard: document.getElementById('fecGuard').value
	};

	console.log('Usuario a guardar', usuario)
	axios({
		method: 'POST',
		url: '../Ctr/ctrSolicitud.php',
		//responseType : 'json',
		data: {
			"opc": document.getElementById('opc').value,
			"codEmpleado": document.getElementById('EmpCod').value,
			"fecSol": document.getElementById('fecSol').value, 
			"fecGuard": document.getElementById('fecGuard').value
		}
	}).then(res=>{
		console.log(res.data);
		//alert(res.data);
		//limp();
		//console.log("Lo logramos");
	}).catch(error=>{
		//alert("Solicitud Enviada");
		console.log("Entra aca!!");
		//console.error(error);
	});
}

function saveSeguro(){
	axios({
		method: 'POST',
		url: '../Ctr/ctrSolicitud.php',

		data: {
			"btnAuto": document.getElementById('auto').value,
			"btnVida": document.getElementById('vida').value,
			"CodEmpleado": document.getElementById('EmpCodS_').value,
			"Marca": document.getElementById('marca').value,
			"Modelo": document.getElementById('modelo').value,
			"Anio": document.getElementById('anio').value, 
			"NumPuertas": document.getElementById('nump').value,
			"Placas": document.getElementById('plac').value,
			"Factura": document.getElementById('nFac').value,
			"TarCirculacion": document.getElementById('nTc').value,
			"NumSerie": document.getElementById('nSer').value,
			"NumMotor": document.getElementById('nMoc').value,

			"Fuma": document.getElementById('fuma').value,
			"Toma": document.getElementById('toma').value,
			"MontoS": document.getElementById('montoS').value,
			"MontoD": document.getElementById('desSe').value
		}
	}).then(res=>{
		console.log(res.data);
		//alert(res.data);
		//limp();
		//console.log("Lo logramos");
	}).catch(error=>{
		//alert("Solicitud Enviada");
		console.log(document.getElementById('vida').value);
		console.log("Entra aca!!");
		//console.error(error);
	});

}

function limp(){
	$('#codEmpleado').val("");
	$('#nombreSol').val("");
	$('#apeP').val("");
	$('#apeM').val("");
	$('#fecN').val("");
	$('#tArea').val("");
	$('#tDep').val("");
	$('#tCarg').val("");
	$('#tBen').val("");
	$('#tJor').val("");
	$('#fecIni').val("");
	$('#fecFin').val("");
	$('#cubN').val("");
}

function limpGuardias(){
	$('#EmpCod').val("");
	$('#nombreSoli').val("");
	$('#apeP_').val("");
	$('#apeM_').val("");
	$('#tArea_').val("");
	$('#tDep_').val("");
	$('#tCarg_').val("");
}
const myData = function (data){
	curpG  = data.curp;
	console.log(curpG);
}

function redPag(){
	window.location.replace("../View/index.php");
	console.log(datPer);
	//viewProfile();
	alert("hola");
	//console.log(curp);
	//getDatosPer();
	//mostrar();
	//console.log("Estos son los datos: ", getDatosPer(datUser));
	//window.location="http://192.168.1.65/NominaW/../index.php";
	//window.location.href = 'http://192.168.1.65/NominaW/../index.php ';
}


function getDatos(datUser){
	curpG = datUser.curp;
	console.log(curpG);
	document.querySelector('#datosPer').innerHTML +=
	`<p>Nombre: <input value = "${datUser[0][0].Nombre}" disabled=""></input></p>
	<p>CodEmpleado: <input value = ${datUser[0][0].CodEmpleado} disabled=""></input></p>
	<p>CodPuesto: <input value = ${datUser[0][0].CodPuesto} disabled=""></input></p>`;
	console.log("--->", datUser);
	//console.log(${datUser[0][0].Estatus});

	//console.log(${usuario.Nombre});
}

	//funcionando al 100%
function muestraDatos(){
   // alert(urlC);
	usuario = document.getElementById('curpSesion').value;
	//foto = '0';
	opc = '1';
	//alert(usuario);
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
		this.nom = res.data;
		//alert(res.data);
		//console.log(res.data);
		//alert(res.data);
		
        console.log(nom);
		//alert(nom[0][0].Nombre);
		document.getElementById('nombre').value = nom[0][0].Nombre;
		document.getElementById('cel').value = nom[0][0].Celular;
		document.getElementById('codp').value = nom[0][0].Pdesc;
		document.getElementById('ctb').value = nom[0][0].CtaBancarea;
		document.getElementById('rfcv').value = nom[0][0].RFC;
		document.getElementById('dir').value = nom[0][0].Direccion;
		document.getElementById('prestamos').value = nom[0][0].Prestamo;

		//contacto de emergencia
		document.getElementById('nomc').value = nom[0][0].NombreEm;
		document.getElementById('dirEm').value = nom[0][0].DireccionEm;
        document.getElementById('telEm').value = nom[0][0].TelefonoEm;
		document.getElementById('celEm').value = nom[0][0].CelularEm;

		//Deducciones
		document.getElementById('area').value = nom[0][0].DescArea;
		document.getElementById('subA').value = nom[0][0].DescSa;
		document.getElementById('tnom').value = nom[0][0].CodTipoNomina;
		document.getElementById('puesto').value = nom[0][0].Pdesc;
		document.getElementById('suelD').value = nom[0][0].SalarioDiario;
		document.getElementById('suelN').value = nom[0][0].Sueldo;

		//Vacaciones
		document.getElementById('vac').value = nom[0][0].VacTomadas;
		document.getElementById('vacR').value = nom[0][0].Restantes;
		document.getElementById('vacA').value = nom[0][0].VacTotal;
		
		//CodEmpleadoEstatus
		document.getElementById('CodEmEs').value = nom[0][0].codEmpleado;
		
		/*for (var i=0; i< res.data.length; i++)
		{
			//Para obtener el objeto de tu lista
			var hotel = res.data[i];
			//Mostramos el objeto en su versión String
			console.log(JSON.stringify(hotel));
			//Muestras el valor de la propiedad name para el objeto viaje, del objeto hotel.
			//console.log(hotel.viaje.origen.name)
		}*/
        /*document.getElementById('nombre').value = res.data[0][0].Nombre;
        document.getElementById('codp').value = res.data[0][0].PDescripcion;
       
        document.getElementById('cel').value = res.data[0][0].Celular;
        document.getElementById('ctb').value = res.data[0][0].CtaBancarea;
        document.getElementById('rfcv').value = res.data[0][0].RFC;
        document.getElementById('dir').value = res.data[0][0].Direccion;
		document.getElementById('prestamos').value = res.data[0][0].Prestamo;

		document.getElementById('nomc').value = res.data[0][0].NombreEm;
        document.getElementById('dirEm').value = res.data[0][0].DireccionEm;
        document.getElementById('telEm').value = res.data[0][0].TelefonoEm;
		document.getElementById('celEm').value = res.data[0][0].CelularEm;

		document.getElementById('area').value = res.data[0][0].CodArea;
		document.getElementById('subA').value = res.data[0][0].Descripcion;
		document.getElementById('tnom').value = res.data[0][0].CodTipoNomina;
		document.getElementById('puesto').value = res.data[0][0].PDescripcion;
		document.getElementById('suelD').value = res.data[0][0].SalarioDiario;
		document.getElementById('suelN').value = res.data[0][0].Sueldo;
		alert("entraste acasadasdas");
		*/
    }).catch(error=>{
        console.error(error);
    });
}	
//funcionando al 100%
function llenado(){
    usuario = document.getElementById('curpSesion').value;
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
		console.log("estas desde esta parte");
		console.log(res.data);
        console.log(res.data[0][0]);
		document.getElementById('opc').value = 1;
		document.getElementById('EmpCod').value = res.data[0][0].codEmpleado;
        document.getElementById('nombreSoli').value = res.data[0][0].Nombre;
        document.getElementById('apeP_').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apeM_').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tArea_').value = res.data[0][0].CodArea;
		document.getElementById('tDep_').value = res.data[0][0].DescSa;
		document.getElementById('tCarg_').value = res.data[0][0].Pdesc;

    }).catch(error=>{
        console.error(error);
		console.log("estas desde esta parte___222");
    });
}	

//rellenar campos de requerimientos
function relleno(){
usuario = document.getElementById('curpSesion').value;
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
		console.log("estas desde esta parte");
		console.log(res.data);
        console.log(res.data[0][0]);
		document.getElementById('opc').value = 1;
		//document.getElementById('EmpCod').value = res.data[0][0].codEmpleado;
        document.getElementById('recipient-name').value = res.data[0][0].Nombre + " " +res.data[0][0].ApellidoPaterno + " " + res.data[0][0].ApellidoMaterno;
        /*document.getElementById('apeP_').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apeM_').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tArea_').value = res.data[0][0].CodArea;
		document.getElementById('tDep_').value = res.data[0][0].DescSa;
		document.getElementById('tCarg_').value = res.data[0][0].Pdesc;
*/
    }).catch(error=>{
        console.error(error);
		console.log("estas desde esta parte___222");
    });

}

function rellenouno(){
usuario = document.getElementById('curpSesion').value;
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
		console.log("estas desde esta parte");
		console.log(res.data);
        console.log(res.data[0][0]);
		document.getElementById('opc').value = 1;
		//document.getElementById('EmpCod').value = res.data[0][0].codEmpleado;
        document.getElementById('recipient-nameuno').value = res.data[0][0].Nombre + " " +res.data[0][0].ApellidoPaterno + " " + res.data[0][0].ApellidoMaterno;
        /*document.getElementById('apeP_').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apeM_').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tArea_').value = res.data[0][0].CodArea;
		document.getElementById('tDep_').value = res.data[0][0].DescSa;
		document.getElementById('tCarg_').value = res.data[0][0].Pdesc;
*/
    }).catch(error=>{
        console.error(error);
		console.log("estas desde esta parte___222");
    });

}



function llenadoPres(){
    curp = document.getElementById('curpSesion').value;
	//alert(curp);
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php'+ '?curp='+ curp+'&opc=1',
        responseType : 'json'
    }).then(res=>{
        console.log(res.data[0][0]);
		document.getElementById('EmpCod_').value = res.data[0][0].codEmpleado;
        document.getElementById('nombreSo').value = res.data[0][0].Nombre;
        document.getElementById('apP_').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apM_').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tAre').value = res.data[0][0].CodArea;
		document.getElementById('tAreD').value = res.data[0][0].DescArea;
		document.getElementById('tDe').value = res.data[0][0].CodSubArea;
		document.getElementById('tDeD').value = res.data[0][0].DescSa;
		document.getElementById('tCa_').value = res.data[0][0].CodPuesto;
		document.getElementById('tCa_D').value = res.data[0][0].Pdesc;
		document.getElementById('tSuel_').value = res.data[0][0].Sueldo;

    }).catch(error=>{
        console.error(error);
    });
}	

function llenadoSeg(){
    curp = 'GOPC960320HCSRNR10';
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php'+ '?curp='+ curp,
        responseType : 'json'
    }).then(res=>{
        console.log(res.data[0][0]);
		document.getElementById('EmpCodS_').value = res.data[0][0].CodEmpleado;
        document.getElementById('nom').value = res.data[0][0].Nombre + " " + res.data[0][0].ApellidoPaterno + " " + res.data[0][0].ApellidoMaterno;
        /*document.getElementById('apP_').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apM_').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tAre').value = res.data[0][0].CodArea;
		document.getElementById('tDe').value = res.data[0][0].Descripcion;
		document.getElementById('tCa_').value = res.data[0][0].PDescripcion;*/

    }).catch(error=>{
        console.error(error);
    });
}	

function cperfil(){
    curp = 'GOPC960320HCSRNR10';
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php'+ '?curp='+ curp + '?foto=' + 1,
        responseType : 'json'
    }).then(res=>{
        console.log(res.data);

    }).catch(error=>{
        console.error(error);
    });
}

//listo 100%
function llenar(){
    usuario = document.getElementById('curpSesion').value;
	//alert(curp);
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
        console.log(res.data[0][0]);
		document.getElementById('codEmpleado').value = res.data[0][0].codEmpleado;
        document.getElementById('nombreSol').value = res.data[0][0].Nombre;
        document.getElementById('apeP').value = res.data[0][0].ApellidoPaterno;
        document.getElementById('apeM').value = res.data[0][0].ApellidoMaterno;
		document.getElementById('tArea').value = res.data[0][0].CodArea;
		document.getElementById('tDep').value = res.data[0][0].DescSa;
		document.getElementById('tCarg').value = res.data[0][0].Pdesc;
    }).catch(error=>{
        console.error(error);
    });
}	

//listo 100%
function llenarModificacion(){
    usuario = document.getElementById('curpSesion').value;
	//alert(curp);
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
        console.log(res.data[0][0]);
		document.getElementById('dirmod').value = res.data[0][0].Direccion;
        document.getElementById('ctamod').value = res.data[0][0].CtaBancarea;
        //document.getElementById('emamod').value = res.data[0][0].Email;
        document.getElementById('celmod').value = res.data[0][0].Celular;
    }).catch(error=>{
        console.error(error);
    });
}	

function muestraDatos2(){
    //curpG = data.curp;
	//console.log(curpG);
    //alert(urlC);
	curp = 'GOPC960320HCSRNR10';
	urlER = '../Ctr/ctrLogin.php'+ '?curp='+ curp + '?foto=' + 1;
	console.log(urlER);
    axios({
        method: 'GET',

        url: '../Ctr/ctrLogin.php'+ '?curp='+ curp + '?foto=' + 1,
        responseType : 'json'
    }).then(res=>{
        console.log(res.data[0][0]);
      
		//document.getElementById('area').value = res.data[0][0].CodArea;
		//document.getElementById('subA').value = res.data[0][0].CodSubArea;

    }).catch(error=>{
        console.error(error);
    });
}


function mostrarD(){
	console.log(datPer);
	getDatosPer(datUser);
}

function datosEme(){
	let data = {
		"curp": document.getElementById('curpSesion').value,
		"NombreEm": document.getElementById('nomc').value,
		"DireccionEm": document.getElementById('dirEm').value,
		"CelularEm": document.getElementById('celEm').value,
		"TelefonoEm": document.getElementById('telEm').value
	};
	console.log(data);

	axios({
		method: 'POST',
		url: '../Ctr/ctrEdicion.php',
		
		data: {
			"curp": document.getElementById('curpSesion').value,
			"NombreEm": document.getElementById('nomc').value,
			"DireccionEm": document.getElementById('dirEm').value,
			"CelularEm": document.getElementById('celEm').value,
			"TelefonoEm": document.getElementById('telEm').value
		}
		
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		console.error(error);
	});
	
	/*curp = document.getElementById('curpSesion').value;
	nombreE = document.getElementById('nomc').value;
	console.log(nombreE);
	console.log(curp);
	console.log(datosUsuario);*/
}

function solicitudMod(){
	let data = {
		"curp": document.getElementById('curpSesion').value,
		"Direccion": document.getElementById('dirmod').value,
		"ctabancaria": document.getElementById('ctamod').value,
		"celular": document.getElementById('celmod').value
	};
	console.log(data);

	axios({
		method: 'POST',
		url: '../Ctr/ctrEdicionDat.php',
		
		data: {
			"curp": document.getElementById('curpSesion').value,
			"Direccion": document.getElementById('dirmod').value,
			"CtaBancarea": document.getElementById('ctamod').value,
			"Celular": document.getElementById('celmod').value
		}
		
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		console.error(error);
		console.log("estas mal");
	});
}

function enviaC(){
	let data = {
		"curp": document.getElementById('curpSesion').value,
		"NombreC": document.getElementById('recipient-name').value,
		"Motivo": document.getElementById('message-text').value
	};
	console.log(data);
	
	axios({
		method: 'POST',
		url: '../Ctr/ctrEdicionDat.php',
		
		data: {
			"curp": document.getElementById('curpSesion').value,
			"NombreC": document.getElementById('recipient-name').value,
			"Motivo": document.getElementById('message-text').value,
			"opc":"1"
		}
		
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		console.error(error);
		console.log("estas mal");
	});
}

function enviaCarta(){
	let data = {
		"curp": document.getElementById('curpSesion').value,
		"NombreC": document.getElementById('recipient-name').value,
		"Motivo": document.getElementById('message-text').value
	};
	console.log(data);
	
	axios({
		method: 'POST',
		url: '../Ctr/ctrEdicionDatos.php',
		
		data: {
			"curp": document.getElementById('curpSesion').value,
			"NombreC": document.getElementById('recipient-nameuno').value,
			"Motivo": document.getElementById('message-textuno').value,
			"opc":"1"
		}
		
	}).then(res=>{
		console.log(res.data);
	}).catch(error=>{
		console.error(error);
		console.log("estas mal");
	});
}

function selVacaciones(){
	var id;

	let data = {
			codEmpleado: document.getElementById('codEmpleado').value,
				nombre: document.getElementById('nombreSol').value,
				apeP: document.getElementById('apeP').value,
				apeM: document.getElementById('apeM').value,
				fecNac: document.getElementById('fecNac').value,
				tArea: document.getElementById('tArea').value,
				tDep: document.getElementById('tDep').value,
				tCarg: document.getElementById('tCarg').value,
				tBen: document.getElementById('tBen').value,
				tJor: document.getElementById('tJor').value,
				fecIni: document.getElementById('fecIni').value,
				fecFin: document.getElementById('fecFin').value,
				cubN: document.getElementById('cubN').value,
				FechaSol: document.getElementById('FechaSol').value,
				firmaG:"0",
				firmaRh:"0",
				firmaGG:"0"
		};
		console.log(data);

	
	axios({
		method: 'POST',
		url: '../Ctr/CtrSolVacaciones.php',
		//responseType : 'json',
		//data: usuarios

		data: {
			codEmpleado: document.getElementById('codEmpleado').value,
			nombre: document.getElementById('nombreSol').value,
			apeP: document.getElementById('apeP').value,
			apeM: document.getElementById('apeM').value,
			fecNac: document.getElementById('fecNac').value,
			tArea: document.getElementById('tArea').value,
			tDep: document.getElementById('tDep').value,
			tCarg: document.getElementById('tCarg').value,
			tBen: document.getElementById('tBen').value,
			tJor: document.getElementById('tJor').value,
			fecIni: document.getElementById('fecIni').value,
			fecFin: document.getElementById('fecFin').value,
			cubN: document.getElementById('cubN').value,
			FechaSol: document.getElementById('FechaSol').value,
			firmaG: "0",
			firmaRh:"0",
			firmaGG:"0"
		}
	}).then(res=>{
		console.log(res.data);
		limp();
		console.log("Lo logramos");
		alert("Solicitud Generada con Exito");
	}).catch(error=>{
		console.log(document.getElementById('FechaSol').value);
		limp();
		alert("Solicitud Enviada");
		console.log("Entra aca!!");
		console.error(error);
	});
}

//Área para la subida de archivos al servidor

/*function sbAc(){
	cod = '010101';
	sub = '4';
	let usuario = {
		Sub: sub,
		Cod: cod,
		Acta: document.getElementById('Acta').value
	};
	
	console.log('Usuario a guardar', usuario)
	axios({
		method: 'POST',
		url: '../Ctr/ctrSolicitud.php',
		//responseType : 'json',
		data: {
			opc: sub,
			Cod: cod,
			Acta: document.getElementById('Acta').value
		}
	}).then(res=>{
		console.log(res.data);
		//alert(res.data);
		//limp();
		//console.log("Lo logramos");
	}).catch(error=>{
		//alert("Solicitud Enviada");
		console.log("Entra aca!!");
		//console.error(error);
	});
}

*/

/*<div class="row">
                       <div class="col">
                        <p>Nombre: <input type="text" name="nombre" disabled=""></p>  
                      </div>
                      <div class="col">
                         <p>Puesto: <input type="text" name="puesto" disabled=""></p>
                      </div>
                    </div>
                    */