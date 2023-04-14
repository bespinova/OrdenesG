// Write on keyup event of keyword input element
$(document).ready(function() {

  // VARIABLES GLOBALES
  var web = $(document);
  var logo = $(".logo");
  var anclas = $('a[href*="#"]');
  var website = $('html, body');  
  var buscador = $('.buscador');
  var menu_links = $('.menu.lateral a');
  
//   menu_links.on( "click", function(){
//     limpiarBuscador();
//   });
  
//   function limpiarBuscador(){
//     buscador.val('').finish();
//   }
  
  //funcion para abrir los plegables
  buscador.blur(function(){
     $(".lista").removeClass("open"); 
    $("#expandir-todo").prop('checked', false);         
  });
  
  //Activar el buscador
  buscador.keyup(function() {    
    
    $(".lista").addClass("open");
    $("#expandir-todo").prop('checked', true);
    
    _this = this;
    // grupo de cosas que se ocultaran
    $.each($("#grupo-busqueda .seccion li, #grupo-busqueda .seccion, #grupo-busqueda .subseccion"), function() {
      if (
        $(this)
        .text()
        .toLowerCase()
        .indexOf(
          $(_this)
          .val()
          .toLowerCase()
        ) === -1
      ){
        $(this).hide();
      }
      else {
        $(this).show();
      }
    });
    
  });

// prevenir el salto de pagina en enlaces trigger
  function ancla_scroll() {
    anclas.on("click", scroll_A);  
  };

  function scroll_A (){
    event.preventDefault();
    var where = $(this).attr('href');
    website.animate({ 
      scrollTop : $( where ).offset().top-80 }, 'slow');
  };

  ancla_scroll();
  
});