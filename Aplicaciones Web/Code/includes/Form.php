<?php
namespace aw\proyecto\clases;
/**
 * Clase base para la gestión de formularios.
 *
 * Además de la gestión básica de los formularios.
 */
abstract class Form
{

    /**
     * @var string Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al formulario y 
     * como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     */
    private $formId;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará el 
     * envío del formulario.
     */
    private $action;

    /**
     * Crea un nuevo formulario.
     *
     * Posibles opciones:
     * <table>
     *   <thead>
     *     <tr>
     *       <th>Opción</th>
     *       <th>Valor por defecto</th>
     *       <th>Descripción</th>
     *     </tr>
     *   </thead>
     *   <tbody>
     *     <tr>
     *       <td>action</td>
     *       <td><code>$_SERVER['PHP_SELF']</code></td>       
     *       <td>URL asociada al atributo "action" de la etiqueta &lt;form&gt; del fomrulario y que procesará
     *            el envío del formulario.</td>
     *     </tr>
     *   </tbody>
     * </table>

     * @param string $formId    Cadena utilizada como valor del atributo "id" de la etiqueta &lt;form&gt; asociada al
     *                          formulario y como parámetro a comprobar para verificar que el usuario ha enviado el formulario.
     *
     * @param array $opciones (ver más arriba).
     */
    public function __construct($formId, $opciones = array() )
    {
        $this->formId = $formId;

        $opcionesPorDefecto = array( 'action' => null, );
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action   = $opciones['action'];
        
        if ( !$this->action ) {
            $this->action = htmlentities($_SERVER['PHP_SELF']);
        }
    }

    /**
     * Genera la lista de mensajes de errores globales (no asociada a un campo) a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string $classAtt (opcional) Valor del atributo class de la lista de errores.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    protected static function generaListaErroresGlobales($errores = array(), $classAtt = '')
    {
        $clavesErroresGlobales = array_filter(array_keys($errores), function ($elem) {
            return is_numeric($elem);
        });

        $numErrores = count($clavesErroresGlobales);
        if ($numErrores == 0) {
            return '';
        }

        $html = "<ul class=\"$classAtt\">";
        foreach ($clavesErroresGlobales as $clave) {
            $html .= "<li>$errores[$clave]</li>";
        }
        $html .= '</ul>';

        return $html;
    }

    /**
     * Crea una etiqueta para mostrar un mensaje de error. Sólo creará el mensaje de error
     * si existe una clave <code>$idError</code> dentro del array <code>$errores</code>.
     * 
     * @param string[] $errores     (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     * @param string   $idError     (opcional) Clave dentro de <code>$errores</code> del error a mostrar.
     * @param string   $htmlElement (opcional) Etiqueta HTML a crear para mostrar el error.
     * @param array    $atts        (opcional) Tabla asociativa con los atributos a añadir a la etiqueta que mostrará el error.
     */
    protected static function createMensajeError($errores = [], $idError = '', $htmlElement = 'span', $atts = [])
    {
        if (! isset($errores[$idError])) {
            return '';
        }

        $att = '';
        foreach ($atts as $key => $value) {
            $att .= "$key=\"$value\" ";
        }
        $html = "<$htmlElement $att>{$errores[$idError]}</$htmlElement>";

        return $html;
    }

  
    /**
     * Se encarga de orquestar todo el proceso de gestión de un formulario.
     * Se la invoca en la pagina que muestra el formulario, de forma que si se acaba de cargar (no esta el parametro action en el post)
     * simplemente generara el formulario correspondiente (el de la clase concreta que extienda a Form). 
     * Los action de los formularios deben tener como destino su propia direccion, de forma que se vuelve a llamar a gestiona, pero
     * esta vez con parametro action en el post, de forma que se llamara a la funcion procesaFormulario propia de cada clase que
     * extienda a Form.
     * 
     * Si al procesar el formulario va bien se redirige a la pagina con direccion $result
     * Si ocurre algun error, se vuelve a llamar a genera formulario padandole en $result un array con los mensajes de error y en $_POST
     * un array con los datos que habia introducido el usuario para que el formulario no aparezca vacio y salga con los datos que habia
     * introducido previamente el usuario
     * @param $primerosDatos Parametro opcional con los datos a mostrar la primera vez que se muestra el formulario
     */
    public function gestiona($primerosDatos = array())
    {   
        if ( ! $this->formularioEnviado($_POST) ) {
            
            return $this->generaFormulario(array(), $primerosDatos);//para por ejemplo formularioPerfil cuyo formulario comienza ya con los datos del usaurio actual
        } else {
            $result = $this->procesaFormulario($_POST);
            if ( is_array($result) ) {
                return $this->generaFormulario($result, $_POST);
            } else {
                header('Location: '.$result);
                exit();
            }
        }  
    }

    /**
     * Genera el HTML necesario para presentar los campos del formulario.
     *
     * @param string[] $datosIniciales Datos iniciales para los campos del formulario (normalmente <code>$_POST</code>).
     * 
     * @return string HTML asociado a los campos del formulario.
     */
    protected function generaCamposFormulario($datosIniciales)
    {
        return '';
    }

    /**
     * Procesa los datos del formulario.
     *
     * @param string[] $datos Datos enviado por el usuario (normalmente <code>$_POST</code>).
     *
     * @return string|string[] Devuelve el resultado del procesamiento del formulario, normalmente una URL a la que
     * se desea que se redirija al usuario, o un array con los errores que ha habido durante el procesamiento del formulario.
     */
    protected function procesaFormulario($datos)
    {
        return array();
    }
  
    /**
     * Función que verifica si el usuario ha enviado el formulario.
     * Comprueba si existe el parámetro <code>$formId</code> en <code>$params</code>.
     *
     * @param string[] $params Array que contiene los datos recibidos en el envío formulario.
     *
     * @return boolean Devuelve <code>true</code> si <code>$formId</code> existe como clave en <code>$params</code>
     */
    private function formularioEnviado(&$params)
    {
        return isset($params['action']) && $params['action'] == $this->formId;
    } 

    /**
     * Función que genera el HTML necesario para el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @param string[] $datos (opcional) Array con los valores por defecto de los campos del formulario.
     *
     * @return string HTML asociado al formulario.
     */
    private function generaFormulario($errores = array(), &$datos = array())
    {
        $html = "";
      //  $html= $this->generaListaErrores($errores); //el mostrar los errores se gestionan ahora desde las subclases para mas personalizacion

        $html .= '<form method="POST" action="'.$this->action.'" id="'.$this->formId.'" enctype="multipart/form-data" >';
        $html .= '<input type="hidden" name="action" value="'.$this->formId.'" />';

        $html .= $this->generaCamposFormulario($datos, $errores);
        $html .= '</form>';
        return $html;
    }

    /**
     * Genera la lista de mensajes de error a incluir en el formulario.
     *
     * @param string[] $errores (opcional) Array con los mensajes de error de validación y/o procesamiento del formulario.
     *
     * @return string El HTML asociado a los mensajes de error.
     */
    private function generaListaErrores($errores)
    {
        $html='';
        $numErrores = count($errores);
        if (  $numErrores == 1 ) {
            $html .= "<ul><li>".$errores[0]."</li></ul>";
        } else if ( $numErrores > 1 ) {
            $html .= "<ul><li>";
            $html .= implode("</li><li>", $errores);
            $html .= "</li></ul>";
        }
        return $html;
    }
}
