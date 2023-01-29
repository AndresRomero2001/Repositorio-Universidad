<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Propietario", "Empleado"));


if(!isset($_POST["idPedido"]))
{
    echo"mal";
}
else{
    if(!isset($_POST["estado"]))
    {
    echo"mal";
    }
    else{

        Pedido::modificarEstado($_POST["idPedido"], $_POST["estado"]);

        $a_devolver = <<< EOF
        {"idPedido":"{$_POST["idPedido"]}",
            "estado":"{$_POST["estado"]}",
            "isok":"ok"}
        EOF;
        echo $a_devolver;
    }
}
?>