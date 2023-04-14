/*function solpruebas(){
	
	console.log("probando");
	
	let usuarios = {
		ValorOpc: document.getElementById('btnEsVac').value,
		cod: document.getElementById('CodEmEs').value
		
	};
	
	usuario = document.getElementById('CodEmEs').value;
	
	axios({
        method: 'GET',

        url: '../Ctr/ctrSeguimiento.php?curp='+ usuario+'&opc=1',
        responseType : 'json'
    }).then(res=>{
		this.nom = res.data;
		
        console.log(nom);

    }).catch(error=>{
        console.error(error);
		console.log("curp",URL);
    });
	
}*/

function solpruebas(){
    autoridad = "0";
	
	let usuarios = {
		ValorOpc: document.getElementById('btnEsVac').value,
		cod: document.getElementById('CodEmEs').value
		
	};
	
	usuario = document.getElementById('CodEmEs').value;

    axios({
        method:'GET',
        url:'../Ctr/ctrAutorizacion.php?opc='+usuario+'&opcs=5',
        responseType:'json'
    }).then(res=>{
		console.log(res.data);

        if(isObject(res.data)){
            this.estatus = res.data;
            llenarTablaEstado();
        }else {
            //llenarTabla2();
			//console.log(res.data);
            alert('No hay registros');
            /*document.getElementById('txtMostrar').innerHTML = "";
            document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong> ! Alerta ¡ </strong>${res.data}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;*/
        }
    }).catch (error=>{
        console.error(error);
    });
}

function llenarTablaEstado()
{
    var algo = Codigo;
	$("#tblStatus tr").remove();
	$("#tblStatusG tr").remove();
    document.querySelector('#tblStatus thead').innerHTML +=
        `<tr>
            <th>Fecha Solicitud</th>
            <th>Beneficio</th>
            <th>Gerente</th>
            <th>RH</th>
            <th>Gerencia General</th>
        </tr>`;
    
	//console.log(estatus);
    for(let i=0; i <estatus.length; i++){
        //var cod = osOrd[i][0].Nombre;
        document.querySelector('#tblStatus tbody').innerHTML +=
        `<tr>
                <td>${estatus[i][0].FechaSol}</td>
                <td>${estatus[i][0].tBen}</td>
                <td>${estatus[i][0].firmaG}</td>
                <td>${estatus[i][0].firmaRh}</td>
                <td>${estatus[i][0].firmaGG}</td>
         </tr>`;
    }
}



//estado de las guardias solicitadas

function solpruebasGuardias(){
    autoridad = "0";
	
	let usuarios = {
		ValorOpc: document.getElementById('btnEsVac').value,
		cod: document.getElementById('CodEmEs').value
		
	};
	
	usuario = document.getElementById('CodEmEs').value;

    axios({
        method:'GET',
        url:'../Ctr/ctrAutorizacion.php?opc='+usuario+'&opcs=6',
        responseType:'json'
    }).then(res=>{
		console.log(res.data);

        if(isObject(res.data)){
            this.estatusG = res.data;
            llenarTablaEstadoGuardia();
        }else {
            //llenarTabla2();
			//console.log(res.data);
            alert('No hay registros');
            /*document.getElementById('txtMostrar').innerHTML = "";
            document.getElementById('txtMostrar').innerHTML += `
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong> ! Alerta ¡ </strong>${res.data}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>`;*/
        }
    }).catch (error=>{
        console.error(error);
    });
}

function llenarTablaEstadoGuardia()
{
    var algo = Codigo;
	$("#tblStatus tr").remove();
	$("#tblStatusG tr").remove();
    document.querySelector('#tblStatusG thead').innerHTML +=
        `<tr>
            <th>Fecha Solicitud</th>
            <th>Fecha Guardia</th>
            <th>Gerente</th>
        </tr>`;
    
	//console.log(estatus);
    for(let i=0; i <estatusG.length; i++){
        //var cod = osOrd[i][0].Nombre;
        document.querySelector('#tblStatusG tbody').innerHTML +=
        `<tr>
                <td>${estatusG[i][0].fecSol}</td>
                <td>${estatusG[i][0].fecGuard}</td>
                <td>${estatusG[i][0].autG}</td>
         </tr>`;
    }
}
