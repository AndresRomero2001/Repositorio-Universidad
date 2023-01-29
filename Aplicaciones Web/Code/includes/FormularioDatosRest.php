<?php
namespace aw\proyecto\clases;

//require_once __DIR__.'/Form.php';
//require_once '/paso7/includes/Form.php';
//require_once __DIR__.'/Usuario.php';

class FormulariodatosRest extends Form
{
    public function __construct() {
        $opciones['action'] = "configuracionRestaurante.php?page=configuracionRestaurante";
        parent::__construct('formDatosRest', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $maxPers =$datos['maxPers'] ?? '';
        $email =$datos['email'] ?? '';
        $contra =$datos['contra'] ?? '';
        $dir =$datos['dir'] ?? '';
        $tel =$datos['tel'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorEmailMSG = self::createMensajeError($errores, 'errorEmail', 'span', array('class' => 'errorMSG'));
        $errorTelLetrasMSG = self::createMensajeError($errores, 'errorTelLetras', 'span', array('class' => 'errorMSG'));
        $errorTelNumDigMSG = self::createMensajeError($errores, 'errorTelNumDig', 'span', array('class' => 'errorMSG'));
       

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
            $htmlErroresGlobales
            <label for="maxPers">Número máximo de personas con reserva por hora: </label>
            <input class="formInput-XS" id="maxPers" type="number" name="maxPers" value="$maxPers">
            <button class="botonesFormConfRes" type="submit"> Enviar </button>

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

        if($datos["maxPers"] < 0)
        {
            $result[] = "Error: El n�mero no puede ser negativo";
        }
        else{

            $app = Aplicacion::getInstancia();
            $conn = $app->conexionBd();
            $query=sprintf("UPDATE restaurante r SET capacidad = '%d'WHERE r.id=%d"
                , $conn->real_escape_string($datos["maxPers"])
                , 1);

            if (! $conn->query($query))
            {
                $result[] = "Error al actualizar los datos";
            }
            else{
                $result = 'configuracionRestaurante.php?page=configuracionRestaurante';
            }
        }

        return $result;


    }
}