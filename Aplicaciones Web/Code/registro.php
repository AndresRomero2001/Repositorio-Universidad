<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Registro';

    $contenidoPrincipal = "";
    $listaCSS["carta"] = "registro.css";

    if(isset( $_SESSION["loged"]))
    {
        header('Location: index.php');
    }
    else{
        $form = new FormularioRegistro("Usuario", "registro.php?page=registro");
        $contenidoPrincipal .= <<<EOF
        <div class="centeredDiv">
        <h2> Registro </h2>
        {$form->gestiona()}
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="js/registro.js"></script>
        EOF;
    }

    include __DIR__.'/includes/plantillas/plantilla.php';