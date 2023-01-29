<?php

//use es\fdi\ucm\aw\Aplicacion;
//namespace es\fdi\ucm\aw;
namespace aw\proyecto\clases;
//require_once __DIR__.'/Aplicacion.php';

/**
 * Configuracion del soporte UTF-8, localizacion (idioma y pais)
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');

date_default_timezone_set('Europe/Madrid');

session_start();

/**
 * Parámetros de conexión a la BD
 */
define('BD_HOST', 'localhost'); //para el contenedor vm07.db.swarm.test
define('BD_NAME', 'letseat');
define('BD_USER', 'root');
define('BD_PASS', ''); //para el contendor cDCHOP07E4smhI8



spl_autoload_register(function ($class) {

/*la variable class sera del estilo es\fdi\ucm\aw\Aplicacion
por tanto si queremos quedarnos con el nombre de la clase (Aplicacion), habra que recortarle es\fdi\ucm\aw\
lo cual sera nuestro prefijo (es decir, nuestro namespace)


La direccion final sera del estilo C:\Universidad 3\AW\Archivos XAMPP\htdocs\paso7\includes\Aplicacion.php
Por tanto al final habra que ejecutar un require de esa direccion del archivo Aplicacion.php
para ello, como lo recortamos anterioremente, conocemos el nombre de la clase (en este ejemplo Aplicacion)
Ahora debemos meterle todo lo anterior, C:\Uni...    ...\includes\ lo cual coincide con la direccion de este archivo,
por tanto podemos usar __DIR__
Por tanto eso sera nuestra direccion base
Concatenamos eso con el nombre de la clase y con .php y ya tenemos la direccion a usar en el requiere

*A tener en cuenta que esta funcion se ejecuta automaticamente al hacer new de alguna clase


*/

    // project-specific namespace prefix
    $prefix = "aw\\proyecto\\clases";

    //echo "</br>$class</br>";

    // base directory for the namespace prefix
    $base_dir =  __DIR__; //dir base para cada clase??


    // does the class use the namespace prefix?
    //comprueba si la clase tiene el prefijo especificado aqui, y sino acaba la funcion
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    //hace un corte al nombre que viene en class y se queda con lo que hay a partir de distancia len
    //es decir, le quita el prefix y se queda con el nombre de la clase
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';


  //  echo "</br>file: ";
   // echo "<div> $file </div>";

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Inicializa la aplicacion
$app = Aplicacion::getInstancia();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS));

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
//register_shutdown_function(array($app, 'shutdown'));