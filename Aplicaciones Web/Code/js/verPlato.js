// codigo del modal cogido de https://www.w3schools.com/howto/howto_css_modals.asp
// Get the modal
var modificarPlatoModal = document.getElementById("modificarPlatoModal");

// Get the button that opens the modal
var modificarPlatoButton = document.getElementById("modificarPlatoButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
//try porque el boton que abre el modal no siempre se encuentra en el codigo html (depende del rol)
//y el error provocaria que no se ejecutara el resto de codigo javascript
try{
  modificarPlatoButton.onclick = function() {
    modificarPlatoModal.style.display = "block";
  }
}
catch{}


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modificarPlatoModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modificarPlatoModal) {
    modificarPlatoModal.style.display = "none";
  }
}

//-----------------------------------------------------------------------------

// Get the modal
var anadirValoracionModal = document.getElementById("anadirValoracionModal");

// Get the button that opens the modal
var anadirValoracionButton = document.getElementById("anadirValoracionButton");

// Get the <span> element that closes the modal
/* var span = document.getElementsByClassName("close")[0]; */
var span = anadirValoracionModal.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
//try porque el boton que abre el modal no siempre se encuentra en el codigo html (depende del rol)
//y el error provocaria que no se ejecutara el resto de codigo javascript
try{
  anadirValoracionButton.onclick = function () {
   
     anadirValoracionModal.style.display = "block";
  }
}
catch{}


// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    anadirValoracionModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == anadirValoracionModal) {
        anadirValoracionModal.style.display = "none";
    }
}