// codigo del modal cogido de https://www.w3schools.com/howto/howto_css_modals.asp
// Get the modal
var anadirPlatoModal = document.getElementById("anadirPlatoModal");

// Get the button that opens the modal
var anadirPlatoButton = document.getElementById("abrirModalButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
anadirPlatoButton.onclick = function() {
  anadirPlatoModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  anadirPlatoModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == anadirPlatoModal) {
    anadirPlatoModal.style.display = "none";
  }
}


