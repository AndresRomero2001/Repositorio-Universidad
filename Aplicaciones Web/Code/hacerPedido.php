<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';

GestionPermisos::validar(array("Administrador", "Usuario"));

$listaCSS["hacerPedido"] = "hacerPedido.css";
$tituloPagina = 'HacerPedido';
$contenidoPrincipal = "";   

$contenidoPrincipal .= <<<EOF
	<div class="cont">
EOF;		

	if ( isset($_SESSION["loged"])){

		$contenidoPrincipal .= <<<EOF
			<div id="divCarta">
		EOF;	
		
		$res = Categoria::listaCategorias();
		foreach ($res as $cat){

			$contenidoPrincipal .= <<<EOF
				<h1 class="mostrarCategoriaPlato">{$cat->getNombre()}</h1>
			EOF;

			$listaPlatos = Plato::listaPlatosCategoria($cat->getId());
			foreach($listaPlatos as $plato){
				
				$contenidoPrincipal .= <<<EOF
					<div class="divPlato">
				EOF; 
				
				$path = "images/carta/";
				if($plato->getFoto() != NULL){
					$path .= $plato->getFoto();
				}
				else{
					$path .= "default.jpg";
				}
				$contenidoPrincipal .= "<img src=$path class=\"mostrarFoto\" alt=\"foto del plato\">";

				$contenidoPrincipal .= <<<EOF
					<h2 class="mostrarNombrePlato">{$plato->getNombre()} - {$plato->getPrecio()} €</h2>
					<p class="mostrarDescripcionPlato">{$plato->getDescripcion()}</p>
					<button type="submit" class="buttonPropio botonPlato" data-precioplato='{$plato->getPrecio()}' data-idplato='{$plato->getId()}' data-nombreplato='{$plato->getNombre()}'>Añadir</button>
					</div> 
				EOF;     
			}
		}

		$contenidoPrincipal .= "</div>";
	}

	$contenidoPrincipal .= <<<EOF
		<div id="divCarrito">
		<h2>Carrito</h2>
		<div id="contendorPlatosCarrito">

		</div>

		<div id="total">
			Total: 0.00€
		</div>

		<button type="submit" class="buttonPropio" id="hacerPedidoButton">Tramitar</button>
		</div>
	EOF;

	$contenidoPrincipal .= <<<EOF
		</div> 
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="js/hacerPedido.js"></script>
	EOF;

include __DIR__.'/includes/plantillas/plantilla.php';
?>