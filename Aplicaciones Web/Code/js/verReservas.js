
var thisReserva;
// codigo del modal cogido de https://www.w3schools.com/howto/howto_css_modals.asp
// Get the modal
var modificarReservaModal = document.getElementById("modificarReservaModal");

// Get the button that opens the modal
//var modificarReservaButton = document.getElementById("modificarReservaButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modificarReservaModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modificarReservaModal) {
    modificarReservaModal.style.display = "none";
  }
}



document.querySelectorAll('.modReserva').forEach(boton => {//aplica listeners a todos los botones de modificar reservas
  boton.addEventListener("click", modificarReserva);

});

function modificarReserva(e){
  thisReserva=e.target.dataset.id;
  console.log(thisReserva);
  $.ajax({
    type: 'post',
    url: 'procesarModificarReserva.php?id='+thisReserva,
    
    data: { id: thisReserva },
    success: function(response){ 
      // Add response in Modal body
      $('.modal-content').html(response);

      // Display Modal
      modificarReservaModal.style.display = "block";
    }

  })


}
