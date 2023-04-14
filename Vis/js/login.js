function IngLogin(){
  axios({
  method:'POST',
  url:'../Ctr/ctrLogin.php',
  data: {
      usuario : document.getElementById('login').value,
      password : document.getElementById('password').value
  }
  }).then(res=>{	 
    if (isObject(res.data)) {
      location.href="../Vis/index.php";
    }else {
      document.getElementById('innerHTML').innerHTML = "";
      $("#innerHTML").slideDown(50).delay(4000).slideUp(500);
      document.getElementById('innerHTML').innerHTML += `
                                  <div class="alert alert-danger" role="alert">
                                  <strong> Error! </strong> Las datos ingresados no coinciden.
                                  </div>`;
    
	}
  }).catch (error=>{
      console.error(error);
  });
}


function cerrarSesion(){	
    axios({
        method:'GET',
        url:'../Ctr/ctrLogin.php',
        responseType:'json'
    }).then(res=>{
        console.log(res.data);
        window.location.reload();
    }).catch (error=>{
        console.error(error);
    });
}

function runScript(e){
  if (e.keyCode == 13) {
    IngLogin();
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

  function focunOnMe(){
    document.getElementById('login').focus();
    axios({
        method:'GET',
        url:'../Ctr/ctrLogin.php?var=path',
        responseType:'json'
    }).then(res=>{        
        var cadena = res.data.split("-");
        document.getElementById('idServidor').innerHTML = "Servidor: "+  cadena[0];
        document.getElementById('idPath').innerHTML = "Base de datos: "+cadena[1];

    }).catch (error=>{
        console.error(error);
    });

  }
