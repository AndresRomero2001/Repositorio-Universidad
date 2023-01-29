<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario", "Propietario", "Empleado"));

        $contenidoPrincipal= "<div id=\"divReserva\">";
        if($_SESSION["rol"] == "Usuario")
        {
          $contenidoPrincipal.= "<h1>Vista con las reservas del usuario {$_SESSION['nombre']}</h1>";
        }
        else if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador" || $_SESSION["rol"] == "Empleado"){
          $contenidoPrincipal.= '<h1> Vista con todas las reservas del restaurante</h1> ';
        }
        $contenidoPrincipal.= "<hr class='separacion'>"; 
        $listaReservas = Reserva::listaReservas($_SESSION['idUsuario']);
           
        foreach($listaReservas as $reserva){
          
          $usuario = Usuario::buscaUsuarioPorId($reserva->getIdUsusario());
          $nombre=$usuario->getNombre();
          $d=date('G:i, d/m/y', strtotime($reserva->getFecha()));

          
          
          
          $contenidoPrincipal.= <<<EOF
            
            <h2 class="usuarioReserva">Reserva a nombre de {$nombre}:</h2>
            <form action='procesarBorrarReserva.php' method="POST">
            <input type="hidden" name="idReserva" value="{$reserva->getId()}">
            <button type="submit" class="borradoReserva">x</button>
            </form> 
           
            <button class="modReserva" data-id='{$reserva->getId()}'>Modificar</button>
            
            <h2 class="mostrarnPersonas">Mesa para x{$reserva->getNPersonas()}</h2>  
            
            <p class="mostrarFecha">{$d}</p> 
            <hr class='separacion'>
            
EOF;
            
           
        }
        
        $contenidoPrincipal .= <<<EOF
        <div id="modificarReservaModal" class="modal">
            <div class="modal-content">
                <span class="close" data-dismiss="modal">&times;</span>
                
            </div>
        </div>
EOF;
        
        
        $contenidoPrincipal.= "</div>";
 

      $contenidoPrincipal .= '<script src="js/verReservas.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>';
      $tituloPagina = "ver Reservas";
      $listaCSS["verReservas"] = "verReservas.css";
      if(isset($_GET['fail'])){
        $saca="'".$_GET['fail']."'";
        echo "<script type='text/javascript'>alert($saca);</script>";
    
    }
      
      include __DIR__.'/includes/plantillas/plantilla.php';
    ?>