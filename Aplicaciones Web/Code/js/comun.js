// link del codigo en comun.css. Modificaciones hechas por un integrante del grupo

function formToast() {
    // Get the snackbar DIV
    var x = document.getElementById("errorToast");
  
    // Add the "show" class to DIV
    x.className = "show";
  
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 7000);
}