<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="css/styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/login.css">

    <script src="../bootstrap/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="../js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/login.js"></script>

    <!-- Core theme JS-->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  </head>

  <body style= "background-color:#297F87;">

    <div class="wrapper fadeInDown" >
      <div id="formContent" > 
        <!-- Tabs Titles -->
        <h2 class="active">Inicio de Sesión</h2>
        <!--<h2 class="inactive underlineHover">Sign Up </h2> -->

        <!-- Icon -->
        <!--<div class="fadeIn first">
          <img src="assets/avim.jpg" id="icon" alt="User Icon" style="background:trasparent;"/>
        </div>
-->
        <div id="innerHTML"></div>
        <!-- Login Form -->
      <!--  <form id="myForm"> -->
          <input type="text" id="login" class="fadeIn second" name="usuario" placeholder="Ingresa Curp"> 
          <input type="button" class="fadeIn fourth" value="Entrar" onclick="IngLogin();">
    <!--    </form> -->
        
        <!--<div>
          <p id="idServidor"></p>
          <p id="idPath"></p>
        </div>-->

      </div>
    </div>
  </body>
</html>
