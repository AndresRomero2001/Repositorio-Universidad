<?php
    namespace aw\proyecto\clases;
    require_once __DIR__.'/includes/config.php';

    $contenido = "";

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
            $contenido .= <<<EOF
            <button id="abrirModalButton" class="modalButton">Añadir plato</button> 
            EOF; 
        }
    }

    $contenido .= <<<EOF
    <div class="cuerpoCarta">
EOF;    

    $res = Categoria::listaCategorias();
    foreach ($res as $cat){
        $listaPlatos = Plato::listaPlatosCategoria($cat->getId());

        $contenidoBorrarCat = "";
        if(isset( $_SESSION["loged"])){
            if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
                if(!$listaPlatos) {
                    $contenidoBorrarCat .= <<<EOF
                    <form class="formBorrarCat" action="procesarBorrarCat.php" method="POST">
                    <button type="submit" class="borrarCatButton" name="idCat" value={$cat->getId()}>❌</button>
                    </form>
EOF;
                }
            }
        }

        $contenido .= <<<EOF
        <h1 class="mostrarCategoria">{$cat->getNombre()}</h1>
        $contenidoBorrarCat
        <div class="filaCategoria">
EOF;
        
        foreach($listaPlatos as $plato){
            $path = "images/carta/";
            if($plato->getFoto() != NULL){
                $path .= $plato->getFoto();
            }
            else{
                $path .= "default.jpg";
            }

            $contenido .= <<<EOF
            <div class="imagenButton">
            
            <form action="verPlato.php">
            <input type="hidden" name="page" value="carta">
            <input type="image"  class="mostrarFoto" src="$path" alt="foto del plato">
            <input type="hidden" name="idPlato" value="{$plato->getId()}">
            </form> 

            <p class="mostrarNombre">{$plato->getNombre()}</p>
            <div class="botones">
            
            <form action="verPlato.php" class="verPlatoForm">
            <input type="hidden" name="page" value="carta">
            <input type="hidden" name="idPlato" value="{$plato->getId()}">
            <button class="submit verPlato">Ver plato</button>
            </form>
            EOF;

            if(isset( $_SESSION["loged"])){
                if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
                    $contenido .= <<<EOF
                    <form action="procesarBorrarPlato.php" class="borrarPlatoForm" method="POST">
                    <input type="hidden" name="idPlato" value="{$plato->getId()}">
                    <button class="borrarPlato">❌</button>
                    </form>
                    EOF;
                }
            }

            $contenido .= <<<EOF
            </div>
            </div>
            EOF;
        }

        $contenido .= <<<EOF
        </div>
        EOF;
    }

    if(isset( $_SESSION["loged"])){
        if($_SESSION["rol"] == "Propietario" || $_SESSION["rol"] == "Administrador"){
            $contenidoModal = anadirPlatoForm();

            $contenido .= <<<EOF
            <div id="anadirPlatoModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    $contenidoModal
                </div>
            </div>
            EOF;
        }
    } 

    $contenido .= <<<EOF
    </div>
    EOF;

    function anadirPlatoForm(){
        $contenidoModal = "";
        $contenidoModal .= '<p class="formTitle">Añadir plato</p>';

        $form = new FormularioAnadirPlato();
        $contenidoModal .= <<<EOF
        {$form->gestiona()}
        EOF;

        return $contenidoModal;
    }

    $contenido .= '<script src="js/carta.js"></script>';
    $contenidoPrincipal = $contenido;
    $tituloPagina = "Carta";
    $listaCSS["carta"] = "carta.css";

    include __DIR__.'/includes/plantillas/plantilla.php';