var dato;
var CodGetMattoSlc;
var EstatusDocSlc;
var CodGteMattoSsc;
var CodSolicitante;

$(document).ready(function(){
    $('#tblOsG tbody').on('click','tr', function (event) {

    dato = $(this).find('td:first').html();
    //CodGetMattoSlc = $(this).find('td:nth-child(10)').html();
    //EstatusDocSlc = $(this).find('td:nth-child(8)').html();
      $('td',this).addClass('selected');
      $(this).siblings().find('td').removeClass('selected');
    }); 

    
    ObtenertOsT();
});

var uneg = [];
var opcion = 0;
var strRsp = "";

function rstFiltros() {
    document.querySelector('#CboEstatus').options.selected = true;
    ObtenertOsT();
}

function ObtenertOsT() {
    valor = document.querySelector('#CboEstatus');
    Es= valor.value;
    dato = "";

    axios({
        method:'GET',
        url:'../Ctr/ctrRpvehMaqPesada.php?op=0&disponible='+Es,
        responseType:'json'
    }).then(res=>{
        //console.log(res.data);
        this.uneg = res.data;
        if(isObject(res.data)){
            console.log(this.uneg);
            llenarTabla();
        }else{
            $("#tblRpMq tr").remove();
            document.querySelector('#tblRpMq thead').innerHTML +=
            `<tr>
                <th scope="col">Cod.Unidad</th>
                <th scope="col">Descripción</th>
                <th scope="col">Tipo de Vehículo</th>
                <th scope="col">Núm. del Servicio</th>
                <th scope="col">Descripción de Fallo</th>
                <th scope="col">Fecha Asignación</th>
            </tr>`
            document.querySelector('#tblRpMq tbody').innerHTML +=
            `<tr>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
                <td>NO HAY REGISTROS</td>
            </tr>`
        } 
    }).catch (error=>{
        console.error(error);
    });
}
function llenarTabla() {
    $("#tblRpMq tr").remove();
    document.querySelector('#tblRpMq thead').innerHTML +=
    `<tr>
        <th scope="col">Cod.Unidad</th>
        <th scope="col">Descripción</th>
        <th scope="col">Tipo de Vehículo</th>
        <th scope="col">Núm. del Servicio</th>
        <th scope="col">Descripción de Fallo</th>
        <th scope="col">Fecha Asignación</th>
    </tr>`
    for(let i=0; i < uneg.length; i++){
    document.querySelector('#tblRpMq tbody').innerHTML +=
    `<tr>
        <td class="col">${uneg[i][1]}</td>
        <td class="col">${uneg[i][2]}</td>
        <td class="col">${uneg[i][3]}</td>
        <td class="col">${uneg[i][4]}</td>
        <td class="col">${uneg[i][5]}</td>
        <td class="col">${uneg[i][0]}</td>
    </tr>`;
    }
}
/**
 *         <td class="col">${uneg[i][0].CodArea}</td>
        <td class="col">${uneg[i][0].Nombre}</td>
        <td class="col">${uneg[i][0].CodUNegocio}</td>
 */