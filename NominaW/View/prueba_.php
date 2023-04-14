<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bienvenidos</title>
</head>

<body>

<form >
	<div class="container">
		<p>Descripción: <input type="text" name="Descripcion" id="Descripcion"></p> 
		<p>Cantidad 1: <input type="text" name="Cantidad1" id="Cantidad1"></p>
		<p>Cantidad 2: <input type="text" name="Cantidad2" id="Cantidad2"></p>
		<p>Fecha: <input type="date" name="Fecha" id="Fecha"></p>
	</div>

	<!--<input class="btn btn-success" style="margin-left: 330px;" type="submit" value="Ingresar" >-->
	<button type="button" onclick="ingRegistro()">Aceptar</button>
</form>

	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	<script type="text/javascript" src="prue.js"></script>
</body>
</html>