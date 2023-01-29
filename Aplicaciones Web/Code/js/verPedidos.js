var coll = document.getElementsByClassName("desplegable");
var i;

for (i = 0; i < coll.length; i++) {

    coll[i].addEventListener("click", function() {
    this.classList.toggle("desplegado");
    var pedidosAntiguos = this.nextElementSibling;
    
    if (pedidosAntiguos.style.display === "block") {

        pedidosAntiguos.style.display = "none";
    } else {

        pedidosAntiguos.style.display = "block";
    }
  });
}

var cont = document.getElementsByClassName("desplegablePlatos");
var j;

for (j = 0; j < cont.length; j++) {

    cont[j].addEventListener("click", function() {
    this.classList.toggle("desplegadoPlatos");
    var platos = this.nextElementSibling;
    
    if (platos.style.display === "block") {

        platos.style.display = "none";
    } else {

        platos.style.display = "block";
    }
  });
}

document.querySelectorAll('.botonEstado').forEach(boton => {//aplica listeners a todos los botones de borrar, el cual muestra el modal y le asigna al boton del modal en el valor la id del plato
    boton.addEventListener("click", e => {
        cambiarEstado(e.target.dataset.estidped, e.target.value) //IMPORTANTE (Los data deben ir en minusculas)    
    });
});

function cambiarEstado(idPedido, nuevoEstado)
{
    console.log("cambiado estado del pedido con id "+ idPedido + " a estado " + nuevoEstado);

    let datos = {};
    datos["idPedido"]

    $(document).ready(function(){ //esto no deberia de ejecutarse nunca tan pronto, pero se mete esta comprobacion para asegurar
        $.post("modificarEstadoPedido.php",{ "idPedido": idPedido, "estado": nuevoEstado}, estadoCambiado)
    });
}

function estadoCambiado(data, status)
{
    console.log(data)
    try{ 
    let jsonData = JSON.parse(data);
    console.log(jsonData);
    if(jsonData["isok"])
    {
        let idPedido = jsonData["idPedido"]
        let nuevoEstado = jsonData["estado"]
        console.log("is ok")
        console.log(document.querySelectorAll("button[data-estidped='"+idPedido+"']"));

            document.querySelectorAll("button[data-estidped='"+idPedido+"']").forEach(boton =>{
                if(boton.value == nuevoEstado)
                {
                    boton.classList.add("actual")
                }
                else{
                    boton.classList.remove("actual")
                    boton.classList.add("noActual")
                }  
            })
    }
 }catch{
    console.log("error al procesar")
}     
}