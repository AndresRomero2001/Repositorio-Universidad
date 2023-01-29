<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador"));
    

if(isset($_POST["idCom"]) && isset($_POST["idPlato"]))


    if(Valoracion::borrarValoracion($_POST["idCom"]))
    {
        $url = "verPlato.php?page=carta&idPlato={$_POST["idPlato"]}";
        header('Location: '.$url);
    }
    else{
        echo "<p>ERROR: no se ha podido borrar el comentario</p>";
    }
    
?>