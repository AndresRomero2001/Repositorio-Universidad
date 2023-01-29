<?php
namespace aw\proyecto\clases;
require_once 'includes/config.php';

$tituloPagina = 'Login';

    $contenidoPrincipal = "";
    if(isset( $_SESSION["loged"])) //si ya estaba logeado y se intenta acceder a login, se redirige a index
    {
        header('Location: index.php');
    }
    else{
        $form = new FormularioLogin();
        $contenidoPrincipal .= <<<EOF
        <div class="centeredDiv">
            <h2> Login </h2>
            {$form->gestiona()}
        </div>
        EOF;

       
    }

    include __DIR__.'/includes/plantillas/plantilla.php';
