<?php
namespace aw\proyecto\clases;
//require_once __DIR__.'/Form.php';
//require_once '/paso7/includes/Form.php';
//require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Form
{
    public function __construct() {
        $opciones['action'] = "login.php?page=login";
        parent::__construct('formLogin', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $email =$datos['email'] ?? '';
        $contra =$datos['contra'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    //    $errorNombreUsuario = self::createMensajeError($errores, 'nombreUsuario', 'span', array('class' => 'error'));
    //    $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
            $htmlErroresGlobales
            <label for="emailInput">Email</label>
            <input class="formInput" id="emailInput" type="email" name="email"  placeholder="Email usuario" value="$email" required>
            <label for="contraInput">Contraseña</label>
            <input class="formInput" id="contraInput" type="password" name="contra" placeholder="Contraseña" value="$contra" required>
            <button class="formSubmitButton" type="submit"> Enviar </button>

EOF;
        return $html;
    }
    
    /**
    *
    *result sera la dir de la pagina destino si ha ido todo bien, o sino un array con los mensajes de error a mostrar
    *Los mensajes de error estan organizados de la siguinete manera:
    *si se meten sin clave (se le asigna valor numerico automaticamente): se mostraran al principio del formulario
    * Para mostrarlos habra que llamar en generarCampos a la funcion generaListaErroresGlobales pasandole la lista de errores
    *Si se meten con clave seran errores de un campo concreto
    *Para mostrarlos habra que llamar en generarCampos a la funcion createMensajeError pasandole la lista de errores y la clave de ese error en esa lista 
    */
    protected function procesaFormulario($datos)
    {
        $result = array();

            $u = Usuario::login($_POST["email"], $_POST["contra"]);


            if(!$u)
            {
                $result[] = "Usuario o contraseña incorrectos"; //mensaje de error global que se mostrara por encima del formulario
            }
            else{
                $_SESSION["loged"] = true;
                $_SESSION["rol"] = $u->getRol();
                $_SESSION["nombre"] = $u->getNombre();
                $_SESSION["email"] = $u->getEmail();
                $_SESSION["idUsuario"] = $u->getId();
                $result = 'index.php';
            }
        return $result;
    }
}