<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Forbiden';
$contenidoPrincipal = "";

$contenidoPrincipal .= <<<EOF
<h2> No tienes permiso para ver esta pagina </h2>
EOF;

include __DIR__.'/includes/plantillas/plantilla.php';