// codigo del modal cogido de https://www.w3schools.com/howto/howto_css_modals.asp

// Get the modal
var modal = document.getElementById("modalContra");

// Get the button that opens the modal
var btn = document.getElementById("botonModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
   resetModalInputs();
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
  resetModalMsgError()
  
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    resetModalMsgError()

  }
}





//codigo propio-------------------

var botonSubmit = document.getElementById("botonSubmit");

botonSubmit.addEventListener("click", e => {
  e.preventDefault();
  console.log("boton pulsado");
  let contra1= document.getElementById("contraInput").value;
  let contra2 = document.getElementById("contraInput2").value;

  if(contra1 != contra2)
  {
    if(document.getElementById("msgErrorContrasModal") == null)//solo se muestra el mensaje si no estaba ya antes
      e.target.insertAdjacentHTML("beforebegin", "<div id='msgErrorContrasModal' class='errorMSG'> Las contraseñas no coinciden</div>");
  }
  else{//las contras son iguales
     document.getElementById("formModalContras").submit();
    
  }

});

function resetModal()
{
  resetModalInputs();
  resetModalMsgError();

}

function resetModalInputs()
{
   let contra1= document.getElementById("contraInput");
  let contra2 = document.getElementById("contraInput2");
  contra1.value ="";
  contra2.value="";
}

function resetModalMsgError()
{
  let msgErrorModal = document.getElementById("msgErrorContrasModal");
  if(msgErrorModal != null)
  {
    msgErrorModal.remove();
  }
}



//contrasenias

$(document).ready(function() {
 
  $("#contraInput").change(comprobarNivelSeg)
  function comprobarNivelSeg()
  {
      var contSeg = 0;
      var text = String(document.querySelector("#contraInput").value)
      var divNivel = document.querySelector("#nivelContra")
      console.log(document.querySelector("#nivelContra"))
      var divColor ="<div class='divVerde'></div>"; 
      console.log(text)
      if(text.length >= 6)
      {
          console.log("mas de 6");
          contSeg++;
      }

      if(checkIfHasSpecialChar(text))
      {
          console.log("especiales");
          contSeg++;
      }

      if(contieneMayus(text))
      {
          console.log("mayus");
          contSeg++;
      }

      if(containsNumber(text))
      {
          console.log("nums");
          contSeg++;
      }

      var clase;
      var msg;
      if(contSeg == 0){
          clase = "divRojo"
          msg = "Muy mala"
      }  
      else if(contSeg == 1){
          clase = "divRojo"
          msg = "Mala"
      }  
      else if(contSeg == 2){
          clase = "divNaran"
          msg = "Media"
      }   
      else if(contSeg == 3){
          clase = "divVerde"
          msg = "Buena"
      }    
      else if(contSeg == 4){
          clase = "divVerdeFinal"
          msg = "Muy buena"
      }
          

      let contenido = "";
      for(var i = 0; i <= contSeg; i++)
      {
          contenido += "<div class='inlineBlockDiv divContra " + clase + "'> </div>"
      }

      if(text.length > 0) //solo mostramos mensajes si habia algun texto
      {
          divNivel.innerHTML = contenido
          document.querySelector("#msgNivel").innerHTML = msg;
      }
      else{
          divNivel.innerHTML = ""
          document.querySelector("#msgNivel").innerHTML = "";
      }

      
      console.log(contSeg)
  }




function contieneMayus(texto) {
  return String(texto).toLowerCase() != texto;
}

//fuente de la funcion:https://bobbyhadz.com/blog/javascript-check-if-string-contains-numbers#:~:text=To%20check%20if%20a%20string,otherwise%20false%20will%20be%20returned.
function containsNumber(str) {
  var aux = String(str);
  console.log(aux)
  return /\d/.test(aux);
}

function hasNumber(myString) {
  return /\d/.test(myString);
}

//fuente de la funcion: https://thispointer.com/javascript-check-if-string-contains-special-characters/
function checkIfHasSpecialChar(string)
{
  let spChars = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
  if(spChars.test(string)){
    return true;
  } else {
    return false;
  }
}









  $("#verContra1").click(ocultarMostrar1)
  $("#verContra2").click(ocultarMostrar2)

  function ocultarMostrar1()
  {
      var element = document.querySelector("#contraInput")

      ocultarMostrar(element)
  }

  function ocultarMostrar2()
  {
      var element = document.querySelector("#contraInput2")
      ocultarMostrar(element)
  }

  function ocultarMostrar(element)
  { 
      console.log("funcion ocultra mostrar")
      if(element.type == "text")
      {
          element.type = "password"
      }
      else if(element.type == "password")
      {
          element.type = "text"
      }
  }

})