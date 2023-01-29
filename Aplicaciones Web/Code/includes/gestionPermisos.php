<?php

namespace aw\proyecto\clases;



class GestionPermisos{



    /**
     * 
     * 
     * Funcion para validar los permisos de acceso desde la pagina que se la llama
     * Si el rol actual del usuario es alguno de los permitidos cargara el contenido de la pagina
     * correctamente. Sino, redirige a una pagina de error sin realizar mas operaciones.
     * @param array $rolesPermitidos Lista con los roles permitidos para dicha pagina en formato array sin claves, solo valores.
     *      */    
    static public function validar($rolesPermitidos = array())// parametro: lista de roles en un array sin claves  (usa indices normales)
    {
        /* foreach($rolesPermitidos as $clave => $valor)
        {
            echo"<p> $clave $valor <p>";
        }   */
        
        
        if(!isset($_SESSION["rol"]))
        {
            //echo "no perm: {$_SESSION["rol"]} ";
            header('Location: noPerm.php');
            exit();

            
        }
        else if(!in_array($_SESSION["rol"], $rolesPermitidos)){//si el rol actual no esta entre los permitidos
            header('Location: noPerm.php');
            exit();
        }


    }

}

