//Variables globales: Necesarias ya que gestionan el carrito y deben poder ser accedidas en multiples lugares
//en cualquier momento
var arrayCarrito = {};//array clave valor. Clave: idPlato Valor: numero de platos que se piden de dicho plato
let total = 0.0;
var arrayPrecios = {};//array clave valor. Clave idPlato Valor: precio de ese plato
//IMPORTANTE: Recalcar que los precios aqui usados son solo con fines de estetica, para mostrarlos en el carrito
//El precio total a pagar se calcula en el servidor usando los ids de los platos, para evitar posibles
//ataques que mandaran al servidor precios incorrectos de los platos



/*Referencia codigo scroll carrito: https://stackoverflow.com/questions/1638895/how-do-i-make-a-div-move-up-and-down-when-im-scrolling-the-page
*/
$(document).ready(function(){

var fixmeTop = $('#divCarrito').offset().top;       

    $(window).scroll(function() {                  

        var activeScrl = $(window).scrollTop();

        if (activeScrl >= fixmeTop) {    
            $("#divCarrito").css("position","fixed");
            $("#divCarrito").css("top",0);
            $("#divCarrito").css("right",0);
            
            /* $('#divCarrito').css({                      
                position: 'fixed',
                top: '0',
                left: '0'
            }); */
        } else { 
            $("#divCarrito").css("position","static");                                  
            /* $('#divCarrito').css({                     
                position: 'static'
            }); */
        }
    });


    $("#hacerPedidoButton").click(hacerPedido);


});
//fin del codigo del scroll del carrito




document.querySelectorAll('.botonPlato').forEach(boton => {//aplica listeners a todos los botones de meter plato en el carrito
    arrayCarrito[boton.dataset.idplato] = 0;//inicializa todos los platos a 0 elementos seleccionados
    arrayPrecios[boton.dataset.idplato] = parseFloat(boton.dataset.precioplato)
    boton.addEventListener("click", e => {//funcion a ejecutar cuando se seleccione 
        console.log(e.target.dataset.idplato);
        console.log(e.target.dataset.nombreplato);
        console.log(e.target.dataset.precioplato);
        let carrito =document.querySelector('#contendorPlatosCarrito');//div que los platos del carrito (boton de tramitar fuera para no afectar a sus listener)
        console.log(carrito);
        console.log("num de ese plato= " + arrayCarrito[e.target.dataset.idplato]);
        
       
        total = (Number(total) +  parseFloat(e.target.dataset.precioplato)).toFixed(2);
        //total = parseFloat(total).toFixed(2); //dos decimales
        //si el plato no se habia elegido antes metemos una linea con sus datos
        if(arrayCarrito[e.target.dataset.idplato] == 0)
        {
            arrayCarrito[e.target.dataset.idplato] += 1;
            
            console.log("no habia");
            //contenido de la nueva linea del carrito
            let contenido = "<div class='clear lineaPlatocarrito' data-idplatocarrito=\"" + e.target.dataset.idplato + "\">";
            contenido+= e.target.dataset.nombreplato;
            contenido += " <ins data-idnumplato=\"" + e.target.dataset.idplato + "\"> x"+arrayCarrito[e.target.dataset.idplato] + "</ins>";
            
            contenido+= "<button class='botonesPlatoCarrito' data-idbotonborrar=\"" + e.target.dataset.idplato+"\"> ❌</button>";//boton de borrar con su identificador propio
            contenido+= "<button class='botonesPlatoCarrito' data-idbotonrestar=\"" + e.target.dataset.idplato+"\"> ➖</button>";//boton de restar con su identificador propio
            contenido+="<div data-idplatopreCarr=\"" + e.target.dataset.idplato+"\"class='inlineBlockDiv precioPlatoCarr'> </div>";
            contenido+= "</div>";
           
            carrito.insertAdjacentHTML("beforeend", contenido);
            actualizarPrecioPlato(e.target.dataset.idplato);

        //ponemos listeners a los botones de borrar y restar de ese plato
        let botonBorrar = document.querySelector("button[data-idbotonborrar='"+e.target.dataset.idplato+"']");
            botonBorrar.addEventListener("click", e => {
                borrarLinea(e.target.dataset.idbotonborrar);
            console.log("intentando borrar linea " + e.target.dataset.idbotonborrar);
        });

        let botonRestar = document.querySelector("button[data-idbotonrestar='"+e.target.dataset.idplato+"']");
            botonRestar.addEventListener("click", e => {
                restarCantidad(e.target.dataset.idbotonrestar);
        });

        }
        else//si el plato ya estaba solo actualizamos el numero de elementos de ese plato y los precios
        {
            console.log("si habia");
            arrayCarrito[e.target.dataset.idplato] += 1;
            actualizarNumero(e.target.dataset.idplato);
            actualizarPrecioPlato(e.target.dataset.idplato);
        }

        //finalmente actualizamos el total del carrito
        actualizarTotal();


    });
});

