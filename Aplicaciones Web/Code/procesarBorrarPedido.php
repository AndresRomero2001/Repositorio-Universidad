<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario", "Propietario", "Empleado"));
    

    $pd=Pedido::borrarPedido( $_POST["idPedido"]);
    
    if($pd) {
        header('Location: verPedidos.php');
    } else {
        echo "<p>ERROR: no se ha podido borrar el pedido</p>";
    }
?>