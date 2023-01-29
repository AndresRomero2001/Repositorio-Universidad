<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario"));

$tituloPagina = 'Hacer Reserva';

$contenidoPrincipal = "";
$form = new FormularioReserva();
$contenidoPrincipal .= <<<EOF
<div class="centeredDiv">
<h2> Datos de la reserva </h2>
{$form->gestiona()}
</div>
EOF;


include __DIR__.'/includes/plantillas/plantilla.php';