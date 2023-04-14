<?php

session_start();

$arreglo = $_SESSION['id_app'];

foreach ($arreglo[0] as $key => $value) {
  $date = $value['FechaIngreso'];

echo "
  <form>

                  <div class='border border-info container' style='font-family: bold; font-size: 15px; margin-top: 10px;''>
                    <div class='row'>
                       <div class='col'>
                        <p>Nombre: <input type='text' name='nombre' disabled=''></p>  
                      </div>";
                      <div class="col">
                         <p>Puesto: <input type="text" name="puesto" disabled=""></p>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col">
                        <p>Celular: <input type="text" name="celular" disabled=""></p>     
                      </div>
                      <div class="col">
                        <p">E-mail: <input type="text" name="correo" disabled=""></p>    
                      </div>
                    </div>       

                    <div class="row">
                      <div class="col">
                        <p>IMSS: <input type="text" name="imms" disabled=""></p>
                      </div>
                      <div class="col">
                        <p>Cta Bancaria: <input type="text" name="cuenta" disabled=""></p>
                      </div>
                    </div>           

                    <div class="row">
                      <div class="col">
                        <p>RFC: <input type="text" name="rfc" disabled=""></p>    
                      </div>
                      <div class="col">
                        <p>Direccion: <input type="text" name="direccion" disabled=""></p>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <p>Prestamos: <input type="text" name="prestamos" disabled=""></p>
                      </div>
                      <div class="col">
                         <p>Seguros: <input type="text" name="seguro" disabled=""></p>
                      </div>
                    </div>  
                  </div>
                  
                </form>
          ";
        }
?>