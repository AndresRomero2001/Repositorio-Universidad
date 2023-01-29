<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario", "Propietario", "Empleado"));

  $contenidoPrincipal= "<div id=\"divPedido\">";

  if($_SESSION["rol"] == "Usuario")
  {
    $contenidoPrincipal.= "<h1 class=\"titulo\">Pedidos del usuario: {$_SESSION['nombre']}</h1>";    
  }
  else if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador" || $_SESSION["rol"] == "Empleado"){
    $contenidoPrincipal .= "<h1 class=\"titulo\"> Lista completa de pedidos realizados en el restaurante</h1>";
  }

  $contenidoPrincipal.= "<hr class='sep'>"; 
  $listaPedidosActivos = Pedido::listaPedidosActivos($_SESSION['idUsuario']);
  $listaPedidosAntiguos = Pedido::listaPedidosAntiguos($_SESSION['idUsuario']);

  foreach($listaPedidosActivos as $pedido){
    
    $listaPlatos = Plato::listaPlatos($pedido->getId());

    $usuario = Usuario::buscaUsuarioPorId($pedido->getIdUsusario());
    $nombre=$usuario->getNombre();
    $d=date('G:i, y/m/d', strtotime($pedido->getFecha()));
    
    $contenidoPrincipal.= <<<EOF
    
      <h2 class="usuarioPedido">Pedido a nombre de {$nombre}:</h2>

      <form action='procesarBorrarPedido.php' method="POST">
      <input type="hidden" name="idPedido" value="{$pedido->getId()}">
      <button type="submit" class="borradoPedido">x</button>
      </form> 

      EOF;

      if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador" || $_SESSION["rol"] == "Empleado"){
        
        //recorremos la lista de posibles estados (de forma inversa, para colocarlso en orden al usar float right)
        foreach(Pedido::getListaEstadosInvertida() as $estado)
        {
          //si el estado por el que vamos es el actual tendra la clase de css actual y sino tendra noActual
          if($estado == $pedido->getEstado())
          {
            //Se mete un boton con un dataset para poder seleccionarlo desde javascript
            //El value del boton sera el estado pulsado, de manera que se podra desde javascript hacer facilmente la peticion usando dicho valor
            $contenidoPrincipal.= <<<EOF
            <button  data-estidped="{$pedido->getId()}" class="botonEstado actual" value="{$estado}">{$estado}</button>
          EOF;
          }
          else{
            $contenidoPrincipal.= <<<EOF
            <button  data-estidped="{$pedido->getId()}" class="botonEstado noActual" value="{$estado}">{$estado}</button>
          EOF;
          }
          
        }
       /*  $contenidoPrincipal.= <<<EOF
        <button class="modEstado" data-id='{$pedido->getId()}'">Modificar estado</button>
        EOF; */
      }

      $contenidoPrincipal.= <<<EOF

      <h2 class="mostrarEstado">Estado del pedido: {$pedido->getEstado()}</h2>  

      <p class="mostrarFecha">{$d}</p> 

      <button type="button" class="desplegablePlatos">- Platos del pedido: </button>

      <div class="platos">

      EOF;
      $t=0;
      foreach($listaPlatos as $platos){

        $plato=$platos[0];
        $numero=$platos[1];
        $total=$plato->getPrecio()*$numero;
        $contenidoPrincipal.= <<<EOF

        <p>{$numero} x {$plato->getNombre()}  {$plato->getPrecio()}€   =>   {$total}€</p>
      
        EOF;
        $t=$t+$total;
      }

      $contenidoPrincipal.= <<<EOF
      <h3>TOTAL={$t}€</h3>
      </div>

      <hr class='sep'>
    EOF;
  }

  $contenidoPrincipal.= <<<EOF

    <button type="button" class="desplegable">- Pedidos antiguos: </button>

    <div class="pedidosAntiguos">

    <hr class='sep'>

  EOF;

  foreach($listaPedidosAntiguos as $pedido){
    
    $listaPlatos = Plato  ::listaPlatos($pedido->getId());

    $usuario = Usuario::buscaUsuarioPorId($pedido->getIdUsusario());
    $nombre=$usuario->getNombre();
    $d=date('G:i, y/m/d', strtotime($pedido->getFecha()));
    
    $contenidoPrincipal.= <<<EOF
    
      <h2 class="usuarioPedido">Pedido a nombre de {$nombre}:</h2>

      <form action='procesarBorrarPedido.php' method="POST">
      <input type="hidden" name="idPedido" value="{$pedido->getId()}">
      <button type="submit" class="borradoPedido">x</button>
      </form> 

      EOF;

      if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador" || $_SESSION["rol"] == "Empleado"){

        foreach(Pedido::getListaEstadosInvertida() as $estado)
        {
          if($estado == $pedido->getEstado())
          {
            $contenidoPrincipal.= <<<EOF
            <button  data-estidped="{$pedido->getId()}" class="botonEstado actual" value="{$estado}">{$estado}</button>
          EOF;
          }
          else{
            $contenidoPrincipal.= <<<EOF
            <button  data-estidped="{$pedido->getId()}" class="botonEstado noActual" value="{$estado}">{$estado}</button>
          EOF;
          }
        }
      }

      $contenidoPrincipal.= <<<EOF

      <h2 class="mostrarEstado">Estado del pedido: {$pedido->getEstado()}</h2>  

      <p class="mostrarFecha">{$d}</p> 

      <button type="button" class="desplegablePlatos">- Platos del pedido: </button>

      <div class="platos">

      EOF;
      $t=0;
      foreach($listaPlatos as $platos){

        $plato=$platos[0];
        $numero=$platos[1];
        $total=$plato->getPrecio()*$numero;
        $contenidoPrincipal.= <<<EOF

        <p>{$numero} x {$plato->getNombre()}  {$plato->getPrecio()}€   =>   {$total}€</p>
      
        EOF;
        $t=$t+$total;
      }

      $contenidoPrincipal.= <<<EOF
      <h3>TOTAL={$t}€</h3>
      </div>

      <hr class='sep'>
    EOF;
  }

  $contenidoPrincipal.= <<<EOF

    </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/verPedidos.js"></script>

  EOF;

$listaCSS["verPedidos"] = "verPedidos.css"; 
$tituloPagina = "Ver pedidos";
include __DIR__.'/includes/plantillas/plantilla.php';