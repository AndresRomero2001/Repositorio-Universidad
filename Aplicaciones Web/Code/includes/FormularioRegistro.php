<?php
namespace aw\proyecto\clases;

//require_once __DIR__.'/Form.php';
//require_once '/paso7/includes/Form.php';
//require_once __DIR__.'/Usuario.php';

class FormularioRegistro extends Form
{
    private $rolAUsar ="Usuario";

    public function __construct($rolAUsar, $pagDestino) {
        $this->rolAUsar = $rolAUsar;
        $opciones['action'] = $pagDestino;
        parent::__construct('formRegistro', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $nombre =$datos['nombre'] ?? '';
        $email =$datos['email'] ?? '';
        $contra =$datos['contra'] ?? '';
        $contra2 =$datos['contra2'] ?? '';
        $dir =$datos['dir'] ?? '';
        $tel =$datos['tel'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorEmailMSG = self::createMensajeError($errores, 'errorEmail', 'span', array('class' => 'errorMSG'));
        $errorTelLetrasMSG = self::createMensajeError($errores, 'errorTelLetras', 'span', array('class' => 'errorMSG'));
        $errorTelNumDigMSG = self::createMensajeError($errores, 'errorTelNumDig', 'span', array('class' => 'errorMSG'));
        $errorContra = self::createMensajeError($errores, 'errorContra', 'span', array('class' => 'errorMSG'));
       

        $msgToolTip ="Introduce numeros, mayusculas, caracteres especiales y al menos 6 letras para mejorar la seguridad de la contraseña";

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
            $htmlErroresGlobales
            <label for="nombreInput">Nombre y apellidos</label>
            <input class="formInput" id="nombreInput" type="text" name="nombre"  placeholder="Nombre y Apellidos" value="$nombre" required>
            <label for="emailInput" id="emailLabel">Email $errorEmailMSG</label>
            <input class="formInput" id="emailInput" type="email" name="email"  placeholder="Email usuario" value="$email" required>
            <label for="contraInput">Contraseña</label>  <div class="inlineBlockDiv tooltip">❔<span class="tooltiptext">$msgToolTip</span></div> <div id="nivelContra" class="inlineBlockDiv"></div><div id="msgNivel" class="inlineBlockDiv"></div> $errorContra
            <input class="formInput" id="contraInput" type="password" name="contra" placeholder="Contraseña" value="$contra" required> <div class="verContra" id="verContra1">👁</div>
            <label for="contraInput2">Repite la contraseña</label>
            <input class="formInput" id="contraInput2" type="password" name="contra2" placeholder="Repite la contraseña" value="$contra2" required> <div class="verContra" id="verContra2">👁</div>
            <label for="dirInput">Dirección</label>
            <input class="formInput" id="dirInput" type="text" name="dir" placeholder="Dirección completa" value="$dir" required>
            <label for="telInput">Teléfono móvil $errorTelLetrasMSG $errorTelNumDigMSG</label>
            <input class="formInput" id="telInput" type="tel" name="tel" placeholder="Número de teléfono" value="$tel" required>
            <button class="formSubmitButton" type="submit"> Enviar </button>

        EOF;
        return $html;
    }
    
    /**
    *
    *result sera la dir de la pagina destino si ha ido todo bien, o sino un array con los mensajes de error a mostrar
    *Los mensajes de error estan organizados de la siguinete manera:
    *Si se meten sin clave (se le asigna valor numerico automaticamente): se mostraran al principio del formulario
    * Para mostrarlos habra que llamar en generarCampos a la funcion generaListaErroresGlobales pasandole la lista de errores
    *Si se meten con clave seran errores de un campo concreto
    * Para mostrarlos habra que llamar en generarCampos a la funcion createMensajeError pasandole la lista de errores y la clave de ese error en esa lista 
    */
    protected function procesaFormulario($datos)
    {
        $result = array();
     
        if(!is_numeric($datos["tel"]))
        {
            $result["errorTelLetras"] = "El telefono debe estar formado solo por numeros"; 
        }
        else{
            $numDigitsTel = (int) log10($datos["tel"]) +1;
            if($numDigitsTel != 9)
            {
                $result["errorTelNumDig"] = "El telefono debe tener 9 numeros";
            }
        }
        
        if($datos['contra'] != $datos['contra2'])
        {
            $result["errorContra"] = "Las contraseñas no coinciden";
        }


        if(Usuario::buscaUsuario($datos["email"]))
        {
            $result["errorEmail"] = "Email ya registrado"; 
        }

        if(count($result) != 0) //ha habido errores en algun campo
        {
            $result[] = "Error en los datos del registro"; //mensaje de error global que se mostrara por encima del formulario
        }
        else{

            if($this->rolAUsar == "Usuario")//registro d eun nuevo usuario
            {
                $u = Usuario::crea($_POST["nombre"], $_POST["email"], $_POST["contra"], $this->rolAUsar, $_POST["dir"], $_POST["tel"]);

                if(!$u)//el acceso a la bd ha ido mal
                {
                    $result[] = "Error al procesar el registro"; //mensaje de error global que se mostrara por encima del formulario
                }
                else{
                    
                    $_SESSION["loged"] = true;
                    $_SESSION["rol"] = $u->getRol();
                    $_SESSION["nombre"] = $u->getNombre();
                    $_SESSION["idUsuario"] = $u->getId();
                    $_SESSION["email"] = $u->getEmail();
                    $result = 'index.php';//pagina a la que se redirige tras el login
                }
            }
            else if($this->rolAUsar == "Empleado")//se registra a un empleado (no se inicia sesion en su perfil)
            {
                $u = Usuario::crea($_POST["nombre"], $_POST["email"], $_POST["contra"], $this->rolAUsar, $_POST["dir"], $_POST["tel"]);

                if(!$u)//el acceso a la bd ha ido mal
                {
                    $result[] = "Error al procesar el registro"; //mensaje de error global que se mostrara por encima del formulario
                }
                else{//empleado registrado sin errores: limpiamos el formulario
                    $_POST['nombre'] = '';
                    $_POST['email'] = '';
                    $_POST['contra'] = '';
                    $_POST['contra2'] = '';
                    $_POST['dir'] = '';
                    $_POST['tel'] = '';
                    $result = 'configuracionRestaurante.php?page=configuracionRestaurante';
                }

                
            }
            else{
                $result[] = "Rol no permitido para registrar";
            }
        }
       
        return $result;
    }
}