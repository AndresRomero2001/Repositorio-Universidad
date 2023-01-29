<?php
namespace aw\proyecto\clases;
use LDAP\Result;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Propietario", "Usuario", "Empleado"));






$tituloPagina = 'Perfil';
$listaCSS["perfil"] = "perfil.css";
$contenidoPrincipal = "";


if(isset($_POST["formModalContras"]))
{
    if(isset($_POST["nuevaContra"]) && isset($_POST["nuevaContra"]))
    {
        if($_POST["nuevaContra"] == $_POST["nuevaContra2"])//en caso de que esta comprobaciones o anteriores no se cumplan, no se generan mensajes
        {                                                 //ya que las comporbaciones se hacen via javascript (los datos aqui no deberian llegar mal)
            $us = Usuario::buscaUsuarioPorId($_SESSION["idUsuario"]);
            $us->cambiaPassword($_POST["nuevaContra"]);
            Usuario::guarda($us);
        }
    }
}


$u = Usuario::buscaUsuario($_SESSION["email"]);
$datosUsuario = array("nombre" => $u->getNombre(),
                "email" => $u->getEmail(),
                "dir" => $u->getDir(),
                "tel" => $u->getTel());

$form = new FormularioPerfil();

$contenidoPrincipal .= <<< EOF
<div class="mediumDiv inlineBlockDiv divFormPerfil">
    <h2> Perfil de {$_SESSION["nombre"]} - {$_SESSION["email"]} </h2>
    <h4> Utilice el siguiente formulario para cambiar los datos de su perfil </h4>
    {$form->gestiona($datosUsuario)}
</div>
EOF;


$msgToolTip ="Introduce números, mayúsculas, caracteres especiales y al menos 6 letras para mejorar la seguridad de la contraseña";

$contenidoPrincipal .= <<<EOF
                        <!-- Trigger/Open The Modal -->
                        <button id="botonModal">Cambiar contraseña</button>

                        <!-- The Modal -->
                        <div id="modalContra" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p>Cambio de contraseña</p>
                            <form id="formModalContras" action="perfil.php?page=perfil" method ="post">
                                <input type="hidden" name="formModalContras" value="">
                                <label for="contraInput">Contraseña</label> <div class="inlineBlockDiv tooltip">❔<span class="tooltiptext">$msgToolTip</span></div> <div id="nivelContra" class="inlineBlockDiv"></div><div id="msgNivel" class="inlineBlockDiv"></div>
                                <input class="formInput" id="contraInput" type="password" name="nuevaContra" placeholder="Nueva contraseña"><div class="verContra" id="verContra1">👁</div>
                                <input class="formInput" id="contraInput2" type="password" name="nuevaContra2" placeholder="Repite la nueva contraseña"><div class="verContra" id="verContra2">👁</div>
                                <button class="formSubmitButton" id="botonSubmit" type="button"> Enviar </button>
                            </form>

                        </div>

                        </div>

                        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                        <script src="js/perfil.js"></script>
EOF;


include __DIR__.'/includes/plantillas/plantilla.php';