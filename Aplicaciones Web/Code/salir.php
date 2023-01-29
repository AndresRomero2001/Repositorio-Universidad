<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';

if(isset( $_SESSION["loged"]))
{

unset($_SESSION["loged"]);
unset($_SESSION["rol"]);
unset($_SESSION["nombre"]);
unset($_SESSION["idUsuario"]);
session_destroy();
header('Location: index.php');

}

