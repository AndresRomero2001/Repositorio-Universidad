<?php
namespace aw\proyecto\clases;

//require_once __DIR__.'/Form.php';
//require_once '/paso7/includes/Form.php';
//require_once __DIR__.'/Usuario.php';

class FormularioReserva extends Form
{
    public function __construct() {
        $opciones['action'] = "hacerReserva.php?page=hacerReserva";
        parent::__construct('formReserva', $opciones);
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $fecha =$datos['fecha'] ?? '';
        $hora =$datos['hora'] ?? '';
        $nPersonas =$datos['nPersonas'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorFechaMSG = self::createMensajeError($errores, 'fechaPasada', 'span', array('class' => 'errorMSG'));
        $errorTelLetrasMSG = self::createMensajeError($errores, 'errorTelLetras', 'span', array('class' => 'errorMSG'));
        $errorTelNumDigMSG = self::createMensajeError($errores, 'errorTelNumDig', 'span', array('class' => 'errorMSG'));
        $horasR=Reserva::horasReserva();
        $outH="";
        foreach ($horasR as &$horaR){
            $outH.=<<<EOF
            <option value="$horaR">$horaR</option>
            EOF;



        }
        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
       
            $htmlErroresGlobales
            <label for="fechaInput">Fecha $errorFechaMSG</label>
            <input class="formInput" id="fechaInput" type="date" name="fecha"  value="$fecha" required>
            <label for="horaInput"> Hora</label>
            <select class="formInput" id="horaInput" name="hora" >
            $outH
            </select>
            <label for="personasInput">¿Cuántas personas vais a venir?</label>
            <input class="formInput" id="personasInput" type="text" name="nPersonas" placeholder="nº Personas" value="$nPersonas" required>
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
        
        $stamp = strtotime($datos['fecha'] . ' ' . $datos['hora']);
        
        $daTime=date("Y-m-d H:i", $stamp);

        if(!Reserva::compruebaSitio($daTime,$datos['nPersonas'])){
            $result[] = "No hay disponibilidad para la hora indicada"; 

        }
        if($daTime<date("Y-m-d H:i")){
            $result['fechaPasada']="Seleccione una fecha futura";

        }

        if(count($result) != 0) //ha habido errores en algun campo
        {
            $result[] = "Error en los datos de la reserva"; //mensaje de error global que se mostrara por encima del formulario
        }
        else{
            $u = Reserva::crea($_SESSION['idUsuario'],$_POST["fecha"], $_POST["hora"], $_POST["nPersonas"]);
            $result = 'verReservas.php?page=verReservas';
        }
       
        return $result;
    }
}