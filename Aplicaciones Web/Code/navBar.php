<?php
//el session start ya se hace en las paginas principales, no repetirlo aqui en este fragmento

$activeItems = array("inicio" => "", "carta" => "", "hacerPedido" => "", "hacerReserva" => "", "verPedidos" => "",
                     "verReservas" => "", "configuracionRestaurante" => "", "login" => "", "registro" => "", "perfil" => "");

function generarItemsNavbar()
{
  $navbarItems = "";

  //las dir son relativas comenzando en /   (la raiz)



  global $activeItems;
  if(!isset($_GET["page"]))
  {
    $activeItems["inicio"] = "active";
  }
  else{
    $activeItems[$_GET["page"]] = "active";
  }

  $navbarItems .= <<<EOF
  <li class="my-nav-li {$activeItems["inicio"]}">
    <a class="my-nav-item" href="index.php?page=inicio">Inicio</a>
  </li>
  <li class="my-nav-li {$activeItems["carta"]}">
    <a class="my-nav-item" href="carta.php?page=carta">Carta</a>
  </li>
EOF;

  if(isset( $_SESSION["rol"]))
  {

    //items que solo ve un user o un admin
    if($_SESSION["rol"] == "Usuario" || $_SESSION["rol"] == "Administrador")
    {
      $navbarItems .= <<<EOF
      <li class="my-nav-li {$activeItems["hacerPedido"]}">
      <a class="my-nav-item" href="hacerPedido.php?page=hacerPedido">Hacer pedido</a>
    </li>
    <li class="my-nav-li {$activeItems["hacerReserva"]}">
      <a class="my-nav-item" href="hacerReserva.php?page=hacerReserva">Hacer reserva</a>
    </li>
    EOF;
    }

    //items que ven todos los usuarios registrados
      $navbarItems .= <<<EOF
      <li class="my-nav-li {$activeItems["verPedidos"]}">
      <a class="my-nav-item" href="verPedidos.php?page=verPedidos">Ver pedidos</a>
    </li>
    <li class="my-nav-li {$activeItems["verReservas"]}">
      <a class="my-nav-item" href="verReservas.php?page=verReservas">Ver reservas</a>
    </li>
    EOF;

    //items que ven solo los propietarios o un admin
    if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador")
    {
      $navbarItems .= <<<EOF
      <li class="my-nav-li {$activeItems["configuracionRestaurante"]}">
      <a class="my-nav-item" href="configuracionRestaurante.php?page=configuracionRestaurante">Configuracion</a>
    </li>
    EOF;
    }

    
  }
  if(!isset($_SESSION["rol"]))
  {
    $navbarItems .= <<<EOF
    <li style="float:right" class="my-nav-li {$activeItems["registro"]}">
      <a class="my-nav-item" href="registro.php?page=registro">Registro</a>
    </li>
    EOF;
    $navbarItems .= <<<EOF
    <li style="float:right" class="my-nav-li {$activeItems["login"]}">
      <a class="my-nav-item" href="login.php?page=login">Login</a>
    </li>
    EOF;
    
  }

  if(isset( $_SESSION["rol"]))
  {
    //el orden es al reves del que saldran porque se van apilando a la derecha
    $navbarItems .= <<<EOF
    <li style="float:right" class="my-nav-li">
      <a class="my-nav-item" href="salir.php">Salir</a>
    </li>
    EOF;
    $navbarItems .= <<<EOF
    <li style="float:right" class="my-nav-li {$activeItems["perfil"]}">
      <a class="my-nav-item" href="perfil.php?page=perfil">Perfil</a>
    </li>
    EOF;
  }
  

  return $navbarItems;

}

?>
<div>
<div class="aux">
    <image class="headerImage"  src="images/bannerLetraGrande.jpg" alt="imagen cabecera">
</div>
<div>
<!-- ms-auto sirve para alinear a la derecha -->
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid"> -->
   <!--  <a class="navbar-brand" href="index.php">Inicio</a> -->
 <!--    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->
    <!-- <div class="collapse navbar-collapse" id="navbarNav"> -->
      <ul class="my-nav-ul">
        
        <?php echo generarItemsNavbar() ?>
        
       
      </ul>
    <!-- </div> -->
  </div>
</div>
<!-- </nav> -->
                
                    <!-- <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="uno" type="button" role="tab" aria-controls="nav-home" aria-selected="true">uno</button>
                    <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="dos" type="button" role="tab" aria-controls="nav-home" aria-selected="false">dos</button> -->
            
   