function actualizarTotal()
{
    console.log("total: "+total);

    document.querySelector('#total').innerHTML = "";

    document.querySelector('#total').innerHTML = "Total: " + total + "€";
}

//dado un id de plato, borra la linea asociada a el
function borrarLinea(idPlato)
{
    let divLinea = document.querySelector("div[data-idplatocarrito='"+idPlato+"']")
    divLinea.parentNode.removeChild(divLinea);
    
    if(arrayCarrito[idPlato] > 0)//solo restamos las cantidades de ese plato si habia alguna
    {
        total = (Number(total) -  (parseFloat(arrayPrecios[idPlato]) * arrayCarrito[idPlato])).toFixed(2);
    }

    arrayCarrito[idPlato] = 0;

    actualizarTotal();
}

//dado un id de un plato, quita una cantidad del plato asociada a el
function restarCantidad(idPlato)
{
    arrayCarrito[idPlato] -= 1;
    total = (Number(total) -  parseFloat(arrayPrecios[idPlato])).toFixed(2);

    if(arrayCarrito[idPlato] == 0)
    {
        borrarLinea(idPlato);
    }
    else
    {
        actualizarNumero(idPlato);
        actualizarPrecioPlato(idPlato);
        actualizarTotal();
    }
    
   // console.log("intentando restar linea " + idPlato);
}

//dado el id de un plato, selecciona en el html el codigo que muestra el numero de elementos de ese plato
//y reescribe el numero con su valor actualizado
function actualizarNumero(idPlato)
{
    let num = document.querySelector("ins[data-idnumplato='"+idPlato+"']"); //¡Cuidado: el valor (en este caso idPlato) debe ir entre ''
    console.log(num);
    num.innerHTML = "<ins data-idnumplato=\"" +idPlato + "\"> x"+arrayCarrito[idPlato] + "</ins>";
}

//dado el id de un palto, actualiza el precio acuulado de ese plato en base a su cantidad
function actualizarPrecioPlato(idPlato)
{
    let divPrecio = document.querySelector("div[data-idPlatoPreCarr='"+idPlato+"']"); //¡Cuidado: el valor (en este caso idPlato) debe ir entre ''
    console.log("divPrecio" + divPrecio);
    let precio = (arrayPrecios[idPlato] * arrayCarrito[idPlato]).toFixed(2);
    /* divPrecio.innerHTML = "<ins data-idnumplato=\"" +idPlato + "\"> x"+arrayCarrito[idPlato] + "</ins>"; */
    divPrecio.innerHTML = " "+precio + "€";
}




function hacerPedido()
{
    console.log("haciendo pedido");
    var platosPedidos = {};
    var count = 0;
    
    for (var key in arrayCarrito) {
        if(arrayCarrito[key] > 0)
        {
            platosPedidos[key] = arrayCarrito[key];
            count++;
           // console.log("plato " + key + " unidades " + arrayCarrito[key]);
        }
    }
    console.log("platos a pedir");
    for (var key in platosPedidos) {
            console.log("plato " + key + " unidades " + platosPedidos[key]);
    }

    if(count == 0)
    {
        alert("Para hacer un pedido debes elegir al menos un plato.");
    }
    else{
        $(document).ready(function(){ //esto no deberia de ejecutarse nunca tan pronto, pero se mete esta comprobacion para asegurar
            $.post("procesarHacerPedido.php",{ platos: platosPedidos}, pedidoHecho)
        });
    }

}

function pedidoHecho(data, status)
{
    
    if(data == "ok")
    {
        console.log("pedido ok");
        //window.location.replace("/verPedidos.php");
        document.location.href = './verPedidos.php?page=verPedidos';
    }
    else{
        alert("Error al procesar el pedido");
    }
// --RECIBIR STRINGS CON FORMATO JSON Y PARSEARLO A OBJETO JSON
 ////jsonData = JSON.parse(data);
//console.log(jsonData); 

console.log(data);
}

