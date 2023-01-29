<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario", "Propietario", "Empleado"));
    

    $rs=Reserva::borrarReserva( $_POST["idReserva"]);
    
    if($rs) {
        header('Location: verReservas.php');
    } else {
        echo "<p>ERROR: no se ha podido borrar la reserva</p>";
    }
?>