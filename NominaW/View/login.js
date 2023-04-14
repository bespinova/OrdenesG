function login(){
  var conexion,form,response, result,curp,sesion;
  curp = __('curp').value;

  form = 'curp=' + curp;

  //conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if (conexion.readyState == 4 && conexion.status == 200) {
      if (conexion.responseText == 1) {
        result = '<div class="alert alert-dismissible alert-success">';
        result += '<h4 class="alert-heading">Conectado</h4>';
        result +='<p><strong>Estamos redireccionandote... f</strong></p>';
        result +='</div>';
        __('_AJAX_LOGIN_').innerHTML = result;
        //console.log(conexion.responseText);
        //location.reload();
        window.location="http://192.168.1.74/NominaW/View/index.php";


      }else {
        __('_AJAX_LOGIN_').innerHTML = conexion.responseText;
      }

    }else if (conexion.readyState != 4) {
      result = '<div class="alert alert-dismissible alert-warning">';
      result += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
      result += '<h4 class="alert-heading">Procesando...</h4>';
      result +='<p><strong>Estamos intentando loguearte...</strong></p>';
      result +='</div>';
      //console.log(conexion.readyState);
        //window.alert(conexion.responseText);
      __('_AJAX_LOGIN_').innerHTML = result;
    }
  }
  conexion.open('POST','http://192.168.1.74/NominaW/Ctr/ctrLogin.php',true);
  conexion.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  conexion.send(form);
}

function runScript(e){
  if (e.keyCode == 13) {
    loginOn();
  }
}
