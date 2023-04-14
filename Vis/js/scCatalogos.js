function scCatalogos(parametros)
{
   switch(parametros){
       case 1:
            $('#winTrabajo').load('../vis/CatSolicitantes.html');
       break;
       case 2:
           $('#winTrabajo').load('../vis/catAreas.html');
       break;
       case 3:
           $('#winTrabajo').load('../vis/CatEmpleados.html');
       break;
       case 4:
          $('#winTrabajo').load('../vis/CatGteMtto.html');
         break;
       case 5:
          $('#winTrabajo').load('../vis/CatUsuarios.html');
        break;
        case 6:
          $('#winTrabajo').load('../vis/PrCatProyectos.html');
          break;
        case 7:
          $('#winTrabajo').load('../vis/prCatRubros.php');
          break;
        case 8:
           $('#winTrabajo').load('../vis/prCatRubroTarea.php');
        break;
        case 9:
          $('#winTrabajo').load('../vis/prArmaProyecto.php');
        break;
        case 10:
           $('#winTrabajo').load('../vis/prRevision.html');
        break;
        case 11:
           $('#winTrabajo').load('../vis/CatVehMaqPesada.php');
        break;
        case 12:
           $('#winTrabajo').load('../vis/RpvehMaqPesada.html');
         break;
   }
}
