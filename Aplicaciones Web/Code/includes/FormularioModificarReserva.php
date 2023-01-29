<?php
namespace aw\proyecto\clases;

class FormularioModificarReserva extends Form {

    public function __construct($id) {
        $opciones['action'] = "procesarModificarReserva.php?page=verReservas&id=$id";
        parent::__construct('formModificarReserva', $opciones);
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
       
        // Se reutilizan los valores que habia en los campos, en caso de haya habiado algun error y se haya
        //vuelto a generar el formulario
        $fecha =$datos['fecha'] ?? '';
        $hora =$datos['hora'] ?? '';
        $nPersonas =$datos['nPersonas'] ?? '';
        $id=$datos['id'] ??'';
        $idUsuario=$datos['idUsuario'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorFechaMSG = self::createMensajeError($errores, 'fechaPasada', 'span', array('class' => 'errorMSG'));
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
            <input class="formInput" id="fechaInput" type="date" name="fecha"  value=$fecha required>
            <label for="horaInput"> Hora</label>
            <select class="form-select formInput" id="horaInput" name="hora" required>
            $outH
            </select>
            <label for="personasInput">¿Cuántas personas vais a venir?</label>
            <input class="formInput" id="personasInput" type="text" name="nPersonas" placeholder="nº Personas" value="$nPersonas" required>
            <button type="submit" id="anadirReservaButton" class="campoFormulario buttonPropio formSubmitButton">Guardar reserva</button>

EOF;
        return $html;
    }

    protected function procesaFormulario($datos)
    {
        
        $fecha =$datos['fecha'];
        $hora =$datos['hora'];
        $nPersonas =$datos['nPersonas'];
        $id=$_GET['id'];
        //$idUsuario=$datos['idUsuario'];
        $stamp = strtotime($fecha . ' ' . $hora);
        $daTime=date("Y-m-d H:i", $stamp);

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
            $str=implode('\n',$result);
            $result = "verReservas.php?page=verReservas&fail=$str";
        }
        else{
            $int = intval($id);
            $u = Reserva::actualizarReserva($int,$daTime,$nPersonas);
            $result = 'verReservas.php?page=verReservas';
        }
       
        return $result;
    }
}
