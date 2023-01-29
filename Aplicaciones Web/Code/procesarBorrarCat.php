<?php
    namespace aw\proyecto\clases;
    require_once __DIR__.'/includes/config.php';

    //$cat = $_GET['nombrePlato'];
    //echo var_dump($_POST);

    echo "hola";

    if(Categoria::borrarCategoria($_POST["idCat"])) header('Location: carta.php');
    else echo "<p>ERROR: no se ha podido borrar el plato</p>";
?>