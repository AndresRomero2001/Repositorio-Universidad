<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
GestionPermisos::validar(array("Administrador", "Usuario"));


if(!isset($_POST["platos"]))
{
    echo"mal";
}
else{
    $platos = $_POST["platos"];

    if(count($platos) == 0)
    {
        echo"mal";
    }
    else{
        
        $u = Usuario::buscaUsuarioPorId($_SESSION["idUsuario"]);
        Pedido::nuevoPedido(null, $u->getId(), $u->getDir(), "procesando", $platos);
        echo "ok";
    }

}

/* $dato = "ok";
 foreach($platos as $idPlato => $numPlato){
//-------------ENVIAR DATOS CON FORMATO JSON ---------------
$dato = <<<EOF
{"id":"$idPlato",
"num":"$numPlato"}
EOF;
} 
echo $dato; */  

?>