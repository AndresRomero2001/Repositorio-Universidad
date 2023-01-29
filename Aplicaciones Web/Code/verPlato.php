<?php
    namespace aw\proyecto\clases;
    require_once __DIR__.'/includes/config.php';

    $plato = Plato::buscarPlato($_GET['idPlato']);

    $tituloPagina = $plato->getNombre();
    $listaCSS["verPlato"] = "verPlato.css";
    $contenido = "";
    
    $path = "images/carta/";
    if($plato->getFoto() != NULL){
        $path .= $plato->getFoto();
    }
    else{
        $path .= "default.jpg";
    }

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
            $contenido .= <<<EOF
            <div id="cabeceraModPlato">
            <button id="modificarPlatoButton" class="modalButton">Modificar plato</button>
            </div>
EOF;
        }
    }

    $contenido .= <<<EOF
    <div class="cuerpoPagina">
    <div class="cuerpoVerPlato">
    <div class="mostrarFoto">
    <img src=$path class="mostrarFoto" alt="foto del plato">
    </div>
    <div class="mostrarInfoPlato">
    <h1 class="mostrarNombre">{$plato->getNombre()}</h1>
    <p class="mostrarDescripcion">{$plato->getDescripcion()}</p>
    <p class="mostrarPrecio">{$plato->getPrecio()} €</p>
    </div>
    </div>
EOF;


            
    $contenido .= <<<EOF
    <div class="cabecera">
    <div class="tituValora">
    <h1>Valoraciones</h1>   
EOF;

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Usuario" || $_SESSION["rol"] == "Administrador"){

            $contenido .= <<<EOF
            <button id="anadirValoracionButton" class="modalButton">Añadir valoración</button>
EOF;
        }
    }

    $contenido .= <<<EOF
    </div>
    </div>
EOF;


    $listaValoraciones = Valoracion::listaValoracionesPlato($plato->getId());
    foreach($listaValoraciones as $valoracion) {

        $id_user = $valoracion->getId_usuario();
        $user = Usuario::buscaUsuarioPorId($id_user);
        $nombreUser = $user->getNombre();
        $descripcion = $valoracion->getDescripcion();
        $num_estrellas = $valoracion->getValoracion();
        $estrellas = "";
        for ($i = 0; $i < $num_estrellas; $i++) {
            $estrellas .= "⭐";
        }

        $contenido .= <<<EOF
        <div class="comentario">
        <div class="tituComen">
            <h3 class="nombreUser">👤 $nombreUser</h3>
EOF;
        if(isset( $_SESSION["loged"]) && $_SESSION["rol"] == "Administrador")
        {
            $contenido .= <<<EOF
            <form action="borrarComentario.php" method="post">
            <button type="submit" name="idCom" value="{$valoracion->getId()}">❌</button>
            <input type="hidden" name="idPlato" value="{$_GET['idPlato']}"> 
            </form>
EOF;
        }

        $contenido .=<<<EOF
        </div>
            <div class="contenedorEstrellas">
            <p class="star">$estrellas</p>
            </div>
            <p>$descripcion</p>
        </div>
EOF;
    }

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
            $contenidoModal = modificarPlatoForm();

            $contenido .= <<<EOF
            <div id="modificarPlatoModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    $contenidoModal
                </div>
            </div>
EOF;
        }
    }

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Usuario" || $_SESSION["rol"] == "Administrador"){

            $contenidoModal = anadirValoracionForm();
            
            $contenido .= <<<EOF
            <div id="anadirValoracionModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    $contenidoModal
                </div>
            </div>
EOF;
        }
    }

    $contenido .=<<<EOF
    </div>
EOF;    

    function modificarPlatoForm() {
        global $plato;
        $datosIniciales = array();
        $datosIniciales["nombre"] = $plato->getNombre();
        $datosIniciales["precio"] = $plato->getPrecio();
        $datosIniciales["categoriaElegida"] = $plato->getIdCategoria();
        $datosIniciales["descripcion"] = $plato->getDescripcion();
        $datosIniciales["idPlato"] = $plato->getId();

        $contenidoModal = "";
        $contenidoModal .= '<p class="formTitle">Modificar plato</p>';

        $form = new FormularioModificarPlato($plato->getId());
        $contenidoModal .= <<<EOF
        {$form->gestiona($datosIniciales)}
EOF;

        return $contenidoModal;
    }

    function anadirValoracionForm() {
        global $plato;
        $datosIniciales = array();
        $datosIniciales["idPlato"] = $plato->getId();
        $contenidoModal = "";
        $contenidoModal .= '<p class="formTitle">Añadir valoración</p>';

        $form = new FormularioAnadirComentario($plato->getId());
        $contenidoModal .= <<<EOF
        {$form->gestiona($datosIniciales)}
EOF;

        return $contenidoModal;
    }
    
    $contenido .= '<script src="js/verPlato.js"></script>';

    $contenidoPrincipal = $contenido;

    include __DIR__.'/includes/plantillas/plantilla.php';