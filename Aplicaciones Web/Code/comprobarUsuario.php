<?php
namespace aw\proyecto\clases;
require_once __DIR__.'/includes/config.php';
//GestionPermisos::validar(array("Administrador", "Usuario"));

if(!isset($_GET["user"]))
{
    echo"mal";
}
else{
    $email = $_GET["user"];
    if(Usuario::buscaUsuario($email))//existe
    {
        echo "existe";
    }
    else{
        echo "noExiste";
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