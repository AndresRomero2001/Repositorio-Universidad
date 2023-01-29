<?php
namespace aw\proyecto\clases;
//require_once __DIR__.'/Form.php';
//require_once '/paso7/includes/Form.php';
//require_once __DIR__.'/Usuario.php';

class FormularioPerfil extends Form
{
    public function __construct() {
        $opciones['action'] = "perfil.php?page=perfil";
        parent::__construct('formPerfil', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $nombre =$datos['nombre'] ?? '';
        $dir =$datos['dir'] ?? '';
        $tel =$datos['tel'] ?? '';

        

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTelLetrasMSG = self::createMensajeError($errores, 'errorTelLetras', 'span', array('class' => 'errorMSG'));
        $errorTelNumDigMSG = self::createMensajeError($errores, 'errorTelNumDig', 'span', array('class' => 'errorMSG'));
       

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
            $htmlErroresGlobales
            <label for="nombreInput">Nombre y apellidos</label>
            <input class="formInput" id="nombreInput" type="text" name="nombre" value="$nombre" placeholder="Nombre y Apellidos" required>
            <label for="dirInput">Dirección</label>
            <input class="formInput" id="dirInput" type="text" name="dir" value="$dir" placeholder="Dirección completa" required>
            <label for="telInput">Teléfono móvil $errorTelLetrasMSG $errorTelNumDigMSG</label>
            <input class="formInput" id="telInput" type="tel" name="tel" value="$tel" placeholder="Número de teléfono" required>
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
            $result["errorTelLetras"] = "El teléfono debe estar formado solo por números"; 
        }
        else{
            $numDigitsTel = (int) log10($datos["tel"]) +1;
            if($numDigitsTel != 9)
            {
                $result["errorTelNumDig"] = "El teléfono debe tener 9 números";
            }
        }


       

        if(count($result) != 0) //ha habido errores en algun campo
        {
            $result[] = "Error en los datos intoducidos. No se han cambiado los datos"; //mensaje de error global que se mostrara por encima del formulario
        }
        else{

            $u = Usuario::buscaUsuario($_SESSION["email"]);
            if(!$u){
                $result[] = "Error al procesar los datos"; 
            }
            else{
                $u->setNombre($datos["nombre"]);
                $u->setDir($datos["dir"]);
                $u->setTel($datos["tel"]);

                Usuario::guarda($u); //actualizamos con los datos nuevos
                $_SESSION["loged"] = true;
                $_SESSION["rol"] = $u->getRol();
                $_SESSION["nombre"] = $u->getNombre();
                $_SESSION["idUsuario"] = $u->getId();
                $result = 'perfil.php?page=perfil';//pagina a la que se redirige tras el login

                
            }
        }
        return $result;
    }
}