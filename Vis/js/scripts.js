document.addEventListener("DOMContentLoaded", function(event) {
   
  const showNavbar = (toggleId, navId, bodyId, headerId) =>{
  const toggle = document.getElementById(toggleId),
  nav = document.getElementById(navId),
  bodypd = document.getElementById(bodyId),
  headerpd = document.getElementById(headerId)
  
  // Validate that all variables exist
  if(toggle && nav && bodypd && headerpd){
  toggle.addEventListener('click', ()=>{
  // show navbar
  nav.classList.toggle('show')
  // change icon
  toggle.classList.toggle('bx-x')
  // add padding to body
  bodypd.classList.toggle('body-pd')
  // add padding to header
  headerpd.classList.toggle('body-pd')
  })
  }
  }
  document.querySelectorAll('.submenu').forEach(function(element){

    element.addEventListener('click', function (e) {
  
      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;
  
        if(nextEl) {
            e.preventDefault();
            let mycollapse = new bootstrap.Collapse(nextEl);
  
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    });
  })

  showNavbar('header-toggle','nav-bar','body-pd','header')
  
  /*===== LINK ACTIVE =====*/
  const linkColor = document.querySelectorAll('.nav_link')
  const linkColor2 = document.querySelectorAll('.nav-link')
  
  function colorLink(){
  if(linkColor){
  linkColor.forEach(l=> l.classList.remove('active'))
  this.classList.add('active')
  }
  }
  linkColor.forEach(l=> l.addEventListener('click', colorLink))

  function colorLink2(){
    if(linkColor2){
    linkColor2.forEach(l=> l.classList.remove('active2'))
    this.classList.add('active2')
    }
    }
    linkColor2.forEach(l=> l.addEventListener('click', colorLink2))
  });