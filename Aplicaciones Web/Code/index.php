<?php
namespace aw\proyecto\clases;
//require_once __DIR__.'/includes/config.php';
require_once 'includes/config.php';
$tituloPagina = 'index';
$listaCSS["carta"] = "index.css";

$contenidoPrincipal = "";

/* $listaCSS = array();
	$listaCSS[] = "comun.css";
	$listaCSS[] = "navbar.css"; */
if(!isset($_SESSION["loged"]))  //vista inicio usuario no registrado
{
   $contenidoPrincipal = <<<EOF
   <div class="verticalSpacerDiv-S"> </div>  
   <div>
      <div class="leftMarginDiv-S"> </div>
      <div class="inlineBlockDiv mediumDiv">
         <h2 class="aclamo">Regístrate para empezar a disfrutar de todos nuestros servicios </h2>
      </div>
      <div class="leftMarginDiv-L"> </div>
      <div class="leftMarginDiv-S"> </div>
   
      <div class="inlineBlockDiv mediumDiv">
         <!--<a href="login.php?page=login" class="specialLink">-->
         <form class="specialForm" action="login.php" method="get">
            <button class="botonInicio" name="page" value="login"> Login </button>
         </form>
         <!--</a>-->
        
         <div class="leftMarginDiv-S"> </div>
         
         <!--<a href="registro.php?page=registro" class="specialLink">-->
         <form class="specialForm" action="registro.php?page=registro" method="get">
            <button class="botonInicio" name="page" value="registro"> Registro </button>
         </form>
         <!--</a>-->
      </div>
   </div>
   
   <div>
      <div class="leftMarginDiv-S"> </div>
         <div class="inlineBlockDiv largeDiv">
         <h2 class="aclamo">O mira nuestros deliciosos platos en la carta</h2>
      </div>
      <div class="leftMarginDiv-L"> </div>
      <div class="leftMarginDiv-S"> </div>
      <div class="inlineBlockDiv">
        <!--  <a href="carta.php?page=carta" class="specialLink"> -->
        <form class="specialForm" action="carta.php" method="get">
            <button class="botonInicioCarta" name="page" value="carta"> Carta </button>
         </form>
        <!--</a>-->
      </div>
   
   </div> 
EOF;
}
else{   //vista inicio usuario registrado
   if($_SESSION["rol"] == "Usuario")
   {
   $contenidoPrincipal = <<<EOF

   <div class="verticalSpacerDiv-S"> </div>
   <div class="centeredDivBig">
      <h2 class="centeredText"> ¿Qué te apetece hacer hoy?</h2>
      <div class="verticalSpacerDiv-S"> </div>
         <div class="divContenedorImgPrin divCenterElements">
         <div class="inlineBlockDiv contenedorImgPrin">
            <!--<span class="contenedorImgPrin"> -->
               <a href="carta.php?page=carta" class="specialLink">
               <!--<form class="specialForm" action="carta.php?page=carta" method="get">-->
                  <img class="imgPrincipal" src="images/cartaImg.jpg" alt="imagen carta">
                  <div class="textOverImage">Ver carta</div>
               <!--</form> -->
               </a>
            
         </div>    
            <!--</span>-->
            <div class="inlineBlockDiv contenedorImgPrin">
            <!--<span class="contenedorImgPrin"> -->
               <a href="hacerReserva.php?page=hacerReserva" class="specialLink">
               <!--<form class="specialForm" action="hacerReserva.php?page=hacerReserva" method="get">-->
                  <img class="imgPrincipal" src="images/reservarImg.jpg" alt="imagen reservar">
                  <div class="textOverImage">Hacer reserva</div>
               <!--</form> -->
               </a>
               
               
            </div>  
               <!--</span>-->
            <div class="inlineBlockDiv contenedorImgPrin">
            <!--<span class="contenedorImgPrin"> -->
               <a href="hacerPedido.php?page=hacerPedido" class="specialLink">
               <!--<form class="specialForm" action="hacerPedido.php?page=hacerPedido" method="get">-->   
                  <img class="imgPrincipal" src="images/pedirImg.jpg" alt="imagen hacer pedido">
                  <div class="textOverImage">Hacer pedido</div>
               <!--</form>-->   
               </a>
               </div>
               <!--</span>-->
         </div>
         <div class="clear"></div>
   </div>
      <div class="verticalSpacerDiv-S"> </div>
      <div class="centeredDivBig divCenterElements">
      <h2 class="centeredText"> Quizás también te interese...</h2>
      <div class="verticalSpacerDiv-S"> </div>
         <!--<a href="verReservas.php?page=verReservas" class="specialLink">-->
         <form class="specialForm" action="verReservas.php" method="get">
            <button class="specialButton" name="page" value="verReservas"> Ver mis reservas </button>
            </form>
         <!--</a>-->
         <!--<a href="verPedidos.php?page=verPedidos" class="specialLink">-->
         <form class="specialForm" action="verPedidos.php" method="get">
            <button class="specialButton" name="page" value="verPedidos"> Ver mis pedidos </button>
         </form>
      <!-- </a>-->
         <!--<a href="perfil.php?page=perfil" class="specialLink">-->
         <form class="specialForm" action="perfil.php" method="get">
            <button class="specialButton" name="page" value="perfil"> Ver Perfil </button>
         </form>
         <!--</a>-->
      </div>
      <div class="verticalSpacerDiv-M"> </div>

EOF; 
   }
   else if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador")
   {
      $contenidoPrincipal = <<<EOF
      <div class="verticalSpacerDiv-S"> </div>
         <div class="centeredDivBig">
         <h2 class="centeredText"> Bienvenido {$_SESSION["nombre"]} </h2>
         <div class="centeredDiv">
         <p>• Utilice la barra superior de navegación para ver las reservas y pedidos del resturante</p>
         <p>• Desde la vista de Carta podrá añadir y modificar platos </p>
         <p>• Desde la vista de Configuración podrá definir los datos del restaurante </p> 
         </div>
      </div>
EOF;
   }
   else if($_SESSION["rol"] == "Empleado")
   {
      $contenidoPrincipal = <<<EOF
      <div class="verticalSpacerDiv-S"> </div>
         <div class="centeredDivBig">
         <h2 class="centeredText"> Bienvenido {$_SESSION["nombre"]} </h2>
         <div class="centeredDiv">
         <p>• Utilice la barra superior de navegación para ver las reservas y pedidos del resturante</p>
         </div>
      </div>
EOF;
   }



}


include __DIR__.'/includes/plantillas/plantilla.php';
